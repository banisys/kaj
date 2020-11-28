<?php

namespace App\Http\Controllers\Admin;

use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Effect_spec;
use App\Models\Effect_value;
use App\Models\Exist;
use App\Models\Product;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use App\Models\Off;
use Illuminate\Support\Facades\Log;
use App\Models\Effect_price;


class ExistController extends Controller
{
    public function index()
    {
        return view('admin.exist.index');
    }

    public function set()
    {
        return view('admin.exist.set');
    }

    public function fetchColors($id)
    {
        $colors = Color::where('product_id', $id)->get(['name', 'id']);

        return response()->json($colors);
    }

    public function fetchEffects($id)
    {
        $product = Product::find($id);

        $effects = Effect_spec::where('cat_id', $product->cat_id)->where('brand_id', $product->brand_id)
            ->with('effect_price')->get();

        return response()->json($effects);
    }

    public function getSlug($id)
    {
        $slug = Product::where('id', $id)->pluck('slug')->first();

        return response()->json($slug);
    }

    public function storeNum(Request $request)
    {
        $pid = sprintf("%'.04d", $request['product_id'] ?? 0);
        $cid = sprintf("%'.04d", $request['color_id'] ?? 0);
        $eid = sprintf("%'.03d",  $request['effect_spec'] ?? 0);
        $pCode = "{$pid}{$cid}{$eid}";
        $ext = Exist::where('product_code', $pCode)->orderBy('created_at','DESC')->first();
        if ($ext)
        {
            $request['code'] = $pCode;
            return $this->changeNum($request);
        }
        
        if ($request['effect_spec'] == 'effect not set' && $request['color_id'] == 'color not set') {
            return $this->storeNumWithoutNothing($request);
        }

        if ($request['effect_spec'] == 'effect not set') {
            return $this->storeNumWithoutEffect($request);
        }

        if ($request['color_id'] == 'color not set') {
            return $this->storeNumWithoutColor($request);
        }

        $effectSpec = Effect_spec::find($request['effect_spec']);
        $effectPriceId = Effect_value::where('key', $effectSpec->name)
            ->where('product_id', $request['product_id'])->pluck('effect_price_id')->first();

        $effectSpecId = $request['effect_spec'];

        $productId = sprintf("%'.04d", $request['product_id']);
        $colorId = sprintf("%'.04d", $request['color_id']);
        $effectSpecId2 = sprintf("%'.03d", $effectSpecId);
        $productCode = "{$productId}{$colorId}{$effectSpecId2}";
//        $productCode = "{$productId}{$colorId}";

        $exist = Exist::create([
            'product_code' => $productCode,
            'product_id' => $request['product_id'],
            'effect_price_id' => $effectPriceId,
            'effect_spec_id' => $effectSpecId,
            'color_id' => $request['color_id'],
            'num' => $request['num'],
        ]);
        
        ProductService::setInventoryTransaction($exist, ['type'=>'add', 'factor_num'=>$request->factor_num]);

        return response()->json(['key' => 'value'], 200);
    }

    public function fetchExist($id)
    {
        $exists = Exist::where('product_id', $id)->with('effect_spec')->with('color')->paginate(150);

        return response()->json($exists);
    }

    public function delete($id)
    {
        $exist = Exist::find($id);
        
        ProductService::setInventoryTransaction($exist, ['type'=>'remove']);
        
        $exist->delete();
        return response()->json(['key' => 'value'], 200);
    }

    public function productCode()
    {
        return view('admin.exist.product_code');
    }

    public function productCodeSearch(Request $request)
    {
        $result = Exist::where('product_code', $request['code'])
            ->with('effect_spec')->with('color')->with('product')->with('effect_price')->first();

        return response()->json($result);
    }

    public function changeNum(Request $request)
    {
        $exist = Exist::where('product_code', $request['code'])->first();
        ProductService::setInventoryTransaction($exist, ['type'=>'change'], $request['num']);
        
        if ($request['num'] == 0) {
            Exist::where('product_code', $request['code'])->delete();
        } else {
            Exist::where('product_code', $request['code'])->update(['num' => $request['num']]);
        }


        return response()->json(['key' => 'value'], 200);
    }

    public function fetchEffectPrice($id)
    {
        $product = Product::where('id', $id)->first();

        $effectPrice = Effect_price::where('cat_id', $product->cat_id)
            ->where('brand_id', $product->brand_id)->pluck('name')->first();


        return response()->json($effectPrice);
    }

    public function fetchEffectSpec($id)
    {
        $product = Product::where('id', $id)->first();

        $effectSpec = Effect_spec::where('cat_id', $product->cat_id)
            ->where('brand_id', $product->brand_id)->get();

        return response()->json($effectSpec);
    }

    public function storeNumWithoutEffect($request)
    {
        $productId = sprintf("%'.04d", $request['product_id']);
        $colorId = sprintf("%'.04d", $request['color_id']);
        $effectSpecId2 = sprintf("%'.03d", 0);
        $productCode = "{$productId}{$colorId}{$effectSpecId2}";

        $exist = Exist::create([
            'product_code' => $productCode,
            'product_id' => $request['product_id'],
            'effect_price_id' => 0,
            'effect_spec_id' => 0,
            'color_id' => $request['color_id'],
            'num' => $request['num'],
        ]);
        
        ProductService::setInventoryTransaction($exist, ['type'=>'add', 'factor_num'=>$request->factor_num]);

        return response()->json(['key' => 'value'], 200);
    }

    public function storeNumWithoutColor($request)
    {
        $effectSpec = Effect_spec::find($request['effect_spec']);
        $effectPriceId = Effect_value::where('key', $effectSpec->name)
            ->where('product_id', $request['product_id'])->pluck('effect_price_id')->first();

        $effectSpecId = $request['effect_spec'];

        $productId = sprintf("%'.04d", $request['product_id']);
        $colorId = sprintf("%'.04d", 0);
        $effectSpecId2 = sprintf("%'.03d", $effectSpecId);
        $productCode = "{$productId}{$colorId}{$effectSpecId2}";

        $exist = Exist::create([
            'product_code' => $productCode,
            'product_id' => $request['product_id'],
            'effect_price_id' => $effectPriceId,
            'effect_spec_id' => $effectSpecId,
            'color_id' => 0,
            'num' => $request['num'],
        ]);
        
        ProductService::setInventoryTransaction($exist, ['type'=>'add', 'factor_num'=>$request->factor_num]);

        return response()->json(['key' => 'value'], 200);
    }

    public function storeNumWithoutNothing($request)
    {
        $effectSpecId = 0;

        $productId = sprintf("%'.04d", $request['product_id']);
        $colorId = sprintf("%'.04d", 0);
        $effectSpecId2 = sprintf("%'.03d", 0);
        $productCode = "{$productId}{$colorId}{$effectSpecId2}";

        $exist = Exist::create([
            'product_code' => $productCode,
            'product_id' => $request['product_id'],
            'effect_price_id' => 0,
            'effect_spec_id' => 0,
            'color_id' => 0,
            'num' => $request['num'],
        ]);
        
        ProductService::setInventoryTransaction($exist, ['type'=>'add', 'factor_num'=>$request->factor_num]);

        return response()->json(['key' => 'value'], 200);
    }
}
