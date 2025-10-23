@extends('layouts.app')

@section('content')
<div class="text-center py-16">
    <h1 class="text-6xl font-bold text-red-600">404</h1>
    <p class="text-xl mt-4">Page not found.</p>
    <a href="{{ url('/') }}" class="mt-6 inline-block px-4 py-2 bg-blue-600 text-white rounded">Back to home</a>
</div>
@endsection
