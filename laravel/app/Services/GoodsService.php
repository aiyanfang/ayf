<?php 
namespace App\Services;

use App\Models\GoodsModel;
use App\Models\GoodsTypeModel;
use Illuminate\Support\Facades\Redis;

class GoodsService
{
	/**
	*	定义模型变量
	*/ 
	public $goodsModel;
	public $goodsTypeModel;

	/**
	*	构造函数
	*/ 
	public function __construct()
	{
		$this->goodsModel = new GoodsModel;
		$this->goodsTypeModel = new GoodsTypeModel;
	}

	/**
	*	查询分类表所有数据
	*/
	public function getTypeAll()
	{
		// 	判断是否存进redis
		if ($data = Redis::get('data')) {
			$data = unserialize($data);
		}else{
			$data = $this->goodsTypeModel->getData();
			$data = serialize($data);
			Redis::set('data', $data);
		}
		return $data;
	}

	/**
	*	限制查询商品表数据
	*/
	public function getLimitAll()
	{
		// 	判断是否存进redis
		if ($goodsData = Redis::get('goodsData')) {
			$goodsData = unserialize($goodsData);
		}else{
			$goodsData = $this->goodsModel->getLimitAll();
			$goodsData = serialize($goodsData);
			Redis::set('goodsData', $goodsData);
		}
		return $goodsData;
	}

	/**
	*	查询商品所有数据
	*/
	public function getAll()
	{
		$result = $this->goodsModel->getAll();
		return $result;
	}
	
	/**
	*	查询分页所有数据
	*/
	public function typeAll()
	{
		$result = $this->goodsTypeModel->getAll();
		return $result;
	}

}