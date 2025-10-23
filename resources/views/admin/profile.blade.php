<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile - QuickStay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #cfd5f7 0%, #a7b3e9 40%, #8a9be0 100%);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            color: #1e293b;
            overflow-x: hidden;
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(15px);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 1.5rem;
            z-index: 50;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: -260px;
            width: 260px;
            height: 100%;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.3);
            transition: left 0.4s ease;
            padding-top: 80px;
            z-index: 40;
        }
        .sidebar.active { left: 0; }
        .sidebar ul { list-style: none; margin: 0; padding: 0; }
        .sidebar ul li { margin: 1rem 0; }
        .sidebar ul li a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            color: #1e293b;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .sidebar ul li a:hover, .sidebar ul li a.active {
            background: rgba(255,255,255,0.5);
            border-radius: 0.75rem;
            transform: translateX(5px);
        }
        .sidebar svg { width: 20px; height: 20px; stroke-width: 2; }
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0,0,0,0.2);
            backdrop-filter: blur(1px);
            z-index: 30;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .main-content {
            margin-top: 70px;
            transition: margin-left 0.4s ease;
            padding: 2rem;
        }
        .sidebar.active ~ .main-content {
            margin-left: 260px;
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <button id="sidebarToggle" aria-label="Toggle Sidebar" class="text-xl text-gray-800">☰</button>
    <h1 class="text-xl font-semibold text-gray-800">QuickStay Admin</h1>
    <div></div>
</nav>

{{-- Sidebar --}}
<div id="sidebar" class="sidebar"> 
    <ul>
        <li><a href="{{ route('admin.profile') }}" class="{{ request()->routeIs('admin.profile') ? 'active' : '' }}"> Profile</a></li>
        <li><a href="{{ route('admin.info') }}" class="{{ request()->routeIs('admin.info') ? 'active' : '' }}">ℹ Info</a></li>
        <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"> Dashboard</a></li>
        <li><a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}"> Users</a></li>
        <li><a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}"> Settings</a></li>
        <li><a href="{{ route('admin.feedbacks') }}" class="{{ request()->routeIs('admin.feedbacks') ? 'active' : '' }}"> Feedbacks</a></li>
        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"> Logout </a> 
        <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </li>
    </ul>
</div>

{{-- Sidebar Overlay --}}
<div id="sidebarOverlay" class="sidebar-overlay"></div>

{{-- Main Content --}}
<div class="main-content">
    <div class="max-w-3xl mx-auto bg-white bg-opacity-70 p-8 rounded-2xl shadow-xl backdrop-blur-md">
        <h2 class="text-3xl font-semibold text-gray-800 mb-6">👤 Profile Information</h2>

        <div class="grid gap-6">
            <div>
                <label class="text-gray-600 font-medium">Name</label>
                <p class="text-xl text-gray-900">{{ $user->name }}</p>
            </div>
            <div>
                <label class="text-gray-600 font-medium">Email</label>
                <p class="text-xl text-gray-900">{{ $user->email }}</p>
            </div>
            <div>
                <label class="text-gray-600 font-medium">Role</label>
                <p class="text-xl text-gray-900 capitalize">{{ $user->role ?? 'N/A' }}</p>
            </div>
        </div>

        {{-- Optionally add edit button --}}
        <div class="mt-8">
            <a href="#" class="inline-block px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
                ✏ Edit Profile
            </a>
        </div>
    </div>
</div>

{{-- Sidebar Toggle Script --}}
<script>
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const sidebarToggle = document.getElementById('sidebarToggle');

    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        sidebarOverlay.classList.toggle('active');
    });

    sidebarOverlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        sidebarOverlay.classList.remove('active');
    });
</script>

</body>
</html>
