<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>注册</title>
</head>
<body>
		<h1>用户注册</h1>
		<form action="/goods/addreg">
		注册账号：	<input  type="text" name="email" placeholder="输入账号" /><br>	
		 <div>验证码：	<input type="text" name="idc"   placeholder="输入验证码" />   
 		<button type="button">获取验证码 </div>  
		 密码： <input type="text" id="pwd" name="password" placeholder="请输入密码"/><br>	
 		确认密码：<input type="text" id="pwd1" placeholder="再次输入密码" /><br>

 		 

 		 <input type="submit" value="立即注册" /><br>	
</form>
 </body>
</html>
<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script>
		$('input[name=email]').blur(function(){
				var _this=$(this).val();
				if (_this=='') {
					alert('注册账号不能为空');
					return false;
				}

		});
		$('input[name=idc]').blur(function(){
				var _this=$(this).val();
				if (_this=='') {
					alert('验证码不能为空');
					return false;
				}

		});
		$('input[name=password]').blur(function(){
				var _this=$(this).val();
				if (_this=='') {
					alert('密码不能为空');
					return false;
				}

		});
		 
				var pwd1=$(this).val();
				var pwd=$('#pwd').val();
				if (pwd1!=pwd) {
					alert('密码必须一致');
					return false;
				}

	 


</script>