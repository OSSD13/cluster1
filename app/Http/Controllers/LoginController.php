<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // ✅ 1. Validate input
        $request->validate([
            'user_username' => 'required|string',
            'user_password' => 'required|string',
        ]);

        // ✅ 2. Find user by username
        $user = User::where('user_username', $request->user_username)->first();

        // ✅ 3. Check password
        if ($user && Hash::check($request->user_password, $user->user_password)) {
            // ✅ 4. Login
            Auth::login($user);
            $request->session()->regenerate();

            // ✅ 6. Redirect ไปยังหน้าแรก
            return redirect()->route('overview.index');
        }

        // ❌ 7. Login fail
        return redirect()->back()->with('error', 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('logined')->with('success', 'ออกจากระบบเรียบร้อยแล้ว');
    }
}
