<?php

namespace App\maguttiCms\Middleware;

use Closure;
// Add Response namespace
use Illuminate\Http\Response;;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

class AdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $model = $request->route('section');
        //$routeName = $request->path();
        $config = config('maguttiCms.admin.list.section.' .$model);
        if(!isset($config['roles']) || Auth::guard('admin')->user()->hasRole($config['roles']) ) return $next($request);
        else {
          return redirect('/admin');
        }

        return $next($request);
    }
}
