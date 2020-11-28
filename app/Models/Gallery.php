<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'image', 'product_id','color_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
