@extends('association.association_layout')

@section('title', 'التبرعات المقبولة - زادنا الخير')

@section('association_content')
<style>
    /* حاوية الصفحة */
    .accepted-donations-wrapper {
        padding: 10px;
        font-family: 'Cairo', sans-serif;
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .header-info { margin-bottom: 35px; }
    .header-info h1 { color: #1b4332; font-weight: 800; font-size: 1.8rem; margin: 0; }
    .header-info p { color: #718096; margin-top: 5px; }

    /* تنسيق الكرت */
    .donation-item {
        background: #ffffff;
        padding: 25px;
        border-radius: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        border: 1px solid #f1f5f9;
        transition: 0.3s;
    }

    .donation-item:hover {
        transform: scale(1.01);
        border-color: #d1fae5;
    }

    .restaurant-details h3 {
        color: #2d3748;
        margin: 0 0 8px 0;
        font-size: 1.3rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* أوسمة الحالة */
    .status-badge {
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 800;
        background: #dcfce7; /* لون افتراضي للمقبول */
        color: #166534;
    }

    .status-completed {
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .phone-number {
        color: #2D6A4F;
        font-weight: 700;
        font-size: 0.9rem;
        display: block;
        margin-bottom: 10px;
        direction: ltr;
        text-align: right;
    }

    .food-desc {
        color: #64748b;
        font-size: 0.95rem;
        background: #f8fafc;
        padding: 8px 15px;
        border-radius: 10px;
        display: inline-block;
    }

    /* زر تأكيد الاستلام */
    .confirm-receipt-btn {
        background: #2D6A4F;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 12px;
        cursor: pointer;
        font-family: 'Cairo';
        font-weight: 700;
        transition: 0.3s;
    }

    .confirm-receipt-btn:hover {
        background: #1b4332;
        box-shadow: 0 5px 15px rgba(45, 106, 79, 0.2);
    }

    .success-label {
        color: #166534;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 5px;
        background: #f0fdf4;
        padding: 10px 15px;
        border-radius: 10px;
    }

    .empty-list {
        text-align: center;
        padding: 60px;
        background: white;
        border-radius: 20px;
        border: 2px dashed #e2e8f0;
        color: #94a3b8;
    }

    @media (max-width: 768px) {
        .donation-item { flex-direction: column; align-items: flex-start; gap: 20px; }
        .confirm-receipt-btn { width: 100%; justify-content: center; }
    }
</style>

<div class="accepted-donations-wrapper">
    <div class="header-info">
        <h1>✅ التبرعات المقبولة</h1>
        <p>تابع حالة التبرعات التي قبلتها وقم بتأكيد استلامها.</p>
    </div>

    @forelse($acceptedDonations as $donation)
        <div class="donation-item">
            <div class="restaurant-details">
                <h3>
                    {{ $donation->RestaurantName }}
                    <span class="status-badge {{ $donation->StatusID == 3 ? 'status-completed' : '' }}">
                        {{ $donation->StatusID == 3 ? '✅ تم الاستلام' : '⏳ بانتظار الاستلام' }}
                    </span>
                </h3>
                <span class="phone-number">📞 {{ $donation->RestaurantPhone }}</span>
                <div class="food-desc">
                    📦 <strong>{{ $donation->Description }}</strong>
                    <span style="margin: 0 10px; color: #cbd5e1;">|</span>
                    ⚖️ {{ $donation->Quantity }} وجبة
                </div>
            </div>

            @if($donation->StatusID == 2)
                <form action="{{ route('association.confirm_receipt', $donation->DonationID) }}" method="POST">
                    @csrf
                    <button type="submit" class="confirm-receipt-btn">تأكيد الاستلام 🚚</button>
                </form>
            @else
                <div class="success-label">
                    <span>تم الاستلام بنجاح</span> ✨
                </div>
            @endif
        </div>
    @empty
        <div class="empty-list">
            <div style="font-size: 3rem; margin-bottom: 15px;">📥</div>
            <h3>لا توجد تبرعات في قائمتك حالياً</h3>
            <p>تصفح التبرعات المتاحة وابدأ في قبولها.</p>
        </div>
    @endforelse
</div>
@endsection
