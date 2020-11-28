<?php

namespace App\Services;

use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    public static function setInventoryTransaction($exists_model, $info, $amount = null)
    {
        if (isset($exists_model))
        {
           $user_id = optional(Auth::user())->id;
           
           $type = $info['type'] ?? null;
           
           $old_balance = $exists_model->num ;
           $new_balance = $old_balance ;
           
            switch ($type) 
            {
                case 'add':
                    $old_balance = 0;
                    break;
                case 'remove':
                   $new_balance = 0;
                    break;
                case 'change':
                    $new_balance += $amount;
                    break;
                case 'sell':
                    $new_balance -= $amount;
                    break;
                default:
                                
                    break;
                                
            }
           
            InventoryTransaction::create([
                'product_code' => $exists_model->product_code,
                'user_id' => $user_id,
                'inventory'=>[
                    'product_id'=>$exists_model->product_id,
                    'product_name'=>optional($exists_model->product)->name,
                    'product_price'=>optional($exists_model->product)->price,
                    'product_discount'=>optional($exists_model->product)->discount,
                    'effect_price_id'=>$exists_model->effect_price_id,
                    'effect_price_name'=>optional($exists_model->effect_price)->name,
                    'effect_spec_id'=>$exists_model->effect_spec_id,
                    'effect_spec_name'=>optional($exists_model->effect_spec)->name,
                    'color_id'=>$exists_model->color_id,
                    'color_name'=>optional($exists_model->color)->name,
                    'color_code'=>optional($exists_model->color)->code,
                    ],
                'old_balance' => $old_balance,
                'balance' => $new_balance,
                'info' => $info
            ]);
        }       
    }

}
