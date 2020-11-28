<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Category;

use App\Models\Catspec;
use App\Models\Specification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class CatspecController extends Controller
{
    public function fetch()
    {
        $catspec = Catspec::orderBy('updated_at', 'desc')->with('cat')->paginate(15);
        return response()->json($catspec);
    }

    public function create()
    {
        return view('admin.catspec.create');
    }

    public function fechCat()
    {
        $xx = Category::whereNotNull('parent')->where('type', 'محصول')->get('parent');
        $y = array();
        foreach ($xx as $x) {
            array_push($y, $x->parent);
        }
        $parent = array_unique($y);

        $child = Category::whereNotIn('id', $parent)->where('type', 'محصول')->get();
        return response()->json($child);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cat' => 'required',
        ]);

        $catId = Category::where('name', $request['cat'])->pluck('id')->first();

        Catspec::create([
            'name' => $request['name'],
            'cat_id' => $catId,
        ]);

        return response()->json(['key' => 'value'], 200);
    }

    public function delete(Catspec $id)
    {
        $specification = Specification::where('catspec_id', $id->id)->first();

        if (isset($specification->id)) {
            return response()->json('cant');
        }

        $id->delete();
        return response()->json(['key' => 'value'], 200);
    }

    public function search(Request $request)
    {

        if (isset($request->id)) {
            $data = Catspec::where('id', 'like', '%' . $request->id . '%')->orderBy('updated_at', 'desc')->with('cat')->paginate(15);
        }
        if (isset($request->name)) {
            $data = Catspec::where('name', 'like', '%' . $request->name . '%')->orderBy('updated_at', 'desc')->with('cat')->paginate(15);
        }
        if (isset($request->cat)) {
            $id = Category::where('name', 'like', '%' . $request->cat . '%')->pluck('id')->first();
            $data = Catspec::where('cat_id', $id)->orderBy('updated_at', 'desc')->with('cat')->paginate(15);

        }

        return response()->json($data);
    }
}
