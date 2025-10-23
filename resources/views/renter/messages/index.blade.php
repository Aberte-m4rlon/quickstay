<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>My Messages</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <style>
    :root {
      --lightest: #EAEF9D;
      --light: #C1D95C;
      --mid: #80B155;
      --dark: #49842B;
      --darker: #336A29;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, var(--lightest), var(--dark));
      min-height: 100vh;
      padding: 2rem;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      color: var(--darker);
    }

    .glass {
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.4);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      transition: all 0.3s ease;
    }

    .glass:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 28px rgba(0, 0, 0, 0.18);
    }

    .back-btn {
      position: absolute;
      top: 1.5rem;
      left: 1.5rem;
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--mid), var(--dark));
      color: white;
      font-weight: bold;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      transition: all 0.2s ease-in-out;
    }

    .back-btn:hover {
      background: linear-gradient(135deg, var(--light), var(--dark));
      transform: scale(1.08);
    }

    .owner-avatar {
      background: linear-gradient(135deg, var(--mid), var(--dark));
    }

    .card-hover:hover {
      background: rgba(255, 255, 255, 0.85);
      transform: scale(1.02);
      transition: all 0.2s ease-in-out;
    }
  </style>
</head>

<body>
  <!-- Back Button -->
      <a href="{{ route('renter.dashboard') }}" class="text-sm text-blue-600 hover:underline">← Back</a>
  <div class="glass w-full max-w-2xl rounded-2xl p-6 mt-10">
    <h2 class="text-2xl font-semibold mb-6 text-[var(--darker)] text-center">💬 My Conversations</h2>

    @if($owners->isEmpty())
      <p class="text-gray-700 text-center">You have no active conversations yet.</p>
    @else
      <div class="space-y-4">
        @foreach($owners as $owner)
          <a href="{{ route('renter.messages.chat', $owner->id) }}" 
             class="block p-4 rounded-xl border border-white/30 shadow-sm bg-white/70 card-hover transition">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 owner-avatar rounded-full flex items-center justify-center text-white font-semibold">
                {{ strtoupper(substr($owner->name, 0, 1)) }}
              </div>
              <div>
                <h3 class="font-semibold text-[var(--darker)]">{{ $owner->name }}</h3>
                <p class="text-sm text-[var(--mid)]">Tap to view your messages</p>
              </div>
            </div>
          </a>
        @endforeach
      </div>
    @endif
  </div>
</body>
</html>
