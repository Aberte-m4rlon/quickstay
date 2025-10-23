<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index() {
        return view('admin.profile'); // or 'admin.info', 'admin.users'
    }
    public function edit(Request $request)
    {
        return view('admin.profile.edit', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        // Accept either contact_number or phone, and either profile_photo or avatar.
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'contact_number' => ['nullable', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ];

        $validated = $request->validate($rules);

        $data = [];

        // Basic fields
        $data['name'] = $validated['name'];
        $data['email'] = $validated['email'];

        // Normalize phone/contact number into a single DB field `contact_number`
        if (!empty($validated['phone'])) {
            $data['contact_number'] = $validated['phone'];
        } elseif (!empty($validated['contact_number'])) {
            $data['contact_number'] = $validated['contact_number'];
        }

        // Address (if present)
        if (array_key_exists('address', $validated)) {
            $data['address'] = $validated['address'];
        }

        // Handle avatar/profile photo upload (prefer profile_photo, then avatar)
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            // Save public URL so views using auth()->user()->avatar work
            $data['avatar'] = Storage::url($path);
        } elseif ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('profile_photos', 'public');
            $data['avatar'] = Storage::url($path);
        }

        // Password handling (hash if provided)
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        // Update user with collected data
        $user->update($data);

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }
}
