<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $property->title }} — QuickStay</title>

  <!-- TailwindCSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { poppins: ['Poppins', 'sans-serif'] },
          colors: {
            primary: '#80B155',
            accent: '#C1D95C',
            forest: '#1E441E',
            deep: '#0F1E0F',
            light: '#E6EED8'
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    .glass {
      background: rgba(255, 255, 255, 0.4);
      backdrop-filter: blur(14px) saturate(140%);
      -webkit-backdrop-filter: blur(14px) saturate(140%);
      border: 1px solid rgba(255, 255, 255, 0.25);
    }
    .star {
      color: #FFD700;
      font-size: 1.25rem;
    }
    .star-empty {
      color: rgba(0,0,0,0.15);
    }
    .star-half {
      position: relative;
      display: inline-block;
    }
    .star-half::before {
      content: '★';
      color: rgba(0,0,0,0.15);
    }
    .star-half::after {
      content: '★';
      color: #FFD700;
      position: absolute;
      left: 0;
      width: 50%;
      overflow: hidden;
    }
  </style>
</head>
<body class="font-poppins bg-gradient-to-br from-[#F4F8F0] to-[#EAEFDD] min-h-screen text-[#1F2A1C] flex items-center justify-center p-6">

  <div class="max-w-5xl w-full glass rounded-3xl overflow-hidden shadow-xl border border-primary/20">

    <!-- Header / Banner -->
    <div class="relative">
      <img src="{{ $property->image_url ?? 'https://via.placeholder.com/800x400?text=QuickStay' }}" 
           alt="{{ $property->title }}" 
           class="w-full h-80 object-cover">
      <div class="absolute inset-0 bg-gradient-to-t from-[#0F1E0F]/80 to-transparent flex items-end justify-between p-8">
        <div>
          <h1 class="text-4xl font-bold text-white drop-shadow-lg">{{ $property->title }}</h1>
          <p class="text-accent text-sm font-medium">{{ $property->address }}</p>
        </div>
        <div class="bg-white/70 backdrop-blur-md text-forest font-bold px-4 py-2 rounded-lg shadow-lg border border-white/40">
          ₱{{ number_format($property->price, 2) }} / month
        </div>
      </div>
    </div>

    <!-- Content -->
    <div class="p-8 bg-white/50 backdrop-blur-xl">

      {{-- Ratings --}}
      @php
        $avg = round($property->feedbacks->avg('rating') ?? 0, 1);
        $fullStars = floor($avg);
        $halfStar = ($avg - $fullStars) >= 0.5;
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
      @endphp

      <div class="flex items-center mb-4">
        @for($i = 1; $i <= $fullStars; $i++)
          <span class="star">★</span>
        @endfor
        @if($halfStar)
          <span class="star-half"></span>
        @endif
        @for($i = 1; $i <= $emptyStars; $i++)
          <span class="star-empty">★</span>
        @endfor
        <span class="ml-2 text-[#1F2A1C]/70 font-medium">{{ $avg }}/5 average rating</span>
      </div>

      {{-- Description --}}
      <p class="text-[#1F2A1C]/80 mb-8 leading-relaxed border-l-4 border-primary/50 pl-4 italic bg-white/50 backdrop-blur-sm rounded-lg p-3 shadow-inner">
        {{ $property->description }}
      </p>

      {{-- Feedbacks --}}
      <h2 class="text-2xl font-semibold text-primary mb-4 border-b border-primary/20 pb-2">Feedbacks</h2>
      @forelse($property->feedbacks as $f)
        <div class="mb-4 bg-white/60 backdrop-blur-md p-4 rounded-xl border border-primary/20 hover:bg-accent/10 hover:shadow-lg transition-all">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
              <strong class="text-forest">{{ $f->user->name ?? 'Anonymous' }}</strong>
              <span class="text-sm text-[#1F2A1C]/60">• Rated: {{ $f->rating }}/5</span>
            </div>
            <div class="flex items-center">
              @for($i = 1; $i <= 5; $i++)
                @if($i <= $f->rating)
                  <span class="star">★</span>
                @else
                  <span class="star-empty">★</span>
                @endif
              @endfor
            </div>
          </div>
          <p class="text-[#1F2A1C]/80 mt-2 italic">“{{ $f->comment }}”</p>
        </div>
      @empty
        <p class="text-[#1F2A1C]/50 italic">No feedback yet for this property.</p>
      @endforelse

      <!-- ✅ Add Feedback Form -->
      <div class="mt-10 border-t border-primary/20 pt-6">
        <h2 class="text-2xl font-semibold text-primary mb-4">Leave a Feedback</h2>

        <form action="{{ route('property.feedback.store', $property->id) }}" method="POST" class="space-y-4">
          @csrf
          <div>
            <label for="rating" class="block text-sm font-semibold text-forest mb-1">Your Rating:</label>
            <div class="flex gap-2 text-2xl">
              @for($i = 1; $i <= 5; $i++)
                <label>
                  <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                  <span class="cursor-pointer peer-checked:text-yellow-400 text-gray-300 hover:text-yellow-400 transition">★</span>
                </label>
              @endfor
            </div>
          </div>

          <div>
            <label for="comment" class="block text-sm font-semibold text-forest mb-1">Your Feedback:</label>
            <textarea name="comment" id="comment" rows="3" class="w-full p-3 rounded-lg border border-primary/30 bg-white/60 backdrop-blur-md focus:ring-2 focus:ring-primary outline-none" placeholder="Write your experience..." required></textarea>
          </div>

          <div class="flex justify-end">
            <button type="submit" class="bg-gradient-to-r from-primary to-accent text-[#1F2A1C] font-semibold px-6 py-3 rounded-xl shadow-md hover:scale-105 transition-all border border-white/40">
              Submit Feedback
            </button>
          </div>
        </form>
      </div>

      <!-- Back Button -->
      <div class="pt-8 flex justify-end">
        <a href="{{ route('renter.dashboard') }}" 
           class="bg-gradient-to-r from-primary to-accent text-[#1F2A1C] px-6 py-3 rounded-xl shadow-md hover:scale-105 transition-all font-semibold flex items-center gap-2 backdrop-blur-md border border-white/40">
          ← Back to Properties
        </a>
      </div>
    </div>
  </div>

  <!-- Floating Message Icon -->
  <a href="{{ route('messages.chat', $property) }}" 
     class="fixed bottom-8 right-8 bg-gradient-to-r from-primary to-accent text-white w-16 h-16 flex items-center justify-center rounded-full shadow-2xl hover:scale-110 hover:opacity-90 transition-all backdrop-blur-md border border-white/30">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
            d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.956 9.956 0 01-4.528-1.107L3 20l1.107-4.472A9.956 9.956 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
    </svg>
  </a>

</body>
</html>
