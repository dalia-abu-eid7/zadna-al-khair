<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RestaurantDashboardController extends Controller
{

    // عرض لوحة التحكم الرئيسية
    public function index()
    {
        $restaurantId = Auth::user()->EntityID;

        $stats = [
            'total_donations' => DB::table('donations')->where('DonatingEntityID', $restaurantId)->count(),
            'active_now'      => DB::table('donations')->where('DonatingEntityID', $restaurantId)->whereIn('StatusID', [1, 2])->count(),
            'total_meals'     => DB::table('donations')->where('DonatingEntityID', $restaurantId)->sum('Quantity') ?? 0,
            'partners'        => DB::table('donations')->where('DonatingEntityID', $restaurantId)->whereNotNull('ReceivingEntityID')->distinct('ReceivingEntityID')->count('ReceivingEntityID'),
        ];

        $activeDonations = DB::table('donations')
            ->leftJoin('donation_statuses', 'donations.StatusID', '=', 'donation_statuses.StatusID')
            ->where('donations.DonatingEntityID', $restaurantId)
            ->select('donations.*', 'donation_statuses.StatusName')
            ->latest('donations.created_at')
            ->limit(3)
            ->get();

        return view('restaurant.dashboard', compact('stats', 'activeDonations'));
    }

    // عرض صفحة سجل التبرعات مع البحث والفلترة
    public function donationsList(Request $request)
    {
        $restaurantId = Auth::user()->EntityID;

        $query = DB::table('donations')
            ->leftJoin('donation_statuses', 'donations.StatusID', '=', 'donation_statuses.StatusID')
            ->leftJoin('entities as receiver', 'donations.ReceivingEntityID', '=', 'receiver.EntityID')
            ->where('donations.DonatingEntityID', $restaurantId)
            ->select(
                'donations.*',
                'donation_statuses.StatusName',
                'receiver.EntityName as ReceiverName'
            );

        // 1. فلترة البحث النصي (وصف التبرع)
        if ($request->filled('search')) {
            $query->where('donations.Description', 'like', '%' . $request->search . '%');
        }

        // 2. فلترة الأزرار (الحالات 1, 2, 3, 4)
        if ($request->filled('status')) {
            $query->where('donations.StatusID', $request->status);
        }

        $donations = $query->latest('donations.created_at')->paginate(10);

        return view('restaurant.donations_list', compact('donations'));
    }

    // فتح صفحة إضافة تبرع
    public function createDonation()
    {
        return view('restaurant.add_donation');
    }


    // حفظ التبرع الجديد
    public function storeDonation(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'quantity' => 'required|numeric',
            'unit' => 'required',
        ]);

        DB::table('donations')->insert([
            'DonatingEntityID' => Auth::user()->EntityID,
            'Description' => $request->description,
            'Quantity' => $request->quantity,
            'Unit' => $request->unit,
            'StatusID' => 1, // متاح تلقائياً
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('restaurant.donations_list')->with('success', 'تمت إضافة التبرع بنجاح');
    }
}
