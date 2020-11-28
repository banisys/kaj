<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class,'admin_role');
    }

    public function hasRole($role)
    {
        if(is_string($role)) {
            return $this->roles->contains('name' , $role);
        }

        return !! $role->intersect($this->roles)->count();
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'admin_id');
    }

    public function tickets2()
    {
        return $this->hasMany(Ticket::class, 'for');
    }
}