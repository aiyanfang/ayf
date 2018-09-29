<?php 
namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
	/**
	*	商城首页
	*/ 	
	public function index()
	{
		return view('goods.index');
	}

	/**
	*	注册
	*/
	public function register()
	{
		return view('goods.register');
	}

	/**
	*	登录
	*/
	public function login()
	{
		return view('goods.login');
	}

	/**
	*	个人中心
	*/
	public function user_info()
	{
		return view('goods.user_info');
	}

	/**
	*	购物车
	*/
	public function goods_cart()
	{
		return view('goods.goods_cart');
	}

	/**
	*	商品选购
	*/
	public function choose()
	{
		return view('goods.choose');
	}

	/**
	*	小米手机列表
	*/
	public function millet_list()
	{
		return view('goods.millet_list');
	}

	/**
	*	订单中心
	*/
	public function order_info()
	{
		return view('goods.order_info');
	}



	// 	小米商城水电费大富大贵
}
