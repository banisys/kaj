<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ImageController extends Controller
{
    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $admin_id = auth('admin')->user()->id;

        foreach ($request->pics as $pic) {
            $random = Str::random(3);
            $imageName = $random . time() . '.' . $pic->getClientOriginalName();
            $pic->move(base_path('uploads/image'), $imageName);
            Image::create([
                'image' => $imageName,
                'admin_id' => $admin_id,
            ]);
        }

        return response()->json(['key' => 'value'], 200);
    }
}