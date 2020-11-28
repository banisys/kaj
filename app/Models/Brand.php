<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name', 'description', 'image', 'cat_id', 'name_f'];

    public function effects()
    {
        return $this->hasMany(Effect_price::class, 'brand_id');
    }

    public function effect_specs()
    {
        return $this->hasMany(Effect_spec::class, 'brand_id');
    }

//    public function cat()
//    {
//        return $this->belongsTo(Category::class);
//    }

    public function cats()
    {
        return $this->belongsToMany(Category::class,'brand_category','brand_id','cat_id');
    }


}


