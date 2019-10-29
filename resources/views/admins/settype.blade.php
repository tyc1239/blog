<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>设置回复类型</title>
</head>
<body>
<input type="radio" name="type" class="types" value="text"><span>文本1</span><br><br>
<input type="radio" name="type" class="types" value="image"><span>图片</span><br><br>
<input type="radio" name="type" class="types" value="voice"><span>语音</span><br><br>
<input type="radio" name="type" class="types" value="video"><span>视频</span><br><br>
<input type="radio" name="type" class="types" value="news"><span>文本</span><br><br>
<input type="radio" name="type" class="types" value="music"><span>音乐</span><br><br>

 </body>
</html>

<script src = "{{url('js/jquery.min.js')}}"></script>
<script>
        $(function(){
            $(".types").each(function () {
                var types = $(this).val();
                var type = '{{$type}}';
                if (types == type){
                    $(this).attr('checked',true);
                }
            })

        });

        $(document).on('blur','.types',function(){
            var types = $(this).val();
            var con = $(this).next().text();
            var re = confirm("是否将类型修改为"+con);

            if(re){
                $.ajax({
                    url : 'settypedo',
                    type : 'POST',
                    data :{type:types,_token:'{{csrf_token()}}'},
                    success:function(res){
                        console.log(res);
//                        alert("ok");
                    }

                })

            }else{
                history.go(0);
            }


        })

</script>