@extends('layouts.app')

@section('content')
<style>
    /* تنسيق الحاوية الرئيسية لتكون تحت الهيدر مباشرة */
    .login-wrapper-full {
        display: flex;
        flex-wrap: wrap;
        min-height: 85vh; /* ارتفاع مناسب ليظهر الفوتر تحتها */
        direction: rtl;
        background-color: #fff;
    }

    /* القسم الأيمن (النموذج) */
    .login-right {
        flex: 1;
        min-width: 400px;
        padding: 50px 8%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* القسم الأيسر (الصورة والخلفية) */
    .login-left {
        flex: 1;
        min-width: 400px;
        background-color: #f4f7f6; /* لون متناسق مع الفوتر */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
    }

    .login-left-content {
        text-align: center;
    }

    /* تنسيق الصورة لضمان ظهورها */
    .login-hero-img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto 30px;
        /* إضافة أنيميشن بسيط لزيادة الجمالية */
        transition: transform 0.3s ease;
    }

    .login-hero-img:hover {
        transform: scale(1.02);
    }

    .login-title {
        color: #27ae60;
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 1.8rem;
    }

    /* تنسيق الحقول والأزرار */
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
    }

    .form-input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 20px;
        outline: none;
        font-family: 'Cairo', sans-serif;
    }

    .btn-submit {
        background-color: #27ae60;
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

    .btn-submit:hover {
        background-color: #219150;
        box-shadow: 0 4px 12px rgba(39, 174, 96, 0.2);
    }

    .auth-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
    }

    .tab-link {
        text-decoration: none;
        padding: 8px 20px;
        border-radius: 5px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .tab-link.active {
        background-color: #e8f5e9;
        color: #27ae60;
        border: 1px solid #27ae60;
    }

    .tab-link.inactive {
        color: #888;
        border: 1px solid #eee;
    }

    /* لإخفاء القسم الأيسر في الشاشات الصغيرة جداً */
    @media (max-width: 850px) {
        .login-left { display: none; }
    }
</style>

<div class="login-wrapper-full">

    <div class="login-right">
        <h2 style="margin-bottom: 10px;">تسجيل الدخول</h2>
        <p style="color: #777; margin-bottom: 25px;">مرحباً بك في زادنا الخير، ادخل بياناتك للمتابعة</p>
@if ($errors->has('email'))
        <div style="background-color: #fff2f0; border: 1px solid #ffccc7; color: #ff4d4f; padding: 15px; border-radius: 10px; margin-bottom: 20px; font-size: 0.95rem; display: flex; align-items: center; gap: 10px;">
            <span>⚠️</span>
            <span>{{ $errors->first('email') }}</span>
        </div>
    @endif
        <div class="auth-tabs">
            <a href="{{ route('login') }}" class="tab-link active">تسجيل دخول</a>
            <a href="{{ route('restaurant.register') }}" class="tab-link inactive">حساب جديد</a>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label class="form-label">البريد الإلكتروني</label>
            <input type="email" name="email" class="form-input" placeholder="example@gmail.com" required>

            <label class="form-label">كلمة المرور</label>
            <input type="password" name="password" class="form-input" placeholder="••••••••" required>

            <button type="submit" class="btn-submit">دخول إلى الحساب</button>
        </form>
    </div>

    <div class="login-left">
        <div class="login-left-content">
            <h2 class="login-title">معاً لنحفظ النعمة<br>وننشر الخير</h2>

            <img src="{{ asset('images/pngtree-food-donation-drive-helpers-packing-donations-on-transparent-background-png-image_12498977.png') }}"
                 alt="صورة تبرعات زادنا الخير"
                 class="login-hero-img">

            <div style="display: flex; gap: 15px; justify-content: center; margin-top: 20px;">
                <div style="background: white; padding: 12px 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                    <span style="font-size: 1.2rem;">🍴 للمطاعم</span>
                </div>
                <div style="background: white; padding: 12px 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                    <span style="font-size: 1.2rem;">💚 للجمعيات</span>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
