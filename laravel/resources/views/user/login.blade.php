<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="author" content="order by dede58.com"/>
		<title>会员登录</title>
		<link rel="stylesheet" type="text/css" href="{{URL::asset('goods/css/login.css')}}">
		<script type="text/javascript" src="{{URL::asset('js/jquery-1.7.2.min.js')}}"></script>

	</head>
	<body>
		<!-- login -->
		<div class="top center">
			<div class="logo center">
				<a href="./index.html" target="_blank"><img src="./image/mistore_logo.png" alt=""></a>
			</div>
		</div>
		<form  method="post" action="login" class="form center">
			@csrf
		<div class="login">
			<div class="login_center">
				<div class="login_top">
					<div class="left fl">会员登录</div>
					<div class="right fr">您还不是我们的会员？<a href="{{asset('user/register')}}" target="_self">立即注册</a></div>
					<div class="clear"></div>
					<div class="xian center"></div>
				</div>

				<div class="login_main center">
					<div class="username">
						用户名:&nbsp;
						<input class="shurukuang" type="text" name="username" placeholder="请输入你的用户名" id="username" />
						<span id="username_info"></span>
					</div>
					<div class="username">
						密&nbsp;&nbsp;&nbsp;&nbsp;码:&nbsp;
						<input class="shurukuang" type="password" name="password" placeholder="请输入你的密码" id="password" />
						<span id="password_info"></span>
					</div>
					<div class="username">
						<div class="left fl">
						验证码:&nbsp;
						<input class="yanzhengma" type="text" name="captcha" placeholder="请输入验证码" id="code" />
					</div>
						<div class="right fl">
							<a onclick="javascript:re_captcha();" >
            					<img src="{{ URL('user/captcha/1') }}"  alt="验证码" title="刷新图片" width="100" height="45" id="c2c98f0de5a04167a9e427d883690ff6" border="0">
        					</a>
						</div>
						<div class="clear"></div>
					</div>

				</div>
				<div class="login_submit">
					<input type="submit" class="submit" name="submit" value="立即登录">
				</div>

			</div>
		</div>
		</form>
		<footer>
			<div class="copyright">简体 | 繁体 | English | 常见问题</div>
			<div class="copyright">小米公司版权所有-京ICP备10046444-<img src="./image/ghs.png" alt="">京公网安备11010802020134号-京ICP证110507号</div>

		</footer>
	</body>
</html>

<script>

	var checkUsername = '';
	var checkCode	= '';
	var checkPassword = '';

	//	用户名验证
	$("#username").blur(function(){
		var username = $(this).val();
		if (username == '') {
			$('#username_info').text('✘');$('#username').css('border-color','red');
			checkUsername = false;
		}else{
			$('#username_info').text('✔');$('#username').css('border-color','green');
			checkUsername = true;
		}
	})

	//	密码验证
	$("#password").blur(function(){
		var password = $(this).val();
		if (password == '') {
			$('#password_info').text('✘');$('#password').css('border-color','red');
			checkPassword = false;
		}else{
			$('#password_info').text('✔');$('#password').css('border-color','green');
			checkPassword = true;
		}
	})

	// 	验证码
	$("#code").blur(function(){
		var code = $(this).val();
		if (code == '') {
			checkCode = false;
		}
		checkCode = true;

	})
	// 	验证码验证
	function re_captcha()
	{
		$url = "{{URL('user/captcha')}}";
		$url = $url + "/" + Math.random();
        document.getElementById('c2c98f0de5a04167a9e427d883690ff6').src=$url;
	}

	// 表单验证
	$(".submit").click(function(){
		if (checkUsername && checkPassword && checkCode) {
			$('form').submit();
		}else{
			return false;
		}
	})

	
</script>