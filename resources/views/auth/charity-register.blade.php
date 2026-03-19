<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <title>زادنا الخير - تسجيل جمعية</title>
  <link rel="stylesheet" href="{{ asset('css/log-in4.css') }}">
</head>

<body>

  <div class="page">

    <div class="right">

      <a href="{{ url('/') }}">
        <div class="logo">
          <img src="{{ asset('images/img.logo.png') }}" class="heart-icon"> <span>زادنا الخير</span>
        </div>
      </a>

      <h2>إنشاء حساب جديد</h2>
      <p class="subtitle">انضم إلينا في مهمتنا لحفظ النعمة ومساعدة</p>

      <div class="auth-links">
        <a href="{{ route('login') }}" class="auth-link secondary ">تسجيل دخول</a>
        <a href="{{ route('restaurant.register') }}" class="auth-link primary ">حساب جديد</a>
      </div>

      <div class="account-type">
        <a href="{{ route('charity.register') }}" class="type charity active">
          <span class="icon">♡</span>
          <span>جمعية خيرية</span>
        </a>

        <a href="{{ route('restaurant.register') }}" class="type restaurant">
          <span class="icon">🍴</span>
          <span>مطعم</span>
        </a>
      </div>

      <form action="{{ route('charity.register.step2') }}" method="POST">
        @csrf
        <div class="form-box">
          <h3>♡ بيانات الجمعية</h3>

          <div class="form-row">
            <div class="input">
              <label>اسم الجمعية</label>
              <input type="text" name="EntityName" required placeholder="مثال: الجمعية الاحسان">
            </div>

            <div class="input">
              <label>جهة الاتصال</label>
              <input type="text" name="ContactPerson" required placeholder="اسم جهة الاتصال">
            </div>
          </div>

          <div class="form-row">
            <div class="input">
              <label>العنوان</label>
              <input type="text" name="Address" required placeholder="العنوان التفصيلي للمقر الرئيسي">
            </div>

            <div class="input">
              <label>رقم الترخيص</label>
              <input type="text" name="LicenseNumber" required placeholder="رقم السجل التجاري">
            </div>
          </div>
        </div>

        <button type="submit" class="next-btn" style="width: 100%; border: none; cursor: pointer;">التالي</button>
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
