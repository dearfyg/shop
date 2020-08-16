<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});


Route::get("/login","Index\LoginController@login");//登录方法
Route::get("/loginDo","Index\LoginController@loginDo");

Route::get("/register","Index\LoginController@register");//注册
Route::post("/reg","Index\LoginController@reg");
Route::post("/reg/gain","Index\LoginController@gain");   //获取验证码
Route::post("/reg/code","Index\LoginController@code");   //验证验证码
Route::post("/reg/name","Index\LoginController@name");   //验证用户名



Route::get("/","Index\IndexController@index");     //首页

Route::get("/goods/list","Index\GoodsController@list");     //产品列表
Route::get("/goods/detail","Index\GoodsController@detail");     //产品详情




Route::get("/order/order","Index\OrderController@order"); //提交订单页面
Route::get("/order/view","Index\OrderController@view");//订单展示
Route::get("/order/pay","Index\OrderController@pay"); //支付
Route::get("/order/success","Index\OrderController@success"); //支付成功同步跳转
Route::post("/order/notify_url","Index\OrderController@notify_url"); //支付成功异步跳转




Route::get("/wish","Index\WishController@wish_list");//收藏列表
Route::get("/wish/add","Index\WishController@wish_add");//收藏列表
Route::get("/wish/del","Index\WishController@wish_del");//取消收藏


Route::get("/cart/add","Index\CartController@cart_add");//添加购物车
Route::get("/cartlist","Index\CartController@cartlist");//购物车列表
Route::get("/cart/gopay","Index\CartController@gopay");//购物车跳转;
Route::get("/cart/subtotal","Index\CartController@subtotal");//结算小计方法
Route::get("/cart/del","Index\CartController@del");//购物车删除商品
Route::get("cart/subtotal","Index\CartController@subtotal");//结算小计方法
Route::get("/blog/list","Index\BlogController@list");       //博客列表
Route::get("/blog/detail","Index\BlogController@detail");       //博客详情
Route::post("/goods/reviews","Index\GoodsController@reviews");//评论
Route::get("/reviews/del","Index\GoodsController@reviewsDel");//评论删除

Route::get("goods/rob","Index\GoodsController@rob");//抢购
Route::get("sign","Index\IndexController@sign");//签到
Route::get("decode","Cron\VideoController@decoder");//解码

Route::get("center","Index\IndexController@center");//个人中心
Route::get("/center/reviews","Index\IndexController@reviews");//个人中心评论总览
Route::prefix("prize")->Group(function(){
    //抽奖页面
    Route::get("prize","Prize\PrizeController@prize");//抽奖页面
    Route::get("prizeDo","Prize\PrizeController@prizeDo");//抽奖规则
});

