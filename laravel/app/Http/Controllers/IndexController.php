<?php
namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
	/**
	*	显示用户列表
	*/ 	
	public function index()
	{
		$res = Db::table('user')->get();
		return view('index.index',['data'=>$res]);
	}

	/**
	*	添加页面
	*/ 	
	public function create()
	{
		return view('index.create');
	}

	/**
	*	添加数据
	*/
	public function store(Request $request)
	{
		$user_info = $request->input();
		unset($user_info['_token']);
		$user_res = Db::table('user')->insert($user_info);
		if ($user_res) {
			return redirect("/index");
		}
	}

	/**
	*	更新数据
	*/
	public function update(Request $request,$id)
	{
		if ($request->isMethod('get')) {
			// 	获取要更新的数据 
		}
	}
}