<?php

namespace App\Http\Controllers\Association;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\UserEntityMapping;
use App\Models\User;
use App\Models\Entity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssociationDashboardController extends Controller
{
    private function getEntityMapping() {
        return UserEntityMapping::where('UserID', Auth::id())->first();
    }

    public function index() {
        $mapping = $this->getEntityMapping();
        if (!$mapping) return redirect()->route('login');

        $coordinatingDonations = Donation::with(['donatingEntity'])
            ->where('ReceivingEntityID', $mapping->EntityID)
            ->where('StatusID', 2)
            ->get()
            ->map(function ($donation) {
                $owner = User::whereHas('entities', fn($q) => $q->where('entities.EntityID', $donation->DonatingEntityID))->first();
                $donation->RestaurantPhone = $owner->PhoneNumber ?? 'غير متوفر';
                return $donation;
            });

        $stats = [
            'partner_restaurants' => Donation::where('ReceivingEntityID', $mapping->EntityID)->distinct('DonatingEntityID')->count('DonatingEntityID'),
            'coordinating'        => $coordinatingDonations->count(),
            'distributed'         => Donation::where('ReceivingEntityID', $mapping->EntityID)->where('StatusID', 3)->sum('Quantity') ?? 0,
            'accepted_total'      => Donation::where('ReceivingEntityID', $mapping->EntityID)->count(),
        ];

        return view('association.dashboard', compact('stats', 'coordinatingDonations'));
    }

    public function availableDonations() {
        $donations = Donation::with('donatingEntity')
            ->where('StatusID', 1)
            ->whereNull('ReceivingEntityID')
            ->get();
        return view('association.available_donations', compact('donations'));
    }


public function acceptDonation($id) {
    $mapping = $this->getEntityMapping();
    $donation = Donation::findOrFail($id);

    $donation->update([
        'StatusID' => 2,
        'ReceivingEntityID' => $mapping->EntityID
    ]);


    DB::table('donation_history')->insert([
        'DonationID'      => $id,
        'StatusID'        => 2,
        'ChangedByUserID' => Auth::id(),
        'ChangeTimestamp' => now(),
    ]);

    return redirect()->route('association.accepted_donations')->with('success', 'تم قبول التبرع!');
}



    public function acceptedDonations() {
        $mapping = $this->getEntityMapping();
        $acceptedDonations = Donation::with('donatingEntity')
            ->where('ReceivingEntityID', $mapping->EntityID)
            ->whereIn('StatusID', [2, 3])
            ->get()
            ->map(function ($donation) {
                $owner = User::whereHas('entities', fn($q) => $q->where('entities.EntityID', $donation->DonatingEntityID))->first();
                $donation->RestaurantName = $donation->donatingEntity->EntityName ?? 'غير معروف';
                $donation->RestaurantPhone = $owner->PhoneNumber ?? 'غير متوفر';
                return $donation;
            });

        return view('association.accepted_donations', compact('acceptedDonations'));
    }

  
public function confirm_receipt($id) {
    Donation::findOrFail($id)->update(['StatusID' => 3]);


    DB::table('donation_history')->insert([
        'DonationID'      => $id,
        'StatusID'        => 3,
        'ChangedByUserID' => Auth::id(),
        'ChangeTimestamp' => now(),
    ]);

    return back()->with('success', 'تم تأكيد الاستلام!');
}

    public function partnerRestaurants() {
        $mapping = $this->getEntityMapping();
        $partnerIds = Donation::where('ReceivingEntityID', $mapping->EntityID)->distinct()->pluck('DonatingEntityID');

        $restaurants = Entity::whereIn('EntityID', $partnerIds)->get()->map(function($res) {
            $user = User::whereHas('entities', fn($q) => $q->where('entities.EntityID', $res->EntityID))->first();
            $res->phone = $user->PhoneNumber ?? 'غير متوفر';
            return $res;
        });

        return view('association.partner_restaurants', compact('restaurants'));
    }
}
