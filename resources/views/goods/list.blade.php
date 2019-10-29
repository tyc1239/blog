<link rel="stylesheet" href="{{asset('css/page.css')}}" type="text/css">
@if (session('msg'))
 <div class="alert alert-success">
 {{ session('msg') }}
 </div>
@endif
<form action="">
		<input type="text" name="name" value="{{$name}}" placeholder="请输入商品名字">
 		<button>搜索</button>

</form>



<table border="1" cellspacing="0" cellpadding="0">
		<tr>
			<td>自增id:</td>
			<td>商品名称:</td>
			<td>商品图片：</td>
			<td>商品数量：</td>
			<td>商品描述：</td>
			<td>操作</td>

		</tr>
		@foreach($data as $key=>$val)

		<tr>
			<td>{{$val->tid}}</td>
			<td>{{$val->name}}</td>
			<td><a href="proinfo/{{$val->tid}}"><img src="http://test.com/{{$val->logo}}" width="100px"></a></td>
			
			<td>{{$val->num}}</td>
			<td>{{$val->desc}}</td>
			<td><a href="del?tid={{$val->tid}}">删除</a> 
				<a href="edit/{{$val->tid}}">修改</a>
			</td>
		</tr>
@endforeach

</table>


{{$data->appends($query)->links()}}