
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
    <xblock>
        <button class="layui-btn layui-btn-danger fanxuan"><i class="layui-icon"></i>反选</button>
        <button class="layui-btn layui-btn-danger" id="buxuan"><i class="layui-icon"></i>全不选</button>
        <span class="x-right" style="line-height:40px">共有数据：2条</span>
    </xblock>

     <table class="layui-table x-admin">
        <thead class="thead">
        <tr>
            <th width="15">
                <input type="checkbox" class="xuanall">
            </th>
            <th >关注用户id</th>
        </tr>
        </thead>
        <tbody class="tbody">
        @foreach($data as $k=>$v)
            <tr>
                <td >
                    <input type="checkbox" class="qbx xuanAll">
                </td>
                <td class="openid">{{$v->openid}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <button class="layui-btn layui-btn-normal sendAll">开始群发</button>
</div>
</body>
</html>
<script>
    $(function() {
        layui.use(['laydate', 'layer'], function () {
            var laydate = layui.laydate;
            var layer = layui.layer;
            //全选
            $(document).on('click','.xuanall',function(){
                var _this=$(this);
                var status = _this.prop('checked');
                $('.xuanAll').prop('checked',status);

            });
            //全不选
            $(document).on('click','#buxuan',function(){
                $('.qbx').prop('checked','');
            });
            //反选
            $(document).on('click','.fanxuan',function(){
                $('.qbx').each(function(index,element) {
                    var aa=$(this).prop('checked');
                    if(aa==true){
                        $(this).prop('checked','');
                    }else{
                        $(this).prop('checked','checked');
                    }
                })
            });
            //提交
            $(document).on('click','.sendAll',function(){
                var group='';
                $('.qbx').each(function(index){
                    var send=$(this).prop('checked');
                    // console.log(send);
                    if(send==true){
                        group+=$(this).parent('td').next('td').text()+',';
                    }

                });
                $.post(
                        "{{url('admin/group/send')}}",
                        {openid:group,_token:'{{csrf_token()}}'},
                        function(res){
                            console.log(res)
                        }

                )
            });
        });
    })
</script>

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
