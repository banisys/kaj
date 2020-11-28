<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Effect_value extends Model
{
    protected $fillable = [
        'key', 'value','product_id','effect_price_id','effect_spec_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function effect_price()
    {
        return $this->belongsTo(Effect_price::class);
    }

    public function cart_value()
    {
        return $this->belongsTo(Cart_value::class);
    }
}
