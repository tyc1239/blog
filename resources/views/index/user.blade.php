<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>珠宝商城用户名</title>
    <link rel="shortcut icon" href="images/favicon.ico" />
    
    <!-- Bootstrap -->
    <link href="{{asset('shop/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('shop/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('shop/css/response.css')}}" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="maincont">
     <div class="userName">
      <dl class="names">
       <dt><img src="{{asset('shop/images/user01.png')}}" /></dt>
       <dd>
        <h3 style="color:orange"> 用户:</h3>
       
        <h3 style="color:orange">{{$email}}</h3>
       </dd>
       <div class="clearfix"></div>
      </dl>
      <div class="shouyi">
       <dl>
        <dt>我的余额</dt>
        <dd>0.00元</dd>
       </dl>
       <dl>
        <dt>我的积分</dt>
        <dd>0</dd>
       </dl>
       <div class="clearfix"></div>
      </div><!--shouyi/-->
     </div><!--userName/-->
     
     <ul class="userNav">
      <li><span class="glyphicon glyphicon-list-alt"></span><a href="/order">我的订单</a></li>
      <div class="height2"></div>
      <div class="state">
         <dl>
          <dt><a href="order.html"><img src="{{asset('shop/images/user1.png')}}" /></a></dt>
          <dd><a href="order.html">待支付</a></dd>
         </dl>
         <dl>
          <dt><a href="order.html"><img src="{{asset('shop/images/user2.png')}}" /></a></dt>
          <dd><a href="order.html">代发货</a></dd>
         </dl>
         <dl>
          <dt><a href="order.html"><img src="{{asset('shop/images/user3.png')}}" /></a></dt>
          <dd><a href="order.html">待收货</a></dd>
         </dl>
         <dl>
          <dt><a href="order.html"><img src="{{asset('shop/images/user4.png')}}" /></a></dt>
          <dd><a href="order.html">全部订单</a></dd>
         </dl>
         <div class="clearfix"></div>
      </div><!--state/-->
      <li><span class="glyphicon glyphicon-usd"></span><a href="quan.html">我的优惠券</a></li>
      <li><span class="glyphicon glyphicon-map-marker"></span><a href="address">收货地址管理</a></li>
      <li><span class="glyphicon glyphicon-star-empty"></span><a href="shoucang.html">我的收藏</a></li>
      <li><span class="glyphicon glyphicon-heart"></span><a href="shoucang.html">我的浏览记录</a></li>
      <li><span class="glyphicon glyphicon-usd"></span><a href="tixian.html">余额提现</a></li>
	 </ul><!--userNav/-->
     
     <div class="lrSub">
        <li><a href="logout" class="rlbg">退出</a>
     </div>
     @include('public.footer')
     
     <!--footNav/-->
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/style.js"></script>
    <!--jq加减-->
    <script src="js/jquery.spinner.js"></script>
   <script>
	$('.spinnerExample').spinner({});
   </script>
  </body>
</html>