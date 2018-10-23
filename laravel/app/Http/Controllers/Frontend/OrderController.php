<?php 
namespace App\Http\Controllers\Frontend;

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
		return view('frontend.order.order_info');
	}
}