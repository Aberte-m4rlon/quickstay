<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class OwnerMessageController extends Controller
{
    public function index()
    {
        $ownerId = auth()->id();

        // Get all messages where owner is sender or receiver
        $messages = Message::where(function($q) use ($ownerId) {
            $q->where('user_id', $ownerId)
              ->orWhere('receiver_id', $ownerId);
        })->orderBy('created_at', 'asc')->get();

        // Extract unique renter IDs
        $renterIds = $messages->map(function($msg) use ($ownerId) {
            return $msg->user_id == $ownerId ? $msg->receiver_id : $msg->user_id;
        })->unique()->values();

        return view('owner.messages.index', compact('messages', 'renterIds', 'ownerId'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'property_id' => 'nullable|exists:properties,id',
            'content' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'user_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'property_id' => $request->property_id,
            'content' => $request->content,
            'is_read' => 0,
        ]);

        return redirect()->back();
    }
}
