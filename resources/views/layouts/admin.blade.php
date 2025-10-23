<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickStay Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <button id="sidebarToggle" aria-label="Toggle Sidebar">☰</button>
    <h1>QuickStay Admin</h1>
    <div></div>
</nav>

{{-- Sidebar --}}
<div id="sidebar" class="sidebar">
    <ul>
        <li>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M3 12l9-9 9 9v9a1 1 0 01-1 1h-5a1 1 0 01-1-1v-5H9v5a1 1 0 01-1 1H3v-9z"/>
                </svg> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.profile') }}" class="{{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M5.121 17.804A11.963 11.963 0 0112 15c2.21 0 4.27.597 6.121 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg> Profile
            </a>
        </li>
        <li>
            <a href="{{ route('admin.info') }}" class="{{ request()->routeIs('admin.info') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M13 16h-1v-4h-1m2-4h.01M21 12A9 9 0 113 12a9 9 0 0118 0z"/>
                </svg> Info
            </a>
        </li>
        <li>
            <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 14a4 4 0 100-8 4 4 0 000 8z"/>
                </svg> Users
            </a>
        </li>
        <li>
            <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M10.325 4.317a1 1 0 011.35-.936l.094.032a1 1 0 01.63.773l.012.09.001.01.003.017a1 1 0 01-.879 1.096 4.992 4.992 0 00-4.266 4.894 5.002 5.002 0 004.85 4.998 1 1 0 01.987.888l.007.1-.001.04a1 1 0 01-.756.964l-.098.021-.094.012a1 1 0 01-.998-.779A7 7 0 1110.325 4.317z"/>
                </svg> Settings
            </a>
        </li>
        <li>
            <a href="{{ route('admin.feedbacks') }}" class="{{ request()->routeIs('admin.feedbacks') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M7 8h10M7 12h6m-6 4h8m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4z"/>
                </svg> Feedbacks
            </a>
        </li>
        <li>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1"/>
                </svg> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </li>
    </ul>
</div>



<script>
const sidebar = document.getElementById('sidebar');
const sidebarToggle = document.getElementById('sidebarToggle');
sidebarToggle.addEventListener('click', () => sidebar.classList.toggle('active'));
</script>
</body>
</html>
