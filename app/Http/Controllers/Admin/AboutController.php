<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;

use App\Models\Effect_spec;
use App\Models\Key;
use App\Models\Product;
use Illuminate\Http\Request;


class AboutController extends Controller
{
    public function create()
    {
        return view('admin.about.create');
    }

    public function update(Request $request)
    {
        Key::where('key', 'about')->update([
            'value' => $request['about'],
        ]);

        Key::where('key', 'contact')->update([
            'value' => $request['contact'],
        ]);

        Key::where('key', 'rolls')->update([
            'value' => $request['rolls'],
        ]);

        Key::where('key', 'delivery')->update([
            'value' => $request['delivery'],
        ]);
        Key::where('key', 'online')->update([
            'value' => $request['online'],
        ]);

        return response()->json(['key' => 'value'], 200);
    }

    public function fetch()
    {
        $about = Key::where('key', 'about')->pluck('value')->first();
        $contact = Key::where('key', 'contact')->pluck('value')->first();
        $rolls = Key::where('key', 'rolls')->pluck('value')->first();
        $delivery = Key::where('key', 'delivery')->pluck('value')->first();
        $online = Key::where('key', 'online')->pluck('value')->first();

        return response()->json([
            'about' => $about,
            'contact' => $contact,
            'rolls' => $rolls,
            'delivery' => $delivery,
            'online' => $online,
        ]);
    }
}
