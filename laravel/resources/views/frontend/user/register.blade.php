<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="author" content="order by dede58.com"/>
		<title>用户注册</title>
		<link rel="stylesheet" type="text/css" href="{{URL::asset('goods/css/login.css')}}">
		<script type="text/javascript" src="{{URL::asset('js/jquery-1.7.2.min.js')}}"></script>
	</head>
	<body>
		<form  method="post" action="register">
		@csrf
		<div class="regist">
			<div class="regist_center">
				<div class="regist_top">
					<div class="left fl">会员注册</div>
					<div class="right fr"><a href="{{asset('goods/index')}}" target="_self">小米商城</a></div>
					<div class="clear"></div>
					<div class="xian center"></div>
				</div>
				<div class="regist_main center">
					<div class="username">
						用&nbsp;&nbsp;户&nbsp;&nbsp;名:&nbsp;&nbsp;
						<input class="shurukuang" type="text" name="username" placeholder="请输入用户名" id="username"/>
						<span id="username_info">请输入用户名</span>
					</div>
					
					<div class="username">
						密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码:&nbsp;&nbsp;
						<input class="shurukuang" type="password" name="password" placeholder="请输入你的密码" id="password"/>
						<span id="password_info">请输入6位以上字符</span>
					</div>
					<div class="username">
						确认密码:&nbsp;&nbsp;
						<input class="shurukuang" type="password" name="repassword" placeholder="请确认你的密码" id="repassword"/>
						<span id="repassword_info">两次密码要输入一致哦</span>
					</div>
					<div class="username">
						邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱:&nbsp;&nbsp;
						<input class="shurukuang" type="email" name="email" placeholder="请输入邮箱" id="email"/>
						<span id="email_info">请输入邮箱</span>
					</div>
					<div class="username">
						手&nbsp;&nbsp;机&nbsp;&nbsp;号:&nbsp;&nbsp;
						<input class="shurukuang" type="text" name="mobile" placeholder="请输入手机号" id="mobile"/>
						<span id="mobile_info">请输入手机号</span>
					</div>
					<div class="username">
						<div class="left fl">
							验&nbsp;&nbsp;证&nbsp;&nbsp;码:&nbsp;&nbsp;
							<input class="yanzhengma" type="text" name="code" placeholder="请输入验证码" id="code" />
						</div>
						<div class="right fl">
							<a onclick="javascript:re_captcha();" >
            					<img src="{{ URL('user/captcha/1') }}"  alt="验证码" title="刷新图片" width="100" height="45" id="c2c98f0de5a04167a9e427d883690ff6" border="0">
        					</a>
        					<span id="code_info">请输入验证码</span>
						</div>
						<div class="clear"></div>
					</div>
					
				<div class="regist_submit">
					<input class="submit" type="submit" name="submit" value="立即注册" >
				</div>
				
			</div>
		</div>
		</form>
	</body>
</html>

