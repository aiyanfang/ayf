<?php 
namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
	/**
	*	订单中心
	*/
	public function orderInfo()
	{
		return view('order.order_info');
	}
}