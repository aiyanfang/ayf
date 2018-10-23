<?php 
namespace App\Models;

use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class GoodsModel extends Model
{
	protected $table = 'goods';
	
	/**
	*	查询商品所有数据
	*/
	public function getAll()
	{
		$result = self::paginate(5);
		return $result;
	}

	/**
	*	限制查询商品数据
	*/
	public function getLimitAll()
	{
		$result = self::limit(5)->get();
		return $result = json_decode($result,true);
	}


}