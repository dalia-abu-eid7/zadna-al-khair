<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class CheckRestaurant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next)
{
    // إذا كان المستخدم مسجل دخول و رتبته هي مطعم (RoleID = 2)
    if (Auth::check() && Auth::user()->RoleID == 2) {
        return $next($request); // اسمح له بالمرور
    }

    // إذا لم يكن مطعماً، اطرده لصفحة الدخول أو الرئيسية مع رسالة تنبيه
    return redirect('/login')->with('error', 'عذراً، لا تملك صلاحية الوصول لهذه الصفحة.');
}
}
