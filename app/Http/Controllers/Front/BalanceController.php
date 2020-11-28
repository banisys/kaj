<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Effect_spec;
use App\Models\Effect_value;
use App\Models\Exist;
use App\Models\Favourite;
use App\Models\Filter;
use App\Models\Mega;
use App\Models\Mega_cat;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Spec_value;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    public $result = array();

    public function fetchProducts()
    {
        $products = Product::where('status', 1)->orderBy('created_at', 'DESC')->paginate(9);

        return response()->json($products);
    }

    public function fetchProductsCat($name)
    {
        $cat_id = Category::where('name', $name)->pluck('id')->first();
        $products = Product::where('status', 1)->where('cat_id', $cat_id)->orderBy('created_at', 'DESC')->paginate(9);

        return response()->json($products);
    }

    public function searchByKey(Request $request)
    {
//        $cat_id = Category::where('name', $request->cat)->pluck('id')->first();
//
//        if (sizeof($request->key)) {
//
//            if (sizeof($request->brand)) {
//                $brand = str_replace("_", " ", $request->brand);
//                $specValues = array();
//                foreach ($request->key as $item) {
//                    $x = explode(":", $item);
//                    $filterName = Filter::where('id', $x[1])->pluck('name')->first();
//                    $holders = Spec_value::where('key', 'like', '%' . $x[0] . '%')
//                        ->where('value', 'like', '%' . $filterName . '%')->get();
//                    foreach ($holders as $holder) {
//                        array_push($specValues, $holder->product_id);
//                    }
//                }
//                $products = Product::where('status', 1)->whereIn('id', $specValues)->orWhereIn('brand', $brand)
//                    ->where('cat_id', $cat_id)->orderBy('created_at', 'DESC')->paginate(9);
//            } else {
//                $specValues = array();
//                foreach ($request->key as $item) {
//                    $x = explode(":", $item);
//                    $filterName = Filter::where('id', $x[1])->pluck('name')->first();
//                    $holders = Spec_value::where('key', 'like', '%' . $x[0] . '%')
//                        ->where('value', $filterName)->get();
//                    foreach ($holders as $holder) {
//                        array_push($specValues, $holder->product_id);
//                    }
//                }
//                $products = Product::where('status', 1)->whereIn('id', $specValues)
//                    ->where('cat_id', $cat_id)
//                    ->orderBy('created_at', 'DESC')->paginate(9);
//            }
//
//        } elseif (sizeof($request->brand)) {
//            $brand = str_replace("_", " ", $request->brand);
//            $products = Product::where('status', 1)->where('cat_id', $cat_id)->whereIn('brand', $brand)
//                ->orderBy('created_at', 'DESC')->paginate(9);
//        } else {
//            $products = Product::where('status', 1)->where('cat_id', $cat_id)->orderBy('created_at', 'DESC')->paginate(9);
//        }
        if (empty($request['brand_ids'])) {
            $cat_id = Category::where('name', $request->cat)->pluck('id')->first();
            $products = Product::where('status', 1)->where('cat_id', $cat_id)->orderBy('created_at', 'DESC')->paginate(9);

        } else {
            $products = Product::where('status', 1)->whereIn('brand_id', $request['brand_ids'])->orderBy('created_at', 'DESC')->paginate(9);
        }


        return response()->json($products);
    }

    public function fetchBrandsCat($name)
    {
        $cat = Category::where('name', $name)->first();

        return response()->json($cat->brands);
    }

    public function fetchBrands()
    {
        $brands = Brand::get();
        $unique = $brands->unique('name');
        $x = $unique->values()->all();

        return response()->json($x);
    }

    public function fetchBrandsRelated($cat)
    {

        $categories = Category::where('name', $cat)->with('childrenRecursive')->take('name')->first();

        self::child($categories);


        $pivots = DB::table('brand_category')->whereIn('cat_id', $this->result)->get(['brand_id']);
        $brandIds = array();
        foreach ($pivots as $pivot) {
            array_push($brandIds, $pivot->brand_id);
        }

        $brands = Brand::whereIn('id', $brandIds)->get();
        $unique = $brands->unique('name');
        $x = $unique->values()->all();

        return response()->json($x);
    }

    public function child($categories)
    {
        foreach ($categories->childrenRecursive as $item) {
            self::child($item);
            array_push($this->result, $item->id);
        }
    }

    public function fetchProductsParentCat($cat)
    {
        $categories = Category::where('name', $cat)->with('childrenRecursive')->take('name')->first();
        self::child($categories);

        $products = Product::where('status', 1)->whereIn('cat_id', $this->result)->orderBy('created_at', 'DESC')->paginate(12);


        return response()->json($products);
    }

    public function searchByBrandCat(Request $request)
    {
        $cat_id = Category::where('name', $request->cat)->pluck('id')->first();
        if (sizeof($request->brand)) {
            $brand = str_replace("_", " ", $request->brand);
            $products = Product::where('status', 1)->where('cat_id', $cat_id)->orWhereIn('brand', $brand)
                ->orderBy('created_at', 'DESC')->paginate(9);
        } else {

            $categories = Category::where('name', $request->cat)->with('childrenRecursive')->take('name')->first();
            self::child($categories);
            $products = Product::where('status', 1)->whereIn('cat_id', $this->result)->orderBy('created_at', 'DESC')->paginate(9);
        }
        return response()->json($products);
    }

    public function searchByBrand(Request $request)
    {

        if (sizeof($request->brand)) {
            $brand = str_replace("_", " ", $request->brand);
            $products = Product::where('status', 1)->whereIn('brand', $brand)
                ->orderBy('created_at', 'DESC')->paginate(9);
        } else {
            $products = Product::where('status', 1)->orderBy('created_at', 'DESC')->paginate(9);
        }
        return response()->json($products);
    }

    public function autoSearch($type, $name)
    {
        $product = Product::where('name', $name)->first();
        if ($type == 'cat') {
            $index = new IndexController();
            return $index->searchByCat($name);
        }
        if ($type == 'brand') {
            return redirect(url('/brands/' . $name));
        }
        if ($type == 'product') {
            return redirect(url('/detail/' . $product->slug));
        }

    }

    public function brands()
    {
        return view('front.balance.search_brand');
    }

    public function fetchProductsBrand($brandName)
    {
        $products = Product::where('status', 1)->where('brand', $brandName)->orderBy('created_at', 'DESC')->paginate(9);

        return response()->json($products);
    }

    public function fetchCatsBrand($brandName)
    {
        $brand = Brand::where('name', $brandName)->first();


        return response()->json(['cats' => $brand->cats, 'image' => $brand->image]);
    }

    public function addFav($id)
    {
        $user_id = auth('web')->user()->id;
        $fav = Favourite::where('product_id', $id)->where('user_id', $user_id)->first();
        if (isset($fav->user_id)) {
            return response()->json(['key' => 'value'], 200);
        } else {
            Favourite::create([
                'user_id' => $user_id,
                'product_id' => $id,
            ]);
            return response()->json(['key' => 'value'], 200);
        }
    }

    public function favourites()
    {
        return view('front.online.fav');
    }

    public function fetchFavs()
    {
        $user_id = auth('web')->user()->id;
        $favs = Favourite::where('user_id', $user_id)->with('product')->orderBy('created_at', 'DESC')->paginate(9);

        return response()->json($favs);
    }

    public function deleteFav($id)
    {
        Favourite::find($id)->delete();

        return response()->json(['key' => 'value'], 200);
    }

    public function related($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $related = Product::where('cat_id', $product->cat_id)->whereNotIn('id', [$product->id])->take(8)->get();

        return response()->json($related);
    }

    public function fetchOffers()
    {
        $output = array();
        if (isset($_COOKIE['offer'])) {
            $offers = Offer::where('cookie', $_COOKIE['offer'])->orderBy('created_at', 'desc')->get();
            $products = array();
            foreach ($offers as $offer) {
                $total = Product::where('cat_id', $offer->cat_id)->where('brand', $offer->brand)->get();
                foreach ($total as $item) {
                    array_push($products, $item);
                }
            }
            $products = array_unique($products);
            $output = array_slice($products, 0, 7);
        }


        return response()->json($output);
    }

    public function searchByBrandFilter(Request $request)
    {
        if (sizeof($request->cat)) {
            $cat_ids = array();
            foreach ($request->cat as $item) {
                $cat = str_replace("_", " ", $item);
                $x = Category::where('name', $cat)->pluck('id')->first();
                array_push($cat_ids, $x);
            }

            $products = Product::where('brand', $request->brand)->whereIn('cat_id', $cat_ids)
                ->orderBy('created_at', 'DESC')->paginate(9);
        } else {
            $products = Product::where('brand', $request->brand)->orderBy('created_at', 'DESC')->paginate(9);
        }

        return response()->json($products);
    }

    public function fetchMegaCat()
    {
        $megaCats = Mega_cat::get();

        return response()->json($megaCats);
    }

    public function fetchMegas()
    {
        $megas = Mega::get();
        $res = $megas->groupBy('mega_cat_id');

        return response()->json($res);
    }

    public function checkColorExist($slug, Request $request)
    {
        $product_id = Product::where('slug', $slug)->pluck('id')->first();

        $effectPriceId = Effect_value::where('product_id', $product_id)->where('key', $request['effect'])
            ->pluck('effect_price_id')->first();



        $effectSpecId = Effect_spec::where('name', $request['effect'])->where('effect_price_id', $effectPriceId)
            ->pluck('id')->first();

        $existColorId = Exist::where('product_id', $product_id)->where('effect_spec_id', $effectSpecId)->get('color_id');

        return response()->json($existColorId);
    }

    public function checkEffectExist($slug, Request $request)
    {
        $product_id = Product::where('slug', $slug)->pluck('id')->first();
        $effectSpecId = Exist::where('product_id', $product_id)->where('color_id', $request['color'])->get('effect_spec_id');

        return response()->json($effectSpecId);
    }

    public function checkProductExist($slug, Request $request)
    {
        $colorId = str_replace("color", "", $request['color']);
        $product_id = Product::where('slug', $slug)->pluck('id')->first();
        $exist = Exist::where('product_id', $product_id)->where('effect_spec_id', $request['effect'])
            ->where('color_id', $colorId)->first();

        if (isset($exist->id)) {
            $result = true;
        } else {
            $result = false;
        }
        return response()->json($result);
    }

    public function checkProductExistIfEffectNotSet($slug, Request $request)
    {
        $colorId = str_replace("color", "", $request['color']);
        $product_id = Product::where('slug', $slug)->pluck('id')->first();
        $exist = Exist::where('product_id', $product_id)->where('color_id', $colorId)->first();

        if (isset($exist->id)) {
            $result = true;
        } else {
            $result = false;
        }
        return response()->json($result);
    }

    public function checkProductExistIfColorNotSet($slug, Request $request)
    {
        $product_id = Product::where('slug', $slug)->pluck('id')->first();
        $exist = Exist::where('product_id', $product_id)->where('effect_spec_id', $request['effect'])->first();

        if (isset($exist->id)) {
            $result = true;
        } else {
            $result = false;
        }
        return response()->json($result);
    }

    public function checkProductExistIfNothingSet($slug, Request $request)
    {
        $product_id = Product::where('slug', $slug)->pluck('id')->first();
        $exist = Exist::where('product_id', $product_id)
            ->where('color_id', 0)
            ->where('effect_spec_id', 0)->first();

        if (isset($exist->id)) {
            $result = true;
        } else {
            $result = false;
        }
        return response()->json($result);
    }

    public function filterConvert(Request $request)
    {
        $pieces = explode(":", $request->filter);
        $catId = Category::where('name', $request->cat)->pluck('id')->first();
        $filterId = Filter::where('name', $pieces[1])->where('cat_id', $catId)->pluck('id')->first();

        $convert = $pieces[0] . ':' . $filterId;

        return response()->json($convert);
    }

}




