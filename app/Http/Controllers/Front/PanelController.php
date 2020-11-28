<?php

namespace App\Http\Controllers\Front;

use App\Models\Holder;
use App\Models\User;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Cart_value;
use App\Models\Color;
use App\Models\Effect_price;
use App\Models\Effect_value;
use App\Models\Exist;
use App\Models\Off;
use App\Models\Order;
use App\Models\Order_value;
use App\Models\Product;
use App\Services\MessagingService;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PanelController extends Controller
{
    public function index()
    {
        return view('front.panel.order');
    }

    public function offs()
    {
        return view('front.panel.off');
    }

    public function fetchOrders()
    {
        $user = Auth::user()->id;

        $orders = Order::where('user_id', $user)->orderBy('updated_at', 'desc')->paginate(7);
        return response()->json($orders);
    }

    public function account()
    {
        return view('front.panel.account');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required'],
            'postal_code' => ['required'],
            'mobile' => ['required'],
            'state' => ['required'],
            'city' => ['required'],
            'address' => ['required'],
        ];

        $customMessages = [
            'name.required' => 'نام تحویل گیرنده الزامی است',
            'postal_code.required' => 'کد پستی الزامی است',
            'mobile.required' => 'شماره همراه الزامی است',
            'state.required' => 'انتخاب استان الزامی است',
            'city.required' => 'انتخاب شهر الزامی است',
            'address.required' => 'وارد کردن آدرس الزامی است',
        ];

        $this->validate($request, $rules, $customMessages);

        $user = Auth::user();

        $user->name = $request['name'];
        $user->mobile = $request['mobile'];
        $user->postal_code = $request['postal_code'];
        $user->city = $request['city'];
        $user->state = $request['state'];
        $user->address = $request['address'];
        $user->tell = $request['tell'];
        $user->shamsi_c = Verta::instance($user->created_at)->format('Y/n/j');
        $user->shamsi_u = Verta::instance($user->updated_at)->format('Y/n/j');
        $user->save();
        return response()->json(['key' => 'value'], 200);
    }

    public function fetchUser()
    {
        $user = Auth::user();
        if (!file_exists('images/user/profile/' . $user->image)) {
            $user->image = 'review-img.jpg';
            $user->save();
        }
        return response()->json($user);
    }

    public function fetchOffs()
    {
        $user = Auth::user();
        $now = Carbon::now();
        $orders = Order::where('user_id', $user->id)->get();

        if (isset($orders[0]->id)) {
            $sum = 0;
            foreach ($orders as $order) {
                $sum = $sum + $order->sum_final;
            }

            $offs = Off::where('min', '<', $sum)->whereDate('e_date', '>', $now)->get();

            foreach ($offs as $key => $off) {
                foreach ($orders as $order) {
                    if ($off->code == $order->off_code) {
                        unset($offs[$key]);
                    }
                }
            }
        } else {
            $offs = Off::where('min', 0)->whereDate('e_date', '>', $now)->get();
        }

        return response()->json($offs);
    }

    public function storeWithEffect($cart, $order)
    {
        $cart_values = $cart->cart_values;
        $product_id = $cart->product_id;
        $number = $cart->number;
        $order_id = $order->id;
        foreach ($cart_values as $cart_value) {
            $key = $cart_value->key;
            $value = $cart_value->effect_value->key;
            $off_percent = 0;

            $effectSpecId = Effect_value::where('product_id', $product_id)
                ->where('key', $value)->pluck('effect_spec_id')->first();

            $productId = sprintf("%'.04d", $product_id);
            $colorId = sprintf("%'.04d", $cart->color_id);
            $effectSpecId = sprintf("%'.03d", $effectSpecId);
            $productCode = "{$productId}{$colorId}{$effectSpecId}";
            $productName = Product::where('id', $product_id)->pluck('name')->first();
            $productDiscount = Product::where('id', $product_id)->pluck('discount')->first();
            $colorName = Color::where('id', $cart->color_id)->pluck('name')->first();
            $OrderValue = Order_value::create([
                'product_code' => $productCode,
                'key' => $key,
                'value' => $value,
                'product_name' => $productName,
                'color_name' => $colorName,
                'number' => $number,
                'discount' => $productDiscount,
                'order_id' => $order_id,
                'cart_id' => $cart_value->cart_id,
                'price' => $cart->price,
                'total' => $cart->total,
                'off_percent' => $off_percent,
            ]);
        }


        $exist = Exist::where('product_code', $OrderValue->product_code)->first();
        if (isset($exist->num)) {

            // ProductService::setInventoryTransaction($exist, ['type' => 'sell', 'user_phone' => Auth::user()->mobile], $OrderValue->number);

            $exist->num = $exist->num - $OrderValue->number;
            $exist->save();

            if ($exist->num == 0) {
                $exist->delete();
            }
        }

    }

    public function storeWithoutEffect($cart, $order)
    {
//        $product = Product::find($cart->product_id);
        $product_id = $cart->product_id;
        $number = $cart->number;
        $order_id = $order->id;
        $off_percent = 0;

        $productId = sprintf("%'.04d", $product_id);
        $colorId = sprintf("%'.04d", $cart->color_id);
        $effectSpecId = sprintf("%'.03d", 0);
        $productCode = "{$productId}{$colorId}{$effectSpecId}";
        $productName = Product::where('id', $product_id)->pluck('name')->first();
        $productDiscount = Product::where('id', $product_id)->pluck('discount')->first();
        $colorName = Color::where('id', $cart->color_id)->pluck('name')->first();
        $OrderValue = Order_value::create([
            'product_code' => $productCode,
            'product_name' => $productName,
            'color_name' => $colorName,
            'number' => $number,
            'discount' => $productDiscount,
            'order_id' => $order_id,
            'cart_id' => $cart->id,
            'price' => $cart->price,
            'total' => $cart->total,
            'off_percent' => $off_percent,
        ]);

        $exist = Exist::where('product_code', $OrderValue->product_code)->first();

        // ProductService::setInventoryTransaction($exist, ['type' => 'sell', 'user_phone' => Auth::user()->mobile], $OrderValue->number);

        $exist->num = $exist->num - $OrderValue->number;
        $exist->save();

        if ($exist->num == 0) {
            $exist->delete();
        }

    }

    public function storeOrder()
    {
        $order = Order::where('refid', session()->get('refid'))->first();
        if (isset($order->id)) {
            return false;
        }
        
        if (Session::has('order_id')) {
            $user = User::where('order_id', session()->get('order_id'))->first();
            
         
            
            $holder = Holder::where('user_id', $user->id)->latest('created_at')->first();
            
         
            
            $sum_final = $holder->sum_final - $holder->distance;

            $order = Order::create([
                'name' => $holder->name,
                'postal_code' => $holder->postal_code,
                'city' => $holder->city,
                'cell' => $holder->cell,
                'state' => $holder->state,
                'address' => $holder->address,
                'distance' => $holder->distance,
                'sum_final' => $sum_final,
                'user_id' => $user->id,
                'status' => 0,
                'refid' => session()->get('refid'),
                'authority' => session()->get('authority'),
            ]);

            $order->shamsi_c = Verta::instance($order->created_at)->format('Y/n/j');
            $order->shamsi_u = Verta::instance($order->updated_at)->format('Y/n/j');
            $order->save();

            $carts = Cart::where('cookie', $user->holder)->get();

        } else {
            $user = Auth::user()->id;
            $sum_final = session()->get('sum_final') - session()->get('distance');

            $order = Order::create([
                'name' => session()->get('name'),
                'postal_code' => session()->get('postal_code'),
                'city' => session()->get('city'),
                'cell' => session()->get('cell'),
                'state' => session()->get('state'),
                'address' => session()->get('address'),
                'distance' => session()->get('distance'),
                'sum_final' => $sum_final,
                'user_id' => $user,
                'status' => 0,
                'refid' => session()->get('refid'),
                'authority' => session()->get('authority'),
            ]);
            session()->forget([
                'name',
                'postal_code',
                'city',
                'cell',
                'state',
                'address',
                'tell',
                'distance',
                'sum_final',
                'user_id',
                'status',
                'refid',
                'authority',
            ]);
            $order->shamsi_c = Verta::instance($order->created_at)->format('Y/n/j');
            $order->shamsi_u = Verta::instance($order->updated_at)->format('Y/n/j');
            $order->save();

            $carts = Cart::where('cookie', $_COOKIE['cart'])->get();
        }





        foreach ($carts as $cart) {
            if (isset($cart->cart_values[0]->id)) {
                $this->storeWithEffect($cart, $order);
            } else {
                $this->storeWithoutEffect($cart, $order);
            }
        }
        
//        SMS
        $mobile = $order['cell'] ?? $user['mobile'];
        MessagingService::sendCustomerSms($mobile, $order['id']);
        MessagingService::sendAdminSms($order['id'], $order['sum_final'] + $order['distance']);
//        SMS

    }

}
