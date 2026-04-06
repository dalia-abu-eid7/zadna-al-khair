@extends('layouts.app')

@section('content')
<style>
    /* الحاوية الرئيسية */
    .auth-container-unified {
        display: flex;
        flex-wrap: wrap;
        min-height: 85vh;
        direction: rtl;
        background-color: #fff;
    }

    /* قسم الفورم (اليمين) */
    .form-side {
        flex: 1.2;
        min-width: 450px;
        padding: 40px 6%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* قسم الصورة (اليسار) */
    .image-side {
        flex: 1;
        min-width: 400px;
        background-color: #f4f7f6;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
    }

    .hero-img-unified {
        max-width: 85%;
        height: auto;
        display: block;
        margin: 0 auto 25px;
    }

    /* أزرار التبديل العلوية */
    .auth-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
    }

    .tab-btn {
        text-decoration: none;
        padding: 8px 18px;
        border-radius: 5px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .tab-btn.primary { background: #e8f5e9; color: #27ae60; border: 1px solid #27ae60; }
    .tab-btn.secondary { color: #888; border: 1px solid #eee; }

    /* أزرار اختيار نوع الحساب */
    .account-selection {
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
    }

    .selection-card {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 12px;
        border: 1px solid #eee;
        border-radius: 12px;
        text-decoration: none;
        color: #888;
        background-color: #fcfcfc;
        transition: 0.3s ease;
    }

    /* تمييز المطعم هنا لأننا في صفحة تسجيل المطعم */
    .selection-card.active-restaurant {
        border-color: #27ae60;
        background-color: #f0fff4;
        color: #27ae60;
        font-weight: bold;
        box-shadow: 0 4px 10px rgba(39, 174, 96, 0.08);
    }

    /* تنسيق صفوف الحقول */
    .form-row-unified {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
    }

    .input-group-unified {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .input-group-unified label { margin-bottom: 5px; font-weight: 600; color: #444; }

    .input-group-unified input {
        padding: 11px;
        border: 1px solid #ddd;
        border-radius: 8px;
        outline: none;
    }

    .submit-next-btn {
        background-color: #2ecc71;
        color: white;
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        font-size: 1.1rem;
        margin-top: 15px;
    }

    @media (max-width: 900px) {
        .image-side { display: none; }
        .form-row-unified { flex-direction: column; }
    }
</style>

<div class="auth-container-unified">

    <div class="form-side">
        <h2>إنشاء حساب جديد</h2>
        <p style="color: #777; margin-bottom: 20px;">انضم إلينا في مهمتنا لحفظ النعمة ومساعدة المحتاجين</p>

        <div class="auth-tabs">
            <a href="{{ route('login') }}" class="tab-btn secondary">تسجيل دخول</a>
            <a href="{{ route('restaurant.register') }}" class="tab-btn primary">حساب جديد</a>
        </div>

        <div class="account-selection">
            <a href="{{ route('charity.register') }}" class="selection-card">
                <span style="font-size: 1.2rem;">♡</span>
                <span>جمعية خيرية</span>
            </a>
            <a href="{{ route('restaurant.register') }}" class="selection-card active-restaurant">
                <span style="font-size: 1.2rem;">🍴</span>
                <span>مطعم</span>
            </a>
        </div>

        <form action="{{ route('restaurant.register.step2') }}" method="POST">
            @csrf
            <h3 style="color: #27ae60; margin-bottom: 15px;">🍴 بيانات المطعم الأساسية</h3>

            <div class="form-row-unified">
                <div class="input-group-unified">
                    <label>اسم المطعم</label>
                    <input type="text" name="EntityName" required placeholder="مثال: مطعم السعادة">
                </div>
                <div class="input-group-unified">
                    <label>جهة الاتصال</label>
                    <input type="text" name="ContactPerson" required placeholder="اسم الشخص المسؤول">
                </div>
            </div>

            <div class="form-row-unified">
                <div class="input-group-unified">
                    <label>العنوان</label>
                    <input type="text" name="Address" required placeholder="العنوان التفصيلي للمقر">
                </div>
                <div class="input-group-unified">
                    <label>رقم الترخيص</label>
                    <input type="text" name="LicenseNumber" required placeholder="رقم السجل التجاري">
                </div>
            </div>

            <button type="submit" class="submit-next-btn">أكمل التسجيل</button>
        </form>
    </div>

    <div class="image-side">
        <div class="image-content-wrapper">
            <h2 style="color: #27ae60; margin-bottom: 20px; text-align:center;">معاً لنحفظ النعمة<br>وننشر الخير</h2>

            <img src="{{ asset('images/pngtree-food-donation-drive-helpers-packing-donations-on-transparent-background-png-image_12498977.png') }}"
                 alt="صورة تبرعات" class="hero-img-unified">

            <div style="display: flex; gap: 12px; justify-content: center;">
                <div style="background: white; padding: 10px 15px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">🍴 للمطاعم</div>
                <div style="background: white; padding: 10px 15px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">❤ للجمعيات</div>
            </div>
        </div>
    </div>

</div>
@endsection
