<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RenterProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('renter.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            $filename = time().'.'.$request->profile_photo->getClientOriginalExtension();
            $path = $request->file('profile_photo')->storeAs('profile_photos', $filename, 'public');
            $user->profile_photo = $path;
        }

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
