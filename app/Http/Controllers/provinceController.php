<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\Provinces;
use App\Models\User;

class provinceController extends Controller
{
    public function overview()
    {
        $categoryCount = Category::count();
        $activityCount = Activity::count(); // รวมทั้งหมด

        $categories = Category::withCount([
            'activities',
            'activities as approved_activities_count' => function ($q) {
                $q->where('status', 'approved');
            }
        ])->get();

        $labels = [];
        $successRates = [];
        $activityCounts = [];

        foreach ($categories as $cat) {
            $labels[] = $cat->cat_name;
            $activityCounts[] = $cat->activities_count;
            $rate = ($cat->activities_count > 0)
                ? ($cat->approved_activities_count / $cat->activities_count) * 100
                : 0;
            $successRates[] = round($rate, 2);
        }

        return view('province.overview', compact(
            'categoryCount',
            'activityCount',
            'labels',
            'successRates',
            'activityCounts'
        ));
    }
    public function reviewList(Request $request)
    {
        $latestYear = \App\Models\Year::orderByDesc('year_name')->first();
        $selectedYearId = $request->input('year_id', $latestYear->year_id);
        $provinceId = auth()->user()->province;
        $activities = Activity::where('status', ['Sent', 'Edit', 'Approve_by_province'])
            ->whereHas('creator', fn($q) => $q->where('province', $provinceId))
            ->whereHas('category', fn($q) => $q->where('cat_year_id', $selectedYearId))
            ->with(['creator', 'category'])
            ->get();

        $groupedActivities = $activities
            ->groupBy(fn($activity) => $activity->creator->user_fullname)
            ->sortKeys();

        $years = \App\Models\Year::orderByDesc('year_name')->get();
        $userCount = $groupedActivities->count();
        $activityCount = $activities->count();

        return view('province.approve_activity_index', compact(
            'groupedActivities',
            'years',
            'selectedYearId',
            'userCount',
            'activityCount',
            'activities'
        ));
    }

    public function report(Request $request)
    {
        $latestYear = \App\Models\Year::orderByDesc('year_name')->first();
        $selectedYearId = $request->input('year_id', $latestYear->year_id);
        $provinceId = auth()->user()->province;

        $activities = Activity::where('status', 'Sent')
            ->whereHas('creator', fn($q) => $q->where('province', $provinceId))
            ->whereHas('category', fn($q) => $q->where('cat_year_id', $selectedYearId))
            ->with(['creator', 'category'])
            ->get();
        $activities = Activity::where('status', 'Approve_by_central')
            ->whereHas('creator', fn($q) => $q->where('province', $provinceId))
            ->whereHas('category', fn($q) => $q->where('cat_year_id', $selectedYearId))
            ->with(['creator', 'category'])
            ->get();

        $groupedActivities = $activities
            ->groupBy(fn($activity) => $activity->creator->user_fullname)
            ->sortKeys();

        $years = \App\Models\Year::orderByDesc('year_name')->get();
        $userCount = $groupedActivities->count();
        $activityCount = $activities->count();

        return view('province.report', compact(
            'groupedActivities',
            'years',
            'selectedYearId',
            'userCount',
            'activityCount'
        ));
    }

    public function activityData(Request $request)
    {
        $provinceId = auth()->user()->province;
        $yearId = $request->input('year_id');

        // ดึงกิจกรรมที่ตรงกับจังหวัดและสถานะ sent
        $query = Activity::where('status', 'Sent')
            ->whereHas('creator', function ($q) use ($provinceId) {
                $q->where('province', $provinceId);
            })
            ->with(['creator.provinceData', 'category']);
        $activities = Activity::where('status', 'Approve_by_central')
            ->whereHas('creator', fn($q) => $q->where('province', $provinceId))
            ->whereHas('category', fn($q) => $q->where('cat_year_id', $selectedYearId))
            ->with(['creator', 'category'])
            ->get();

        // กรองปีจาก category
        if ($yearId) {
            $query->whereHas('category', function ($q) use ($yearId) {
                $q->where('cat_year_id', $yearId);
            });
        }

        $activities = $query->get();

        // ✅ Group by ผู้สร้าง ไม่ซ้ำ
        $grouped = $activities->groupBy(function ($a) {
            return $a->creator->user_fullname;
        });

        $data = $grouped->map(function ($group) {
            $first = $group->first();
            return [
                'fullname' => $first->creator->user_fullname,
                'province' => $first->creator->provinceData->pvc_name ?? '-',
                'activity_id' => $first->activity_id,
            ];
        })->values();

        return response()->json([
            'data' => $data,
            'userCount' => $data->count(),
            'activityCount' => $activities->count(),
        ]);
    }

    public function considerData(Request $request)
    {
        $yearId = $request->input('year_id');
        $provinceId = auth()->user()->province;

        $activities = Activity::where('status', 'Sent')
            ->whereHas('creator', fn($q) => $q->where('province', $provinceId))
            ->whereHas('category', fn($q) => $q->where('cat_year_id', $yearId))
            ->with(['creator', 'category'])
            ->get();

        $groupedActivities = $activities->groupBy(fn($a) => $a->creator->user_fullname);

        $html = view('partials._consider_table_body', compact('groupedActivities'))->render();

        return response()->json(['html' => $html]);
    }