<script>

	// 	验证码验证
	function re_captcha()
	{
		$url = "{{URL('user/captcha')}}";
		$url = $url + "/" + Math.random();
        document.getElementById('c2c98f0de5a04167a9e427d883690ff6').src=$url;
	}

	// 	用户信息验证
	$(document).ready(function(){

		var checkUsername = '';
		var checkPassword = '';
		var checkRepassword = '';
		var checkEmail = '';
		var checkMobile = '';
		var checkCode = '';

		// 	用户名验证
		$("#username").blur(function(){
			var username = $(this).val();
			regular = /^[\u4E00-\u9FA5A-Za-z]{2,20}$/;
			if (username == '') {
				$('#username_info').text('用户名不能为空');$('#username').css('border-color','red');
				checkUsername = false;
			}else if (regular.test(username)) {
				$('#username_info').text("用户名验证成功");$('#username').css('border-color','green');
				$.ajax({
					url:'userName',
					type:'POST',
					data:{'_token':'{{csrf_token()}}','username':username},
					success:function(msg){
						if (msg == 2) {
							alert("用户名已存在");
							checkUsername = false;
						}else{
							checkUsername = true;
						}
					},
					error:function(msg){
						alert("服务器繁忙");
					}
				})
			}else{
				$("#username_info").text("用户名必须由汉字，字母组成");$('#username').css('border-color','red');
				checkUsername = false;
			}
		})

		// 	密码验证
		$("#password").blur(function(){
			var password = $(this).val();
			regular = /^[a-z0-9A-Z]\w{5,17}$/;
			if (password == '') {
				$('#password_info').text('密码不能为空');$('#password').css('border-color','red');
				checkPassword = false;
			}else if (regular.test(password)) {
				$('#password_info').text('密码验证成功');$('#password').css('border-color','green');
				checkPassword = true;
			}else{
				$('#password_info').text('密码长度必须5-17位之间');$('#password').css('border-color','red');
				checkPassword = false;
			}
		})

		// 	验证确认密码与密码是否一致
		$("#repassword").blur(function(){
			var password = $("#password").val();
			var repassword = $(this).val();
			if (password == '' && repassword == '') {
				$('#repassword_info').text('确认密码不能为空');$('#repassword').css('border-color','red');
				checkRepassword = false;
			}else if (repassword == password){
				$('#repassword_info').text('确认密码与密码一致');$('#repassword').css('border-color','green');
				checkRepassword = true;
			}else{
				$('#repassword_info').text('确认密码与密码不一致');$('#repassword').css('border-color','red');
				checkRepassword = false;
			}
		})

		// 	邮箱验证
		$("#email").blur(function(){
			var email = $(this).val();
			var regular = /^[A-Za-z0-9]+\@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
			if (email == '') {
				$('#email_info').text('邮箱不能为空');$('#email').css('border-color','red');
				checkEmail = false;
			}else if (regular.test(email)) {
				$('#email_info').text("邮箱验证成功");$('#email').css('border-color','green');
				$.ajax({
					url:'userName',
					type:'POST',
					data:{'_token':'{{csrf_token()}}','email':email},
					success:function(msg){
						if (msg == 2) {
							alert("邮箱已存在");
							checkEmail = false;
						}else{
							checkEmail = true;
						}
					},
					error:function(msg){
						alert("服务器繁忙");
					}
				})
			}else{
				$("#email_info").text("邮箱格式不正确");$('#email').css('border-color','red');
				checkNick = false;
			}
		})


		// 	手机号验证
		$("#mobile").blur(function(){
			var mobile = $(this).val();
			var regular = /^[1][34578]\d{9}$/;
			if (mobile == '') {
				$('#mobile_info').text('手机号不能为空');$('#mobile').css('border-color','red');
				return checkMobile = false;
			}else if (regular.test(mobile)) {
				$('#mobile_info').text('手机号验证成功');$('#mobile').css('border-color','green');
				$.ajax({
					url:'userName',
					type:'POST',
					data:{'_token':'{{csrf_token()}}','mobile':mobile},
					success:function(msg){
						if (msg == 2) {
							alert("手机号已存在");
							checkMobile = false;
						}else{
							checkMobile = true;
						}
					},
					error:function(msg){
						alert("服务器繁忙");
					}
				})
			}else{
				$('#mobile_info').text('验证失败');$('#mobile').css('border-color','red');
				return checkMobile = false;
			}
			
		})


		// 	验证码验证
		$("#code").blur(function(){
			var code = $(this).val();
			if (code == '') {
				$('#code_info').text('验证码不能为空');$('#repassword').css('border-color','red');
				checkCode = false;
			}
			checkCode = true;

		})
		
		// 表单提交
		$('.submit').click(function(){
	    	if(checkUsername && checkPassword && checkRepassword && checkCode && checkEmail && checkMobile){
    			$('form').submit();
	    	}else{
	    		return false;
	    	}
	   	});
	});

</script>