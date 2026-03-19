@extends('association.association_layout')

@section('association_content')
 <link rel="stylesheet" href="{{ asset('css/available-donations.css') }}">
    <h1>التبرعات المتاحة</h1>

    <form action="{{ route('association.available_donations') }}" method="GET" class="search-box">
        <input type="text" name="search" placeholder="بحث عن مطعم أو نوع طعام" value="{{ request('search') }}">
    </form>

    <div class="cards">
        @forelse($donations as $donation)
            <div class="donation-card">
                <h3>{{ $donation->RestaurantName }}</h3>
                <p><span>الوصف:</span> {{ $donation->Description }}</p>
                <p><span>الكمية:</span> {{ $donation->Quantity }} {{ $donation->Unit }}</p>
                {{-- افترضنا وجود عمود PickupTime في قاعدة البيانات --}}
                <p><span>وقت الاستلام:</span> {{ $donation->PickupTime ?? 'متاح الآن' }}</p>

                <form action="{{ route('association.accept_donation', $donation->DonationID) }}" method="POST">
                    @csrf
                    <button type="submit">قبول التبرع</button>
                </form>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 50px;">
                <p>لا توجد تبرعات متاحة حالياً. تفقد الصفحة لاحقاً!</p>
            </div>
        @endforelse
    </div>

    <style>
        /* التنسيقات الإضافية لضمان تطابق التصميم */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .donation-card {
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            border: 1px solid #eee;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: 0.3s;
        }
        .donation-card:hover { transform: translateY(-5px); }
        .donation-card h3 { color: #2D6A4F; margin-bottom: 15px; }
        .donation-card p { margin-bottom: 10px; font-size: 14px; }
        .donation-card p span { font-weight: bold; color: #555; }
        .donation-card button {
            width: 100%;
            padding: 10px;
            background-color: #008080;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }
        .donation-card button:hover { background-color: #006666; }
    </style>
@endsection
