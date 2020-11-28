<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Effect_price;
use App\Models\Effect_spec;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BrandController extends Controller
{
    public function fetch()
    {
        $brand = Brand::with('cats')->orderBy('updated_at', 'desc')->paginate(7);
        return response()->json($brand);
    }

    public function fetchAll()
    {
        $brand = Brand::orderBy('updated_at', 'desc')->get();
        return response()->json($brand);
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name_f' => ['required', 'max:40', 'unique:brands'],
            'name_e' => ['required', 'max:40'],
            'name' => 'required',
        ];

        $customMessages = [
            'name_f.required' => 'نام فارسی الزامی است',
            'name_e.required' => 'نام لاتین الزامی است',
            'name.required' => 'انتخاب دسته الزامی است',
            'name_f.unique' => 'این نام فارسی قبلا ثبت شده است',
        ];

        $this->validate($request, $rules, $customMessages);



        $validBrandName = Brand::where('name', $request['name_e'])->first();

        if (isset($validBrandName->id)){
            throw ValidationException::withMessages(['name_e' => 'این نام لاتین قبلا ثبت شده است']);
        }

        if ($request->image != 'null') {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(base_path('images/brand'), $imageName);
        } else {
            $imageName = null;
        }

        $brand = Brand::create([
            'name' => $request['name_e'],
            'name_f' => $request['name_f'],
            'image' => $imageName,
            'description' => $request['description'],
        ]);

        $result = array();

        if ($request['name'] == 'ریشه') {
            $cats = Category::where('parent', null)->with('childrenRecursive')->get();
            foreach ($cats as $cat) {
                foreach ($cat->childrenRecursive as $chil) {
                    if (!isset($chil->childrenRecursive[0]->id)) {

                        array_push($result, $chil->id);
                    } else {

                        foreach ($chil->childrenRecursive as $chil2) {
                            if (!isset($chil2->childrenRecursive[0]->id)) {
                                array_push($result, $chil2->id);
                            } else {
                                foreach ($chil2->childrenRecursive as $chil3) {
                                    if (!isset($chil3->childrenRecursive[0]->id)) {
                                        array_push($result, $chil3->id);
                                    } else {
                                        foreach ($chil3->childrenRecursive as $chil4) {
                                            if (!isset($chil4->childrenRecursive[0]->id)) {
                                                array_push($result, $chil4->id);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }


        } else {
            $cat = Category::where('name', $request['name'])->with('childrenRecursive')->first();

            if (!isset($cat->childrenRecursive[0]->id)) {
                array_push($result, $cat->id);
            }
            foreach ($cat->childrenRecursive as $chil) {
                if (!isset($chil->childrenRecursive[0]->id)) {

                    array_push($result, $chil->id);
                } else {

                    foreach ($chil->childrenRecursive as $chil2) {
                        if (!isset($chil2->childrenRecursive[0]->id)) {
                            array_push($result, $chil2->id);
                        } else {
                            foreach ($chil2->childrenRecursive as $chil3) {
                                if (!isset($chil3->childrenRecursive[0]->id)) {
                                    array_push($result, $chil3->id);
                                } else {
                                    foreach ($chil3->childrenRecursive as $chil4) {
                                        if (!isset($chil4->childrenRecursive[0]->id)) {
                                            array_push($result, $chil4->id);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        foreach ($result as $item) {
            DB::table('brand_category')->insert([
                    'brand_id' => $brand->id,
                    'cat_id' => $item
                ]
            );
        }

        return response()->json(['key' => 'value'], 200);
    }

    public function search(Request $request)
    {

        if (isset($request->name)) {
            $data = Brand::where('name', 'like', '%' . $request->name . '%')->orderBy('updated_at', 'desc')
                ->with('cats')->paginate(7);
        }
        return response()->json($data);
    }

    public function image(Brand $id)
    {
        $image = $id->image;
        return response()->json($image);
    }

    public function description(Brand $id)
    {
        $description = $id->description;
        return response()->json($description);
    }

    public function delete(Brand $id)
    {
        $product = Product::where('brand_id', $id->id)->first();
        $effectPrice = Effect_price::where('brand_id', $id->id)->first();
        $effectSpec = Effect_spec::where('brand_id', $id->id)->first();

        if (isset($product->id) || isset($effectPrice->id) || isset($effectSpec->id)) {
            return response()->json('cant');
        }

        $id->cats()->detach();

        $brand = Brand::where('id', $id->id)->first();
        if (isset($brand->image)) {
            $string_1 = 'images/brand/' . $id->image;
            unlink($string_1);
        }

        $id->delete();
        return response()->json(['key' => 'value'], 200);
    }

    public function fetchBrandCat($cat)
    {
        $cat = Category::find($cat);
        $brands = $cat->brands;

        return response()->json($brands);
    }

    public function editCat(Request $request)
    {
        DB::table('brand_category')->where('brand_id', $request['brand'])->delete();
        $cats = explode(",", $request['cats']);

        foreach ($cats as $cat) {
            DB::table('brand_category')->insert([
                'brand_id' => $request['brand'],
                'cat_id' => $cat,
            ]);
        }

        return response()->json(['key' => 'value'], 200);
    }

    public function fetchRootChild($id)
    {
        $childs = Category::where('parent', $id)->where('type', 'محصول')->with('childrenRecursive')->get();

        return response()->json($childs);
    }

    public function fetchRootCat()
    {
        $roots = Category::where('parent', null)->where('type', 'محصول')->get();

        return response()->json($roots);
    }
}
