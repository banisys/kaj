<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'name', 'description', 'cat_id', 'image', 'shamsi_c', 'shamsi_u', 'admin_id', 'url', 'seo_title', 'seo_key',
        'seo_description', 'titles',
    ];

    public function cat()
    {
        return $this->belongsTo(Category::class);
    }
}
