<?php 
namespace App\Services;

use DB;
use Session;
use App\Models\MenuModel;
use App\Models\ButtonModel;
use App\Models\RoleResourceModel;

class PowerService
{
	public $menuModel;
	public $buttonModel;
	public $roleresource;
	public function __construct()
	{
		$this->menuModel = new MenuModel;
		$this->buttonModel = new ButtonModel;
		$this->roleresource = new RoleResourceModel;
	}

	/**
	*	验证菜单名称唯一性
	*/
	public function getName($data)
	{
		$where = $data;	// 	where条件
		return $this->menuModel->getOne($where);
	}

	/**
	*	获取权限列表
	*/
	public function getAll()
	{
		$result = $this->menuModel->getAll();
		return $result;
	}

	/**
	*	where条件，获取权限列表
	*/
	public function getWhereAll($data)
	{
		$where = ['menu_id'=>$data];
		$result = $this->menuModel->getWhereAll($where);
		foreach ($result as $key => $value) {
			$menus = [
				'menu_id'=>$value['menu_id'],
				'menu_name'=>$value['menu_name'],
				'uri'	=>$value['uri'],
				'pid'	=>$value['pid'],
				'path'	=>$value['path'],
				'is_menu'=>$value['is_menu'],
			];
		}
		return $menus;
	}

	/**
    *	无限级分类
    */
    public function createTree($data,$parent_id = 0,$level = 0,$html='|--')
    {
    	$tree = [];
    	foreach ($data as $key => $value) {
    		// 	获取的pid == $parent_id
    		if ($value['pid'] == $parent_id) {
    			$value['level'] = $level;
    			$value['html'] = str_repeat($html,$level);
    			$value['son'] = $this->createTree($data,$value['menu_id'],$level+1,$html);
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
	*	查询按钮
	*/
	public function getButtons()
	{
		$result = $this->buttonModel->getAll();
		return $result;
	}

	/**
	*	添加权限
	*/
	public function saveMenus($request)
	{
		$data = $request->input();
		//	获取最后一行ID
		$id = 'menu_id';
		$last_id = $this->menuModel->getLastID($id);
		$path = $last_id['menu_id'] + 1;
		if ($data['parent_id'] == 0) {
			$menuData = [
				'menu_name'	=>$data['menuname'],
				'uri'		=>$data['uri'],
				'pid'		=>$data['parent_id'],
				'path'		=>$path,
			];
		}else{
			$menuData = [
				'menu_name'	=>$data['menuname'],
				'uri'		=>$data['uri'],
				'pid'		=>$data['parent_id'],
				'path'		=>$data['parent_id']."-".$path,
			];
		}
		$menuID = $this->menuModel->getMenuID($menuData);
		if ($menuID) {
			return true;
		}else{
			return false;
		}
	}

	/**
    *   修改权限
    */
    public function powerUpdate($request)
    {
        $result = true;
        $data = $request->input();
        $where = ['menu_id'=>$data['menu_id']];
        $updateData = ['menu_name'=>$data['menu_name']];
        $result = $this->menuModel->upInfo($where,$updateData);
        return $result;
    }

    /**
    *   删除权限
    */
    public function powerDelete($request)
    {
        $result = true;
        $data = $request->input('id');
        DB::beginTransaction();
        try{
        	$where1 = ['resource_id'=>$data];
            //  删除该角色的权限
            $resource_reslut = $this->roleresource->deleteInfo($where1);
            //  删除该权限
            $where2 = ['menu_id'=>$data];
            $menu_result = $this->menuModel->deleteInfo($where2);
            DB::commit();
        }catch(\Exception $e){
            $result = false;
            DB::rollBack();
        }
        return $result;	
    }
}