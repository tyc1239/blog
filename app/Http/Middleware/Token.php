<?php

namespace App\Http\Middleware;

use App\Model\Tuser;
use Closure;

class Token
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

        $token =$request ->token;
        $callback = $request->getuser;
         $obj =  new Tuser();
        if($token){
            $re = $obj ->checktoken($token,$callback);
            if($re){
                return $next($request);
            }
        }else{
            $data = [
                'code'=>'101',
                'message'=>'缺少参数,不能为空',
                'data'=>[
                ]
            ];
            die ($callback."(".json_encode($data,JSON_UNESCAPED_UNICODE).")");
        }
    }
}
