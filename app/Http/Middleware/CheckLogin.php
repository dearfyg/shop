<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;
class Checklogin
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
        //获取cookie
        $token = Cookie::get("token");
        $token = substr($token,strpos($token,"|")+1);
        //判断是否存在
        $url = "http://passport.shop1.com/api/login?token=".$token;
        //发送get请求
        $check = file_get_contents($url);
        //判断是否成功
        if($check==1){
            //成功
            $_SERVER["is_login"] = 1;
        }else{
            //失败
            $_SERVER["is_login"] = 0;
        }
        return $next($request);
    }
}
