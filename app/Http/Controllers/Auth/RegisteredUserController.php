<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // ✅ Base validation
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:renter,owner'],
        ];

        // ✅ Extra rules for owner role
        if ($request->role === 'owner') {
            $rules['phone'] = ['required', 'string', 'max:15'];
            $rules['valid_id'] = ['required', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:2048'];
        }

        $validated = $request->validate($rules);

        // ✅ Handle ID upload for owner
        $validIdPath = null;
        $veriffSessionId = null;

        if ($request->role === 'owner' && $request->hasFile('valid_id')) {
            try {
                $validIdPath = $request->file('valid_id')->store('valid_ids', 'public');
            } catch (\Exception $e) {
                return back()->withErrors(['valid_id' => 'Failed to upload ID. Please try again.'])
                             ->withInput();
            }

            // 📌 Optional Veriff API verification
            try {
                $response = Http::withHeaders([
                    'X-AUTH-CLIENT' => config('services.veriff.api_key'),
                    'Content-Type' => 'application/json',
                ])->post(config('services.veriff.base_url') . '/sessions', [
                    'verification' => [
                        'type' => 'document',
                        'document' => ['type' => 'id_card'],
                    ],
                ]);

                $veriffData = $response->json();

                if (!$response->failed() && isset($veriffData['verification']['id'])) {
                    $veriffSessionId = $veriffData['verification']['id'];
                } else {
                    \Log::warning('Veriff session failed', ['response' => $veriffData]);
                }
            } catch (\Exception $e) {
                \Log::error('Veriff API error: ' . $e->getMessage());
            }
        }

        // ✅ Create user safely
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'phone' => $validated['role'] === 'owner' ? ($validated['phone'] ?? null) : null,
            'valid_id' => $validated['role'] === 'owner' ? $validIdPath : null,
            'veriff_session_id' => $veriffSessionId,
        ]);

        // ✅ Trigger registration + auto login
        event(new Registered($user));
        Auth::login($user);

        // ✅ Ensure user data is persisted
        $user->refresh();

        // ✅ Role-based redirect
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Welcome Admin! Registration successful.');

            case 'owner':
                return redirect()->route('owner.dashboard')
                    ->with('success', 'Welcome Owner! Registration successful. ID verification in process.');

            case 'renter':
            default:
                return redirect()->route('renter.dashboard')
                    ->with('success', 'Welcome Renter! Registration successful.');
        }
    }
}
