<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>

		<form action="/user/log" method="post">
			@csrf
				邮箱：<input type="text" value="" name="name"><br><br>
				密码：<input type="password" name="password" ><br><br>
			<button>提交</button>
		</form>
</body>
</html>