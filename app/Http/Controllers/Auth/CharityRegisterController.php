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
    public function showRegistrationForm() {
        return view('auth.charity-register');
    }

    public function showRegistrationStep2(Request $request) {
      
        if ($request->isMethod('post')) {
            $step1Data = $request->validate([
                'EntityName'    => 'required|string|max:255',
                'ContactPerson' => 'required|string|max:100',
                'Address'       => 'required|string|max:500',
                'LicenseNumber' => 'required|numeric|unique:entities,LicenseNumber',
            ], [
                'EntityName.required' => 'اسم الجمعية مطلوب',
                'LicenseNumber.unique' => 'رقم الترخيص مسجل مسبقاً للجمعية',
            ]);


            session(['charity_step1' => $step1Data]);
            return view('auth.charity-register-step2', ['data' => $step1Data]);
        }


        if (session()->has('charity_step1')) {
            return view('auth.charity-register-step2', ['data' => session('charity_step1')]);
        }

        return redirect()->route('charity.register')->with('error', 'يرجى إكمال بيانات الجمعية أولاً');
    }

    public function registerCharity(Request $request) {

        $request->validate([
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:8|confirmed',
            'name'        => 'required|string',
            'PhoneNumber' => 'required|string',
            'EntityName'  => 'required',
        ], [
            'email.unique' => 'هذا البريد الإلكتروني مسجل لدينا بالفعل',
            'password.confirmed' => 'كلمة المرور غير متطابقة',
        ]);

        try {
            DB::transaction(function () use ($request) {

                $user = User::create([
                    'name'         => $request->name,
                    'email'        => $request->email,
                    'password'     => Hash::make($request->password),
                    'PhoneNumber'  => $request->PhoneNumber,
                    'RoleID'       => 2,
                    'IsActive'     => 0,
                ]);


                $entity = Entity::create([
                    'EntityName'    => $request->EntityName,
                    'EntityType'    => 'Charity',
                    'LicenseNumber' => $request->LicenseNumber,
                    'Address'       => $request->Address,
                    'ContactPerson' => $request->ContactPerson,
                    'ContactEmail'  => $request->email,
                    'Status'        => 'Pending',
                ]);


                DB::table('user_entity_mappings')->insert([
                    'UserID'     => $user->id,
                    'EntityID'   => $entity->EntityID,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });


            session()->forget('charity_step1');

            return redirect()->route('login')->with('success', 'تم تسجيل طلبك بنجاح! بانتظار موافقة الإدارة.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'حدث خطأ أثناء التسجيل: ' . $e->getMessage());
        }
    }
}
