<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Model\Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Model\Cart;
use App\Model\Order;
use Illuminate\Support\Facades\Log;
use App\Model\Order_goods;
use Illuminate\Support\Facades\Redis;
class OrderController extends Controller
{
    //订单列表
    public function order(){
        //获取当前登录的用户
        //$user_id = session();
        $user_id = 3;
        //接商品id
        $goods_id = request()->goods_id;
        //接购买数量
        $buy_num = request()->buy_num;
        //判断商品数量若为空则提示
        if(strlen($goods_id)< 1){
            return redirect("cartlist")->with("msg","请至少结算一件物品");
        }
        //开启事务
        DB::beginTransaction();
        //设置字段添加入库
        //订单号
        $order_no = time().rand(1,500).Str::random("10");
        //购买数量切换为数组
        $buy_num = explode(",",$buy_num);
        //循环算出购买数量
        $buynum = 0;
        foreach ($buy_num as $k=>$v){
            $buynum += $v;
        }
        //字符串转为数组
        $goodsId = explode(",",$goods_id);
        //循环算出总价
        $sum = 0;
        foreach($goodsId as $k=>$v){
            //通过id查询商品单价
            $price = Goods::where("goods_id",$v)->value("goods_price");
            foreach($buy_num as $ks=>$vs){
            }
            $sum += $price * $vs;
        }
        $data = [
            'order_no'=>$order_no,
            'user_id' =>$user_id,
            'order_time'=>time(),
            'buy_num' =>$buynum,
            'goods_id'=>$goods_id,
            'status'=>0,
            'buy_price' =>$sum
        ];
        //添加入库
        $order_ok = Order::insert($data);
        //通过商品id查询商品的名称
        $arr = [];
        foreach($goodsId as $k=>$v){
            $arr[] = Goods::where("goods_id",$v)->first();
        }
        $array = [];
        //循环arr添加如订单商品库
        foreach ($arr as $k=>$v){
            $res = [
                "order_no"=>$order_no,
                "goods_id"=>$v["goods_id"],
                "goods_name"=>$v["goods_name"],
                "goods_price"=>$v["goods_price"],
                "goods_img"=>$v["goods_img"],
            ];
            $order_goodsok = Order_goods::insert($res);
            $array[]=$v["goods_id"];
        }
        //合并数组 以goods_id为键  购买数量为值
        $qq=array_combine($array,$buy_num);
        //循环
        foreach ($qq as $k=>$v){
            //定义条件
            $where = [];
            //goods_id为$k
           $where[] = ["goods_id","=",$k];
           //为当前订单号
           $where[] = ["order_no","=",$order_no];
           //修改购买数量
           $orderOk = Order_goods::where($where)->update(["buy_num"=>$v]);
        }
        foreach($goodsId as $k=>$v){
            $goods_num = Goods::where("goods_id",$v)->value("goods_num");
            if($goods_num<=0){
                return redirect("goods/list")->with("商品库存不足");
            }
            foreach($buy_num as $ks=>$vv){
            }
            $goods_num =  $goods_num - $vv;
            //减商品库存
            $goodsNum = Goods::where("goods_id",$v)->update(["goods_num"=>$goods_num]);
        }
        //获取uuid
        $uuid = $_COOKIE["uuid"];
        $akey = "cart:".$uuid."*";
        //先查询所有这个模糊的key
        $yes = Redis::keys($akey);

        //删除商品缓存
        foreach($yes as $k=>$v){
            $v = substr($v,12);
            $cart_ok = Redis::del($v);
        }
        //删除购物车列表
        $key = "cart:ids:set:".$uuid;
        $cartok = Redis::del($key);
        //判断条件全部成立才提交
        if($order_ok && $order_goodsok && $cartok &&$cart_ok && $orderOk && $goodsNum){
            //提交
            DB::commit();
            return redirect("order/view?order_no=".$order_no);
        }else{
            //回滚
            DB::rollBack();
            echo "订单提交出现异常";
            header("refres:1;url=goods/list");
        }
    }
    //订单展示页面
    public function view(){
        //订单号
        $order_no = request()->order_no;
        //通过订单号查询商品信息表
        $goodsInfo = Order_goods::where("order_no",$order_no)->get();
        $sum = 0;
        foreach($goodsInfo as $k=>$v){
            $sum += $v["goods_price"] * $v["buy_num"];
        }
        //渲染视图
        return view("order.order",["goodsInfo"=>$goodsInfo,"sum"=>$sum]);

    }
    //支付方法
    public function pay(){
        //获取订单号
        $order_no = request()->order_no;
        //通过订单号查总价
        $sum = Order::where("order_no",$order_no)->value("buy_price");
            require_once app_path("Packages/alipay/pagepay/service/AlipayTradeService.php");
            require_once app_path("Packages/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php");
            $config = config("alipay");

            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no = $order_no;
            //订单名称，必填
            $subject = trim("Lightning团队测试");

            //付款金额，必填
            $total_amount = $sum;

            //商品描述，可空
            $body = "";

            //构造参数
            $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
            $payRequestBuilder->setBody($body);
            $payRequestBuilder->setSubject($subject);
            $payRequestBuilder->setTotalAmount($total_amount);
            $payRequestBuilder->setOutTradeNo($out_trade_no);

            $aop = new \AlipayTradeService($config);
//            $aop = new \AopClient($config);
            /**
             * pagePay 电脑网站支付请求
             * @param $builder 业务参数，使用buildmodel中的对象生成。
             * @param $return_url 同步跳转地址，公网可以访问
             * @param $notify_url 异步通知地址，公网可以访问
             * @return $response 支付宝返回的信息
             */
            $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);
            //输出表单
            var_dump($response);
    }
    //同步跳转
    public function success(){
        $config = config('alipay');
        require_once app_path("Packages/alipay/pagepay/service/AlipayTradeService.php");
        //接收数据
        $arr = $_GET;
        $alipaySevice = new \AlipayTradeService($config);
        $ischeck = $alipaySevice->check($arr);
        //验签
        if($ischeck){
            $data = [
                "order_no"=>$arr["out_trade_no"],
                "status" => 0,
            ];
           //判断用户的订单号和当前返回的是否一致
            $order = Order::where($data)->first();
            //如果为空则订单号不存在 返回错误
            if(empty($order)){
                $msg = [
                    "msg"=>'订单号错误',
                    "code"=>"1",
                ];
                $msg = json_encode($msg,JSON_UNESCAPED_UNICODE);
                return $msg;
            }
            //判断返回支付金额是否一致
            if($arr["total_amount"]!=$order->buy_price){
                $msg = [
                    "msg"=>'支付金额错误',
                    "code"=>"2",
                ];
                $msg = json_encode($msg,JSON_UNESCAPED_UNICODE);
                return $msg;
            }
            //判断appid是否一致
            if($arr["app_id"]!=$config["app_id"]){
                $msg = [
                    "msg"=>'订单错误',
                    "code"=>"3",
                ];
                $msg = json_encode($msg,JSON_UNESCAPED_UNICODE);
                return $msg;
            }
            //运行这里 表示都没错 返回到成功页面
            return view("order.success",["order"=>$arr]);
        }else{
            echo "fail";
        }

    }
    //异步跳转
    public function notify_url(){
        $config = config('alipay');
        require_once app_path("Packages/alipay/pagepay/service/AlipayTradeService.php");
        $arr = $_POST;
        $alipaySevice = new \AlipayTradeService($config);
        $ischeck = $alipaySevice->check($arr);
        if($ischeck){
            //判断用户的订单号和当前返回的是否一致
            $data = [
                "order_no"=>$arr["out_trade_no"],
                "status" => 0,
            ];
            $order = Order::where($data)->first();
            //如果为空则订单号不存在 返回错误
            if(empty($order)){
                 Log::info("订单号错误");
                 die;
            }
            //判断返回支付金额是否一致
            if($arr["total_amount"]!=$order->buy_price){
                Log::info("支付金额错误");
                die;
            }
            //判断appid是否一致
            if($arr["app_id"]!=$config["app_id"]){
                Log::info("订单错误");
                die;
            }
            //运行这里说明没错  修改数据库订单表的支付状态
            $res = Order::where("order_no",$arr["out_trade_no"])->update(["status"=>1]);
            if($res){
                Log::info("支付成功");
                echo "success";die;
            }else{
                Log::info("支付失败");
                die;
            }
        }else{
            echo "fail";
        }
    }
}
