<?php 
namespace App\Services;

use Session;
use App\Models\GoodsModel;

class HomeService
{
	public $goodsModel;

	/**
	*	构造函数
	*/
	public function __construct()
	{
		$this->goodsModel = new GoodsModel;
	}
}