<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <title>إنشاء حساب | زادنا الخير</title>
  <link rel="stylesheet" href="{{ asset('css/log-in2.css') }}">
</head>

<body>

  <div class="container">
    <div class="right-section">
      <a href="{{ url('/') }}">
        <div class="logo">
          <img src="{{ asset('images/img.logo.png') }}" class="heart-icon"> <span>زادنا الخير</span>
        </div>
      </a>
      <h2>إكمال إنشاء الحساب</h2>
      <p class="subtitle">الخطوة الأخيرة: بيانات الحساب والمسؤول</p>

      <div class="auth-links">
        <a href="{{ route('login') }}" class="auth-link secondary ">تسجيل دخول</a>
        <a href="{{ route('restaurant.register') }}" class="auth-link primary ">حساب جديد</a>
      </div>

      <form action="{{ route('charity.register.post') }}" method="POST" class="form">
        @csrf

        <input type="hidden" name="EntityName" value="{{ $data['EntityName'] ?? '' }}">
        <input type="hidden" name="ContactPerson" value="{{ $data['ContactPerson'] ?? '' }}">
        <input type="hidden" name="Address" value="{{ $data['Address'] ?? '' }}">
        <input type="hidden" name="LicenseNumber" value="{{ $data['LicenseNumber'] ?? '' }}">

        <h3>بيانات الدخول والمسؤول</h3>

        <input type="text" name="name" placeholder="اسم المسؤول عن الحساب" required>
        <input type="email" name="email" placeholder="البريد الإلكتروني الرسمي" required>

        <div style="display: flex; gap: 10px;">
             <input type="password" name="password" placeholder="كلمة المرور" required style="width: 50%;">
        </div>

        <button type="submit" class="btn submit" style="width: 100%; border: none; cursor: pointer; background-color: #2ecc71; color: white; padding: 12px; border-radius: 8px; font-size: 16px;">
            إنشاء حساب الجمعية
        </button>
      </form>

    </div>

    <div class="left-section">
      <img src="{{ asset('images/pngtree-food-donation-drive-helpers-packing-donations-on-transparent-background-png-image_12498977.png') }}" alt="صورة تبرعات" class="hero-img">

      <div class="overlay">
        <h2>معاً لنحفظ النعمة<br>وننشر الخير</h2>
        <div class="cards">
          <div class="card">
            <span class="icon">🍴</span>
            <h4>للمطاعم</h4>
            <p>إدارة التبرعات بسهولة وتوثيق المساهمة المجتمعية</p>
          </div>
          <div class="card">
            <span class="icon">❤</span>
            <h4>للجمعيات</h4>
            <p>استقبال التبرعات وتوزيعها على المستفيدين بسرعة</p>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
