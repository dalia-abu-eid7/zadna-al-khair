@extends('layouts.app')
@section('content')
<style>
    .register-page-container { display: flex; flex-wrap: wrap; min-height: 85vh; direction: rtl; background-color: #fff; }
    .right-section { flex: 1; min-width: 400px; padding: 50px 8%; display: flex; flex-direction: column; justify-content: center; }
    .left-section { flex: 1; min-width: 400px; background-color: #f4f7f6; display: flex; align-items: center; justify-content: center; padding: 40px; }
    .form input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px; outline: none; font-family: 'Cairo', sans-serif; }
    .error-msg { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; border: 1px solid #f5c6cb; }
    .error-msg ul { margin: 0; padding-right: 20px; }
    .btn-submit { width: 100%; border: none; cursor: pointer; background-color: #2ecc71; color: white; padding: 12px; border-radius: 8px; font-size: 16px; font-weight: bold; transition: 0.3s; }
    .btn-submit:hover { background-color: #27ae60; }
</style>

<div class="register-page-container">
    <div class="right-section">
        <h2>إكمال إنشاء الحساب</h2>
        <p style="color: #666; margin-bottom: 20px;">الجمعية: <strong>{{ $data['EntityName'] ?? 'غير معرف' }}</strong></p>

        @if ($errors->any())
            <div class="error-msg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('charity.register.post') }}" method="POST" class="form">
            @csrf
            {{-- الحقول المخفية لضمان انتقال بيانات الجمعية للدالة النهائية --}}
            <input type="hidden" name="EntityName" value="{{ $data['EntityName'] ?? '' }}">
            <input type="hidden" name="ContactPerson" value="{{ $data['ContactPerson'] ?? '' }}">
            <input type="hidden" name="Address" value="{{ $data['Address'] ?? '' }}">
            <input type="hidden" name="LicenseNumber" value="{{ $data['LicenseNumber'] ?? '' }}">

            <h3 style="margin-bottom: 15px; color: #27ae60;">بيانات المسؤول والدخول</h3>

            <input type="text" name="name" value="{{ old('name') }}" placeholder="اسم المسؤول عن الحساب" required>

            <input type="email" name="email" value="{{ old('email') }}" placeholder="البريد الإلكتروني الرسمي" required
                   style="{{ $errors->has('email') ? 'border-color: #e74c3c;' : '' }}">

            <input type="text" name="PhoneNumber" value="{{ old('PhoneNumber') }}" placeholder="رقم الهاتف (مثال: 059xxxxxxx)" required>

            <input type="password" name="password" placeholder="كلمة المرور" required>

            <input type="password" name="password_confirmation" placeholder="تأكيد كلمة المرور" required>

            <button type="submit" class="btn-submit">
                إنشاء حساب
            </button>

            <a href="{{ route('charity.register') }}" style="text-align: center; display: block; margin-top: 15px; color: #7f8c8d; text-decoration: none; font-size: 0.9rem;">
                العودة لتعديل بيانات الجمعية
            </a>
        </form>
    </div>

    <div class="left-section">
        <img src="{{ asset('images/pngtree-food-donation-drive-helpers-packing-donations-on-transparent-background-png-image_12498977.png') }}" alt="صورة تبرعات" style="max-width:80%">
    </div>
</div>
@endsection
