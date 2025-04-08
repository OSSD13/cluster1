<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Year;

class volunteerController extends Controller
{

    public function overview($id)
    {
        $userId = auth()->id();

        // ดึงหมวดหมู่ที่เผยแพร่แล้ว
        $categories = Category::where('status', 'published')->get();

        // นับหมวดหมู่ทั้งหมดที่ User เข้าถึงได้
        $categoryCount = $categories->count();

        // นับกิจกรรมที่ทำเสร็จแล้ว
        $completedCategories = Activity::where('created_by', $userId)
            ->whereIn('status', ['approved', 'final_approved'])
            ->distinct('category_id')
            ->count();

        $completedCategoryIds = Activity::where('created_by', $userId)
            ->whereIn('status', ['approved', 'final_approved'])
            ->pluck('category_id')
            ->toArray();

        // ✅ เพิ่มตรงนี้
        $years = Year::all();

        // ✅ เพิ่มตัวแปร years และ selectedYearId ไปใน view
        return view('volunteer.overview', compact(
            // 'categories',
            // 'categoryCount',
            // 'completedCategories',
            // 'completedCategoryIds',
            'years',
            'latestYear'
        ));
    }
}
