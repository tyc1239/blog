<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>三级分销</title>
    <link rel="shortcut icon" href="shop/images/favicon.ico" />
    
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
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>购物车</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="{{asset('shop/images/head.jpg')}}" />
     </div><!--head-top/-->
     <table class="shoucangtab">
      <tr>
       <td width="75%"><span class="hui">购物车共有：<strong class="orange">{{$num}}</strong>件商品</span></td>
       <td width="25%" align="center" style="background:#fff url(images/xian.jpg) left center no-repeat;">
        <span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#666;"></span>
       </td>
      </tr>
     </table>
     
     <div class="dingdanlist">
    
      <table>
       <tr>
        <td width="100%" colspan="4">
        <a href="javascript:;"><input type="checkbox" name="1" /> 全选</a></td>
       </tr>
        @foreach($cart as $key=>$val)
       <tr>
        <td width="4%">
        <input type="checkbox" name="1" id="check" />

        </td>
        <td class="dingimg" width="15%"><img src="http://test.com/{{$val->g_img}}"  width="150px" /></td>
        <td width="50%">
         <h3>{{$val->g_name}}</h3>
        <input type="hidden" name="g_id" id="g_id" g_id="{{$val->g_id}}">
         <time>下单时间：2015-08-11  13:51</time>
        </td>
        
       </tr>
       <tr>
        <th colspan="4"><strong class="orange">¥{{$val->g_price}}</strong></th>
       </tr>
       <tr>
        <td width="100%" colspan="4">
        <a href="delcart{{$val->c_id}}">
        <input type="checkbox" name="1" /> 删除</a>
        </td>
       </tr>
       <tr>
       @endforeach
      </table>
 
     </div><!--dingdanlist/-->
     <div class="height1"></div>  
     <div class="gwcpiao">
     <table>
      <tr>
       <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
       <td width="50%">总计：<strong class="orange">¥69.88</strong></td>
       <td width="40%"><a href="addsuccess{{$val->g_id}}" class="jiesuan">去结算</a></td>
      </tr>
     </table>
    </div><!--gwcpiao/-->
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{asset('shop/js/jquery.min.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{asset('shop/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('shop/js/style.js')}}"></script>
    <!--jq加减-->
    <script src="{{asset('shop/js/jquery.spinner.js')}}"></script>
   <script>
	$('.spinnerExample').spinner({});

  $('.jiesuan').click(function(){
      if ($('#checke').prop('checked')==true) {
        var g_id=$("input[type='hidden']").attr('g_id');
      }
      if (g_id!='') {
        $.ajax({
          method:'GET',
          urlL:'/pay',
          data:{g_id：g_id},
        });
      }
  });

	</script>

  </body>
</html>