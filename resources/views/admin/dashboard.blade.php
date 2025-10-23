<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QuickStay Admin Dashboard</title>

{{-- Tailwind CSS --}}
<script src="https://cdn.tailwindcss.com"></script>
{{-- Feather Icons --}}
<script src="https://unpkg.com/feather-icons"></script>

<style>
/* === 🌲 Dark Forest Gradient Dashboard (Deep Green Edition) === */
body {
    background: linear-gradient(135deg, #EAEF9D 0%, #C1D95C 40%, #80B155 100%);
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
    color: #E6EED8;
    overflow-x: hidden;
}

/* === Navbar & Sidebar === */
.navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 60px;
    background: rgba(14, 33, 14, 0.6);
    backdrop-filter: blur(12px);
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.25);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 1.5rem;
    z-index: 50;
    border-bottom: 1px solid rgba(166, 198, 78, 0.2);
}
.navbar h1 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #D8EFC1;
    text-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
}
.navbar button {
    background: none;
    border: none;
    cursor: pointer;
    color: #A6C64E;
    font-size: 1.5rem;
    transition: transform 0.2s ease;
}
.navbar button:hover { transform: scale(1.1); }

/* === Sidebar === */
.sidebar {
    position: fixed;
    top: 0;
    left: -260px;
    width: 260px;
    height: 100%;
    background: rgba(14, 33, 14, 0.95);
    backdrop-filter: blur(16px);
    border-right: 1px solid rgba(166, 198, 78, 0.15);
    box-shadow: 6px 0 20px rgba(0, 0, 0, 0.3);
    transition: left 0.4s ease;
    padding-top: 80px;
    z-index: 40;
}
.sidebar.active { left: 0; }
.sidebar ul { list-style: none; padding: 0; margin: 0; }
.sidebar ul li { margin: 1rem 0; }
.sidebar ul li a {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.5rem;
    color: #D8EFC1;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    border-radius: 0.75rem;
}
.sidebar ul li a:hover,
.sidebar ul li a.active {
    background: linear-gradient(to right, #49842B, #80B155);
    color: #fff;
    transform: translateX(6px);
    box-shadow: 0 0 16px rgba(166, 198, 78, 0.3);
}
.sidebar ul li a svg { width: 20px; height: 20px; }

/* === Overlay for mobile === */
.sidebar-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(10,20,10,0.6);
    backdrop-filter: blur(2px);
    opacity: 0; visibility: hidden;
    transition: opacity 0.4s ease;
    z-index: 30;
}
.sidebar-overlay.active { opacity: 1; visibility: visible; }

/* === Main Content === */
.main-content {
    margin-top: 70px;
    transition: margin-left 0.4s ease;
}
.sidebar.active ~ .main-content { margin-left: 260px; }

/* === Frosted Container === */
.max-w-7xl {
    backdrop-filter: blur(20px);
    background: rgba(20, 40, 20, 0.6);
    border: 1px solid rgba(166,198,78,0.2);
    border-radius: 1.5rem;
    padding: 2rem;
    box-shadow: 0 12px 40px rgba(0,0,0,0.25);
}

