<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\VarImage;

class imageController extends Controller
{
    //
    public function destroy($id)
{
    // ค้นหาภาพจากฐานข้อมูล
    $image = VarImage::findOrFail($id);

    // ลบไฟล์จาก storage
    $imagePath = storage_path( $image->img_path);
    if (file_exists($imagePath)) {
        unlink($imagePath);  // ลบไฟล์
    }

    // ลบข้อมูลจากฐานข้อมูล
    $image->delete();

    return response()->json(['success' => true]);  // ส่งกลับเป็น JSON เพื่อให้ JS สามารถจัดการ
}
}
