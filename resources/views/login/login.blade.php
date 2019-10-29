 @extends('layouts.shop')
@section('title','微商城登录')
@section('content')



    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="{{asset('shop/images/head.jpg')}}" />
     </div><!--head-top/-->
     <form action="/logindo" method="get" class="reg-login">
      <h3>还没有三级分销账号？点此<a class="orange" href="/reg">注册</a></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" name="email"placeholder="输入邮箱号" /></div>
       <div class="lrList"><input type="text" name="password" placeholder="输入密码" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" value="立即登录" />
      </div>
     </form>

     
    @include('public.footer')
    @endsection

     <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>