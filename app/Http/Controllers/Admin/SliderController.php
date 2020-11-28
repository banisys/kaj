<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class SliderController extends Controller
{
    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(Request $request)
    {
        $urls = json_decode($request->urls);
        $index = 0;
        foreach ($urls as $key => $url) {

            $random = Str::random(3);
            $imageName = $random . time() . '.' . $request->pics[$index]->getClientOriginalName();
            $request->pics[$index]->move(public_path('images/slider'), $imageName);
            Slider::create([
                'url' => $url->url,
                'image' => $imageName
            ]);
            $index++;
        }

        return response()->json(['key' => 'value'], 200);
    }

    public function slideFetch()
    {
        $slider = Slider::get();

        return response()->json($slider);
    }

    public function delete($id)
    {
        $slide = Slider::find($id);

        $string_1 = 'images/slider/' . $slide->image;
        unlink($string_1);
        $slide->delete();

    }

}
