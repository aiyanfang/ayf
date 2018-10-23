<?php 
namespace App\Http\Controllers\Frontend;

use DB;
use Session;
use Illuminate\Http\Request;
use App\Services\UserService;
use Gregwar\Captcha\CaptchaBuilder;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
	/**
	*	定义Service变量
	*/ 
	public $userService;

	/**
	*	定义构造函数
	*/ 
	public function __construct()
	{
		$this->userService = new UserService;
	}

	/**
	*	生成验证码
	*/
    public function captcha($tmp)
    {
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder;
        //可以设置图片宽高及字体
        $builder->build($width = 100, $height = 45, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();
        //把内容存入session
        Session::flash('code', $phrase);
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();

    }

	/**
	*	验证用户名、邮箱、手机号唯一性
	*/
	public function userName(Request $request)
	{
		$username = $request->input('username');
		$email = $request->input('email');
		$mobile = $request->input('mobile');
		// 	判断请求数据是否存在且不为空
		if ($request->filled('username')) {
			$data = ['username'=>$username];
		}else if ($request->filled('email')) {
			$data = ['email'=>$email];
		}else if ($request->filled('mobile')) {
			$data = ['mobile'=>$mobile];
		}
		$result = $this->userService->getName($data);
		if ($result) {
			return 2;	//	已存在
		}else{
			return 3;	//	不存在
		}
	}

	/**
	*	注册页面
	*/
	public function register(Request $request)
	{
		// 	判断提交方式
		if ($request->isMethod('post')) {
			//读取验证码
	        $code = Session::get('code');
	        // 判断验证码
			if ($request->input('captcha') != $code){
				return redirect('/message')->with(['message'=>'验证码错误!','url' =>'/user/register', 'jumpTime'=>3,'status'=>false]);
	    	}else{
	    		// 	用户信息验证规则
	    		$this->validate($request,[
	    			'name'		=> ['regex:/^[\u4E00-\u9FA5A-Za-z]{2,20}$/'],
                    'email'		=> 'required|email',
                    'mobile'	=> ['regex:/^[1][34578]\d{9}$/'],
                    'password' 	=> ['regex:/^[a-z0-9A-Z]\w{5,17}$/'],
                    'repassword' => 'required|same:password',
                ]);
                $data = $request->input();
                $data['ip'] = $request->ip();
                $result = $this->userService->saveRegisterInfo($data);
                if ($result) {
                	return redirect('/message')->with(['message'=>'恭喜你通过邮箱注册','url'=>'goods/index','jumpTime'=>3,'status'=>true]);
                } else {
                    return redirect('/message')->with(['message'=>'注册失败或该邮箱已使用，请重试','url'=>'users/register','jumpTime'=>3,'status'=>false]);
                }
	    	}
		}else{
			return view('frontend.user.register');
		}
	}

	/**
	*	登录页面
	*/
	public function login(Request $request)
	{
		// 判断提交方式
		if ($request->isMethod('post')) {
		       $code = Session::get('code');	//读取验证码
		       // 判断验证码
			if ($request->input('captcha') != $code){
				return redirect('/message')->with(['message'=>'验证码错误!','url' =>'/user/login', 'jumpTime'=>3,'status'=>false]);
		    }else{
		    	// 	用户信息验证规则
		    	$this->validate($request,[
	                   'username' 	=> 'required',
	                   'password' 	=> ['regex:/^[a-z0-9A-Z]\w{5,17}$/'],
	            ]);
		    	$data = $request->input();
		    	$data['ip'] = $request->ip();
		    	$result = $this->userService->getUserInfo($data);
		    	if ($result) {
		    		return redirect('/message')->with(['message'=>'登录成功','url'=>'goods/index','jumpTime'=>3,'status'=>true]); 
		    	}else{
		    		return redirect('/message')->with(['message'=>'用户名或密码错误','url'=>'/user/login','jumpTime'=>3,'status'=>false]); 
		    	}	
		    }
	    }else{
			return view('frontend.user.login');	
		}
	}

	/**
	*	退出
	*/
	public function loginOut()
	{
		Session::pull('userInfo');
		return redirect('/message')->with(['message'=>'退出登录成功','url'=>'goods/index','jumpTime'=>3,'status'=>true]); 
	}

	/**
	*	个人中心
	*/
	public function userInfo()
	{
		return view('frontend.user.userInfo');
	}

}
