<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    //订单列表
    public function order($order_id){
        return view("order.order");
    }
    //支付方法
    public function pay($order_id){

        require_once app_path("Packages/alipay/pagepay/service/AlipayTradeService.php");
        require_once app_path("Packages/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php");
        $config = config("alipay");

        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = date('YmdHis').rand(50,200).Str::random(10);
        //订单名称，必填
        $subject = trim("go团队测试");

        //付款金额，必填
        $total_amount = rand(10,100);

        //商品描述，可空
        $body = "";

        //构造参数
        $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setOutTradeNo($out_trade_no);

        $aop = new \AlipayTradeService($config);

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
        return view("order.success");
    }

}
