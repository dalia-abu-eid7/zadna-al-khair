@extends('admin.layout')

@section('admin_content')
<div class="main-content-card">
    <div class="dashboard-header">
        <div class="header-text">
            <h1 class="title">📜 سجل التبرعات</h1>
            <p class="subtitle">تتبع ومراقبة جميع عمليات التبرع عبر النظام</p>
        </div>

        <div class="header-actions">
            <form action="{{ route('admin.donations') }}" method="GET" class="search-form">
                <div class="input-wrapper">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث عن كيان..." onchange="this.form.submit()">
                    <span class="search-icon">🔍</span>
                </div>
                <select name="status" onchange="this.form.submit()" class="status-select">
                    <option value="">كل الحالات</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>⏳ معلق</option>
                    <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>✅ مستلم</option>
                    <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>📦 موزع</option>
                    <option value="4" {{ request('status') == '4' ? 'selected' : '' }}>❌ ملغي</option>
                </select>
            </form>
        </div>
    </div>

    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>رقم التبرع</th>
                    <th>الكيان المتبرع</th>
                    <th>الجهة المستفيدة</th>
                    <th>الكمية</th>
                    <th>الحالة</th>
                    <th>التاريخ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donations as $donation)
                <tr>
                    <td><span class="badge-id">#{{ $donation->DonationID }}</span></td>
                    <td><div class="donor-name">{{ $donation->donor_name }}</div></td>
                    <td>{{ $donation->receiver_name ?? '—' }}</td>
                    <td><span class="quantity-tag">{{ $donation->Quantity }} {{ $donation->Unit == 'KILO' ? 'كيلو' : 'وجبة' }}</span></td>
                    <td>
                        @php
                            $statusMap = [
                                1 => ['class' => 'p-pending', 'label' => 'معلق'],
                                2 => ['class' => 'p-received', 'label' => 'مستلم'],
                                3 => ['class' => 'p-distributed', 'label' => 'موزع'],
                                4 => ['class' => 'p-cancelled', 'label' => 'ملغي'],
                            ];
                            $status = $statusMap[$donation->StatusID] ?? ['class' => '', 'label' => 'غير معروف'];
                        @endphp
                        <span class="pill {{ $status['class'] }}">{{ $status['label'] }}</span>
                    </td>
                    <td class="date-col">{{ date('d/m/Y', strtotime($donation->created_at)) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="no-data">
                        <div class="empty-state">
                            <p>لا توجد بيانات تبرعات حالياً</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($donations->hasPages())
    <div class="custom-pagination">
        {{ $donations->links() }}
    </div>
    @endif
</div>

<style>
    /* التنسيقات الأساسية لتحويل الشكل تماماً */
    .main-content-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        margin: 20px;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .title { font-size: 1.8rem; color: #2d3436; margin: 0; }
    .subtitle { color: #636e72; margin-top: 5px; }

    .search-form { display: flex; gap: 10px; }

    .input-wrapper { position: relative; }
    .input-wrapper input {
        padding: 12px 40px 12px 15px;
        border: 1px solid #dfe6e9;
        border-radius: 12px;
        outline: none;
        width: 250px;
        transition: 0.3s;
    }
    .input-wrapper input:focus { border-color: #00b894; box-shadow: 0 0 0 4px rgba(0, 184, 148, 0.1); }
    .search-icon { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); opacity: 0.5; }

    .status-select {
        padding: 12px;
        border-radius: 12px;
        border: 1px solid #dfe6e9;
        background: #f9f9f9;
        outline: none;
        cursor: pointer;
    }

    /* الجدول */
    .table-container { overflow-x: auto; border-radius: 15px; border: 1px solid #f1f2f6; }
    .custom-table { width: 100%; border-collapse: collapse; text-align: right; }
    .custom-table th { background: #f8fafc; padding: 18px; color: #636e72; font-weight: 600; font-size: 0.9rem; }
    .custom-table td { padding: 18px; border-bottom: 1px solid #f1f2f6; color: #2d3436; }

    .badge-id { background: #f1f2f6; padding: 4px 10px; border-radius: 8px; font-family: monospace; font-weight: bold; }
    .donor-name { font-weight: 700; color: #2d3436; }
    .quantity-tag { color: #0984e3; font-weight: 600; }

    /* الحالات (Pills) */
    .pill { padding: 6px 15px; border-radius: 50px; font-size: 0.8rem; font-weight: bold; display: inline-block; }
    .p-pending { background: #fff3cd; color: #856404; }
    .p-received { background: #d4edda; color: #155724; }
    .p-distributed { background: #d1ecf1; color: #0c5460; }
    .p-cancelled { background: #f8d7da; color: #721c24; }

    .no-data { text-align: center; padding: 100px !important; color: #b2bec3; }

    @media (max-width: 768px) {
        .dashboard-header { flex-direction: column; align-items: stretch; }
        .input-wrapper input { width: 100%; }
    }
</style>
@endsection
