@extends('layouts.admin')

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #cfd5f7 0%, #a7b3e9 40%, #8a9be0 100%);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            color: #1e293b;
            overflow-x: hidden;
        }
        .navbar {
            position: fixed; top: 0; left: 0; width: 100%; height: 60px;
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(15px);
            display: flex; justify-content: space-between; align-items: center;
            padding: 0 1.5rem; z-index: 50; box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .sidebar {
            position: fixed; top: 0; left: -260px; width: 260px; height: 100%;
            background: rgba(255, 255, 255, 0.25); backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.3);
            transition: left 0.4s ease; padding-top: 80px; z-index: 40;
        }
        .sidebar.active { left: 0; }
        .sidebar ul { list-style: none; margin: 0; padding: 0; }
        .sidebar ul li { margin: 1rem 0; }
        .sidebar ul li a {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.75rem 1.5rem; text-decoration: none;
            color: #1e293b; font-weight: 500; transition: all 0.3s ease;
        }
        .sidebar ul li a:hover, .sidebar ul li a.active {
            background: rgba(255,255,255,0.5);
            border-radius: 0.75rem; transform: translateX(5px);
        }
        .sidebar svg { width: 20px; height: 20px; stroke-width: 2; }
        .main-content { margin-top: 70px; transition: margin-left 0.4s ease; }
        .sidebar.active ~ .main-content { margin-left: 260px; }
        .max-w-7xl {
            backdrop-filter: blur(20px); background: rgba(255,255,255,0.15);
            border-radius: 1.5rem; padding: 2rem;
            box-shadow: 0 12px 40px rgba(0,0,0,0.08);
        }
    </style>
{{-- === Navbar === --}}
<nav class="navbar">
    <button id="sidebarToggle" aria-label="Toggle Sidebar">
        ☰
    </button>
    <h1>QuickStay Admin</h1>
    <div></div>
</nav>

{{-- === Sidebar === --}}
<div id="sidebar" class="sidebar">
    <ul>
        <li>
            <a href="{{ route('admin.profile') }}" class="{{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M5.121 17.804A11.963 11.963 0 0112 15c2.21 0 4.27.597 6.121 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg> Profile
            </a>
        </li>
        <li>
            <a href="{{ route('admin.info') }}" class="{{ request()->routeIs('admin.info') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M13 16h-1v-4h-1m2 0V9m0 0H8m4 0h4m1 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg> Info
            </a>
        </li>
        <li>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m-4 0h8" />
                </svg> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 14a4 4 0 100-8 4 4 0 000 8z" />
                </svg> Users
            </a>
        </li>
        <li>
            <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M11 17a4 4 0 01-8 0v-7a4 4 0 018 0v7zm10-7a4 4 0 01-8 0v7a4 4 0 008 0v-7z" />
                </svg> Settings
            </a>
        </li>
        <li>
            <a href="{{ route('admin.feedbacks') }}" class="{{ request()->routeIs('admin.feedbacks') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 16H3m18-8H3m18 8a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg> Feedbacks
            </a>
        </li>
        <li>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                   <path stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1" />
               </svg> Logout
            </a>
            <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </li>
    </ul>
</div>


{{-- Overlay --}}
<div id="sidebarOverlay" class="sidebar-overlay"></div>
<div class="dashboard-card shadow p-6 rounded-xl">
    <h2 class="text-2xl font-semibold mb-6 text-gray-700">User Feedbacks</h2>

    <table class="min-w-full text-left">
        <thead>
            <tr>
                <th class="px-4 py-2 text-gray-700 font-semibold">User</th>
                <th class="px-4 py-2 text-gray-700 font-semibold">Property</th>
                <th class="px-4 py-2 text-gray-700 font-semibold">Rating</th>
                <th class="px-4 py-2 text-gray-700 font-semibold">Comment</th>
            </tr>
        </thead>
        <tbody>
            @foreach($feedbacks as $feedback)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-2">{{ $feedback->user->name ?? 'N/A' }}</td>
                <td class="px-4 py-2">{{ $feedback->property->title ?? 'N/A' }}</td>
                <td class="px-4 py-2 text-yellow-500 font-semibold">{{ $feedback->rating }}/5</td>
                <td class="px-4 py-2">{{ $feedback->comment }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $feedbacks->links() }}
    </div>
</div>
@endsection
