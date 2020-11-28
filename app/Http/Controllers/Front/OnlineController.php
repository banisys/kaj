<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Log;


class OnlineController extends Controller
{
    public function newProducts()
    {
        $products = Product::where('status', 1)->with('colors')
            ->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($products);
    }

    public function fetchRootCat()
    {
        $roots = Category::where('parent', null)->where('type', 'محصول')->with('childrenRecursive')->get();

        return response()->json($roots);
    }

}
