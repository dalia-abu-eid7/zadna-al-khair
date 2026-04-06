@extends('restaurant.restaurant_layout')

@section('restaurant_content')
    <h1>إضافة تبرع جديد</h1>
    <p class="subtitle">نموذج مفصل لإدخال بيانات التبرع الجديد</p>

    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <ul style="margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('restaurant.store_donation') }}" method="POST" class="donation-form">
        @csrf

        <div class="row">
            <div class="field">
                <label>وصف الوجبة</label>
                <input type="text" name="Description" required placeholder="مثلاً: أرز ودجاج" value="{{ old('Description') }}">
            </div>

            <div class="field">
                <label>الكمية</label>
                <input type="number" name="Quantity" required placeholder="أدخل الرقم فقط" value="{{ old('Quantity') }}">
            </div>
        </div>

        <div class="row">
            <div class="field">
                <label>الوحدة</label>
                <select name="Unit" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ddd;">
                    <option value="وجبة">وجبة</option>
                    <option value="كيلو">كيلو</option>
                    <option value="صندوق">صندوق</option>
                </select>
            </div>

            <div class="field">
                <label>تاريخ ووقت توفر الطعام</label>
                <input type="datetime-local" name="PickupTimeSuggestion" required>
            </div>
        </div>

        <div class="field full">
            <label>ملاحظات إضافية (مثل: معلومات انتهاء الصلاحية)</label>
            <textarea name="ExpiryInfo" placeholder="اكتب أي ملاحظات تهم الجمعية المستلمة...">{{ old('ExpiryInfo') }}</textarea>
        </div>

        <button type="submit" class="submit-btn" style="background-color: #008080; color: white; padding: 15px; border: none; border-radius: 8px; cursor: pointer; width: 100%;">
            إرسال التبرع الآن
        </button>
    </form>
@endsection
