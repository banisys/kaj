<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Cart_value;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Effect_price;
use App\Models\Effect_value;
use App\Models\Filter_cat;
use App\Models\Product;
use App\Models\Spec_value;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FilterController extends Controller
{
    public function fetchFilters($cat)
    {
        $cat_id = Category::where('name', $cat)->pluck('id')->first();

        $filter = Filter_cat::where('cat_id', $cat_id)->with('filters')->get();

        return response()->json($filter);
    }

}
