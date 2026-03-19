<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

      <h2>إنشاء حساب جديد</h2>
      <p class="subtitle">انضم إلينا في مهمتنا لحفظ النعمة ومساعدة المحتاجين</p>

      <div class="auth-links">
        <a href="{{ route('login') }}" class="auth-link secondary">تسجيل دخول</a>
        <a href="{{ route('restaurant.register') }}" class="auth-link primary">حساب جديد</a>
      </div>

      <div class="account-type">
        <a href="{{ route('charity.register') }}" class="type charity">
          <span class="icon">♡</span>
          <span>جمعية خيرية</span>
        </a>

        <a href="{{ route('restaurant.register') }}" class="type restaurant active">
          <span class="icon">🍴</span>
          <span>مطعم</span>
        </a>
      </div>
      @if ($errors->any())
    <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
        <strong>فيه حقول ناقصة أو غلط:</strong>
        <ul>
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
        <h3>بيانات المسؤول</h3>

        <input type="text" name="name" placeholder="مثال: أحمد أبو شامة" required>
        <input type="email" name="email" placeholder="example@domain.com" required>
        <input type="text" name="PhoneNumber" placeholder="00972xxxxxxxx" required>
        <input type="password" name="password" placeholder="••••••••" required>

        <button type="submit" class="btn submit" style="border:none; cursor:pointer; width:100%;">إنشاء حساب</button>
      </form>

    </div>

    <div class="left-section">
      <img src="{{ asset('images/pngtree-food-donation-drive-helpers-packing-donations-on-transparent-background-png-image_12498977.png') }}"
        alt="صورة تبرعات" class="hero-img">

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
