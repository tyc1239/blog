<!DOCTYPE html>
<!-- saved from url=(0026)http://m.cstm.org.cn/login -->
<html style="font-size: 83.9375px;"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>中国科学技术馆门票预售</title>
    <link rel="icon" href="http://m.cstm.org.cn/images/wap/logo.ico" type="image/x-ico">  
<link rel="stylesheet" href="./login_files/reset.css">
<link rel="stylesheet" href="./login_files/zk-style.css">
<script src="./login_files/hm.js.下载"></script><script src="./login_files/jquery-1.12.4.min.js.下载"></script>
<script src="./login_files/date.js.下载"></script>
<script src="./login_files/common.js.下载"></script>
<script src="./login_files/commons.js.下载"></script>
<script src="./login_files/browserTransfer.js.下载"></script>
<script src="./login_files/flowStatistics.js.下载"></script>
</head>
<body>
<!-- 标题 -->
    <div class="title">
        <img id="back" src="./login_files/goback.png" alt="">
        登录
    </div> 
<!-- logo -->
<div class="landing-logo">
    <img src="./login_files/logo.png" alt="">
</div>
<!-- 登录信息填写-->
    <ul class="login-info landing-info">
        <li>
            <input type="text" name="userName" class="txt" placeholder="请输入用户名">
            <img class="landing-tu" src="./login_files/user.png" alt="">
        </li>
        <li>
            <input type="password" name="password" class="txt" placeholder="请输入密码">
            <img class="landing-tu" src="./login_files/password.png" alt="">
        </li>
        <li class="verification">
            <input name="validCode" required="true" type="text" class="txt fl" placeholder="请输入验证码">
           <span class="fl"> <img src="./login_files/1" id="codeImg"></span>
        </li>

    </ul>
<!-- 立即注册 -->
    <div class="login weixin" id="login_button">登录</div>

    <div class="reg-landing">
        <a href="http://m.cstm.org.cn/reg/1/">立即注册</a>
        |
        <a href="http://m.cstm.org.cn/pwd">忘记密码</a>
    </div>
<!-- 说明 -->
<div class="footer">
        <div class="more classstyle">
            <div>本系统由北京春秋永乐科技发展有限公司提供</div>
            <div>©中国科技馆 版权所有</div>
            <div>票务客户服务电话：010-59041000</div>
            <div> 京ICP备11000850号 京公网安备110105007388号</div>
        </div>
</div>    <input type="hidden" id="phone_num" value="">
<script src="./login_files/rem.js.下载"></script>
<script src="./login_files/layerUtil.js.下载"></script>
<script type="text/javascript">
$(function(){
	if($("#phone_num").val()){
		$("input[name=userName]").val($("#phone_num").val());
	}
    $("#codeImg").click(function () {
        $(this).attr("src","/vcode/1?v" + (new Date()).getTime());
    });
	$("#login_button").click(function(){
		var userName = $("input[name=userName]").val();
		var password = $("input[name=password]").val();
		var validCode = $("input[name=validCode]").val();
        if(!userName){
            layerUtil.tip("请输入用户名");
            return;
        }
        if(!password){
            layerUtil.tip("请输入登录密码");
            return;
        }
        if(!validCode){
            layerUtil.tip("请输入验证码");
            return;
        }
		var url = "/login/in";
		var param = {
			'userName':userName,
			'password':password,
			'validCode': validCode
		}
		
		$.post(url, param, function(data){
            if (data.status == 0) {
                layerUtil.tip(data.message)
            } else {
                var result = data.result;
                var userType = "";
                if(result){
                    userType = result.userType;
                }
                var homeUrl = "/index";
                if (userType== 1) {
                    location.href = homeUrl;
                    if(result.contacts && result.contacts.length>0){
                        sessionStorage.setItem("contacts", JSON.stringify(result.contacts));
                    }else{
                        sessionStorage.removeItem("contacts");
                    }

                } else if (userType == 2) {
                    homeUrl = "/user/center/baseInfo";
                    location.href = homeUrl;
                } else {
                    location.href = homeUrl;
                }
                window.sessionStorage.setItem('userType', userType);
                window.sessionStorage.setItem('homeUrl', homeUrl);
            }
		});

	});
});
</script>

</body></html>