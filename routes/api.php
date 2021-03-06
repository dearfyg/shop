<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get("/goods","Api\GoodsController@goods");//商品列表Api
Route::get("/goodsdetail","Api\GoodsController@detail");//商品列表Api
Route::get("/search","Api\GoodsController@search");//商品列表Api