<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>pc互踢登录</title>
</head>
<body>
    <p>账号：<input type="text" id="username"></p>
    <p>密码：<input type="text" id="pwd"></p>
    <p><button id="btn">登录</button></p>
</body>
</html>
<script src="{{url('js/jquery.min.js')}}"></script>
<script>
    $(function(){
        $('#btn').click(function(){
            var username=$('#username').val();
            var pwd=$('#pwd').val();
            //alert(username);
            $.ajax({
             url:   "/apiht/dologin",
            data:{username:username,pwd:pwd},
            type:'get',
                success:function(res){
              //  console.log(res);
                if(res.code==200){
                    document.cookie="token="+res.data.token;
                    location.href="/apiht/index";
                }else{
                    alert(res.msg);
                }
            },
            dataType:'json'
             })
        });
    })
</script>