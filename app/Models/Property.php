<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'title',
        'address',
        'description',
        'price',
        'status',
        'is_verified',
        'image_url',
    ];


    protected $casts = [
        'amenities' => 'array',
        'is_verified' => 'boolean',
    ];

   public function owner()
        {
            return $this->belongsTo(User::class, 'owner_id');
        }

        public function feedbacks()
        {
            return $this->hasMany(PropertyFeedback::class);
        }
        public function messages()
        {
            return $this->hasMany(Message::class);
        }

        public function inquiries()
        {
            return $this->hasMany(Inquiry::class);
        }
}
