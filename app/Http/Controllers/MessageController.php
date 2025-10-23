<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    // Show all conversations (inbox)
    public function index()
{
    $ownerId = auth()->id();

    // Fetch all messages where the owner is either sender or receiver
    $messages = \App\Models\Message::where(function($q) use ($ownerId) {
        $q->where('user_id', $ownerId)
          ->orWhere('receiver_id', $ownerId);
    })->orderBy('created_at', 'asc')->get();

    // Pass messages to the Blade view
    return view('owner.messages.index', compact('messages'));
}


    // Show private chat with a specific owner
    public function chat($ownerId)
    {
        $user = auth()->user();

        $messages = Message::where(function ($q) use ($user, $ownerId) {
                $q->where('user_id', $user->id)
                  ->whereHas('property', function ($sub) use ($ownerId) {
                      $sub->where('owner_id', $ownerId);
                  });
            })
            ->orWhere(function ($q) use ($ownerId, $user) {
                $q->whereHas('property', function ($sub) use ($user, $ownerId) {
                    $sub->where('owner_id', $ownerId)
                        ->where('renter_id', $user->id);
                });
            })
            ->with('user:id,name')
            ->orderBy('created_at', 'asc')
            ->get();

        $owner = User::findOrFail($ownerId);

        return view('renter.messages.chat', compact('messages', 'owner'));
    }

    // Store message in a chat
    public function store(Request $request, $ownerId)
    {
        $request->validate(['content' => 'required|string|max:1000']);

        $user = auth()->user();

        // Find property connecting renter and owner
        $property = Property::where('owner_id', $ownerId)
            ->where('renter_id', $user->id)
            ->firstOrFail();

        Message::create([
            'user_id' => $user->id,
            'property_id' => $property->id,
            'content' => $request->content,
        ]);

        return back();
    }
        // app/Http/Controllers/MessageController.php

public function sendOwnerMessage(Request $request)
{
    $request->validate([
        'receiver_id' => 'required|exists:users,id',
        'property_id' => 'nullable|exists:properties,id',
        'content' => 'required|string|max:1000',
    ]);

    $message = new \App\Models\Message();
    $message->user_id = auth()->id();          // Owner sending
    $message->receiver_id = $request->receiver_id; // Renter receiving
    $message->property_id = $request->property_id;
    $message->content = $request->content;
    $message->save();

    return redirect()->back(); // Refresh page to see message
}

}
