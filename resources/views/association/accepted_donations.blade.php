@extends('association.association_layout')

@section('association_content')
 <link rel="stylesheet" href="{{ asset('css/accepted-donations.css') }}">
<div class="page-title">
    <h1>سجل التبرعات</h1>
    <p>تتبع التبرعات التي تم قبولها وتأكيد إتمام عملية الاستلام</p>
</div>

@forelse($acceptedDonations as $donation)
    <div class="donation-card">
        <div class="donation-info">
            <div class="title-row">
                <h3>{{ $donation->RestaurantName }}</h3>
                <span class="status">مقبول</span>
            </div>
            <p>{{ $donation->RestaurantPhone }}</p>
            <span class="details">{{ $donation->Description }} ({{ $donation->Quantity }} {{ $donation->Unit }})</span>
        </div>

        <form action="{{ route('association.confirm_receipt', $donation->DonationID) }}" method="POST">
            @csrf
            <button type="submit" class="confirm-btn">تأكيد الاستلام</button>
        </form>
    </div>
@empty
    <div class="donation-card" style="justify-content: center;">
        <p>لا توجد تبرعات بانتظار الاستلام حالياً.</p>
    </div>
@endforelse

<style>
    .page-title { margin-bottom: 30px; }
    .page-title h1 { color: #333; font-size: 24px; }
    .donation-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        border: 1px solid #eee;
    }
    .title-row { display: flex; align-items: center; gap: 15px; margin-bottom: 5px; }
    .status { background: #2d6a4f; color: white; padding: 2px 10px; border-radius: 5px; font-size: 12px; }
    .details { color: #666; font-size: 14px; }
    .confirm-btn {
        background: #c7f9cc;
        color: #2d6a4f;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
    }
    .confirm-btn:hover { background: #80ed99; }
</style>
@endsection
