<?php

namespace App\Http\Middleware;
use App\Tools\Auth\JWTAuth;

use Closure;

class JWTAuthMiddle
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
        $token = $request->token;
        if($token){
            $jwtAuth = JWTAuth::getInstance();
            $jwtAuth->SetToken($token);
            if($jwtAuth->validate() && $jwtAuth->verify()){
                return $next($request);
            }else{
                $data =[
                    'code'=>40002,
                    'msg'=>'登录失败',
                    'data'=>[ ]
                ];
                dd(json_encode($data,JSON_UNESCAPED_UNICODE));
            }
        }else{
            $data =[
                'code'=>40001,
                'msg'=>'缺少必要的参数',
                'data'=>[ ]
            ];
           dd(json_encode($data,JSON_UNESCAPED_UNICODE));
        }
    }
}
