<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>QuickStay</title>

  {{-- Tailwind --}}
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

  <style>
    :root {
      --forest-dark: #0F1E0F;
      --forest-mid: #1E441E;
      --forest-light: #3E702B;
      --lime: #A6C64E;
      --leaf: #608F3D;
      --text-light: #E6EED8;
      --text-muted: #BFD6B2;
    }

    body {
      font-family: 'Poppins', system-ui, sans-serif;
      background: radial-gradient(circle at 20% 20%, var(--forest-mid), var(--forest-dark));
      color: var(--text-light);
      min-height: 100vh;
    }

    nav {
      backdrop-filter: blur(20px);
      background: linear-gradient(to right, rgba(15,30,15,0.85), rgba(30,68,30,0.85));
      border-bottom: 1px solid rgba(166,198,78,0.2);
    }

    .nav-link {
      color: var(--text-light);
      transition: 0.2s ease;
    }

    .nav-link:hover {
      color: var(--lime);
    }

    .btn-outline {
      border: 1px solid var(--lime);
      color: var(--lime);
      padding: 0.3rem 0.8rem;
      border-radius: 0.375rem;
      transition: 0.2s;
    }

    .btn-outline:hover {
      background-color: var(--lime);
      color: var(--forest-dark);
    }

    .alert-success {
      background: rgba(166,198,78,0.15);
      color: var(--lime);
      border-left: 4px solid var(--lime);
    }

    main {
      backdrop-filter: blur(10px);
      background: rgba(15,30,15,0.35);
      border-radius: 1rem;
      padding: 2rem;
      box-shadow: 0 4px 24px rgba(0,0,0,0.4);
      margin-bottom: 3rem;
    }

    @media (max-width: 640px) {
      main {
        padding: 1rem;
      }
    }
  </style>
</head>

<body class="overflow-x-hidden">

  {{-- Responsive Navbar --}}
  <nav class="shadow-sm p-4 sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center px-4 md:px-0">
      {{-- Hamburger Button (mobile) --}}
      <button id="menu-toggle" class="text-lime-300 focus:outline-none md:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
          viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
      </button>

      {{-- Desktop Links --}}
      <div class="hidden md:flex space-x-6 items-center">
        @auth
          @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="nav-link text-sm">Admin</a>
          @endif
          @if(auth()->user()->role === 'owner')
            <a href="{{ route('owner.dashboard') }}" class="nav-link text-sm">Owner</a>
          @endif
        @else
          <a href="{{ route('login') }}" class="nav-link text-sm">Login</a>
          <a href="{{ route('register') }}" class="nav-link text-sm">Register</a>
        @endauth
      </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="hidden md:hidden flex flex-col mt-3 space-y-3 px-6 bg-opacity-80 pb-4">
      @auth
        @if(auth()->user()->role === 'admin')
          <a href="{{ route('admin.dashboard') }}" class="nav-link text-sm block">Admin</a>
        @endif
        @if(auth()->user()->role === 'owner')
          <a href="{{ route('owner.dashboard') }}" class="nav-link text-sm block">Owner</a>
        @endif
      @else
        <a href="{{ route('login') }}" class="nav-link text-sm block">Login</a>
        <a href="{{ route('register') }}" class="nav-link text-sm block">Register</a>
      @endauth
    </div>
  </nav>

  {{-- Main content --}}
  <main class="container mx-auto mt-10 px-4 md:px-0">
    @if(session('success'))
      <div class="alert-success p-3 rounded mb-6">
        {{ session('success') }}
      </div>
    @endif

    @yield('content')
  </main>

  {{-- Simple JS for toggle --}}
  <script>
    document.getElementById('menu-toggle').addEventListener('click', () => {
      document.getElementById('mobile-menu').classList.toggle('hidden');
    });
  </script>
</body>
</html>
