<?php

namespace App\Http\Controllers;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Activity;

class HomeController extends Controller
{

    public function overview()
    {
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            return redirect('/login')->with('error', 'กรุณาเข้าสู่ระบบก่อน');
        }
        $user = Auth::user();


        if ($user->hasRole('Central Officer')) {

            // ใช้ count ของ Category
            $categoryCount = Category::count();

            // การคำนวณจำนวน Activity ทั้งหมด (เฉพาะสถานะ approved)
            $activityCount = Activity::whereIn('status', ['Approve_by_central', 'Approve_by_province'])->count();

            // ดึงข้อมูล Categories พร้อมจำนวน Activity ที่ได้รับการอนุมัติ
            $categories = Category::withCount([
                'activities',
                'activities as approved_activities_count' => function ($q) {
                    $q->where('status', 'Approve_by_central'); // หรือสถานะอื่นที่ต้องการ
                }
            ])->get();

            $labels = [];
            $successRates = [];
            $activityCounts = [];

            foreach ($categories as $cat) {
                $labels[] = $cat->cat_name;  // ชื่อ Category
                $activityCounts[] = $cat->activities_count; // จำนวน Activities ทั้งหมด

                if ($cat->activities_count > 0) {
                    // คำนวณอัตราความสำเร็จ (approved)
                    $rate = ($cat->approved_activities_count / $cat->activities_count) * 100;
                } else {
                    $rate = 0;
                }

                $successRates[] = round($rate, 2); // เก็บอัตราความสำเร็จที่ได้
            }

            // ส่งค่าผ่าน view
            return view('central.overview', compact(
                'categoryCount',
                'activityCount',
                'labels',
                'successRates',
                'activityCounts'
            ));
        } elseif ($user->hasRole('Province Officer')) {

            $categories = Category::where('status', 'published')->get();
            $categoryCount = Category::count();
            // เดิม
            $activityCount = Activity::count();


            return view('province.overview', compact('categoryCount', 'activityCount', 'categories'));
        } elseif ($user->hasRole('Volunteer')) {



            // ดึงหมวดหมู่ที่เผยแพร่แล้ว
            $categories = Category::where('status', 'published')->get();

            // นับหมวดหมู่ทั้งหมดที่ User3 สามารถเข้าถึง
            $categoryCount = $categories->count();

            // นับกิจกรรมที่ทำสำเร็จ
            $completedCategories = Activity::where('act_submit_by', 1)
                ->whereIn('status', ['Saved', 'Edit', 'Sent', 'Approve_by_province', 'Approve_by_central'])
                ->distinct('act_cat_id')
                ->count('act_cat_id');

            // ดึง ID หมวดหมู่ที่ทำกิจกรรมสำเร็จ
            $completedCategoryIds = Activity::where('act_submit_by', 1)
                ->whereIn('status', ['Saved', 'Sent', 'Approve_by_province', 'Approve_by_central'])
                ->pluck('act_cat_id')
                ->toArray();


            return view('volunteer.overview', compact('categoryCount', 'completedCategories', 'completedCategoryIds', 'categories'));
        } else {
            return view('errors.404');
        }
    }

    public function error404()
    {
        return view('errors.404');
    }

    public function error500()
    {
        return view('errors.500');
    }
}
