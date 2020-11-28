<?php

namespace App\Http\Controllers\Admin;

use App\Services\MessagingService;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Exist;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class CartController extends Controller
{
    public function index()
    {
        return view('admin.cart.index');
    }

    public function cartSearch(Request $request)
    {
        
        $userId = User::where('mobile', $request['mobile'])->pluck('id')->first();

        $carts = Cart::where('user_id', $userId)->with('product')->with('color')
            ->with('cart_values.effect_value')->get();

        return response()->json($carts->groupBy('cookie'));
    }
    
    public function newindex(Request $request)
    {
        $sendMessage = false;
        
        // $exist = Exist::first();
        // ProductService::setInventoryTransaction($exist,['type'=>'add', 'factor_num'=>'test']);
        
        $query = Cart::orderBy('created_at','DESC')->with('product')->with('color')
            ->with('user')->with('cart_values.effect_value')->with('order_values');
        
        $filters_request = $request->filters ?? '{"created":"15m","status":"unpaid"}';
        $filters = [];
        if (isset($filters_request))
        {
            $filter_validations = [
                'mobile' => ['sometimes','required'],
                'created' => [Rule::in(['15m','1h','1d','1w','1M'])],
                'status' => [Rule::in(['unpaid','paid'])],
            ];
            
            $filters = json_decode($filters_request, true);
            
            $validator = Validator::make($filters,  $filter_validations);

            if (!$validator->fails()) {
                
                 foreach ($filters as $columnname => $keyword) 
                 {
                     switch ($columnname) {
                        case "created":
                        //   $date = Verta::parse($keyword)->DateTime();
                          if ($keyword == '15m')
                            $query->where('created_at', '>=', Carbon::now()->subMinutes(15)->toDateTimeString());
                          elseif ($keyword == '1h')
                            $query->where('created_at', '>=', Carbon::now()->subHour()->toDateTimeString());
                          elseif ($keyword == '1d')
                            $query->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString());
                          elseif ($keyword == '1w')
                            $query->where('created_at', '>=', Carbon::now()->subWeek()->toDateTimeString());
                          elseif ($keyword == '1M')
                            $query->where('created_at', '>=', Carbon::now()->subMonth()->toDateTimeString());
                          
                          break;
                        case "status":
                          if ($keyword == 'paid')
                            $query->has('order_values');
                          elseif ($keyword == 'unpaid')
                          {
                            $sendMessage = $request->sendMessage;
                            $query->doesntHave('order_values');
                          }
                          break;
                        case "mobile":
                            if (strlen($keyword)>2)
                            {
                             $query->whereHas('user', function (Builder $q) use ($keyword) {
                                $q->where('mobile', 'LIKE', "%{$keyword}%");
                             });
                            }
                          break;
                        default:
                           
                          break;
                      }
                 }
                 
            }
            
        }
        
        if ($sendMessage)
        {
              $mobiles = $query->get()->pluck('user.mobile')->all();
              $result = MessagingService::sendCartNotification($mobiles);
              return response()->json($result, 200);
        }
        
        $carts = $query->paginate(20)->appends(['filters' => $filters_request]);//->groupBy('cookie');//->get();
        
         if ($request->ajax()) 
            return response()->json($carts, 200);
         else
            return view('admin.cart.newindex', compact('filters', 'carts') );
    }
}
