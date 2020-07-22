<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Goods;
use App\Model\Cart;
class CartController extends Controller
{
    public function cart_add(){
        $id=request()->goods_id;
        $data=[
          'goods_id'=>$id,
            "user_id"=>3,
            "buy_num"=>1,
            "add_time"=>time()
        ];

        $res=Cart::where("goods_id",$id)->first();
        if($res){
            $buy_num=Cart::where("goods_id",$id)->value("buy_num");
            Cart::where("goods_id",$id)->update(['buy_num'=>$buy_num+1]);
        }else{
            Cart::insert($data);
        }
        return redirect("/cartlist");

    }
    //商品购物车展示
    public function cartlist()
    {
        $id=3;
        //查询用户购物车表中数据
        $cartInfo=Cart::join("admin_goods","admin_cart.goods_id","admin_goods.goods_id")
            ->where(['user_id'=>$id,"is_del"=>1])
            ->get();

        return view("cart.cartlist",['cartInfo'=>$cartInfo]);
    }
    //获取总价
    public function gopay(){
        $user_id=request()->user_id;
        $cartInfo=Cart::join("admin_goods","admin_cart.goods_id","admin_goods.goods_id")
            ->where(['user_id'=>$user_id,"is_del"=>1])
            ->get();
        $money=0;
        foreach($cartInfo as $k=>$v){
            $money+=$v['goods_price']*$v['buy_num'];
        }
        echo $money;
    }
    //点击获取小计i
    public function subtotal(){
        $buy_num=request()->buy_num;
        $goods_id=request()->goods_id;
        $price=Goods::where("goods_id",$goods_id)->value("goods_price");
        $subtotal=$buy_num*$price;
        Cart::where("goods_id",$goods_id)->update(['buy_num'=>$buy_num]);
        return $subtotal;
    }
}
