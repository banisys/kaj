<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'image', 'parent', 'type'];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'cat_id');
    }

    public function catspecs()
    {
        return $this->hasMany(Catspec::class, 'cat_id');
    }

    public function specifications()
    {
        return $this->hasMany(Specification::class, 'cat_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'cat_id');
    }

    public function effects()
    {
        return $this->hasMany(Effect_price::class, 'cat_id');
    }

    public function effect_specs()
    {
        return $this->hasMany(Effect_spec::class, 'cat_id');
    }

//    public function brands()
//    {
//        return $this->hasMany(Brand::class, 'cat_id');
//    }

    public function child()
    {
        return $this->hasMany(Category::class, 'parent');
    }

    public function childrenRecursive()
    {
        return $this->child()->with('childrenRecursive');
    }

    public function filter_cats()
    {
        return $this->hasMany(Filter_cat::class, 'cat_id');
    }

    public function filters()
    {
        return $this->hasMany(Filter::class, 'cat_id');
    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'cat_id');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class,'brand_category','cat_id');
    }

}
