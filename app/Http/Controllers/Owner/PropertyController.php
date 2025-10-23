<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    // ✅ Show Owner Dashboard
    public function index()
    {
        $user = auth()->user();
        $properties = Property::where('owner_id', $user->id)->latest()->get();

        $available = $properties->where('status', 'available')->count();
        $partial = $properties->where('status', 'partial')->count();
        $full = $properties->where('status', 'full')->count();

        return view('owner.dashboard', compact('properties', 'available', 'partial', 'full'));
    }

    // ✅ Create Property Form
    public function create()
    {
        return view('owner.properties.create');
    }

    // ✅ Store Property
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('properties', 'public');
        }

        \App\Models\Property::create([
            'owner_id' => auth()->id(),
            'title' => $request->title,
            'address' => $request->address,
            'description' => $request->description,
            'price' => $request->price,
            'status' => $request->status,
            'is_verified' => false, // admin verifies later
            'image_url' => $path ? "/storage/$path" : null,
        ]);

        return redirect()->route('owner.dashboard')
            ->with('success', 'Property added successfully!');
    }


    // ✅ Edit Form
    public function edit($id)
    {
        $property = Property::findOrFail($id);
        return view('owner.properties.edit', compact('property'));
    }

    // ✅ Update Property
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,partial,full',
        ]);

        $property = Property::findOrFail($id);
        $property->update($request->only(['title', 'address', 'price', 'status']));

        return redirect()->route('owner.dashboard')->with('success', 'Property updated successfully!');
    }

    // ✅ Delete Property
    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return redirect()->route('owner.dashboard')->with('success', 'Property deleted successfully!');
    }

    // ✅ Update Status (Available / Partial / Full)
    public function updateStatus(Request $request, $id)
    {
        $property = Property::findOrFail($id);
        $property->status = $request->status;
        $property->save();

        return redirect()->route('owner.dashboard')->with('success', 'Status updated successfully!');
    }
}
