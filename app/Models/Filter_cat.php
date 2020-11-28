<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filter_cat extends Model
{
    protected $fillable = [
        'name', 'cat_id',
    ];

    public function cat()
    {
        return $this->belongsTo(Category::class);
    }

    public function filters()
    {
        return $this->hasMany(Filter::class, 'filter_cat_id');
    }
}
