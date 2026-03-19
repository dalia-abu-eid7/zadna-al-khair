<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة تحكم زادنا الخير</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/entities.css') }}" >
        <link rel="stylesheet" href="{{ asset('css/users.css') }}" >
        <link rel="stylesheet" href="{{ asset('"css/donations.css') }}" >



    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    @yield('extra_css')
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
    {{-- لوحة التحكم --}}
    <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}">لوحة التحكم</a>
    </li>

    {{-- إدارة الكيانات --}}
    <li class="{{ request()->routeIs('admin.entities') ? 'active' : '' }}">
        <a href="{{ route('admin.entities') }}">إدارة الكيانات</a>
    </li>

    {{-- إدارة المستخدمين - (تقدري تربطيها لما تجهزي الكنترولر تبعها) --}}
    <li class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
        <a href="{{ route('admin.users') }}">إدارة المستخدمين</a>
    </li>

    {{-- سجل التبرعات --}}
    <li class="{{ request()->routeIs('admin.donations') ? 'active' : '' }}">
        <a href="{{ route('admin.donations') }}">سجل التبرعات</a>
    </li>


</ul>
            <div class="profile">
                <div class="profile-info">
                    <img src="{{ asset('images/user.png') }}" alt="user">
                    <div>
                        <strong>{{ Auth::user()->name }}</strong>
                        <span>مدير النظام</span>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout" style="background:none; border:none; color:white; cursor:pointer;">⎋</button>
                </form>
            </div>
        </aside>

        <main class="content">
            <div class="top-bar">
                <button class="export-btn">تصدير التقرير</button>
                <div class="user-box">
                    <span>{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background:none; border:none; cursor:pointer;">⎋</button>
                    </form>
                </div>
            </div>

            @yield('admin_content')

        </main>
    </div>
</body>
</html>
