<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_verified',
        'phone',
        'valid_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /* --------------------------------------------
    | 🔹 RELATIONSHIPS
    |---------------------------------------------*/

    // ✅ Properties owned by this user (if owner)
    public function properties()
    {
        return $this->hasMany(Property::class, 'owner_id');
    }

    // ✅ Reviews written by this user
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // ✅ Inquiries made by this user
    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    // ✅ Feedbacks submitted by this user
    public function feedbacks()
    {
        return $this->hasMany(PropertyFeedback::class);
    }

    /* --------------------------------------------
    | 💬 MESSAGING RELATIONSHIPS
    |---------------------------------------------*/

    // ✅ Messages this user has SENT
    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    // ✅ Messages this user has RECEIVED
    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // ✅ Optional helper — all messages (sent + received)
    public function allMessages()
    {
        return $this->messagesSent->merge($this->messagesReceived);
    }
}
