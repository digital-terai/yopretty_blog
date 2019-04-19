<?php

namespace App\Http\Middleware;

use Closure;
use App\maguttiCms\Tools\StoreHelper;
use Illuminate\Support\Facades\Redirect;

class StoreEnabled
{
    public function __construct() {}

    public function handle($request, Closure $next) {
		if (StoreHelper::isStoreEnabled())
			return $next($request);
		else
			return Redirect::to('/');
    }
}
