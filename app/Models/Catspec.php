<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catspec extends Model
{
    protected $fillable = [
        'name', 'cat_id',
    ];

    public function cat()
    {
        return $this->belongsTo(Category::class);
    }

    public function specifications()
    {
        return $this->hasMany(Specification::class,'catspec_id');
    }
}
