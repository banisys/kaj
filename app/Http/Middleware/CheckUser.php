<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $flag = false;
        $url = 'http://termetan.com';

        if (isset(auth('admin')->user()->id)) {
            $flag = true;
        }

        $orderUserId = Order::where('id', $request->id)->pluck('user_id')->first();

        if (isset(auth()->user()->id)) {
            $userId = auth()->user()->id;
        } else {
            $userId = 0;
        }

        if ($orderUserId == $userId || $flag) {
            return $next($request);
        } else {
            header('Location: ' . $url, true);
            exit();
        }
    }
}
