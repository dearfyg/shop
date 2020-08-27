<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redis;
class CheckLogin
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
        $token=Cookie::get("token");
        if($token){
            $token=Crypt::decryptString($token);

            $key="token_".$token;
            $u=Redis::hGetAll($key);
            if(isset($u['uid'])){

                $_SERVER['uid']=$u['uid'];
                $_SERVER['user_name']=$u['user_name'];
                $_SERVER['token']=$token;
            }
        }
        return $next($request);
    }
}
