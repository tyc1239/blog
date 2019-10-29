<html>
		<head lang="en">
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

			 <form action="adddo" method="post" enctype="multipart/form-data">
			 		@csrf
			 		<input type="text" name="username" value="" placeholder="用户名"><br><br>
			 		<input type="number" name="age" value="" placeholder="年龄"><br><br>
			 		<input type="number" name="class" value="" placeholder="班级"><br><br>
			 		<input type="file" name="head"><br><br>
					<!-- <button>提交</button><br> -->
			 		<input type="button" value="提交">

			 </form>
			
			<script>
					$('input[name=username]').blur(function(){
						var username=$(this).val();
						
						if (username=='') {
							$(this).next().remove();
							// alert('用户名不能为空');
							$(this).after("<b style='color:red'>用户名不能为空</b>");
							return false;
						}
						var reg=/^\w{3,30}$/;
						if (!reg.test(username)) {
							// alert('用户名必须是字母数字下划线组成');
							$(this).next().remove();
							$(this).after("<b style='color:red'>用户名必须是字母数字下划线组成</b>");
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
							  url: "/user/checkname",
							  data: {username:username}
							}).done(function( msg ) {
								$('input[name=username]').next().remove();
							  if (msg.code==00000) {
							  		
							  		$('input[name=username]').after("<b style='color:red'>"+msg.msg+"</b>");
							  }

							});
					});

						$('input[name=age]').blur(function(){
						var age=$(this).val();
						$(this).next().remove();
						if (age=='') {
							$(this).after("<b style='color:red'>年龄不能为空</b>");
							return false;
						}
						var reg=/^\d{1,3}$/;
						if (!reg.test(age)) {
							$(this).after("<b style='color:red'>年龄必须是数字</b>");
							return false;
						}

					});

					$('input[type=button]').click(function(){
 							var obj_name=$('input[name=username]');
 							
 							var username=obj_name.val();

							if (username=='') {
							// alert('用户名不能为空');
							obj_name.next().remove();
							obj_name.after("<b style='color:red'>用户名不能为空</b>");
							return false;
						}
						var reg=/^\w{3,30}$/;
						obj_name.next().remove();
						if (!reg.test(username)) {
   							obj_name.after("<b style='color:red'>用户名必须是字母数字下划线组成</b>");
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
							  url: "/user/checkname",
							  data: {username:username}
							}).done(function( msg ) {
								$('input[name=username]').next().remove();
 							  if (msg.code==00000) {
							  		
							  		$('input[name=username]').after("<b style='color:red'>"+msg.msg+"</b>");
							  }

							});

						var obj_name=$('input[name=age]');
 						obj_name.next().remove();
						var age=obj_name.val();
						if (age=='') {
							obj_name.after("<b style='color:red'>年龄不能为空</b>");
							return false;
						}
						var reg=/^\d{1,3}$/;
						if (!reg.test(age)) {
							obj_name.after("<b style='color:red'>年龄必须是数字</b>");
							return false;
						}
						$('form').submit();

 				});


			</script>
		</body>
</html>