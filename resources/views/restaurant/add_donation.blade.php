@extends('restaurant.restaurant_layout')

@section('restaurant_content')
    <h1>إضافة تبرع جديد</h1>
    <p class="subtitle">نموذج مفصل لإدخال بيانات التبرع الجديد</p>

    {{-- رسالة نجاح الإرسال --}}
    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('restaurant.store_donation') }}" method="POST" class="donation-form">
        @csrf {{-- ضروري جداً لحماية الفورم في Laravel --}}

        <div class="row">
            <div class="field">
                <label>وصف الوجبة (مثلاً: أرز ودجاج)</label>
                <input type="text" name="description" required placeholder="ما هو نوع الطعام؟">
            </div>

            <div class="field">
                <label>الكمية</label>
                <input type="number" name="quantity" required placeholder="أدخل الرقم فقط">
            </div>
        </div>

        <div class="row">
            <div class="field">
                <label>الوحدة</label>
                <select name="unit" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ddd;">
                    <option value="وجبة">وجبة</option>
                    <option value="كيلو">كيلو</option>
                    <option value="صندوق">صندوق</option>
                </select>
            </div>

            <div class="field">
                <label>تاريخ ووقت توفر الطعام</label>
                <input type="datetime-local" name="available_time" required>
            </div>
        </div>

        <div class="field full">
            <label>ملاحظات إضافية (مثل: معلومات انتهاء الصلاحية)</label>
            <textarea name="notes" placeholder="اكتب أي ملاحظات تهم الجمعية المستلمة..."></textarea>
        </div>

        <button type="submit" class="submit-btn">
            إرسال التبرع الآن
        </button>
    </form>
@endsection
