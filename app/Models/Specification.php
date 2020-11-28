<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    protected $fillable = [
        'name', 'cat_id','catspec_id',
    ];

    public function cat()
    {
        return $this->belongsTo(Category::class);
    }

    public function catspec()
    {
        return $this->belongsTo(Catspec::class);
    }

}
