<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>زادنا الخير ❤</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add-donation.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-green: #27ae60;
            --dark-green: #219150;
            --danger-red: #e74c3c;
        }

        .navbar {
            padding: 5px 5%;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo-link {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: 0.3s;
        }

        .logo-link:hover { opacity: 0.8; }
        .logo-link img { height: 50px; width: auto; }
        .logo-link span { font-size: 1.3rem; font-weight: 800; color: var(--primary-green); }

        .nav-menu { display: flex; align-items: center; gap: 20px; }
        .nav-links a {
            margin: 0 10px;
            text-decoration: none;
            color: #444;
            font-size: 0.95rem;
            font-weight: 600;
            transition: 0.3s;
        }
        .nav-links a:hover { color: var(--primary-green); }

        .auth-buttons { display: flex; align-items: center; gap: 15px; }

        .btn-logout {
            background: none;
            border: 1px solid #fbcaca;
            color: var(--danger-red);
            padding: 6px 15px;
            border-radius: 50px;
            cursor: pointer;
            font-family: 'Cairo';
            font-weight: 700;
            font-size: 0.85rem;
            transition: 0.3s;
        }
        .btn-logout:hover { background: #fff5f5; border-color: var(--danger-red); }

        .user-welcome-text {
            font-size: 0.9rem;
            color: #636e72;
            font-weight: 600;
        }

        .signup {
            background-color: var(--primary-green);
            color: white !important;
            padding: 8px 22px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 700;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(39, 174, 96, 0.2);
        }
        .signup:hover { background-color: var(--dark-green); transform: translateY(-2px); }

        .menu-toggle { display: none; flex-direction: column; gap: 5px; cursor: pointer; }
        .menu-toggle span { width: 28px; height: 3px; background: var(--primary-green); border-radius: 2px; }

        .footer { background-color: #f4f7f6; padding: 50px 5% 0; border-top: 1px solid #e0edec; }
        .footer-bottom-wrapper { padding: 20px 0; border-top: 1px solid #eee; margin-top: 30px; }
        .footer-bottom { text-align: center; color: #64748b; font-size: 0.9rem; }

        @media (max-width: 992px) {
            .menu-toggle { display: flex; }
            .nav-menu {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 80px;
                right: 0;
                width: 100%;
                background: white;
                padding: 20px;
                box-shadow: 0 5px 10px rgba(0,0,0,0.1);
            }
            .nav-menu.active { display: flex; }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <div class="logo">
            <a href="{{ url('/') }}" class="logo-link">
                <img src="{{ asset('images/img.logo.png') }}" alt="شعار زادنا الخير">
                <span>زادنا الخير</span>
            </a>
        </div>

        <div class="menu-toggle" id="mobile-menu">
            <span></span><span></span><span></span>
        </div>

        <div class="nav-menu" id="nav-menu">
            <div class="nav-links">
                <a href="{{ url('/') }}#hero">الرئيسية</a>
                <a href="{{ url('/') }}#why-us">عن المنصة</a>
                <a href="{{ url('/') }}#Faq">الأسئلة الشائعة</a>
                <a href="{{ url('/') }}#contact">تواصل معنا</a>
            </div>

            <div class="auth-buttons">
                @guest
                    @if(!Route::is('login') && !Route::is('restaurant.register')&& !Route::is('restaurant.register.step2') && !Route::is('charity.register') && !Route::is('charity.register.step2'))
                        <a href="{{ route('login') }}" class="login" style="text-decoration: none; color: #333; font-weight: 600;">تسجيل دخول</a>
                        <a href="{{ route('restaurant.register') }}" class="signup">حساب جديد</a>
                    @else
                        <a href="{{ url('/') }}" style="text-decoration: none; color: var(--primary-green); font-weight: 700; font-size: 0.9rem;">🏠 العودة للرئيسية</a>
                    @endif
                @endguest

                @auth
                    <span class="user-welcome-text">مرحباً، <b>{{ Auth::user()->name }}</b></span>

                    @if(Auth::user()->RoleID == 1)
                        <a href="{{ route('admin.dashboard') }}" class="signup">لوحة الإدارة</a>
                    @elseif(Auth::user()->RoleID == 2)
                        <a href="{{ route('association.dashboard') }}" class="signup">حسابي</a>
                    @else
                        <a href="{{ url('restaurant/dashboard') }}" class="signup">حسابي</a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout">الخروج من الحساب</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-content" style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 20px;">
            <div class="footer-col" style="max-width: 300px;">
                <h3 style="color: var(--primary-green); margin-bottom: 15px;">زادنا الخير 💚</h3>
                <p style="color: #636e72; font-size: 0.9rem; line-height: 1.6;">
                    منصة رقمية لتعزيز التكافل الاجتماعي وتسهيل وصول المساعدات في فلسطين.
                </p>
            </div>
        </div>
        <div class="footer-bottom-wrapper">
             <div class="footer-bottom">
                 <p>© زادنا الخير {{ date('Y') }}</p>
             </div>
        </div>
    </footer>

    <script>
        const menuToggle = document.getElementById('mobile-menu');
        const navMenu = document.getElementById('nav-menu');

        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            const spans = menuToggle.getElementsByTagName('span');
            if(navMenu.classList.contains('active')){
                spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(7px, -7px)';
            } else {
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });
    </script>
</body>
</html>
