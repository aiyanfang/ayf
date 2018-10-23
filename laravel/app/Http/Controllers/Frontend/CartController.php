<?php 
namespace App\Http\Controllers\Frontend;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
	/**
	*	购物车
	*/
	public function goodsCart()
	{
		return view('frontend.cart.goods_cart');
	}
}