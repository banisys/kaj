<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hekmatinasser\Verta\Facades\Verta;

class InventoryTransaction extends Model
{
    protected $fillable = [
        'product_code', 'user_id', 'inventory', 'old_balance', 'balance', 'info'
    ];
    
    protected $casts = [
        'inventory' => 'array',
         'info' => 'array',
    ];

    protected $table = 'inventory_transactions';
    
    public function getCreatedAtAttribute()
    {
        $value = $this->attributes['created_at'];
        $output = isset($value) ?
            Verta::instance($value)->format('Y/m/d H:i') : null;
            
        return $output;
    }
    
    public function getUpdatedAtAttribute()
    {
        $value = $this->attributes['updated_at'];
        $output = isset($value) ?
            Verta::instance($value)->format('Y/m/d H:i') : null;
            
        return $output;
    }
}
