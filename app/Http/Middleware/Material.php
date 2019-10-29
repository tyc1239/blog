<?php

namespace App\Http\Middleware;

use App\Model\Materials;
use Closure;

class Material
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
         $info = Materials::where('type',1)->get();
        $arr =[];
        foreach($info as $value){
            if($value->create_time<time()){
                $arr[] = $value->id;
            }
        }
        Materials::whereIn('id',$arr)->delete();
        return $next($request);
    }
}
