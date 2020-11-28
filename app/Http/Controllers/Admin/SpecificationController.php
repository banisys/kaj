<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Catspec;
use App\Models\Specification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class SpecificationController extends Controller
{
    public function fetch()
    {
        $catspec = Specification::orderBy('updated_at', 'desc')->with('cat', 'catspec')->paginate(15);
        return response()->json($catspec);
    }

    public function create()
    {
        return view('admin.specification.create');
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

    public function fechCatspec($name)
    {
        $catId = Category::where('name', $name)->pluck('id')->first();

        $catspecs = Catspec::where('cat_id', $catId)->get();

        return response()->json($catspecs);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cat' => 'required',
            'catspec' => 'required',
        ]);

        $catId = Category::where('name', $request['cat'])->pluck('id')->first();

        Specification::create([
            'name' => $request['name'],
            'cat_id' => $catId,
            'catspec_id' => $request['catspec'],
        ]);

        return response()->json(['key' => 'value'], 200);
    }

    public function search(Request $request)
    {
        if (isset($request->id)) {
            $data = Specification::where('id', 'like', '%' . $request->id . '%')->orderBy('updated_at', 'desc')->with('cat')->paginate(15);
        }
        if (isset($request->name)) {
            $data = Specification::where('name', 'like', '%' . $request->name . '%')->orderBy('updated_at', 'desc')->with('cat', 'catspec')->paginate(15);
        }
        if (isset($request->cat)) {
            $id = Category::where('name', 'like', '%' . $request->cat . '%')->pluck('id')->first();
            $data = Specification::where('cat_id', $id)->orderBy('updated_at', 'desc')->with('cat', 'catspec')->paginate(15);
        }
        if (isset($request->catspec)) {

            $id = Catspec::where('name', 'like', '%' . $request->catspec . '%')->pluck('id')->first();
            $data = Specification::where('catspec_id', $id)->orderBy('updated_at', 'desc')->with('cat', 'catspec')->paginate(15);
        }


        return response()->json($data);
    }

    public function delete(Specification $id)
    {
        $id->delete();
        return response()->json(['key' => 'value'], 200);
    }
}
