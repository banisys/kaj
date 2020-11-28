<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use App\Models\Off;
use Illuminate\Support\Facades\Log;

class OffController extends Controller
{
    public function create()
    {
        return view('admin.off.create');
    }

    public function fetchOffs()
    {
        $offs = Off::orderBy('updated_at', 'desc')->paginate(9999);
        $arr = array();
        foreach ($offs as $off) {
            $arr2 = array();
            $cat_id_of = $off["category"];
            $brand_id_of = $off["brand"];
            if ($cat_id_of == '0') {
                $category = 'همه دسته ها';

            } else {
                $category = $off["category"];
            }
            if ($brand_id_of == '0') {
                $brand = 'همه برند ها';
            } else {
                $brand = $off["brand"];
            }
            $x = $off['created_at']->addDays($off['expir']);
            $expir = Verta::instance($x)->format('Y/n/j');
            array_push($arr2, $off['id'], $off['name'], $off['code'], $expir, $off['percent'], $category, $brand);
            array_push($arr, $arr2);
        }

        return response()->json(['off' => $arr]);
    }

    public function fetchBrands()
    {
        $brands = Brand::orderBy('updated_at', 'desc')->paginate(7);

        return response()->json($brands);
    }

    public function fetchCat()
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
            'percent' => 'required',
            'code' => 'required',
            'expir' => 'required',
        ]);

        if ($request['cat_id'] == NULL || $request['cat_id'] == '9999') {
            $catName = '0';
        } else {
            $category = Category::find($request['cat_id']);
            $catName = $category->name;
        }
        if ($request['brand_id'] == NULL || $request['brand_id'] == '9999') {
            $brandName = '0';
        } else {
            $brand = Brand::find($request['brand_id']);
            $brandName = $brand->name;
        }

        $eDate=Carbon::now()->addDays($request['expir']);

        Off::create([
            'name' => $request['name'],
            'percent' => $request['percent'],
            'code' => $request['code'],
            'expir' => $request['expir'],
            'category' => $catName,
            'brand' => $brandName,
            'min' => $request['min'],
            'e_date' => $eDate,
        ]);

        return response()->json();
    }

    public function delete($id)
    {
        $off = Off::find($id);
        $off->delete();
        return response()->json();
    }

    public function search(Request $request)
    {

        if ($request['name']) {

            $data = Off::where('name', 'LIKE', '%' . $request['name'] . '%')->paginate(7);
            $arr = array();
            foreach ($data as $off) {
                $arr2 = array();
                $cat_id_of = $off["category"];
                $brand_id_of = $off["brand"];
                if ($cat_id_of == '0') {
                    $category = 'همه دسته ها';

                } else {
                    $category = $off["category"];
                }
                if ($brand_id_of == '0') {
                    $brand = 'همه برند ها';
                } else {
                    $brand = $off["brand"];
                }
                array_push($arr2, $off['id'], $off['name'], $off['code'], $off['expir'], $off['percent'], $category, $brand);
                array_push($arr, $arr2);

            }
            log::info($arr);
            return response()->json(['off' => $arr]);
        }
        if ($request['category']) {
            if ($request['category'] == '9999' || $request['category'] == NULL) {
                $data = Off::where('category', '=', '0')->paginate(7);
                $arr = array();
                foreach ($data as $off) {
                    $arr2 = array();
                    $cat_id_of = $off["category"];
                    $brand_id_of = $off["brand"];
                    if ($cat_id_of == '0') {
                        $category = 'همه دسته ها';

                    } else {
                        $category = $off["category"];
                    }
                    if ($brand_id_of == '0') {
                        $brand = 'همه برند ها';
                    } else {
                        $brand = $off["brand"];
                    }
                    array_push($arr2, $off['id'], $off['name'], $off['code'], $off['expir'], $off['percent'], $category, $brand);
                    array_push($arr, $arr2);
                }

                return response()->json(['off' => $arr]);
            } else {
                $category = Category::find($request['category']);
                $catName = $category->name;
                $data = Off::where('category', 'LIKE', '%' . $catName . '%')->paginate(7);
                $arr = array();
                foreach ($data as $off) {
                    $arr2 = array();
                    $cat_id_of = $off["category"];
                    $brand_id_of = $off["brand"];
                    if ($cat_id_of == '0') {
                        $category = 'همه دسته ها';

                    } else {
                        $category = $off["category"];
                    }
                    if ($brand_id_of == '0') {
                        $brand = 'همه برند ها';
                    } else {
                        $brand = $off["brand"];
                    }
                    array_push($arr2, $off['id'], $off['name'], $off['code'], $off['expir'], $off['percent'], $category, $brand);
                    array_push($arr, $arr2);
                }
                return response()->json(['off' => $arr]);
            }
        }
        if ($request['brand']) {
            if ($request['brand'] == '9999' || $request['brand'] == NULL) {
                $data = Off::where('brand', '=', '0')->paginate(7);
                $arr = array();
                foreach ($data as $off) {
                    $arr2 = array();
                    $cat_id_of = $off["category"];
                    $brand_id_of = $off["brand"];
                    if ($cat_id_of == '0') {
                        $category = 'همه دسته ها';

                    } else {
                        $category = $off["category"];
                    }
                    if ($brand_id_of == '0') {
                        $brand = 'همه برند ها';
                    } else {
                        $brand = $off["brand"];
                    }
                    array_push($arr2, $off['id'], $off['name'], $off['code'], $off['expir'], $off['percent'], $category, $brand);
                    array_push($arr, $arr2);
                }

                return response()->json(['off' => $arr]);
            } else {
                $brand = Brand::find($request['brand']);
                $brandName = $brand->name;
                $data = Off::where('brand', 'LIKE', '%' . $brandName . '%')->paginate(7);
                $arr = array();
                foreach ($data as $off) {
                    $arr2 = array();
                    $cat_id_of = $off["category"];
                    $brand_id_of = $off["brand"];
                    if ($cat_id_of == '0') {
                        $category = 'همه دسته ها';

                    } else {
                        $category = $off["category"];
                    }
                    if ($brand_id_of == '0') {
                        $brand = 'همه برند ها';
                    } else {
                        $brand = $off["brand"];
                    }
                    array_push($arr2, $off['id'], $off['name'], $off['code'], $off['expir'], $off['percent'], $category, $brand);
                    array_push($arr, $arr2);
                }
                return response()->json(['off' => $arr]);

            }
        }


    }

    public function edit($id)
    {
        $data = Off::find($id);
        return response()->json($data);
    }

    public function fetchDetail($id)
    {
        $data = Off::find($id);
        return response()->json($data);
    }


}
