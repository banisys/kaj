<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Cart_value;
use App\Models\Category;
use App\Models\Color;
use App\Models\Comment;
use App\Models\Effect_price;
use App\Models\Effect_spec;
use App\Models\Effect_value;
use App\Models\Exist;
use App\Models\Gallery;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Complaint;
use App\Models\Slider;
use App\Models\Spec_value;
use App\Models\User;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    public function index()
    {
        return view('front.kaj.index');
    }

    public function fetchProducts()
    {
        $products = Product::where('status', 1)->take(8)->get();

        return response()->json($products);
    }

    public function fetchCat($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $x = Category::where('id', $product->cat_id)->first();
        $y = array();
        array_push($y, $x);
        while (true) {
            $last = end($y);
            if ($last->parent == 0) {
                break;
            }
            $z = Category::where('id', $last->parent)->first();
            array_push($y, $z);
        }
        $result = array();

        foreach ($y as $item) {

            array_push($result, $item->name);
        }

        $cats = array_reverse($result);
        return response()->json($cats);

    }

    public function fetchCat2($slug)
    {
        $x = Category::where('name', $slug)->first();
        $y = array();
        array_push($y, $x);
        while (true) {
            $last = end($y);
            if ($last->parent == 0) {
                break;
            }
            $z = Category::where('id', $last->parent)->first();
            array_push($y, $z);
        }
        $result = array();

        foreach ($y as $item) {

            array_push($result, $item->name);
        }

        $cats = array_reverse($result);
        return response()->json($cats);

    }

    public function cart()
    {
        $carts = Cart::where('cookie', $_COOKIE['cart'])->with('product')->with('color')
            ->with('cart_values.effect_value')->get();

        if (!$carts->first()) {
            return redirect(url('/'));
        }

        foreach ($carts as $key => $cart) {

            if (isset($cart->cart_values[0]->effect_value) && $cart->color_id != 0) {

                $exist = Exist::where('product_id', $cart->product_id)
                    ->where('effect_spec_id', $cart->cart_values[0]->effect_value->effect_spec_id)
                    ->where('color_id', $cart->color_id)->pluck('num')->first();

            } else if (!isset($cart->cart_values[0]->effect_value)) {
                $exist = Exist::where('product_id', $cart->product_id)
                    ->where('color_id', $cart->color_id)->pluck('num')->first();

            } else if ($cart->color_id == 0) {
                $exist = Exist::where('product_id', $cart->product_id)
                    ->where('effect_spec_id', $cart->cart_values[0]->effect_value->effect_spec_id)
                    ->pluck('num')->first();
            }

            if (!isset($exist)) {
                $cart->delete();
            }

            // if ($cart->number > $exist) {
            //     $cart->number = $exist;
            //     $cart->save();
            // }
        }

        return view('front.cart');
    }

    public function detail($slug, $color = 0)
    {
        $price = Color::where('id', $color)->pluck('price')->first();

        return view('front.kaj.detail', compact(['slug', 'color', 'price']));
    }

    public function fetch($slug)
    {
        $product = Product::where('slug', $slug)->first();

        return response()->json($product);
    }

    public function fetchGalleries($slug)
    {
        $productId = Product::where('slug', $slug)->pluck('id')->first();
        $galleries = Gallery::where('product_id', $productId)->whereNull('color_id')->get();

        return response()->json($galleries);
    }

    public function fetchColorGalleries($slug, $color)
    {
        $productId = Product::where('slug', $slug)->pluck('id')->first();
        $galleries = Gallery::where('product_id', $productId)->where('color_id', $color)->get();

        return response()->json($galleries);
    }

    public function fetchCatspec($slug)
    {
        $cat_id = Product::where('slug', $slug)->pluck('cat_id')->first();

        $catspecs = Category::where('id', $cat_id)->with('catspecs.specifications')->first();

        return response()->json($catspecs);
    }

    public function fetchSpec($slug)
    {
        $product_id = Product::where('slug', $slug)->pluck('id')->first();
        $specifications = Spec_value::where('product_id', $product_id)->get();

        return response()->json($specifications);
    }

    public function fetchColor($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $colors = $product->colors;
        return response()->json($colors);
    }

    public function fetchEffect($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $effect = Effect_value::where('product_id', $product->id)->get();
        $effect = $effect->groupBy('effect_price_id');

        foreach ($effect as $key => $value) {

            $name = Effect_price::where('id', $key)->first();
            $effect[$name->name] = $effect[$key];
            unset($effect[$key]);

        }

        return response()->json($effect);
    }

    public function fetchEffectPrice($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $effect_price = Effect_value::where('product_id', $product->id)->get();
        $a = array();
        foreach ($effect_price as $x) {
            array_push($a, $x->effect_price->name);
        }

        $a = array_unique($a);

        $b = array();
        foreach ($a as $r) {
            $b[$r] = 0;
        }

        return response()->json($b);
    }

    public function storeCart(Request $request)
    {

        if ($request['effects'] == 'effect not set' && $request['color'] == 0) {
            return $this->storeCartWithoutNothing($request);
        }

        if ($request['effects'] == 'effect not set') {
            return $this->storeCartWithoutEffect($request);
        }

        if ($request['color'] == 0) {
            return $this->storeCartWithoutColor($request);
        }

        $product = Product::where('name', $request['product'])->first();
        $effectSpec = Effect_spec::find($request['effects']);
        $effectPrice = Effect_price::find($effectSpec->effect_price_id);
        $effectValueId = Effect_value::where('effect_spec_id', $request['effects'])->pluck('id')->first();
        $flag = 0;

        if (isset($_COOKIE['cart'])) {
            $x = Cart::where('cookie', $_COOKIE['cart'])
                ->where('color_id', $request['color'])->where('product_id', $product['id'])
                ->whereHas('cart_values', function ($query) use ($effectValueId) {
                    return $query->where('value', $effectValueId);
                })->first();

            if ($x == null) {
                $cart = Cart::create([
                    'product_id' => $product['id'],
                    'cookie' => $_COOKIE['cart'],
                    'color_id' => $request['color'],
                    'number' => 1,
                    'price' => $request['price'],
                    'total' => $request['cal_discount'],
                ]);

                Cart_value::create([
                    'key' => $effectPrice->name,
                    'value' => $effectValueId,
                    'cart_id' => $cart->id,
                    'product_id' => $product['id'],
                ]);

            } else {
                $exist = Cart_value::where('product_id', $product['id'])->where('key', $effectPrice->name)->where('value', $effectValueId)->first();
                if (!isset($exist)) {
                    $flag++;
                }
                if ($flag > 0) {
                    $cart = Cart::create([
                        'product_id' => $product['id'],
                        'cookie' => $_COOKIE['cart'],
                        'color_id' => $request['color'],
                        'number' => 1,
                        'price' => $request['price'],
                        'total' => $request['cal_discount'],
                    ]);

                    Cart_value::create([
                        'key' => $effectPrice->name,
                        'value' => $effectValueId,
                        'cart_id' => $cart->id,
                        'product_id' => $product['id'],
                    ]);

                } else {
                    $tt = $exist->cart->total / $exist->cart->number;
                    $exist->cart->number++;
                    $exist->cart->total = $exist->cart->total + $tt;
                    $exist->cart->save();
                }
            }
        } else {
            $cookie = microtime(true) . rand(1, 10000);
            setcookie('cart', $cookie, time() + 60 * 60 * 24 * 365, '/');
            $cart = Cart::create([
                'color_id' => $request['color'],
                'product_id' => $product['id'],
                'cookie' => $cookie,
                'number' => 1,
                'total' => $request['cal_discount'],
                'price' => $request['price'],
            ]);

            Cart_value::create([
                'key' => $effectPrice->name,
                'value' => $effectValueId,
                'cart_id' => $cart->id,
                'product_id' => $product['id'],
            ]);

            return response()->json(['key' => 'value'], 200);
        }

        return response()->json(['key' => 'value'], 200);
    }

    public function fetchCart()
    {
        $carts = array();
        if (isset($_COOKIE['cart'])) {
            $carts = Cart::where('cookie', $_COOKIE['cart'])->with('product')->with('color')
                ->with('cart_values.effect_value')->get();

            foreach ($carts as $key => $cart) {

                if (isset($cart->cart_values[0]->effect_value) && $cart->color_id != 0) {

                    $exist = Exist::where('product_id', $cart->product_id)
                        ->where('effect_spec_id', $cart->cart_values[0]->effect_value->effect_spec_id)
                        ->where('color_id', $cart->color_id)->pluck('num')->first();
                    $carts[$key]["number2"] = $exist;

                } else if (!isset($cart->cart_values[0]->effect_value)) {
                    $exist = Exist::where('product_id', $cart->product_id)
                        ->where('color_id', $cart->color_id)->pluck('num')->first();
                    $carts[$key]["number2"] = $exist;

                } else if ($cart->color_id == 0) {
                    $exist = Exist::where('product_id', $cart->product_id)
                        ->where('effect_spec_id', $cart->cart_values[0]->effect_value->effect_spec_id)
                        ->pluck('num')->first();
                    $carts[$key]["number2"] = $exist;
                }

                if ($cart->number > $exist) {
                    $cart->number = $exist;
                    $cart->save();
                }
            }
        }

        return response()->json($carts);
    }

    public function fetchResultPrice()
    {
        $cart = Cart::where('cookie', $_COOKIE['cart'])->with('product')->with('cart_values.effect_value')->get();

        return response()->json($cart);
    }

    public function cartTotal(Request $request)
    {
        $cart = Cart::where('id', $request['cart'])->with('cart_values')->first();

        if (!isset($cart->cart_values[0]->id) && $cart->color_id == 0) {

            $exist = Exist::where('product_id', $cart->product_id)
                ->where('color_id', 0)->first();

            if (!isset($exist->id)) {
                $cart->delete();
            } else {
                $per = $request['price'] / 100;
                $diff = 100 - $request['discount'];
                $result = $diff * $per;
                $total = $request['number'] * $result;
                $cart->number = $request['number'];
                $cart->total = $total;
                $cart->save();
            }
        } elseif (isset($cart->cart_values[0]->id) && $cart->color_id != 0) {

            $effectValue = Effect_value::where('id', $cart->cart_values[0]->value)->first();

            $exist = Exist::where('product_id', $cart->product_id)
                ->where('effect_spec_id', $effectValue->effect_spec_id)
                ->where('color_id', $cart->color_id)->first();

            if (!isset($exist->id)) {
                $cart->delete();
            } else {
                $per = $request['price'] / 100;
                $diff = 100 - $request['discount'];
                $result = $diff * $per;
                $total = $request['number'] * $result;
                $cart->number = $request['number'];
                $cart->total = $total;
                $cart->save();
            }
        } elseif (!isset($cart->cart_values[0]->id) && $cart->color_id != 0) {
            $exist = Exist::where('product_id', $cart->product_id)
                ->where('color_id', $cart->color_id)->first();

            if (!isset($exist->id)) {
                $cart->delete();
            } else {
                $per = $request['price'] / 100;
                $diff = 100 - $request['discount'];
                $result = $diff * $per;
                $total = $request['number'] * $result;
                $cart->number = $request['number'];
                $cart->total = $total;
                $cart->save();
            }
        } elseif (isset($cart->cart_values[0]->id) && $cart->color_id == 0) {
            $effectValue = Effect_value::where('id', $cart->cart_values[0]->value)->first();

            $exist = Exist::where('product_id', $cart->product_id)
                ->where('effect_spec_id', $effectValue->effect_spec_id)
                ->where('color_id', 0)->first();

            if (!isset($exist->id)) {
                $cart->delete();
            } else {
                $per = $request['price'] / 100;
                $diff = 100 - $request['discount'];
                $result = $diff * $per;
                $total = $request['number'] * $result;
                $cart->number = $request['number'];
                $cart->total = $total;
                $cart->save();
            }
        }


        return response()->json();
    }

    public function sumTotal()
    {
        $carts = Cart::where('cookie', $_COOKIE['cart'])->get();

        $sum = 0;
        foreach ($carts as $cart) {
            $sum = $cart->total + $sum;
        }

        return response()->json($sum);
    }

    public function sumPrice()
    {
        $carts = Cart::where('cookie', $_COOKIE['cart'])->get();

        $sum = 0;
        foreach ($carts as $cart) {
            $price = $cart->number * $cart->price;
            $sum = $price + $sum;
        }

        return response()->json($sum);
    }

    public function deleteCart($id)
    {
        $cart = Cart::where('id', $id)->first();

        $cart->cart_values()->delete();
        $cart->delete();

        return response()->json(['key' => 'value'], 200);
    }

    public function fetchValue($slug)
    {
        $pro = Product::where('slug', $slug)->pluck('id')->first();
        $values = Spec_value::where('product_id', $pro)->get();
        return response()->json($values);
    }

    public function storeComment(Request $request)
    {
        $user = Auth::user();
        $comment = Comment::create([
            'body' => $request['body'],
            'user_id' => $user->id,
            'product_id' => $request['id'],
        ]);
        $comment->shamsi_c = Verta::instance($comment->created_at)->format('Y/n/j');
        $comment->save();

        return response()->json(['key' => 'value'], 200);
    }

    public function storeReplyComment(Request $request)
    {
        $product_id = Product::where('slug', $request['slug'])->pluck('id')->first();

        $user = Auth::user();

        $comment = Comment::create([
            'body' => $request['reply'],
            'user_id' => $user->id,
            'product_id' => $product_id,
            'parent' => $request['parent'],
        ]);

        $comment->shamsi_c = Verta::instance($comment->created_at)->format('Y/n/j');

        $comment->save();

        return response()->json(['key' => 'value'], 200);
    }

    public function fetchParentComment($slug)
    {
        $product_id = Product::where('slug', $slug)->pluck('id')->first();
        $comments = Comment::where('product_id', $product_id)->whereNull('parent')
            ->with('replies.user')->with('user')->orderBy('created_at', 'DESC')->get();

        return response()->json($comments);
    }

    public function autocompleteSearch(Request $request)
    {
        $product = Product::where('name', 'like', '%' . $request['searchquery'] . '%')->take(5)->get();
        $category = Category::where('name', 'like', '%' . $request['searchquery'] . '%')->take(5)->get();
        $brand = Brand::where('name', 'like', '%' . $request['searchquery'] . '%')
            ->orWhere('name_f', 'like', '%' . $request['searchquery'] . '%')->take(5)->get();

        return response()->json(['product' => $product, 'category' => $category, 'brand' => $brand->unique('name')]);
    }

    public function search($cat, $name)
    {
        if ($cat == 'دسته ها') {
            $name = json_encode($name);

            return view('front.search_key', compact('name'));
        } else {
            $cat = json_encode($cat);
            $name = json_encode($name);
            return view('front.search', compact('cat', 'name'));
        }
    }

    public function fetchSearchProduct(Request $request)
    {
        if ($request['cat'] == 'محصول') {
            $products = Product::where('name', $request['name'])->with('cat')->get();
        } else {
            $products = Product::where('brand', $request['name'])->with('cat')->get();
        }

        return response()->json($products);
    }

    public function fetchSearchProductCat(Request $request)
    {
        $cat_id = Category::where('name', $request['name'])->pluck('id')->first();

        $products = Product::where('cat_id', $cat_id)->with('cat')->get();

        return response()->json($products);
    }

    public function fetchSearchCat()
    {
        $categories = Category::with('childrenRecursive')->where('type', 'محصول')->whereNull('parent')->get();

        return response()->json($categories);
    }

    public function searchByCat($cat)
    {

        $x = Category::where('name', $cat)->first();
        $y = Category::where('parent', $x->id)->first();

        if (isset($y['name'])) {
            $name = json_encode($cat);
            return view('front.balance.search', compact('name'));
        }

        $name = json_encode($cat);
        return view('front.balance.search_key', compact('name'));
    }

    public function fetchEffectPriceDetail($slug)
    {
        $product = Product::where('slug', $slug)->first();

        $effectPrice = Effect_price::where('cat_id', $product->cat_id)
            ->where('brand_id', $product->brand_id)->pluck('name')->first();

        return response()->json($effectPrice);
    }

    public function fetchEffectSpecDetail($slug)
    {
        $product = Product::where('slug', $slug)->first();

        $effectSpec = Effect_spec::where('cat_id', $product->cat_id)
            ->where('brand_id', $product->brand_id)
            ->with('effect_values')->get();

        return response()->json($effectSpec);
    }

    public function fetchSlider()
    {
        $slider = Slider::orderBy('created_at', 'desc')->get();

        return response()->json($slider);
    }

    public function storeCartWithoutEffect($request)
    {
        $product = Product::where('name', $request['product'])->first();

        $flag = 0;
        if (isset($_COOKIE['cart'])) {
            $x = Cart::where('cookie', $_COOKIE['cart'])
                ->where('color_id', $request['color'])->where('product_id', $product['id'])->first();

            if ($x == null) {
                $cart = Cart::create([
                    'product_id' => $product['id'],
                    'cookie' => $_COOKIE['cart'],
                    'color_id' => $request['color'],
                    'number' => 1,
                    'price' => $request['price'],
                    'total' => $request['cal_discount'],
                ]);

            } else {


                //                $exist = Cart_value::where('product_id', $product['id'])->where('key', $effectPrice->name)->where('value', $effectValueId)->first();
                //                if (!isset($exist)) {
                //                    $flag++;
                //                }

                if ($flag > 0) {
                    $cart = Cart::create([
                        'product_id' => $product['id'],
                        'cookie' => $_COOKIE['cart'],
                        'color_id' => $request['color'],
                        'number' => 1,
                        'price' => $request['price'],
                        'total' => $request['cal_discount'],
                    ]);

                    //                    Cart_value::create([
                    //                        'key' => $effectPrice->name,
                    //                        'value' => $effectValueId,
                    //                        'cart_id' => $cart->id,
                    //                        'product_id' => $product['id'],
                    //                    ]);

                } else {
                    //                    $tt = $exist->cart->total / $exist->cart->number;
                    //                    $exist->cart->number++;
                    //                    $exist->cart->total = $exist->cart->total + $tt;
                    //                    $exist->cart->save();
                }
            }
        } else {
            $cookie = microtime(true) . rand(1, 10000);
            setcookie('cart', $cookie, time() + 60 * 60 * 24 * 365, '/');
            $cart = Cart::create([
                'color_id' => $request['color'],
                'product_id' => $product['id'],
                'cookie' => $cookie,
                'number' => 1,
                'total' => $request['cal_discount'],
                'price' => $request['price'],
            ]);

            //            Cart_value::create([
            //                'key' => $effectPrice->name,
            //                'value' => $effectValueId,
            //                'cart_id' => $cart->id,
            //                'product_id' => $product['id'],
            //            ]);

            return response()->json(['key' => 'value'], 200);
        }

        return response()->json(['key' => 'value'], 200);
    }

    public function storeCartWithoutColor($request)
    {
        $product = Product::where('name', $request['product'])->first();
        $effectSpec = Effect_spec::find($request['effects']);
        $effectPrice = Effect_price::find($effectSpec->effect_price_id);
        $effectValueId = Effect_value::where('effect_spec_id', $request['effects'])->pluck('id')->first();
        $flag = 0;
        if (isset($_COOKIE['cart'])) {
            $x = Cart::where('cookie', $_COOKIE['cart'])
                ->whereHas('cart_values', function ($query) use ($effectValueId) {
                    return $query->where('value', $effectValueId);
                })->where('product_id', $product['id'])->first();

            if ($x == null) {
                $cart = Cart::create([
                    'product_id' => $product['id'],
                    'cookie' => $_COOKIE['cart'],
                    'color_id' => 0,
                    'number' => 1,
                    'price' => $request['price'],
                    'total' => $request['cal_discount'],
                ]);

                Cart_value::create([
                    'key' => $effectPrice->name,
                    'value' => $effectValueId,
                    'cart_id' => $cart->id,
                    'product_id' => $product['id'],
                ]);

            } else {


                $exist = Cart_value::where('product_id', $product['id'])
                    ->where('key', $effectPrice->name)
                    ->where('value', $effectValueId)->first();
                if (!isset($exist)) {
                    $flag++;
                }

                if ($flag > 0) {
                    $cart = Cart::create([
                        'product_id' => $product['id'],
                        'cookie' => $_COOKIE['cart'],
                        'color_id' => 0,
                        'number' => 1,
                        'price' => $request['price'],
                        'total' => $request['cal_discount'],
                    ]);

                    Cart_value::create([
                        'key' => $effectPrice->name,
                        'value' => $effectValueId,
                        'cart_id' => $cart->id,
                        'product_id' => $product['id'],
                    ]);

                } else {
                    $tt = $exist->cart->total / $exist->cart->number;
                    $exist->cart->number++;
                    $exist->cart->total = $exist->cart->total + $tt;
                    $exist->cart->save();
                }
            }
        } else {
            $cookie = microtime(true) . rand(1, 10000);
            setcookie('cart', $cookie, time() + 60 * 60 * 24 * 365, '/');
            $cart = Cart::create([
                'color_id' => 0,
                'product_id' => $product['id'],
                'cookie' => $cookie,
                'number' => 1,
                'total' => $request['cal_discount'],
                'price' => $request['price'],
            ]);

            Cart_value::create([
                'key' => $effectPrice->name,
                'value' => $effectValueId,
                'cart_id' => $cart->id,
                'product_id' => $product['id'],
            ]);

            return response()->json(['key' => 'value'], 200);
        }

        return response()->json(['key' => 'value'], 200);
    }

    public function storeCartWithoutNothing($request)
    {
        $product = Product::where('name', $request['product'])->first();

        if (isset($_COOKIE['cart'])) {
            $x = Cart::where('cookie', $_COOKIE['cart'])
                ->where('color_id', 0)->where('product_id', $product['id'])->first();

            if (!isset($x->id)) {
                $cart = Cart::create([
                    'product_id' => $product['id'],
                    'cookie' => $_COOKIE['cart'],
                    'color_id' => 0,
                    'number' => 1,
                    'price' => $request['price'],
                    'total' => $request['cal_discount'],
                ]);
            } else {
                $y = $x->total / $x->number;
                $x->number = $x->number + 1;
                $x->total = $x->number * $y;
                $x->save();
            }
        } else {
            $cookie = microtime(true) . rand(1, 10000);
            setcookie('cart', $cookie, time() + 60 * 60 * 24 * 365, '/');
            $cart = Cart::create([
                'color_id' => 0,
                'product_id' => $product['id'],
                'cookie' => $cookie,
                'number' => 1,
                'total' => $request['cal_discount'],
                'price' => $request['price'],
            ]);

            return response()->json(['key' => 'value'], 200);
        }

        return response()->json(['key' => 'value'], 200);
    }

    public function fetchCartNumber()
    {
        $number = Cart::where('cookie', $_COOKIE['cart'])->sum('number');

        return response()->json($number);
    }

    public function about()
    {
        return view('front.dress.about');
    }

    public function contact()
    {
        return view('front.dress.contact');
    }

    public function rolls()
    {
        return view('front.dress.rolls');
    }

    public function delivery()
    {
        return view('front.dress.delivery');
    }

    public function online()
    {

        return view('front.dress.online');
    }

    public function searchBrand($cat, $brand)
    {
        $cat_id = Category::where('name', $cat)->pluck('id')->first();
        $brand_ids = DB::table('brand_category')->where('cat_id', $cat_id)->get('brand_id');

        $brand_ids = json_decode($brand_ids, true);

        $result = array();
        foreach ($brand_ids as $brand_id) {
            array_push($result, $brand_id['brand_id']);

        }

        $result = Brand::whereIn('id', $result)->where(function ($q) use ($brand) {
            $q->where('name', 'like', '%' . $brand . '%')->orWhere('name_f', 'like', '%' . $brand . '%');
        })->get();

        return response()->json($result);
    }

    public function complaint()
    {
        return view('front.complaint');
    }

    public function complaintStore(Request $request)
    {
        Complaint::create([
            'name' => $request['name'],
            'mobile' => $request['mobile'],
            'ticket' => $request['ticket'],
        ]);

        return response()->json(['key' => 'value'], 200);
    }

}
