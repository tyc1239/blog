<?php

namespace App\Http\Middleware;

use Closure;

class AdminLogin
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
        if(!request()->session()->get('email')){
            echo"<script>alert('请登录后再进行操作');location.href='/admin'</script>";
             }
         return $next($request);
     }


}