/* === Headings === */
h1,h2,h3 { letter-spacing:-0.5px; color:#E6EED8; }
h1 { text-shadow:0 3px 6px rgba(0,0,0,0.4); }
p.text-gray-500 { color:#BFD9A5 !important; }

/* === Summary Cards === */
.dashboard-card {
    background: rgba(255,255,255,0.08);
    border:1px solid rgba(166,198,78,0.2);
    border-radius:1rem;
    box-shadow:0 8px 20px rgba(0,0,0,0.25);
    transition:all 0.4s ease;
    color:#E6EED8;
    backdrop-filter: blur(10px);
}
.dashboard-card:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 16px 40px rgba(166,198,78,0.2);
}
.border-blue-500 { border-top:4px solid #A6C64E; }
.border-yellow-400 { border-top:4px solid #DDE56B; }
.border-green-500 { border-top:4px solid #91C56E; }
.border-purple-500 { border-top:4px solid #8BB86C; }
.dashboard-card h2 { color:#D8EFC1; font-weight:600; }
.dashboard-card p { color:#A6C64E; }

/* === Table === */
table { border-collapse: separate; border-spacing:0; width:100%; }
thead th { background: rgba(255,255,255,0.1); color:#CFECC4; text-transform:uppercase; font-weight:600; letter-spacing:0.05em; border-bottom:1px solid rgba(166,198,78,0.2);}
tbody tr { transition: background 0.3s ease, transform 0.3s ease;}
tbody tr:hover { background: rgba(255,255,255,0.05)!important; transform: scale(1.01);}
td { color:#E6EED8; }

/* === Buttons === */
a.bg-red-600, button.bg-green-600 {
    border-radius:0.75rem; font-weight:500; box-shadow:0 3px 10px rgba(0,0,0,0.25); transition:all 0.3s ease;
}
button.bg-green-600 {
    background:linear-gradient(to right,#80B155,#49842B); color:#fff;
}
button.bg-green-600:hover {
    transform:translateY(-2px);
    background:linear-gradient(to right,#91C56E,#49842B);
}

/* === Footer === */
footer { margin-top:3rem; color:#BFD9A5; font-size:0.9rem; animation:fadeIn 1.2s ease; }
@keyframes fadeIn { from {opacity:0; transform:translateY(12px);} to {opacity:1; transform:translateY(0);} }

/* === Scrollbar === */
::-webkit-scrollbar { width:8px; }
::-webkit-scrollbar-thumb { background:rgba(166,198,78,0.3); border-radius:10px; }
::-webkit-scrollbar-thumb:hover { background:rgba(166,198,78,0.5); }

/* === Responsive === */
@media (max-width:768px) { .max-w-7xl{padding:1.5rem;} .dashboard-card{padding:1.2rem;} }
</style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <button id="sidebarToggle" aria-label="Toggle Sidebar"><i data-feather="menu"></i></button>
    <h1>QuickStay Admin</h1>
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
<div id="sidebarOverlay" class="sidebar-overlay"></div>

{{-- Main Content --}}
<div class="main-content">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold">Admin Dashboard</h1>
                <p class="text-gray-500">Welcome back, {{ auth()->user()->name }} 👋</p>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="dashboard-card rounded-lg p-5 text-center border-t-4 border-green-500">
                <h2>Verified Properties</h2>
                <p class="text-4xl font-bold">{{ $verified ?? 0 }}</p>
            </div>
            <div class="dashboard-card rounded-lg p-5 text-center border-t-4 border-yellow-400">
                <h2>Pending Properties</h2>
                <p class="text-4xl font-bold">{{ $pending ?? 0 }}</p>
            </div>
            <div class="dashboard-card rounded-lg p-5 text-center border-t-4 border-green-500">
                <h2>Registered Owners</h2>
                <p class="text-4xl font-bold">{{ $owners ?? 0 }}</p>
            </div>
            <div class="dashboard-card rounded-lg p-5 text-center border-t-4 border-purple-500">
                <h2>Registered Renters</h2>
                <p class="text-4xl font-bold">{{ $renters ?? 0 }}</p>
            </div>
        </div>

        {{-- Property Management --}}
        <div class="dashboard-card shadow rounded-lg overflow-hidden">
            <div class="flex justify-between items-center p-5 border-b border-green-900/40">
                <h2 class="text-2xl font-semibold">All Properties</h2>
                <span class="text-sm text-green-200">Total: {{ $properties->count() ?? 0 }}</span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-green-800 text-sm">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left">Title</th>
                            <th class="px-6 py-3 text-left">Owner</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Verification</th>
                            <th class="px-6 py-3 text-left">Price</th>
                            <th class="px-6 py-3 text-left">Rating</th>
                            <th class="px-6 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-green-800/40">
                        @forelse ($properties as $property)
                            @php
                                $feedbacks = $property->feedbacks ?? collect();
                                $avgRating = round($feedbacks->avg('rating') ?? 0, 1);
                                $totalFeedback = $feedbacks->count();
                            @endphp
                            <tr>
                                <td class="px-6 py-4 font-medium">{{ $property->title }}</td>
                                <td class="px-6 py-4">{{ $property->owner->name ?? 'Unknown' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $property->status === 'available' ? 'bg-green-800 text-green-200' : ($property->status === 'partial' ? 'bg-yellow-800 text-yellow-200' : 'bg-red-800 text-red-200') }}">
                                        {{ ucfirst($property->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($property->is_verified)
                                        <span class="text-green-300 font-semibold">Verified</span>
                                    @else
                                        <span class="text-yellow-300 font-semibold">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">₱{{ number_format($property->price, 2) }}</td>
                                <td class="px-6 py-4">
                                    @if($totalFeedback > 0)
                                        <span class="text-yellow-400">{{ $avgRating }}/5 ({{ $totalFeedback }})</span>
                                    @else
                                        <span class="text-gray-400 italic">No ratings</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if(!$property->is_verified)
                                        <form action="{{ route('admin.properties.approve', $property->id) }}" method="POST" onsubmit="return confirm('Approve this property?');">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded">Approve</button>
                                        </form>
                                    @else
                                        <span class="text-green-300">✔</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-6 text-gray-400">No properties found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Footer --}}
        <footer class="mt-10 text-center text-sm">
            <p>© {{ date('Y') }} QuickStay Admin Dashboard. All rights reserved.</p>
        </footer>
    </div>
</div>

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

// Feather icons initialization
feather.replace();
</script>
</body>
</html>
