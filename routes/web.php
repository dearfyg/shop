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
