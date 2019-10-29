<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>微信扫码登录!!</title>
</head>
<body>

<center><img src="/qrcode.png" alt="">
    <div><span class="content"></span></div></center>
</body>

</html>

<script type="text/javascript" src="{{url('js/jquery-3.2.1.min.js')}}"></script>


<script>
//    $(document).ready(function(){
//        setInterval(getstatus,2000);
//
//    })
    {{--$(document).ready(function(){--}}
        {{--$.ajax({--}}
            {{--url:'/getstatus',--}}
            {{--data:{userid:'{{$userid}}',_token:'{{csrf_token()}}'},--}}
            {{--type:"POST",--}}
            {{--success:function(res){--}}
                 {{--var str ='';--}}
                {{--if (res==0){--}}
                    {{--str +="等待扫码";--}}
                {{--}else if(res.status==1){--}}
                    {{--str +="扫码成功";--}}
                {{--}else if(res.status==2){--}}
                    {{--str +="确认成功";--}}
                {{--}--}}

                {{--$('.content').html(str);--}}
            {{--}--}}
        {{--})--}}
    {{--})--}}

$(function(){
    //获取当前状态
    setInterval(getstatus,1000);
})
function getstatus(){
    $.ajax({
        url:'getstatus',
        data:{userid:"{{$userid}}"},
        type:"GET",
        success:function(res){
            var str='';
            if(res==0){
                str+="等待扫码";
            }else if(res==1){
                str+="扫码成功等待授权";
                $("img").attr('src','/shixiao.png');
            }else if(res==2){
                str+="等待跳转";
                location.href="/";
            }
            $('.content').html(str);
        }
    })
}


</script>