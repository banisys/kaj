<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Str;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function create()
    {
        return view('admin.blog.create');
    }

    public function index()
    {
        return view('admin.blog.index');
    }

    public function fetchCat()
    {
        $xx = Category::whereNotNull('parent')->where('type', 'blog')->get('parent');
        $y = array();
        foreach ($xx as $x) {
            array_push($y, $x->parent);
        }
        $parent = array_unique($y);

        $child = Category::whereNotIn('id', $parent)->where('type', 'blog')->get();
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
        $request->image->move(base_path('images/blog'), $imageName);

        $product = Blog::create([
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

    public function fetchBlogs()
    {
        $blogs = Blog::orderBy('updated_at', 'desc')->with('cat')->paginate(7);
        return response()->json($blogs);
    }

    public function search(Request $request)
    {
        if (isset($request->cat)) {
            if ($request->cat === '999999') {
                $data = Blog::with('cat')->orderBy('created_at', 'desc')->paginate(7);
            } else {
                $data = Blog::where('cat_id', $request->cat)->with('cat')->orderBy('created_at', 'desc')->paginate(7);
            }
        }
        if (isset($request->name)) {
            $data = Blog::where('name', 'like', '%' . $request->name . '%')->with('cat')
                ->orderBy('created_at', 'desc')->paginate(7);
        }

        return response()->json($data);
    }

    public function delete($id)
    {
        $blog = Blog::find($id);
        $image = 'images/blog/' . $blog->image;
        $rr = file_exists($image);
        if ($rr == 1) {
            unlink($image);
        }
        $blog->delete();

        return response()->json(['key' => 'value'], 200);
    }

    public function edit()
    {
        return view('admin.blog.edit');
    }

    public function fetchBlog($id)
    {
        $blog = Blog::where('id', $id)->with('cat')->first();
        return response()->json($blog);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        $titles = json_decode($request['titles']);
        if(isset($titles[0])){
            $a = array();
            foreach ($titles as $key => $title) {
                array_push($a, $title->name);
            }
            $json=json_encode($a);
            $blog->titles = $json;
            $blog->save();
        }

        $blog = Blog::find($id);
        if ($request->image != $blog->image) {
            $img = 'images/blog/' . $blog->image;
            unlink($img);
            $imageName = time() . '.' . $request->image->getClientOriginalName();
            $request->image->move(base_path('images/blog'), $imageName);
            $blog->image = $imageName;
        }

        $blog->name = $request->name;
        $blog->url = $request->url;
        $blog->description = $request->description;
        $blog->cat_id = $request->cat;
        $blog->seo_title = $request->seo_title;
        $blog->seo_description = $request->seo_description;
        $blog->seo_key = $request->seo_key;
        $blog->shamsi_u = Verta::instance($blog->updated_at)->format('Y/n/j');

        $blog->save();

        return response()->json(['key' => 'value'], 200);
    }

}
