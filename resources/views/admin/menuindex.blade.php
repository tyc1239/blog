{{--{{dd($menu)}}--}}
<html>
<head>
<meta charset="UTF-8">
<title>菜单</title>
    <link rel="stylesheet" href="{{url('css/weui.css')}}">
</head>
<body>
        @foreach($menu as $value)
                <div class="weui-cell menu" menuid="{{$value['m_id']}}">
                    <div class="weui-cell__bd">
                        <p>一级菜单</p>
                    </div>
                    <div class="weui-cell__bd">{{$value['name']}}</div>
                    <div class="weui-cell__bd">{{$value['type']}}</div>
                    <div class="weui-cell__ft sub_menu" >
                        {{--<a href="/admin/menu/menuupd/{{$value['m_id']}}}" class="weui-btn weui-btn_mini weui-btn_primary" >修改</a>--}}
                        {{--<a href="" class="weui-btn weui-btn_mini weui-btn_warn" id="forbidden" mid="{{$value['m_id']}}">删除</a>--}}
                    </div>


                </div>

            @endforeach

        {{--<input type="submit" id="btn" value="上传菜单" class="weui-btn_mini weui-btn_primary">--}}
        {{--<input type="submit" id="del" value="删除菜单" class="weui-btn_mini weui-btn_primary">--}}
        {{--<input type="submit" id="preson" value="上传个性菜单" class="weui-btn_mini  weui-btn_primary">--}}

</body>
</html>
<script src="{{url('js/jquery.min.js')}}"></script>
<script src="{{url('lib/layui/layui.js')}}"></script>
<script>


        $(document).ready(function(){

                $('.menu').each(function(){
                 var menuid = $(this).attr('menuid');
//                    alert(menuid);
                    var  that = $(this);
                    $.ajax({
                        url:'/admin/menu/getmenu/'+menuid,
                        success:function(res){
                            var str ='';
                            for(var i in res){
                                str +='<div class="weui-cell" style="margin-left: 10%"><div class="weui-cell bd"><p>二级菜单</p></div><div class="weui-cell bd">'+res[i]['name']+'</div><div class="weui-cell bd" style="margin-left: 45%">'+res[i]['type']+'</div><div class="weui-cell bd"> <a href="" class="weui-btn weui-btn_mini weui-btn_primary" id="forbidden" mid="'+res[i]['m_id']+'"></a></div><div class="weui-cell bd"> <a href="" class="weui-btn weui-btn_mini weui-btn_warn" id="forbidden" mid="'+res[i]['m_id']+'"></a></div></div>';
                            }
                            that.after(str);
                        }
                    })
            })
        })


        $(document).on('click','#forbidden',function(){
                var re =confirm('确认删除？');
                if (re){
                        var id =$(this).attr('mid');
                    $.ajax({
                        url:'/admin/menu/forbidden/'+id,
                        success:function(res){
                            var info = eval("("+res+")");
                            alert(info.message);
                            history.go(0)
                        }
                    })
                }else {
                    history.go(0)
                }

        })



    $(document).on('click','#btn',function(){
        $.ajax({
            url:'/admin/menu/set',
            success:function(res){
                console.log(res);
            }
        })
    })

        $(document).on('click','#del',function(){
            $.ajax({
                url:'/admin/menu/set',
                success:function(res){
                    console.log(res);
                }
            })
        })

        $(document).on('click','#person',function(){
            $.ajax({
                url:'/admin/menu/personmenu',
                success:function(res){
                    console.log(res);
                }
            })
        })

</script>