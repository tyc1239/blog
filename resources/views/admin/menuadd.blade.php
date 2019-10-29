<html>
<head>
    <meta charset="UTF-8">
    <title>关注回复管理</title>

    <link rel="stylesheet" href="{{url('/css/weui.css')}}">
</head>

<body>
<form action="/admin/menu/addmenu" method="post" enctype="multipart/form-data" class="layui-form">
    {{csrf_field()}}
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">菜单名称</label>
        </div>
        <div class="weui-cell__bd">
            <input type="text" name="name" >
        </div>
    </div>
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">菜单类型</label>
        </div>
        <div class="weui-cell__bd">
            <select class="weui-select" name="type" id="type">
                <option value="click">click</option>
                <option value="view">view</option>
                <option value="pic_weixin">pic_weixin</option>
            </select>
        </div>
    </div>
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">选择父级菜单</label>
        </div>
        <div class="weui-cell__bd">
            <select class="weui-select" name="pid" id="type">
                <option value="0">顶级菜单</option>
                @foreach($data as $key=>$val)
                    <option value="{{$val->m_id}}">{{$val->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div id="content"></div>
    <input type="submit" value="提交" class="weui-btn weui-btn_primary">
</form>
</body>
</html>