<?php 
namespace App\Services;

use App\Models\UserModel;

class GoodsService
{
	/**
	*	定义模型变量
	*/ 
	public $userModel;

	/**
	*	构造函数
	*/ 
	public function __construct()
	{
		$this->userModel = new UserModel('goods_type');
	}

	/**
	*	查询分类表所有数据
	*/
	public function getTypeAll()
	{
		$typeData = $this->userModel->getAll();
		return $this->getTypeData($typeData);
	}

	/**
	*	获取分类数据
	*/ 
	public function getTypeData(&$typeData, $parentId = '0', &$item = null, $name = 'children')
	{
	    $tree = [];
	    foreach ($typeData as $key => $value) {
	        if ($value['parent_id'] == $parentId) {
	            self::shiftCollection($typeData, $value, $key);
	            if ($item) $item[$name][] = $value;
	            else $tree[] = $value;
	        }
	    };
	    // var_dump($tree);die;
	    return $tree;
	}

	/**
	*	删除分配的元素
	*/
	public function shiftCollection(&$typeData, &$value, $key)
	{
	    unset($typeData[$key]);
	    self::getTypeData($typeData, $value['type_id'], $value);
	    var_dump($typeData);die;
	}
	
}