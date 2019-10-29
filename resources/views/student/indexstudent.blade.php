<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>展示学生首页</title>
</head>
<body>
<a href="/student/create">添加</a>
<table border="1" >
    <tr>
        <th>ID</th>
        <th>用户名</th>
        <th>性别</th>
        <th>操作</th>
    </tr>

    @foreach($data as $k => $v)
        <tr>
            <th id="id">{{$v->id}}</th>
            <th>{{$v->name}}</th>
            <th>
                @if($v->sex==1)男
                @else女
                @endif
            </th>
            <th>
                <button><a href="/student/{{$v->id}}/edit">修改</a></button>
                <button class="del">删除</button>
            </th>
        </tr>
    @endforeach
</table>
</body>
</html>
<script src = "{{url('js/jquery-3.2.1.min.js')}}"></script>



<script>
    $(function(){

        $(".del").click(function(){
            $.ajax({
                method: "DELETE",
                url: "/student/{{$v->id}}",
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