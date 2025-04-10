<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Year;

class CategoryController extends Controller
{
    public function index(Request $request) //เพิ่มRequest $request
    {
        //$this->checkCategoryExpiration();
        // $categories = Category::all();
        // return view('categories.index', compact('categories'));

        // เพิ่มเข้ามา
        $years = Year::orderByDesc('year_name')->get(); // ดึงรายการปีทั้งหมด
        $latestYear = Year::orderByDesc('year_name')->first(); // ดึงปีล่าสุด

        // ถ้ามีการส่ง year_id มาใน query string ให้ใช้ค่านั้น ถ้าไม่มีก็ใช้ปีล่าสุด
        $selectedYearId = $request->input('year_id', $latestYear->year_id);

        // ดึงเฉพาะหมวดหมู่ของปีที่เลือก
        $categories = Category::where('cat_year_id', $selectedYearId)->get();
        $pendingCount = Category::where('status', 'published')->count();

        return view('categories.index', compact('categories', 'years', 'selectedYearId','pendingCount'));
    }

    public function create(Request $request)
    {
        $latestYear = \App\Models\Year::orderByDesc('year_name')->first();
        $selectedYearId = $request->input('year_id', $latestYear->year_id);
        $categories = Category::all();
        $years = Year::all(); // ดึงข้อมูลปีจากตาราง years

        return view('categories.create', compact('years', 'categories','selectedYearId'));
    }

    // public function checkCategoryExpiration()
    // {
    //     Category::where('expiration_date', '<', now())
    //         ->where('status', 'published')
    //         ->update(['status' => 'expired']);
    // }

    public function publishAll()
    {
        // ตรวจสอบว่ามีหมวดหมู่ที่ยังไม่เผยแพร่หรือไม่
        $pendingCount = Category::where('status', 'published')->count();

        if ($pendingCount >= 1) {
            return redirect()->route('categories.index')->with('info', 'ไม่มีหมวดหมู่ที่รอการเผยแพร่');
        }

        // อัปเดตหมวดหมู่ที่ยังไม่เผยแพร่ให้เป็น published
        Category::where('status', 'pending')->update(['status' => 'published']);

        return redirect()->route('categories.index',compact('pendingCount'))->with('success', 'เผยแพร่หมวดหมู่ทั้งหมดเรียบร้อยแล้ว!');
    }

    /**
     * Store a newly created category in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ตรวจสอบความถูกต้องของข้อมูล
        $request->validate([
            'cat_name' => 'required|string|max:100|unique:categories,cat_name',
            'description' => 'nullable|string',
            'cat_ismandatory' => 'required|boolean',
            'cat_year_id' => 'required|exists:years,year_id',
            'expiration_date' => 'nullable|date',
        ]);

        try {
            // สร้าง category ใหม่
            $category = new Category();
            $category->cat_name = $request->cat_name;
            $category->description = $request->description;
            $category->cat_ismandatory = $request->cat_ismandatory;
            $category->cat_year_id = $request->cat_year_id;
            $category->expiration_date = $request->expiration_date;
            $category->created_by = Auth::id(); // ใช้ ID ของผู้ใช้ที่ล็อกอินอยู่
            $category->status = 'pending'; // ค่าเริ่มต้นเป็น pending

            $category->save();

            return redirect()->route('categories.index')
                ->with('success', 'เพิ่มหมวดหมู่ ' . $category->cat_name . ' สำเร็จแล้ว');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage())
                ->withInput();
        }
    }
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $years = Year::all(); // ดึงข้อมูลปีจากตาราง years
        //dd($category->cat_id);

        return view('categories.edit_category', compact('category', 'years'));
    }
    public function update(Request $request, $id)
    {
        // ตรวจสอบความถูกต้องของข้อมูล
        $request->validate([
            'cat_name' => 'required|string|max:100|unique:categories,cat_name,' . $id . ',cat_id',
            'description' => 'nullable|string',
            'cat_ismandatory' => 'required|boolean',
            'cat_year_id' => 'required|exists:years,year_id',
            'expiration_date' => 'nullable|date',
        ]);

        try {
            // อัปเดตหมวดหมู่ที่มีอยู่
            $category = Category::findOrFail($id);
            $category->cat_name = $request->cat_name;
            $category->description = $request->description;
            $category->cat_ismandatory = $request->cat_ismandatory;
            $category->cat_year_id = $request->cat_year_id;
            $category->expiration_date = $request->expiration_date;

            $category->save();

            return redirect()->route('categories.index')
                ->with('success', 'อัปเดตหมวดหมู่ ' . $category->cat_name . ' สำเร็จแล้ว');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage())
                ->withInput();
        }
    }
    // เพิ่มเข้ามา
    public function detail($id){
        $category = Category::findOrFail($id);
        return view('categories.category_detail', compact('category'));
    }

}
