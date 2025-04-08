<?php

namespace App\Http\Controllers;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Activity;
use Carbon\Carbon;

class HomeController extends Controller
{

    public function overview()
    {
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            return redirect()->route('logined')->with('error', 'กรุณาเข้าสู่ระบบก่อน');
        }
        $user = Auth::user();


        if ($user->hasRole('Central Officer')) {
            $years = Category::with('year')
            ->select('cat_year_id')
            ->distinct()
            ->get()
            ->pluck('year.year_name');
            $expiration_date = Category::value('expiration_date');
            $category_due_date = $expiration_date
                ? Carbon::parse($expiration_date)->subDays(15)->format('Y-m-d')
                : null;

            $categoryCount = Category::count();
            $activityCount = Activity::count();

            $categories = Category::withCount([
                'activities as approved_activities_count' => function ($q) {
                    $q->where('status', 'Approve_by_central');
                },
                'activities as unapproved_activities_count' => function ($q) {
                    $q->whereNot('status', 'Approve_by_central');
                },
            ])->get();

            $labels = $categories->pluck('cat_name');
            $approvedCounts = $categories->pluck('approved_activities_count');
            $unapprovedCounts = $categories->pluck('unapproved_activities_count');

            return view('central.overview', compact(
                'labels',
                'approvedCounts',
                'unapprovedCounts',
                'categoryCount',
                'activityCount',
                'category_due_date',
                'years'
            ));
        } elseif ($user->hasRole('Province Officer')) {

            $categories = Category::where('status', 'published')->get();
            $categoryCount = Category::count();
            // เดิม
            $activityCount = Activity::count();


            return view('province.overview', compact('categoryCount', 'activityCount', 'categories'));
        }
        elseif ($user->hasRole('Volunteer')) {



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
