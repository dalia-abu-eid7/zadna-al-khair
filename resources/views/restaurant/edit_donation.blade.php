@extends('restaurant.restaurant_layout')

@section('restaurant_content')
<div class="container" style="max-width: 600px; margin: 20px auto; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <h2 style="color: #2D6A4F; margin-bottom: 20px;">تعديل بيانات التبرع</h2>

    <form action="{{ route('restaurant.donations.update', $donation->DonationID) }}" method="POST">
        @csrf
        @method('PUT') 

        <div style="margin-bottom: 15px;">
            <label>وصف الطعام:</label>
            <input type="text" name="description" value="{{ old('description', $donation->Description) }}"
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" required>
        </div>

        <div style="display: flex; gap: 10px; margin-bottom: 15px;">
            <div style="flex: 1;">
                <label>الكمية:</label>
                <input type="number" name="quantity" value="{{ old('quantity', $donation->Quantity) }}"
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" required>
            </div>
            <div style="flex: 1;">
                <label>الوحدة:</label>
                <select name="unit" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    <option value="وجبة" {{ $donation->Unit == 'وجبة' ? 'selected' : '' }}>وجبة</option>
                    <option value="كيلو" {{ $donation->Unit == 'كيلو' ? 'selected' : '' }}>كيلو</option>
                    <option value="صندوق" {{ $donation->Unit == 'صندوق' ? 'selected' : '' }}>صندوق</option>
                </select>
            </div>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" style="flex: 1; padding: 12px; background: #2D6A4F; color: white; border: none; border-radius: 5px; cursor: pointer;">
                حفظ التعديلات
            </button>
            <a href="{{ route('restaurant.donations_list') }}" style="flex: 1; padding: 12px; background: #666; color: white; text-align: center; text-decoration: none; border-radius: 5px;">
                إلغاء
            </a>
        </div>
    </form>
</div>
@endsection
