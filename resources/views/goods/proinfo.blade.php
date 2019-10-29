<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>商品详情</title>
</head>
<body>
		<h1>商品详情</h1>

		<img src="http://test.com/{{$data->logo}}" width="190px">
		<table border="1">
			<tr>
			<td>自增id:</td>
			<td>商品名称:</td>
 			<td>商品数量：</td>
			<td>商品描述：</td>
			<td>操作</td>
 
		</tr>

			<td>{{$data->tid}}</td>
			<td>{{$data->name}}</td>
			<td>{{$data->num}}</td>
			<td>{{$data->desc}}</td>
			<td><a href="/goods/list">返回商品展示页面</a></td>
			 
		</tr>

		</table>
</body>
</html>