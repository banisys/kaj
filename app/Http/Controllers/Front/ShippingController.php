<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Cart_value;
use App\Models\Color;
use App\Models\Effect_value;
use App\Models\Holder;
use App\Models\Off;
use App\Models\Order;
use App\Models\Order_value;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SoapClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ShippingController extends Controller
{
    public function index()
    {
        $carts = Cart::where('cookie', $_COOKIE['cart'])->get();

        foreach ($carts as $cart) {
            $cart->user_id = auth()->user()->id;
            $cart->save();
        }


        return view('front.shipping');
    }

    public function store(Request $request)
    {
        $user = Auth::user()->id;
        $off = Off::where('code', $request['code'])->first();
        $delivery = explode("+", $request['delivery_time']);

        $order = Order::create([
            'name' => $request['name'],
            'postal_code' => $request['postal_code'],
            'city' => $request['city'],
            'cell' => $request['cell'],
            'state' => $request['state'],
            'address' => $request['address'],
            'lat' => $request['lat'],
            'lon' => $request['lon'],
            'distance' => $request['distance'],
            'sum_final' => $request['sum_final'],
            'delivery_date' => $delivery[0],
            'delivery_time' => $delivery[1],
            'user_id' => $user,
            'status' => 0,
            'off_code' => $request['code'],
        ]);

        $order->shamsi_c = Verta::instance($order->created_at)->format('Y/n/j');
        $order->shamsi_u = Verta::instance($order->updated_at)->format('Y/n/j');
        $order->save();

        $carts = Cart::where('cookie', $_COOKIE['cart'])->get();

        if (isset($carts[0]->cart_values[0]->id)) {
            $this->storeWithEffect($carts, $order, $off);
        } else {
            $this->storeWithoutEffect($carts, $order, $off);
        }

        $mustBeDeleted = Cart::where('cookie', $_COOKIE['cart'])->get();
        foreach ($mustBeDeleted as $item) {
            Cart_value::where('cart_id', $item->id)->delete();
        }
        Cart::where('cookie', $_COOKIE['cart'])->delete();

        return response()->json(['key' => 'value'], 200);
    }

    public function fetchDate()
    {
        $now1 = Carbon::now();
        $now2 = Carbon::now();
        $date1 = $now1->addDays(2);
        $date2 = $now2->addDays(3);

        $date1 = Verta::instance($date1)->format('Y/n/j');
        $date2 = Verta::instance($date2)->format('Y/n/j');

        return response()->json([$date1, $date2], 200);
    }

    public function sumTotal()
    {
        $carts = Cart::where('cookie', $_COOKIE['cart'])->get();

        $sum = 0;
        foreach ($carts as $cart) {
            $sum = $cart->total + $sum;
        }

        return response()->json($sum);
    }

    public function validShipping(Request $request)
    {
        $rules = [
            'name' => 'required',
            'postal_code' => 'required',
            'city' => 'required',
            'cell' => 'required',
            'state' => 'required',
            'address' => 'required',
        ];

        $customMessages = [
            'name.required' => 'نام تحویل گیرنده الزامی است',
            'postal_code.required' => 'کد پستی الزامی است',
            'city.required' => 'انتخاب شهر الزامی است',
            'state.required' => 'انتخاب استان الزامی است',
            'state..required' => 'آدرس الزامی است',
            'cell.required' => 'شماره همراه الزامی است',
        ];

        $this->validate($request, $rules, $customMessages);

        return response()->json(['key' => 'value'], 200);
    }

    public function off(Request $request)
    {
        $now = Carbon::now();
        $carts = Cart::where('cookie', $_COOKIE['cart'])->get();
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->get();

        if (isset($orders[0])) {
            $sum2 = 0;
            foreach ($orders as $order) {
                $sum2 = $sum2 + $order->sum_final;
            }
            $off = Off::where('code', $request['code'])->where('min', '<', $sum2)
                ->whereDate('e_date', '>', $now)->first();
        } else {
            $off = Off::where('code', $request['code'])->where('min', '0')
                ->whereDate('e_date', '>', $now)->first();
        }

        $sum = $request['sum_final'];
        if (isset($off['id'])) {
            foreach ($carts as $cart) {
                $cat = $cart->product->cat->name;
                $brand = $cart->product->brand;
                if ($off->category == "0" && $off->brand == "0") {
                    $diff = 100 - $off->percent;
                    $one = $cart->total / 100;
                    $result = $one * $diff;
                    $hhh = $cart->total - $result;
                    $sum = $sum - $hhh;
                } else {
                    if ($off->category == "0") {
                        if ($off->brand == $brand) {
                            $diff = 100 - $off->percent;
                            $one = $cart->total / 100;
                            $result = $one * $diff;
                            $hhh = $cart->total - $result;
                            $sum = $sum - $hhh;
                        }
                    } elseif ($off->brand == "0") {
                        if ($off->category == $cat) {
                            $diff = 100 - $off->percent;
                            $one = $cart->total / 100;
                            $result = $one * $diff;
                            $hhh = $cart->total - $result;
                            $sum = $sum - $hhh;
                        }
                    } else {
                        if ($off->category == $cat || $off->brand == $brand) {
                            $diff = 100 - $off->percent;
                            $one = $cart->total / 100;
                            $result = $one * $diff;
                            $hhh = $cart->total - $result;
                            $sum = $sum - $hhh;
                        }
                    }
                }
            }
            if ($sum == $request['sum_final']) {
                $sum = 'nothing';
            }
        } else {
            $sum = 0;
        }

        $orders2 = Order::where('user_id', $user->id)->where('off_code', $request['code'])->get();
        if (isset($orders2[0])) {
            $sum = 0;
        }

        return response()->json($sum);
    }

    public function fetchOrder($id)
    {
        $order = Order::where('id', $id)->first();

        return response()->json($order);
    }

    public function storeWithEffect($carts, $order, $off)
    {
        foreach ($carts as $cart) {
            $cart_values = $cart->cart_values;
            $product_id = $cart->product_id;
            $number = $cart->number;
            $order_id = $order->id;
            foreach ($cart_values as $cart_value) {
                $key = $cart_value->key;
                $value = $cart_value->effect_value->key;
                $off_percent = 0;

                if (isset($off->id)) {
                    if ($off->category == "0" && $off->brand == "0") {
                        $off_percent = $off->percent;
                    } else {
                        if ($off->category === "0") {
                            if ($off->brand == $cart_value->product->brand) {
                                $off_percent = $off->percent;
                            }
                        } elseif ($off->brand === "0") {
                            if ($off->category == $cart_value->product->cat->name) {
                                $off_percent = $off->percent;
                            }
                        } else {
                            if ($off->category == $cart_value->product->cat->name || $off->brand == $cart_value->product->brand) {
                                $off_percent = $off->percent;
                            }
                        }
                    }
                } else {
                    $off_percent = 0;
                }

                $effectSpecId = Effect_value::where('product_id', $product_id)
                    ->where('key', $value)->pluck('effect_spec_id')->first();

                $productId = sprintf("%'.04d", $product_id);
                $colorId = sprintf("%'.04d", $cart->color_id);
                $effectSpecId = sprintf("%'.03d", $effectSpecId);
                $productCode = "{$productId}{$colorId}{$effectSpecId}";
                $productName = Product::where('id', $product_id)->pluck('name')->first();
                $productDiscount = Product::where('id', $product_id)->pluck('discount')->first();
                $colorName = Color::where('id', $cart->color_id)->pluck('name')->first();
                Order_value::create([
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
        }
    }

    public function storeWithoutEffect($carts, $order, $off)
    {
        foreach ($carts as $cart) {
            $product = Product::find($cart->product_id);
            $product_id = $cart->product_id;
            $number = $cart->number;
            $order_id = $order->id;
            $off_percent = 0;

            if (isset($off->id)) {
                if ($off->category == "0" && $off->brand == "0") {
                    $off_percent = $off->percent;
                } else {
                    if ($off->category === "0") {
                        if ($off->brand == $product->brand) {
                            $off_percent = $off->percent;
                        }
                    } elseif ($off->brand === "0") {
                        if ($off->category == $product->cat->name) {
                            $off_percent = $off->percent;
                        }
                    } else {
                        if ($off->category == $product->cat->name || $off->brand == $product->brand) {
                            $off_percent = $off->percent;
                        }
                    }
                }
            } else {
                $off_percent = 0;
            }

            $productId = sprintf("%'.04d", $product_id);
            $colorId = sprintf("%'.04d", $cart->color_id);
//            $effectSpecId = sprintf("%'.03d", 0);
            $productCode = "{$productId}{$colorId}";
            $productName = Product::where('id', $product_id)->pluck('name')->first();
            $productDiscount = Product::where('id', $product_id)->pluck('discount')->first();
            $colorName = Color::where('id', $cart->color_id)->pluck('name')->first();
            Order_value::create([
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
        }
    }

    public function epayStoreSession(Request $request)
    {
        $user = Auth::user()->id;

        session()->forget('distance');
        session()->forget('sum_final');

        session()->put('name', $request['name']);
        session()->put('postal_code', $request['postal_code']);
        session()->put('city', $request['city']);
        session()->put('cell', $request['cell']);
        session()->put('state', $request['state']);
        session()->put('address', $request['address']);
        session()->put('distance', $request['distance']);
        session()->put('sum_final', $request['sum_final']);
        session()->put('user_id', $user);
        session()->put('status', 0);

        Holder::create([
            'name' => $request['name'],
            'postal_code' => $request['postal_code'],
            'city' => $request['city'],
            'cell' => $request['cell'],
            'state' => $request['state'],
            'address' => $request['address'],
            'distance' => $request['distance'],
            'sum_final' => $request['sum_final'],
            'user_id' => $user,
            'status' => $request['status'],
        ]);

        return response()->json(['key' => 'value'], 200);
    }

    public function redirectToZarinpal(Request $request)
    {
        $user = User::find(auth()->user()->id);

        $user->holder = $_COOKIE["cart"];

        $user->save();
        $MerchantID = '7e0c3e5e-77d3-421d-ae62-f8e64310c080';
        $Amount2 = session()->get('sum_final');
        $Description = 'نام شرکت';
        $CallbackURL = url("/order/return/zarinpal");
        $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

        $result = $client->PaymentRequest([
            'MerchantID' => $MerchantID,
            'Amount' => $Amount2,
            'Description' => $Description,
            'CallbackURL' => $CallbackURL,
        ]);
        session()->put('authority', $result->Authority);
        //Redirect to URL You can do it also by creating a form
        if ($result->Status == 100) {
            return redirect()->away('https://www.zarinpal.com/pg/StartPay/' . $result->Authority);
        } else {
            echo 'ERR: ' . $result->Status;
        }
    }

    public function redirectToSadad(Request $request)
    {
        $user = User::find(auth()->user()->id);

        $user->holder = $_COOKIE["cart"];
        $OrderId = time() . mt_rand(1, 3222); // شماره سفارش را در دیتابیس ذخیره کنید به عنوان یک سطر جدید
        $user->order_id = $OrderId;
        $user->save();

        $key = "1JyJhGHnj2bZFoo3i5GnRdkm2wFMqvRk"; // TerminalKey
        $MerchantId = "000000140334112";
        $TerminalId = "24089971";

        // $Amount = 10000;
        $Amount = session()->get('sum_final') * 10;

        $LocalDateTime = date("m/d/Y g:i:s a");

        $ReturnUrl = url("/order/return/sadad");

        $SignData = $this->encrypt_pkcs7("$TerminalId;$OrderId;$Amount", "$key");
        $data = array('TerminalId' => $TerminalId,
            'MerchantId' => $MerchantId,
            'Amount' => $Amount,
            'SignData' => $SignData,
            'ReturnUrl' => $ReturnUrl,
            'LocalDateTime' => $LocalDateTime,
            'OrderId' => $OrderId);

        $str_data = json_encode($data);

        $res = $this->CallAPI('https://sadad.shaparak.ir/vpg/api/v0/Request/PaymentRequest', $str_data);
        $arrres = json_decode($res);
        if ($arrres->ResCode == 0) {
            $Token = $arrres->Token;
            $url = "https://sadad.shaparak.ir/VPG/Purchase?Token=$Token";
            header("Location:$url");
            exit;
        } else
            die($arrres->Description);
    }

    public function returnFromZarinpal()
    {
        return view('front.return_zarinpal');
    }

    public function returnFromSadad()
    {

        return view('front.return_sadad');
    }


    function encrypt_pkcs7($str, $key)
    {
        $key = base64_decode($key);
        $ciphertext = OpenSSL_encrypt($str, "DES-EDE3", $key, OPENSSL_RAW_DATA);
        return base64_encode($ciphertext);
    }

    function CallAPI($url, $data = false)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data)));
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public function fetchState()
    {
        $states = DB::table('state')->get();

        return response()->json($states);
    }

    public function fetchCity($id)
    {
        $city = DB::table('city')->where('state_id', $id)->get();

        return response()->json($city);
    }

    public function userInfo()
    {
        $user = auth()->user();

        return response()->json([
            'name' => $user->name,
            'postal_code' => $user->postal_code,
            'state' => $user->state,
            'city' => $user->city,
            'address' => $user->address,
            'mobile' => $user->mobile,
            'tell' => $user->tell,
            'introduced' => $user->introduced_code,
            'rate' => $user->balance,
            'sheba' => $user->sheba,
            'card_num' => $user->card_num,
            'user' => $user,
        ]);
    }
}
