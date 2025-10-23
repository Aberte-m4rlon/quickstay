<x-guest-layout>
  <div class="min-h-screen flex items-center justify-center relative overflow-hidden bg-gradient-to-br from-blue-700 via-blue-600 to-blue-500 px-4">
    <!-- Floating Glass Container -->
    <div class="w-full max-w-5xl flex flex-col md:flex-row rounded-2xl overflow-hidden shadow-2xl backdrop-blur-2xl bg-white/10 border border-white/20">

      <!-- LEFT PANEL -->
      <div class="hidden md:flex w-1/2 flex-col justify-between p-12 relative text-white">
        <!-- Decorative gradient circles -->
        <div class="absolute inset-0">
          <div class="absolute top-10 left-10 w-56 h-56 bg-white/10 rounded-full blur-3xl"></div>
          <div class="absolute bottom-20 right-10 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 space-y-6">
          <h1 class="text-4xl font-bold">Join us today!</h1>
          <p class="text-blue-100 leading-relaxed">Create your QuickStay account and start your journey as a renter or property owner.</p>
        </div>

        <div class="relative z-10 flex items-center space-x-4 mt-10">
          <span class="text-sm text-blue-100">Follow us:</span>
          <a href="#" class="hover:text-white"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="hover:text-white"><i class="fab fa-twitter"></i></a>
          <a href="#" class="hover:text-white"><i class="fab fa-instagram"></i></a>
        </div>
      </div>

      <!-- RIGHT PANEL -->
      <div class="w-full md:w-1/2 bg-white/20 backdrop-blur-xl p-10 md:p-16 flex flex-col justify-center relative text-white">
        <div class="mb-8 text-center">
          <img src="/image/quick.png" alt="QuickStay Logo" class="w-24 mx-auto mb-4">
          <h2 class="text-3xl font-semibold text-white">Create Account</h2>
          <p class="text-sm text-blue-100 mt-1">Sign up as Renter or Owner</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4" enctype="multipart/form-data">
          @csrf

          <!-- Name -->
          <div>
            <label for="name" class="block text-sm font-medium text-blue-100">Full Name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
              class="mt-1 w-full rounded-lg border border-white/30 bg-white/10 text-white placeholder-white/70 px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-300" />
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-blue-100">Email Address</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required
              class="mt-1 w-full rounded-lg border border-white/30 bg-white/10 text-white placeholder-white/70 px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
          </div>

          <!-- Role -->
          <div>
            <label for="role" class="block text-sm font-medium text-blue-100">Select Role</label>
            <select id="role" name="role" required
              class="mt-1 w-full rounded-lg border border-white/30 bg-white/10 text-white px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
              <option value="">Choose role...</option>
              <option value="renter">Renter</option>
              <option value="owner">Owner</option>
            </select>
          </div>

          <!-- Owner Requirements -->
          <div id="owner-fields" class="hidden space-y-4 mt-2">
            <div>
              <label for="phone" class="block text-sm font-medium text-blue-100">Phone Number</label>
              <input id="phone" name="phone" type="text"
                class="mt-1 w-full rounded-lg border border-white/30 bg-white/10 text-white px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
            </div>

            <div>
              <label for="valid_id" class="block text-sm font-medium text-blue-100">Valid ID</label>
              <input id="valid_id" name="valid_id" type="file" accept="image/*"
                class="mt-1 w-full rounded-lg border border-white/30 bg-white/10 text-white px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
              <p class="text-xs text-blue-200 mt-1">Upload a photo of a valid government ID (JPEG, PNG, or PDF).</p>
            </div>
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block text-sm font-medium text-blue-100">Password</label>
            <input id="password" name="password" type="password" required
              class="mt-1 w-full rounded-lg border border-white/30 bg-white/10 text-white px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
          </div>

          <!-- Confirm Password -->
          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-blue-100">Confirm Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
              class="mt-1 w-full rounded-lg border border-white/30 bg-white/10 text-white px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-300" />
          </div>

          <!-- Submit -->
          <div class="flex items-center justify-between pt-4">
            <a href="{{ route('login') }}" class="text-sm text-blue-200 hover:underline">
              Already registered?
            </a>
            <button type="submit"
              class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition">
              Register
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Script for showing owner fields -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const roleSelect = document.getElementById('role');
      const ownerFields = document.getElementById('owner-fields');

      roleSelect.addEventListener('change', () => {
        if (roleSelect.value === 'owner') {
          ownerFields.classList.remove('hidden');
          ownerFields.classList.add('block');
        } else {
          ownerFields.classList.add('hidden');
          ownerFields.classList.remove('block');
        }
      });
    });
  </script>

  <!-- Success Modal -->
  @if (session('success'))
  <div id="successModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-2xl shadow-xl w-96 p-6 text-center space-y-4 animate-fade-in">
      <div class="flex justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
      </div>
      <h2 class="text-xl font-semibold text-gray-800">Registration Successful!</h2>
      <p class="text-gray-500 text-sm">{{ session('success') }}</p>
      <button onclick="document.getElementById('successModal').remove()"
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition">
        Continue
      </button>
    </div>
  </div>

  <style>
    @keyframes fade-in {
      from {
        opacity: 0;
        transform: scale(0.95);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    .animate-fade-in {
      animation: fade-in 0.3s ease-out;
    }
  </style>
  @endif

  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</x-guest-layout>
