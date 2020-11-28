<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:admin', ['only' => 'index', 'edit']);
    }

    public function fetch()
    {
        $admins = Admin::orderBy('updated_at', 'desc')->paginate(7);
        return response()->json($admins);
    }

    public function search(Request $request)
    {

        if (isset($request->id)) {
            $data = Admin::where('id', 'like', '%' . $request->id . '%')->orderBy('updated_at', 'desc')->paginate(7);
        }
        if (isset($request->name)) {
            $data = Admin::where('name', 'like', '%' . $request->name . '%')->orderBy('updated_at', 'desc')->paginate(7);
        }
        if (isset($request->email)) {
            $data = Admin::where('email', 'like', '%' . $request->email . '%')->orderBy('updated_at', 'desc')->paginate(7);
        }

        return response()->json($data);
    }

    public function index(Request $request)
    {
        $users = Admin::search($request->all());
        if (sizeof($users) == 0) $x = 0;
        else $x = 1;

        return view('admin.user.index', compact('users', 'x'));
    }

    public function create()
    {
        return view('admin.auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:2', 'confirmed'],
            'roles' => 'required',
        ]);

        $x = Admin::where('email', $request['email'])->first();
        if (isset($x)) {
            $x->roles()->detach();
            $x->delete();
        }

        $admin = Admin::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        $admin->roles()->attach($request['roles']);

        return response()->json(['key' => 'value'], 200);
    }

    public function getRoles()
    {
        $roles = Role::orderBy('updated_at', 'desc')->get();
        return response()->json($roles);
    }

    public function fetchRole(Admin $id)
    {
        $a = $id->roles;
        $roles = array();
        foreach ($a as $role) {
            array_push($roles, $role->title);
        }
        $roles = implode(" - ", $roles);

        return response()->json($roles);
    }

    public function delete(Admin $id)
    {
        $id->roles()->detach();
        $id->delete();
        return response()->json(['key' => 'value'], 200);
    }

    public function dashboard()
    {
        $farvardin = Order::where('shamsi_c', 'like', '1398/1/%')->sum('sum_final');
        $ordibehesht = Order::where('shamsi_c', 'like', '1398/2/%')->sum('sum_final');
        $khordad = Order::where('shamsi_c', 'like', '1398/3/%')->sum('sum_final');
        $tir = Order::where('shamsi_c', 'like', '1398/4/%')->sum('sum_final');
        $mordad = Order::where('shamsi_c', 'like', '1398/5/%')->sum('sum_final');
        $shahrivar = Order::where('shamsi_c', 'like', '1398/6/%')->sum('sum_final');
        $mehr = Order::where('shamsi_c', 'like', '1398/7/%')->sum('sum_final');
        $aban = Order::where('shamsi_c', 'like', '1398/8/%')->sum('sum_final');
        $azar = Order::where('shamsi_c', 'like', '1398/9/%')->sum('sum_final');
        $dey = Order::where('shamsi_c', 'like', '1398/10/%')->sum('sum_final');
        $bahman = Order::where('shamsi_c', 'like', '1398/11/%')->sum('sum_final');
        $esfand = Order::where('shamsi_c', 'like', '1398/12/%')->sum('sum_final');

        return view('admin.dashboard',
            compact('farvardin', 'ordibehesht', 'khordad', 'tir', 'mordad',
                'shahrivar', 'mehr', 'aban', 'azar', 'dey', 'bahman', 'esfand')
        );
    }
}