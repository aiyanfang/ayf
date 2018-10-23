<?php 
namespace App\Http\Controllers\Backend;

use DB;
use Session;
use Illuminate\Http\Request;
use App\Services\GoodsService;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
	public $goodsService;
	public function __construct()
	{
		$this->goodsService = new GoodsService;
	}

	/**
	*	商品列表
	*/
	public function list()
	{
		$goodsData = $this->goodsService->getAll();
		return view('backend.goods.list',['goodsData'=>$goodsData]);
	}

	/**
	*	商品添加
	*/
	public function insert(Request $request)
	{
		if ($request->isMethod('post')) {
			$result = $this->goodsService->saveRole($request);
			dd($result);
		}else{
			//	商品分类
			$typeData = $this->goodsService->typeAll();
			return view('backend.goods.insert',['typeData'=>$typeData]);
		}
	}
}
