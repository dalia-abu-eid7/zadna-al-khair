@extends('layouts.app') @section('content')
<style>
    /* التنسيق لضمان ظهور القسمين بجانب بعضهما */
    .auth-page-container {
        display: flex;
        flex-wrap: wrap;
        min-height: 85vh;
        direction: rtl;
        background-color: #fff;
    }

    /* القسم الأيمن (الفورم) */
    .auth-right-section {
        flex: 1;
        min-width: 400px;
        padding: 50px 8%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* القسم الأيسر (الصورة) */
    .auth-left-section {
        flex: 1;
        min-width: 400px;
        background-color: #f4f7f6; /* لون متناسق مع الفوتر */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
    }

    .auth-left-content {
        text-align: center;
    }

    .auth-hero-img {
        max-width: 85%;
        height: auto;
        display: block;
        margin: 0 auto 30px;
    }

    /* تنسيق الحقول */
    .form-input-box {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 15px;
        outline: none;
        font-family: 'Cairo', sans-serif;
    }

    .auth-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
    }

    .tab-item {
        text-decoration: none;
        padding: 8px 20px;
        border-radius: 5px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .tab-item.active {
        background-color: #e8f5e9;
        color: #27ae60;
        border: 1px solid #27ae60;
    }

    .tab-item.inactive {
        color: #888;
        border: 1px solid #eee;
    }

    .submit-btn {
        background-color: #2ecc71;
        color: white;
        width: 100%;
        padding: 13px;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        font-size: 1.1rem;
        transition: 0.3s;
    }

    .submit-btn:hover {
        background-color: #27ae60;
    }

    /* إخفاء القسم الأيسر في الشاشات الصغيرة جداً */
    @media (max-width: 850px) {
        .auth-left-section { display: none; }
    }
</style>

<div class="auth-page-container">

    <div class="auth-right-section">
        <h2>إكمال إنشاء الحساب</h2>
        <p style="color: #777; margin-bottom: 20px;">الخطوة الأخيرة: بيانات المسؤول عن المطعم</p>

        <div class="auth-tabs">
            <a href="{{ route('login') }}" class="tab-item inactive">تسجيل دخول</a>
            <a href="{{ route('restaurant.register') }}" class="tab-item active">حساب جديد</a>
        </div>

        @if ($errors->any())
            <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem;">
                <strong>فيه حقول ناقصة أو غلط:</strong>
                <ul style="margin: 5px 0 0 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="form" method="POST" action="{{ route('restaurant.register.post') }}">
            @csrf
            <input type="hidden" name="EntityName" value="{{ $old_data['EntityName'] ?? '' }}">
            <input type="hidden" name="LicenseNumber" value="{{ $old_data['LicenseNumber'] ?? '' }}">
            <input type="hidden" name="Address" value="{{ $old_data['Address'] ?? '' }}">
            <input type="hidden" name="ContactPerson" value="{{ $old_data['ContactPerson'] ?? '' }}">

            <h3 style="margin-bottom: 15px; color: #27ae60; font-size: 1.1rem;">بيانات المسؤول</h3>

            <input type="text" name="name" class="form-input-box" placeholder="مثال: أحمد أبو شمالة" required>
            <input type="email" name="email" class="form-input-box" placeholder="example@domain.com" required>
            <input type="text" name="PhoneNumber" class="form-input-box" placeholder="00972xxxxxxxx" required>
            <input type="password" name="password" class="form-input-box" placeholder="••••••••" required>

            <button type="submit" class="submit-btn">إنشاء الحساب</button>
        </form>
         <a href="{{ route('restaurant.register') }}" style="text-align: center; display: block; margin-top: 15px; color: #7f8c8d; text-decoration: none; font-size: 0.9rem;">
                العودة لتعديل بيانات المطعم
            </a>
    </div>

    <div class="auth-left-section">
        <div class="auth-left-content">
            <h2 style="color: #27ae60; margin-bottom: 20px;">معاً لنحفظ النعمة<br>وننشر الخير</h2>

            <img src="{{ asset('images/pngtree-food-donation-drive-helpers-packing-donations-on-transparent-background-png-image_12498977.png') }}"
                 alt="صورة تبرعات" class="auth-hero-img">

            <div style="display: flex; gap: 15px; justify-content: center;">
                <div style="background: white; padding: 12px 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                    <span style="font-size: 1rem;">🍴 للمطاعم</span>
                </div>
                <div style="background: white; padding: 12px 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                    <span style="font-size: 1rem;">❤ للجمعيات</span>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
