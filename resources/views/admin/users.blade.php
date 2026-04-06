@extends('admin.layout')

@section('admin_content')
<div class="box">
    <div class="page-header-wrapper">
        <div>
            <h1 class="page-title">👥 إدارة المستخدمين</h1>
            <p class="page-sub">التحكم في حسابات النظام، تفعيلها، أو حذفها</p>
        </div>

        <form action="{{ route('admin.users') }}" method="GET" class="filter-container">
            <div class="search-group">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="بحث عن اسم، بريد، أو هاتف..." class="admin-input" onchange="this.form.submit()">
                <button type="submit" class="admin-btn-search">🔍</button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>المستخدم</th>
                    <th>التواصل</th>
                    <th>الدور</th>
                    <th class="center">الحالة</th>
                    <th>منذ</th>
                    <th class="center">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="user-info-cell">
                            <div class="user-avatar">{{ mb_substr($user->name, 0, 1) }}</div>
                            <div>
                                <strong>{{ $user->name }}</strong><br>
                                <small class="muted-text">ID: #{{ $user->id }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-size: 0.9em;">📧 {{ $user->email }}</span><br>
                        <span style="font-size: 0.85em; color: #64748b;">📞 {{ $user->PhoneNumber ?? '—' }}</span>
                    </td>
                    <td>
                        @php
                            $roleClass = ['1' => 'purple', '2' => 'blue', '3' => 'orange'];
                            $roleNames = ['1' => 'مدير نظام', '2' => 'جمعية', '3' => 'مطعم'];
                            $currentRole = $roleClass[$user->RoleID] ?? 'green';
                            $roleName = $roleNames[$user->RoleID] ?? 'متبرع';
                        @endphp
                        <span class="role-badge {{ $currentRole }}">{{ $roleName }}</span>
                    </td>
                    <td class="center">
                        <span class="status-dot {{ $user->IsActive ? 'active' : 'suspended' }}">
                            {{ $user->IsActive ? 'مفعّل' : 'معطّل' }}
                        </span>
                    </td>
                    <td class="date-text">
                        {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->diffForHumans() : '—' }}
                    </td>
                    <td class="center">
                        <div class="actions-flex">
                            <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-action {{ $user->IsActive ? 'btn-warn' : 'btn-success' }}"
                                        title="{{ $user->IsActive ? 'تعطيل الحساب' : 'تفعيل الحساب' }}">
                                    {!! $user->IsActive ? '🚫' : '✅' !!}
                                </button>
                            </form>

                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                  onsubmit="return confirm('⚠️ هل أنت متأكد؟ سيتم حذف المستخدم نهائياً!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-danger" title="حذف نهائي">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="empty-state">لم يتم العثور على أي مستخدمين</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('extra_css')
<style>
    /* التنسيقات الخاصة بصفحة المستخدمين */
    .user-info-cell { display: flex; align-items: center; gap: 12px; }
    .user-avatar {
        width: 35px; height: 35px; background: #e2e8f0;
        border-radius: 8px; display: flex; align-items: center;
        justify-content: center; font-weight: bold; color: var(--admin-green);
    }

    /* الروابط والأدوار */
    .role-badge {
        padding: 4px 10px; border-radius: 6px; font-size: 0.75em; font-weight: 700;
    }
    .role-badge.purple { background: #f5f3ff; color: #7c3aed; }
    .role-badge.blue { background: #eff6ff; color: #2563eb; }
    .role-badge.orange { background: #fff7ed; color: #ea580c; }
    .role-badge.green { background: #f0fdf4; color: #16a34a; }

    /* حالة الحساب */
    .status-dot {
        font-size: 0.8em; font-weight: 600; padding: 4px 12px; border-radius: 50px;
    }
    .status-dot.active { background: #dcfce7; color: #15803d; }
    .status-dot.suspended { background: #fee2e2; color: #dc2626; }

    /* الأزرار */
    .actions-flex { display: flex; gap: 8px; justify-content: center; }
    .btn-action {
        border: none; width: 32px; height: 32px; border-radius: 8px;
        cursor: pointer; transition: 0.2s; display: flex; align-items: center; justify-content: center;
    }
    .btn-warn { background: #fffbeb; }
    .btn-success { background: #f0fdf4; }
    .btn-danger { background: #fef2f2; }
    .btn-action:hover { transform: translateY(-2px); filter: brightness(0.9); }

    /* تحسين البحث */
    .filter-container { width: 100%; max-width: 400px; }
    .search-group { display: flex; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0; overflow: hidden; }
    .admin-input { border: none; background: transparent; padding: 10px 15px; flex: 1; outline: none; font-family: 'Cairo'; }
    .admin-btn-search { border: none; background: #edf2f7; padding: 0 15px; cursor: pointer; }

    /* الجدول */
    .admin-table { width: 100%; border-collapse: collapse; min-width: 800px; }
    .admin-table th { text-align: right; padding: 15px; color: #64748b; border-bottom: 2px solid #f1f5f9; }
    .admin-table td { padding: 15px; border-bottom: 1px solid #f1f5f9; }
    .center { text-align: center !important; }

    @media (max-width: 768px) {
        .page-header-wrapper { flex-direction: column; text-align: center; }
        .filter-container { max-width: 100%; }
    }
</style>
@endsection
