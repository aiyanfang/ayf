<?php 
namespace App\Services;

use DB;
use Session;
use App\Models\AdminModel;
use App\Models\AdminRoleModel;
use App\Models\RoleModel;
use App\Models\MenuModel;
use App\Models\ButtonModel;
use App\Models\RoleResourceModel;


class AdminService
{
	public $admin;
	public $rolesModel;
	public $adminrole;

	/**
	*	构造函数
	*/ 
	public function __construct()
	{
		$this->admin = new AdminModel;
		$this->rolesModel = new RoleModel;
		$this->adminrole = new AdminRoleModel;
        $this->roleresource = new RoleResourceModel;
        $this->menuModel = new MenuModel;
	}

	/**
	*	登录查询用户表
	*/
	public function getUserInfo($data)
	{
		$where = ['email'=>$data['email'],'password'=>md5($data['password'])];
		$result = AdminModel::where($where)->first();
		if ($result) {
			$result->login_time = time();
			$data = json_decode($result,true);
			$where = ['user_id'=>$result['user_id']];
			if ($result->where($where)->update($data)) {
				Session::put('userInfo',$data);
				return $result;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	/**
    *	无限级分类
    */
    public function createTree($data,$parent_id = 0,$level = 0)
    {
    	$tree = [];
    	foreach ($data as $key => $value) {
    		// 	获取的pid == $parent_id
    		if ($value['pid'] == $parent_id) {
    			$value['level'] = $level;
    			$value['son'] = $this->createTree($data,$value['menu_id'],$level+1);
    			$tree[] = $value;
    		}
    	}
    	return $tree;
    }

	/**
     * 	获取用户菜单权限
    */
    public function getUserMenu()
    {
        //    获取用户信息
       	$userInfo = Session::get('userInfo');
        //  查询用户角色表           
        $where = ['user_id'=>$userInfo['user_id']];
        $info = 'role_id';
        $resource = $this->adminrole->whereAll($where,$info);
        //  转化为一维数组
        $role_id = array_column($resource,'role_id');
        //  通过role_id查询角色资源表
        $where2 = ['resource_type'=>1];     //  过滤到按钮
        $id = 'role_id';                    //  查询条件
        $info_resource_id = 'resource_id';              //  要获取的字段
        $resource_reslut = $this->roleresource->whereAll($role_id,$info_resource_id,$id,$where2);
        $resource_id = array_column($resource_reslut,'resource_id');
        //  通过resource_id查询菜单表
        $info_menu_id = 'menu_id';
        $where3 = ['is_menu'=>1];     //  是否展示
        $menuData = $this->menuModel->getAdminWhereAll($resource_id,$info_menu_id,$where3);
        //  调用无限极分类
        $menus = $this->createTree($menuData);
        foreach ($menus as $key => $value) {
            $getMenus[$key] = ['text'=>$value['menu_name'],'url'=>$value['uri'],'icon'=>'user','level'=>$value['level']];
            foreach ($value['son'] as $k => $item) {
                $getMenus[$key]['submenu'][] = ['text'=>$item['menu_name'],'url'=>$item['uri'],'level'=>$item['level']];
            }
        }
        if (isset($getMenus)) {return $getMenus;}
    }

    /**
	*	验证用户名、邮箱、手机号唯一性
	*/
	public function getName($data)
	{
		$where = $data;	// 	where条件
		return $this->admin->getOne($where);
	}

    /**
    *	查询所有角色
    */
    public function getRoles()
    {
    	$result = $this->rolesModel->getAll();
    	return $result;
    }

    /**
    *   查询此管理员所有角色
    */
    public function getAdminRoles($data)
    {
        $where = ['user_id'=>$data];
        $info = 'role_id';
        $result = $this->adminrole->whereAll($where,$info);
        $roleData = array_column($result,'role_id');
        foreach ($roleData as $key => $value) {
            $role_id['role_id'] = $value;
        }
        return $role_id;
    }


    /**
    *	添加管理员
    */
    public function saveAdmin($request)
    {
        $result = true;
    	$data = $request->input();
    	$adminData = [
    		'username' 	=>$data['username'],
    		'password'	=>md5($data['password']),
    		'email'		=>$data['email'],
    		'mobile'	=>$data['mobile'],
    		'create_name'=>$data['create_name'],
    		'create_time'=>time(),
    		'update_time'=>time(),
    		'login_time'=>time(),
    	];
        DB::beginTransaction();
        try{
            $adminID = $this->admin->getInfoID($adminData);
            //  给用户添加角色
            foreach ($data['role'] as $key => $value) {
                $roleData[$key] = ['user_id' =>$adminID,'role_id' =>$value,];
            }
            $admin_role = $this->adminrole->getInfo($roleData); 
            DB::commit();
        }catch(\Exception $e){
            $result = false;
            DB::rollBack();
        }
        return $result;
    }

    /**
    *   管理员列表展示
    */
    public function adminList()
    {
        $data = $this->admin->getAll();
        return $data;
    }

    /**
    *   查询管理员要修改的数据
    */
    public function getAdminUpdate($data)
    {
        $where = ['user_id'=>$data];
        $data = $this->admin->getOne($where);
        return $data;
    }

    /**
    *   修改管理员
    */
    public function adminUpdate($request)
    {
        $result = true;
        $data = $request->input();
        DB::beginTransaction();
        try{
            //  先删除原有角色
            $where = ['user_id'=>$data['user_id']];
            $delete_result = $this->adminrole->deleteInfo($where);
            //  重新赋值
            foreach ($data['roles'] as $key => $value) {
                $updateData[$key] = ['user_id'=>$data['user_id'],'role_id'=>$value];
            }
            $role_result = $this->adminrole->getInfo($updateData);
            DB::commit();
        }catch(\Exception $e){
            $result = false;
            DB::rollBack();
        }
        return $result; 
    }

    /**
    *   删除管理员
    */
    public function adminDelete($request)
    {
        $result = true;
        $data = $request->input('id');
        DB::beginTransaction();
        try{
            $where = ['user_id'=>$data];
            //  删除该管理员的权限
            $resource_reslut = $this->roleresource->deleteInfo($where);
            //  删除该管理员的角色
            $role_result = $this->adminrole->deleteInfo($where);
            //  删除该管理员
            $admin_result = $this->admin->deleteInfo($where);
            DB::commit();
        }catch(\Exception $e){
            $result = false;
            DB::rollBack();
        }
        return $result;
    }

    /**
    *   获取该用户所有的权限
    */
    public function power($path)
    {
        //    获取用户信息
        $userInfo = Session::get('userInfo');
        //  查询用户角色表          
        $where = ['user_id'=>$userInfo['user_id']];
        $info = 'role_id';
        $resource = $this->adminrole->whereAll($where,$info);
        //  转化为一维数组
        $role_id = array_column($resource,'role_id');
        //  通过role_id查询角色资源表
        $where2 = ['resource_type'=>1];     //  过滤到按钮
        $id = 'role_id';                    //  查询条件
        $info_resource_id = 'resource_id';              //  要获取的字段
        $resource_reslut = $this->roleresource->whereAll($role_id,$info_resource_id,$id,$where2);
        $resource_id = array_column($resource_reslut,'resource_id');
        //  通过resource_id查询菜单表
        $info_menu_id = 'menu_id';
        $menuData = $this->menuModel->whereAll($resource_id,$info_menu_id);
        $menuData = array_column($menuData,'uri');

        return in_array($path, $menuData)?true:false;
    }
}