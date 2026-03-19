@extends('layouts.app')

@section('content')
<main class="content">

    <h1>إضافة تبرع جديد</h1>
    <p class="subtitle">نموذج مفصل لإدخال بيانات التبرع الجديد</p>

    {{-- تعديل وسم الفورم لإرسال البيانات للمسار الصحيح مع إضافة حماية لارافل --}}


    @if(session('success'))
    <div style="
        background-color: #d4edda;
        color: #155724;
        padding: 20px;
        border: 1px solid #c3e6cb;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    ">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <ul style="margin: 0;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="{{ route('donations.store') }}" method="POST" class="donation-form">
        @csrf

        <div class="row">
            <div class="field">
                <label>وصف الوجبة</label>
                {{-- أضفنا name="description" لكي نعرف هذا الحقل في قاعدة البيانات --}}
                <input type="text" name="Description" required>
            </div>

            <div class="field">
                <label>الكمية</label>
                <input type="number" name="Quantity" required>
            </div>
        </div>

        <div class="row">
            <div class="field">
                <label>الوحدة</label>
                {{-- مثال: وجبة، كيلو، صحن --}}
                <input type="text" name="Unit" placeholder="مثلاً: وجبة أو كيلو">
            </div>

            <div class="field">
                <label>تاريخ ووقت توفر الطعام</label>
                <input type="datetime-local" name="PickupTimeSuggestion" required>
            </div>
        </div>

        <div class="field full">
            <label>معلومات انتهاء الصلاحية</label>
            <textarea name="ExpiryInfo"></textarea>
        </div>

        <button type="submit" class="submit-btn">
            إرسال التبرع الآن
        </button>

    </form>

</main>
@endsection
