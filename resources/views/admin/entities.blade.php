@extends('admin.layout')

@section('admin_content')
    {{-- وضعنا كل أدوات التحكم داخل فورم واحد يرسل البيانات للكنترولر --}}
    <form action="{{ route('admin.entities') }}" method="GET" id="adminFilterForm">

        <div class="top-search">
            {{-- تفعيل مربع البحث --}}
            <input type="text" name="search" value="{{ request('search') }}" placeholder="البحث بالاسم أو رقم الترخيص..." onchange="this.form.submit()">
            <span class="bell">🔔</span>
        </div>

        <h1 class="page-title">إدارة الكيانات</h1>
        <p class="page-sub">عرض ومراجعة كل الجمعيات والمطاعم المسجلة</p>

        <div class="filters">
            {{-- فلتر الحالة --}}
            <select name="status" onchange="this.form.submit()">
                <option value="">جميع الحالات</option>
                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>مفعّل</option>
                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>معلّق</option>
            </select>

            {{-- فلتر النوع --}}
            <select name="type" onchange="this.form.submit()">
                <option value="">جميع الأنواع</option>
                <option value="Charity" {{ request('type') == 'Charity' ? 'selected' : '' }}>جمعية خيرية</option>
                <option value="Restaurant" {{ request('type') == 'Restaurant' ? 'selected' : '' }}>مطعم</option>
            </select>

            {{-- زر لمسح الفلاتر يظهر فقط عند وجود بحث --}}
            @if(request()->has('search') || request()->has('status') || request()->has('type'))
                <a href="{{ route('admin.entities') }}" style="font-size: 12px; color: #e74c3c; text-decoration: none; margin-right: 10px;">إلغاء الفلاتر ✖</a>
            @endif
        </div>
    </form>

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>اسم الكيان</th>
                    <th>نوع الكيان</th>
                    <th>رقم الترخيص</th>
                    <th>جهة الاتصال</th>
                    <th>حالة الكيان</th>
                    <th>تاريخ الإنشاء</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>

            <tbody>
                @forelse($entities as $entity)
                <tr>
                    <td>{{ $entity->EntityName }}</td>
                    <td>{{ $entity->EntityType == 'Charity' ? '❤️ جمعية خيرية' : '🍴 مطعم' }}</td>
                    <td>{{ $entity->LicenseNumber }}</td>
                    <td>{{ $entity->manager_name }}</td>
                    <td>
                        <span class="status {{ $entity->IsActive ? 'active' : 'suspended' }}">
                            {{ $entity->IsActive ? 'مفعّل' : 'معلّق' }}
                        </span>
                    </td>
                    <td>{{ date('d-m-Y', strtotime($entity->created_at)) }}</td>
                    <td>
                        <form action="{{ route('admin.entities.toggle', $entity->UserID) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-action" style="cursor:pointer; border:none; background:none;">
                                @if($entity->IsActive)
                                    <span title="تعطيل الحساب">🚫تعطيل الحساب </span>
                                @else
                                    <span title="تفعيل الحساب">✅ تفعيل الحساب</span>
                                @endif
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #888;">
                        لا توجد نتائج تطابق بحثك الحالي.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
