<?php 
namespace App\Http\Controllers\Frontend;

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
		$goodsData = $this->goodsService->getLimitAll();
		return view('frontend.goods.index',['typeData'=>$typeData,'goodsData'=>$goodsData]);
	}

	/**
	*	详情页
	*/
	public function details()
	{
		return view('frontend.goods.details');
	}

	/**
	*	小米手机列表
	*/
	public function milletList()
	{
		return view('frontend.goods.millet_list');
	}


}
