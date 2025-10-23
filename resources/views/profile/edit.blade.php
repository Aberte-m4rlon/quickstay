@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">My Profile</h1>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- Profile Card --}}
    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Profile Picture --}}
                <div class="sm:col-span-2 text-center">
                    @if ($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" class="w-32 h-32 rounded-full mx-auto mb-3 object-cover">
                    @else
                        <img src="https://via.placeholder.com/150x150?text=Profile" class="w-32 h-32 rounded-full mx-auto mb-3 object-cover">
                    @endif

                    <label class="block">
                        <span class="text-gray-700 font-medium">Profile Photo</span>
                        <input type="file" name="profile_photo" class="mt-2 block w-full text-sm text-gray-600 border border-gray-300 rounded-lg p-2">
                        @error('profile_photo')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </label>
                </div>

                {{-- Name --}}
                <div>
                    <label class="block text-gray-700 font-medium">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border-gray-300 rounded-lg p-2 mt-1">
                    @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-gray-700 font-medium">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border-gray-300 rounded-lg p-2 mt-1">
                    @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Contact Number --}}
                <div class="sm:col-span-2">
                    <label class="block text-gray-700 font-medium">Contact Number</label>
                    <input type="text" name="contact_number" value="{{ old('contact_number', $user->contact_number) }}" class="w-full border-gray-300 rounded-lg p-2 mt-1">
                    @error('contact_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-gray-700 font-medium">New Password</label>
                    <input type="password" name="password" class="w-full border-gray-300 rounded-lg p-2 mt-1">
                    @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="block text-gray-700 font-medium">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-lg p-2 mt-1">
                </div>
            </div>

            <div class="mt-6 text-right">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 shadow">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
