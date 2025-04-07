<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Activity;


class centralController extends Controller
{
    //
    public function overview()
    {
        $categoryCount = Category::count();
        // เดิม
        $activityCount = Activity::count();

        // ใหม่ (เฉพาะ approved)
        //$activityCount = Activity::where('status', 'approved')->count();


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

            if ($cat->activities_count > 0) {
                $rate = ($cat->approved_activities_count / $cat->activities_count) * 100;
            } else {
                $rate = 0;
            }

            $successRates[] = round($rate, 2);
        }



        return view('central.overview', compact(
            'categoryCount',
            'activityCount',
            'labels',
            'successRates',
            'activityCounts'
        )); // ให้มั่นใจว่ามีไฟล์ central/overview.blade.php
    }
}
