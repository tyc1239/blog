<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>个人中心</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>登录</th>
            <th>用户</th>
            <th>在线状态</th>
        </tr>
        @foreach($data as $key=>$val)
            <tr>
                <td>{{$val->id}}</td>
                <td>{{$val->username}}</td>
                @if($val->ip==1)
                    <td>pc端登录</td>
                @elseif($val->ip==2)
                    <td>移动端登录</td>
                @elseif($val->ip==3)
                    <td>未登录</td>
                @endif
            </tr>

        @endforeach
    </table>
</body>
</html>
<script src="{{url('js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {

        var token =localStorage.getItem('token');

        $.ajax({
            url:"/apiht/doindex",
            data:{token:token},
            type:'get',
            success:function(res){

                console.log(res);
                if (res.code == 101){
                    alert('过期');  location.href="/apiht/login";
                }else if (res.code ==102){
                    alert('在别处');location.href="/apiht/login";
                }
            },
            dataType:'json'
        })
    })
</script>