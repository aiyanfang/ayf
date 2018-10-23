<?php 
namespace App\Http\Controllers\Backend;

use DB;
use Session;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\HomeService;
use App\Http\Controllers\Controller;


class HomeController extends Controller
{
	public $userService;
	public $goodsService;

	/**
	*	定义构造函数
	*/ 
	public function __construct()
	{
		$this->userService = new UserService;
		$this->homeService = new HomeService;
	}

	/**
	*	后台首页
	*/
	public function index()
	{
		$userInfo = Session::get('userInfo');
		$username = $userInfo['username'];
		if (empty($username)) {
			return redirect('/message')->with(['message'=>'请先的登录','url'=>'admin/login','jumpTime'=>3,'status'=>false]); 
		}else{
			return view('backend.home.index',['username'=>$username]);
		}
	}

	/**
	*	商品列表
	*/
	public function list()
	{
		$goods = $this->homeService->getList();
		return view('backend.home.list',['goods'=>$goods]);
	}
}