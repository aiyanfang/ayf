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


/**
*	信息提示
*/ 
Route::get('/message','Admin\MessageController@index');


/**
*	商城
*/ 	
Route::get('goods/index','Admin\GoodsController@index');
Route::get('goods/details','Admin\GoodsController@details');
Route::get('goods/milletList','Admin\GoodsController@milletList');

/**
*	用户
*/ 	
Route::any('user/login','Admin\UserController@login');
Route::any('user/loginOut','Admin\UserController@loginOut');
Route::any('user/register','Admin\UserController@register');
Route::get('user/userInfo','Admin\UserController@userInfo');
Route::post('user/userName','Admin\UserController@userName');
Route::get('user/captcha/{tmp}','Admin\UserController@captcha');





/**
*	购物车
*/ 	
Route::get('cart/goodsCart','Admin\CartController@goodsCart');

/**
*	订单
*/ 	
Route::get('order/orderInfo','Admin\OrderController@orderInfo');

