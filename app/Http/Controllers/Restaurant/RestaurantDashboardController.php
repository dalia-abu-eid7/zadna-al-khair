<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Entity;
use App\Models\User;

use App\Models\UserEntityMapping;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RestaurantDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $mapping = UserEntityMapping::where('UserID', $userId)->first();

        if (!$mapping) {
            return view('restaurant.dashboard', [
                'stats' => ['total_donations' => 0, 'active_now' => 0, 'total_meals' => 0, 'partners' => 0],
                'activeDonations' => collect(),
                'suggestedPartners' => collect()
            ]);
        }

        $restaurantId = $mapping->EntityID;
        $stats = [
            'total_donations' => Donation::where('DonatingEntityID', $restaurantId)->count(),
            'active_now'      => Donation::where('DonatingEntityID', $restaurantId)->whereIn('StatusID', [1, 2])->count(),
            'total_meals'     => Donation::where('DonatingEntityID', $restaurantId)->sum('Quantity') ?? 0,
            'partners'        => Donation::where('DonatingEntityID', $restaurantId)->whereNotNull('ReceivingEntityID')->distinct('ReceivingEntityID')->count('ReceivingEntityID'),
        ];

        $activeDonations = Donation::with('status')->where('DonatingEntityID', $restaurantId)->whereIn('StatusID', [1, 2])->latest()->limit(3)->get();
        $suggestedPartners = Entity::where('EntityType', 'Charity')->limit(4)->get();

        return view('restaurant.dashboard', compact('stats', 'activeDonations', 'suggestedPartners'));
    }

  public function showPartners()
{
    $userId = Auth::id();
    $mapping = UserEntityMapping::where('UserID', $userId)->first();

    if (!$mapping) {
        return redirect()->back()->with('error', 'بيانات المطعم غير مكتملة.');
    }

    $restaurantId = $mapping->EntityID;

    $partnerIds = Donation::where('DonatingEntityID', $restaurantId)
        ->whereNotNull('ReceivingEntityID')
        ->distinct()
        ->pluck('ReceivingEntityID');

    $partners = Entity::whereIn('EntityID', $partnerIds)
        ->get()
        ->map(function($entity) {
            $user = User::whereHas('entities', function($q) use ($entity) {
                $q->where('entities.EntityID', $entity->EntityID);
            })->first();

            $entity->manager_phone = $user->PhoneNumber ?? 'لا يوجد رقم';
            $entity->manager_email = $user->email ?? $entity->ContactEmail;

            return $entity;
        });

    return view('restaurant.partners', compact('partners'));
}

    public function donationsList(Request $request)
    {
        $userId = Auth::id();
        $mapping = UserEntityMapping::where('UserID', $userId)->first();
        $query = Donation::with(['status', 'receivingEntity'])->where('DonatingEntityID', $mapping->EntityID);

        if ($request->filled('status')) { $query->where('StatusID', $request->status); }
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('Description', 'LIKE', "%{$searchTerm}%")->orWhere('Quantity', 'LIKE', "%{$searchTerm}%");
            });
        }

        $donations = $query->latest()->paginate(10);
        return view('restaurant.donations_list', compact('donations'));
    }

    public function createDonation() { return view('restaurant.add_donation'); }
public function storeDonation(Request $request)
{
    // 1. التحقق من البيانات
    $request->validate([
        'Description' => 'required|string|max:255',
        'Quantity'    => 'required|numeric|min:1',
        'Unit'        => 'required',
        'PickupTimeSuggestion' => 'required',
    ]);

    $userId = Auth::id();
    $mapping = UserEntityMapping::where('UserID', $userId)->first();

    if (!$mapping) {
        return redirect()->back()->with('error', 'عذراً، لم يتم العثور على بيانات المطعم المرتبطة بحسابك.');
    }

    // 2. نحفظ التبرع في متغير اسمه $donation لكي نتمكن من استخدام الـ ID الخاص به
    $donation = Donation::create([
        'DonatingEntityID'     => $mapping->EntityID,
        'Description'          => $request->Description,
        'Quantity'             => $request->Quantity,
        'Unit'                 => $request->Unit,
        'PickupTimeSuggestion' => $request->PickupTimeSuggestion,
        'ExpiryInfo'           => $request->ExpiryInfo,
        'StatusID'             => 1, // حالة "جديد"
    ]);

    // 3. (الإضافة الجديدة) هنا نكتب السطر الذي سيجعل التبرع يظهر في لوحة الأدمن
    DB::table('donation_history')->insert([
        'DonationID'        => $donation->DonationID, // الرقم التلقائي للتبرع اللي انحفظ فوق
        'StatusID'          => 1,
        'ChangedByUserID'   => $userId,
        'ChangeTimestamp'   => now(),
        'Notes'             => 'قام المطعم بإضافة تبرع جديد للوجبات.',
        'created_at'        => now(),
        'updated_at'        => now(),
    ]);

    return redirect()->route('restaurant.donations_list')->with('success', 'تمت إضافة التبرع بنجاح، شكرًا لمساهمتكم! ✨');
}


    public function editDonation($id)
    {
        $donation = Donation::findOrFail($id);
        return view('restaurant.edit_donation', compact('donation'));
    }

    public function updateDonation(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);
        $donation->update($request->all());
        return redirect()->route('restaurant.donations_list')->with('success', 'تم التحديث بنجاح');
    }

    public function destroyDonation($id)
    {
        $donation = Donation::findOrFail($id);
        $donation->delete();
        return redirect()->route('restaurant.donations_list')->with('success', 'تم الحذف بنجاح');
    }
}
