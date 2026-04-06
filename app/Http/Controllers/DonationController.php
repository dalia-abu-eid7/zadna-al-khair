<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    public function create()
    {
        return view('donations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Description' => 'required',
            'Quantity'    => 'required|numeric',
            'Unit'        => 'required',
        ]);

        try {

$userEntity = DB::table('user_entity_mappings')
                ->where('UserID', auth()->id())
                ->first();


if (!$userEntity) {
    return redirect()->back()->with('error', 'حسابك غير مرتبط بمطعم!');
}
            $donation = Donation::create([
                'Description'          => $request->Description,
                'Quantity'             => $request->Quantity,
                'Unit'                 => $request->Unit,
                'ExpiryInfo'           => $request->ExpiryInfo,
                'PickupTimeSuggestion' => $request->PickupTimeSuggestion,
                'StatusID'             => 1, // متاح
                'DonatingEntityID'     => $userEntity->EntityID,
            ]);

            $notificationsData = [];

            $associations = User::where('RoleID', 3)->get();

            foreach ($associations as $assoc) {
                $notificationsData[] = [
                    'UserID'      => $assoc->id,
                    'SourceTable' => 'donations',
                    'SourceID'    => $donation->DonationID,
                    'Type'        => 1,
                    'Message'     => "تبرع جديد متاح: " . $request->Description,
                    'IsRead'      => 0,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }

            $notificationsData[] = [
                'UserID'      => 1,
                'SourceTable' => 'donations',
                'SourceID'    => $donation->id,
                'Type'        => 1,
                'Message'     => "قام مطعم بإضافة تبرع جديد: " . $request->Description,
                'IsRead'      => 0,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];

            DB::table('notifications')->insert($notificationsData);

            return redirect()->route('restaurant.donations_list')->with('success', 'تم حفظ التبرع وإبلاغ الجمعيات بنجاح!');

        } catch (\Exception $e) {
            dd("حدث خطأ تقني أثناء الحفظ: " . $e->getMessage());
        }
    }
}
