<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',   // optional, if related to a property
        'user_id',       // sender (the one who sent the message)
        'receiver_id',   // receiver (who gets the message)
        'content',       // message body
        'is_read',       // boolean read status
    ];

    /**
     * 🔹 The user who sent the message.
     */
 // The sender of the message
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function property() {
        return $this->belongsTo(Property::class);
    }
}
