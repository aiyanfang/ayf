<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>添加数据</title>
</head>

<style type="text/css">
	.p1{font-size:18px;font-weight:bold;padding-left:2rem;}
	.submit{margin-left:2rem;}

</style>

<body>
	<div>
		<form action="/index" method="post">
		 	{{csrf_field()}}
			<p class="p1">添加用户信息</p>
			<p>
				用户名：
				<input type="text" name="name">
			</p>
			<p>
				密码：&nbsp;&nbsp;&nbsp;
				<input type="password" name="pwd">
			</p>
			<p>
				<input type="submit" value="提交" class="submit">
			</p>
		</form>
	</div>
</body>
</html>