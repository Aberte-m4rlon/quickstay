@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Add New Property</h1>

    {{-- Success or Error Message --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg shadow">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Create Property Form --}}
    <form action="{{ route('owner.properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-8 rounded-lg shadow">
        @csrf

        {{-- Title --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">Property Title</label>
            <input type="text" name="title" value="{{ old('title') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500">
        </div>

        {{-- Address --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">Address</label>
            <input type="text" name="address" value="{{ old('address') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500">
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">Description</label>
            <textarea name="description" rows="4"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500">{{ old('description') }}</textarea>
        </div>

        {{-- Price --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">Monthly Price (₱)</label>
            <input type="number" name="price" step="0.01" value="{{ old('price') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500">
        </div>

        {{-- Status --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">Availability Status</label>
            <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500">
                <option value="available">Available</option>
                <option value="partial">Partial</option>
                <option value="full">Full</option>
            </select>
        </div>

        {{-- Image Upload --}}
        <div>
            <label class="block text-gray-700 font-medium mb-1">Upload Image</label>
            <input type="file" name="image"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring focus:ring-blue-200 focus:border-blue-500">
        </div>

        {{-- Submit --}}
        <div class="flex justify-end">
            <a href="{{ route('owner.dashboard') }}"
               class="mr-3 px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Cancel</a>
            <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow">
                Save Property
            </button>
        </div>
    </form>
</div>
@endsection
