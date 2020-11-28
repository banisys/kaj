<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Catspec;
use App\Models\Effect_price;
use App\Models\Effect_spec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class Effect_priceController extends Controller
{
    public function fetch()
    {
        $effect = Effect_price::orderBy('updated_at', 'desc')->with('cat')->with('brand')->paginate(7);
        return response()->json($effect);
    }

    public function create()
    {
        return view('admin.effect_price.create');
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
        ]);

        $effectPrice = Effect_price::where('cat_id', $request['cat'])->where('brand_id', $request['brand'])->first();
        if (!isset($effectPrice->id)) {
            Effect_price::create([
                'name' => $request['name'],
                'cat_id' => $request['cat'],
                'brand_id' => $request['brand'],
            ]);

            return response()->json(['key' => 'value'], 200);
        } else {
            return response()->json("iterate");
        }
    }

    public function search(Request $request)
    {

        if (isset($request->name)) {
            $data = Effect_price::where('name', 'like', '%' . $request->name . '%')->orderBy('updated_at', 'desc')
                ->with('cat')->with('brand')->paginate(7);
        }
        if (isset($request->cat)) {
            $id = Category::where('name', 'like', '%' . $request->cat . '%')->pluck('id')->first();
            $data = Effect_price::where('cat_id', $id)->orderBy('updated_at', 'desc')
                ->with('cat')->with('brand')->paginate(7);
        }
        if (isset($request->brand)) {
            $id = Brand::where('name', 'like', '%' . $request->brand . '%')->pluck('id')->first();
            $data = Effect_price::where('brand_id', $id)->orderBy('updated_at', 'desc')
                ->with('cat')->with('brand')->paginate(7);
        }

        return response()->json($data);
    }

    public function fechBrand($id)
    {
        $cat=Category::find($id);
        $brands = $cat->brands;

        return response()->json($brands);
    }

    public function delete(Effect_price $id)
    {

        $effectSpec=Effect_spec::where('effect_price_id', $id->id)->first();

        if (isset($effectSpec->id)) {
            return response()->json('cant');
        }

        $id->delete();
        return response()->json(['key' => 'value'], 200);
    }
}
