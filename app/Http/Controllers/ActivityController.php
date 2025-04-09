<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\VarImage;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    /**
     * แสดงกิจกรรมทั้งหมด
     */
    public function index()
    {
        $activities = Activity::latest()->get();
        $categories = Category::where('status', 'published')->get(); // ดึงเฉพาะหมวดหมู่ที่เผยแพร่แล้ว
        // dd($activities , $categories);
        return view('volunteer.Activity', compact('activities', 'categories'));
    }

    /**
     * แสดงหน้าเพิ่มกิจกรรม
     */
    public function create()
    {
        // $categories = Category::where('status', 'published')->get(); // ดึงเฉพาะหมวดหมู่ที่เผยแพร่แล้ว
        // return view('volunteer.makedActivity', compact('categories'));
        $categories = Category::where('status', 'published')->get();
        $activities = Activity::where('act_save_by', Auth::id())->get();
        if ($activities->isEmpty()) {
            $activities = 0;
        }
        return view('volunteer.makedActivity', compact('activities', 'categories'));
    }


    public function historyActivity()
    {
        $categories = Category::where('status', 'published')->get();
        $activities = Activity::where('act_save_by', Auth::id())->get();
        $checkAcSent = false;
        if ($activities->isEmpty()) {
            $activities = 0;
        } else {
            foreach ($activities as $activity) {
                if ($activity->status == 'Sent') {
                    $checkAcSent = true;
                    break;
                } else {
                    $checkAcSent = false;
                }
            }
        }
        return view('volunteer.makedActivity', compact('activities', 'categories', 'checkAcSent'));
    }



    /**
     * บันทึกกิจกรรมใหม่
     */
    /**
     * บันทึกกิจกรรมใหม่
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ตรวจสอบความถูกต้องของข้อมูล
        $request->validate([
            'act_title' => 'required|string|max:100',
            'act_description' => 'required|string',
            'act_cat_id' => 'required|exists:categories,cat_id',
            'act_date' => 'required|date', // ตรวจสอบวันที่
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        try {
            // สร้างกิจกรรมใหม่
            $activity = new Activity();
            $activity->act_title = $request->act_title;
            $activity->act_description = $request->act_description;
            $activity->act_cat_id = $request->act_cat_id;
            $activity->act_date = $request->act_date; // รับค่าจากฟอร์ม
            $activity->status = 'Saved'; // สถานะเริ่มต้น
            $activity->act_submit_by = Auth::id(); // ใช้ ID ของผู้ใช้ที่ล็อกอินอยู่
            $activity->act_save_by = Auth::id(); // ใช้ ID ของผู้ใช้ที่ล็อกอินอยู่
            $activity->save(); // บันทึกข้อมูลกิจกรรม

            // ตรวจสอบว่ากิจกรรมถูกบันทึกแล้ว
            if (!$activity->act_id) {
                dd('กิจกรรมไม่สามารถบันทึกได้', $activity);
            }
            // dd($request->hasFile('images'));
            // อัปโหลดรูปภาพ (ถ้ามี)
            if (!$request->hasFile('images')) {
                dd('ปปปปปปปปป', $activity);
                foreach ($request->file('images') as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $imagePath = $image->storeAs('activity_images', $imageName, 'public');
                    // บันทึกข้อมูลรูปภาพ
                    DB::table('var_images')->insert([
                        'img_act_id' => $activity->act_id,
                        'img_path' => 'storage/app/public/' . $imagePath,
                        'img_name' => $imageName,
                        'img_uploaded_at' => now(),
                    ]);
                }
            }
            return redirect()->route('activities.history')
                ->with('success', 'สร้างกิจกรรม ' . $activity->act_title . ' สำเร็จแล้ว');
        } catch (\Exception $e) {
            // แสดงข้อผิดพลาดที่เกิดขึ้น
            return redirect()->back()
                ->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function submitAll()
    {
        $userId = Auth::id();
        // dd($userId);
        // อัปเดตทุกกิจกรรม ให้เป็น "Sent"
        Activity::where('act_submit_by', $userId)
            ->where('status', 'Saved') // เฉพาะกิจกรรมที่ยังไม่ถูกส่ง
            ->update(['status' => 'Sent']);
        Activity::where('act_submit_by', $userId)
            ->where('status', 'Edit') // เฉพาะกิจกรรมที่ยังไม่ถูกส่ง
            ->update(['status' => 'Sent']);

        Activity::where('act_submit_by', $userId)
            ->where('status', 'Edit') // เฉพาะกิจกรรมที่ยังไม่ถูกส่ง
            ->update(['status' => 'Sent']);

        return redirect()->route('activities.history')->with('success', 'ส่งกิจกรรมทั้งหมดให้ User2 ตรวจสอบแล้ว!');
    }



    public function show($id)
    {
        // ดึงข้อมูลกิจกรรมโดยใช้ id
        $latestYear = \App\Models\Year::orderByDesc('year_name')->first();
        $selectedYearId = $request->input('year_id', $latestYear->year_id);

        $activities = Category::where('status', 'Sent')
            ->whereHas('category', fn($q) => $q->where('cat_year_id', $selectedYearId))
            ->get();

        $groupedActivities = $activities
            ->groupBy(fn($activity) => $activity->creator->user_fullname)
            ->sortKeys();

        $years = \App\Models\Year::orderByDesc('year_name')->get();
        $userCount = $groupedActivities->count();
        $activityCount = $activities->count();

        return view('volunteer.makedActivity', compact(
            'groupedActivities',
            'years',
            'selectedYearId',
            'userCount',
            'activityCount'
        ));
        // ส่งข้อมูลกิจกรรมไปยัง view
    }




    public function edit($id)
    {
        $activity = Activity::findOrFail($id); // ดึงข้อมูลกิจกรรม
        $categories = Category::where('status', 'published')->get(); // ดึงหมวดหมู่ที่เผยแพร่

        // ดึง apv_comment จากตาราง var_approvals
        $approval = DB::table('var_approvals')
            ->where('apv_act_id', $id)
            ->orderByDesc('apv_date') // หากมีหลาย comment อาจเอาอันล่าสุด
            ->first();
        dd($activity->images);
        $comment = $approval->apv_comment ?? null; // กรณีไม่มีข้อมูลจะได้ค่า null

        return view('volunteer.edit_my_activities', compact('activity', 'categories', 'comment'));
    }
    public function editwithcomment($id)
    {
        // ดึงกิจกรรมที่ต้องการแก้ไข (ถ้าไม่เจอจะ error 404)
        $activity = Activity::findOrFail($id);

        // ดึงหมวดหมู่ทั้งหมดที่เผยแพร่แล้ว
        $categories = Category::where('status', 'published')->get();

        // ดึง apv_comment จาก var_approvals โดยอิงจาก act_id
        $approval = DB::table('var_approvals')
            ->where('apv_act_id', $id)
            ->first(); // ใช้ first() เพราะมีแค่หนึ่ง comment เท่านั้น

        // ถ้ามีข้อมูลใน $approval จะได้ $approval->apv_comment, ถ้าไม่มีจะได้ null
        $comment = $approval->apv_comment ?? null;

        // ส่งค่าทั้งหมดไปยัง view
        return view('volunteer.edit_my_activities_with_comment', compact('activity', 'categories', 'comment'));
    }



    public function update(Request $request, $id)
    {
        // ตรวจสอบความถูกต้องของข้อมูล
        $request->validate([
            'act_title' => 'required|string|max:100',
            'act_description' => 'required|string',
            'act_cat_id' => 'required|exists:categories,cat_id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // ค้นหากิจกรรมที่ต้องการแก้ไข
        $activity = Activity::findOrFail($id);

        // อัปเดตข้อมูลกิจกรรม
        $activity->act_title = $request->act_title;
        $activity->act_description = $request->act_description;
        $activity->act_cat_id = $request->act_cat_id;

        // กำหนดสถานะใหม่ถ้าต้องการ
        // $activity->status = 'Updated';  // หากต้องการเปลี่ยนสถานะหลังจากการแก้ไข
        $activity->save();

        // อัปโหลดรูปภาพใหม่ (ถ้ามี)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // เตรียมข้อมูลสำหรับการอัปโหลด
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('activity_images', $imageName, 'public');

                // บันทึกข้อมูลรูปภาพในตาราง var_images
                DB::table('var_images')->insert([
                    'img_act_id' => $activity->act_id,  // ใช้ ID ของกิจกรรมที่สัมพันธ์
                    'img_path' => 'storage/' . $imagePath,  // ระบุ path ของไฟล์ภาพ
                    'img_name' => $imageName,  // ระบุชื่อไฟล์
                    'img_uploaded_at' => now(),  // ใช้เวลาปัจจุบันสำหรับ img_uploaded_at
                ]);
            }
        }

        // รีไดเรกต์ไปที่หน้าแสดงกิจกรรมที่ถูกอัปเดต และแสดงข้อความสำเร็จ
        return redirect()->route('activities.history')->with('success', 'กิจกรรมถูกอัปเดตสำเร็จ');
    }
    public function detail($id)
    {
        $activity = Activity::findOrFail($id); // ดึงข้อมูลกิจกรรม
        $categories = Category::where('status', 'published')->get(); // ดึงหมวดหมู่ที่เผยแพร่

        return view('volunteer.activity_detail', compact('activity', 'categories'));
    }
    public function destroy($id)
    {
        $activity = Activity::findOrFail($id); // ดึงข้อมูลกิจกรรม
        $activity->delete(); // ลบกิจกรรม

        return redirect()->route('activities.history')->with('success', 'ลบกิจกรรมสำเร็จ');
    }
}
