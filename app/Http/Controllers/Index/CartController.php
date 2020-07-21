<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Goods;
use App\Model\Cart;
class CartController extends Controller
{
    public function cart_add($id){
        $data=[
          'goods_id'=>$id,
            "user_id"=>3,
            "buy_num"=>1,
            "add_time"=>time()
        ];
        Cart::insert($data);
    }
    //商品购物车展示
    public function cartlist($id)
    {
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
    //点击支付

}
