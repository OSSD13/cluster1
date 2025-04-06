<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\VarImage;
use App\Models\Activity;
use App\Models\Category;

class imageController extends Controller
{
    //
    public function destroy($id)
    {

        // ค้นหาภาพจากฐานข้อมูล
        $image = VarImage::findOrFail($id);
        $idAct = $image->img_act_id; // ดึง id กิจกรรมที่มีการอัพโหลดภาพ
        // ลบไฟล์จาก storage
        $imagePath = storage_path($image->img_path);
        if (file_exists($imagePath)) {
            unlink($imagePath);  // ลบไฟล์
        }
        $activity = Activity::findOrFail($idAct); // ดึงข้อมูลกิจกรรม
        // dd($activity);

        // ลบข้อมูลจากฐานข้อมูล
        $image->delete();


        $categories = Category::where('status', 'published')->get(); // ดึงหมวดหมู่ที่เผยแพร่

        return view('volunteer.edit_my_activities', compact('activity', 'categories'));
    }
}
