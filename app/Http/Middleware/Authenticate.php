<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Permission;
use Route;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }
        
        //Quet cac routing va them vao bang Permission neu chua co
        // $routeCollection = Route::getRoutes();
        // foreach ($routeCollection as $route) {
        //     $num_permission = Permission::where('name', '=', $route->getName())->count();
        //     if($num_permission == 0){
        //         $permission = new Permission();
        //         $permission->name = $route->getName();
        //         $permission->save();
        //     }
        // }

        return $next($request);
    }
}
