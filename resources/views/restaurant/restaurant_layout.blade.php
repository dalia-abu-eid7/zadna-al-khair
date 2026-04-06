<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة تحكم المطعم') | زادنا الخير</title>

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add-donation.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-green: #2d6a4f;
            --light-green: #d8f3dc;
            --accent-green: #40916c;
            --text-color: #1b4332;
            --sidebar-width: 290px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Cairo', sans-serif; }
        body { background-color: #f8f9fa; direction: rtl; overflow-x: hidden; }

        .layout { display: flex; min-height: 100vh; }

        /* Sidebar Style */
        .sidebar {
            width: var(--sidebar-width);
            background-color: #ffffff;
            border-left: 1px solid #eaeaea;
            padding: 30px;
            display: flex;
            flex-direction: column;
            position: fixed;
            right: 0; top: 0; height: 100vh;
            z-index: 1000;
            box-shadow: -4px 0 15px rgba(0,0,0,0.03);
        }

        .brand { text-align: center; margin-bottom: 40px; padding-bottom: 25px; border-bottom: 1px solid #f0f0f0; }
        .brand img.logo { width: 90px; margin-bottom: 10px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.07)); }
        .brand h3 { color: var(--primary-green); font-size: 1.4rem; font-weight: 800; }

        .menu { list-style: none; flex-grow: 1; }
        .menu li { margin-bottom: 8px; }
        .menu a {
            display: flex; align-items: center; padding: 14px 20px;
            border-radius: 14px; text-decoration: none; color: #495057;
            font-weight: 600; transition: 0.3s; gap: 12px;
        }
        .menu li.active a, .menu a:hover { background-color: #f0fdf4; color: var(--primary-green); }
        .menu li.active a { border-right: 5px solid var(--primary-green); }

        /* Content Area */
        .content {
            margin-right: var(--sidebar-width);
            padding: 40px;
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
        }

        /* Welcome Header Style */
        .welcome-header {
            margin-bottom: 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            padding: 20px 25px;
            border-radius: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            border: 1px solid #f0f0f0;
        }
        .welcome-text h2 { color: var(--text-color); font-weight: 800; font-size: 1.5rem; }
        .welcome-text p { color: #666; font-size: 0.9rem; margin-top: 4px; }
        .date-badge {
            background: var(--light-green);
            color: var(--primary-green);
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
        }

        /* Profile & Logout */
        .profile-card {
            background-color: #f9fdfb; border: 1px solid #e9f5f0;
            border-radius: 18px; padding: 15px; display: flex;
            align-items: center; gap: 12px; margin-bottom: 15px;
        }
        .profile-card img { width: 45px; height: 45px; border-radius: 12px; object-fit: cover; }

        .logout-btn {
            width: 100%; padding: 12px; background-color: #fff1f2;
            color: #e11d48; border: none; border-radius: 12px;
            font-weight: 700; cursor: pointer; transition: 0.3s;
        }
        .logout-btn:hover { background-color: #ffe4e6; }
    </style>
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <a href="{{ url('/') }}" style="text-decoration: none;">
                <div class="brand">
                    <img src="{{ asset('images/img.logo.png') }}" alt="Logo" class="logo">
                    <h3>زادنا الخير</h3>
                    <p>لوحة تحكم المطعم</p>
                </div>
            </a>

            <ul class="menu">
                <li class="{{ Request::is('*dashboard*') ? 'active' : '' }}">
                    <a href="{{ route('restaurant.dashboard') }}">📊 لوحة التحكم</a>
                </li>
                <li class="{{ Request::is('*add-donation*') ? 'active' : '' }}">
                    <a href="{{ route('restaurant.add_donation') }}">🍲 إضافة تبرع</a>
                </li>
                <li class="{{ Request::is('*donations-list*') ? 'active' : '' }}">
                    <a href="{{ route('restaurant.donations_list') }}">📜 سجل التبرعات</a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <div class="profile-card">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=d8f3dc&color=2d6a4f" alt="User">
                    <div>
                        <strong style="display:block; font-size: 0.9rem; color: var(--text-color);">{{ Auth::user()->name }}</strong>
                        <span style="font-size: 0.75rem; color: #888;">{{ Auth::user()->email }}</span>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">تسجيل الخروج</button>
                </form>
            </div>
        </aside>

        <main class="content">
            <div class="welcome-header">
                <div class="welcome-text">
                    <h2>مرحباً، {{ Auth::user()->name }} 👋</h2>
                    <p>إليك نظرة شاملة على نشاط مطعمك في منصة زادنا.</p>
                </div>
                <div class="date-badge">
                    📅 {{ now()->translatedFormat('l، j F Y') }}
                </div>
            </div>

            @yield('restaurant_content')
        </main>
    </div>
</body>
</html>
