<x-guest-layout>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#1A2F1A] via-[#204020] to-[#0D1A0D] px-4 relative overflow-hidden">

    <!-- Decorative background mist and orbs -->
    <div class="absolute inset-0 overflow-hidden">
      <!-- Ambient mist layers -->
      <div class="absolute inset-0 bg-gradient-to-b from-[#0D1A0D]/50 via-transparent to-[#0D1A0D]/80 backdrop-blur-3xl"></div>
      <!-- Floating lights -->
      <div class="absolute top-20 left-10 w-80 h-80 bg-[#A6C64E]/15 rounded-full blur-[140px]"></div>
      <div class="absolute bottom-20 right-10 w-[28rem] h-[28rem] bg-[#6C8E3D]/20 rounded-full blur-[160px]"></div>
      <div class="absolute top-1/2 left-1/3 w-[18rem] h-[18rem] bg-[#A6C64E]/10 rounded-full blur-[100px]"></div>
    </div>

    <!-- Glass container -->
    <div class="relative w-full max-w-5xl flex flex-col md:flex-row rounded-[2rem] overflow-hidden shadow-2xl backdrop-blur-2xl bg-white/10 border border-white/20">

      <!-- LEFT PANEL -->
      <div class="hidden md:flex w-1/2 bg-gradient-to-br from-[#2A4D2A]/60 via-[#1E441E]/70 to-[#0F1E0F]/60 text-[#E6EED8] flex-col justify-center p-12 relative backdrop-blur-2xl border-r border-[#A6C64E]/10">
        <div class="absolute inset-0">
          <div class="absolute top-10 left-10 w-64 h-64 bg-[#A6C64E]/20 rounded-full blur-[100px]"></div>
          <div class="absolute bottom-16 right-10 w-80 h-80 bg-[#6C8E3D]/10 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative z-10 space-y-6 drop-shadow-lg">
          <div class="flex items-center space-x-3">
            <div class="bg-[#A6C64E]/20 p-3 rounded-full shadow-md backdrop-blur-lg border border-[#A6C64E]/30">
              <img src="{{ asset('image/quick.png') }}" alt="QuickStay" class="h-45 w-auto drop-shadow-xl">
            </div>
          </div>

          <h2 class="text-4xl font-bold leading-tight drop-shadow-2xl">Welcome Back</h2>
          <p class="text-[#E6EED8]/80 text-lg">Manage your bookings, users, and reviews with ease.</p>
        </div>
      </div>

      <!-- RIGHT PANEL -->
      <div class="w-full md:w-1/2 backdrop-blur-3xl bg-white/10 p-10 md:p-16 flex flex-col justify-center relative border-l border-[#A6C64E]/10 shadow-2xl">
        <form method="POST" action="{{ route('login') }}" class="w-full space-y-6">
          @csrf

          <h2 class="text-3xl font-bold text-[#E6EED8] mb-2 drop-shadow-lg">Sign In</h2>
          <p class="text-[#A6C64E]/70 text-sm mb-6">Enter your credentials to access your dashboard.</p>

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-[#A6C64E]/80 mb-1">Email address</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required
              class="w-full px-4 py-3 border border-[#A6C64E]/30 rounded-xl bg-white/10 shadow-inner text-[#E6EED8] placeholder-[#A6C64E]/50 focus:outline-none focus:ring-2 focus:ring-[#A6C64E]/60 focus:border-[#A6C64E]/70 backdrop-blur-lg transition duration-300" />
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block text-sm font-medium text-[#A6C64E]/80 mb-1">Password</label>
            <input id="password" name="password" type="password" required
              class="w-full px-4 py-3 border border-[#A6C64E]/30 rounded-xl bg-white/10 shadow-inner text-[#E6EED8] placeholder-[#A6C64E]/50 focus:outline-none focus:ring-2 focus:ring-[#A6C64E]/60 focus:border-[#A6C64E]/70 backdrop-blur-lg transition duration-300" />
          </div>

          <!-- Remember + Forgot -->
          <div class="flex items-center justify-between text-sm text-[#A6C64E]/80">
            <label class="flex items-center space-x-2">
              <input id="remember_me" type="checkbox" name="remember"
                class="rounded border-[#A6C64E]/40 bg-transparent text-[#A6C64E] focus:ring-[#A6C64E]/60">
              <span>Remember me</span>
            </label>
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-[#C8E86E] hover:text-[#E6EED8] font-medium transition">
              Forgot password?
            </a>
            @endif
          </div>

          <!-- Buttons -->
          <div class="flex space-x-3">
            <button type="submit"
              class="w-1/2 py-2.5 text-sm font-semibold bg-gradient-to-r from-[#6C8E3D] to-[#A6C64E] hover:opacity-95 text-white rounded-xl shadow-lg hover:shadow-2xl backdrop-blur-xl transition-all duration-300 transform hover:scale-[1.02]">
              Login
            </button>
            <a href="{{ route('register') }}"
              class="w-1/2 py-2.5 text-sm font-semibold border border-[#A6C64E]/50 text-[#A6C64E] hover:bg-[#A6C64E] hover:text-[#0F1E0F] text-center rounded-xl shadow-md backdrop-blur-xl transition-all duration-300 transform hover:scale-[1.02]">
              Sign Up
            </a>
          </div>

          <!-- Socials -->
          <div class="text-center pt-6">
            <p class="text-sm text-[#A6C64E]/70">Follow us</p>
            <div class="flex justify-center space-x-6 mt-3 text-[#A6C64E]">
              <a href="#" class="hover:text-[#C8E86E] transition"><i class="fab fa-facebook-f"></i></a>
              <a href="#" class="hover:text-[#C8E86E] transition"><i class="fab fa-twitter"></i></a>
              <a href="#" class="hover:text-[#C8E86E] transition"><i class="fab fa-instagram"></i></a>
            </div>
          </div>
        </form>

        <!-- ❗ Modal for invalid credentials -->
        @if ($errors->any())
        <div id="errorModal"
          class="fixed inset-0 flex items-center justify-center bg-black/60 z-50 backdrop-blur-sm">
          <div class="bg-[#0F1E0F]/80 backdrop-blur-xl rounded-xl shadow-2xl p-8 w-80 text-center space-y-4 border border-[#A6C64E]/30">
            <div class="text-[#A6C64E] text-5xl">
              <i class="fas fa-times-circle"></i>
            </div>
            <h3 class="text-lg font-semibold text-[#E6EED8]">Login Failed</h3>
            <p class="text-sm text-[#A6C64E]/70">Invalid email or password. Please try again.</p>
            <button onclick="document.getElementById('errorModal').remove()"
              class="mt-2 px-4 py-2 bg-gradient-to-r from-[#3E702B] to-[#A6C64E] text-white rounded-lg hover:opacity-90 transition">
              OK
            </button>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>

  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</x-guest-layout>
