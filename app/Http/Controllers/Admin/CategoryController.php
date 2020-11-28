<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Catspec;
use App\Models\Effect_price;
use App\Models\Effect_spec;
use App\Models\Filter;
use App\Models\Filter_cat;
use App\Models\Product;
use App\Models\Spec_value;
use App\Models\Specification;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Redirect;
use View;
use Illuminate\Support\Facades\DB;
use Session;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.index');
    }

    public function fetchall()
    {
        $categories = Category::where('parent', NULL)->with('childrenRecursive')->get();

        return response()->json($categories);
    }

    public function fetch()
    {
        $categories = Category::where('parent', NULL)->orderBy('updated_at', 'desc')->get();
        return response()->json($categories);

    }

    public function fetchsubcat($id)
    {
        $subcategories = Category::Where('parent', $id)->orderBy('updated_at', 'desc')->get();
        return response()->json($subcategories);

    }

    public function fetchsubsubcat($id)
    {
        $subcategories = Category::Where('parent', '=', $id)->orderBy('updated_at', 'desc')->paginate(500);
        return response()->json($subcategories);

    }

    public function fetchsubs($id)
    {
        $subcategories = Category::Where('parent', '=', $id)->orderBy('updated_at', 'desc')->paginate(500);
        return response()->json($subcategories);

    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        if ($request['parent'] == 'ریشه') {
            $parent = null;
        } else {
            $parent = Category::where('name', $request['parent'])->pluck('id')->first();
        }

        if ($request->image != 'null') {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(base_path('images/category'), $imageName);
        } else {
            $imageName = null;
        }


        $cat = Category::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'parent' => $parent,
            'image' => $imageName,
            'type' => 'محصول',
        ]);

        if ($request['brand_id'] == 'undefined') {
            $request['brand_id'] = null;
        }

        if (!empty($request['brand_id'])) {
            $brands = explode(",", $request['brand_id']);

            foreach ($brands as $brand) {
                $cat->brands()->attach($brand);
            }
        }

        return response()->json(['success' => 'success'], 200);
    }

    public function delete($id)
    {
        $xx = Category::whereNotNull('parent')->where('type', 'محصول')->get('parent');

        $y = array();
        foreach ($xx as $x) {
            array_push($y, $x->parent);
        }
        $parent = array_unique($y);

        $childs = Category::whereNotIn('id', $parent)->where('type', 'محصول')->get();

        $flag = false;
        foreach ($childs as $child) {
            if ($child->id == $id) {
                $flag = true;
            }
        }

        $brandCat = DB::table('brand_category')->where('cat_id', $id)->first();
        $product = Product::where('cat_id', $id)->first();
        $catspec = Catspec::where('cat_id', $id)->first();
        $specification = Specification::where('cat_id', $id)->first();
        $specValue = Spec_value::where('cat_id', $id)->first();
        $effectPrice = Effect_price::where('cat_id', $id)->first();
        $effectSpec = Effect_spec::where('cat_id', $id)->first();
        $filterCat = Filter_cat::where('cat_id', $id)->first();
        $filter = Filter::where('cat_id', $id)->first();


        if (isset($brandCat->cat_id) || isset($product->id) || isset($catspec->id)
            || isset($specification->id) || isset($specValue->id) || isset($effectPrice->id)
            || isset($effectSpec->id) || isset($filterCat->id) || isset($filter->id)) {
            $flag = false;
            Log::alert($brandCat->cat_id);
        }

        if (!$flag) {
            return response()->json('cant');
        }


        $category = Category::where('id', $id)->first();

        $category->brands()->detach();
        if (isset($category->image)) {
            $image = 'images/category/' . $category->image;
            unlink($image);
        }

        $category->delete();

        return response()->json(['key' => 'value'], 200);
    }

    public function fetnewcat($id)
    {
        $x = Category::where('id', $id)->first();

        $y = array();
        array_push($y, $x);
        while (true) {

            $last = end($y);

            if ($last->parent == null) {

                break;
            }
            $z = Category::where('id', $last->parent)->first();
            array_push($y, $z);
        }

        $result = array();

        foreach ($y as $item) {

            array_push($result, $item->name);
        }
        $result = array_reverse($result);

//    $result =  json_encode($result);

//        dd($result);


        return response()->json($result);
    }

    public function showedit($id)
    {

        $category = Category::find($id);


        $x = Category::where('id', $id)->first();

        $y = array();
        array_push($y, $x);
        while (true) {

            $last = end($y);

            if ($last->parent == null) {

                break;
            }
            $z = Category::where('id', $last->parent)->first();
            array_push($y, $z);
        }

        $result = array();

        foreach ($y as $item) {

            array_push($result, $item->name);
        }
        $result = array_reverse($result);

        $result = json_encode($result);

//        dd($result);


        return view('admin.category.edit', compact('category', 'result'));
    }

    public function search(Request $request)
    {
        if (isset($request->name)) {
            $categories = Category::where('name', 'like', '%' . $request->name . '%')->get();
            $arr = array();
            foreach ($categories as $category) {
                $arr2 = array();
                $parent = $category["parent"];
                $result = Category::where('id', $parent)->first();
                if ($result['name'] == Null) {
                    $parentname = 'دسته بندی اصلی';
                } else {
                    $parentname = $result['name'];
                }
                array_push($arr2, $category['id'], $category['name'], $category['image'], $category['description'], $parentname);

                $arr2['id'] = $arr2[0];
                unset($arr2[0]);

                $arr2['name'] = $arr2[1];
                unset($arr2[1]);

                $arr2['parent'] = $arr2[4];
                unset($arr2[4]);
                array_push($arr, $arr2);
            }
        }
        return response()->json($arr);
    }

    public function update(Request $request)
    {
        if ($request->file('image')) {
            if ($request['parent'] != 'undefined' && $request['parent'] != '0' && $request['parent'] != '') {
                $prnt = $request['parent'];
            } else {
                $prnt = null;
            }
            $category = Category::find($request['id']);
            $image = 'uploads/category/' . $category->image;
            unlink($image);

            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(base_path('uploads/category'), $imageName);
            $category->name = $request['name'];
            $category->description = $request['description'];
            $category->parent = $request['parent'];
            $category->type = $request['type'];
            $category->image = $imageName;
            $category->save();
        } else {
            if ($request['parent'] != 'undefined' && $request['parent'] != '0' && $request['parent'] != '') {
                $prnt = $request['parent'];
            } else {
                $prnt = null;
            }
            $category = Category::find($request['id']);
            $category->name = $request['name'];
            $category->description = $request['description'];
            $category->type = $request['type'];
            $category->parent = $prnt;
            $category->save();
        }

        return response()->json(['success' => 'success'], 200);
    }

    public function createblogcat()
    {
        return view('admin.blog.category.create');
    }

    public function blogcatstore(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',

        ]);

        if ($request->file('image')) {
            if ($request['parent'] != 'undefined') {
                $prnt = $request['parent'];
            } else {
                $prnt = null;
            }
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(base_path('uploads/category'), $imageName);
            Category::create([
                'name' => $request['name'],
                'description' => $request['description'],
                'parent' => $prnt,
                'image' => $imageName,
                'type' => 'blog',
            ]);
        } else {
            Category::create([
                'name' => $request['name'],
                'description' => $request['description'],
                'parent' => $request['parent'],
                'type' => 'product',

            ]);
        }


        return response()->json(['success' => 'success'], 200);


    }

    public function indexblogcat()
    {
        return view('admin.blog.category.index');
    }

    public function fetchblogcategory()
    {
        $categories = Category::where('type', '=', 'blog')->orderBy('updated_at', 'desc')->paginate(500);
        $arr = array();
        foreach ($categories as $category) {
            $arr2 = array();
            $parent = $category["parent"];
            $result = Category::where('id', $parent)->where('type', '=', 'blog')->first();
            if ($result['name'] == Null) {
                $parentname = 'دسته بندی اصلی';

            } else {
                $parentname = $result['name'];
            }
            array_push($arr2, $category['id'], $category['name'], $category['image'], $category['description'], $parentname);
            array_push($arr, $arr2);
        }


        return response()->json(['category' => $arr]);
    }

    public function searchblogcat(Request $request)
    {
        if (isset($request->id)) {
            $data = Category::where('id', 'like', '%' . $request->id . '%')->where('type', '=', 'blog')->paginate(7);
            $arr = array();
            foreach ($data as $category) {
                $arr2 = array();
                $parent = $category["parent"];
                $result = Category::where('id', $parent)->where('type', '=', 'blog')->first();
                if ($result['name'] == Null) {
                    $parentname = 'دسته بندی اصلی';

                } else {
                    $parentname = $result['name'];
                }
                array_push($arr2, $category['id'], $category['name'], $category['image'], $category['description'], $parentname);
                array_push($arr, $arr2);
            }
        }
        if (isset($request->name)) {
            $data = Category::where('name', 'like', '%' . $request->name . '%')->where('type', '=', 'blog')->paginate(7);
            $arr = array();
            foreach ($data as $category) {
                $arr2 = array();
                $parent = $category["parent"];
                $result = Category::where('id', $parent)->where('type', '=', 'blog')->first();
                if ($result['name'] == Null) {
                    $parentname = 'دسته بندی اصلی';

                } else {
                    $parentname = $result['name'];
                }
                array_push($arr2, $category['id'], $category['name'], $category['image'], $category['description'], $parentname);
                array_push($arr, $arr2);
            }
        }

        return response()->json($arr);
    }

    public function fetchblogcategorycreate()
    {
        $categories = Category::where('parent', '=', NULL)->where('type', '=', 'blog')->orderBy('updated_at', 'desc')->paginate(500);
        return response()->json($categories);
    }

    public function fetchblogsubcat($id)
    {
        $subcategories = Category::Where('parent', '=', $id)->where('type', '=', 'blog')->orderBy('updated_at', 'desc')->paginate(500);
        return response()->json($subcategories);
    }

    public function fetchblogsubsubcat($id)
    {
        $subcategories = Category::Where('parent', '=', $id)->where('type', '=', 'blog')->orderBy('updated_at', 'desc')->paginate(500);
        return response()->json($subcategories);
    }

    public function fetchblogsubs($id)
    {
        $subcategories = Category::Where('parent', '=', $id)->where('type', '=', 'blog')->orderBy('updated_at', 'desc')->paginate(500);
        return response()->json($subcategories);

    }

    public function showblogcatedit($id)
    {
        $category = Category::find($id);
        $x = Category::where('id', $id)->first();
        $y = array();
        array_push($y, $x);
        while (true) {
            $last = end($y);
            if ($last->parent == null) {
                break;
            }
            $z = Category::where('id', $last->parent)->first();
            array_push($y, $z);
        }

        $result = array();

        foreach ($y as $item) {

            array_push($result, $item->name);
        }
        $result = array_reverse($result);

        $result = json_encode($result);

//        dd($result);


        return view('admin.blog.category.edit', compact('category', 'result'));
    }

    public function blogcatupdate(Request $request)
    {
        if ($request->file('image')) {
            if ($request['parent'] != 'undefined' && $request['parent'] != '0' && $request['parent'] != '') {
                $prnt = $request['parent'];
            } else {
                $prnt = null;
            }

            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(base_path('uploads/category'), $imageName);
            $category = Category::find($request['id']);
            $category->name = $request['name'];
            $category->description = $request['description'];
            $category->parent = $request['parent'];
            $category->image = $imageName;
            $category->save();


        } else {
            if ($request['parent'] != 'undefined' && $request['parent'] != '0' && $request['parent'] != '') {
                $prnt = $request['parent'];
            } else {
                $prnt = null;
            }
            $category = Category::find($request['id']);
            $category->name = $request['name'];
            $category->description = $request['description'];
            $category->parent = $prnt;
            $category->save();
        }


        return response()->json(['success' => 'success'], 200);

    }

    public function fetnewcatblog($id)
    {
        $x = Category::where('id', $id)->where('type', '=', 'blog')->first();
        $y = array();
        array_push($y, $x);
        while (true) {

            $last = end($y);

            if ($last->parent == null) {

                break;
            }
            $z = Category::where('id', $last->parent)->first();
            array_push($y, $z);
        }

        $result = array();

        foreach ($y as $item) {

            array_push($result, $item->name);
        }
        $result = array_reverse($result);

//    $result =  json_encode($result);

//        dd($result);


        return response()->json($result);
    }

    public function fetchRootCat($type)
    {
        $roots = Category::where('parent', null)->where('type', $type)->get();

        return response()->json($roots);
    }

    public function fetchRootChild($id, $type)
    {
        $childs = Category::where('parent', $id)->where('type', $type)->with('childrenRecursive')->get();

        return response()->json($childs);
    }

    public function fetchBrands()
    {
        $brands = Brand::orderBy('created_at', 'desc')->get();

        return response()->json($brands);
    }

    public function fetchTest()
    {
        $categories = Category::where('parent', NULL)->with('childrenRecursive')->get();
        return response()->json($categories);

    }

    public function edit(Request $request)
    {
        $category = Category::find($request['id']);
        $category->name = $request['name'];
        $category->save();

        return response()->json(['key' => 'value']);

    }

    public function searchBrand($brand)
    {
        $result = Brand::where('name', 'like', '%' . $brand . '%')
            ->orWhere('name_f', 'like', '%' . $brand . '%')->get();

        return response()->json($result);

    }
}
