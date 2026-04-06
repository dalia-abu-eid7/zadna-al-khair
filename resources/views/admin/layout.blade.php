<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم زادنا الخير | الإدارة</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --admin-green: #2D6A4F;
            --bg-light: #f4f7f6;
            --sidebar-white: #ffffff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --danger: #dc2626;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: var(--bg-light);
            margin: 0;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        .layout {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* --- السايد بار --- */
        .sidebar {
            width: 280px;
            background-color: var(--sidebar-white);
            border-left: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            padding: 30px 20px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.02);
            transition: var(--transition);
            position: sticky;
            top: 0;
            height: 100vh;
            z-index: 1200;
        }

        /* تعديل البراند ليكون رابطاً نظيفاً */
        .brand { text-align: center; margin-bottom: 40px; }
        .brand a { text-decoration: none !important; color: inherit !important; display: block; }
        .brand a:hover { opacity: 0.8; }
        .brand img.logo { width: 90px; margin-bottom: 10px; }
        .brand h3 { color: var(--admin-green); font-size: 1.4rem; margin: 0; font-weight: 800; }

        .menu { list-style: none; padding: 0; margin: 0; flex-grow: 1; }
        .menu li { margin-bottom: 8px; }
        .menu a {
            color: var(--text-muted);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            border-radius: 12px;
            font-weight: 600;
            transition: var(--transition);
        }

        .menu li.active a, .menu a:hover {
            background-color: #f0fdf4;
            color: var(--admin-green);
        }

        .profile-box {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 16px;
            border: 1px solid #edf2f7;
            margin-top: 20px;
        }
        .profile-info { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .profile-info img { width: 40px; height: 40px; border-radius: 10px; }

        .logout-btn {
            width: 100%;
            background-color: #fee2e2;
            color: var(--danger);
            border: none;
            padding: 10px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Cairo';
            transition: 0.2s;
        }
        .logout-btn:hover { background-color: #fecaca; }

        /* --- المحتوى الرئيسي --- */
        .content {
            flex: 1;
            padding: 30px;
            max-width: 100%;
            transition: var(--transition);
            min-width: 0;
        }

        .top-bar {
            background: white;
            padding: 15px 25px;
            border-radius: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }

        /* هيدر الموبايل */
        .mobile-header {
            display: none;
            background: white;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1100;
        }

        /* تعديل رابط اللوجو في الموبايل */
        .mobile-logo-link {
            text-decoration: none !important;
            color: inherit !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .menu-btn {
            background: var(--admin-green);
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 5px 12px;
            border-radius: 8px;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 1150;
        }

        /* التحسينات المتجاوبة */
        @media (max-width: 992px) {
            .mobile-header { display: flex; }
            .sidebar {
                position: fixed;
                right: -280px;
                top: 0;
                transition: 0.4s ease;
            }
            .sidebar.active { right: 0; }
            .sidebar-overlay.active { display: block; }
            .top-bar { display: none; }
            .content { padding: 20px 15px; }
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>
    @yield('extra_css')
</head>
<body>

    <div class="mobile-header">
        <a href="{{ url('/') }}" class="mobile-logo-link">
            <img src="{{ asset('images/img.logo.png') }}" alt="الشعار" style="width: 35px;">
            <span style="font-weight: 800; color: var(--admin-green);">زادنا الخير</span>
        </a>
        <button class="menu-btn" onclick="toggleSidebar()">☰</button>
    </div>

    <div class="layout">
        <div class="sidebar-overlay" id="overlay" onclick="toggleSidebar()"></div>

        <aside class="sidebar" id="sidebar">
            <div class="brand">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/img.logo.png') }}" alt="الشعار" class="logo">
                    <h3>زادنا الخير</h3>
                </a>
            </div>

            <ul class="menu">
                <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">📊 لوحة التحكم</a>
                </li>
                <li class="{{ request()->routeIs('admin.entities') ? 'active' : '' }}">
                    <a href="{{ route('admin.entities') }}">🏢 إدارة الكيانات</a>
                </li>
                <li class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <a href="{{ route('admin.users') }}">👥 إدارة المستخدمين</a>
                </li>
                <li class="{{ request()->routeIs('admin.donations') ? 'active' : '' }}">
                    <a href="{{ route('admin.donations') }}">📜 سجل التبرعات</a>
                </li>
            </ul>

            <div class="profile-box">
                <div class="profile-info">
                    <div>
                        <strong>{{ Auth::user()->name }}</strong>
                        <span style="font-size: 0.8rem; color: var(--text-muted); display: block;">إدارة النظام</span>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">تسجيل الخروج</button>
                </form>
            </div>
        </aside>

        <main class="content">
            <div class="top-bar">
                <div style="font-weight: 700; color: var(--admin-green);">أهلاً بك، {{ Auth::user()->name }} 👋</div>
                <div style="font-size: 0.85rem; color: var(--text-muted);">{{ now()->format('l، d F Y') }}</div>
            </div>

            @yield('admin_content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('overlay').classList.toggle('active');
        }
    </script>
</body>
</html>
