<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Goods;
use App\Model\Cart;
use Illuminate\Support\Facades\Redis;
class CartController extends Controller
{
    public $now;
    public $uuid;

    public function __construct()
    {
        $this->now = time();
        $this->uuid = $_COOKIE['uuid'];     //用户标识
    }
    //购物车加入商品
    public function cart_add(){
        $id=request()->goods_id;
//        dd($id);
        $user_id=$this->uuid;
        //判断是否有商品id
        if(empty($id)){
//            $data=[
//                'goods_id'=>$id,
//                "user_id"=>3,
//                "buy_num"=>1,
//                "add_time"=>time()
//            ];
//
//            $res=Cart::where("goods_id",$id)->first();
//            if($res){
//                $buy_num=Cart::where("goods_id",$id)->value("buy_num");
//                Cart::where("goods_id",$id)->update(['buy_num'=>$buy_num+1]);
//            }else{
//                Cart::insert($data);
//            }
            return $repson=[
               'code'=>"100001",
                'msg'=>"添加购物车失败"
            ];
        }
        //根据商品id查询数据库户取商品信息
        $goodData=Goods::where("goods_id",$id)->first()->toArray();
        if(empty($goodData)){
            return $repson=[
                'code'=>"100002",
                'msg'=>"没有该商品"
            ];
        }
        //拼写key
        $key="cart:".$user_id.":".$id;
        //判断购物车之前有无此商品
        $data = Redis::exists($key);
        $cartNum=1;
        if(!$data){
            //之前没有此商品，进行添加

            $goodData['num'] = $cartNum;
            //将商品数据放入redis hash中
            Redis::hmset($key, $goodData);

            $key1 = 'cart:ids:set:'.$user_id;
            //将商品ID存放集合中,是为了更好将用户的购物车的商品给遍历出来
            Redis::sadd($key1, $id);
        }else{
            //购物车有对应的商品，只需要添加对应商品的数量
            $originNum = Redis::hget($key, 'num');

            //原来的数量加上用户新加入的数量
            $newNum = $originNum + $cartNum;

            Redis::hset($key, 'num', $newNum);
        }
        return $repson=[
            'code'=>"0000",
            'msg'=>"添加购物车成功"
        ];
    }
    //商品购物车展示
    public function cartlist()
    {
//        if($user_id){
//            //查询用户购物车表中数据
//            $cartInfo=Cart::join("admin_goods","admin_cart.goods_id","admin_goods.goods_id")
//                ->where(['user_id'=>$user_id,"is_del"=>1])
//                ->get();
//        }else{
//            //查询redis中的数据
//        }
        $user_id=$this->uuid;

        $key = 'cart:ids:set:'.$user_id;

        //先根据集合拿到商品ID
        $idArr =  Redis::sMembers($key);

        if($idArr){
            for ($i=0; $i<count($idArr); $i++) {

                $k  = 'cart:'.$user_id.':'.$idArr[$i];//id

                // echo $k,'<br/>';
                $cartInfo[] = Redis::hGetAll($k);
            }
            return view("cart.cartlist",['cartInfo'=>$cartInfo]);
        }
//        dd($cartInfo);
        return view("cart.cartlist",['cartInfo'=>[]]);
    }
    //获取总价
    public function gopay(){
        $user_id=$this->uuid;
        $key = 'cart:ids:set:'.$user_id;

        //先根据集合拿到商品ID
        $idArr =  Redis::sMembers($key);


        for ($i=0; $i<count($idArr); $i++) {

            $k  = 'cart:'.$user_id.':'.$idArr[$i];//id

            // echo $k,'<br/>';
            $cartInfo[] = Redis::hGetAll($k);
        }
        $money=0;
        foreach($cartInfo as $k=>$v){
            $money+=$v['goods_price']*$v['num'];
        }
        echo $money;
    }
    //点击更改购物车数量
    public function subtotal(){
        $buy_num=request()->buy_num;
        $id=request()->goods_id;
        $price=request()->price;
        $user_id=$this->uuid;
        $key="cart:".$user_id.":".$id;
        Redis::hset($key, 'num', $buy_num);
        $totoal=$price*$buy_num;
        return $totoal;
    }
    //购物车删除商品
    public function del(){
        $user_id=$this->uuid;
        $goods_id=request()->goods_id;
        //写用户的购物车
        $key1 = 'cart:ids:set:'.$user_id;
        Redis::srem($key1,$goods_id);
    }

}
