<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Index extends Model
{
    protected $table = 'indices';

    protected $fillable = ['index', 'image', 'url','product_id'];
}
