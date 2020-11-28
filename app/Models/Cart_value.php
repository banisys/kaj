<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart_value extends Model
{
    protected $fillable = ['key', 'value', 'cart_id','product_id'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function effect_value()
    {
        return $this->hasOne(Effect_value::class,'id','value');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
