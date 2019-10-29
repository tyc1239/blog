<!DOCTYPE html>
<html lang="en">
<head>
 	<meta charset="utf-8" name="csrf-token" content="{{ csrf_token() }}">
	<title>修改</title>
	<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
</head>
<body>
			
		@if ($errors->any())
			 <div class="alert alert-danger">
			 <ul>
			 @foreach ($errors->all() as $error)
			 <li>{{ $error }}</li>
			 @endforeach
			 </ul>
			 </div>
		@endif

			<form action="{{url('goods/update/'.$data->tid)}}" method="post" enctype="multipart/form-data">
				
				@csrf
			 		<p>商品名称：<input type="text" name="name" value="{{$data->name}}" ></p>
			 	 
			 		<p>商品图片: 
			 		<img src="http://test.com/{{$data->logo}}" width="100px">
			 		<input type="file" name="edit_logo">
					<input type="hidden" name="logo" value="{{$data->logo}}">
			 		</p>

			 		<p>商品数量： <input type="text" name="ptc" value="{{$data->num}}" ></p>
			 		<p>商品描述：<textarea name="desc" id="" cols="30" rows="10" >{{$data->desc}}</textarea></p>
			 		 
					
					<p><input type="submit"  value="提交">         
					   <input type="reset" value="重置">
					</p>
			</form>




</body>
</html>