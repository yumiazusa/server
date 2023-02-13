<?php

namespace Modules\Test\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Common\Exceptions\ApiException;
use Modules\Common\Exceptions\MessageData;
use Modules\Common\Exceptions\StatusData;

class TestApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {   
        $route_data = $request->route();
        $url= str_replace($route_data->getAction()['prefix'].'/',"",$route_data->uri);
        $url_arr=['index/typeList'];
        $api_key = $request->header('apikey');
        if($api_key != config('test.api_key')){
            throw new ApiException(['status'=>StatusData::TOKEN_ERROR_KEY,'message'=>MessageData::TOKEN_ERROR_KEY]);
            return $next();
        }
        if(in_array($url,$url_arr)){
            return $next($request);
         }else{
            throw new ApiException(['status'=>StatusData::TOKEN_ERROR_KEY,
            'message'=>MessageData::TOKEN_ERROR_KEY]);
              }
        
    }
}
