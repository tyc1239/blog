<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" name="csrf-token" content="{{ csrf_token() }}">
	<title>登录</title>

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

			<form action="{{url('test/update/'.$data->tid)}}" method="post" enctype="multipart/form-data">
				
				@csrf
			 		<p>网站名称：<input type="text" name="name" value="{{$data->name}}" ></p>
			 		<p>网站网址：<input type="text" name="web" value="{{$data->web}}"></p>
			 		<p>链接类型：<input type="radio" name="line" value="1" @if($data->line==1) checked @endif>LOGO链接
								 <input type="radio" name="line" value="0" @if($data->line==0) checked @endif>文字链接
					</p>
			 		<p>图片LOGO: 
			 		<img src="http://test.com/{{$data->logo}}" width="100px"><input type="file" name="edit_logo">
					<input type="hidden" name="logo" value="{{$data->logo}}">
			 		</p>

			 		<p>网站联系人： <input type="text" name="ptc" value="{{$data->ptc}}" ></p>
			 		<p>网站介绍：<textarea name="desc" id="" cols="30" rows="10" >{{$data->desc}}</textarea></p>
			 		<p>是否显示：<input type="radio" name="show" value="1" @if($data->show==1) checked @endif>是
								 <input type="radio" name="show" value="0" @if($data->show==0) checked @endif>否
					</p>
					
					<p><input type="submit"  value="提交">         
					   <input type="reset" value="重置">
					</p>
			</form>

			<script>
					$('input[name=name]').blur(function(){
						var name=$(this).val();
						if (name=='') {
							$(this).next().remove();
 							$(this).after("<b style='color:red'>网站名不能为空啊</b>");
							return false;
						}
						var reg=/^[a-zA-Z0-9_\u4e00-\u9fa5]+$/;
						if (!reg.test(name)) {
 							$(this).next().remove();
							$(this).after("<b style='color:red'>网站名必须是中文字母数字下划线</b>");
							return false;
						}
						//判断用户是否存在
						$.ajaxSetup({
								headers: {
								 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								 }
						});

						$.ajax({
							  method: "POST",
							  url: "/test/checkname",
							  data: {name:name}
							}).done(function( msg ) {
								$('input[name=name]').next().remove();
							  if (msg.code==00000) {	
							  	$('input[name=name]').after("<b style='color:red'>"+msg.msg+"</b>");
							  }

							});
					});

						$('input[name=web]').blur(function(){
						var web=$(this).val();
						$(this).next().remove();
						if (web=='') {
							$(this).after("<b style='color:red'>网站不能为空</b>");
							return false;
						}
						var reg=/^http:\/\/.+$/;
						if (!reg.test(web)) {
							$(this).after("<b style='color:red'>格式应该以http://开头</b>");
							return false;
						}

					});

					$('input[type=submit]').click(function(){
 							var obj_name=$('input[name=name]');
 							
 							var name=obj_name.val();

							if (name=='') {
							obj_name.next().remove();
							obj_name.after("<b style='color:red'>网站名不能为空</b>");
							return false;
						}
						var reg=/^[a-zA-Z0-9_\u4e00-\u9fa5]+$/;
						obj_name.next().remove();
						if (!reg.test(name)) {
   						  obj_name.after("<b style='color:red'>网站名必须是中文字母数字下划线</b>");
							return false;
						}
						
						// //判断用户是否存在
						// $.ajaxSetup({
						// 		headers: {
						// 		 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						// 		 }

						// });

						$.ajax({
							  method: "POST",
							  url: "/test/checkname",
							  data: {name:name}
							}).done(function( msg ) {
								$('input[name=name]').next().remove();
 							  if (msg.code==00000) {
							  		
							  	$('input[name=name]').after("<b style='color:red'>"+msg.msg+"</b>");
							  }

							});

						var obj_name=$('input[name=web]');
 						obj_name.next().remove();
						var age=obj_name.val();
						if (age=='') {
							obj_name.after("<b style='color:red'>网站不能为空</b>");
							return false;
						}
						var reg=/^http:\/\/.+$/;
						if (!reg.test(web)) {
							obj_name.after("<b style='color:red'>格式应该以http://开头</b>");
							return false;
						}
						$('form').submit();

 				});

					 
			</script>
		
</body>
</html>