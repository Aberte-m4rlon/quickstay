<?php

namespace App\Http\Controllers\Renter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\User;
class SearchController extends Controller
{
    public function index(Request $request)
{
    $query = Property::query();

    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('address', 'like', "%{$search}%");
        });
    }

    $properties = $query->orderBy('created_at', 'desc')->get();

    // ✅ Add this line to define $users
    $users = User::where('id', '!=', auth()->id())->get();

    return view('renter.dashboard', compact('properties', 'users'));
}
    public function show($id)   
    {
        $property = Property::with('owner')->findOrFail($id);
        return view('renter.show', compact('property'));
    }
}
