<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    public function fetch()
    {
        $roles = Role::orderBy('updated_at', 'desc')->paginate(7);
        return response()->json($roles);
    }

    public function getPermission()
    {
        $permissions = Permission::orderBy('updated_at', 'desc')->get();
        return response()->json($permissions);
    }

    public function create()
    {
        return view('admin.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'permissions' => 'required',
        ]);

        $x=Role::where('name',$request['name'])->first();
        if(isset($x)){
            $x->permissions()->detach();
            $x->delete();
        }

        $role=Role::create([
            'name' => $request['name'],
            'title' => $request['title'],
        ]);
        $role->permissions()->attach($request['permissions']);

        return response()->json(['key' => 'value'], 200);
    }

    public function delete(Role $id)
    {
        $id->delete();
        return response()->json(['key' => 'value'], 200);
    }

    public function search(Request $request)
    {

        if (isset($request->id)) {
            $data = Role::where('id', 'like', '%' . $request->id . '%')->paginate(7);
        }
        if (isset($request->name)) {
            $data = Role::where('name', 'like', '%' . $request->name . '%')->paginate(7);
        }
        if (isset($request->title)) {
            $data = Role::where('title', 'like', '%' . $request->title . '%')->paginate(7);
        }

        return response()->json($data);
    }

    public function fetchPermission(Role $id)
    {

        $a = $id->permissions;
        $permissions=array();
        foreach ($a as $permission){
            array_push($permissions,$permission->title);
        }
        $permissions=implode(" - ",$permissions);

        Log::info($permissions);

        return response()->json($permissions);

    }
}
