<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ], [
            'email.required' => 'حقل البريد الإلكتروني لا يمكن أن يكون فارغاً.',
            'email.email' => 'البريد الإلكتروني الذي أدخلته غير صحيح.',
            'password.required' => 'يرجى إدخال كلمة المرور.',
            'password.min' => 'كلمة المرور يجب أن تكون 6 خانات على الأقل.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

        
            if ($user->IsActive == 0) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'عذراً، حسابك لا يزال قيد المراجعة. سيتم تفعيل حسابك قريباً من قبل الإدارة.',
                ]);
            }

            $request->session()->regenerate();

            if ($user->RoleID == 1) {
                return redirect('/admin/dashboard');
            }

            $entity = $user->entities->first();

            if ($entity) {
                if ($entity->EntityType == 'Restaurant') {
                    return redirect('/restaurant/dashboard');
                } elseif (in_array($entity->EntityType, ['Charity', 'NGO'])) {
                    return redirect()->route('association.dashboard');
                }
            }

            return $user->RoleID == 2 ? redirect()->route('association.dashboard') : redirect('/');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'البيانات المدخلة لا تتطابق مع سجلاتنا.',
            ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
