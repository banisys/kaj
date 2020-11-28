<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spec_value extends Model
{
    protected $fillable = [
        'key', 'value','product_id','cat_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
