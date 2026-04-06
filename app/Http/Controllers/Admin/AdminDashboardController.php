<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Entity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\StatsExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalDonations = DB::table('donations')->count();
        $totalEntities = Entity::count();

        $pendingEntitiesCount = User::where('IsActive', 0)
            ->whereIn('RoleID', [2, 3])
            ->count();

        $latestPending = User::where('IsActive', 0)
            ->whereIn('RoleID', [2, 3])
            ->latest()
            ->take(5)
            ->get();

        $recentActivities = DB::table('donation_history')
            ->join('users', 'donation_history.ChangedByUserID', '=', 'users.id')
            ->join('donations', 'donation_history.DonationID', '=', 'donations.DonationID')
            ->join('donation_statuses', 'donation_history.StatusID', '=', 'donation_statuses.StatusID')
            ->leftJoin('user_entity_mappings', 'users.id', '=', 'user_entity_mappings.UserID')
            ->leftJoin('entities', 'user_entity_mappings.EntityID', '=', 'entities.EntityID')
            ->select(
                'donation_history.*',
                'users.name as UserName',
                'entities.EntityName',
                'donations.Description as DonationTitle',
                'donation_statuses.StatusName'
            )
            ->latest('donation_history.ChangeTimestamp')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalDonations',
            'totalEntities',
            'pendingEntitiesCount',
            'latestPending',
            'recentActivities'
        ));
    }

    public function manageEntities(Request $request)
    {
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

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('entities.EntityName', 'like', "%$search%")
                  ->orWhere('entities.LicenseNumber', 'like', "%$search%");
            });
        }

        if ($request->filled('status')) {
            $query->where('users.IsActive', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('entities.EntityType', $request->type);
        }

        $entities = $query->latest('users.created_at')->get();
        return view('admin.entities', compact('entities'));
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        $user->IsActive = !$user->IsActive;
        $user->save();

        $statusMessage = $user->IsActive ? 'تم تفعيل الحساب بنجاح' : 'تم تعطيل الحساب بنجاح';
        return back()->with('success', $statusMessage);
    }

    public function manageUsers(Request $request)
    {
        $query = User::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        $users = $query->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function manageDonations(Request $request)
    {
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

        if ($request->filled('status')) {
            $query->where('donations.StatusID', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('donor.EntityName', 'like', "%$search%")
                  ->orWhere('receiver.EntityName', 'like', "%$search%");
            });
        }

        $donations = $query->latest('donations.created_at')->paginate(10);
        return view('admin.donations', compact('donations'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'تم حذف المستخدم بنجاح من النظام.');
    }

    public function exportStats()
    {
        $data = [
            'totalUsers'     => User::count(),
            'totalDonations' => DB::table('donations')->count(),
            'totalEntities'  => Entity::count(),
            'pending'        => User::where('IsActive', 0)->whereIn('RoleID', [2, 3])->count(),
            'date'           => now()->format('Y-m-d H:i')
        ];

        return Excel::download(new StatsExport($data), 'تقرير_إحصائيات_زادنا.xlsx');
    }
}
