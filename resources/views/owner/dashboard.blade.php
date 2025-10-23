<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Owner Dashboard — QuickStay</title>

  <!-- TailwindCSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { poppins: ['Poppins', 'sans-serif'] },
          colors: {
            primary: '#4F46E5',
            blueglass: '#A7B3E9',
            bluedeep: '#8A9BE0'
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  
  <style>
    body {
      background: linear-gradient(135deg, #cfd5f7 0%, #a7b3e9 40%, #8a9be0 100%);
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      color: #1e293b;
      overflow-x: hidden;
    }

    .glass-container {
      backdrop-filter: blur(20px);
      background: rgba(255, 255, 255, 0.15);
      border-radius: 1.5rem;
      padding: 2rem;
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Headings */
    h1 {
      color: #111827;
      text-shadow: 0 2px 6px rgba(255, 255, 255, 0.4);
    }

    /* Cards */
    .status-card {
      background: rgba(255, 255, 255, 0.7);
      border: 1px solid rgba(255, 255, 255, 0.3);
      backdrop-filter: blur(12px);
      border-radius: 1rem;
      transition: all 0.4s ease;
    }

    .status-card:hover {
      transform: translateY(-5px) scale(1.02);
      box-shadow: 0 16px 40px rgba(0, 0, 0, 0.12);
    }

    /* Table */
    table {
      border-collapse: separate;
      border-spacing: 0;
      width: 100%;
    }

    thead th {
      background: rgba(255, 255, 255, 0.5);
      text-transform: uppercase;
      font-weight: 600;
      letter-spacing: 0.05em;
      color: #1f2937;
      border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    tbody tr {
      transition: background 0.3s ease, transform 0.3s ease;
    }

    tbody tr:hover {
      background: rgba(255, 255, 255, 0.5);
      transform: scale(1.01);
    }

    /* Buttons */
    .btn {
      border-radius: 0.75rem;
      font-weight: 500;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
      transition: all 0.3s ease;
    }

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    footer {
      margin-top: 3rem;
      color: #334155;
      font-size: 0.9rem;
      letter-spacing: 0.02em;
      animation: fadeIn 1.2s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(12px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Scrollbar */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-thumb {
      background: rgba(0, 0, 0, 0.2);
      border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb:hover { background: rgba(0, 0, 0, 0.35); }

    @media (max-width: 768px) {
      .glass-container { padding: 1.5rem; }
      .header-actions { flex-direction: column; gap: 0.75rem; align-items: stretch; }
      .header-actions a, .header-actions button { width: 100%; text-align: center; }
    }
  </style>
</head>
<body class="p-6">

  <div class="max-w-7xl mx-auto glass-container">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
      <div class="mb-4 sm:mb-0">
        <h1 class="text-3xl font-bold">Owner Dashboard</h1>
        <p class="text-gray-600">Welcome back, {{ auth()->user()->name }} 👋 Manage your properties here.</p>
      </div>

      <div class="flex items-center space-x-3 header-actions">
        @php
          $unreadCount = \App\Models\Message::whereIn('property_id', auth()->user()->properties->pluck('id'))
                          ->where('is_read', false)
                          ->count();
        @endphp
        <a href="{{ route('owner.profile.edit') }}" 
          class="bg-indigo-600 text-white px-4 py-2 btn">
          Profile
        </a>

<a href="{{ route('owner.messages.index') }}" 
   class="relative bg-purple-600 text-white px-4 py-2 btn">
   Messages
   @if($unreadCount > 0)
      <span class="absolute -top-2 -right-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold text-white bg-red-600 rounded-full">
         {{ $unreadCount }}
      </span>
   @endif
</a>


        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="bg-red-600 text-white px-4 py-2 btn">Logout</button>
        </form>

        <a href="{{ route('owner.properties.create') }}"
           class="bg-blue-600 text-white px-4 py-2 btn">
          + Add Property
        </a>
      </div>
    </div>

    <!-- Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
      <div class="status-card border-t-4 border-green-600 shadow p-6 text-center">
        <h2 class="text-lg font-semibold text-gray-700">Available</h2>
        <p class="text-4xl font-bold text-green-700">{{ $available ?? 0 }}</p>
      </div>

      <div class="status-card border-t-4 border-yellow-500 shadow p-6 text-center">
        <h2 class="text-lg font-semibold text-gray-700">Partial</h2>
        <p class="text-4xl font-bold text-yellow-600">{{ $partial ?? 0 }}</p>
      </div>

      <div class="status-card border-t-4 border-red-500 shadow p-6 text-center">
        <h2 class="text-lg font-semibold text-gray-700">Full</h2>
        <p class="text-4xl font-bold text-red-600">{{ $full ?? 0 }}</p>
      </div>
    </div>

    <!-- Property Table -->
    <div class="rounded-xl overflow-hidden shadow-lg bg-white/40 backdrop-blur-xl border border-white/30">
      <div class="flex justify-between items-center p-5 border-b border-white/40">
        <h2 class="text-2xl font-semibold text-gray-700">My Properties</h2>
        <span class="text-sm text-gray-600">Total: {{ $properties->count() }}</span>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead>
            <tr>
              <th class="px-6 py-3 text-left">Title</th>
              <th class="px-6 py-3 text-left">Address</th>
              <th class="px-6 py-3 text-left">Status</th>
              <th class="px-6 py-3 text-left">Verification</th>
              <th class="px-6 py-3 text-left">Price</th>
              <th class="px-6 py-3 text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($properties as $p)
              <tr class="hover:bg-white/50 transition">
                <td class="px-6 py-4 font-medium">{{ $p->title }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $p->address }}</td>
                <td class="px-6 py-4">
                  <form action="{{ route('owner.properties.status', $p->id) }}" method="POST" class="inline-block">
                    @csrf
                    <select name="status" onchange="this.form.submit()" class="rounded border-gray-300 px-2 py-1">
                      <option value="available" {{ $p->status == 'available' ? 'selected' : '' }}>Available</option>
                      <option value="partial" {{ $p->status == 'partial' ? 'selected' : '' }}>Partial</option>
                      <option value="full" {{ $p->status == 'full' ? 'selected' : '' }}>Full</option>
                    </select>
                  </form>
                </td>
                <td class="px-6 py-4">
                  @if($p->is_verified)
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Verified</span>
                  @else
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Pending</span>
                  @endif
                </td>
                <td class="px-6 py-4">₱{{ number_format($p->price, 2) }}</td>
                <td class="px-6 py-4 text-center space-x-2">
                  <a href="{{ route('owner.properties.edit', $p->id) }}" class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">Edit</a>
                  <form action="{{ route('owner.properties.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this property?');">
                    @csrf
                    @method('DELETE')
                    <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center py-6 text-gray-500">No properties found. Add one above.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <footer class="mt-10 text-center text-gray-700 text-sm">
      <p>© {{ date('Y') }} QuickStay Owner Dashboard — Manage your listings easily.</p>
    </footer>
  </div>

</body>
</html>
