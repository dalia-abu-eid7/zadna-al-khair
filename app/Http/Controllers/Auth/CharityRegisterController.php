<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Entity;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class CharityRegisterController extends Controller
{
   public function registerCharity(Request $request)
{
    try {
        DB::transaction(function () use ($request) {

            // إنشاء المستخدم
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'PhoneNumber' => $request->PhoneNumber,
                'RoleID'   => 3,
                'IsActive' => 0,
            ]);

            // إنشاء الكيان
            $entity = Entity::create([
                'EntityName'    => $request->EntityName,
                'EntityType'    => 'Charity',
                'LicenseNumber' => $request->LicenseNumber,
                'Address'       => $request->Address,
                'ContactPerson' => $request->name,
                'ContactEmail'  => $request->email,
                'Status'        => 'Pending',
            ]);

            // الربط
          DB::table('user_entity_mappings')->insert([
    'UserID'   => $user->id, // أو $user->UserID حسب موديل اليوزر
    'EntityID' => $entity->EntityID, // سحبنا الرقم اللي لسه متخزن هالحين
    'created_at' => now(),
]);
        });

return redirect('/login')->with('success', 'تهانينا تم انشاء حسابك بنجاح، يرجى تسجيل الدخول للذهاب للوحة التحكم الخاصة بك');
    } catch (\Exception $e) {
        // إذا فشل، رح يطبع لك شو السبب بالضبط
        return "الغلط هو: " . $e->getMessage();
    }
}

 public function showRegistrationForm()
    {
        return view('auth.charity-register');
    }

    // دالة عرض صفحة التسجيل (المرحلة الثانية)
public function showRegistrationStep2(Request $request)
{
    // هنا نمرر البيانات القادمة من الصفحة الأولى لكي نعرضها في الصفحة الثانية
    return view('auth.charity-register-step2', [
        'data' => $request->all()
    ]);
}
}
