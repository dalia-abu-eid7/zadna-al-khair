@extends('association.association_layout')

@section('title', 'التبرعات المتاحة - زادنا الخير')

@section('association_content')
<style>
    /* حاوية المحتوى الأساسية لضمان التناسق */
    .available-donations-wrapper {
        padding: 10px;
        font-family: 'Cairo', sans-serif;
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .page-header {
        margin-bottom: 30px;
    }

    .page-header h1 {
        color: #1b4332;
        font-size: 1.8rem;
        font-weight: 800;
        margin: 0;
    }

    /* تنسيق البحث */
    .search-section {
        margin-bottom: 35px;
    }

    .search-box-input {
        width: 100%;
        max-width: 450px;
        padding: 14px 20px;
        border: 2px solid #edf2f7;
        border-radius: 15px;
        font-family: 'Cairo';
        font-size: 0.95rem;
        transition: 0.3s;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    .search-box-input:focus {
        outline: none;
        border-color: #2D6A4F;
        background: #fff;
        box-shadow: 0 10px 15px rgba(45, 106, 79, 0.05);
    }

    /* شبكة الكروت */
    .donations-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 25px;
    }

    .donation-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 25px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 10px 20px rgba(0,0,0,0.02);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
    }

    .donation-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 25px rgba(0,0,0,0.05);
        border-color: #2D6A4F;
    }

    .donation-card h3 {
        color: #1b4332;
        margin: 0 0 10px 0;
        font-size: 1.4rem;
        font-weight: 700;
    }

    .restaurant-link {
        color: #2D6A4F;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 20px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .restaurant-link:hover {
        text-decoration: underline;
    }

    .info-row {
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        color: #4a5568;
        font-size: 0.95rem;
    }

    .info-label {
        font-weight: 700;
        color: #2d3748;
        min-width: 90px;
    }

    /* زر قبول التبرع */
    .accept-btn {
        width: 100%;
        padding: 14px;
        background-color: #2D6A4F;
        color: white;
        border: none;
        border-radius: 15px;
        cursor: pointer;
        font-family: 'Cairo';
        font-weight: 800;
        font-size: 1rem;
        margin-top: 20px;
        transition: 0.3s;
    }

    .accept-btn:hover {
        background-color: #1b4332;
        box-shadow: 0 8px 15px rgba(45, 106, 79, 0.2);
    }

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 25px;
        border: 2px dashed #e2e8f0;
    }
</style>

<div class="available-donations-wrapper">
    <div class="page-header">
        <h1>🍲 التبرعات المتاحة</h1>
        <p style="color: #718096; margin-top: 5px;">استعرض التبرعات الغذائية المتاحة حالياً من المطاعم الشريكة.</p>
    </div>

    <div class="search-section">
        <form action="{{ route('association.available_donations') }}" method="GET">
            <input type="text" name="search" class="search-box-input" placeholder="🔍 ابحث عن مطعم أو نوع طعام..." value="{{ request('search') }}">
        </form>
    </div>

    <div class="donations-grid">
        @forelse($donations as $donation)
            <div class="donation-card">
                <h3>{{ $donation->donatingEntity->EntityName ?? 'مطعم غير معروف' }}</h3>

                <a href="{{ route('association.partner_restaurants') }}" class="restaurant-link">
                    📞 عرض بيانات التواصل مع المطعم
                </a>

                <div class="info-row">
                    <span class="info-label">📝 الوصف:</span>
                    <span>{{ $donation->Description }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">⚖️ الكمية:</span>
                    <span>{{ $donation->Quantity }} {{ $donation->Unit }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">⏰ الاستلام:</span>
                    <span style="color: #2D6A4F; font-weight: 700;">{{ $donation->PickupTimeSuggestion ?? 'متاح الآن' }}</span>
                </div>

                <form action="{{ route('association.accept_donation', $donation->DonationID) }}" method="POST">
                    @csrf
                    <button type="submit" class="accept-btn">قبول التبرع ✅</button>
                </form>
            </div>
        @empty
            <div class="empty-state">
                <span style="font-size: 3rem;">✨</span>
                <h3 style="color: #4a5568; margin-top: 15px;">لا توجد تبرعات متاحة حالياً</h3>
                <p style="color: #a0aec0;">تفقد الصفحة لاحقاً أو حاول البحث بكلمة أخرى.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
