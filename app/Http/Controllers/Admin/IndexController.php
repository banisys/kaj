<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Index;
use App\Models\Slider;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class IndexController extends Controller
{
    public function create()
    {
        return view('admin.index.create');
    }

    public function imageStore(Request $request)
    {
        $random = Str::random(3);
        $imageName = $random . time() . '.' . $request->image->getClientOriginalName();
        $request->image->move(base_path('images/index'), $imageName);

        $index = Index::where('index', $request['index'])->first();

        $image = 'images/index/' . $index->image;
        $rr = file_exists($image);

        if ($rr == 1) {
            unlink($image);
        }

        $index->image = $imageName;
        $index->save();

        return response()->json(['key' => 'value'], 200);
    }

    public function urlStore(Request $request)
    {
        Index::where('index', 1)->update(['url' => $request['one']]);
        Index::where('index', 2)->update(['url' => $request['tow']]);
        Index::where('index', 3)->update(['url' => $request['three']]);
        Index::where('index', 4)->update(['url' => $request['four']]);
        Index::where('index', 5)->update(['url' => $request['five']]);
        Index::where('index', 6)->update(['url' => $request['six']]);

        return response()->json(['key' => 'value'], 200);
    }

    public function fetchImage()
    {
        $i1 = Index::where('index', 1)->first();
        $i2 = Index::where('index', 2)->first();
        $i3 = Index::where('index', 3)->first();
        $i4 = Index::where('index', 4)->first();
        $i5 = Index::where('index', 5)->first();

        return response()->json([
            'i1' => $i1,
            'i2' => $i2,
            'i3' => $i3,
            'i4' => $i4,
            'i5' => $i5,
        ], 200);
    }

    public function showComplaint()
    {
        return view('admin.complaint.create');
    }

    public function fetchComplaint()
    {
        $complaints = Complaint::get();

        return response()->json($complaints, 200);
    }

    public function showTicketComplaint($id)
    {
        $ticket = Complaint::where('id', $id)->pluck('ticket')->first();

        return response()->json($ticket, 200);
    }

}
