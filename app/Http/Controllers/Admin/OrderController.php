<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exist;
use App\Models\Order;
use App\Models\Order_value;
use App\Models\User;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.order.index');
    }

    public function fetch()
    {
        $orders = Order::orderBy('created_at', 'desc')->with('order_values')
            ->with('user')
            ->paginate(100);
        return response()->json($orders);
    }

    public function fetchNotConfirm()
    {
        $orders = Order::whereNull('confirm')->orderBy('created_at', 'desc')->with('order_values')
            ->with('user')
            ->paginate(7);
        return response()->json($orders);
    }

    public function fetchConfirm()
    {
        $orders = Order::whereNotNull('confirm')->orderBy('created_at', 'desc')->with('order_values')
            ->with('user')
            ->paginate(7);
        return response()->json($orders);
    }

    public function changeStatus(Request $request, $id)
    {
        $order = Order::where('id', $id)->with('order_values')->first();

//        if($request['status'] == 1){
//            foreach ($order->order_values as $item) {
//                $exist = Exist::where('product_code', $item->product_code)->first();
//                $exist->num = $exist->num - $item->number;
//                $exist->save();
//            }
//        }

        $order->status = $request['status'];
        $order->save();

        return response()->json(['key' => 'value'], 200);
    }

    public function search(Request $request)
    {
        $data = null;
        if (isset($request->id)) {
            $data = Order::where('id', $request->id)->with('order_values')->with('user')
                ->orderBy('created_at', 'desc')->paginate(999);
        }

        if (isset($request->name)) {
            $data = Order::where('name', $request->name)->with('order_values')->with('user')
                ->orderBy('created_at', 'desc')->paginate(999);
        }

        if (isset($request->mobile)) {
            $user = User::where('mobile', $request->mobile)->first();
            if (isset($user)) {
                $data = Order::where('user_id', $user->id)->with('order_values')->with('user')
                    ->orderBy('created_at', 'desc')->paginate(999);
            }
        }

        if (isset($request->state)) {
            $data = Order::where('state', 'like', $request->state . '%')->with('order_values')->with('user')
                ->orderBy('created_at', 'desc')->paginate(999);
        }

        if (isset($request->refid)) {
            $data = Order::where('refid', $request->refid)->with('order_values')->with('user')
                ->orderBy('created_at', 'desc')->paginate(999);
        }

        if (isset($request->shamsi_c)) {
            $data = Order::where('shamsi_c', 'like', $request->shamsi_c . '%')->with('order_values')->with('user')
                ->orderBy('created_at', 'desc')->paginate(999);
        }
        if (isset($request->status)) {

            $data = Order::where('status', $request->status)->with('order_values')->with('user')
                ->orderBy('created_at', 'desc')->paginate(999);
        }

        if (isset($request->shamsiless)) {
            $explode = explode("/", $request->shamsiless);
            $date = Verta::getGregorian($explode[0], $explode[1], $explode[2]);
            $date = implode("-", $date);

            if (isset($date)) {
                $data = Order::whereDate('created_at', '<', $date)->with('order_values')->with('user')
                    ->orderBy('created_at', 'desc')->paginate(999);
            }
        }

        if (isset($request->shamsimore)) {
            $explode = explode("/", $request->shamsimore);
            $date = Verta::getGregorian($explode[0], $explode[1], $explode[2]);
            $date = implode("-", $date);

            if (isset($date)) {
                $data = Order::whereDate('created_at', '>', $date)->with('order_values')->with('user')
                    ->orderBy('created_at', 'desc')->paginate(999);
            }
        }

        return response()->json($data);
    }

    public function delete($id)
    {
        $order = Order::where('id', $id)->first();

        $order->order_values()->delete();
        $order->delete();

        return response()->json(['key' => 'value'], 200);
    }

    public function factor()
    {
        return view('front.factor');
    }

    public function fetchOrder($id)
    {
        $order = Order::where('id', $id)->first();

        return response()->json($order);
    }

    public function fetchOrderValue($id)
    {
        $order_values = Order_value::where('order_id', $id)->with('color')->with('product')->get();
        $order_values = $order_values->groupBy('cart_id');

        return response()->json($order_values);
    }

    public function sumPrice($id)
    {
        $orders = Order_value::where('order_id', $id)->get();
        $orders = $orders->groupBy('cart_id');
        $sum = 0;
        foreach ($orders as $order) {
            $price = $order[0]->number * $order[0]->price;
            $sum = $price + $sum;
        }

        return response()->json($sum);
    }

    public function factorConfirm($id)
    {
        Order::where('id', $id)->update(['confirm' => 1]);
        $orderId = Order::where('id', $id)->pluck('id')->first();
        $OrderValues = Order_value::where('order_id', $orderId)->get(['product_code', 'number']);

        foreach ($OrderValues as $OrderValue) {
            $num = Exist::where('product_code', $OrderValue->product_code)->pluck('num')->first();
            $result = $num - $OrderValue->number;
            Exist::where('product_code', $OrderValue->product_code)->update(['num' => $result]);
        }

        return response()->json(['key' => 'value'], 200);
    }

    public function fetchNumber($id)
    {
        $sum = Order_value::where('order_id', $id)->sum('number');

        return response()->json($sum);
    }
}
