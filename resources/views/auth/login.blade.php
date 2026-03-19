<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>زادنا الخير - تسجيل الدخول</title>
    <link rel="stylesheet" href="{{ asset('css/sign-up.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">

        <div class="right-section">

            <div class="logo-wrapper">
                <a href="{{ url('/') }}" class="logo-link">
                    <img src="{{ asset('images/img.logo.png') }}" class="heart-icon" alt="لوجو">
                    <span>زادنا الخير</span>
                </a>
            </div>

            <h1>تسجيل الدخول</h1>
            <p class="subtitle">مرحباً بعودتك، رجاءً ادخل بياناتك للمتابعة</p>

            <div class="auth-links">
                <a href="{{ route('login') }}" class="auth-link primary">تسجيل دخول</a>
                <a href="{{ route('restaurant.register') }}" class="auth-link secondary">حساب جديد</a>
            </div>
            @if (session('success'))
    <div style="background-color: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold;">
        ✨ {{ session('success') }}
    </div>
@endif


@if ($errors->any())
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <ul style="margin: 0;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        {{ session('error') }}
    </div>
@endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <label>البريد الإلكتروني</label>
                <input type="email" name="email" placeholder="example@gmail.com" value="{{ old('email') }}" required autofocus>

                <label>كلمة المرور</label>
                <input type="password" name="password" placeholder="••••••••" required>

                <button type="submit" class="login-btn">تسجيل الدخول</button>
            </form>
        </div>

        <div class="left-section">
            <div class="overlay" >
                <h2>معاً لنحفظ النعمة<br>وننشر الخير</h2><br>

                <img src="{{ asset('images/pngtree-food-donation-drive-helpers-packing-donations-on-transparent-background-png-image_12498977.png') }}"
                     alt="صورة تبرعات" class="hero-img">

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
