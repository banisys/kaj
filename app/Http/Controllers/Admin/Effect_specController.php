<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Catspec;
use App\Models\Effect_price;
use App\Models\Effect_spec;
use App\Models\Effect_value;
use App\Models\Product;
use App\Models\Exist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class Effect_specController extends Controller
{
    public function fetch()
    {
        $effect_specs = Effect_spec::orderBy('updated_at', 'desc')->with('cat')->with('brand')->with('effect_price')->paginate(7);

        return response()->json($effect_specs);
    }

    public function create()
    {
        return view('admin.effect_spec.create');
    }

    public function fechCat()
    {
        $xx = Category::whereNotNull('parent')->get('parent');
        $y = array();
        foreach ($xx as $x) {
            array_push($y, $x->parent);
        }
        $parent = array_unique($y);

        $child = Category::whereNotIn('id', $parent)->get();
        return response()->json($child);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cat' => 'required',
            'brand' => 'required',
            'effect_price' => 'required',
        ]);

        $effectSpec = Effect_spec::create([
            'name' => $request['name'],
            'cat_id' => $request['cat'],
            'brand_id' => $request['brand'],
            'effect_price_id' => $request['effect_price'],
        ]);

        $products = Product::where('cat_id', $request['cat'])->where('brand_id', $request['brand'])->get();

        $effectPriceId = Effect_price::where('cat_id', $request['cat'])->where('brand_id', $request['brand'])
            ->pluck('id')->first();

        foreach ($products as $product) {
            Effect_value::create([
                'key' => $request['name'],
                'value' => 0,
                'product_id' => $product['id'],
                'effect_price_id' => $effectPriceId,
                'effect_spec_id' => $effectSpec->id,
            ]);
        }

        return response()->json(['key' => 'value'], 200);
    }

    public function search(Request $request)
    {
        if (isset($request->name)) {
            $data = Effect_spec::where('name', 'like', '%' . $request->name . '%')->orderBy('updated_at', 'desc')
                ->with('cat')->with('brand')->with('effect_price')->paginate(7);
        }
        if (isset($request->cat)) {
            $id = Category::where('name', 'like', '%' . $request->cat . '%')->pluck('id')->first();
            $data = Effect_spec::where('cat_id', $id)->orderBy('updated_at', 'desc')
                ->with('cat')->with('brand')->with('effect_price')->paginate(7);
        }
        if (isset($request->brand)) {
            $id = Brand::where('name', 'like', '%' . $request->brand . '%')->pluck('id')->first();
            $data = Effect_spec::where('brand_id', $id)->orderBy('updated_at', 'desc')
                ->with('cat')->with('brand')->with('effect_price')->paginate(7);
        }
        if (isset($request->effect_price)) {
            $id = Effect_price::where('name', 'like', '%' . $request->effect_price . '%')->pluck('id')->first();
            $data = Effect_spec::where('effect_price_id', $id)->orderBy('updated_at', 'desc')
                ->with('cat')->with('brand')->with('effect_price')->paginate(7);
        }

        return response()->json($data);
    }

    public function fechBrand($id)
    {
        $brands = Brand::where('cat_id', $id)->get();

        return response()->json($brands);
    }

   public function delete($id)
    {
        Exist::where('effect_spec_id', $id)->delete();
        
     
    
  
        
        

        $effectSpec = Effect_spec::find($id);
        $effectSpec->delete();

        return response()->json(['key' => 'value'], 200);
    }

    public function fetchEffectPrice($brandId, $catId)
    {
        $effectPrices = Effect_price::where('brand_id', $brandId)->where('cat_id', $catId)->get();

        return response()->json($effectPrices);
    }
}
