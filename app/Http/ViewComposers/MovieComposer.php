<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/8/12 0012
 * Time: 14:40
 */
namespace App\Http\ViewComposers;
use App\Model\Cart;
use App\Model\Goods;
use Illuminate\View\View;//**记得引入这个啊（因为在composer函数参数里使用了View类）**
use App\Http\Controllers\Index\CartController;
class MovieComposer extends CartController
{
    public $movieList = [];
    public function __construct()
    {
        $this->movieList = [
            'Shawshank redemption',
            'Forrest Gump',
        ];
    }
    public function compose(View $view)
    {
        $id=3;
        //查询用户购物车表中数据
        $cartInfo=Cart::join("admin_goods","admin_cart.goods_id","admin_goods.goods_id")
            ->where(['user_id'=>$id,"is_del"=>1])
            ->get();
        $money=0;
        foreach($cartInfo as $k=>$v){
            $money+=$v['goods_price']*$v['buy_num'];
        }
        $view->with(['cartInfo'=>$cartInfo,'money'=>$money]);
    }
}