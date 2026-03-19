<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation; // استدعاء الموديل لسهولة الاستخدام

class DonationController extends Controller
{
    //
    // هذه الدالة وظيفتها فقط عرض صفحة "إضافة تبرع"
public function create()
{
    return view('donations.create');
}

// هذه الدالة وظيفتها استلام البيانات وحفظها (سنبرمجها في الخطوة القادمة)
// لا تنسي إضافة هذا السطر في أعلى الملف تحت كلمة namespace


public function store(Request $request)
{
    $validatedData = $request->validate([
            'Description'          => 'required|string|min:3',
            'Quantity'             => 'required|numeric',
            'Unit'                 => 'required|string',
            'ExpiryInfo'           => 'nullable|string',
            'PickupTimeSuggestion' => 'nullable',
        ]);
  try {
        Donation::create([
            'Description'          => $request->Description,
            'Quantity'             => $request->Quantity,
            'Unit'                 => $request->Unit,
            'ExpiryInfo'           => $request->ExpiryInfo,
            'PickupTimeSuggestion' => $request->PickupTimeSuggestion,
            'StatusID'             => 1,
            'DonatingEntityID'     => 1,
        ]);
return redirect()->back()->with('success', '✅ تم إرسال تبرعك بنجاح! شكراً لمساهمتك.');
    }
    catch (\Exception $e) {
        // هذا السطر سيطبع لكِ الخطأ الحقيقي "ليش ما عم تحفظ"
return back()->withInput()->with('error', 'عذراً، حدث خطأ أثناء الحفظ: ' . $e->getMessage());    }
}
}

