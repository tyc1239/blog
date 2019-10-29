@extends('layouts.shop')
@section('title','微商城注册')
@section('content')
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="{{asset('shop/images/head.jpg')}}" />
     </div><!--head-top/-->
     <form action="/addreg" method="post" class="reg-login">
     {{csrf_field()}}
      <h3>已经有账号了？点此<a class="orange" href="/login">登陆</a></h3>
      <div class="lrBox">
       <div class="lrList"><input  type="text" name="email" placeholder="输入邮箱号" /></div>
       <div class="lrList2"><input type="text" name="idc"   placeholder="输入验证码" /> 
       <button id="idcg">获取验证码</button></div>
       <div class="lrList"><input type="text" id="pwd"  name="password" placeholder="设置新密码（6-18位数字或字母）" /></div>
       <div class="lrList"><input type="text" id="pwd1"   placeholder="再次输入密码" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" value="立即注册" />
      </div>
     </form> 


<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>

<script>
      //邮箱
        $('input[name=email]').blur(function(){

            var email=$('input[name=email]').val();
            if (email=='') {
                 alert('邮箱不能为空');
               //   $(this).next().remove();
               // $(this).after("<b style='color:red'>邮箱不能为空啊</b>");
              // console.log('asdfsghjj');
                return false;
            }

          //验证唯一
            $.ajax({
                method:"GET",
                url:"/checkname",
                data:{email:email},
            }).done(function(msg){
               $('input[name=email]').next().remove();
                if (msg.code==0) {
                 $('input[name=email]').after("<b style='color:red'>"+msg.msg+"</b>");
                }
            });
        });

          //验证码
        $('input[name=idc]').blur(function(){
          var idc=$('input[name=idc]').val();
          if (idc=='') {
              alert('验证码不能为空');
          }
          return false;
        });

        //获取验证码
        $('#idcg').click(function(){
          var email=$('input[name=email]').val();
          $('#idcg').attr('disabled',true);
          $.ajax({
            method:"GET",
            url:"/sendSms",
            data:{email:email}
          }).done(function(msg){
              if (msg.code==0) {
                  alert(msg.msg);
                  return false;
              }else if(msg.code==1){
                  alert(msg.msg);
              }
          });
          });

        //密码
        $('input[name=password]').blur(function(){
            var pwd=$('input[name=password]').val();
            if (pwd=='') {
                alert('密码不能为空');
            }
            return false;

        });

          //提交
          $('input[type="submit"]').click(function(){
            var email=$('input[name=email]').val();
            if (email=='') {
              alert('注册邮箱不能为空啊！');
              return false;
            }
            var password=$('input[name=password]').val();
            if (password=='') {
              alert('密码不能为空');
              return false;
            }
            var set=/^\w{3,6}$/;
              if (!set.test(password)) {
                alert('密码为三到六位数字字母下划线组成');
                return false;
              }
            var pwd1=$('#pwd1').val();
            if (pwd1!=password) {
              alert('密码和确认密码要求一致');
              return false;
            }
            $.ajax({
                method:"GET",
                url:"/checkname",
                data:{email:email}
            }).done(function(msg){
                if (msg.code==0) {
                  alert('邮箱已存在');
                  return false;
                }
            })
          });


</script>

@include('public.footer') 
@endsection