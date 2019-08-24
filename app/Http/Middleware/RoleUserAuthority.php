<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleUserAuthority
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
        $url=$request->url();
        $method=$request->method();
        $user=$request->user();
        $roleAndPermission=$user->getAllPermissionData();
        $roles = Auth::user()->hasRoleType();
        if($roles=='user'){
            return $next($request);
        }else{
            if( strpos( $url, 'ajax' ) !== false ) {
                return $next($request);
            }else{
                abort(403, 'Forbidden');
            }

        }

    }
}
