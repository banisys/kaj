<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'name', 'postal_code', 'city', 'cell', 'state',
        'address', 'tell', 'lat', 'lon', 'distance', 'sum_final',
        'delivery_time', 'delivery_date', 'user_id', 'shamsi_c',
        'shamsi_u', 'status', 'off_code', 'confirm', 'authority', 'refid'
    ];

    public function order_values()
    {
        return $this->hasMany(Order_value::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
