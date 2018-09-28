<?php 
namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
*     用户登录、注册
*/
class UserController extends Controller
{
	/**
	*	注册页面
	*/
	public function register()
	{
		return view('user.register');
	}

	/**
	*	登录页面
	*/
	public function login()
	{
		return view('user.login');
	}
}
