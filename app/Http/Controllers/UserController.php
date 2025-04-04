<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    function index()
    {
        $users = User::all();
        return view('user.index', ['users' => $users]);
    }
    public function edit($id)
    {
        // ดึงข้อมูลผู้ใช้ทั้งหมด (ถ้าต้องใช้)
        $users = User::all();

        // ดึงข้อมูลผู้ใช้จาก ID ที่รับมา
        $user = User::find($id);

        // ตรวจสอบว่า user มีอยู่จริงหรือไม่
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        // ส่งข้อมูลไปยัง View
        return view('user.user_edit', ['user' => $user, 'users' => $users]);
    }

    function saveEdit(Request $req, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $user->name = $req->name;
        $user->email = $req->email;

        if ($req->filled('password')) {
            $user->password = bcrypt($req->password); // Hash password ก่อนบันทึก
        }

        $user->save();
        return redirect('/user')->with('success', 'User updated successfully!');
    }
    function delete(Request $req){
        $user = User::find($req->id);
        $user->delete();
        return redirect('/user');
    }
}
