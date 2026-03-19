@extends('restaurant.restaurant_layout') {{-- توريث الهيكل الجديد --}}

@section('restaurant_content')
    {{-- الأزرار العلوية --}}
    <div class="top-actions">
        {{-- تأكدي من تسمية Route إضافة التبرع لاحقاً بهذا الاسم --}}
        <a href="{{ route('restaurant.add_donation') }}" class="add-btn" style="text-decoration: none;">+ تبرع جديد</a>
    </div>

    <h1 class="title">لوحة التحكم</h1>
    <p class="subtitle">ملخص لتبرعات المطعم وإحصائيات الأداء</p>

    {{-- الإحصائيات الحقيقية من الكنترولر --}}
    <div class="stats">
        <div class="stat-card">
            <span class="icon">💚</span>
            <p>الجمعيات الشريكة</p>
            <strong>{{ $stats['partners'] }}</strong>
        </div>

        <div class="stat-card">
            <span class="icon">⏱</span>
            <p>نشطة الآن</p>
            <strong>{{ $stats['active_now'] }}</strong>
        </div>

        <div class="stat-card">
            <span class="icon">📦</span>
            <p>كمية الوجبات</p>
            <strong>{{ $stats['total_meals'] }}</strong>
        </div>

        <div class="stat-card">
            <span class="icon">🤍</span>
            <p>إجمالي التبرعات</p>
            <strong>{{ $stats['total_donations'] }}</strong>
        </div>
    </div>

    {{-- القسم الأوسط: الجدول وصندوق المساعدة --}}
    <div class="middle">
        <div class="table-box">
            <h3>التبرعات النشطة التي تحتاج إلى قبول أو استلام</h3>

            <table>
                <thead>
                    <tr>
                        <th>وصف التبرع</th>
                        <th>الكمية</th>
                        <th>الحالة</th>
                        <th>الوقت</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activeDonations as $donation)
                    <tr>
                        <td>{{ $donation->Description ?? 'وجبة فائضة' }}</td>
                        <td>{{ $donation->Quantity }} وجبة</td>
                        <td>
                            @php
                                // تحديد لون الـ Badge بناءً على الحالة
                                $badgeClass = match((int)$donation->StatusID) {
                                    1 => 'blue',   // متاح
                                    2 => 'orange', // تم القبول
                                    default => 'blue'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $donation->StatusName }}</span>
                        </td>
                        {{-- استخدام diffForHumans لإظهار "منذ 15 دقيقة" مثلاً --}}
                        <td>{{ \Carbon\Carbon::parse($donation->created_at)->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;">لا توجد تبرعات نشطة حالياً</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="help-box">
            <p>لديك فائض بالطعام؟</p>
            <span>ساعد في إطعام المحتاجين اليوم</span>
            <a href="{{ route('restaurant.add_donation') }}">
                <button style="cursor: pointer;">ابدأ الآن</button>
            </a>
        </div>
    </div>
@endsection
