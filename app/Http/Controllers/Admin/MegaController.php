<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Mega;
use App\Models\Mega_cat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class MegaController extends Controller
{
    public function create()
    {
        return view('admin.mega.create');
    }

    public function fetchRootCat()
    {
        $roots = Category::where('parent', null)->get();

        return response()->json($roots);
    }

    public function fetchRootChild($id)
    {
        $childs = Category::where('parent', $id)->with('childrenRecursive')->get();

        return response()->json($childs);
    }

    public function fetchBrands()
    {
        $brands = Brand::get();
        $res = $brands->unique('name');
        return response()->json($res);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'priority' => 'required',
        ]);

        Mega::create([
            'name' => $request['name'],
            'title' => $request['title'],
            'priority' => $request['priority'],
            'type' => $request['type'],
            'mega_cat_id' => $request['mega_cat_id'],
        ]);

        return response()->json(['key' => 'value'], 200);
    }

    public function fetchMegas()
    {
        $megas = Mega::orderBy('created_at', 'desc')->with('mega_cat')->paginate(7);
        return response()->json($megas);
    }

    public function delete($id)
    {
        $mega = Mega::find($id);
        $mega->delete();
        return response()->json(['key' => 'value'], 200);
    }

    public function megaCat()
    {
        return view('admin.mega.cat');
    }

    public function storeMegaCats(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        if ($request->image != null) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(base_path('images/mega'), $imageName);
        } else {
            $imageName = null;
        }

        Mega_cat::create([
            'name' => $request['name'],
            'image' => $imageName,
        ]);

        return response()->json(['key' => 'value'], 200);
    }

    public function fetchMegaCats()
    {
        $megaCats = Mega_cat::orderBy('created_at', 'desc')->paginate(7);
        return response()->json($megaCats);
    }

    public function deleteCat(Mega_cat $id)
    {
        if (isset($id->image)) {
            $string_1 = 'images/mega/' . $id->image;
            unlink($string_1);
        }
        $id->delete();
        return response()->json(['key' => 'value'], 200);
    }

    public function megaCats()
    {
        $megaCats = Mega_cat::get();
        return response()->json($megaCats);
    }
}
