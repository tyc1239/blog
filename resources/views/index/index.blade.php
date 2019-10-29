 @extends('layouts.shop')
@section('title','微商城首页')
@section('content')
     <div class="head-top">
      <img src="/shop/images/head.jpg" />
      <dl>
       <dt><a href="user"><img src="/shop/images/tou.jpg" /></a></dt>
       <dd>
        <h1 class="username"><b style='color:orange'>用户：{{$email}}</b></h1>
        <ul>
         <li><a href="/prolist"><strong>点击查看</strong><p>全部商品</p></a></li>
         <li><a href="javascript:;"><span class="glyphicon glyphicon-star-empty"></span><p>收藏本店</p></a></li>
         <li style="background:none;"><a href="javascript:;"><span class="glyphicon glyphicon-picture"></span><p>二维码</p></a></li>
         <div class="clearfix"></div>
        </ul>
       </dd>
       <div class="clearfix"></div>
      </dl>
     </div><!--head-top/-->
     <form action="#" method="get" class="search">
      <input type="text" class="seaText fl" />
      <input type="submit" value="搜索" class="seaSub fr" />
     </form><!--search/-->
     <ul class="reg-login-click">
      <?php if($email==''){?>
      <li><a href="/login">登录</a></li>
      <li><a href="/reg" class="rlbg">注册</a></li>
       <?php }else{?>
      <li><a href="logout" class="rlbg">退出</a></li>
      <?php }?>
     </ul><!--reg-login-click/-->
     <div id="sliderA" class="slider">
        <!-- <img src="/shop/images/image1.jpg" />
         <img src="/shop/images/image2.jpg" /> 
        <img src="/shop/images/image3.jpg" />
        <img src="/shop/images/image4.jpg" /> -->
     </div><!--sliderA/-->
     <ul class="pronav">
      <li><a href="prolist">全部商品</a></li>
       
      <div class="clearfix"></div>
     </ul><!--pronav/-->
     <!--index-pro1/-->
     <div class="prolist">
 
       @foreach($data as $key=>$val)
      <dl>
       <dt>
       <a href="proinfo{{$val->g_id}}">
        <img src="http://test.com/{{$val->g_img}}" width="100" height="100" />
        </a>
       </dt>
       <dd>
        <h3><a href="proinfo{{$val->g_id}}">{{$val->g_name}}</a></h3>
        <div class="prolist-price"><strong>¥{{$val->g_price}}</strong> <span>¥599</span></div>
        <div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>
       </dd>
       <div class="clearfix"></div>
      </dl>
     @endforeach
 
     </div><!--prolist/-->
     <div class="joins"><a href="fenxiao.html"><img src="/shop/images/jrwm.jpg" /></a></div>
     <div class="copyright">Copyright &copy; <span class="blue">这是就是底部了</span></div>
     
@include('public.footer')
@endsection