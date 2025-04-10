<?php

namespace App\Http\Controllers;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Activity;
use Carbon\Carbon;
use App\Models\Year;
use PHPUnit\Framework\Constraint\Count;

class HomeController extends Controller
{

    public function overview(Request $request)
    {
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            return redirect()->route('logined')->with('error', 'กรุณาเข้าสู่ระบบก่อน');
        }
        $user = Auth::user();


        if ($user->hasRole('Central Officer')) {
            $years = \App\Models\Year::orderByDesc('year_name')->get();
            $latestYear = \App\Models\Year::orderByDesc('year_name')->first();
            $selectedYearId = $request->input('year_id', $latestYear->year_id);
            $expiration_date = Category::value('expiration_date');
            $category_due_date = $expiration_date
                ? Carbon::parse($expiration_date)->subDays(15)->format('Y-m-d')
                : null;

            $categoryCount = Category::where('cat_year_id', $selectedYearId)->count();
            $activityCount = Activity::whereHas('category', fn($q) => $q->where('cat_year_id', $selectedYearId))->count();

            $categories = Category::where('status', 'published')
                ->where('cat_year_id', $selectedYearId)
                ->withCount([
                    'activities as approved_activities_count' => function ($q) {
                        $q->where('status', 'Approve_by_central');
                    },
                    'activities as unapproved_activities_count' => function ($q) {
                        $q->whereNot('status', 'Approve_by_central');
                    },
                    'activities as activities_count' => function ($q) {
                        $q->selectRaw('count(*)');
                    },
                ])->get();

            $labels = $categories->pluck('cat_name');
            $approvedCounts = $categories->pluck('approved_activities_count');
            $unapprovedCounts = $categories->pluck('unapproved_activities_count');
            $activityCounts = $categories->pluck('activities_count');

            return view('central.overview', compact(
                'labels',
                'approvedCounts',
                'unapprovedCounts',
                'categoryCount',
                'activityCount',
                'category_due_date',
                'years',
                'activityCounts',
                'latestYear',
                'selectedYearId'
            ));
        } elseif ($user->hasRole('Province Officer')) {

            // 1. ดึงปีล่าสุด (อ้างอิงจาก id)
            $latestYear = Year::orderBy('year_name', 'desc')->first();

            // ถ้าเจอปีล่าสุด ก็เอาหมวดหมู่ที่ตรงกับปีนั้น
            $categories = collect(); // default เป็นค่าว่าง

            if ($latestYear) {
                $categories = Category::where('status', 'published')
                    ->where('cat_year_id', $latestYear->year_id)
                    ->get();
            }

            // 3. นับจำนวนหมวดหมู่ และกิจกรรม
            $categoryCount = $categories->count(); // นับเฉพาะของปีล่าสุด
            $activityCount = Activity::count();
            $expiration_date = Category::value('expiration_date');
            $category_due_date = $expiration_date
                ? Carbon::parse($expiration_date)->subDays(15)->format('Y-m-d')
                : null;

            // 4. ส่งค่าไปที่ view
            return view('province.overview', compact(
                'categoryCount',
                'activityCount',
                'categories',
                'latestYear',
                'category_due_date' // เพิ่มอันนี้เผื่อใช้ในหน้า blade
            ));
        } elseif ($user->hasRole('Volunteer')) {
            // หาปีล่าสุดจากตาราง years โดยดูจาก year_name
            $latestYear = Year::orderBy('year_name', 'desc')->first();

            // ถ้าเจอปีล่าสุด ก็เอาหมวดหมู่ที่ตรงกับปีนั้น
            $categories = collect(); // default เป็นค่าว่าง

            if ($latestYear) {
                $categories = Category::where('status', 'published')
                    ->where('cat_year_id', $latestYear->year_id)
                    ->get();
            }
            $expiration_date = Category::value('expiration_date');
            $category_due_date = $expiration_date
            ? Carbon::parse($expiration_date)->subDays(15)->format('Y-m-d')
            : null;

            $categoryCount = $categories->count();

            $completedCategories = Activity::where('act_submit_by', Auth::user()->id)
                ->whereIn('status', ['Saved', 'Edit', 'Sent', 'Approve_by_province', 'Approve_by_central'])
                ->distinct('act_cat_id')
                ->count('act_cat_id');

            $completedCategoryIds = Activity::where('act_submit_by', Auth::user()->id)
                ->whereIn('status', ['Saved', 'Sent', 'Approve_by_province', 'Approve_by_central'])
                ->pluck('act_cat_id')
                ->toArray();


            $completedActivities = Activity::where('act_submit_by', Auth::user()->id)
                ->whereIn('status', ['Approve_by_central'])
                ->distinct('act_cat_id')
                ->pluck('act_cat_id')
                ->count();

            $EditActivity = Activity::where('act_submit_by', Auth::user()->id)
            ->whereIn('status', ['Approve_by_central'])
            ->distinct('act_cat_id')
            ->pluck('act_cat_id')
            ->count();

            return view('volunteer.overview', compact('categoryCount', 'completedCategories', 'completedCategoryIds', 'categories', 'latestYear','category_due_date','completedActivities','EditActivity'));
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
