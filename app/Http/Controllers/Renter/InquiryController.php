<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function store(Request $request, $propertyId)
    {
        $data = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Inquiry::create([
            'property_id' => $propertyId,
            'user_id' => auth()->id(),
            'message' => $data['message'],
            'status' => 'new',
        ]);

        return back()->with('success', 'Inquiry sent to owner.');
    }
}
