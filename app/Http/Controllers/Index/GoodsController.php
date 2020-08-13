<?php

namespace App\Http\Controllers\Index;
use App\Http\Controllers\Controller;
use App\Model\Goods;
use App\Model\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class GoodsController extends Controller
{
    /*
     * 产品列表
     */
    public function list(){
        //判断redis中是否有商品数据
            $data=Goods::select("admin_goods.*","Category.id","Category.cate_name")
//                ->where()
                ->leftJoin("Category","admin_goods.cate_id","=","Category.id")
                ->paginate(4)
                ->toArray();

        return view("goods.list",["data"=>$data]);
    }
    /*
     * 产品详情
     */
    public function detail(){
        //接产品id
        $id=request()->goods_id;
        $video=Video::where("id",$id)->first();
        //判断id是否在redis中
        $goods=Redis::hget($id,"goods_id");
        if($goods){
            //存在
            $data=Redis::hgetall($id);
//            dd($data);
        }else{
            //不存在
            $data=Goods::where("goods_id",$id)
                ->leftJoin("Category","admin_goods.cate_id","=","Category.id")
                ->first()->toArray();
            Redis::hmset($id,$data);
        }
        //访问一次逐步增加
        $key="goods_id:".$id;
        Redis::zincrby($key,1,$id);
        //查询数据
        return view("goods.detail",["data"=>$data,"video"=>$video]);
    }
    /*
     *计算商品数量，防止超卖
     */
    public function add(){
        $goods_id=request()->goods_id;
        $seckill=Redis::incr("seckill");
        if($seckill>10){
            //结束购买，跳转回首页
            echo "该商品已售完";
        }else{
            //跳转付款页面
            echo "请支付";
        }
    }
}
