<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Model\Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Model\Reviews;
class IndexController extends Controller
{
    public function index(){
        //文件名
        $fileName = "index.html";
        //过期时间
        $cache = 10;
        //判断如果文件存在 或者 当前时间减创建时间小于过期时间则
        if(file_exists($fileName) && time()-filemtime($fileName)<$cache){
//            echo "有缓存";echo "<br>";
            $content = file_get_contents($fileName);
            echo $content;
            die;
        }
        //sql
         $img=Goods::select("goods_id","goods_img","goods_name","goods_desc")->where("is_new",1)->orderBy("goods_id","desc")->take(3)->get();
         $new=Goods::select("goods_id","goods_img","goods_name","goods_price")->where("is_new",1)->orderBy("goods_id","desc")->take(4)->get();
         $hot=Goods::select("goods_id","goods_img","goods_name","goods_price")->where("is_hot",1)->orderBy("goods_id","desc")->paginate(4);
        //开启静态缓存
       ob_start();
       //生成页面
        echo view("index.index",["img"=>$img,"new"=>$new,"hot"=>$hot])->__toString();
        //获取缓存
        $content = ob_get_contents();
        //写入文件
        file_put_contents("index.html",$content);
        //清空缓存
        ob_end_clean();
//        echo "无缓冲";echo "<br>";
        echo $content;

    }
    /*
    *签到
    */
    public function sign(){
        //获取当前登录用户的session
        $user_id = 2;
        //判断当前用户是否签到
        //没有签到
        //将list作为key存入redis为当前用户
        $sign = Redis::lpush("list",$user_id);
        //已经签到

    }
    /**
    个人中心
     ***/
    public function center(){
        $userinfo=session("userinfo");
        return view("index.center",["userinfo"=>$userinfo]);
    }
    public function duty(){

    }
    /*
     * 个人中心查看评论
     */
    public function reviews(){
        //获取用户id
        $userinfo=session("userinfo");
        $user_id=$userinfo['user_id'];
        $reviews=Reviews::where("user_id",3)
            ->orderBy("reviews_time","desc")
            ->get();//查询数据库中该用户的评论
        return view("index.reviews",['reviews'=>$reviews]);
    }
}
