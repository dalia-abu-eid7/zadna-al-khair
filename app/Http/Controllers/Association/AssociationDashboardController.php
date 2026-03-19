<?php

namespace App\Http\Controllers\Association;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AssociationDashboardController extends Controller
{
    // 1. لوحة التحكم الرئيسية
    public function index()
    {
        $associationId = Auth::user()->EntityID;

        $coordinatingDonations = DB::table('donations')
            ->join('entities as restaurant', 'donations.DonatingEntityID', '=', 'restaurant.EntityID')
            ->where('donations.StatusID', 2) // مقبول وقيد التنسيق
            ->where('donations.ReceivingEntityID', $associationId)
            ->select(
                'donations.*',
                'restaurant.EntityName as RestaurantName',
                DB::raw("(SELECT PhoneNumber FROM users WHERE EntityID = donations.DonatingEntityID LIMIT 1) as RestaurantPhone")
            )
            ->get();

        $stats = [
            'partner_restaurants' => DB::table('donations')->where('ReceivingEntityID', $associationId)->distinct('DonatingEntityID')->count(),
            'coordinating'        => $coordinatingDonations->count(),
            'distributed'         => DB::table('donations')->where('ReceivingEntityID', $associationId)->where('StatusID', 3)->sum('Quantity') ?? 0,
            'accepted_total'      => DB::table('donations')->where('ReceivingEntityID', $associationId)->count(),
        ];

        return view('association.dashboard', compact('stats', 'coordinatingDonations'));
    }

    // 2. التبرعات المتاحة (المعروضة من المطاعم)
    public function availableDonations()
    {
        $donations = DB::table('donations')
            ->leftJoin('entities as restaurant', 'donations.DonatingEntityID', '=', 'restaurant.EntityID')
            ->where('donations.StatusID', 1) // حالة متاح
            ->whereNull('donations.ReceivingEntityID')
            ->select(
                'donations.*',
                DB::raw("IFNULL(restaurant.EntityName, 'مطعم غير معروف') as RestaurantName")
            )
            ->latest()
            ->get();

        return view('association.available_donations', compact('donations'));
    }

    // 3. معالجة زر "قبول التبرع" (هذه الدالة التي كانت تنقصك وتسبب الخطأ)
    public function acceptDonation($id)
    {
        $associationId = Auth::user()->EntityID;

        DB::table('donations')
            ->where('DonationID', $id)
            ->where('StatusID', 1)
            ->update([
                'StatusID' => 2, // تحويله لمقبول
                'ReceivingEntityID' => $associationId,
                'updated_at' => now()
            ]);

        return redirect()->route('association.dashboard')->with('success', 'تم قبول التبرع بنجاح، يظهر الآن في لوحة التحكم.');
    }

    // 4. سجل التبرعات المقبولة
    public function acceptedDonations()
    {
        $associationId = Auth::user()->EntityID;

        $acceptedDonations = DB::table('donations')
            ->join('entities as restaurant', 'donations.DonatingEntityID', '=', 'restaurant.EntityID')
            ->where('donations.StatusID', 2)
            ->where('donations.ReceivingEntityID', $associationId)
            ->select(
                'donations.*',
                'restaurant.EntityName as RestaurantName',
                DB::raw("(SELECT PhoneNumber FROM users WHERE EntityID = donations.DonatingEntityID LIMIT 1) as RestaurantPhone")
            )
            ->get();

        return view('association.accepted_donations', compact('acceptedDonations'));
    }

    // 5. تأكيد الاستلام النهائي
    public function confirmReceipt($id)
    {
        DB::table('donations')
            ->where('DonationID', $id)
            ->where('ReceivingEntityID', Auth::user()->EntityID)
            ->update(['StatusID' => 3]); // تحويل الحالة لمكتمل

        return redirect()->back()->with('success', 'تم تأكيد الاستلام بنجاح!');
    }
}
