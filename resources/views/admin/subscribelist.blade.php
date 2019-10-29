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
    </head>
    
    <body>
 
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                    
                        </div>
                        <div class="layui-card-header">
                            <button class="layui-btn layui-btn-danger" onclick="delAll()">
                                <i class="layui-icon"></i>批量删除</button>
                            <button class="layui-btn" onclick="xadmin.open('添加用户','./order-add.html',800,600)">
                                <i class="layui-icon"></i>添加</button></div>
                        <div class="layui-card-body ">
                            <table class="layui-table layui-form">
                                <thead>
                                    <tr>
                                        <th>数据类型</th>
                                        <th>标题</th>
                                        <th>内容</th>
                                        <th>简介</th>
                                        <th>url</th>
                                        <th>media_id</th>
                                         <th>操作</th>
                                    </tr>
                                </thead>
                                @foreach($data as $key=>$val)
                                <tbody>


                                    <tr>
                                        <td>{{$val->type}}</td>
                                        <td>{{$val->title}}</td>
                                        <td>{{$val->content}}</td>
                                        <td>{{$val->url}}</td>
                                        <td>{{$val->media_id}}</td>
                                        <td>{{$val->material_url}}</td>
                                        <td class="td-manage">
                                            <a title="查看" onclick="xadmin.open('编辑','order-view.html')" href="javascript:;">
                                                <i class="layui-icon">&#xe63c;</i></a>
                                            <a title="删除" onclick="member_del(this,'要删除的id')" href="javascript:;">
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

        /*用户-删除*/
        function member_del(obj, id) {
            layer.confirm('确认要删除吗？',
            function(index) {
                //发异步删除数据
                $(obj).parents("tr").remove();
                layer.msg('已删除!', {
                    icon: 1,
                    time: 1000
                });
            });
        }

        function delAll(argument) {

            var data = tableCheck.getData();

            layer.confirm('确认要删除吗？' + data,
            function(index) {
                //捉到所有被选中的，发异步进行删除
                layer.msg('删除成功', {
                    icon: 1
                });
                $(".layui-form-checked").not('.header').parents('tr').remove();
            });
        }</script>

</html>