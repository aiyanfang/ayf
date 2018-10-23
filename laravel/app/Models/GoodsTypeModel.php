<?php
namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class GoodsTypeModel extends Model
{
	protected $table = 'goods_type';

	/**
	*	获取最终展示数据
	*/
	public static function getData()
	{
		// 	查询 parent_id 为0的值
		$parentData = self::where('parent_id',0)->get();
		$typeData = [];
		foreach ($parentData as $key => $topType){
			if (count($topType->getType) == 0) {continue;}	// 	调用getType()方法，判断是否存在二级
			$typeData[$key]['goods'] = [];
			$typeData[$key]['type_name'] = [];
			// 	调用getType()，循环输出二级分类
			foreach ($topType->getType as $type){
				$typeData[$key]['type_name'][] = $type->type_name;
				$typeData[$key]['goods'] = array_merge($typeData[$key]['goods'],$type->getGoods->toArray());
			}
		}
		return $typeData;
	}

	/**
	*	获取分类数据
	*/
    public function getType()
    {
    	return $this->hasMany('App\Models\GoodsTypeModel','parent_id','type_id');
    }
    /**
    *	根据分类查询该分类的商品
    */
    public function getGoods()
    {
    	return $this->hasMany('App\Models\GoodsModel','type_id','type_id');
    }

    /**
	*	查询分类所有数据
	*/
	public function getAll()
	{
		$result = self::get();
		return $result;
	}
}