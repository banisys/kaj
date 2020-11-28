<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;


class KajController extends Controller
{
    public function fetchSuggests()
    {
        $suggests = Product::where('status', 1)->where('suggest', 1)->orderBy('created_at', 'desc')->get();

        return response()->json($suggests);
    }


}
