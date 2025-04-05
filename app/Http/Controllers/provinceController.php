<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\Provinces;
use App\Models\User;

class ProvinceController extends Controller
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
        $activities = Activity::where('status', 'Sent')
            ->whereHas('creator', fn($q) => $q->where('province', $provinceId))
            ->whereHas('category', fn($q) => $q->where('cat_year_id', $selectedYearId))
            ->with(['creator', 'category'])
            ->get();

        // $activities = Activity::where('status', 'Sent')
        //     ->whereHas('creator', fn($q) => $q->where('province', $provinceId))
        //     ->whereHas('category', fn($q) => $q->where('cat_year_id', $selectedYearId))
        //     ->with(['creator', 'category'])
        //     ->get();

        $groupedActivities = $activities
            ->groupBy(fn($activity) => $activity->creator->user_fullname)
            ->sortKeys();

        $years = \App\Models\Year::orderByDesc('year_name')->get();
        $userCount = $groupedActivities->count();
        $activityCount = $activities->count();

        return view('province.considerEvent', compact(
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
}
