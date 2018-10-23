<?php 
namespace App\Http\Controllers\Backend;

use DB;
use Session;
use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
	public $roleService;

	/**
	*	定义构造函数
	*/ 
	public function __construct()
	{
		$this->roleService = new RoleService;
	}

	/**
	*	验证角色唯一性
	*/
	public function roleName(Request $request)
	{
		$rolename = $request->input('rolename');

		// 	判断请求数据是否存在且不为空
		if ($request->filled('rolename')) {	
			$data = ['role_name'=>$rolename];
		}
		$result = $this->roleService->getName($data);
		if ($result) {
			return 2;	//	已存在
		}else{
			return 3;	//	不存在
		}
	}

	/**
	*	角色列表
	*/
	public function list()
	{
		$roleData = $this->roleService->getAll();
		return view('backend.role.list',['roleData'=>$roleData]);
	}

	/**
	*	角色添加
	*/
	public function insert(Request $request)
	{
		if ($request->isMethod('post')) {
			$result = $this->roleService->saveRole($request);
			if ($result) {
				return redirect('/message')->with(['message'=>'添加角色成功','url'=>'role/list','jumpTime'=>3,'status'=>true]);  
			}else{
				return redirect('/message')->with(['message'=>'添加角色失败','url'=>'role/list','jumpTime'=>3,'status'=>false]); 
			}
		}else{

			$roleData = $this->roleService->getAll();		// 	查询所有角色
			$menuData = $this->roleService->getMenus();		//	查询所有菜单权限
			return view('backend.role.insert',['roleData'=>$roleData,'menuData'=>$menuData]);
		}
	}

	/**
	*	修改角色
	*/
	public function update(Request $request)
	{
		if ($request->isMethod('post')) {
			$result = $this->roleService->roleUpdate($request);
			if ($result) {
				return redirect('/message')->with(['message'=>'修改角色成功','url'=>'role/list','jumpTime'=>3,'status'=>true]); 
			}else{
				return redirect('/message')->with(['message'=>'修改角色失败','url'=>'role/list','jumpTime'=>3,'status'=>false]); 
			}
		}else{
			$data = $request->input('id');
			$roleData = $this->roleService->whereAll($data);	//	根据role_id查询角色
			return view('backend.role.update',['roleData'=>$roleData]);
		}
	}

	/**
	*	删除角色
	*/
	public function delete(Request $request)
	{
		$result = $this->roleService->roleDelete($request);
		if ($result) {
			return redirect('/message')->with(['message'=>'删除角色成功','url'=>'role/list','jumpTime'=>3,'status'=>true]); 
		}else{
			return redirect('/message')->with(['message'=>'删除角色失败','url'=>'role/list','jumpTime'=>3,'status'=>false]); 
		}
	}
}