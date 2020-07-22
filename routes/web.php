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

Route::get('/', function () {
    return view('welcome');
});


Route::get("/goods/list","Index\GoodsController@list");     //产品列表
Route::get("/goods/detail","Index\GoodsController@detail");     //产品详情
Route::get("/order/order/{order_id}","Index\OrderController@order"); //提交订单页面
Route::get("/order/pay/{order_id}","Index\OrderController@pay"); //支付
Route::get("/order/success","Index\OrderController@success"); //支付成功同步跳转
Route::get("/cart/add","Index\CartController@cart_add");//添加购物车
Route::get("/cartlist","Index\CartController@cartlist");//购物车列表
Route::get("/cart/gopay","Index\CartController@gopay");//购物车跳转;
Route::get("/cart/subtotal","Index\CartController@subtotal");//结算小计方法
Route::get("/cart/del","Index\CartController@del");//购物车删除商品
