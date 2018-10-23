<?php 
namespace App\Services;

use DB;
use Session;
use App\Models\RoleModel;
use App\Models\MenuModel;
use App\Models\ButtonModel;
use App\Models\AdminRoleModel;
use App\Models\RoleResourceModel;

class RoleService
{
	public $roleModel;
	public $menuModel;
	public $buttonModel;
	public $roleresource;
	public $adminrole;
	public function __construct()
	{
		$this->roleModel = new RoleModel;
		$this->menuModel = new MenuModel;
		$this->buttonModel = new ButtonModel;
		$this->adminrole = new AdminRoleModel;
		$this->roleresource = new RoleResourceModel;
	}

	/**
	*	验证用户名、邮箱、手机号唯一性
	*/
	public function getName($data)
	{
		$where = $data;	// 	where条件
		return $this->roleModel->getOne($where);
	}
	
	/**
	*	查询所有角色
	*/
	public function getAll()
	{
		$result = $this->roleModel->getLimitAll();
		return $result;
	}

	/**
	*	where条件查询所有
	*/
	public function whereAll($data)
	{
		$where = ['role_id'=>$data];
		$result = $this->roleModel->whereAll($where);
		foreach ($result as $key => $value) {
			$roles = ['role_id'=>$value['role_id'],'role_name'=>$value['role_name']];
		}
		return $roles;
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
	*	查询所有菜单权限
	*/
	public function getMenus()
	{
		$menuData = $this->menuModel->getAll();
		$menus = $this->createTree($menuData);
		return $menus;
	}

	/**
	*	查询所有按钮权限
	*/
	public function getButton()
	{
		$buttonData = $this->buttonModel->getAll();
		return $buttonData;
	}

	/**
	*	添加角色
	*/
	public function saveRole($request)
	{
		$result = true;
		$data = $request->input();
		$roleData['role_name'] =$data['rolename'];
		DB::beginTransaction();
        try{
            $roleID = $this->roleModel->getInfoID($roleData);
            //  给角色添加权限
            foreach ($data['menus'] as $k => $value) {
                $powerData[$k] = ['role_id' =>$roleID,'resource_id' =>$value,];
            }
            $role_resource = $this->roleresource->getInfo($powerData);
            DB::commit();
        }catch(\Exception $e){
            $result = false;
            DB::rollBack();
        }
		return $result;
	}

	/**
    *   修改角色
    */
    public function roleUpdate($request)
    {
        $result = true;
        $data = $request->input();
        $where = ['role_id'=>$data['role_id']];
        $updateData = ['role_name'=>$data['role_name']];
        $result = $this->roleModel->upInfo($where,$updateData);
        return $result;
    }

    /**
    *   删除角色
    */
    public function roleDelete($request)
    {
        $result = true;
        $data = $request->input('id');
        $where = ['role_id'=>$data];
        DB::beginTransaction();
        try{
            //  删除该角色的权限
            $resource_reslut = $this->roleresource->deleteInfo($where);
            //  删除该角色所属的管理员
            $role_result = $this->adminrole->deleteInfo($where);
            //  删除该角色
            $admin_result = $this->roleModel->deleteInfo($where);
            DB::commit();
        }catch(\Exception $e){
            $result = false;
            DB::rollBack();
        }
        return $result;
    }
}

