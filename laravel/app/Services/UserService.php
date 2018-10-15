<?php 
namespace App\Services;

use Session;
use DispatchesJobs;
use App\Jobs\SendEmail;
use App\Models\UserModel;

class UserService
{
	/**
	*	定义模型变量
	*/ 
	public $userModel;
	public $logModel;

	/**
	*	构造函数
	*/ 
	public function __construct()
	{
		$this->userModel = new UserModel('users');
		$this->logModel = new UserModel('login_log');
	}

	/**
	*	验证用户名、邮箱、手机号唯一性
	*/
	public function getName($data)
	{
		$where = $data;	// 	where条件
		return $this->userModel->getOne($where);
	}

	/**
	*	注册用户
	*/
	public function saveRegisterInfo($data)
	{
		$ip = $data['ip'];
		$data = [
			'username'	=>$data['username'],
			'password'	=>md5($data['password']),
			'email'	=>$data['email'],
			'mobile'	=>$data['mobile'],
			'login_time'=>time()
		];
		$userInfo = $this->userModel->getInfoID($data);
		if ($userInfo) {
			Session::put('userInfo',$data);
			$userLog = [
				'ip'	=>$ip,
				'userInfo'	=>$userInfo,
				'username'	=>$data['username'],
			];
			$logResult = $this->saveLoginLog($userLog);
			$email = $this->UserSendEmail($data);
			return true;
		}else{
			return false;
		}
	}

	/**
	*	队列发送邮件
	*/
	public function UserSendEmail($data)
	{
		return dispatch(new SendEmail($data));
	}

	/**
	*	用户登录方式
	*/
	public function getUserInfo($data)
	{
		$where = '';
		$where = ['email'=>$data['username'],'password'=>md5($data['password'])];
		$result = $this->userModel->getOne($where);
		if (empty($result)) {
			$where = ['mobile'=>$data['username'],'password'=>md5($data['password'])];
			$result = $this->userModel->getOne($where);
		}
		if ($result) {
			Session::put('userInfo',$data);
			$userLog = [
				'ip'	=>$data['ip'],
				'u_id'	=>$result['u_id'],
				'username'	=>$data['username'],
			];
			$logResult = $this->saveLoginLog($userLog);
			if ($logResult) {return true;}
			return false;
		}
		return false;
	}

	/**
	*	获取用户地址
	*/ 	
	public function getUserAddress()
	{
		$url ='http://ip.taobao.com/service/getIpInfo.php?ip=' ;
        $ip = '110.96.13.134';
        $path = $url . $ip;
        $res = file_get_contents($path);
        $result = json_decode($res,true);
        $address = $result['data']['country'].$result['data']['region'].$result['data']['city'];
        return $address;
	}

	/**
	*	存进登录日志
	*/
	public function saveLoginLog($userLog)
	{
		$logData = [
			'u_id'	=>$userLog['u_id'],
			'username'	=>$userLog['username'],
			'address'	=>$this->getUserAddress(),
			'ip'	=>$userLog['ip'],
			'last_time'	=>time(),
			'content'	=>'登录成功',
		];
		return $result = $this->logModel->saveInfo($logData);
	}

	/**
	*	欢迎登录
	*/
	public function getLoginInfo($data)
	{
		$where =['u_id'=>$data];
		return $this->userModel->getOne($where);
	}

}