    public function showCategoryToSelect(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $selectedYearId = $request->input('year_id');

        $categories = \App\Models\Category::where('cat_year_id', $selectedYearId)
            ->whereHas('activities', function ($query) use ($user) {
                $query->where('act_submit_by', $user->user_id)
                      ->where('status', 'Sent');
            })
            ->get();

        return view('province.approve_activity_category', compact('user', 'categories', 'selectedYearId'));
    }
    public function approveActivity(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $selectedYearId = $request->input('year_id');

    // อัปเดตเฉพาะกิจกรรมของผู้ใช้นี้ในปีที่เลือก และมีสถานะ Sent
    Activity::where('act_submit_by', $user->user_id)
        ->where('status', 'Sent')
        ->whereHas('category', function ($query) use ($selectedYearId) {
            $query->where('cat_year_id', $selectedYearId);
        })
        ->update(['status' => 'Approve_by_province']);

        return redirect()->route('province.index')->with('success', 'กิจกรรมของผู้ใช้นี้ถูกส่งกลับเรียบร้อยแล้ว');
    }
    public function rejectActivity(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $selectedYearId = $request->input('year_id');

    // อัปเดตเฉพาะกิจกรรมของผู้ใช้นี้ในปีที่เลือก และมีสถานะ Sent
    Activity::where('act_submit_by', $user->user_id)
        ->where('status', 'Sent')
        ->whereHas('category', function ($query) use ($selectedYearId) {
            $query->where('cat_year_id', $selectedYearId);
        })
        ->update(['status' => 'Edit']);

        return redirect()->route('province.index')->with('success', 'กิจกรรมของผู้ใช้นี้ถูกส่งกลับเรียบร้อยแล้ว');
    }

    public function showActivities($id, $cat_id)
    {
        $user = \App\Models\User::findOrFail($id);
        $category = \App\Models\Category::findOrFail($cat_id);

        $activities = \App\Models\Activity::where('act_submit_by', $user->user_id)
            ->where('act_cat_id', $cat_id)
            ->where('status', 'Sent')
            ->with(['creator', 'category'])
            ->get();

        return view('province.approve_activity_activity', compact('user', 'activities', 'category'));
    }
    public function showActivityDetail($id, $cat_id, $act_id)
    {
        $user = \App\Models\User::findOrFail($id);
        $category = \App\Models\Category::findOrFail($cat_id);
        $activity = \App\Models\Activity::findOrFail($act_id);

        return view('province.approve_activity_activity_detail', compact('user', 'activity', 'category'));
    }

    public function storeComment(Request $request, $activityId)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        \App\Models\Approval::create([
            'apv_act_id' => $activityId,
            'apv_approver' => auth()->id(),
            'apv_level' => auth()->user()->user_role,
            'apv_comment' => $request->input('comment'),
            'apv_date' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'บันทึกความคิดเห็นเรียบร้อยแล้ว']);
    }
    public function showUnapprovedActivities(Request $request)
    {
        $latestYear = \App\Models\Year::orderByDesc('year_name')->first();
        $selectedYearId = $request->input('year_id', $latestYear->year_id);
        $provinceId = auth()->user()->province;
        $activities = Activity::where('status', 'Unapproved_by_central')
            ->whereHas('creator', fn($q) => $q->where('province', $provinceId))
            ->whereHas('category', fn($q) => $q->where('cat_year_id', $selectedYearId))
            ->with(['creator', 'category'])
            ->get();

        $groupedActivities = $activities
            ->groupBy(fn($activity) => $activity->creator->user_fullname)
            ->sortKeys();

        $years = \App\Models\Year::orderByDesc('year_name')->get();
        $userCount = $groupedActivities->count();
        $activityCount = $activities->count();

        return view('province.unapprove_activity', compact(
            'groupedActivities',
            'years',
            'selectedYearId',
            'userCount',
            'activityCount',
            'activities'
        ));
    }
    public function rejectAllInProvince(Request $request)
    {
        $provinceId = auth()->user()->province;

        // อัปเดตเฉพาะกิจกรรมที่สถานะ Sent และผู้สร้างอยู่ในจังหวัดเดียวกัน
        Activity::where('status', 'Unapproved_by_central')
            ->whereHas('creator', function ($q) use ($provinceId) {
                $q->where('province', $provinceId);
            })
            ->update(['status' => 'Edit']);

        return redirect()->route('province.unapprove')->with('success', 'กิจกรรมของทุกคนในจังหวัดถูกส่งกลับเรียบร้อยแล้ว');
    }
    public function unapproveByCentral(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

        // Update all 'Sent' activities of the user to 'Edit'
        Activity::where('act_submit_by', $user->user_id)
            ->where('status', 'Unapproved_by_central')
            ->update(['status' => 'Edit']);

        return redirect()->route('province.unapprove')->with('success', 'กิจกรรมของผู้ใช้นี้ถูกส่งกลับเรียบร้อยแล้ว');
    }
}
