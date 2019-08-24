<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class RoleAuthority
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // Code will be refactor Later.

        $url = $request->url();
        $method = $request->method();
        $user = $request->user();
        $roleAndPermission = $user->getAllPermissionData();
        $roles = Auth::user()->hasRoleType();
        if ($roles== 'admin') {
            return $next($request);
        } elseif ($roles == 'sub-admin') {

            if(strpos($url, 'account-setting') ||strpos($url, 'update-account-password')||
                strpos($url, 'update-password')){
                return $next($request);

            }else if ($method == 'PATCH' || $method == 'DELETE' || $method == 'POST') {

                if ($method == 'POST' && in_array('create', $roleAndPermission[1])) {
                    return $next($request);
                } elseif ($method == "PATCH" && in_array('edit', $roleAndPermission[1])) {

                    return $next($request);

                } elseif ($method == "DELETE" && in_array('delete', $roleAndPermission[1])) {
                    return $next($request);

                } else {
                    abort(403, 'Forbidden');
                }

            } else if ($method == "GET" && strpos($url, 'create')) {


                if (in_array('create', $roleAndPermission[1])) {
                    return $next($request);

                } else {
                    abort(403, 'Forbidden');
                }

            } else if ($method == "GET" && strpos($url, 'edit')) {


                if (in_array('edit', $roleAndPermission[1])) {
                    return $next($request);

                } else {
                    abort(403, 'Forbidden');
                }

            } else if ($method == "GET" && strpos($url, 'edit')) {

                if (in_array('edit', $roleAndPermission[1])) {
                    return $next($request);

                } else {
                    abort(403, 'Forbidden');
                }

            } else if ($method == "GET" && $request->route()->parameters()) {

                if (in_array('details', $roleAndPermission[1])) {
                    return $next($request);

                } else {
                    abort(403, 'Forbidden');
                }

            } else if ($method == "GET" && $request->route()->parameters()) {

                if (in_array('details', $roleAndPermission[1])) {
                    return $next($request);

                } else {
                    abort(403, 'Forbidden');
                }

            } else {
                return $next($request);
            }


        } else {
            abort(403, 'Forbidden');
        }

    }

}
