<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'زادنا الخير - الجمعية')</title>
    <link rel="stylesheet" href="{{ asset('css/association-dashboard.css') }}">


    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
              <a href="{{ url('/')  }}">
                <div class="brand">
                     <img src="{{ asset('images/img.logo.png') }}" alt="شعار زادنا الخير" class="logo">
                    <h3>زادنا الخير</h3>
                    <p>لوحة تحكم المدير</p>
                </div>
            </a>

            <ul class="menu">
                <li class="{{ request()->routeIs('association.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('association.dashboard') }}">▦ لوحة التحكم</a>
                </li>
                <li class="{{ request()->routeIs('association.available_donations') ? 'active' : '' }}">
                    <a href="{{ route('association.available_donations') }}">♡ التبرعات المتاحة</a>
                </li>
                <li class="{{ request()->routeIs('association.accepted_donations') ? 'active' : '' }}">
                    <a href="{{ route('association.accepted_donations') }}">✔ التبرعات المقبولة</a>
                </li>
            </ul>

            <div class="profile">
                <div class="profile-info">
                    <div class="avatar">👤</div>
                    <div>
                        <strong>{{ auth()->user()->name }}</strong>
                        <span>{{ auth()->user()->email }}</span>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout" style="background:none; border:none; cursor:pointer;">⎋</button>
                </form>
            </div>
        </aside>

        <main class="content">
            @yield('association_content')
        </main>
    </div>
</body>
</html>
