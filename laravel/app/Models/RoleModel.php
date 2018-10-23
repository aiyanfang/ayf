<?php 
namespace App\Models;

use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
	// 	设置主键
	protected $table = 'admin_role';
	protected $primaryKey = 'role_id';

	/**
	*	查询所有
	*/
	public function getAll()
	{
		$result = DB::table($this->table)->get();
		return $result = json_decode($result,true);
	}

	/**
	*	查询所有
	*/
	public function getLimitAll()
	{
		$result = DB::table($this->table)->paginate(5);
		return $result;
	}

	/**
	*	where条件查询所有
	*/
	public function whereAll($where)
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
	public function getInfoID($data)
	{
		foreach($data as $field => $value){
			$this->$field = $value;
		}
		return $this->insertGetId($data);
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
	*	where条件删除，返回受影响行数
	*/
	public function deleteInfo($where)
	{
		$result = DB::table($this->table)->where($where)->delete();
		return $result;
	}
}