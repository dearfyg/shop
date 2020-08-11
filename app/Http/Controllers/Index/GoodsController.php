<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Model\Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Model\Video;
class GoodsController extends Controller
{
    /*
     * 产品列表
     */
    public function list(){
        //获取页数
        $page = request()->page;
        //如果没有页数则为第一页
        if(!$page){
            $page = 1;
        }
        //获取商品id 对象用于分页
        $goods_id = Goods::select("goods_id")->paginate(4);
        //转为数组用于循环
        $id=$goods_id->toArray();
        //获取redis
        foreach($id["data"] as $k=>$v){
            //获取多个
            $data[] = Redis::hgetall($v["goods_id"]."goods".$page);
        }
        //判断redis是否有此id 有则存直接获取没有去数据库查询
        if(count($data,COUNT_RECURSIVE)<=4){
            //俩表联查
            $data=Goods::select("admin_goods.*","Category.id","Category.cate_name")
                ->leftJoin("Category","admin_goods.cate_id","=","Category.id")
                ->paginate(4)->toArray();
            $data = $data["data"];
            foreach($data as $k=>$v){
                //存入多个
                Redis::hmset($v["goods_id"]."goods".$page,$v);
                Redis::expire($v["goods_id"]."goods".$page,120);
            }
        }
        //获取分数从大到小
        $sort = Redis::zrevrange("ss:goods",0,9,['withscores']==true);
        $rr = [];
        foreach($sort as $k=>$v){
            $r= Goods::select("goods_name")->where("goods_id",$k)->first()->toArray();
            $r["score"] = $v;
            $rr[] = $r;
        }
        return view("goods.list",["data"=>$data,"link"=>$goods_id,"rr"=>$rr]);
    }
    /*
     * 产品详情
     */
    public function detail()
    {
        //接产品id
        $id = request()->goods_id;
        //判断是否有此redis
        $a = Redis::zscore("ss:goods", $id);
        //如果没有
        if (!$a) {
            //设置一个
            Redis::zadd("ss:goods", 0, $id);
        }
        //键自增
        $sum = Redis::zincrby("ss:goods", 1, $id);
        //获取redis里面是否有次键值
        $data = Redis::hgetall($id . "goods");
        //判断是否有这个键
        if (!$data) {
            //没有缓存
            //没有则存入redis
            //查询数据
            $data = Goods::where("goods_id", $id)
                ->leftJoin("Category", "admin_goods.cate_id", "=", "Category.id")
                ->first()->toArray();
            //存入redis
            Redis::hmset($id . "goods", $data);
            //设置redis缓存过期时间
            Redis::expire($id . "goods", 300);
        }
        //通过goods id查询商品视频表
        $video = Video::where("goods_id", $id)->first("video_m3u8");
        return view("goods.detail", ["data" => $data, "sum" => $sum, "video" => $video]);
    }
    /*
    *抢购
    */
    public function rob(){
        //接商品id值
        $goods_id = request()->goods_id;
        //当前商品id为key去查询数据库
        $stock = Redis::hget("goods",$goods_id);
        //每次进入先判断key值是否大于零
        if($stock>0){
            //如果大于零 减去购买的数量
            $a = Redis::hincrby("goods",$goods_id,-1);
            //跳转到购物车页面
            return redirect("cart/add?goods_id=".$goods_id);
        }else{
            //如果小于零提示商品库存不足
            return  "库存不足";
        }
    }
}
