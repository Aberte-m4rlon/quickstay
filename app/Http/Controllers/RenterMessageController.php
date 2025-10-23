<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Property;
use App\Models\User;

class RenterMessageController extends Controller
{
    /**
     * 📨 Show list of owners that the renter has chatted with.
     */
    public function index()
    {
        $renterId = auth()->id();

        // Get unique owners that this renter has chatted with
        $owners = User::where('role', 'owner')
            ->where(function ($query) use ($renterId) {
                $query->whereHas('messagesSent', function ($q) use ($renterId) {
                    $q->where('receiver_id', $renterId);
                })
                ->orWhereHas('messagesReceived', function ($q) use ($renterId) {
                    $q->where('user_id', $renterId);
                });
            })
            ->distinct()
            ->get();

        return view('renter.messages.index', compact('owners'));
    }

    /**
     * 💬 Open chat page for a specific property.
     */
   // RenterMessageController@chat
public function chat(Property $property)
{
    // Get property owner
    $owner = $property->owner;

    // Fetch messages between renter (auth user) and property owner
    $messages = Message::where(function($q) use ($owner) {
        $q->where('user_id', auth()->id())
          ->where('receiver_id', $owner->id);
    })->orWhere(function($q) use ($owner) {
        $q->where('user_id', $owner->id)
          ->where('receiver_id', auth()->id());
    })->orderBy('created_at')->get();

    return view('renter.messages.chat', compact('property', 'owner', 'messages'));
}

    /**
     * 📨 Handle sending a new message.
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'content' => 'required|string|max:1000',
        ]);

        Message::create([
            'user_id' => auth()->id(),
            'receiver_id' => $validated['receiver_id'],
            'property_id' => $validated['property_id'],
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Message sent successfully.');
    }
}
