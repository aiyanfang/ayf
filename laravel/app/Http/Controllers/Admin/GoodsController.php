<?php 
namespace App\Http\Controllers\Admin;

use DB;
use Session;
use Illuminate\Http\Request;
use App\Services\GoodsService;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
	/**
	*	定义Service变量
	*/ 
	public $goodsService;

	/**
	*	定义构造函数
	*/ 
	public function __construct()
	{
		$this->goodsService = new GoodsService;
	}

	/**
	*	商城首页
	*/
	public function index(Request $request)
	{
		
		// 	查询分类表数据
		$typeData = $this->goodsService->getTypeAll();
		// dd($typeData);
		return view('goods.index',['typeData'=>$typeData]);

	}

	/**
	*	详情页
	*/
	public function details()
	{
		return view('goods.details');
	}

	/**
	*	小米手机列表
	*/
	public function milletList()
	{
		return view('goods.millet_list');
	}

	

}
