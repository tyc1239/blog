<?php

namespace App\Http\Middleware;

use App\Model\Material;
use Closure;

class Materials
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
         $info = Material::where('type',1)->get();
        $arr =[];
        foreach($info as $v){
            if($v->create_time<time()){
                $arr[] =$v->id;
            }
        }
        Material::whereIn('id',$arr)->delete();
        return $next($request);
    }
}
