<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    protected $fillable = [
        'name', 'cat_id','filter_cat_id'
    ];

    public function cat()
    {
        return $this->belongsTo(Category::class);
    }

    public function filter_cat()
    {
        return $this->belongsTo(Filter_cat::class);
    }

}
