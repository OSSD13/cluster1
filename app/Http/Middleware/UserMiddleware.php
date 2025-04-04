<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'กรุณาเข้าสู่ระบบก่อน');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!empty($roles) && !$user->hasAnyRole($roles)) {
            return abort(403, 'คุณไม่มีสิทธิ์เข้าสู่หน้านี้');
        }

        return $next($request);
    }
}
