@extends('association.association_layout')

@section('title', 'المطاعم الشريكة')

@section('association_content')
<style>
    .partners-container { animation: fadeIn 0.5s ease-in-out; font-family: 'Cairo', sans-serif; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .header-box { margin-bottom: 30px; border-bottom: 1px solid #edf2f7; padding-bottom: 15px; }
    .header-box h2 { color: #1b4332; font-weight: 800; margin-bottom: 5px; }

    .table-wrapper { background: white; border-radius: 15px; border: 1px solid #f1f5f9; box-shadow: 0 4px 6px rgba(0,0,0,0.02); overflow: hidden; }

    .partners-table { width: 100%; border-collapse: collapse; text-align: right; }
    .partners-table thead th { background: #f8fafc; padding: 15px; color: #64748b; font-weight: 700; font-size: 0.9rem; }
    .partners-table tbody td { padding: 15px; border-bottom: 1px solid #f8fafc; color: #334155; vertical-align: middle; }

    .res-name { color: #2d6a4f; font-weight: 800; font-size: 1rem; }
    .contact-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        background: #f0fdf4;
        color: #166534;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.85rem;
        transition: 0.2s;
    }
    .contact-btn:hover { background: #dcfce7; }

    .address-tag { color: #94a3b8; font-size: 0.85rem; }
</style>

<div class="partners-container">
    <div class="header-box">
        <h2>🤝 شبكة المطاعم الشريكة</h2>
        <p style="color: #64748b;">المطاعم التي قمتِ بقبول تبرعات منها مسبقاً.</p>
    </div>

    <div class="table-wrapper">
        <table class="partners-table">
            <thead>
                <tr>
                    <th>اسم المطعم</th>
                    <th>الموقع / العنوان</th>
                    <th>مسؤول التواصل</th>
                    <th>رقم الهاتف المباشر</th>
                </tr>
            </thead>
            <tbody>
                @foreach($restaurants as $restaurant)
                <tr>
                    <td class="res-name">{{ $restaurant->EntityName }}</td>
                    <td class="address-tag">📍 {{ $restaurant->Address ?? 'العنوان غير متوفر' }}</td>
                    <td>{{ $restaurant->ContactPerson ?? '---' }}</td>
                    <td>
                        <a href="tel:{{ $restaurant->phone }}" class="contact-btn">
                            <span>📞</span> {{ $restaurant->phone }}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
