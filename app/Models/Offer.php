<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['cat_id', 'product_id', 'brand', 'cookie'];
}
