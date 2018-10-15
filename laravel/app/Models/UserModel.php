<?php 
namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
	public $table;

	/**
	*	定义构造函数
	*/ 
	public function __construct($table)
	{
		$this->table = $table;
	}

	/**
	*	查询所有
	*/
	public function getAll()
	{
		$result = DB::table($this->table)->get();
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
	*	where条件查询所有
	*/
	public function whereAll($where)
	{
		$result = Db::table($this->table)->where($where)->get();
		return $result = json_decode($result,true);
	}

	/**
	*	两表联查
	*/
	public function getJoin($where)
	{
		$result = Db::table($this->table)->join($where)->get();
		return $result = json_decode($result,true);
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
	*	添加一条，返回影响行数
	*/
	public function saveInfo($data)
	{
		foreach($data as $field => $value){
			$this->$field = $value;
		}
		return $this->insert($data);
	}

	/**
	*	where条件修改
	*/
	public function updateInfo($where)
	{
		$result = DB::talbe($this->table)->where($where)->update();
		return $result;
	}
}
