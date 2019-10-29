<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>修改</title>
</head>
<body>
<form>
    姓名：<input type="text" name="name" id="name" value="{{$data->name}}"><br>
    密码：<input type="password" name="pwd" id="pwd" value="{{$data->pwd}}"><br>
    性别：<input type="radio" name="sex" value="1" @if($data->sex==1)checked @endif>男
    <input type="radio" name="sex" value="2" @if($data->sex==2)checked @endif>女<br>
    <input type="hidden" name="id" value="{{$data->id}}">
</form>
<input type="submit" id="btn" value="修改">
</body>
</html>
<script src = "{{url('js/jquery-3.2.1.min.js')}}"></script>
<script>
    $(function(){
        $("#btn").click(function(){
            var name = $('#name').val();
            var pwd = $('#pwd').val();
            var sex = $("input[type='radio']:checked").val();

            $.ajax({
                method: "PATCH",
                url: "/student/{{$data->id}}",
                data: {name:name,pwd:pwd,sex:sex},
                dataType:'json'
            }).done(function (res) {
                if (res.error==1){
                    alert(res.msg);
                    location.href="/student";
                }else{
                    alert(res.msg);
                }
            });
        });
    });
</script>