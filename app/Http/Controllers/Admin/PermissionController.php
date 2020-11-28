<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
    public function fetch()
    {
        $permissions = Permission::orderBy('updated_at', 'desc')->paginate(7);

        return response()->json($permissions);
       

    }

    public function create()
    {
        return view('admin.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
        ]);

        permission::create([
            'name'=>$request['name'],
            'title'=>$request['title'],
        ]);
        return response()->json(['key' => 'value'], 200);
    }

    public function delete(Permission $id)
    {
    //     $id->delete();
    //     return response()->json(['key' => 'value'], 200);
    return response()->json(['key' => 'value'], 503);
    // }
}

    public function search(Request $request)
    {

        if (isset($request->id)){
            $data = Permission::where('id','like','%'.$request->id.'%')->paginate(7);
        }
        if (isset($request->name)){
            $data = Permission::where('name','like','%'.$request->name.'%')->paginate(7);
        }
        if (isset($request->title)){
            $data = Permission::where('title','like','%'.$request->title.'%')->paginate(7);
        }

        return response()->json($data);
    }
}
