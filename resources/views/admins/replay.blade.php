<html>
<head>
    <meta charset="UTF-8">
    <title>关注回复管理</title>

    <link rel="stylesheet" href="{{url('css/weui.css')}}">
</head>

<body>

<form action="/admins/add" method="post" enctype="multipart/form-data" class="layui-form">
    @csrf
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">选择回复类型</label>
        </div>
        <div class="weui-cell__bd">
            <select class="weui-select" name="type" id="type">
                <option value="">请选择</option>
                <option value="text">文本消息</option>
                <option value="image">图片消息</option>
                <option value="news">图文消息</option>
                <option value="video">视频消息</option>
            </select>
        </div>
    </div>
    <div id="content"></div>
    <input type="submit" value="提交" class="weui-btn weui-btn_primary">
</form>
</body>
</html>

<script type="text/javascript" src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script>
    $('#type').change(function(){
        var type = $(this).val();
         if(type =='text'){
            var str = '<div class="weui-cell__bd">回复内容</div><div class="weui-cells weui-cells_form"><div class="weui-cell"> <div class="weui-cell__bd"> <textarea class="weui-textarea" placeholder="请输入回复内容" rows="3" name="text"></textarea> <div class="weui-textarea-counter"><span>0</span>/200</div></div></div></div>';
            $("#content").html(str);
        }else if(type=='image'){
            var str = '<div class="weui-cell"><div class="weui-cell__hd"><label class="weui-label">选择文件</label></div><div class="weui-cell__bd"><input class="weui-input" type="file" name="picurl"/></div></div>';
            $("#content").html(str);
        }else if(type == 'news'){
            var str = '<div class="weui-cell"><div class="weui-cell__hd"><label class="weui-label">标题</label></div><div class="weui-cell__bd"><input class="weui-input" type="text" placeholder="请输入标题" name="title"/></div></div><div class="weui-cell"><div class="weui-cell__hd"><label class="weui-label">简介</label></div><div class="weui-cell__bd"><input class="weui-input" type="text" placeholder="请输入简介" name="des"/></div></div><div class="weui-cell"><div class="weui-cell__hd"><label class="weui-label">选择图片</label></div><div class="weui-cell__bd"><input class="weui-input" type="file" name="picurl"/></div></div><div class="weui-cell"><div class="weui-cell__hd"><label class="weui-label">跳转链接</label></div><div class="weui-cell__bd"><input class="weui-input" type="text" placeholder="请输入跳转链接" name="url"/></div></div>';
            $("#content").html(str);
        }else if(type == 'video')
            var str = '<div class="weui-cell"><div class="weui-cell__hd"><label class="weui-label">选择文件</label></div><div class="weui-cell__bd"><input class="weui-input" type="file" name="picurl"/></div></div></div><div class="weui-cell"><div class="weui-cell__hd"><label class="weui-label">标题</label></div><div class="weui-cell__bd"><input class="weui-input" type="text" placeholder="请输入标题" name="title"/></div></div></div><div class="weui-cell"><div class="weui-cell__hd"><label class="weui-label">简介</label></div><div class="weui-cell__bd"><input class="weui-input" type="text" placeholder="请输入简介" name="des"/></div></div>';
        $("#content").html(str);

    })
</script>

