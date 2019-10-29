<?php

namespace App\Http\Middleware;

use Closure;

class Elogin
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
        $token =$request->token;
        if(empty($token)){
            $data =[
                    'code'=>100,
                    'message'=>'请登录',
                    'data'=>[]
            ];
            die(json_encode($data,JSON_UNESCAPED_UNICODE));
        }
        return $next($request);
    }
}
