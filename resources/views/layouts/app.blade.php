<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>زادنا الخير ❤</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add-donation.css') }}">


    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">

        <div class="logo">
            <img src="{{asset('images/img.logo.png')}}" alt="شعار زادنا الخير">
            <span>زادنا الخير</span>
        </div>

<div class="nav-links">
    <a href="{{ url('/') }}#hero">الرئيسية</a>
    <a href="{{ url('/') }}#why-us">عن المنصة</a>
    <a href="{{ url('/') }}#Faq">الأسئلة الشائعة</a>
    <a href="{{ url('/') }}#contact">تواصل معنا</a>
</div>

<div class="auth-buttons">
    <a href="{{ route('login') }}" class="login">تسجيل دخول</a>
    <a href="{{ route('restaurant.register') }}" class="signup">إنشاء حساب</a>
</div>

    </nav>



    @yield('content')





    <!-- Footer -->
    <footer class="footer">
        <div class="container footer-content">

            <!-- About -->
            <div class="    ">
                <div class="footer-logo">
                    <span class="heart">🤍</span>
                    <h3>زادنا الخير</h3>
                </div>
                <p class="footer-desc">
                    منصة رقمية تهدف لتعزيز التكافل الاجتماعي
                    وتسهيل وصول المساعدات لمستحقيها بكل شفافية.
                </p>

                <div class="social-icons">
                    <img src="">
                    <img src="">
                    <img src="">
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-col">
                <h4 class="footer-title greon">روابط سريعة</h4>
                <ul>
                    <li><a href="index.html">الرئيسية</a></li>
                    <li><a href="index.html#why-us">عن المنصة</a></li>
                    <li><a href="index.html#Faq">الأسئلة الشائعة</a></li>
                    <li><a href="index.html#contact">تواصل معنا</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-col">
                <h4 class="footer-title lime">معلومات التواصل</h4>
                <ul class="contact-list">
                    <li>📍 فلسطين - غزة</li>
                    <li>📞 0598082027</li>
                    <li>✉️ Zadnaelkahir@gmail.com</li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="footer-col">
                <h4 class="footer-title orange">انضم إلينا</h4>
                <div class="newsletter">
                    <input type="email" placeholder="بريدك الإلكتروني">
                    <button>اشترك</button>
                </div>
            </div>

        </div>

        <div class="footer-bottom-wrapper">
            <div class="container footer-bottom">
                <p>© جميع الحقوق محفوظة 2025</p>

                <div class="footer-links">
                    <a href="#">شروط الاستخدام</a>
                    <a href="#">سياسة الخصوصية</a>
                </div>
            </div>
        </div>

        </div>
    </footer>

</body>

</html>
