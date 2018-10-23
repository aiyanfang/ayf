<?php 
namespace App\Http\Controllers\Backend;

use DB;
use Session;
use Illuminate\Http\Request;
use App\Services\PowerService;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
	public $powerService;

	/**
	*	定义构造函数
	*/ 
	public function __construct()
	{
		$this->powerService = new PowerService;
	}

	/**
	*	验证菜单名称唯一性
	*/
	public function menuName(Request $request)
	{
		$menuname = $request->input('menuname');
		$uri = $request->input('uri');
		// 	判断请求数据是否存在且不为空
		if ($request->filled('menuname')) {	
			$data = ['menu_name'=>$menuname];
		}else if ($request->filled('uri')) {
			$data = ['uri'=>$uri];
		}
		$result = $this->powerService->getName($data);
		if ($result) {
			return 2;	//	已存在
		}else{
			return 3;	//	不存在
		}
	}

	/**
	*	权限列表
	*/
	public function list()
	{
		$powerData = $this->powerService->getAll();
		return view('backend.menu.list',['powerData'=>$powerData]);
	}

	/**
	*	权限添加
	*/
	public function insert(Request $request)
	{
		if ($request->isMethod('post')) {
			$result = $this->powerService->saveMenus($request);
			if ($result) {
				return redirect('/message')->with(['message'=>'添加权限成功','url'=>'menu/list','jumpTime'=>3,'status'=>true]);
			}else{
				return redirect('/message')->with(['message'=>'添加权限失败','url'=>'menu/list','jumpTime'=>3,'status'=>false]); 
			}
		}else{

			//	查询所有菜单权限
			$menuData = $this->powerService->getMenus();
			$buttonData = $this->powerService->getButtons();
			return view('backend.menu.insert',['menuData'=>$menuData,'buttonData'=>$buttonData]);
		}
	}

	/**
	*	权限修改
	*/
	public function update(Request $request)
	{
		if ($request->isMethod('post')) {
			$result = $this->powerService->powerUpdate($request);
			if ($result) {
				return redirect('/message')->with(['message'=>'修改权限成功','url'=>'menu/list','jumpTime'=>3,'status'=>true]); 
			}else{
				return redirect('/message')->with(['message'=>'修改权限失败','url'=>'menu/list','jumpTime'=>3,'status'=>false]); 
			}
		}else{
			$data = $request->input('id');
			$menuData = $this->powerService->getWhereAll($data);	//	根据menu_id查询权限
			return view('backend.menu.update',['menuData'=>$menuData]);
		}
	}

	/**
	*	权限删除
	*/
	public function delete(Request $request)
	{
		$result = $this->powerService->powerDelete($request);
		if ($result) {
			return redirect('/message')->with(['message'=>'删除权限成功','url'=>'menu/list','jumpTime'=>3,'status'=>true]); 
		}else{
			return redirect('/message')->with(['message'=>'删除权限失败','url'=>'menu/list','jumpTime'=>3,'status'=>false]); 
		}
	}

}