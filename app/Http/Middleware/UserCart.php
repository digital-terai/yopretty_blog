<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\maguttiCms\Tools\StoreHelper;

class UserCart
{
    public function __construct() {}

    public function handle($request, Closure $next) {
		if (Auth::user()) {
			$cart = StoreHelper::getUserCart();
			if ($cart)
				StoreHelper::setSessionCart($cart);
		}
		return $next($request);
    }
}
