<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>自定义单列表</title>
</head>
<body>
        @foreach($menu as $v)
           <p >
                <i pid ="{{$v['menu_id']}}" class="one">一级菜单</i>
                <span>{{$v['name']}}</span>
               @if($v['status'] ==1)
               <span><input type="button" value="点击禁用" class="forbidden" menu_id= "{{$v['menu_id']}}"></span>&nbsp;
                   &nbsp;
                @else
                   <span><input type="button" value="点击启用" class="forbidden" menu_id= "{{$v['menu_id']}}"></span>

               @endif
                       <span><input type="button" value="点击删除"></span>
                       <span class="content"></span>
            </p>
            @endforeach

        <input type="button" value="发布菜单" id="btn">

</body>
</html>

<script src = "{{url('js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function(){
     var _pid=$('.one');
      _pid.each(function(index){
         var pid = $(this).attr('pid');
          var that = $(this);
          $.ajax({
              url:'getsecondmenu',
              type:'POST',
              data:{pid:pid,_token:'{{csrf_token()}}'},
              success:function(res){
                  var str ='';
                   for(var i in res){
                       if(res[i]['status'] == 1) {
                           str +="<p><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+"二级菜单</span>&nbsp;&nbsp;<span>"+res[i]['name']+"</span><span><input type='button' value='点击禁用' class='forbidden'  menu_id ='"+res[i]['menu_id']+"'></span><span><input type='button' value='点击删除'></span></p>";

                       }else {
                           str +="<p><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+"二级菜单</span>&nbsp;&nbsp;<span>"+res[i]['name']+"</span><span><input type='button' value='点击启用' class='forbidden'  menu_id ='"+res[i]['menu_id']+"'></span>&nbsp;&nbsp;<span><input type='button' value='点击删除'  menu_id ='"+res[i]['menu_id']+"'></span></p>";

                       }
                  }
                  that.siblings('.content').after(str);
              }
          })

      })
    });

    $(document).on('click','.forbidden',function(){
            var _this = $(this);
            var id = $(this).attr('menu_id');
        $.ajax({
            url:'forbidden?id='+id,
            dataType:'json',
            success:function(res){
                if(res.code ==10000){
                    _this.attr('value','启用')
                }else if(res.code ==20000){
                    _this.attr('value','禁用')
                }else{
                    alert(res.message)
                }
            }


        })
    });

    $(document).on('click','#btn',function(){

        $.ajax({
            url:'makemenu',
             success:function(res){
                 console.log(res);
            }

        })
    })



</script>