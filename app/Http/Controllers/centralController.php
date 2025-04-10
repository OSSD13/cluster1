<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Activity;
use Illuminate\Http\Request;

class centralController extends Controller
{
    //
    public function reportIndex(Request $request)
    {
        $years = \App\Models\Year::orderByDesc('year_name')->get();
        $latestYear = \App\Models\Year::orderByDesc('year_name')->first();
        $selectedYearId = $request->input('year_id', $latestYear->year_id);
        $selectedProvinceId = $request->input('province_id');

        $provinces = \App\Models\Provinces::whereHas('users.activities', function ($query) use ($selectedYearId) {
            $query->where('status', 'Approve_by_central')
                ->whereHas('category', fn($q) => $q->where('cat_year_id', $selectedYearId));
        })->get();
        $provinceIds = $provinces->pluck('pvc_id');

        $activities = Activity::where('status', 'Approve_by_central')
            ->when($selectedProvinceId, function ($query) use ($selectedProvinceId) {
                return $query->whereHas('creator', fn($q) => $q->where('province', $selectedProvinceId));
            }, function ($query) use ($provinces) {
                return $query->whereHas('creator', fn($q) => $q->whereIn('province', $provinces->pluck('pvc_id')));
            })
            ->whereHas('category', fn($q) => $q->where('cat_year_id', $selectedYearId))
            ->get();

        $userCount = $activities->count();
        $activityCount = $activities->count();

        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));
            $provinces = $provinces->filter(function ($province) use ($search) {
                return str_contains(strtolower($province->pvc_name), $search);
            });
        }

        return view('central.report_index', compact(
            'years',
            'selectedYearId',
            'provinces',
            'selectedProvinceId',
            'userCount',
            'activityCount'
        ));
    }

    public function report(Request $request, $id)
    {
        $latestYear = \App\Models\Year::orderByDesc('year_name')->first();
        $selectedYearId = $request->input('year_id', $latestYear->year_id);
        $province = \App\Models\Provinces::find($id);
        $provinceName = $province ? $province->pvc_name : '-';
        $provinceId = $province ? $province->pvc_id : null;

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

        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));
            $activities = $activities->filter(function ($activity) use ($search) {
                return str_contains(strtolower($activity->creator->user_fullname), $search);
            });
        }

        return view('central.report', compact(
            'groupedActivities',
            'years',
            'selectedYearId',
            'userCount',
            'activityCount',
            'provinceId',
            'provinceName',
        ));
    }

    public function provinceData(Request $request)
    {
        $yearId = $request->input('year_id');
        $index = 0;

        // ดึงเฉพาะจังหวัดที่มี user และ user เหล่านั้นมี activity ที่ผ่านสถานะ Approve_by_central
        $provinces = \App\Models\Provinces::whereHas('users.activities', function ($query) use ($yearId) {
            $query->where('status', 'Approve_by_central')
                ->whereHas('category', fn($q) => $q->where('cat_year_id', $yearId));
        })->get();

        $provinceIds = $provinces->pluck('pvc_id');

        $activities = Activity::where('status', 'Approve_by_central')
            ->whereHas('creator', fn($q) => $q->whereIn('province', $provinceIds))
            ->whereHas('category', fn($q) => $q->where('cat_year_id', $yearId))
            ->with(['creator.provinceData', 'category'])
            ->get();

        $data = $activities->groupBy(function ($a) {
            return $a->creator->provinceData->pvc_name ?? 'ไม่ทราบจังหวัด';
        })->map(function ($group, $provinceName) use (&$index) {
            return [
                'index' => ++$index,
                'province' => $provinceName,
            ];
        })->values();

        return response()->json([
            'data' => $data
        ]);
    }
    public function activityData(Request $request, $id)
    {
        $provinceId = $id;
        $yearId = $request->input('year_id');

        // ดึงกิจกรรมที่ตรงกับจังหวัดและสถานะ sent
        $query = Activity::where('status', 'Sent')
            ->whereHas('creator', function ($q) use ($provinceId) {
                $q->where('province', $provinceId);
            })
            ->with(['creator.provinceData', 'category']);

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
    public function approveIndex(Request $request)
    {
        $years = \App\Models\Year::orderByDesc('year_name')->get();
        $latestYear = \App\Models\Year::orderByDesc('year_name')->first();
        $selectedYearId = $request->input('year_id', $latestYear->year_id);
        $selectedProvinceId = $request->input('province_id');

        $provinces = \App\Models\Provinces::whereHas('users.activities', function ($query) use ($selectedYearId) {
            $query->where('status', 'Approve_by_province')
                ->whereHas('category', fn($q) => $q->where('cat_year_id', $selectedYearId));
        })->get();
        $provinceIds = $provinces->pluck('pvc_id');

        $activities = Activity::where('status', 'Approve_by_province')
            ->when($selectedProvinceId, function ($query) use ($selectedProvinceId) {
                return $query->whereHas('creator', fn($q) => $q->where('province', $selectedProvinceId));
            }, function ($query) use ($provinces) {
                return $query->whereHas('creator', fn($q) => $q->whereIn('province', $provinces->pluck('pvc_id')));
            })
            ->whereHas('category', fn($q) => $q->where('cat_year_id', $selectedYearId))
            ->get();

        $userCount = $activities->count();
        $activityCount = $activities->count();
        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));
            $provinces = $provinces->filter(function ($province) use ($search) {
                return str_contains(strtolower($province->pvc_name), $search);
            });
        }

        return view('central.approve_index', compact(
            'years',
            'selectedYearId',
            'provinces',
            'selectedProvinceId',
            'userCount',
            'activityCount'
        ));
    }
    public function approveIndexData(Request $request)
    {
        $yearId = $request->input('year_id');
        $index = 0;

        // ดึงเฉพาะจังหวัดที่มี user และ user เหล่านั้นมี activity ที่ผ่านสถานะ Approve_by_central
        $provinces = \App\Models\Provinces::whereHas('users.activities', function ($query) use ($yearId) {
            $query->where('status', 'Approve_by_central')
                ->whereHas('category', fn($q) => $q->where('cat_year_id', $yearId));
        })->get();

        $provinceIds = $provinces->pluck('pvc_id');

        $activities = Activity::where('status', 'Approve_by_central')
            ->whereHas('creator', fn($q) => $q->whereIn('province', $provinceIds))
            ->whereHas('category', fn($q) => $q->where('cat_year_id', $yearId))
            ->with(['creator.provinceData', 'category'])
            ->get();

        $data = $activities->groupBy(function ($a) {
            return $a->creator->provinceData->pvc_name ?? 'ไม่ทราบจังหวัด';
        })->map(function ($group, $provinceName) use (&$index) {
            return [
                'index' => ++$index,
                'province' => $provinceName,
            ];
        })->values();

        return response()->json([
            'data' => $data
        ]);
    }

    public function selectVolunteer(Request $request, $pvc_id)
    {
        $latestYear = \App\Models\Year::orderByDesc('year_name')->first();
        $selectedYearId = $request->input('year_id', $latestYear->year_id);
        $provinceID = \App\Models\Provinces::find($pvc_id)->pvc_id;
        $provinceName = \App\Models\Provinces::find($pvc_id)->pvc_name;
        $activities = Activity::where('status', ['Approve_by_province', 'Approve_by_central'])
            ->whereHas('creator', fn($q) => $q->where('province', $provinceID))
            ->whereHas('category', fn($q) => $q->where('cat_year_id', $selectedYearId))
            ->with(['creator', 'category'])
            ->get();

        $groupedActivities = $activities
            ->groupBy(fn($activity) => $activity->creator->user_fullname)
            ->sortKeys();

        $years = \App\Models\Year::orderByDesc('year_name')->get();
        $userCount = $groupedActivities->count();
        $activityCount = $activities->count();
        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));
            $activities = $activities->filter(function ($activity) use ($search) {
                return str_contains(strtolower($activity->creator->user_fullname), $search);
            });
        }

        return view('central.approve_activity_index', compact(
            'groupedActivities',
            'years',
            'selectedYearId',
            'userCount',
            'activityCount',
            'activities',
            'provinceID',
            'provinceName'
        ));
    }

    public function showCategoryToSelect(Request $request, $id)
    {
        $provinceID = $request->input('pvc_id');
        $user = \App\Models\User::findOrFail($id);
        $selectedYearId = $request->input('year_id');

        $categories = \App\Models\Category::where('cat_year_id', $selectedYearId)
            ->whereHas('activities', function ($query) use ($user) {
                $query->where('act_submit_by', $user->user_id)
                    ->where('status', 'Approve_by_province');
            })
            ->get();

        return view('central.approve_activity_category', compact('user', 'categories', 'selectedYearId', 'provinceID'));
    }
    public function approveActivity(Request $request, $id)
    {
        $provinceId = $request->input('pvc_id');
        $user = \App\Models\User::findOrFail($id);
        $selectedYearId = $request->input('year_id');

        \App\Models\Activity::where('act_submit_by', $user->user_id)
            ->where('status', 'Approve_by_province')
            ->whereHas('category', function ($query) use ($selectedYearId) {
                $query->where('cat_year_id', $selectedYearId);
            })
            ->update(['status' => 'Approve_by_central']);

        return redirect()->route('central.province.index', ['pvc_id' => $provinceId])
            ->with('success', 'กิจกรรมของผู้ใช้นี้ถูกส่งเรียบร้อยแล้ว');
    }
    public function rejectActivity(Request $request, $id)
    {
        $provinceId = $request->input('pvc_id');
        $user = \App\Models\User::findOrFail($id);
        $selectedYearId = $request->input('year_id');

        \App\Models\Activity::where('act_submit_by', $user->user_id)
            ->where('status', 'Approve_by_province')
            ->whereHas('category', function ($query) use ($selectedYearId) {
                $query->where('cat_year_id', $selectedYearId);
            })
            ->update(['status' => 'Unapproved_by_central']);

        return redirect()->route('central.province.index', ['pvc_id' => $provinceId]);
    }

    public function selectActivities($id, $cat_id)
    {
        $user = \App\Models\User::findOrFail($id);
        $category = \App\Models\Category::findOrFail($cat_id);

        $activities = \App\Models\Activity::where('act_submit_by', $user->user_id)
            ->where('act_cat_id', $cat_id)
            ->where('status', 'Approve_by_province')
            ->with(['creator', 'category'])
            ->get();

        return view('central.approve_activity_activity', compact('user', 'activities', 'category'));
    }
    public function showActivityDetail($id, $cat_id, $act_id)
    {
        $user = \App\Models\User::findOrFail($id);
        $category = \App\Models\Category::findOrFail($cat_id);
        $activity = \App\Models\Activity::findOrFail($act_id);

        return view('central.approve_activity_activity_detail', compact('user', 'activity', 'category'));
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
    public function considerData(Request $request, $pvc_id)
    {

        $yearId = $request->input('year_id');
        $provinceId = \App\Models\Provinces::find($pvc_id)->pvc_id;

        $activities = Activity::where('status', 'Approve_by_province')
            ->whereHas('creator', fn($q) => $q->where('province', $provinceId))
            ->whereHas('category', fn($q) => $q->where('cat_year_id', $yearId))
            ->with(['creator', 'category'])
            ->get();

        $groupedActivities = $activities->groupBy(fn($a) => $a->creator->user_fullname);

        $html = view('partials._consider_table_body', compact('groupedActivities'))->render();

        return response()->json(['html' => $html]);
    }
}
