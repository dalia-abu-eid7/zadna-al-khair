@extends('restaurant.restaurant_layout')

@section('title', 'لوحة التحكم')

@section('restaurant_content')
    <div style="display: flex; justify-content: flex-end; margin-bottom: 25px;">
        <a href="{{ route('restaurant.add_donation') }}" style="text-decoration: none; background: var(--primary-green); color: white; padding: 12px 28px; border-radius: 15px; font-weight: 800; box-shadow: 0 4px 15px rgba(45, 106, 79, 0.2); transition: 0.3s;">
            + إضافة تبرع جديد
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 40px;">

        <a href="{{ route('restaurant.partners_list') }}" style="text-decoration: none; color: inherit;">
            <div style="background: white; padding: 25px; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); text-align: center; border-bottom: 5px solid var(--accent-green); transition: 0.3s;">
                <span style="font-size: 2.2rem; display: block; margin-bottom: 10px;">💚</span>
                <p style="color: #666; font-weight: 600; font-size: 0.95rem;">الجمعيات الشريكة</p>
                <strong style="font-size: 1.8rem; color: var(--text-color); display: block;">{{ $stats['partners'] }}</strong>
                <span style="color: var(--accent-green); font-size: 0.8rem; font-weight: 800; margin-top: 8px; display: block;">عرض الكل ←</span>
            </div>
        </a>

        <div style="background: white; padding: 25px; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); text-align: center; border-bottom: 5px solid #ff9f1c;">
            <span style="font-size: 2.2rem; display: block; margin-bottom: 10px;">⏳</span>
            <p style="color: #666; font-weight: 600;">تبرعات نشطة</p>
            <strong style="font-size: 1.8rem; color: var(--text-color);">{{ $stats['active_now'] }}</strong>
        </div>

        <div style="background: white; padding: 25px; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); text-align: center; border-bottom: 5px solid var(--primary-green);">
            <span style="font-size: 2.2rem; display: block; margin-bottom: 10px;">📦</span>
            <p style="color: #666; font-weight: 600;">إجمالي الوجبات</p>
            <strong style="font-size: 1.8rem; color: var(--text-color);">{{ number_format($stats['total_meals']) }}</strong>
        </div>

        <div style="background: white; padding: 25px; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); text-align: center; border-bottom: 5px solid #1b4332;">
            <span style="font-size: 2.2rem; display: block; margin-bottom: 10px;">🤍</span>
            <p style="color: #666; font-weight: 600;">عدد التبرعات</p>
            <strong style="font-size: 1.8rem; color: var(--text-color);">{{ $stats['total_donations'] }}</strong>
        </div>
    </div>

    <div style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #f0f0f0;">
        <h3 style="margin-bottom: 25px; color: var(--text-color); display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 1.4rem;">🥘</span> التبرعات المتاحة حالياً
        </h3>
        <table style="width: 100%; border-collapse: collapse; text-align: right;">
            <thead>
                <tr style="border-bottom: 2px solid #f8fafc;">
                    <th style="padding: 15px; color: #94a3b8; font-size: 0.9rem;">الوصف</th>
                    <th style="padding: 15px; color: #94a3b8; font-size: 0.9rem;">الكمية</th>
                    <th style="padding: 15px; color: #94a3b8; font-size: 0.9rem;">الحالة</th>
                    <th style="padding: 15px; color: #94a3b8; font-size: 0.9rem;">منذ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activeDonations as $donation)
                <tr style="border-bottom: 1px solid #f1f5f9; transition: 0.2s;">
                    <td style="padding: 20px 15px; font-weight: 700; color: var(--primary-green);">{{ $donation->Description ?? 'وجبات منوعة' }}</td>
                    <td style="padding: 20px 15px;"><strong>{{ $donation->Quantity }}</strong> وجبة</td>
                    <td style="padding: 20px 15px;">
                        @php
                            $statusColor = $donation->StatusID == 1 ? 'background: #e0f2fe; color: #0369a1;' : 'background: #fff7ed; color: #c2410c;';
                        @endphp
                        <span style="padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; {{ $statusColor }}">
                            {{ $donation->status->StatusName ?? 'متاح' }}
                        </span>
                    </td>
                    <td style="padding: 20px 15px; color: #94a3b8; font-size: 0.85rem;">
                        {{ \Carbon\Carbon::parse($donation->created_at)->diffForHumans() }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: #cbd5e1;">لا توجد تبرعات نشطة حالياً.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
