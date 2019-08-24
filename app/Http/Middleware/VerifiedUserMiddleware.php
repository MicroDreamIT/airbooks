<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerifiedUserMiddleware
{

    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        if($request->user()->email_verified=='' && $request->user()->is_active && auth()->check()){
            return $next($request);
        }else{
            return redirect()->to('/')->with('blade-alert', 'please verify email');
        }

    }
}
