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

        $query = Activity::where('status', 'Sent')
            ->whereHas('creator', fn($q) => $q->where('province', $provinceId))
            ->with(['creator', 'category']);

        if ($yearId) {
            $query->whereHas('category', fn($q) => $q->where('cat_year_id', $yearId));
        }

        $activities = $query->get();

        $data = $activities->map(function ($a) {
            return [
                'fullname' => $a->creator->user_fullname ?? '-',
                'category' => $a->category->cat_name ?? '-',
                'title' => $a->act_title ?? '-', // <- ใช้ act_title เพราะ title เป็น null
                'date' => $a->created_at ? \Carbon\Carbon::parse($a->created_at)->format('d/m/Y') : '-',
            ];
        });

        return response()->json(['data' => $data]);
    }
}