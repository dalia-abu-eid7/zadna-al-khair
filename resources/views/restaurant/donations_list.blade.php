@extends('restaurant.restaurant_layout')

@section('restaurant_content')
    <h1>سجل التبرعات</h1>
    <p class="subtitle">قائمة بجميع التبرعات التي قدمها المطعم</p>

    {{-- قسم الفلاتر والبحث --}}
    <div class="filters" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">

        {{-- أزرار الفلترة --}}
        <div class="status-filter" style="display: flex; gap: 10px;">
            <a href="{{ route('restaurant.donations_list') }}"
               class="btn-filter {{ !request('status') ? 'active' : '' }}">الكل</a>

            <a href="{{ route('restaurant.donations_list', ['status' => 1]) }}"
               class="btn-filter {{ request('status') == 1 ? 'active' : '' }}">متاح</a>

            <a href="{{ route('restaurant.donations_list', ['status' => 2]) }}"
               class="btn-filter {{ request('status') == 2 ? 'active' : '' }}">مقبول</a>

            <a href="{{ route('restaurant.donations_list', ['status' => 3]) }}"
               class="btn-filter {{ request('status') == 3 ? 'active' : '' }}">مكتمل</a>
        </div>

        {{-- مربع البحث --}}
        <form action="{{ route('restaurant.donations_list') }}" method="GET" style="display: flex; gap: 5px;">
            <input type="text" name="search" placeholder="بحث في التبرعات..." value="{{ request('search') }}"
                   style="padding: 10px; border: 1px solid #ddd; border-radius: 20px; outline: none; width: 250px;">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
        </form>
    </div>

    <h2>جميع التبرعات</h2>

    <table class="donations">
        <thead>
            <tr>
                <th>وصف التبرع</th>
                <th>الحالة الحالية</th>
                <th>تاريخ الإضافة</th>
                <th>الجهة المستلمة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($donations as $donation)
            <tr>
                <td>{{ $donation->Quantity }} {{ $donation->Unit ?? 'وجبة' }} - {{ $donation->Description }}</td>
                <td>
                    @php
                        $badgeClass = match((int)$donation->StatusID) {
                            1 => 'available', // متاح - أزرق
                            2 => 'pending',   // مقبول - برتقالي
                            3 => 'completed', // مكتمل - أخضر
                            4 => 'cancelled', // ملغي - أحمر
                            default => 'available'
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $donation->StatusName }}</span>
                </td>
                <td>{{ \Carbon\Carbon::parse($donation->created_at)->translatedFormat('d-m-Y') }}</td>
                <td>{{ $donation->ReceiverName ?? '—' }}</td>
                <td>
                    <a href="#" style="color: #2D6A4F; text-decoration: none; font-weight: bold;">التفاصيل</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px;">لا توجد نتائج مطابقة للبحث</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination" style="margin-top: 20px;">
        {{ $donations->appends(request()->query())->links() }}
    </div>

    <style>
        .btn-filter {
            text-decoration: none;
            padding: 8px 22px;
            border-radius: 20px;
            border: 1px solid #eee;
            color: #666;
            background: #fff;
            font-size: 14px;
            transition: 0.3s;
        }
        .btn-filter.active {
            background-color: #008080; /* لون زادنا الخير الأخضر */
            color: white;
            border-color: #008080;
        }
        .badge {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge.available { background-color: #E3F2FD; color: #1976D2; }
        .badge.pending { background-color: #FFF3E0; color: #F57C00; }
        .badge.completed { background-color: #E8F5E9; color: #388E3C; }
        .badge.cancelled { background-color: #FFEBEE; color: #D32F2F; }
    </style>
@endsection
