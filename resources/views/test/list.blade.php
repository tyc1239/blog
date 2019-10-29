<link rel="stylesheet" href="{{asset('css/page.css')}}" type="text/css">
@if (session('msg'))
 <div class="alert alert-success">
 {{ session('msg') }}
 </div>
@endif
<form action="">
		<input type="text" name="name" value="{{$name}}" placeholder="请输入网站名字">
 		<button>搜索</button>

</form>



<table border="1" cellspacing="0" cellpadding="0">
		<tr>
			<td>排序:</td>
			<td>网站名称:</td>
			<td>图片logo：</td>
			<td>链接类型：</td>
			<td>状态：</td>
			<td>操作</td>

		</tr>
		@foreach($data as $key=>$val)

		<tr>
			<td>{{$val->tid}}</td>
			<td>{{$val->name}}</td>
			<td><img src="http://test.com/{{$val->logo}}" width="100px"></td>
			<td>@if($val->line==1)LOGO链接 @else 文字链接 @endif</td>
			<td>@if($val->show==1)显示 @else 不显示 @endif</td>
			<td><a href="del?tid={{$val->tid}}">删除</a> 
				<a href="{{route('edittest',['tid'=>$val->tid])}}">修改</a>
			</td>
		</tr>
@endforeach

</table>


{{$data->appends($query)->links()}}