<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Effect_spec extends Model
{
    protected $fillable = [
        'name', 'cat_id', 'brand_id','effect_price_id',
    ];

    public function cat()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function effect_price()
    {
        return $this->belongsTo(Effect_price::class);
    }

    public function effect_values()
    {
        return $this->hasMany(Effect_value::class, 'effect_spec_id');
    }

}
