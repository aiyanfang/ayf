<?php 
namespace App\Services;

use App\Models\UserModel;

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
		$this->goodsModel = new UserModel('goods');
		$this->goodsTypeModel = new UserModel('goods_type');
	}

	/**
	*	查询分类表所有数据
	*/
	public function getTypeAll()
	{
		$typeData = $this->goodsTypeModel->getAll();
		return $typeData;
		
	}
	
}