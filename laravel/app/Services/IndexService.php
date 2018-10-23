<?php 
namespace App\Services;

use App\Models\GoodsModel;

class BackendService
{
	public $goodsModel;

	/**
	*	定义构造函数
	*/ 
	public function __construct()
	{
		$this->goodsModel = new GoodsModel;
	}

	/**
	*	商品列表
	*/
	public function getAll()
	{
		$data = $this->goodsModel->getAll();
		return $data;
	}
}
