<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة تحكم المطعم - زادنا الخير</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add-donation.css') }}">

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
                <li class="{{ Request::is('restaurant/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('restaurant.dashboard') }}">لوحة التحكم</a>
                </li>
                <li class="{{ Request::is('restaurant/add-donation') ? 'active' : '' }}">
                    <a href="{{ route('restaurant.add_donation') }}">إضافة تبرع جديد</a>
                </li>
                <li class="{{ Request::is('restaurant/donations-list') ? 'active' : '' }}">
                    <a href="{{ route('restaurant.donations_list') }}">سجل التبرعات</a>
                </li>
            </ul>

            <div class="profile">
                <div class="profile-info">
                    <img src="" alt="صورة المستخدم">
                    <div>
                        <strong>{{ Auth::user()->name }}</strong>
                        <span>{{ Auth::user()->email }}</span>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout" style="background:none; border:none; color:white; cursor:pointer; font-size: 20px;">⎋</button>
                </form>
            </div>
        </aside>

        <main class="content">
            @yield('restaurant_content')
        </main>
    </div>
</body>
</html>
