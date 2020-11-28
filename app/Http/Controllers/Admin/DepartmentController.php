<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class DepartmentController extends Controller
{
    public function create(){
        return view('admin.department.create');
    }
    public function fetchDepartment(){
        $data = Department::orderBy('updated_at', 'desc')->paginate(7);
        return response()->json($data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $data = Department::create([
            'name'=>$request['name'],
        ]);
        return response()->json($data);
    }
    public function delete($id){
        $data = Department::find($id);
        $data->delete();
        return response()->json($data);
    }
    public function search(Request $request){
        $data = Department::where('name','LIKE','%' . $request['name'] . '%')->paginate(7);
        return response()->json($data);
    }
}
