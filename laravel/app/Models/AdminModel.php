<?php 
namespace App\Models;

use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
	public $table = 'admin';
	protected $primaryKey = 'user_id';		//	设置主键
    public $timestamps = false;				//是否自动添加时间戳

	/**
	*	查询所有管理员    
	*/
	public function getAll()
	{
		$result = DB::table($this->table)->paginate(5);
		return $result;
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