<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class volunteerController extends Controller
{
    public function overview()
    {
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            return redirect('/login')->with('error', 'กรุณาเข้าสู่ระบบก่อน');
        }

        // ดึงหมวดหมู่ที่เผยแพร่แล้ว
        $categories = Category::where('status', 'published')->get();

        // นับหมวดหมู่ทั้งหมดที่ User3 สามารถเข้าถึง
        $categoryCount = $categories->count();

        // นับกิจกรรมที่ทำสำเร็จ
        $completedCategories = Activity::where('created_by', $userId)
            ->whereIn('status', ['approved', 'final_approved'])
            ->distinct('category_id')
            ->count();

        // ดึง ID หมวดหมู่ที่ทำกิจกรรมสำเร็จ
        $completedCategoryIds = Activity::where('created_by', $userId)
            ->whereIn('status', ['approved', 'final_approved'])
            ->pluck('category_id')
            ->toArray();

        return view('volunteer.overview', compact('categoryCount', 'completedCategories', 'completedCategoryIds', 'categories'));
    }
}
