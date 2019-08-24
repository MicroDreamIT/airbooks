<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class WebJson
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
        if (!$request->isXmlHttpRequest()) {
            return new Response(view('admin.admin-dashboard'));
        }
        return $next($request);
    }
}
