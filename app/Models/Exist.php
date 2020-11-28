<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exist extends Model
{
    protected $fillable = [
        'product_id', 'effect_price_id', 'effect_spec_id', 'color_id', 'num','product_code'
    ];

    protected $eagerload = ["effect_price", "effect_spec", "color", "product"];
    
    public function effect_price()
    {
        return $this->belongsTo(Effect_price::class);
    }

    public function effect_spec()
    {
        return $this->belongsTo(Effect_spec::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
