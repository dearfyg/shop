<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/8/12 0012
 * Time: 14:40
 */
namespace App\Http\ViewComposers;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;//**记得引入这个啊（因为在composer函数参数里使用了View类）**
use App\Http\Controllers\Index\CartController;
class MovieComposer extends CartController
{
    public $movieList = [];
    public $now;

    public function __construct()
    {
        $this->movieList = [
            'Shawshank redemption',
            'Forrest Gump',
        ];
        //用户标识
    }
    public function compose(View $view)
    {
//        $user_id=$this->uuid;
//
//        $key = 'cart:ids:set:'.$user_id;
//
//        //先根据集合拿到商品ID
//        $idArr =  Redis::sMembers($key);
//
//
//        if($idArr){
//            for ($i=0; $i<count($idArr); $i++) {
//
//                $k  = 'cart:'.$user_id.':'.$idArr[$i];//id
//
//                // echo $k,'<br/>';
//                $cartInfo[] = Redis::hGetAll($k);
//            }
//            $money=0;
//            foreach($cartInfo as $k=>$v){
//                $money+=$v['goods_price']*$v['num'];
//            }
//            $view->with(['cartInfo'=>$cartInfo,'money'=>$money]);
//        }
//        dd($cartInfo);

    }
}