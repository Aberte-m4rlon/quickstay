<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Browse Properties — Green Glass UI</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { poppins: ['Poppins', 'system-ui', 'sans-serif'] },
          colors: {
            pale: '#EAEF9D',
            glow: '#C1D95C',
            primary: '#80B155',
            midforest: '#49842B',
            deepforest: '#336A29',
            textdark: '#1F2A1C'
          },
          boxShadow: {
            'glass-md': '0 12px 40px rgba(31,42,28,0.15)',
            'glass-lg': '0 20px 60px rgba(31,42,28,0.2)',
            'inner-glow': 'inset 0 0 15px rgba(255,255,255,0.1)'
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    /* Deep glass panels */
    .glass {
      background: rgba(255,255,255,0.22);
      backdrop-filter: blur(16px) saturate(150%);
      -webkit-backdrop-filter: blur(16px) saturate(150%);
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 16px;
      box-shadow: 0 12px 40px rgba(31,42,28,0.12), inset 0 0 15px rgba(255,255,255,0.08);
      transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
    }
    .glass:hover {
      background: rgba(255,255,255,0.28);
      transform: translateY(-4px) scale(1.02);
      box-shadow: 0 20px 60px rgba(31,42,28,0.18), inset 0 0 20px rgba(255,255,255,0.1);
    }

    .glass-forest {
      background: rgba(128,177,85,0.08);
      backdrop-filter: blur(18px) saturate(160%);
      -webkit-backdrop-filter: blur(18px) saturate(160%);
      border: 1px solid rgba(128,177,85,0.12);
      border-radius: 16px;
      box-shadow: 0 12px 40px rgba(128,177,85,0.06), inset 0 0 15px rgba(193,217,92,0.08);
      transition: all 0.3s ease;
    }
    .glass-forest:hover {
      background: rgba(128,177,85,0.12);
      transform: translateY(-4px) scale(1.02);
      box-shadow: 0 20px 60px rgba(128,177,85,0.1), inset 0 0 20px rgba(193,217,92,0.1);
    }

    /* Buttons & chevrons glow */
    .chev-btn {
      background: rgba(255,255,255,0.15);
      backdrop-filter: blur(10px);
      border-radius: 9999px;
      width: 44px;
      height: 44px;
      display:flex;
      align-items:center;
      justify-content:center;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
      transition: all 0.2s ease;
    }
    .chev-btn:hover {
      transform: translateY(-2px);
      background: rgba(255,255,255,0.25);
      box-shadow: 0 8px 25px rgba(0,0,0,0.12), 0 0 12px rgba(193,217,92,0.25);
    }

    /* Scrollbars */
    .no-scrollbar::-webkit-scrollbar { height: 8px; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: thin; }
    .no-scrollbar::-webkit-scrollbar-thumb {
      background: rgba(255,255,255,0.25);
      border-radius: 8px;
    }

    /* Muted text for glass */
    .muted-forest { color: rgba(31,42,28,0.7); }

    html, body { height: 100%; }

    /* Ambient gradient glows behind content */
    .ambient-glow {
      position: fixed;
      inset:0;
      pointer-events:none;
      z-index:-10;
    }
    .ambient-glow::before, .ambient-glow::after {
      content:'';
      position:absolute;
      border-radius:50%;
      filter:blur(150px);
      opacity:0.5;
    }
    .ambient-glow::before {
      width: 600px; height: 600px; top:-150px; left:-100px;
      background: radial-gradient(circle, rgba(128,177,85,0.25), transparent 60%);
    }
    .ambient-glow::after {
      width: 500px; height: 500px; bottom:-100px; right:-50px;
      background: radial-gradient(circle, rgba(193,217,92,0.25), transparent 60%);
    }

    /* Card hover glow for featured items */
    .featured-card:hover {
      box-shadow: 0 25px 60px rgba(128,177,85,0.15), inset 0 0 20px rgba(193,217,92,0.12);
      transform: translateY(-6px) scale(1.03);
    }
  </style>
</head>
<body class="min-h-screen antialiased font-poppins text-textdark bg-white">
    <!-- Ambient blurred glow -->
       <div class="ambient-glow"></div>
  <div class="fixed inset-0 pointer-events-none -z-10">
    <div class="absolute inset-0 bg-gradient-to-br from-white via-[rgba(193,217,92,0.08)] to-white opacity-75"></div>
    <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-gradient-to-tr from-[rgba(128,177,85,0.12)] to-transparent filter blur-3xl opacity-60"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full bg-gradient-to-bl from-[rgba(128,177,85,0.10)] to-transparent filter blur-3xl opacity-50"></div>
  </div>

 <div class="min-h-screen flex flex-col lg:flex-row gap-6 p-4 md:p-6 lg:p-8">
<!-- SIDEBAR (glassy & readable) -->
<aside id="sidebar" class="w-72 lg:w-80 xl:w-96 bg-[rgba(255,255,255,0.15)] backdrop-blur-2xl border-r border-[rgba(31,42,28,0.15)] shadow-glass-md min-h-screen flex flex-col justify-between transition-transform duration-300 transform lg:translate-x-0 fixed lg:static z-50">

  <!-- Top Section -->
  <div class="p-6 overflow-y-auto flex-1">

    <!-- Logo / Header -->
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-xl font-bold text-textdark">Renter Dashboard</h2>
      <button id="sidebarCloseBtn" class="lg:hidden p-2 rounded-md hover:bg-white/20">
        <svg class="w-5 h-5 text-textdark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <!-- User Profile -->
    <div class="flex items-center gap-4 p-4 rounded-xl glass border border-[rgba(31,42,28,0.08)] mb-6">
      <img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : 'https://via.placeholder.com/80?text=Profile' }}" 
           alt="Profile Photo"
           class="w-16 h-16 rounded-full object-cover border border-[rgba(255,255,255,0.4)] shadow">
      <div>
        <div class="font-semibold text-textdark text-base">{{ auth()->user()->name }}</div>
        <div class="text-sm text-textdark/70">{{ auth()->user()->email }}</div>
        <a href="{{ route('renter.profile.edit') }}" 
           class="inline-block mt-2 px-3 py-1 text-xs bg-primary text-white rounded-md hover:bg-glow transition">
          Edit Profile
        </a>
      </div>
    </div>

    <!-- Divider -->
    <hr class="border-[rgba(31,42,28,0.15)] mb-4">

    <!-- Navigation Links -->
    <nav class="flex flex-col gap-2 mb-8">
      <a href="{{ route('renter.dashboard') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-white/20 transition text-textdark font-medium">
        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m4-8v8m5 0h-3m-6 0H4"/>
        </svg>
        <span>Dashboard</span>
      </a>

      <a href="{{ route('renter.messages.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-white/20 transition text-textdark font-medium">
        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
        </svg>
        <span>Messages</span>
      </a>
    </nav>

    <!-- Friends Section -->
    <div>
      <h3 class="text-lg font-semibold text-textdark flex items-center gap-2 mb-3">
        <svg class="w-5 h-5 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 7a4 4 0 110-8 4 4 0 010 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
        </svg>
        Friends
      </h3>

      <ul class="flex flex-col gap-3 max-h-52 overflow-y-auto pr-2">
        @forelse($users as $user)
          <li class="flex items-center justify-between p-3 rounded-xl glass border border-[rgba(31,42,28,0.08)] hover:bg-white/20 transition">
            <div class="flex items-center gap-3">
              <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://via.placeholder.com/40' }}" 
                   alt="{{ $user->name }}" 
                   class="w-10 h-10 rounded-full object-cover border border-[rgba(31,42,28,0.08)]" />
              <div>
                <div class="text-sm font-medium text-textdark">{{ $user->name }}</div>
                <div class="text-xs text-textdark/70">{{ $user->email }}</div>
              </div>
            </div>
            <span class="w-3 h-3 rounded-full {{ $user->is_online ? 'bg-green-500' : 'bg-gray-300' }}"></span>
          </li>
        @empty
          <p class="text-sm text-textdark/70">No users found.</p>
        @endforelse
      </ul>
    </div>

  </div>

  <!-- Bottom Logout -->
  <div class="p-4 border-t border-[rgba(31,42,28,0.15)]">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="w-full flex items-center justify-center gap-2 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H5a3 3 0 01-3-3v-1"/>
        </svg>
        Logout
      </button>
    </form>
  </div>
