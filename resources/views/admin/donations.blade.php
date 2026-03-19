@extends('admin.layout')

@section('admin_content')
    {{-- الفورم المسؤول عن البحث والفلترة --}}
    <form action="{{ route('admin.donations') }}" method="GET" id="filterForm">
        <div class="top-search">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="البحث باسم الكيان..." onchange="this.form.submit()">
            <span class="bell">🔔</span>
        </div>

        <h1>سجل التبرعات</h1>

        <div class="filter-area" style="margin-bottom: 20px;" >
            <select name="status" onchange="this.form.submit()" class="filter">
                <option value="" class="filter" >جميع الحالات ⌄ </option>
                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>معلّق</option>
                <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>تم الاستلام</option>
                <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>تم التوزيع</option>
                <option value="4" {{ request('status') == '4' ? 'selected' : '' }}>ملغي</option>
            </select>
        </div>
    </form>

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>رقم التبرع</th>
                    <th>الكيان المتبرع</th>
                    <th>الجهة المستفيدة</th>
                    <th>الكمية</th>
                    <th>الحالة</th>
                    <th>تاريخ الإنشاء</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donations as $donation)
                <tr>
                    <td>#{{ $donation->DonationID }}</td>
                    <td>{{ $donation->donor_name }}</td>
                    <td>{{ $donation->receiver_name ?? '—' }}</td>
                    <td>{{ $donation->Quantity }} {{ $donation->Unit == 'KILO' ? 'كيلو' : 'وجبة' }}</td>
  <td>
    @php
        // تحويل الرقم القادم من قاعدة البيانات إلى اسم كلاس يفهمه الـ CSS
        $statusClass = '';
        switch((int)$donation->StatusID) {
            case 1: $statusClass = 'pending'; break;     // معلق -> بنفسجي
            case 2: $statusClass = 'received'; break;    // تم الاستلام -> أخضر
            case 3: $statusClass = 'distributed'; break; // تم التوزيع -> برتقالي
            case 4: $statusClass = 'cancelled'; break;   // ملغي -> أحمر
        }
    @endphp

    {{-- وضع الكلاس داخل الـ span --}}
    <span class="status-pill {{ $statusClass }}">
        {{ $donation->StatusName }}
    </span>
</td>

                    <td>{{ date('d-m-Y', strtotime($donation->created_at)) }}</td>
                    <td>...</td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;">لا توجد بيانات</td></tr>
                @endforelse
            </tbody>
        </table>

        {{-- أزرار التنقل المبرمجة --}}
        <div class="pagination">
            @if (!$donations->onFirstPage())
                <a href="{{ $donations->previousPageUrl() }}"><button class="btn-page">السابق</button></a>
            @endif
            @if ($donations->hasMorePages())
                <a href="{{ $donations->nextPageUrl() }}"><button class="btn-page">التالي</button></a>
            @endif
        </div>
    </div>
@endsection
