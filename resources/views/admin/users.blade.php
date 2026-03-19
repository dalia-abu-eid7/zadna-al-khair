@extends('admin.layout')

@section('admin_content')
    <form action="{{ route('admin.users') }}" method="GET" class="top-search">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث عن اسم المستخدم أو البريد..." onchange="this.form.submit()">
        <span class="bell">🔔</span>
    </form>

    <div class="page-header">
        <div>
            <h1 class="page-title">المستخدمين</h1>
            <p class="page-sub">إدارة جميع مستخدمي النظام وصلاحياتهم</p>
        </div>
    </div>

    <h3 class="section-title">قائمة المستخدمين</h3>

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>الاسم كامل</th>
                    <th>البريد الإلكتروني</th>
                    <th>رقم الهاتف</th>
                    <th>الدور</th>
                    <th>الحالة</th>
                    <th>تاريخ التسجيل</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? 'غير مسجل' }}</td>
                    <td>
                        {{-- تلوين الدور بناءً على النوع --}}
                        @if($user->RoleID == 1)
                            <span class="role purple">مدير نظام</span>
                        @elseif($user->RoleID == 2)
                            <span class="role blue">ممثل جمعية</span>
                        @elseif($user->RoleID == 3)
                            <span class="role orange">مدير مطعم</span>
                        @else
                            <span class="role green">متبرع</span>
                        @endif
                    </td>
                    <td>
                        <span class="status {{ $user->IsActive ? 'active' : 'suspended' }}">
                            {{ $user->IsActive ? 'مفعّل' : 'معطّل' }}
                        </span>
                    </td>
<td>{{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->diffForHumans() : 'غير متوفر' }}</td>                    <td>
                        {{-- زر التفعيل والتعطيل --}}
                        <form action="{{ route('admin.entities.toggle', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-action" style="border:none; background:none; cursor:pointer;">
                                {!! $user->IsActive ? '🚫' : '✅' !!}
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;">لا يوجد مستخدمين حالياً</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
