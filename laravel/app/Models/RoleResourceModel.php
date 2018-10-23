<?php 
namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class RoleResourceModel extends Model
{
	protected $table = 'admin_role_resource';

	/**
	*	where条件查询所有,过滤字段
	*/
	public function whereAll($where,$info_resource_id,$id,$where2)
	{
		$result = Db::table($this->table)->whereIn($id,$where)->where($where2)->select($info_resource_id)->get();
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
	*	添加一条，返回影响条数
	*/
	public function getInfo($data)
	{
		foreach($data as $field => $value){
			$this->$field = $value;
		}
		return $this->insert($data);
	}

	/**
	*	where条件删除，返回受影响行数
	*/
	public function deleteInfo($where)
	{
		$result = DB::table($this->table)->where($where)->delete();
		return $result;
	}
	
}	