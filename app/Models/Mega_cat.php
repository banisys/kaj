<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mega_cat extends Model
{
    protected $fillable = [
        'name', 'image',
    ];

    public function megas()
    {
        return $this->hasMany(Mega::class, 'mega_cat_id');
    }
}
