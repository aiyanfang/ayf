<?php 
namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
	protected $table = 'admin_menu';
	protected $primarykey = 'menu_id';	//	设置主键

	/**
	*	查询所有菜单权限
	*/
	public function getAll()
	{
		$result = DB::table($this->table)->get();
		return $result = json_decode($result,true);
	}

	/**
	*	where条件多参数，查询所有
	*/
	public function whereAll($where,$info_menu_id)
	{
		$result = Db::table($this->table)->whereIn($info_menu_id,$where)->get();
		return $result = json_decode($result,true);
	}
	
	/**
	*	where条件多参数，查询所有
	*/
	public function getAdminWhereAll($where,$info_menu_id,$where3)
	{
		$result = Db::table($this->table)->whereIn($info_menu_id,$where)->where($where3)->get();
		return $result = json_decode($result,true);
	}

	/**
	*	where条件查询所有
	*/
	public function getWhereAll($where)
	{
		$result = Db::table($this->table)->where($where)->get();
		return $result = json_decode($result,true);
	}

	/**
	*	where条件查询一条
	*/
	public function getOne($where)
	{
		$result = DB::table($this->table)->where($where)->first();
		if ($result) {
			$result = get_object_vars($result);	// 	转化为数组
		}
		return $result;
	}

	/**
	*	添加一条，返回插入行ID
	*/
	public function getMenuID($data)
	{
		foreach($data as $field => $value){
			$this->$field = $value;
		}
		return $this->insertGetId($data);
	}

	/**
	*	获取最后一条ID
	*/
	public function getLastID($id)
	{
		$result = DB::table($this->table)->orderBy($id,'desc')->select($id)->first();
		return $result = get_object_vars($result);
	}

	/**
	*	where条件修改
	*/
	public function upInfo($where,$data)
	{
		$result = DB::table($this->table)->where($where)->update($data);
		return $result;
	}

	/**
	*	where条件删除
	*/
	public function deleteInfo($where)
	{
		$result = DB::table($this->table)->where($where)->delete();
		return $result;
	}
}