@extends('restaurant.restaurant_layout')

@section('restaurant_content')
    <div style="padding: 20px;">
        <h1 class="title" style="color: #1b4332; font-size: 2rem; margin-bottom: 5px;">🤝 الجمعيات الشريكة</h1>
        <p class="subtitle" style="color: #666; margin-bottom: 30px;">يمكنك التواصل مع الجمعيات الخيرية لترتيب عمليات الاستلام</p>

        <div class="middle">
            <div class="table-box" style="width: 100%; background: white; padding: 25px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #eef2f0;">
                <h3 style="margin-bottom: 20px; color: #2d6a4f; border-right: 4px solid #40916c; padding-right: 15px;">قائمة بيانات التواصل</h3>

                <table style="width: 100%; border-collapse: separate; border-spacing: 0 10px; text-align: right;">
                    <thead>
                        <tr style="background-color: #f8fdfb;">
                            <th style="padding: 15px; color: #1b4332; border-radius: 0 10px 10px 0;">اسم الجمعية</th>
                            <th style="padding: 15px; color: #1b4332;">📍 العنوان</th>
                            <th style="padding: 15px; color: #1b4332;">📞 رقم التواصل</th>
                            <th style="padding: 15px; color: #1b4332; border-radius: 10px 0 0 10px;">✉️ البريد الإلكتروني</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($partners as $partner)
                        <tr class="partner-row" style="transition: all 0.3s ease;">
                            <td style="padding: 15px; background: #fff; border-top: 1px solid #eee; border-bottom: 1px solid #eee; border-right: 1px solid #eee; border-radius: 0 10px 10px 0; font-weight: bold; color: #2d6a4f;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 35px; height: 35px; background: #f0fdf4; border-radius: 50%; display: flex; align-items: center; justify-content: center;">🏢</div>
                                    {{ $partner->EntityName }}
                                </div>
                            </td>
                            <td style="padding: 15px; background: #fff; border-top: 1px solid #eee; border-bottom: 1px solid #eee; color: #555;">
                                {{ $partner->Address ?? 'الموقع غير محدد' }}
                            </td>
                            <td style="padding: 15px; background: #fff; border-top: 1px solid #eee; border-bottom: 1px solid #eee;">
                                @if($partner->Phone)
                                    <a href="tel:{{ $partner->Phone }}" style="color: #40916c; text-decoration: none; font-weight: bold; background: #f0fdf4; padding: 5px 12px; border-radius: 20px; border: 1px solid #dcfce7;">
                                        {{ $partner->Phone }}
                                    </a>
                                @else
                                    <span style="color: #999; font-style: italic;">لا يوجد رقم</span>
                                @endif
                            </td>
                            <td style="padding: 15px; background: #fff; border-top: 1px solid #eee; border-bottom: 1px solid #eee; border-left: 1px solid #eee; border-radius: 10px 0 0 10px; color: #666;">
                                {{ $partner->ContactEmail ?? '---' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align:center; padding: 40px; color: #999;">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" style="width: 50px; opacity: 0.3; margin-bottom: 10px;"><br>
                                لا توجد جمعيات متوفرة حالياً.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div style="margin-top: 30px; text-align: center;">
            <a href="{{ route('restaurant.dashboard') }}" style="text-decoration: none; color: #666; font-weight: bold; padding: 10px 20px; border: 2px solid #eee; border-radius: 10px; transition: 0.3s;">
                ← العودة للوحة التحكم
            </a>
        </div>
    </div>

    <style>
        .partner-row:hover td {
            background-color: #f0fdf4 !important;
            border-color: #40916c !important;
            transform: scale(1.01);
        }
        table {
            border-spacing: 0 8px !important;
        }
    </style>
@endsection
