<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'title'
    ];

    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_role');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'permission_role');
    }
}
