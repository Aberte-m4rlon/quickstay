<?php

namespace App\Http\Controllers;

use App\Models\PropertyFeedback;
use Illuminate\Http\Request;

class PropertyFeedbackController extends Controller
{
    public function store(Request $request, $propertyId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        PropertyFeedback::create([
            'property_id' => $propertyId,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Thank you for your feedback!');
    }
    
}


