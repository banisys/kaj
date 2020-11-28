<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Catspec;
use App\Models\Specification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class SpecopyController extends Controller
{
    public function create()
    {
        return view('admin.specopy.create');
    }

    public function store(Request $request)
    {
        $from = Category::where('name', $request['from'])->first();
        $to = Category::where('name', $request['to'])->first();

        $fromCatspecs = Catspec::where('cat_id', $from->id)->get();
        $toCatspecs = Catspec::where('cat_id', $to->id)->first();

        if (isset($toCatspecs->id)) {
            return response()->json(['key' => 'value'], 200);
        }

        foreach ($fromCatspecs as $fromCatspec) {
            $catspec = Catspec::create([
                'name' => $fromCatspec->name,
                'cat_id' => $to->id,
            ]);

            $fromSpecifications = Specification::where('cat_id', $from->id)
                ->where('catspec_id', $fromCatspec->id)->get();

            foreach ($fromSpecifications as $fromSpecification) {
                Specification::create([
                    'name' => $fromSpecification->name,
                    'cat_id' => $to->id,
                    'catspec_id' => $catspec->id,
                ]);
            }
        }

        return response()->json(['key' => 'value'], 200);
    }
}
