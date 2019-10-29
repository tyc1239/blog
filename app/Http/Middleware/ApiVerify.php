<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class ApiVerify
{
    private  $limit =20;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $key = $request->ip();
        $exprekey =$key.'expire';
        if(Redis::exists($exprekey)){
        die(json_encode(Redis::get($exprekey),JSON_UNESCAPED_UNICODE));
        }
        if(Redis::exists($key)){
            Redis::incr($key);
            $count = Redis::get($key);
            if($count>$this->limit){
                Redis::set($exprekey,'3分钟以后');
                Redis::expire($exprekey,180);
                 die(json_encode(Redis::get($exprekey),JSON_UNESCAPED_UNICODE));

            }else{
                return $next($request);
            }
        }else{
            Redis::incr($key);
            Redis::expire($key,60);
            return $next($request);
        }
    }
}
