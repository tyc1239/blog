<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>微信扫码登录</title>
</head>
<body>
        <center>
            <img src="/code/code.png" alt="" width="300px" height="300px">
            <p class="message"></p>
            <p class="failure"></p >
            
        </center>

</body>
</html>


<script src="{{url('/js/jquery.min.js')}}"></script>

<script>

    userid = '{{$userid}}';
    $(document).ready(function(){
        setInterval(getstatus,1000);
        sec=30;
        setInterval(failure,1000);

    });

    //60秒失效
    function failure(){
        if(sec>0){
            var str="二维码还有"+sec+"秒后失效，请尽快操作";
            $('.failure').text(str);
            sec--;
        }else{
            $('img').attr('src','/code/failure.png');
            $('.failure').text(' ');
        }
    }

    //获取状态
    function getstatus(){
        var str = '';
        $.ajax({
            url:'scanstatus?userid='+userid,
            success:function(res){
                //console.log(res);
                 if(res==0){
                    str +='等待扫码';
                }else if(res==1){
                    str +='扫码成功 等待确认';
                    $('img').attr('src','/code/querens.png');
                }else if(res==2){
                    location.href='http://47.103.4.61';
                }else{
                    console.log(res);
                }
                $('.message').text(str);
            }
        })
    }

</script>