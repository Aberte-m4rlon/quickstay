<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use App\Models\PropertyFeedback; // ✅ Add this model for feedback and ratings
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Existing dashboard data
        $verified = Property::where('is_verified', true)->count();
        $pending = Property::where('is_verified', false)->count();
        $owners = User::where('role', 'owner')->count();
        $renters = User::where('role', 'renter')->count();

        $properties = Property::with('owner')->orderBy('created_at', 'desc')->get();

        // ✅ New: Gather feedback/ratings summary
        $averageRating = PropertyFeedback::avg('rating') ?? 0;
        $totalFeedbacks = PropertyFeedback::count();
        $properties = Property::with(['owner', 'feedbacks'])->latest()->get();

        return view('admin.dashboard', compact(
            'verified',
            'pending',
            'owners',
            'renters',
            'properties',
            'averageRating',     // ✅ Added
            'totalFeedbacks'     // ✅ Added
        ));
    }

    public function properties()
    {
        $properties = Property::with('owner')->latest()->get();
        return view('admin.dashboard', compact('properties'));
    }

    public function approve($id)
    {
        $property = Property::findOrFail($id);
        $property->is_verified = true;
        $property->save();

        return redirect()->back()->with('success', 'Property approved successfully!');
    }
  public function info()
        {
            $totalUsers = \App\Models\User::count();
            $totalProperties = \App\Models\Property::count();
            $averageRating = round(\App\Models\PropertyFeedback::avg('rating') ?? 0, 2);

            // Add users data for the table
            $users = \App\Models\User::latest()->paginate(10);

            return view('admin.info', compact('totalUsers', 'totalProperties', 'averageRating', 'users'));
        }
        public function profile()
        {
            $user = auth()->user();
            return view('admin.profile', compact('user'));
        }

}
