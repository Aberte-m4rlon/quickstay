@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Property</h1>

    {{-- Back link --}}
    <a href="{{ route('owner.dashboard') }}" 
       class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
       ← Back to Dashboard
    </a>

    {{-- Success message --}}
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- Edit Form --}}
    <form method="POST" action="{{ route('owner.properties.update', $property->id) }}" 
          class="bg-white shadow rounded-lg p-6 space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700">Property Title</label>
            <input type="text" name="title" value="{{ old('title', $property->title) }}" 
                   required class="mt-1 w-full border-gray-300 rounded-lg p-2 shadow-sm focus:ring focus:ring-blue-300">
            @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Address</label>
            <input type="text" name="address" value="{{ old('address', $property->address) }}" 
                   required class="mt-1 w-full border-gray-300 rounded-lg p-2 shadow-sm focus:ring focus:ring-blue-300">
            @error('address') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Price (₱)</label>
            <input type="number" name="price" step="0.01" value="{{ old('price', $property->price) }}" 
                   required class="mt-1 w-full border-gray-300 rounded-lg p-2 shadow-sm focus:ring focus:ring-blue-300">
            @error('price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" required class="mt-1 w-full border-gray-300 rounded-lg p-2 shadow-sm focus:ring focus:ring-blue-300">
                <option value="available" {{ $property->status === 'available' ? 'selected' : '' }}>Available</option>
                <option value="partial" {{ $property->status === 'partial' ? 'selected' : '' }}>Partial</option>
                <option value="full" {{ $property->status === 'full' ? 'selected' : '' }}>Full</option>
            </select>
            @error('status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Optional: Verification info --}}
        <div class="bg-gray-50 border-l-4 border-yellow-400 p-3 rounded">
            <p class="text-gray-600 text-sm">
                <strong>Note:</strong> Once you edit, the property may require admin re-verification.
            </p>
        </div>

        <div class="flex justify-end">
            <button type="submit" 
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 shadow">
                Update Property
            </button>
        </div>
    </form>
</div>
@endsection
