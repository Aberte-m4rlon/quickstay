<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $propertyId)
    {
        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'property_id' => $propertyId,
            'user_id' => auth()->id(),
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ]);

        return back()->with('success', 'Review posted.');
    }
}
