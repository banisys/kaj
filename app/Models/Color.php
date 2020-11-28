<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = [
        'name', 'product_id', 'code','price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order_values()
    {
        return $this->hasMany(Order_value::class, 'color_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'color_id');
    }

}
