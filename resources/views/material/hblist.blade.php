<!DOCTYPE html>
<html class="x-admin-sm">
<link rel="stylesheet" href="{{url('css/page.css')}}" type="text/css">
@if (session('msg'))
    <div class="alert alert-success">
        {{ session('msg') }}
    </div>
@endif
<head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.2</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="{{url('/css/font.css')}}">
    <link rel="stylesheet" href="{{url('/css/xadmin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('/css/weui.css')}}">
    <script src = "{{url('js/jquery.min.js')}}"></script>

    <script src="{{url('/lib/layui/layui.js')}}" charset="utf-8"></script>
    <script type="text/javascript" src="{{url('/js/xadmin.js')}}"></script>

</head>

<body>


<div class="layui-card-header">

    <div class="layui-card-body ">
        <table class="layui-table layui-form">
            <thead>
            <tr>

                <th>id</th>
                <th>name</th>
                <th>money</th>
                <th>num</th>
                <th>操作</th>


            </thead>
            @foreach($data as $key=>$val)
                <tbody>
                <tr>

                    <td>>{{$val->id}}</td>
                    <td>{{$val->name}}</td>
                    <td>{{$val->money}}</td>
                    <td>{{$val->num}}</td>
                    <td><a href="">抢红包</a></td>

                </tr>

                </tbody>
            @endforeach

        </table>
        {{$data->appends($query)->links()}}

    </div>
</div>
</div>
</div>
</div>
</body>
<script>layui.use(['laydate', 'form'],
            function() {
                var laydate = layui.laydate;

                //执行一个laydate实例
                laydate.render({
                    elem: '#start' //指定元素
                });

                //执行一个laydate实例
                laydate.render({
                    elem: '#end' //指定元素
                });
            });


    //点击显示
    $('.is_show').click(function(){
        var id = $(this).prop('id');
        $.post(
                '/material/changeshow',
                {id:id},
                function (res) {
                    console.log(res);
                    if(res.msg == 1){
                        layer.msg(res.font,{icon:1},function () {
                            window.location.href="{{url('/material/list')}}";
                        });
                    }else{
                        layer.msg(res.font,{icon:2});
                    }
                },
                'json'
        )
    });

    /*用户-停用*/
    function member_stop(obj, id) {
        layer.confirm('确认要停用吗？',
                function(index) {

                    if ($(obj).attr('title') == '启用') {

                        //发异步把用户状态进行更改
                        $(obj).attr('title', '停用');
                        $(obj).find('i').html('&#xe62f;');

                        $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                        layer.msg('已停用!', {
                            icon: 5,
                            time: 1000
                        });

                    } else {
                        $(obj).attr('title', '启用');
                        $(obj).find('i').html('&#xe601;');

                        $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                        layer.msg('已启用!', {
                            icon: 5,
                            time: 1000
                        });
                    }

                });
    }

</script>

</html>