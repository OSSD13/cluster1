<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Year;

class CategoryController extends Controller
{
    public function index()
    {
        //$this->checkCategoryExpiration();
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {

        $categories = Category::all();
        $years = Year::all(); // ดึงข้อมูลปีจากตาราง years

        return view('categories.create', compact('years', 'categories'));
    }

    // public function checkCategoryExpiration()
    // {
    //     Category::where('expiration_date', '<', now())
    //         ->where('status', 'published')
    //         ->update(['status' => 'expired']);
    // }

    public function publishAll()
    {
        // อัปเดตทุกหมวดหมู่ที่ยังไม่เผยแพร่ให้เป็น published
        Category::where('status', 'pending')->update(['status' => 'published']);

        return redirect()->route('categories.index')->with('success', 'เผยแพร่หมวดหมู่ทั้งหมดเรียบร้อยแล้ว!');
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
}
