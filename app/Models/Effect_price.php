<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Effect_price extends Model
{
    protected $fillable = [
        'name', 'cat_id', 'brand_id',
    ];

    public function cat()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function effect_specs()
    {
        return $this->hasMany(Effect_spec::class, 'effect_price_id');
    }

    public function effect_values()
    {
        return $this->hasMany(Effect_value::class, 'effect_price_id');
    }

}
