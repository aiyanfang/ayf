<?php 
namespace App\Http\Controllers\Backend;

use DB;
use Session;
use Illuminate\Http\Request;
use App\Services\AdminService;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
	public $adminService;

	/**
	*	定义构造函数
	*/ 
	public function __construct()
	{
		$this->adminService = new AdminService;
	}

	/**
	*	用户登录
	*/
	public function login(Request $request)
	{
		if ($request->isMethod('post')) {
			// 	用户信息验证规则
		    $this->validate($request,[
	            'email' 	=> 'required',
	            'password' 	=> ['regex:/^[a-z0-9A-Z]\w{5,17}$/'],
	        ]);
			$data = $request->input();
			$result = $this->adminService->getUserInfo($data);
			if ($result) {
				if ($result->is_freeze == 1) {
					return redirect('/message')->with(['message'=>'登录成功','url'=>'home/index','jumpTime'=>3,'status'=>true]); 
				}else{
					return redirect('/message')->with(['message'=>'账号已冻结','url'=>'admin/login','jumpTime'=>3,'status'=>false]); 
				}
			}else{
		    	return redirect('/message')->with(['message'=>'用户名或密码错误','url'=>'admin/login','jumpTime'=>3,'status'=>false]); 
		    }
		}else{
			return view('backend.admin.login');
		}
	}

	/**
	*	退出
	*/
	public function loginOut()
	{
		Session::pull('userInfo');
		return redirect('/message')->with(['message'=>'退出登录成功','url'=>'admin/login','jumpTime'=>3,'status'=>true]); 
	}

	/**
	*	验证用户名、邮箱、手机号唯一性
	*/
	public function userName(Request $request)
	{
		$username = $request->input('username');
		$email = $request->input('email');
		$mobile = $request->input('mobile');
		// 	判断请求数据是否存在且不为空
		if ($request->filled('username')) {
			$data = ['username'=>$username];
		}else if ($request->filled('email')) {
			$data = ['email'=>$email];
		}else if ($request->filled('mobile')) {
			$data = ['mobile'=>$mobile];
		}
		$result = $this->adminService->getName($data);
		if ($result) {
			return 2;	//	已存在
		}else{
			return 3;	//	不存在
		}
	}

	/**
	*	添加管理员
	*/
	public function insert(Request $request)
	{
		if($request->isMethod('post')){
			// 	用户信息验证规则
	    	$this->validate($request,[
	    		'name'		=> ['regex:/^[\u4E00-\u9FA5A-Za-z]{2,20}$/'],
                'email'		=> 'required|email',
                'mobile'	=> ['regex:/^[1][34578]\d{9}$/'],
                'password' 	=> ['regex:/^[a-z0-9A-Z]\w{5,17}$/'],
            ]);
			$result = $this->adminService->saveAdmin($request);
			if ($result) {
				return redirect('/message')->with(['message'=>'添加管理员成功','url'=>'admin/list','jumpTime'=>3,'status'=>true]); 
			}else{
				return redirect('/message')->with(['message'=>'添加管理员失败','url'=>'admin/list','jumpTime'=>3,'status'=>false]); 
			}
		}else{
			$roles = $this->adminService->getRoles();
			return view('backend.admin.insert',['roles'=>$roles]);
		}
	}

	/**
	*	管理员列表
	*/
	public function list()
	{
		$adminData = $this->adminService->adminList();
		return view('backend.admin.list',['adminData'=>$adminData]);
	}

	/**
	*	删除管理员
	*/
	public function delete(Request $request)
	{
		$result = $this->adminService->adminDelete($request);
		if ($result) {
			return redirect('/message')->with(['message'=>'删除管理员成功','url'=>'admin/list','jumpTime'=>3,'status'=>true]); 
		}else{
			return redirect('/message')->with(['message'=>'删除管理员失败','url'=>'admin/list','jumpTime'=>3,'status'=>false]); 
		}
	}

	/**
	*	修改管理员
	*/
	public function update(Request $request)
	{
		if ($request->isMethod('post')) {
			$result = $this->adminService->adminUpdate($request);
			if ($result) {
				return redirect('/message')->with(['message'=>'修改管理员成功','url'=>'admin/list','jumpTime'=>3,'status'=>true]); 
			}else{
				return redirect('/message')->with(['message'=>'修改管理员失败','url'=>'admin/list','jumpTime'=>3,'status'=>false]); 
			}
		}else{
			$data = $request->input('id');
			$roles = $this->adminService->getRoles();
			$roleData = $this->adminService->getAdminRoles($data);
			$updateData = $this->adminService->getAdminUpdate($data);
			return view('backend.admin.update',['updateData'=>$updateData,'roles'=>$roles,'roleData'=>$roleData]);
		}
	}

}