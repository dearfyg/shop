<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->resource('/goods', GoodsController::class);
    $router->resource('cate', CategoryController::class);

    $router->resource('/order', OrderController::class);

    $router->resource('videos', VideoController::class);
    $router->resource('/prize', PrizeController::class);

});
