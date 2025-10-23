<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Chat with {{ $owner->name }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #fbc2eb, #a6c1ee);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 2rem;
    }
    .bubble {
      padding: 0.75rem 1rem;
      border-radius: 1rem;
      max-width: 70%;
      word-wrap: break-word;
    }
  </style>
</head>
<body>
  <div class="w-full max-w-2xl glass rounded-2xl p-6 bg-white/50 backdrop-blur-md">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-xl font-semibold text-gray-800">Chat with {{ $owner->name }}</h2>
<a href="{{ route('renter.messages.index') }}" class="text-sm text-blue-600 hover:underline">← Back</a>
    </div>

    <div class="space-y-3 mb-4 max-h-[60vh] overflow-y-auto">
      @foreach($messages as $msg)
        @if($msg->user_id === auth()->id())
          <div class="flex justify-end">
            <div class="bubble bg-blue-500 text-white shadow-sm">{{ $msg->content }}</div>
          </div>
        @else
          <div class="flex justify-start">
            <div class="bubble bg-gray-200 text-gray-800">{{ $msg->content }}</div>
          </div>
        @endif
      @endforeach
    </div>

    <form method="POST" action="{{ route('renter.messages.send') }}" class="flex gap-3">
      @csrf
      <input type="hidden" name="property_id" value="{{ $property->id }}">
      <input type="hidden" name="receiver_id" value="{{ $owner->id }}">
      <input type="text" name="content" placeholder="Type your message..." class="flex-1 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:ring-blue-300">
      <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Send</button>
    </form>
  </div>
</body>
</html>
