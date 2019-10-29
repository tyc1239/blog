<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>添加123</title>
</head>
<body>
<form>
    姓名：<input type="text" name="name" id="name"><br>
    密码：<input type="password" name="pwd" id="pwd"><br>
    性别：<input type="radio" name="sex" value="1" checked="">男
    <input type="radio" name="sex" value="2">女<br>
</form>
<input type="submit" id="btn" value="提交">
</body>
</html>
<script src = "{{url('js/jquery-3.2.1.min.js')}}"></script>

<script>
    $(function(){
        $("#btn").click(function(){
            var name = $('#name').val();
            var pwd = $('#pwd').val();
            var sex = $("input[type='radio']:checked").val();

            $.post(
                    '/student',
                    {name:name,pwd:pwd,sex:sex},
                    function(res){
                        if(res.error==1){
                            alert(res.msg);
                            location.href="/student";
                        }else{
                            alert(res.msg);
                        }
                    },
                    'json'
            );
        });
    });
</script>