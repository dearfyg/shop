<?php

namespace App\Http\Middleware;

use Closure;

class Checkmobile
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
        //查看头部是什么请求
        $user_agent = $_SERVER["HTTP_USER_AGENT"];
        //定义一个数组
        $arr = [
            "Android","iPhone","iPad"
        ];
        //循环
        foreach($arr as $k=>$v){
            //判断这个值是否出现在头部
            if(strpos($user_agent,$v)){
                //跳转到手机页面
              return redirect("http://h5.1910.com");
            }
        }
        return $next($request);
    }
}
