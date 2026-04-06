@extends('association.association_layout')

@section('title', 'لوحة تحكم الجمعية')

@section('association_content')
<style>
    .dashboard-container { animation: fadeIn 0.5s ease-in-out; font-family: 'Cairo', sans-serif; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .dashboard-header { margin-bottom: 30px; }
    .dashboard-header h1 { font-size: 1.8rem; color: #1b4332; font-weight: 800; }

    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px; }
    .card { background: white; padding: 20px; border-radius: 15px; border: 1px solid #f1f5f9; box-shadow: 0 4px 6px rgba(0,0,0,0.02); transition: 0.3s; text-align: center; position: relative; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px rgba(0,0,0,0.05); }
    .card-icon { font-size: 1.8rem; margin-bottom: 10px; display: block; }
    .card-title { color: #64748b; font-size: 0.9rem; margin-bottom: 5px; font-weight: 600; }
    .card-value { font-size: 1.6rem; font-weight: 800; color: #2d6a4f; margin-bottom: 10px; }

    .table-card { background: white; border-radius: 15px; padding: 20px; border: 1px solid #f1f5f9; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .table-card h2 { font-size: 1.1rem; margin-bottom: 20px; color: #1b4332; display: flex; align-items: center; gap: 10px; }
    .main-table { width: 100%; border-collapse: collapse; text-align: right; }
    .main-table th { padding: 12px; color: #94a3b8; border-bottom: 2px solid #f8fafc; font-size: 0.85rem; }
    .main-table td { padding: 15px 12px; border-bottom: 1px solid #f8fafc; font-size: 0.9rem; color: #334155; }
    .badge-coordinating { background: #fff7ed; color: #c2410c; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; }
</style>

<div class="dashboard-container">
    <div class="dashboard-header">
        <p style="color: #64748b;">ملخص سريع لنشاط الجمعية اليوم.</p>
    </div>

    <div class="stats-grid">
        <div class="card">
            <span class="card-icon">🤝</span>
            <p class="card-title">مطاعم شريكة</p>
            <p class="card-value">{{ $stats['partner_restaurants'] }}</p>
            <a href="{{ route('association.partner_restaurants') }}"
               style="color: #2d6a4f; text-decoration: none; font-size: 0.8rem; font-weight: 700; border-bottom: 1px dashed #2d6a4f;">
                عرض التفاصيل ←
            </a>
        </div>

        <div class="card">
            <span class="card-icon">🚚</span>
            <p class="card-title">قيد التنسيق</p>
            <p class="card-value">{{ $stats['coordinating'] }}</p>
            <a href="{{ route('association.accepted_donations') }}"
               style="color: #2d6a4f; text-decoration: none; font-size: 0.8rem; font-weight: 700; border-bottom: 1px dashed #2d6a4f;">
                إدارة الطلبات ←
            </a>
        </div>

        <div class="card">
            <span class="card-icon">🍲</span>
            <p class="card-title">وجبات موزعة</p>
            <p class="card-value">{{ number_format($stats['distributed']) }}</p>
            <span style="font-size: 0.75rem; color: #94a3b8;">إجمالي مستلم</span>
        </div>

        <div class="card" style="border-right: 4px solid #2d6a4f;">
            <span class="card-icon">💚</span>
            <p class="card-title">إجمالي المقبول</p>
            <p class="card-value">{{ number_format($stats['accepted_total']) }}</p>
            <span style="font-size: 0.75rem; color: #94a3b8;">منذ البداية</span>
        </div>
    </div>

    <div class="table-card">
        <h2>📦 تبرعات قيد التنسيق (بانتظار وصولها)</h2>
        <table class="main-table">
            <thead>
                <tr>
                    <th>المطعم</th>
                    <th>الكمية</th>
                    <th>رقم التواصل</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coordinatingDonations as $donation)
                <tr>
                    <td style="font-weight: 700; color: #2d6a4f;">{{ $donation->donatingEntity->EntityName ?? 'غير معروف' }}</td>
                    <td><strong>{{ $donation->Quantity }}</strong> وجبة</td>
                    <td style="direction: ltr; font-weight: bold;">{{ $donation->RestaurantPhone }}</td>
                    <td><span class="badge-coordinating">⏳ بانتظار الاستلام</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: #cbd5e1;">
                        لا يوجد تبرعات جارية حالياً. ابدأي بـ <a href="{{ route('association.available_donations') }}" style="color: #2d6a4f;">قبول تبرعات جديدة</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
