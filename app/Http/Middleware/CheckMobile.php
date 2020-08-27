<?php

namespace App\Http\Middleware;

use Closure;

class CheckMobile
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
//        echo "<pre>";print_r($_SERVER);"<pre>";die;
        $mobile=$_SERVER['HTTP_USER_AGENT'];//获取设备
        $arr=[
            'iPhone',
            'iPad',
            'Android'
        ];
        foreach($arr as $k=>$v){

            if(strpos($mobile,$v)){
                return redirect("h5.1910.com");
            }
        }
        return $next($request);
    }
}
