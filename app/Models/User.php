<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'postal_code',
        'city', 'mobile', 'state', 'address', 'tell',
        'shamsi_c', 'shamsi_u', 'image', 'holder', 'order_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function favourite()
    {
        return $this->hasMany(Favourite::class, 'user_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'from');
    }
}
