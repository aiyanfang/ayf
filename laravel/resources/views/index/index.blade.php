<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>数据展示</title>
</head>

<style type="text/css">
	p{font-size:18px;font-weight:bold;padding-left:2rem;}
	table tr td{padding:1rem;}
</style>

<body>
	<div>
		<table>
			<a href="index/create">添加</a>
			<p>数据展示</p>
			<tr>
				<td>ID</td>
				<td>姓名</td>
				<td>密码</td>
				<td>操作</td>
			</tr>
			@foreach ($data as $val)
				<tr>
					<td>{{$val->u_id}}</td>
					<td>{{$val->name}}</td>
					<td>{{$val->pwd}}</td>
					<td>
						<button>删除</button>
						<button>修改</button>
					</td>
				</tr>
			@endforeach
		</table>
	</div>
</body>
</html>

<script>
	
</script>