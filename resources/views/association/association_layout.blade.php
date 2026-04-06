<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | زادنا الخير</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary-green: #2d6a4f; --sidebar-width: 280px; --bg-light: #f8f9fa; --danger-red: #e11d48; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Cairo', sans-serif; }
        body { background-color: var(--bg-light); direction: rtl; overflow-x: hidden; }

        .mobile-header { display: none; background: #fff; padding: 15px 20px; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1100; }
        .menu-toggle-btn { background: var(--primary-green); color: white; border: none; padding: 8px 12px; border-radius: 8px; cursor: pointer; }

        .sidebar { width: var(--sidebar-width); background: #ffffff; border-left: 1px solid #eee; height: 100vh; position: fixed; right: 0; top: 0; display: flex; flex-direction: column; padding: 25px; z-index: 1200; transition: 0.3s; }
        .brand-link { text-decoration: none; text-align: center; padding-bottom: 20px; border-bottom: 1px solid #f5f5f5; margin-bottom: 30px; display: block; }
        .brand-link img { width: 60px; margin-bottom: 5px; }
        .brand-link h3 { color: var(--primary-green); font-size: 1.2rem; font-weight: 800; }

        .menu { list-style: none; flex-grow: 1; }
        .menu li { margin-bottom: 8px; }
        .menu a { display: flex; align-items: center; padding: 12px 15px; border-radius: 12px; text-decoration: none; color: #555; font-weight: 600; transition: 0.3s; gap: 10px; }
        .menu li.active a, .menu a:hover { background: #f0fdf4; color: var(--primary-green); }

        .main-content { margin-right: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); padding: 40px; min-height: 100vh; }

        .profile-section { margin-top: auto; background: #fdfdfd; padding: 15px; border-radius: 15px; border: 1px solid #f0f0f0; }
        .user-info { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
        .avatar-circle { width: 40px; height: 40px; background: #e8f5e9; color: var(--primary-green); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }

        .logout-btn { width: 100%; padding: 10px; background: #fff1f2; color: var(--danger-red); border: 1px solid #ffe4e6; border-radius: 10px; font-weight: 700; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .logout-btn:hover { background: var(--danger-red); color: white; }

        @media (max-width: 992px) {
            .mobile-header { display: flex; }
            .sidebar { right: -280px; }
            .sidebar.active { right: 0; }
            .main-content { margin-right: 0; width: 100%; padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="mobile-header">
        <span style="font-weight: 800; color: var(--primary-green);">زادنا الخير</span>
        <button class="menu-toggle-btn" onclick="document.getElementById('sidebar').classList.toggle('active')">☰</button>
    </div>

    <div class="layout-wrapper">
        <aside class="sidebar" id="sidebar">
            <a href="{{ url('/') }}" class="brand-link">
                <img src="{{ asset('images/img.logo.png') }}" alt="Logo">
                <h3>زادنا الخير</h3>
            </a>
            <ul class="menu">
                <li class="{{ Request::is('*dashboard*') ? 'active' : '' }}"><a href="{{ route('association.dashboard') }}">📊 لوحة التحكم</a></li>
                <li class="{{ Request::is('*available-donations*') ? 'active' : '' }}"><a href="{{ route('association.available_donations') }}">🍲 التبرعات المتاحة</a></li>
                <li class="{{ Request::is('*accepted-donations*') ? 'active' : '' }}"><a href="{{ route('association.accepted_donations') }}">✅ التبرعات المقبولة</a></li>
                <li class="{{ Request::is('*partner-restaurants*') ? 'active' : '' }}"><a href="{{ route('association.partner_restaurants') }}">🍽️ الشركاء</a></li>
            </ul>
            <div class="profile-section">
                <div class="user-info">
                    <div class="avatar-circle">👤</div>
                    <div>
                        <p style="font-weight: 700; font-size: 0.85rem; margin:0;">{{ Auth::user()->name }}</p>
                        <p style="font-size: 0.7rem; color: #888; margin:0;">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn"> تسجيل خروج</button>
                </form>
            </div>
        </aside>

        <main class="main-content">
            <div style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
                <h2 style="color: #333; font-weight: 800;">مرحباً، {{ Auth::user()->name }} 👋</h2>
                <span style="background: white; padding: 5px 15px; border-radius: 20px; font-size: 0.85rem; color: #666; border: 1px solid #eee;">{{ now()->format('Y-m-d') }}</span>
            </div>
            @yield('association_content')
        </main>
    </div>
</body>
</html>
