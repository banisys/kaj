<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Off extends Model
{
    protected $fillable = ['name', 'code', 'category', 'brand', 'expir', 'percent', 'min', 'e_date'];
    public $timestamps = true;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
