<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Support\Str;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function create()
    {
        return view('admin.page.create');
    }

    public function index()
    {
        return view('admin.page.index');
    }

    public function fetchCat()
    {
        $xx = Category::whereNotNull('parent')->where('type', 'page')->get('parent');
        $y = array();
        foreach ($xx as $x) {
            array_push($y, $x->parent);
        }
        $parent = array_unique($y);

        $child = Category::whereNotIn('id', $parent)->where('type', 'page')->get();
        return response()->json($child);
    }

    public function store(Request $request)
    {
        $titles = json_decode($request['titles']);
        $a = array();
        foreach ($titles as $key => $title) {
            array_push($a, $title->name);
        }
        $json=json_encode($a);

        $admin_id = auth('admin')->user()->id;
        $random1 = Str::random(3);
        $imageName = $random1 . time() . '.' . $request->image->getClientOriginalName();
        $request->image->move(bath_path('images/page'), $imageName);

        $product = Page::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'cat_id' => $request['cat'],
            'seo_title' => $request['seo_title'],
            'seo_key' => $request['seo_key'],
            'seo_description' => $request['seo_description'],
            'image' => $imageName,
            'url' => $request['url'],
            'admin_id' => $admin_id,
            'titles' => $json,
        ]);

        $product->shamsi_c = Verta::instance($product->created_at)->format('Y/n/j');
        $product->shamsi_u = Verta::instance($product->updated_at)->format('Y/n/j');
        $product->save();

        return response()->json(['key' => 'value'], 200);
    }

    public function fetchPages()
    {
        $pages = Page::orderBy('updated_at', 'desc')->with('cat')->paginate(7);
        return response()->json($pages);
    }

    public function search(Request $request)
    {
        if (isset($request->cat)) {
            if ($request->cat === '999999') {
                $data = Page::with('cat')->orderBy('created_at', 'desc')->paginate(7);
            } else {
                $data = Page::where('cat_id', $request->cat)->with('cat')->orderBy('created_at', 'desc')->paginate(7);
            }
        }
        if (isset($request->name)) {
            $data = Page::where('name', 'like', '%' . $request->name . '%')->with('cat')
                ->orderBy('created_at', 'desc')->paginate(7);
        }

        return response()->json($data);
    }

    public function delete($id)
    {
        $page = Page::find($id);
        $image = 'images/page/' . $page->image;
        $rr = file_exists($image);
        if ($rr == 1) {
            unlink($image);
        }
        $page->delete();

        return response()->json(['key' => 'value'], 200);
    }

    public function edit()
    {
        return view('admin.page.edit');
    }

    public function fetchPage($id)
    {
        $page = Page::where('id', $id)->with('cat')->first();
        return response()->json($page);
    }

    public function update(Request $request, $id)
    {
        $page = Page::find($id);
        $titles = json_decode($request['titles']);
        if(isset($titles[0])){
            $a = array();
            foreach ($titles as $key => $title) {
                array_push($a, $title->name);
            }
            $json=json_encode($a);
            Log::info($json);
            $page->titles = $json;
            $page->save();
        }

        $page = Page::find($id);
        if ($request->image != $page->image) {
            $img = 'images/page/' . $page->image;
            unlink($img);
            $imageName = time() . '.' . $request->image->getClientOriginalName();
            $request->image->move(bath_path('images/page'), $imageName);
            $page->image = $imageName;
        }

        $page->name = $request->name;
        $page->url = $request->url;
        $page->description = $request->description;
        $page->cat_id = $request->cat;
        $page->seo_title = $request->seo_title;
        $page->seo_description = $request->seo_description;
        $page->seo_key = $request->seo_key;
        $page->shamsi_u = Verta::instance($page->updated_at)->format('Y/n/j');

        $page->save();

        return response()->json(['key' => 'value'], 200);
    }

}
