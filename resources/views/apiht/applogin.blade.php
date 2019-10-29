<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>app互踢登录</title>
</head>
<body>
    <p>账号：<input type="text" id="username"></p>
    <p>密码：<input type="text" id="pwd"></p>
    <p><button id="btn">登录</button></p>
</body>
</html>
<script src="{{url('/js/jquery.min.js')}}"></script>
<script>
    $(function(){
        $('#btn').click(function(){
            var username=$('#username').val();
            var pwd=$('#pwd').val();
            //alert(username);
            $.post(
                "/apiht/appdologin",
                {username:username,pwd:pwd},
                function(res){
                    //console.log(res);
                    if(res.code==200){
                        location.href="/apiht/apiht";
                    }else{
                        alert(res.message);
                    }
                },
                'json'
            );
            //阻止表单跳转。如果需要表单跳转，去掉这段即可。
            return false;
        })
    })
</script>