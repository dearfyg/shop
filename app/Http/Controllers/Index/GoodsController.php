<?php

namespace App\Http\Controllers\Index;
use App\Http\Controllers\Controller;
use App\Model\Goods;
use App\Model\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Model\Reviews;


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
        $userinfo=session("userinfo");
        //根据用户id,查询评论
        $reviews=Reviews::where(['goods_id'=>$id,'user_id'=>$userinfo['user_id']])
            ->orderBy('reviews_time',"desc")
            ->get()
            ->toArray();
//        dd($reviews);
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
        $video = Video::where("goods_id", $id)->value("video_m3u8");
        return view("goods.detail", ["data" => $data, "sum" => $sum, "video" => $video,'reviews'=>$reviews]);
    }
    /*
    *抢购
    */
    public function rob()
    {
        //接商品id值
        $goods_id = request()->goods_id;
        //当前商品id为key去查询数据库
        $stock = Redis::hget("goods", $goods_id);
        //每次进入先判断key值是否大于零
        if ($stock > 0) {
            //如果大于零 减去购买的数量
            $a = Redis::hincrby("goods", $goods_id, -1);
            //跳转到购物车页面
            return redirect("cart/add?goods_id=" . $goods_id);
        } else {
            //如果小于零提示商品库存不足
            return "库存不足";
        }
    }
    /*
     * 评论
     */
    public function reviews(){
        //接收评论内容和商品id
        $content=request()->content;
        if(empty($content)){
            $reposn=[
              'code'=>100003,
                'msg'=>'评论不能为空'
            ];
            return $reposn;
        }
        $goods_id=request()->goods_id;
        if(empty($goods_id)){
            $reposn=[
                'code'=>100004,
                'msg'=>'商品id不能为空'
            ];
            return $reposn;
        }
        //获取用户id
        $user_info=session("userinfo");
        if(!$user_info){
              $repson=[
                  'code'=>100006,
                    'msg'=>'请您先登录'
              ];
                return $repson;
       }
        $data=[
            'user_id'=>$user_info['user_id'],
//            'user_id'=>3,
            'content'=>$content,
            'reviews_time'=>time(),
            'goods_id'=>$goods_id
        ];
        $res=Reviews::insert($data);
        if($res){
            $reposn=[
                'code'=>000000,
                'msg'=>'评论成功!'
            ];
        }else{
            $reposn=[
                'code'=>100005,
                'msg'=>'评论失败!!!'
            ];
        }
        return $reposn;
    }
    /*
     * 评论删除
     */
    public function reviewsDel(){
        $reviews_id=request()->reviews_id;
        //判断有无登陆
        $userinfo=session("userinfo");
        if(!$userinfo){
             $reposn=[
                'code'=>100007,
                'msg'=>'请您先登录'
            ];
            return $reposn;
        }
        $res=Reviews::where(["reviews_id"=>$reviews_id,"user_id"=>$userinfo['user_id']])->delete();
        if($res){
            $reposn=[
               'code'=>000000,
                'msg'=>'评论删除成功'
            ];
        }else{
            $reposn=[
                'code'=>100008,
                'msg'=>'评论删除失败'
            ];
        }
        return $reposn;
    }
}
