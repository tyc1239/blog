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
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="stylesheet" href="{{url('/css/font.css')}}">
    <link rel="stylesheet" href="{{url('/css/xadmin.css')}}">
    <script src="{{url('/lib/layui/layui.js')}}" charset="utf-8"></script>
    <script type="text/javascript" src="{{url('/js/xadmin.js')}}"></script>
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="layui-card-header">

    <div class="layui-card-body ">
        <table class="layui-table layui-form">
            <thead>
            <tr>

                <th>id</th>
                <th>media_id</th>
                <th>material_type</th>
                <th>type</th>
                <th>path</th>
                <th>is_show</th>
                <th>time</th>
                <th>操作</th></tr>
            </thead>
            @foreach($data as $key=>$val)
                <tbody>
                <tr>

                    <td>>{{$val->id}}</td>
                    <td>{{$val->media_id}}</td>
                    <td>{{$val->material_type}}</td>
                    <td>{{$val->type==1?"临时":"永久"}}</td>
                    <td>{{$val->path}}</td>
                    <td>{{$val->is_show==1?"是":"否"}}</td>
                    <td>{{date("Y-m-dH:i",$val->create_time)}}</td>

                    <td class="td-manage">
                        <a title="查看" onclick="xadmin.open('编辑','order-view.html')" href="javascript:;">
                            <i class="layui-icon">&#xe63c;</i></a>
                        <a title="删除"  href="/material/del/{{$val->media_id}}">
                            <i class="layui-icon">&#xe640;</i></a>
                    </td>
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