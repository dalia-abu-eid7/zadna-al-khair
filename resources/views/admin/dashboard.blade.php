@extends('admin.layout')

@section('admin_content')
<div class="dashboard-wrapper">
    <div class="dash-header">
        <div class="text-side">
            <h1 class="main-title">لوحة التحكم</h1>
            <p class="sub-title">مرحباً بك في نظام زادنا الخير، إليك ملخص النشاط اليومي</p>
        </div>
        <a href="{{ route('admin.export.stats') }}" class="btn-export">
            📊 تصدير تقرير الإحصائيات (Excel)
        </a>
    </div>

    <div class="stats-grid">
        <a href="{{ route('admin.users') }}" class="stat-card-link">
            <div class="stat-card">
                <div class="icon-circle user-bg">👤</div>
                <div class="stat-info">
                    <p>إجمالي المستخدمين</p>
                    <h3>{{ number_format($totalUsers) }}</h3>
                    <span class="trend-up">مستخدم مسجل</span>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.donations') }}" class="stat-card-link">
            <div class="stat-card">
                <div class="icon-circle donation-bg">📦</div>
                <div class="stat-info">
                    <p>إجمالي التبرعات</p>
                    <h3>{{ number_format($totalDonations) }}</h3>
                    <span class="trend-up">عملية تبرع</span>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.entities') }}" class="stat-card-link">
            <div class="stat-card">
                <div class="icon-circle entity-bg">🏢</div>
                <div class="stat-info">
                    <p>إجمالي الكيانات</p>
                    <h3>{{ $totalEntities }}</h3>
                    <span class="trend-neutral">مطاعم وجمعيات</span>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.entities') }}?status=pending" class="stat-card-link">
            <div class="stat-card pending-card">
                <div class="icon-circle alert-bg">⚠️</div>
                <div class="stat-info">
                    <p>الكيانات المعلقة</p>
                    <h3 class="danger-text">{{ $pendingEntitiesCount }}</h3>
                    <span class="trend-down">بحاجة مراجعة وتفعيل</span>
                </div>
            </div>
        </a>
    </div>

    <div class="bottom-sections">
        <div class="content-box tasks-box">
            <h3 class="box-title">🚩 المهام العاجلة <span class="badge">{{ $pendingEntitiesCount }}</span></h3>
            <div class="tasks-list">
                @forelse($latestPending as $user)
                    <a href="{{ route('admin.entities') }}?status=pending" class="task-item urgent">
                        <div class="task-main">
                            <strong>{{ $user->name }}</strong>
                            <span class="tag">{{ $user->RoleID == 3 ? 'مطعم' : 'جمعية خيرية' }}</span>
                        </div>
                        <p>بانتظار مراجعة المستندات والتفعيل</p>
                    </a>
                @empty
                    <div class="empty-task">✅ لا توجد طلبات معلقة حالياً</div>
                @endforelse

                <a href="{{ route('admin.donations') }}" class="task-item warning">
                    <div class="task-main">
                        <strong>تنبيه تبرع كبير</strong>
                        <span class="tag">تنبيه</span>
                    </div>
                    <p>هناك تبرع بحجم كبير بانتظار التنسيق</p>
                </a>
            </div>
        </div>

        <div class="content-box activity-box">
            <h3 class="box-title center">📊 توزيع الحسابات</h3>
            <div class="chart-container">
                @php
                    $total = ($totalUsers + $totalEntities) > 0 ? ($totalUsers + $totalEntities) : 1;
                    $userP = ($totalUsers / $total) * 100;
                    $entityP = ($totalEntities / $total) * 100;
                @endphp
                <div class="bar-wrapper">
                    <div class="bar user-bar" style="width: {{ $userP }}%"></div>
                    <div class="bar entity-bar" style="width: {{ $entityP }}%"></div>
                </div>
                <div class="bar-legend">
                    <span><i class="dot blue"></i> مستخدمين ({{ $totalUsers }})</span>
                    <span><i class="dot green"></i> كيانات ({{ $totalEntities }})</span>
                </div>
            </div>

            <h3 class="box-title mt-20">🕒 آخر النشاطات</h3>
            <div class="table-mini-wrapper">
                <table class="mini-table">
                    <tbody>
                        @foreach($recentActivities as $activity)
                        <tr>
                            <td>
                                <strong>{{ $activity->EntityName ?? 'الإدارة' }}</strong><br>
                                <small>{{ $activity->DonationTitle }}</small>
                            </td>
                            <td class="text-left">
                                <span class="status-dot-text">{{ \Carbon\Carbon::parse($activity->ChangeTimestamp)->diffForHumans() }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* التصفير ومنع اللون الأزرق */
    .dashboard-wrapper * { box-sizing: border-box; font-family: 'Cairo', sans-serif; }

    .stat-card-link, .stat-card-link:hover, .stat-card-link:visited {
        text-decoration: none !important;
        color: inherit !important;
        display: block;
    }

    .dashboard-wrapper { padding: 20px; background: #fdfdfd; }

    /* الهيدر */
    .dash-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .main-title { font-size: 24px; color: #2d3436; margin: 0; }
    .sub-title { color: #636e72; margin-top: 5px; }
    .btn-export { background: #27ae60; color: white !important; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-weight: bold; font-size: 14px; transition: 0.3s; }
    .btn-export:hover { background: #219150; transform: translateY(-2px); }

    /* الكروت */
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px; }
    .stat-card { background: white; padding: 20px; border-radius: 15px; display: flex; align-items: center; gap: 15px; border: 1px solid #f1f2f6; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); border-color: #d1d8e0; }

    .icon-circle { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
    .user-bg { background: #e3f2fd; }
    .donation-bg { background: #e8f5e9; }
    .entity-bg { background: #fff3e0; }
    .alert-bg { background: #ffebee; }

    .stat-info p { margin: 0; color: #7f8c8d; font-size: 14px; }
    .stat-info h3 { margin: 5px 0; font-size: 22px; color: #2c3e50; }
    .trend-up { font-size: 12px; color: #27ae60; }
    .trend-neutral { font-size: 12px; color: #7f8c8d; }
    .trend-down { font-size: 12px; color: #e74c3c; }
    .danger-text { color: #e74c3c !important; }
    .pending-card { border-right: 4px solid #e74c3c; }

    /* الأقسام السفلية */
    .bottom-sections { display: flex; gap: 20px; }
    .content-box { background: white; padding: 25px; border-radius: 15px; border: 1px solid #f1f2f6; }
    .tasks-box { flex: 1; }
    .activity-box { flex: 1.5; }

    .box-title { font-size: 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
    .badge { background: #e74c3c; color: white; padding: 2px 8px; border-radius: 50px; font-size: 12px; }

    /* المهام كروابط نظيفة */
    .tasks-list { display: flex; flex-direction: column; gap: 12px; }
    .task-item { text-decoration: none !important; color: inherit !important; padding: 15px; border-radius: 10px; border-right: 4px solid #dfe6e9; background: #f8f9fa; transition: 0.2s; }
    .task-item:hover { background: #f1f2f6; transform: scale(1.01); }
    .task-item.urgent { border-right-color: #e74c3c; background: #fff5f5; }
    .task-item.warning { border-right-color: #f1c40f; background: #fffdf0; }

    .task-main { display: flex; justify-content: space-between; align-items: center; }
    .tag { font-size: 10px; background: rgba(0,0,0,0.05); padding: 2px 6px; border-radius: 4px; }
    .task-item p { margin: 5px 0 0; font-size: 13px; color: #636e72; }

    /* شريط التوزيع */
    .chart-container { margin-bottom: 30px; }
    .bar-wrapper { height: 10px; display: flex; border-radius: 10px; overflow: hidden; background: #f1f2f6; }
    .bar.user-bar { background: #3498db; }
    .bar.entity-bar { background: #2ecc71; }
    .bar-legend { display: flex; justify-content: center; gap: 20px; margin-top: 15px; font-size: 13px; }
    .dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-left: 5px; }
    .dot.blue { background: #3498db; }
    .dot.green { background: #2ecc71; }

    /* جدول صغير */
    .mini-table { width: 100%; border-collapse: collapse; }
    .mini-table td { padding: 12px 0; border-bottom: 1px solid #f1f2f6; }
    .text-left { text-align: left; }
    .status-dot-text { color: #95a5a6; font-size: 12px; }

    @media (max-width: 992px) {
        .bottom-sections { flex-direction: column; }
    }
</style>
@endsection