</aside>



    <!-- Sidebar Overlay (mobile) -->
 <div id="sidebarOverlay" class="fixed inset-0 bg-[rgba(31,42,28,0.12)] hidden z-30 backdrop-blur-sm"></div>

    <!-- MAIN + RIGHT PANEL WRAPPER -->
   <div class="flex-1 flex flex-col lg:flex-row gap-6 w-full">
      <!-- MAIN CONTENT -->
      <main class="flex-1 p-0 lg:p-0">
        <!-- Topbar -->
 <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4 glass p-4 rounded-2xl shadow-glass-md">          <div class="flex items-center gap-4">
            <button id="sidebarToggleBtn" class="lg:hidden w-12 h-12 rounded-xl flex items-center justify-center glass border border-[rgba(128,177,85,0.08)]">
              <svg class="w-5 h-5 text-textdark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <div>
              <h1 class="text-lg font-semibold text-textdark">Browse Properties</h1>
              <p class="text-xs muted-forest">Find your next stay — modern, warm, and secure.</p>
            </div>
          </div>

          <div class="flex items-stretch sm:items-center gap-3 w-full sm:w-auto">
            <form method="GET" action="{{ route('renter.dashboard') }}" class="flex w-full sm:w-auto gap-2 items-center">
              <input id="search" name="search" value="{{ request('search') }}" placeholder="Search by title or location..." class="flex-1 sm:w-64 px-3 py-2 rounded-lg border border-[rgba(31,42,28,0.06)] glass text-textdark focus:ring-1 focus:ring-primary focus:outline-none" />
              <button type="submit" class="px-3 py-2 rounded-lg bg-gradient-to-r from-primary to-glow text-white font-semibold shadow">Search</button>
            </form>
          </div>
        </div>

        <!-- HERO / FEATURED SCROLLER -->
        @if($properties->isNotEmpty())
          @php
            $topFeatured = $properties->sortByDesc(fn($p) => $p->feedbacks->avg('rating'))->take(5);
          @endphp
        <div class="mb-6 relative">
          <div class="relative">
              <!-- Left/Right chevrons -->
              <button id="heroPrev" class="chev-btn absolute left-2 top-1/2 -translate-y-1/2 z-20 lg:block hidden" aria-label="Prev featured">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/></svg>
              </button>
              <button id="heroNext" class="chev-btn absolute right-2 top-1/2 -translate-y-1/2 z-20 lg:block hidden" aria-label="Next featured">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6"/></svg>
              </button>

              <div id="heroScroll" class="flex gap-4 overflow-x-auto no-scrollbar py-2">
                  @foreach($topFeatured as $featured)
                <a href="{{ route('renter.properties.show', $featured->id) }}" class="flex-shrink-0 w-72 sm:w-80 lg:w-96 rounded-2xl overflow-hidden glass-forest border border-[rgba(128,177,85,0.08)] shadow-glass-md hover:scale-[1.02] transition-transform">
                  <div class="w-full h-44 overflow-hidden">
                    <img src="{{ $featured->image_url ?? 'https://via.placeholder.com/1200x500?text=Featured+Property' }}" alt="Featured" class="object-cover w-full h-full" />
                  </div>
                  <div class="p-4">
                    <p class="text-xs text-primary font-semibold">Featured</p>
                    <h3 class="text-base font-semibold text-textdark mt-1">{{ $featured->title }}</h3>
                    <p class="text-sm muted-forest mt-1">{{ Str::limit($featured->description ?? $featured->address, 100) }}</p>
                  </div>
                  </a>
                @endforeach
              </div>
            </div>
          </div>
        @endif

        <!-- GRID -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($properties as $p)
            @php $avgRating = round($p->feedbacks->avg('rating') ?? 0, 1); @endphp
            <article class="rounded-2xl overflow-hidden glass border border-[rgba(31,42,28,0.05)] shadow-glass-md">
              <a href="{{ route('renter.properties.show', $p->id) }}" class="block">
                <div class="w-full h-44 overflow-hidden">
                  <img src="{{ $p->image_url ?? 'https://via.placeholder.com/600x400?text=QuickStay' }}" alt="{{ $p->title }}" class="object-cover w-full h-full" />
                </div>
                <div class="p-4">
                  <div class="flex justify-between items-start gap-3">
                    <div>
                      <h4 class="text-sm font-semibold text-textdark truncate">{{ $p->title }}</h4>
                      <p class="text-xs muted-forest truncate">{{ $p->address }}</p>
                    </div>
                    <div class="text-right">
                      <div class="text-sm font-semibold text-deepforest">₱{{ number_format($p->price,2) }}/mo</div>
                      <div class="text-xs muted-forest">{{ $p->type ?? 'Apartment' }}</div>
                    </div>
                  </div>

                  <div class="mt-3 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-sm">
                      <div class="flex gap-1">
                        @for($i=1;$i<=5;$i++)
                          <span class="{{ $i <= round($avgRating) ? 'text-[rgba(255,197,72,1)]' : 'text-[rgba(31,42,28,0.08)]' }}">★</span>
                        @endfor
                      </div>
                      <div class="text-xs muted-forest">{{ $avgRating }}/5</div>
                    </div>

                    <form method="POST" action="{{ route('renter.inquiries.store', $p->id) }}">
                      @csrf
                      <button type="submit" class="px-3 py-1 rounded-lg bg-gradient-to-r from-primary to-glow text-white text-sm font-semibold shadow">Inquire</button>
                    </form>
                  </div>
                </div>
              </a>
            </article>
          @empty
            <p class="col-span-full muted-forest">No properties available.</p>
          @endforelse
        </div>
      </main>

   

  <!-- Logout Modal -->
  <div id="logoutModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="max-w-sm w-full p-6 rounded-2xl glass-forest border border-[rgba(128,177,85,0.08)]">
      <h2 class="text-lg font-semibold text-textdark text-center">Confirm Logout</h2>
      <p class="text-sm muted-forest text-center mt-2">Are you sure you want to log out?</p>
      <div class="mt-6 flex justify-between">
        <button id="confirmLogout" class="px-4 py-2 rounded-lg bg-gradient-to-r from-primary to-glow text-white font-semibold">Yes, Logout</button>
        <button id="cancelLogout" class="px-4 py-2 rounded-lg bg-[rgba(128,177,85,0.10)] text-textdark">Cancel</button>
      </div>
    </div>
  </div>

  <!-- Scripts: toggles, overlays, scroll controls, and modal -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Sidebar elements
      const sidebar = document.getElementById('sidebar');
      const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
      const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');
      const sidebarOverlay = document.getElementById('sidebarOverlay');

      sidebarToggleBtn?.addEventListener('click', () => {
        sidebar.classList.remove('-translate-x-full');
        sidebarOverlay.classList.remove('hidden');
      });
      sidebarCloseBtn?.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
      });
      sidebarOverlay?.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
      });

      // Right panel
      const rightPanel = document.getElementById('rightPanel');
      const openRightBtns = [document.getElementById('rightPanelToggleBtn')];
      const rightPanelCloseBtn = document.getElementById('rightPanelCloseBtn');
      const rightPanelOverlay = document.getElementById('rightPanelOverlay');

      openRightBtns.forEach(btn => btn?.addEventListener('click', () => {
        rightPanel.classList.remove('translate-x-full');
        rightPanelOverlay.classList.remove('hidden');
        document.documentElement.style.overflow = 'hidden';
      }));

      rightPanelCloseBtn?.addEventListener('click', () => {
        rightPanel.classList.add('translate-x-full');
        rightPanelOverlay.classList.add('hidden');
        document.documentElement.style.overflow = '';
      });
      rightPanelOverlay?.addEventListener('click', () => {
        rightPanel.classList.add('translate-x-full');
        rightPanelOverlay.classList.add('hidden');
        document.documentElement.style.overflow = '';
      });

      // Logout Modal
      const logoutModal = document.getElementById('logoutModal');
      const confirmLogout = document.getElementById('confirmLogout');
      const cancelLogout = document.getElementById('cancelLogout');
      const logoutForm = document.getElementById('logoutForm');

      window.openLogoutModal = () => {
        logoutModal.classList.remove('hidden');
      };
      confirmLogout?.addEventListener('click', () => logoutForm?.submit());
      cancelLogout?.addEventListener('click', () => logoutModal.classList.add('hidden'));
      logoutModal?.addEventListener('click', (e) => { if (e.target === logoutModal) logoutModal.classList.add('hidden'); });

      // Responsive behavior: ensure panels are visible/hidden on resize appropriately
      const handleResize = () => {
        if (window.innerWidth >= 1024) {
          // ensure sidebar and right panel are visible on large screens
          sidebar.classList.remove('-translate-x-full');
          rightPanel.classList.remove('translate-x-full');
          sidebarOverlay?.classList.add('hidden');
          rightPanelOverlay?.classList.add('hidden');
          document.documentElement.style.overflow = '';
        } else {
          // start with hidden panels on small screens
          sidebar.classList.add('-translate-x-full');
          rightPanel.classList.add('translate-x-full');
        }
        updateHeroControlsVisibility();
      };
      window.addEventListener('resize', handleResize);
      handleResize();

      // ESC hotkey to close overlays
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
          sidebar.classList.add('-translate-x-full');
          sidebarOverlay?.classList.add('hidden');
          rightPanel.classList.add('translate-x-full');
          rightPanelOverlay.classList.add('hidden');
          logoutModal?.classList.add('hidden');
        }
      });

      /* ---------------- Hero Scroller Controls ---------------- */
      const heroScroll = document.getElementById('heroScroll');
      const heroPrev = document.getElementById('heroPrev');
      const heroNext = document.getElementById('heroNext');

      function scrollByAmount(container, amount) {
        container.scrollBy({ left: amount, behavior: 'smooth' });
      }

      function updateHeroControlsVisibility() {
        if (!heroScroll || !heroPrev || !heroNext) return;
        // show controls only if scrollable horizontally and on large screens
        const scrollable = heroScroll.scrollWidth > heroScroll.clientWidth + 5;
        if (scrollable && window.innerWidth >= 768) {
          heroPrev.classList.remove('hidden');
          heroNext.classList.remove('hidden');
        } else {
          heroPrev.classList.add('hidden');
          heroNext.classList.add('hidden');
        }
      }

      heroPrev?.addEventListener('click', () => {
        const amount = Math.round(heroScroll.clientWidth * 0.8);
        scrollByAmount(heroScroll, -amount);
      });
      heroNext?.addEventListener('click', () => {
        const amount = Math.round(heroScroll.clientWidth * 0.8);
        scrollByAmount(heroScroll, amount);
      });

      // support keyboard arrows for hero scroller when focused
      heroScroll?.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight') heroNext?.click();
        if (e.key === 'ArrowLeft') heroPrev?.click();
      });

      // drag-to-scroll (basic)
      (function enableDragScroll(el) {
        if (!el) return;
        let isDown = false, startX, scrollLeft;
        el.addEventListener('mousedown', (e) => { isDown = true; el.classList.add('active'); startX = e.pageX - el.offsetLeft; scrollLeft = el.scrollLeft; });
        el.addEventListener('mouseleave', () => { isDown = false; el.classList.remove('active'); });
        el.addEventListener('mouseup', () => { isDown = false; el.classList.remove('active'); });
        el.addEventListener('mousemove', (e) => {
          if (!isDown) return;
          e.preventDefault();
          const x = e.pageX - el.offsetLeft;
          const walk = (x - startX) * 1; //scroll-fast
          el.scrollLeft = scrollLeft - walk;
        });
        // touch support
        let startTouchX = 0, startTouchScroll = 0;
        el.addEventListener('touchstart', (e) => { startTouchX = e.touches[0].pageX; startTouchScroll = el.scrollLeft; }, {passive:true});
        el.addEventListener('touchmove', (e) => { const diff = e.touches[0].pageX - startTouchX; el.scrollLeft = startTouchScroll - diff; }, {passive:true});
      })(heroScroll);

      // recompute hero controls on scroll / resize
      heroScroll?.addEventListener('scroll', () => { /* could update active state */ });
      window.addEventListener('load', updateHeroControlsVisibility);
      window.addEventListener('resize', updateHeroControlsVisibility);

      /* ---------------- Owners List Controls ---------------- */
      const ownersList = document.getElementById('ownersList');
      const ownersUp = document.getElementById('ownersUp');
      const ownersDown = document.getElementById('ownersDown');

      ownersUp?.addEventListener('click', () => {
        if (!ownersList) return;
        ownersList.scrollBy({ top: -120, behavior: 'smooth' });
      });
      ownersDown?.addEventListener('click', () => {
        if (!ownersList) return;
        ownersList.scrollBy({ top: 120, behavior: 'smooth' });
      });

      // optionally show/hide owners controls when content fits
      function updateOwnersControlsVisibility() {
        if (!ownersList) return;
        const canScroll = ownersList.scrollHeight > ownersList.clientHeight + 4;
        ownersUp?.parentElement?.classList.toggle('hidden', !canScroll);
      }
      window.addEventListener('resize', updateOwnersControlsVisibility);
      window.addEventListener('load', updateOwnersControlsVisibility);

      // up/down on mouse wheel makes the list scroll
      ownersList?.addEventListener('wheel', (e) => {
        // When wheel on ownersList, scroll it normally (do nothing special)
      }, {passive:true});

      // helper: smooth anchor scrolling for internal links
      document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', (e) => {
          const target = document.querySelector(a.getAttribute('href'));
          if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            // also open sidebar if on mobile
            if (window.innerWidth < 1024) {
              sidebar.classList.add('-translate-x-full');
              sidebarOverlay?.classList.add('hidden');
            }
          }
        });
      });
    });
  </script>
</body>
</html>
