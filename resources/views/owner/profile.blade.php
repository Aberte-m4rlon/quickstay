<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile — QuickStay</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #cfd5f7 0%, #a7b3e9 40%, #8a9be0 100%);
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      color: #1e293b;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem;
    }

    .glass-box {
      backdrop-filter: blur(25px);
      background: rgba(255, 255, 255, 0.2);
      border-radius: 1.5rem;
      box-shadow: 0 10px 40px rgba(0,0,0,0.15);
      border: 1px solid rgba(255,255,255,0.3);
      max-width: 550px;
      width: 100%;
      padding: 2rem;
    }

    .profile-pic {
      width: 120px;
      height: 120px;
      border-radius: 9999px;
      object-fit: cover;
      border: 3px solid rgba(255,255,255,0.8);
      box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }
  </style>
</head>
<body>

  <div class="glass-box">
    <h1 class="text-2xl font-semibold mb-6 text-center">My Profile</h1>

    @if(session('success'))
      <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-sm">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('owner.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf

      <div class="flex flex-col items-center mb-4">
        <img 
          src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://via.placeholder.com/120?text=No+Photo' }}" 
          alt="Profile Photo" 
          class="profile-pic mb-3">
        <input type="file" name="profile_photo" accept="image/*" class="block text-sm text-gray-600">
      </div>

      <div>
        <label class="block text-gray-700 mb-1">Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}"
               class="w-full px-4 py-2 rounded border border-gray-300 focus:ring focus:ring-blue-300 focus:outline-none">
      </div>

      <div>
        <label class="block text-gray-700 mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}"
               class="w-full px-4 py-2 rounded border border-gray-300 focus:ring focus:ring-blue-300 focus:outline-none">
      </div>

      <div class="flex justify-between mt-6">
        <a href="{{ route('owner.dashboard') }}" ...>← Back</a>
        <button type="submit" 
                class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
          Save Changes
        </button>
      </div>
    </form>
  </div>

</body>
</html>
