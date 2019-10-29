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
                 <tr align="center">
                    <td>openid</td>
                    <td>头像</td>
                    <td>昵称</td>
                    <td>性别</td>
                    <td>籍贯</td>
                    <td>所属标签</td>
                 </tr>
                @if($fans)
                    @foreach($fans as $v)
                        <tr align="center">
                            <td>{{$v['openid']}}</td>
                            <td><img src="{{$v['headimgurl']}}" width="60px;"></td>
                            <td>{{$v['nickname']}}</td>
                            <td>{{$v['sex']==1?"男":"女"}}</td>
                            <td>{{$v['country']}}{{$v['province']}}{{$v['city']}}</td>
                            <td>{{intval($v['tagid_list'])}}</td>

                        </tr>
                    @endforeach
                @endif

        </table>

    </div>
</div>
</div>
</div>
</div>
</body>


</html>