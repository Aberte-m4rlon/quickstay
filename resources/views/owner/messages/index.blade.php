<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Owner Conversations</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background: linear-gradient(135deg, #0f5132 0%, #198754 100%);
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
    }

    .glass-card {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.25);
      box-shadow: 0 4px 25px rgba(0, 0, 0, 0.2);
    }

    .conversation-scroll {
      height: 420px;
      overflow-y: auto;
      background: rgba(255, 255, 255, 0.08);
      border-radius: 1rem;
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .message-owner {
      background: linear-gradient(135deg, #00b96b 0%, #00693e 100%);
      box-shadow: 0 2px 8px rgba(0, 128, 0, 0.3);
    }

    .message-renter {
      background: rgba(255, 255, 255, 0.8);
      color: #064e3b;
    }

    .btn-green {
      background: linear-gradient(135deg, #00b96b 0%, #009e56 100%);
      transition: all 0.25s ease-in-out;
    }

    .btn-green:hover {
      filter: brightness(1.1);
      transform: translateY(-2px);
    }
  </style>
</head>

<body class="text-gray-50">
  <div class="min-h-screen flex items-start justify-center py-10 px-4">
    <div class="w-full max-w-6xl">

      <header class="mb-8 text-center">
        <h1 class="text-4xl font-bold">💬 Owner Conversations</h1>
        <p class="text-sm text-green-200 mt-2">Manage chats with your renters</p>
      </header>

      <!-- Back Button -->
      <button onclick="history.back()"
        class="absolute top-6 left-6 w-10 h-10 rounded-full flex items-center justify-center shadow-md hover:scale-105 transition-transform"
        title="Back">
        <span class="text-lg font-bold">←</span>
      </button>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- LEFT SIDEBAR -->
        <aside class="col-span-1 glass-card rounded-2xl p-5">
          <h2 class="text-lg font-semibold mb-4 text-green-100">Active Conversations</h2>

          @if($renterIds->isEmpty())
            <p class="text-sm text-gray-200">No renter conversations yet.</p>
          @else
            <ul class="space-y-3">
              @foreach($renterIds as $renterId)
                @php
                  $repMsg = $messages->firstWhere(function($m) use ($renterId, $ownerId) {
                      return $m->user_id == $renterId || $m->receiver_id == $renterId;
                  });
                  $renterName = optional($repMsg->user)->name ?? 'Renter #' . $renterId;
                  $count = $messages->filter(function($m) use ($renterId, $ownerId) {
                      return $m->user_id == $renterId || $m->receiver_id == $renterId;
                  })->count();
                @endphp
                <li>
                  <a href="#conversation-{{ $renterId }}" class="block glass-card px-4 py-3 rounded-xl hover:bg-green-800/30 transition-all duration-300">
                    <div class="flex justify-between items-center">
                      <div>
                        <div class="font-semibold text-green-50">{{ $renterName }}</div>
                        <div class="text-xs text-green-200">Messages: {{ $count }}</div>
                      </div>
                      <span class="text-green-300 text-lg">→</span>
                    </div>
                  </a>
                </li>
              @endforeach
            </ul>
          @endif
        </aside>

        <!-- RIGHT CONVERSATION PANELS -->
        <main class="col-span-2 space-y-6">
          @foreach($renterIds as $renterId)
            @php
              $conversation = $messages->filter(function($m) use ($renterId, $ownerId) {
                  return ($m->user_id == $ownerId && $m->receiver_id == $renterId)
                      || ($m->user_id == $renterId && $m->receiver_id == $ownerId);
              })->sortBy('created_at')->values();
              $renterName = optional($conversation->first()->user)->name ?? 'Renter #' . $renterId;
            @endphp

            <section id="conversation-{{ $renterId }}" class="glass-card rounded-2xl p-6">
              <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-green-100">{{ $renterName }}</h3>
                <div class="text-sm text-green-200">{{ $conversation->count() }} message{{ $conversation->count() > 1 ? 's' : '' }}</div>
              </div>

              <div class="conversation-scroll p-4 mb-4">
                @forelse($conversation as $msg)
                  @if($msg->user_id == $ownerId)
                    <div class="flex justify-end mb-3">
                      <div class="max-w-[75%] text-right">
                        <div class="inline-block message-owner text-white px-4 py-2 rounded-2xl break-words">
                          {{ $msg->content }}
                        </div>
                        <div class="text-xs text-green-200 mt-1">{{ $msg->created_at->format('Y-m-d H:i') }}</div>
                      </div>
                    </div>
                  @else
                    <div class="flex justify-start mb-3">
                      <div class="max-w-[75%]">
                        <div class="inline-block message-renter px-4 py-2 rounded-2xl break-words shadow">
                          {{ $msg->content }}
                        </div>
                        <div class="text-xs text-green-900 mt-1">{{ $msg->created_at->format('Y-m-d H:i') }}</div>
                      </div>
                    </div>
                  @endif
                @empty
                  <p class="text-sm text-gray-300">No messages yet.</p>
                @endforelse
              </div>

              {{-- REPLY FORM --}}
              <form class="flex gap-2" method="POST" action="{{ route('owner.messages.send') }}">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $renterId }}">
                <input type="text" name="content" placeholder="Type your reply..."
                       class="flex-1 px-4 py-2 rounded-xl bg-white/40 text-gray-900 placeholder-gray-700 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                <button type="submit" class="btn-green px-4 py-2 rounded-xl text-white font-semibold">Send</button>
              </form>
            </section>
          @endforeach
        </main>
      </div>
    </div>
  </div>
</body>
</html>
