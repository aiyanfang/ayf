<?php 
namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class AdminRoleModel extends Model
{
	protected $table = 'admin_user_role';

	/**
	*	where条件查询所有
	*/
	public function whereAll($where,$info)
	{
		$result = Db::table($this->table)->where($where)->select($info)->get();
		return $result = json_decode($result,true);
	}

	/**
	*	添加一条，返回影响行数
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