<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Effect_price;
use App\Models\Effect_spec;
use App\Models\Effect_value;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Spec_value;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.product.index');
    }

    public function fetch()
    {
        $products = Product::orderBy('created_at', 'desc')->with('cat')->paginate(15);
        return response()->json($products);
    }

    public function fetchValue($pro)
    {
        $values = Spec_value::where('product_id', $pro)->get();
        return response()->json($values);
    }

    public function fetchColors($pro)
    {
        $colors = Color::where('product_id', $pro)->get();
        return response()->json($colors);
    }

    public function fetchGallery($pro)
    {
        $gallery = Gallery::where('product_id', $pro)->whereNull('color_id')->get();
        return response()->json($gallery);
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function fechCatspec($id)
    {
        $catspecs = Category::where('id', $id)->with('catspecs.specifications')->first();
        return response()->json($catspecs);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'max:40'],
            'cat' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'image' => 'required',
        ];

        $customMessages = [
            'name.required' => 'نام الزامی است',
            'name.max' => 'حداکثر 40 کاراکتر',
        ];

        $this->validate($request, $rules, $customMessages);


        $productExist = Product::where('name', $request['name'])->first();

        if (isset($productExist->id)) {
            return response()->json($productExist->id);
        }

        $admin_id = auth('admin')->user()->id;
        $random1 = Str::random(3);
        $imageName = $random1 . time() . '.' . $request->image->getClientOriginalName();
        $request->image->move(public_path('images/product'), $imageName);

        $slug = str_replace(" ", "-", $request['name']);

        if (!empty($request['brand'])) {
            $brandName = Brand::where('id', $request['brand'])->pluck('name')->first();
        } else {
            $brandName = null;
        }

        if ($request['status'] == 0) {
            $status = 0;
        } else {
            $status = 1;
        }

        if ($request['suggest'] == 0) {
            $suggest = 0;
        } else {
            $suggest = 1;
        }

        $product = Product::create([
            'code' => $request['code'],
            'name' => $request['name'],
            'brand_id' => $request['brand'],
            'brand' => $brandName,
            'price' => $request['price'],
            'discount' => $request['discount'],
            'description' => $request['description'],
            'short_desc' => $request['short_desc'],
            'status' => $status,
            'suggest' => $suggest,
            'cat_id' => $request['cat'],
            'seo_title' => $request['seo_title'],
            'seo_key' => $request['seo_key'],
            'seo_description' => $request['seo_description'],
            'image' => $imageName,
            'slug' => $slug,
            'admin_id' => $admin_id,
        ]);

        $product->shamsi_c = Verta::instance($product->created_at)->format('Y/n/j');
        $product->shamsi_u = Verta::instance($product->updated_at)->format('Y/n/j');
        $product->save();

        $effectVals = json_decode($request['effects']);
        foreach ($effectVals as $key => $effectVal) {
            $effect_spec = Effect_spec::where('name', $key)->where('brand_id', $product->brand_id)->first();
            Effect_value::create([
                'key' => $key,
                'value' => $effectVal,
                'product_id' => $product->id,
                'effect_price_id' => $effect_spec->effect_price->id,
                'effect_spec_id' => $effect_spec->id,
            ]);
        }


        $specVals = json_decode($request['specifications']);
        foreach ($specVals as $key => $specVal) {
            Spec_value::create([
                'key' => $key,
                'value' => $specVal,
                'product_id' => $product->id,
                'cat_id' => $request['cat'],
            ]);
        }

        $colors = json_decode($request['colors']);
        foreach ($colors as $key => $color) {
            if (!empty($color->code)) {
                $code = $color->code;
            } else {
                $code = '#000000';
            }
            Color::create([
                'name' => $color->name,
                'code' => $code,
                'price' => $color->price,
                'product_id' => $product->id,
            ]);
        }

        if ($request->color_images != null) {
            $rang = Color::where('product_id', $product->id)->get();
            foreach ($request->color_images as $color_image) {
                $random3 = Str::random(3);

                $imageName3 = $random3 . time() . '.' . $color_image->getClientOriginalName();
                $prefix = explode(".", $color_image->getClientOriginalName());
                $color_image->move(public_path('images/gallery'), $imageName3);
                Gallery::create([
                    'image' => $imageName3,
                    'product_id' => $product->id,
                    'color_id' => $rang[$prefix[0]]->id,
                ]);
            }
        }

        if (!empty($request->pics)) {
            foreach ($request->pics as $pic) {
                $random2 = Str::random(3);
                $imageName2 = $random2 . time() . '.' . $pic->getClientOriginalName();
                $pic->move(public_path('images/gallery'), $imageName2);
                Gallery::create([
                    'image' => $imageName2,
                    'product_id' => $product->id,
                ]);
            }
        }

        return response()->json($product->id);


    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => ['required', 'max:40'],
            'cat' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'image' => 'required',
        ];

        $customMessages = [
            'name.required' => 'نام الزامی است',
            'name.max' => 'حداکثر 40 کاراکتر',
        ];

        if ($request['code'] == 'null') {
            $request['code'] = null;
        }

        if ($request['brand'] == 'null') {
            $request['brand'] = null;
        }

        if ($request['seo_title'] == 'null') {
            $request['seo_title'] = null;
        }

        if ($request['seo_description'] == 'null') {
            $request['seo_description'] = null;
        }

        $this->validate($request, $rules, $customMessages);

        $product = Product::where('id', $id)->first();

        if (!empty($request->image)) {
            if ($request->image != $product->image) {
                $img = 'images/product/' . $product->image;
                unlink($img);
                $imageName = time() . '.' . $request->image->getClientOriginalName();
                $request->image->move(public_path('images/product'), $imageName);
                $product->image = $imageName;
            }
        }

        $slug = str_replace(" ", "-", $request['name']);

        if (!empty($request['brand'])) {
            $brandId = Brand::where('name', $request['brand'])->pluck('id')->first();
        } else {
            $brandId = null;
        }

        if ($request['status'] == 0) {
            $status = 0;
        } else {
            $status = 1;
        }

        if ($request['suggest'] == 0) {
            $suggest = 0;
        } else {
            $suggest = 1;
        }

        $product->code = $request['code'];
        $product->name = $request['name'];
        $product->slug = $slug;
        $product->brand = $request['brand'];
        $product->brand_id = $brandId;
        $product->price = $request['price'];
        $product->discount = $request['discount'];
        $product->description = $request['description'];
        $product->short_desc = $request['short_desc'];
        $product->status = $status;
        $product->suggest = $suggest;
        $product->cat_id = $request['cat'];
        $product->seo_title = $request['seo_title'];
        $product->seo_description = $request['seo_description'];
        $product->seo_key = $request['seo_key'];
        $product->shamsi_u = Verta::instance($product->updated_at)->format('Y/n/j');

        $rang = array();
        $colors = json_decode($request['colors']);
        if ($colors) {
            foreach ($colors as $key => $color) {

                if (!empty($color->code)) {
                    $code = $color->code;
                } else {
                    $code = '#000000';
                }
                $ss = Color::create([
                    'name' => $color->name,
                    'code' => $code,
                    'price' => $color->price,
                    'product_id' => $product->id,
                ]);
                array_push($rang, $ss);
            }

            if (!empty($request->color_images)) {
                foreach ($request->color_images as $color_image) {
                    if (isset($color_image)) {
                        $random3 = Str::random(3);
                        $imageName3 = $random3 . time() . '.' . $color_image->getClientOriginalName();
                        $prefix = explode(".", $color_image->getClientOriginalName());
                        $color_image->move(public_path('images/gallery'), $imageName3);
                        Gallery::create([
                            'image' => $imageName3,
                            'product_id' => $product->id,
                            'color_id' => $rang[$prefix[0]]->id,
                        ]);
                    }
                }
            }
        }
        $specVals = json_decode($request['specifications']);
        Spec_value::where('product_id', $id)->delete();
        foreach ($specVals as $key => $specVal) {
            Spec_value::create([
                'key' => $key,
                'value' => $specVal,
                'product_id' => $product->id,
                'cat_id' => $request['cat'],
            ]);
        }

        $effectVals = json_decode($request['effects']);
        foreach ($effectVals as $key => $effectVal) {

            Effect_value::where('product_id', $product['id'])->where('key', $key)->update([
                'value' => $effectVal,
            ]);
        }

        if (isset($request->pics)) {
            foreach ($request->pics as $pic) {
                $imageName2 = time() . '.' . $pic->getClientOriginalName();
                $pic->move(public_path('images/gallery'), $imageName2);
                Gallery::create([
                    'image' => $imageName2,
                    'product_id' => $product->id,
                ]);
            }
        }
        $product->save();

        return response()->json(['key' => 'value'], 200);
    }

    public function search(Request $request)
    {
        if (isset($request->cat)) {
            if ($request->cat === '999999') {
                $data = Product::with('cat')->orderBy('created_at', 'desc')->paginate(999);
            } else {
                $data = Product::where('cat_id', $request->cat)->with('cat')->orderBy('created_at', 'desc')->paginate(999);
            }
        }
        if (isset($request->name)) {
            $data = Product::where('name', 'like', '%' . $request->name . '%')->with('cat')
                ->orderBy('created_at', 'desc')->paginate(999);
        }
        if (isset($request->brand)) {
            $data = Product::where('brand', 'like', $request->brand . '%')->with('cat')
                ->orderBy('created_at', 'desc')->paginate(999);
        }
        if (isset($request->brand) && isset($request->price)) {
            $data = Product::where('brand', $request->brand)
                ->where('price', '=', $request->price)->with('cat')
                ->orderBy('created_at', 'desc')->paginate(999);
            return response()->json($data);
        }
        if (isset($request->brand) && isset($request->less)) {
            $data = Product::where('brand', 'like', '%' . $request->brand . '%')->with('cat')
                ->where('price', '<', $request->price)->orderBy('created_at', 'desc')->paginate(999);
            return response()->json($data);
        }
        if (isset($request->brand) && isset($request->more)) {
            $data = Product::where('brand', 'like', '%' . $request->brand . '%')->with('cat')
                ->where('price', '>', $request->price)->orderBy('created_at', 'desc')->paginate(999);
            return response()->json($data);
        }
        if (isset($request->price)) {
            $data = Product::where('price', '=', $request->price)->with('cat')
                ->orderBy('created_at', 'desc')->paginate(15);
        }
        if (isset($request->less)) {
            $data = Product::where('price', '<', $request->less)->with('cat')
                ->orderBy('created_at', 'desc')->paginate(15);
        }
        if (isset($request->more)) {
            $data = Product::where('price', '>', $request->more)->with('cat')
                ->orderBy('created_at', 'desc')->paginate(15);
        }
        if (isset($request->shamsi_c)) {
            $data = Product::where('shamsi_c', 'like', $request->shamsi_c . '%')->with('cat')
                ->orderBy('created_at', 'desc')->paginate(15);
        }
        if (isset($request->exist)) {
            $data = Product::where('exist', 'like', $request->exist)->with('cat')
                ->orderBy('created_at', 'desc')->paginate(15);
        }
        if (isset($request->existless)) {
            $data = Product::where('exist', '<', $request->existless)->with('cat')
                ->orderBy('created_at', 'desc')->paginate(15);
        }
        if (isset($request->existmore)) {
            $data = Product::where('exist', '>', $request->existmore)->with('cat')
                ->orderBy('created_at', 'desc')->paginate(15);
        }
        if (isset($request->shamsiless)) {
            $d = explode("/", $request->shamsiless);
            if (isset($d[0]) && isset($d[1]) && isset($d[2])) {
                $date2 = Verta::getGregorian($d[0], $d[1], $d[2]);
                $s = $date2[0] . '-' . $date2[1] . '-' . $date2[2];
                $data = Product::whereDate('created_at', '<', $s)->with('cat')
                    ->orderBy('created_at', 'desc')->paginate(999);
            } else {
                $data = [];
            }
        }
        if (isset($request->shamsimore)) {

            $d = explode("/", $request->shamsimore);
            if (isset($d[0]) && isset($d[1]) && isset($d[2])) {
                $date2 = Verta::getGregorian($d[0], $d[1], $d[2]);
                $s = $date2[0] . '-' . $date2[1] . '-' . $date2[2];
                $data = Product::whereDate('created_at', '>', $s)->with('cat')
                    ->orderBy('created_at', 'desc')->paginate(999);
            } else {
                $data = [];
            }
        }

        return response()->json($data);
    }

    public function edit()
    {
        return view('admin.product.edit');
    }

    public function fetchProduct($id)
    {
        $product = Product::where('id', $id)->with('cat')->first();
        return response()->json($product);
    }

    public function deleteGallery(Gallery $id)
    {
        $id->delete();
        return response()->json(['key' => 'value'], 200);
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {

            $product = Product::where('id', $id)->first();

            $image = 'images/product/' . $product->image;
            $rr = file_exists($image);

            if ($rr == 1) {
                unlink($image);
            }

            foreach ($product->galleries as $gallery) {
                $g = 'images/gallery/' . $gallery->image;
                $rrr = file_exists($g);
                if ($rrr == 1) {
                    unlink($g);
                }
            }

            $product->spec_values()->delete();
            $product->effect_values()->delete();
            $product->galleries()->delete();
            $product->colors()->delete();
            $product->favourites()->delete();
            $product->carts()->delete();
            $product->cart_values()->delete();
            $product->offers()->delete();
            $product->exists()->delete();
            foreach ($product->comments as $comment) {
                $comment->replies()->delete();
            }
            $product->comments()->delete();
            $product->delete();
        });

        return response()->json(['key' => 'value'], 200);
    }

    public function fetchEffectPrice($cat, $brand)
    {
        $effect_prices = Effect_price::where('cat_id', $cat)->where('brand_id', $brand)->with('effect_specs')->get();

        return response()->json($effect_prices);
    }

    public function fetchEffectPriceId($id)
    {
        $product = Product::where('id', $id)->first();
        $brand_id = Brand::where('name', $product->brand)->pluck('id')->first();
        $effect_prices = Effect_price::where('cat_id', $product->cat_id)->where('brand_id', $brand_id)->with('effect_specs')->get();

        return response()->json($effect_prices);
    }

    public function fetchEffectVal($id)
    {
        $values = Effect_value::where('product_id', $id)->get();
        return response()->json($values);
    }

    public function fetchColorImageDemo($id)
    {
        $galleries = Gallery::where('product_id', $id)->whereNotNull('color_id')->get();
        return response()->json($galleries);
    }

    public function deleteColorImage($id)
    {
        $galleries = Gallery::where('color_id', $id)->get();

        if (!empty($galleries)) {
            foreach ($galleries as $gallery) {
                if (isset($gallery->image)) {
                    $image = 'images/gallery/' . $gallery->image;
                    unlink($image);
                    $gallery->delete();
                }
            }
        }

        $color = Color::where('id', $id)->first();
        $color->delete();

        return response()->json(['key' => 'value'], 200);
    }

    public function colorImageShow($id)
    {
        $galley = Gallery::where('color_id', $id)->get();

        return response()->json($galley);
    }

    public function getCatId($name)
    {
        $catId = Category::where('name', $name)->pluck('id')->first();

        return response()->json($catId);
    }

    public function fetchBrands($product_id)
    {
        $catId = Product::where('id', $product_id)->pluck('cat_id')->first();

        $brandIds = DB::table('brand_category')->where('cat_id', $catId)->get();


        $array = array();

        foreach ($brandIds as $brandId) {
            array_push($array, $brandId->brand_id);
        }

        $brands = Brand::whereIn('id', $array)->get();

        return response()->json($brands);
    }

    public function editPrice(Request $request)
    {

        $product = Product::where('id', $request['id'])->first();

        $product->price = $request->price;
        $product->discount = $request->discount;

        $product->save();

        return response()->json(['key' => 'value'], 200);
    }

}
