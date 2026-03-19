@extends('admin.layout')

@section('admin_content')
    <h1 class="page-title">لوحة التحكم</h1>
    <p class="page-sub">نظرة عامة على نشاط النظام والطلبات المعلقة</p>

    <div class="cards">
        <div class="card">
            <p>إجمالي المستخدمين</p>
            <h2>{{ number_format($totalUsers) }}</h2>
            <small class="success">مستخدم مسجل</small>
        </div>
        <div class="card">
            <p>إجمالي التبرعات</p>
            <h2>{{ number_format($totalDonations) }}</h2>
            <small class="success">عملية تبرع</small>
        </div>
        <div class="card">
            <p>إجمالي الكيانات</p>
            <h2>{{ $totalEntities }}</h2>
            <small>مطاعم وجمعيات</small>
        </div>
        <div class="card">
            <p>الكيانات المعلقة</p>
            <h2 style="color: #e74c3c;">{{ $pendingEntitiesCount }}</h2>
            <small class="danger">بحاجة مراجعة وتفعيل</small>
        </div>
    </div>

    <div class="bottom">
        <div class="box">
            <h3>المهام العاجلة <span class="badge" style="background: #e74c3c;">{{ $pendingEntitiesCount }}</span></h3>
            <ul class="tasks">
                @forelse($latestPending as $user)
                    <li class="red">
                        <strong>{{ $user->name }}</strong> ينتظر التفعيل
                        <span style="font-size: 0.8em; color: #666;">
                            ({{ $user->RoleID == 3 ? 'جمعية خيرية' : 'مطعم' }})
                        </span>
                    </li>
                @empty
                    <li class="green">لا يوجد طلبات تسجيل معلقة حالياً</li>
                @endforelse

                <li class="yellow">هناك تبرع كبير بانتظار التأكيد</li>
                <li class="blue">تحديث سياسة الخصوصية السنوية</li>
            </ul>
        </div>

        <div class="box">
            <h3 class="center">مقارنة بين تسجيل المستخدمين والكيانات</h3>
            <div class="compare">
                <div>
                    <p>المستخدمين</p>
                    <h2>{{ $totalUsers }}</h2>
                </div>
                <div class="bar">
                    @php
                        $total = $totalUsers + $totalEntities;
                        $userWidth = $total > 0 ? ($totalUsers / $total) * 100 : 50;
                        $entityWidth = $total > 0 ? ($totalEntities / $total) * 100 : 50;
                    @endphp
                    <span class="users" style="width: {{ $userWidth }}%; background-color: #3498db;"></span>
                    <span class="orgs" style="width: {{ $entityWidth }}%; background-color: #2ecc71;"></span>
                </div>
                <div>
                    <p>الكيانات</p>
                    <h2>{{ $totalEntities }}</h2>
                </div>
            </div>
            <p style="font-size: 0.8em; text-align: center; margin-top: 15px; color: #777;">
                الأزرق: مستخدمين | الأخضر: كيانات (مطاعم/جمعيات)
            </p>
        </div>
    </div>
@endsection
