<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['product_id', 'cookie', 'color_id','number','price','total'];

    public function cart_values()
    {
        return $this->hasMany(Cart_value::class, 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function order_values()
    {
        return $this->hasMany(Order_value::class, 'cart_id');
    }

}
