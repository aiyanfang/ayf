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

Route::resource('index','IndexController');			//	练习


/**
*	信息提示
*/
Route::get('/message','MessageController@index');
// Route::get('/message','MessageController@index');



/**
*	前台商城
*/
Route::get('goods/index','Frontend\GoodsController@index');
Route::get('goods/details','Frontend\GoodsController@details');
Route::get('goods/milletList','Frontend\GoodsController@milletList');	
Route::any('user/login','Frontend\UserController@login');
Route::any('user/loginOut','Frontend\UserController@loginOut');
Route::any('user/register','Frontend\UserController@register');
Route::get('user/userInfo','Frontend\UserController@userInfo');
Route::post('user/userName','Frontend\UserController@userName');
Route::get('user/captcha/{tmp}','Frontend\UserController@captcha'); 	
Route::get('cart/goodsCart','Frontend\CartController@goodsCart');
Route::get('order/orderInfo','Frontend\OrderController@orderInfo');


/**
*	后台管理
*/
Route::any('admin/login','Backend\AdminController@login');
Route::post('admin/loginOut','Backend\AdminController@loginOut');
Route::get('home/index','Backend\HomeController@index');
Route::get('home/list','Backend\HomeController@list');

Route::group(['middleware'=>['power'],['namespace'=>'Backend']],function(){
	
	// Route::get('admin/l','Backend\AdminController@l');
	Route::post('admin/userName','Backend\AdminController@userName');
	Route::any('admin/insert','Backend\AdminController@insert');
	Route::any('admin/update','Backend\AdminController@update');
	Route::get('admin/delete','Backend\AdminController@delete');
	Route::get('admin/list','Backend\AdminController@list');
	Route::post('role/roleName','Backend\RoleController@roleName');
	Route::any('role/insert','Backend\RoleController@insert');
	Route::any('role/update','Backend\RoleController@update');
	Route::get('role/delete','Backend\RoleController@delete');
	Route::get('role/list','Backend\RoleController@list');
	Route::post('menu/menuName','Backend\MenuController@menuName');
	Route::any('menu/insert','Backend\MenuController@insert');
	Route::any('menu/update','Backend\MenuController@update');
	Route::get('menu/delete','Backend\MenuController@delete');
	Route::get('menu/list','Backend\MenuController@list');
	Route::any('goods/insert','Backend\GoodsController@insert');
	Route::any('goods/update','Backend\GoodsController@update');
	Route::get('goods/delete','Backend\GoodsController@delete');
	Route::get('goods/list','Backend\GoodsController@list');
});

/**
*	后台分组
*/

