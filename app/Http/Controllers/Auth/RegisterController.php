<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Entity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{

  public function registerRestaurant(Request $request)
{
    try {
        // جلب رتبة المطعم من قاعدة البيانات بناءً على الاسم
        $restaurantRole = DB::table('roles')->where('RoleName', 'Restaurant')->first();

        // تأكدي من وجود الرتبة لتجنب الأخطاء
        if (!$restaurantRole) {
            return "الغلط هو: لم يتم العثور على رتبة Restaurant في جدول roles.";
        }

        DB::transaction(function () use ($request, $restaurantRole) {

            // إنشاء المستخدم
            $user = User::create([
                'name'        => $request->name,
                'email'       => $request->email,
                'password'    => Hash::make($request->password),
                'PhoneNumber' => $request->PhoneNumber,
                'RoleID'      => $restaurantRole->RoleID, // استخدام القيمة التي جلبناها
                'IsActive'    => 0,
            ]);

            // إنشاء الكيان (المطعم)
            $entity = Entity::create([
                'EntityName'    => $request->EntityName,
                'EntityType'    => 'Restaurant',
                'LicenseNumber' => $request->LicenseNumber,
                'Address'       => $request->Address,
                'ContactPerson' => $request->name,
                'ContactEmail'  => $request->email,
                'Status'        => 'Pending',
            ]);

            // الربط في جدول المابينج
            DB::table('user_entity_mappings')->insert([
                'UserID'     => $user->id,
                'EntityID'   => $entity->EntityID,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return redirect('/login')->with('success', 'تهانينا تم انشاء حسابك بنجاح!');
    } catch (\Exception $e) {
        return "الغلط هو: " . $e->getMessage();
    }
}
    public function showRegistrationForm()
    {
        return view('auth.restaurant-register');
    }

    public function showRegistrationStep2(Request $request)
    {
        return view('auth.restaurant-register-step2', [
            'old_data' => $request->all()
        ]);
    }
}
