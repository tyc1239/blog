
<html class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.1</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="stylesheet" href="{{url('css/font.css')}}">
    <link rel="stylesheet" href="{{url('css/xadmin.css')}}">
    <script type="text/javascript" src="{{url('js/jquery-1.11.2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('lib/layui/layui.js')}}" charset="utf-8"></script>
    <script type="text/javascript" src="{{url('js/xadmin.js')}}"></script>
    <script type="text/javascript" src="{{url('js/cookie.js')}}"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>



<div class="x-body">


    <form class="layui-form layui-col-space5" action="/admin/group/sendopenid" method="post">
        {{ csrf_field() }}
        <div class="layui-input-inline">
           发送内容： <input type="text" id="content" name="text" required="" lay-verify="required"
                   autocomplete="off" class="layui-input">
        </div>
        <br>
        <div class="layui-inline layui-show-xs-block">

            选择标签：<select name="name">
                @foreach($dta as $k=>$v)

                    <option value="{{$v->id}}">{{$v->name}}</option>
                @endforeach
            </select>
        </div>


    <button class="layui-btn layui-btn-normal sendAll" type="submit">发送</button>
    </form>
</div>
</body>
</html>

<script>
    layui.use(['laydate','form'], function(){
        var laydate = layui.laydate;
        var form = layui.form;

        //执行一个laydate实例
        laydate.render({
            elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
            elem: '#end' //指定元素
        });
    });

</script>