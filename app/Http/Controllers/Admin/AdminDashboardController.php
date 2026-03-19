<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Entity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * عرض لوحة تحكم الأدمن (الرئيسية) بالأرقام الحقيقية
     */
    public function index()
    {
        // 1. إجمالي المستخدمين
        $totalUsers = User::count();

        // 2. إجمالي التبرعات
        $totalDonations = 0;
        try {
            $totalDonations = DB::table('donations')->count();
        } catch (\Exception $e) {
            $totalDonations = 0;
        }

        // 3. إجمالي الكيانات
        $totalEntities = Entity::count();

        // 4. عدد الكيانات المعلقة
        $pendingEntitiesCount = User::where('IsActive', 0)
                                    ->whereIn('RoleID', [2, 3])
                                    ->count();

        // 5. جلب آخر 5 طلبات معلقة للمهام العاجلة
        $latestPending = User::where('IsActive', 0)
                             ->whereIn('RoleID', [2, 3])
                             ->latest()
                             ->take(5)
                             ->get();

        return view('admin.dashboard', [
            'totalUsers'           => $totalUsers,
            'totalDonations'       => $totalDonations,
            'totalEntities'        => $totalEntities,
            'pendingEntitiesCount' => $pendingEntitiesCount,
            'latestPending'        => $latestPending
        ]);
    }




    /**
     * عرض صفحة إدارة الكيانات مع (البحث والفلترة)
     */
    public function manageEntities(Request $request)
    {
        // بناء الاستعلام الأساسي مع الربط بين الجداول
        $query = DB::table('entities')
            ->join('user_entity_mappings', 'entities.EntityID', '=', 'user_entity_mappings.EntityID')
            ->join('users', 'user_entity_mappings.UserID', '=', 'users.id')
            ->select(
                'entities.*',
                'users.name as manager_name',
                'users.IsActive',
                'users.id as UserID',
                'users.created_at'
            );

        // 1. فلتر البحث (بالاسم أو رقم الترخيص)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('entities.EntityName', 'like', "%$search%")
                  ->orWhere('entities.LicenseNumber', 'like', "%$search%");
            });
        }

        // 2. فلتر الحالة (مفعل = 1، معلق = 0)
        if ($request->filled('status')) {
            $query->where('users.IsActive', $request->status);
        }

        // 3. فلتر النوع (Charity أو Restaurant)
        if ($request->filled('type')) {
            $query->where('entities.EntityType', $request->type);
        }

        // جلب النتائج وترتيبها من الأحدث للأقدم
        $entities = $query->latest('users.created_at')->get();

        return view('admin.entities', compact('entities'));
    }

    /**
     * تفعيل أو تعطيل حساب الكيان
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        // تغيير الحالة (إذا 1 تصير 0، وإذا 0 تصير 1)
        $user->IsActive = !$user->IsActive;
        $user->save();

        return back()->with('success', 'تم تحديث حالة الكيان بنجاح');
    }



//ادارة المستخدمين
    public function manageUsers(Request $request)
{
    // جلب المستخدمين مع البحث
    $query = User::query();

    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
    }

    // جلب المستخدمين وترتيبهم (يمكنك استخدام paginate إذا كان العدد كبيراً)
    $users = $query->latest()->get();

    return view('admin.users', compact('users'));
}


//سجل التبرعات

public function manageDonations(Request $request)
{
    // الربط مع الجداول لجلب الأسماء والحالات
    $query = DB::table('donations')
        ->join('entities as donor', 'donations.DonatingEntityID', '=', 'donor.EntityID')
        ->leftJoin('entities as receiver', 'donations.ReceivingEntityID', '=', 'receiver.EntityID')
        ->leftJoin('donation_statuses', 'donations.StatusID', '=', 'donation_statuses.StatusID')
        ->select(
            'donations.*',
            'donor.EntityName as donor_name',
            'receiver.EntityName as receiver_name',
            'donation_statuses.StatusName'
        );

    // برمجة فلترة "جميع الحالات"
    if ($request->filled('status')) {
        $query->where('donations.StatusID', $request->status);
    }

    // برمجة البحث العلوي
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('donor.EntityName', 'like', "%$search%")
              ->orWhere('receiver.EntityName', 'like', "%$search%");
        });
    }

    $donations = $query->latest('donations.created_at')->paginate(10);
    return view('admin.donations', compact('donations'));
}

}
