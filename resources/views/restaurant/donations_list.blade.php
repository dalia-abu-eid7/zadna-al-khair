@extends('restaurant.restaurant_layout')

@section('restaurant_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* تحسين شكل الشارات (Badges) */
    .status-badge {
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 90px;
    }
    .status-1 { background: #e3f2fd; color: #1976d2; border: 1px solid #bbdefb; } /* متاح */
    .status-2 { background: #fff3e0; color: #f57c00; border: 1px solid #ffe0b2; } /* مقبول */
    .status-3 { background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; } /* مكتمل */

    .custom-table { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
    .custom-table tr { background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.02); transition: 0.3s; }
    .custom-table tr:hover { transform: scale(1.01); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    .custom-table td, .custom-table th { padding: 18px; text-align: right; border: none; }
    .custom-table th { color: #888; font-weight: 600; padding-bottom: 5px; }
    .custom-table td:first-child { border-radius: 0 15px 15px 0; }
    .custom-table td:last-child { border-radius: 15px 0 0 15px; }

    .action-icon { font-size: 1.1rem; transition: 0.2s; cursor: pointer; }
    .action-icon:hover { opacity: 0.7; }
</style>

<div class="header-section" style="margin-bottom: 30px;">
    <h1 style="color: #1b4332; font-weight: 800;">سجل التبرعات 📦</h1>
    <p style="color: #64748b;">تتبع وإدارة كافة التبرعات التي قدمها مطعمك.</p>
</div>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <div style="display: flex; gap: 12px;">
        <a href="{{ route('restaurant.donations_list') }}" class="btn-filter {{ !request('status') ? 'active' : '' }}">الكل</a>
        <a href="{{ route('restaurant.donations_list', ['status' => 1]) }}" class="btn-filter {{ request('status') == 1 ? 'active' : '' }}">متاح</a>
        <a href="{{ route('restaurant.donations_list', ['status' => 2]) }}" class="btn-filter {{ request('status') == 2 ? 'active' : '' }}">مقبول</a>
    </div>

    <form action="{{ route('restaurant.donations_list') }}" method="GET">
        <input type="text" name="search" placeholder="ابحث عن تبرع..." value="{{ request('search') }}"
               style="padding: 10px 20px; border-radius: 25px; border: 1px solid #eee; width: 280px; outline: none; focus: border-green-500;">
    </form>
</div>

<table class="custom-table">
    <thead>
        <tr>
            <th>وصف التبرع</th>
            <th>الحالة الحالية</th>
            <th>تاريخ الإضافة</th>
            <th>الجهة المستلمة</th>
            <th style="text-align: center;">الإجراءات</th>
        </tr>
    </thead>
    <tbody>
        @forelse($donations as $donation)
        <tr>
            <td>
                <div style="font-weight: 700; color: #2d6a4f;">{{ $donation->Quantity }} وجبة</div>
                <div style="font-size: 0.85rem; color: #777;">{{ $donation->Description }}</div>
            </td>
            <td>
                @php
                    $sID = (int)$donation->StatusID;
                    $sName = $donation->status->StatusName ?? match($sID) { 1=>'متاح', 2=>'مقبول', 3=>'مكتمل', default=>'غير محدد' };
                @endphp
                <span class="status-badge status-{{ $sID }}">{{ $sName }}</span>
            </td>
            <td style="color: #64748b; font-size: 0.9rem;">
                {{ \Carbon\Carbon::parse($donation->created_at)->translatedFormat('d M Y') }}
            </td>
            <td>
                @if($donation->receivingEntity)
                    <span style="color: #1b4332; font-weight: 600;">{{ $donation->receivingEntity->EntityName }}</span>
                @else
                    <span style="color: #cbd5e1; font-style: italic;">بانتظار قبول جمعية</span>
                @endif
            </td>
            <td>
                <div style="display: flex; gap: 15px; justify-content: center;">
                    <a href="#" class="action-icon" style="color: #2d6a4f;" title="عرض"><i class="fas fa-eye"></i></a>
                    @if($donation->StatusID == 1)
                        <a href="{{ route('restaurant.donations.edit', $donation->DonationID) }}" class="action-icon" style="color: #f59e0b;" title="تعديل"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('restaurant.donations.destroy', $donation->DonationID) }}" method="POST" onsubmit="return confirm('هل أنت متأكد؟');">
                            @csrf @method('DELETE')
                            <button type="submit" style="background:none; border:none; padding:0;" class="action-icon" style="color: #ef4444;"><i class="fas fa-trash"></i></button>
                        </form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align: center; padding: 50px; color: #94a3b8;">لا توجد تبرعات حالياً.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top: 25px;">
    {{ $donations->appends(request()->query())->links() }}
</div>
@endsection
