@extends('admin.layout')

@section('admin_content')
<div class="box">
    <div class="page-header-wrapper">
        <div>
            <h1 class="page-title">🏢 إدارة الكيانات</h1>
            <p class="page-sub">عرض ومراجعة التراخيص، تفعيل المطاعم، وإدارة الجمعيات الخيرية</p>
        </div>
    </div>

    <div class="filter-section-wrapper">
        <form action="{{ route('admin.entities') }}" method="GET" id="adminFilterForm" class="entities-filter-form">
            <div class="filter-grid">
                <div class="filter-item search-box">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="البحث بالاسم أو رقم الترخيص..." class="admin-input" onchange="this.form.submit()">
                </div>

                <div class="filter-item">
                    <select name="status" onchange="this.form.submit()" class="admin-select">
                        <option value="">جميع الحالات</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>🟢 مفعّل</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>⏳ معلّق (بانتظار مراجعة)</option>
                    </select>
                </div>

                <div class="filter-item">
                    <select name="type" onchange="this.form.submit()" class="admin-select">
                        <option value="">جميع الأنواع</option>
                        <option value="Charity" {{ request('type') == 'Charity' ? 'selected' : '' }}>❤️ جمعية خيرية</option>
                        <option value="Restaurant" {{ request('type') == 'Restaurant' ? 'selected' : '' }}>🍴 مطعم</option>
                    </select>
                </div>

                @if(request()->has('search') || request()->has('status') || request()->has('type'))
                    <div class="filter-item">
                        <a href="{{ route('admin.entities') }}" class="clear-filter-btn">
                            إلغاء الفلاتر ✖
                        </a>
                    </div>
                @endif
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>اسم الكيان</th>
                    <th>النوع</th>
                    <th>رقم الترخيص</th>
                    <th>المسؤول</th>
                    <th class="center">الحالة</th>
                    <th>تاريخ التسجيل</th>
                    <th class="center">الإجراءات</th>
                </tr>
            </thead>

            <tbody>
                @forelse($entities as $entity)
                <tr>
                    <td>
                        <div class="entity-name-cell">
                            <strong>{{ $entity->EntityName }}</strong>
                        </div>
                    </td>
                    <td>
                        <span class="type-tag {{ $entity->EntityType == 'Charity' ? 'tag-charity' : 'tag-restaurant' }}">
                            {{ $entity->EntityType == 'Charity' ? '❤️ جمعية' : '🍴 مطعم' }}
                        </span>
                    </td>
                    <td><code class="license-code">{{ $entity->LicenseNumber }}</code></td>
                    <td>{{ $entity->manager_name }}</td>
                    <td class="center">
                        <span class="status-pill {{ $entity->IsActive ? 'st-active' : 'st-pending' }}">
                            {{ $entity->IsActive ? 'مفعّل' : 'معلّق' }}
                        </span>
                    </td>
                    <td class="date-text">{{ date('d-m-Y', strtotime($entity->created_at)) }}</td>
                    <td class="center">
                        <form action="{{ route('admin.entities.toggle', $entity->UserID) }}" method="POST">
                            @csrf
                            <button type="submit" class="toggle-btn {{ $entity->IsActive ? 'btn-deactivate' : 'btn-activate' }}">
                                @if($entity->IsActive)
                                    <span>🚫 تعطيل</span>
                                @else
                                    <span>✅ تفعيل</span>
                                @endif
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-state">
                        <img src="{{ asset('images/no-data.png') }}" style="width: 50px; opacity: 0.3; display: block; margin: 0 auto 10px;">
                        لا توجد نتائج تطابق بحثك الحالي.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('extra_css')
<style>
    /* تنسيق الفلاتر */
    .filter-section-wrapper { margin-bottom: 25px; background: #f8fafc; padding: 15px; border-radius: 12px; }
    .filter-grid { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
    .filter-item { flex: 1; min-width: 200px; }
    .filter-item.search-box { flex: 2; }

    /* المدخلات */
    .admin-input, .admin-select {
        width: 100%; padding: 10px 15px; border: 1px solid #e2e8f0;
        border-radius: 10px; font-family: 'Cairo'; font-size: 0.9em; outline: none;
    }
    .admin-input:focus { border-color: var(--admin-green); }

    .clear-filter-btn { color: #e74c3c; text-decoration: none; font-size: 0.85em; font-weight: 700; white-space: nowrap; }

    /* الكيانات (Tags) */
    .type-tag { padding: 4px 10px; border-radius: 6px; font-size: 0.8em; font-weight: 700; }
    .tag-charity { background: #fff1f2; color: #e11d48; }
    .tag-restaurant { background: #f0f9ff; color: #0284c7; }

    .license-code { background: #f1f5f9; padding: 2px 6px; border-radius: 4px; color: #475569; font-family: monospace; }

    /* الحالة (Status) */
    .status-pill { padding: 5px 12px; border-radius: 50px; font-size: 0.75em; font-weight: 800; color: white; }
    .st-active { background: #10b981; }
    .st-pending { background: #f59e0b; }

    /* أزرار الإجراءات */
    .toggle-btn {
        padding: 7px 15px; border: none; border-radius: 8px;
        cursor: pointer; font-family: 'Cairo'; font-size: 0.85em;
        font-weight: 700; transition: 0.3s; width: 110px;
    }
    .btn-activate { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .btn-deactivate { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }
    .toggle-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 6px rgba(0,0,0,0.05); }

    /* الجدول */
    .admin-table { width: 100%; border-collapse: collapse; min-width: 900px; }
    .admin-table th { background: #f8fafc; padding: 15px; text-align: right; color: #64748b; font-size: 0.9em; border-bottom: 2px solid #edf2f7; }
    .admin-table td { padding: 15px; border-bottom: 1px solid #edf2f7; vertical-align: middle; }
    .center { text-align: center !important; }
    .date-text { color: #94a3b8; font-size: 0.85em; }
    .empty-state { text-align: center; padding: 60px !important; color: #94a3b8; }

    /* التجاوب مع الجوال */
    @media (max-width: 768px) {
        .filter-grid { flex-direction: column; align-items: stretch; }
        .filter-item { width: 100%; }
        .clear-filter-btn { display: block; text-align: center; margin-top: 10px; }
    }
</style>
@endsection
