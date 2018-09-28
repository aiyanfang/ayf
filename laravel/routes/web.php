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

// 	自定义
// Route::get('/admin','Admin\IndexController@index');

Route::resource('index','Admin\IndexController');			//	练习

// 小米商城
Route::get('goods/index','Admin\GoodsController@index');
Route::get('goods/login','Admin\GoodsController@login');
Route::get('goods/register','Admin\GoodsController@register');
Route::get('goods/goods_cart','Admin\GoodsController@goods_cart');
Route::get('goods/choose','Admin\GoodsController@choose');
Route::get('goods/user_info','Admin\GoodsController@user_info');
Route::get('goods/order_info','Admin\GoodsController@order_info');
Route::get('goods/millet_list','Admin\GoodsController@millet_list');
// Route::get('goods/user_info','Admin\GoodsController@user_info');
