<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_value extends Model
{
    protected $fillable = [
        'key', 'value', 'product_id', 'order_id',
        'number','cart_id','price','total','color_id',
        'off_percent','product_code','color_name',
        'product_name','discount',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
