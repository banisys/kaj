<?php

namespace App\Http\Controllers;

use App\Models\Catspec;
use App\Models\Color;
use App\Models\Product;
use App\Models\Role;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $x=Color::where('id',93)->with('product')->first();
//        $y=Verta::instance($x->created_at)->format('Y/n/j');
        dd($x);
        return view('home');
    }

}
