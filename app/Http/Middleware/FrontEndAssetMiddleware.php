<?php

namespace App\Http\Middleware;

use Closure;

class FrontEndAssetMiddleware
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
        $urlDetails = explode('/', $request->getRequestUri());

        if(count($urlDetails)>2){
            if($urlDetails[2]=='aircraft'|| $urlDetails[2]=='engine'||$urlDetails[2]=='apu' ||$urlDetails[2]=='wanted'){
                $model = '\App\\'.ucfirst($urlDetails[2]);
                $data = $model::find($urlDetails[3]);

                if($data){
                    if($urlDetails[2]=='wanted'){
                        if($data->is_active==1){
                            return $next($request);
                        }else{
                            return response()->json([
                                'url'=>'404'
                            ]);
                        }
                    }else{
//
                        if($data->isActiveStatus=='Approved' && $data->is_active_by_user==1){
                            return $next($request);
                        }else{
                            return response()->json([
                                'url'=>'404'
                            ]);
                        }
                    }
                }else{
                    return response()->json([
                        'url'=>'404'
                    ]);
                }


            }
        }else{

            return $next($request);
        }

        return $next($request);

    }
}
