<?php 
namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class ButtonModel extends Model
{
	protected $table = 'admin_button';
	protected $primarykey = 'button_id';
	
	/**
	*	查询所有按钮权限
	*/
	public function getAll()
	{
		$result = DB::table($this->table)->get();
		return $result = json_decode($result,true);
	}
}