<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Catspec;
use App\Models\Filter;
use App\Models\Filter_cat;
use App\Models\Specification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FilterController extends Controller
{
    public function filterCatCreate()
    {
        return view('admin.filter.filter_cat');
    }

    public function storeFilterCat(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cat' => 'required',
        ]);

        Filter_cat::create([
            'name' => $request['name'],
            'cat_id' => $request['cat'],
        ]);

        return response()->json(['key' => 'value'], 200);
    }

    public function fetchFilterCat()
    {
        $filter = Filter_cat::orderBy('updated_at', 'desc')->with('cat')->paginate(7);
        return response()->json($filter);
    }

    public function delete(Filter_cat $id)
    {
        $id->delete();
        return response()->json(['key' => 'value'], 200);
    }

    public function filterCreate()
    {
        return view('admin.filter.filter');
    }

    public function FilterCat($cat_id)
    {
        $filterCat = Filter_cat::where('cat_id', $cat_id)->get();

        return response()->json($filterCat);
    }

    public function fetchFilter()
    {
        $filters = Filter::orderBy('updated_at', 'desc')->with('cat')->with('filter_cat')->paginate(7);

        return response()->json($filters);
    }

    public function storeFilter(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cat' => 'required',
        ]);

//        $catId = Category::where('name', $request['cat'])->pluck('id')->first();

        Filter::create([
            'name' => $request['name'],
            'cat_id' => $request['cat'],
            'filter_cat_id' => $request['filter_cat'],
        ]);

        return response()->json(['key' => 'value'], 200);
    }

    public function deleteFilter(Filter $id)
    {
        Log::info("ssss");
        $id->delete();
        return response()->json(['key' => 'value'], 200);
    }

    public function fetchFilterCat2($id)
    {
        $specification = Specification::where('cat_id', $id)->get();

        return response()->json($specification);
    }

}
