@extends('association.association_layout')

@section('title', 'لوحة تحكم الجمعية')

@section('association_content')
    <h1>لوحة التحكم الجمعية</h1>
    <p class="subtitle">مرحباً بكم، جرى تنسيق وصول التبرعات للمستفيدين</p>

    <div class="stats">
        <div class="stat-card">
            <div class="icon food">🍽</div>
            <p>مطاعم شريكة</p>
            <strong>{{ $stats['partner_restaurants'] }}</strong>
        </div>

        <div class="stat-card">
            <div class="icon car">🚚</div>
            <p>قيد التنسيق</p>
            <strong>{{ $stats['coordinating'] }}</strong>
        </div>

        <div class="stat-card">
            <div class="icon meals">🌱</div>
            <p>وجبات تم توزيعها</p>
            <strong>{{ number_format($stats['distributed']) }}</strong>
        </div>

        <div class="stat-card">
            <div class="icon heart">♡</div>
            <p>تبرعات مقبولة</p>
            <strong>{{ number_format($stats['accepted_total']) }}</strong>
        </div>
    </div>

    <div class="section-title">قائمة التبرعات قيد التنسيق</div>

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>المطعم</th>
                    <th>الكمية</th>
                    <th>التواصل</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coordinatingDonations as $donation)
                <tr>
                    <td>{{ $donation->RestaurantName }}</td>
                    <td>{{ $donation->Quantity }} {{ $donation->Unit ?? 'وجبة' }}</td>
                    <td>{{ $donation->RestaurantPhone }}</td>
                    <td><span class="status">بانتظار الاستلام</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px;">لا توجد تبرعات قيد التنسيق حالياً.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
