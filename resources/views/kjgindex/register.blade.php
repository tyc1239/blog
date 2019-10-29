<!DOCTYPE html>
<!-- saved from url=(0027)http://m.cstm.org.cn/reg/1/ -->
<html style="font-size: 85px;"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>中国科学技术馆门票预售</title>
    <link rel="icon" href={{url("kjg/img/logo.ico")}} type="image/x-ico">
    <link rel="stylesheet" href={{url("kjg/css/reset.css")}}>
    <link rel="stylesheet" href={{url("kjg/css/zk-style.css")}}>
    <script src={{url("kjg/js/hm.js.下载")}}></script>
    <script src={{url("kjg/js/date.js.下载")}}></script>
    <script src={{url("kjg/js/common.js.下载")}}></script>
    <script src={{url("kjg/js/commons.js.下载")}}></script>
    <script src={{url("kjg/js/browserTransfer.js.下载")}}></script>
    <script src={{url("kjg/js/flowStatistics.js.下载")}}></script>
</head>
<body>
	<!-- 标题 -->
    <div class="title">
        <img id="back" src={{url("kjg/img/goback.png")}} alt="">

        注册
    </div> 
<!-- 注册信息填写-->
    <ul class="login-info">
        <form action="http://m.cstm.org.cn/register/user" id="userForm">
        <li><input id="phone" name="phone" required="true" check="phone" type="tel" class="txt" placeholder="请输入手机号"></li>
        <li><input id="email" name="email" required="true" check="email" type="text" class="txt" placeholder="请输入邮箱地址"></li>
        <li><input id="pwd" name="pwd" required="true" check="pwd" type="password" class="txt" placeholder="请输入密码"></li>
        <li><input id="pwdtwo" name="pwdtwo" required="true" check="pwdtwo" type="password" class="txt" placeholder="请再次输入密码"></li>
        <li class="code">
            <input id="code" name="smsCode" required="true" type="tel" class="txt" placeholder="请输入验证码">
            <button id="codeButton">获取验证码</button>
        </li>
        </form>
    </ul>

<!-- 立即注册 -->
    <div class="login weixin" id="subRegister">立即注册</div>
<!-- 说明 -->
    <div class="footer">
        <div class="more classstyle">
            <div>本系统由北京春秋永乐科技发展有限公司提供</div>
            <div>©中国科技馆 版权所有</div>
            <div>票务客户服务电话：010-59041000</div>
            <div> 京ICP备11000850号 京公网安备110105007388号</div>
        </div>
</div>
    <script type="text/javascript"   src={{url("kjg/js/common.js(1).下载")}}></script>
    <script type="text/javascript"   src={{url("kjg/js/commons.js(1).下载")}}></script>
    <script src={{url("kjg/js/rem.js.下载")}}></script>
    <script src={{url("kjg/js/layerUtil.js.下载")}}></script>
    <script src={{url("kjg/js/reg.js.下载")}}></script>



</body></html>

<script src={{url("kjg/js/jquery-1.12.4.min.js.下载")}}></script>
<script>
     $(function(){
         $('#subRegister').click(function(){
             var phone = $('#phone').val();
             var email = $('#email').val();
             var pwd = $('#pwd').val();
             var code = $('#code').val();

             $.ajax({
                 url :'/kjg/regdo',
             type:'post',
             data:{
                 phone:phone,email:email,pwd:pwd,code:code,
             },
              success:function(res){
               alert(res);
               // console.log(res);
             }
             })
         })

     })

</script>