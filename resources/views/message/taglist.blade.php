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
                <th>编号</th>
                <th>标签名</th>
                <th>该标签下的用户数量</th>
                <th>操作</th>
            </thead>
            <tbody>
            @foreach($data as $key=>$val)
                <tr>
                    <td>{{$val->id}}</td>
                    <td>{{$val->name}}</td>
                    <td>{{$val->count}}</td>
                    <td><a href="removetag/{{$val->id}}">删除</a>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</div>
</div>
</div>
</div>
</body>


</html>