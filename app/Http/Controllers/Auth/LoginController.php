<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * عرض صفحة تسجيل الدخول
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * معالجة عملية تسجيل الدخول
     */
    public function login(Request $request)
    {
        // 1. التحقق من صحة البيانات المدخلة
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. محاولة تسجيل الدخول
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // ⚠️ فحص هل الحساب مفعل من قبل الإدارة؟
            if ($user->IsActive == 0) {
                Auth::logout(); // تسجيل خروج فوراً
                return back()->withErrors([
                    'email' => 'حسابك لا يزال قيد المراجعة من قبل الإدارة.',
                ]);
            }

            // تجديد الجلسة للحماية من هجمات تثبيت الجلسة
            $request->session()->regenerate();

            // 3. التوجيه الصارم حسب الدور (RoleID)
            // ملاحظة: استخدمنا redirect العادي لتجنب التوجيه التلقائي للصفحة الرئيسية
            if ($user->RoleID == 1) { // مدير النظام
                return redirect('/admin/dashboard');
            } elseif ($user->RoleID == 2) { // مطعم
                return redirect('/restaurant/dashboard');
            } elseif ($user->RoleID == 3) { // جمعية خيرية
               return redirect()->route('association.dashboard');
            }

            // إذا لم يتطابق مع أي دور، يذهب للرئيسية
            return redirect('/');
        }

        // 4. إذا فشلت بيانات تسجيل الدخول
        return back()->withErrors([
            'email' => 'الإيميل أو كلمة المرور غير صحيحة.',
        ]);
    }

    /**
     * عملية تسجيل الخروج
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
