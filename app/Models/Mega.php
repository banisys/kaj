<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mega extends Model
{
    protected $fillable = [
        'name', 'title','priority','type','mega_cat_id',
    ];

    public function mega_cat()
    {
        return $this->belongsTo(Mega_cat::class);
    }
}
