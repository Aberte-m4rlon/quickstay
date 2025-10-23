@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">Conversation about {{ $property->title }}</h1>

    {{-- Chat container --}}
    <div id="chat-box" class="bg-gray-50 p-6 rounded-xl shadow-lg h-[400px] overflow-y-auto flex flex-col gap-4">
        @foreach($property->messages ?? [] as $msg)
            @if($msg->user_id == auth()->id())
                <div class="self-end bg-blue-600 text-white px-4 py-2 rounded-2xl max-w-xs break-words">
                    {{ $msg->content }}
                </div>
            @elseif(is_null($msg->user_id))
                <div class="self-start bg-gray-200 text-gray-800 px-4 py-2 rounded-2xl max-w-xs break-words">
                    {{ $msg->content }}
                </div>
            @endif
        @endforeach
    </div>

    {{-- Message input --}}
    <form id="chat-form" class="mt-4 flex gap-2">
        @csrf
        <input type="text" name="content" id="message-input" placeholder="Type your message..."
               class="flex-1 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Send</button>
    </form>
</div>

{{-- AJAX / JS --}}
<script>
    const chatBox = document.getElementById('chat-box');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');

    // Scroll to bottom initially
    chatBox.scrollTop = chatBox.scrollHeight;

    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const msg = messageInput.value.trim();
        if (!msg) return;

        // Disable input while AI is replying
        messageInput.disabled = true;

        // Append user message immediately
        const userDiv = document.createElement('div');
        userDiv.className = 'self-end bg-blue-600 text-white px-4 py-2 rounded-2xl max-w-xs break-words';
        userDiv.innerText = msg;
        chatBox.appendChild(userDiv);
        chatBox.scrollTop = chatBox.scrollHeight;

        messageInput.value = '';

        // Send message to Laravel (AJAX)
        const token = document.querySelector('input[name="_token"]').value;
        const response = await fetch("{{ route('messages.store', $property) }}", {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': token 
            },
            body: JSON.stringify({ content: msg })
        });

        const data = await response.json();

        // Append AI reply
        const aiDiv = document.createElement('div');
        aiDiv.className = 'self-start bg-gray-200 text-gray-800 px-4 py-2 rounded-2xl max-w-xs break-words';
        aiDiv.innerText = data.reply;
        chatBox.appendChild(aiDiv);
        chatBox.scrollTop = chatBox.scrollHeight;

        messageInput.disabled = false;
        messageInput.focus();
    });
</script>
@endsection
