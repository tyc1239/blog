<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//闭包路由 返回视图

// Route::get('/', function () {
// 	dump(request()->user());
// 	// echo 123;
//     return view('welcome');
// });

// Route::view('/','test',['name'=>'lisidasddadf']);

//闭包路由返回值

 Route::get('/index','IndexController@index');






Route::get('/form',function(){
	return'<form action="/do" method="post">'.csrf_field().'<input type="text" name="name"><button>提交</button></form>';
});
// Route::post('/do','IndexController@adddo');
//支持多种路由
// Route::match(['get','post'],'/do','IndexController@adddo');

//闭包函数传参 必填
 
// Route::get('/goods/{id}',function($id){
//  		echo "ID is:".$id;

//  });

//可选传参
// Route::get('/goods/{id}','IndexController@goods');
// Route::get('/goods/{id?}','IndexController@goods')->where('id','\d+');

Route::prefix('goods')->group(function(){

		Route::get('add','IndexController@add');
		Route::get('del','IndexController@del');
		Route::get('edit','IndexController@edit');
		Route::get('list','IndexController@lists');
});

// Route::get('/goods/add','IndexController@add');
// Route::get('/goods/del','IndexController@del');
// Route::get('/goods/edit','IndexController@edit');
// Route::get('/goods/list','IndexController@lists');

// Route::get('/aa',function(){
// 	return redirect('/form');

// });

	Route::prefix('user')->group(function(){
// Route::prefix('user')->middleware('islogin')->group(function(){
	Route::get('add',function(){
	return view('users/add');
	});

	Route::post('adddo','UserController@store');
	Route::get('del','UserController@del');
	Route::get('list','UserController@index');
	Route::get('edit/{id}','UserController@edit')->name('edituser');
	Route::post('update/{id}','UserController@update');
	Route::post('checkname','UserController@checkName');
	Route::post('send','UserController@send');
	Route::post('log','UserController@login');
});

Route::get('/test',function(){
	// return 'sadfadfd';
	// return [1,2,3];
	 return response('Hello Cookie')->cookie('test', '123', 1);
});

// Route::get('/login',function(){
// 	return view('users.login');

// });
Route::get('/log',function(){
	return view('users/login');

});



//测试
Route::prefix('test')->group(function(){

// Route::prefix('test')->middleware('islogin')->group(function(){
	Route::get('add',function(){
	return view('test/add');
	});


	Route::post('adddo','TestController@store');
	Route::post('update/{id}','TestController@update');
	Route::get('list','TestController@index');		
	Route::get('del','TestController@del');
	Route::get('edit/{id}','TestController@edit')->name('edittest');
	Route::post('checkname','TestController@checkName');



});

  Route::get('/login',function(){
	return view('test.login');

});

//注册登录
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// 珠宝首饰小项目
Route::get('/','IndexController@index');
Route::get('/sendSms','IndexController@sendSms');
Route::get('/logindo','IndexController@logindo');
Route::post('/addreg','IndexController@addreg');
Route::get('/checkname','IndexController@checkname');
Route::get('/logout','IndexController@logout');
Route::get('/regname','IndexController@regname');
Route::get('/idcg','IndexController@idcg');
Route::get('/prolist','IndexController@prolist');
Route::get('/car','IndexController@car');
Route::get('/user','IndexController@user');
Route::get('/pay','IndexController@pay');
Route::get('/success','IndexController@success');
Route::get('/proinfo{g_id}','IndexController@proinfo');
Route::get('/cart{g_id}','IndexController@cart');
Route::get('/addcart','IndexController@addcart');
Route::get('/delcart{g_id}','IndexController@delcart');
Route::get('/success','IndexController@success');
Route::get('/addsuccess{g_id}','IndexController@addsuccess');
Route::get('/order','IndexController@order');


Route::get('/login',function(){
	return view('login.login');
});

Route::get('/reg',function(){
	return view('login.reg');
});


Route::get('/mamcache/{id}','IndexController@mamcache');


//考题B  

Route::prefix('goods')->group(function(){
Route::get('list','GoodsController@index');	

Route::get('del','GoodsController@del');	

Route::get('/edit/{tid}','GoodsController@edit');
Route::post('/update/{tid}','GoodsController@update');
Route::get('/proinfo/{tid}','GoodsController@proinfo');

});


//考题A 测试
Route::get('/goods/reg','GoodsController@reg');
Route::get('/goods/sendSms','GoodsController@sendSms');
Route::get('/goods/addreg','GoodsController@addreg');



Route::get('/alipay',function(){

	$ordersn=date('YmdHis').rand(1000,9999);
	 // return ="<b><a href=/alipays/".$ordersn.">支付宝支付</a></b>";
	return "<b><a href=/pays/".$ordersn.">支付宝支付</a></b>";
	// echo $ordersn;

});

Route::get('/pays/{s_num}','AlipayController@pays');
 

 // 考试
Route::get('/kao/login','KaoController@login');
Route::post('/kao/logindo','KaoController@logindo');
Route::get('/kao/add','KaoController@add');
Route::post('/kao/addHandle','KaoController@addHandle');
Route::post('/kao/addHandle2','KaoController@addHandle2');

Route::get('/kao/checkname','KaoController@checkname');
Route::get('/kao/list','KaoController@list');

Route::get('/kao/adddo{kid}','KaoController@adddo');

Route::get('/kao/del','KaoController@del');
Route::get('/kao/proinfo/{Kid}','KaoController@proinfo');


//微信
route::prefix('wechat')->group(function(){


        route::any('/','WX\\WechatController@valid');
        route::any('/responseMsg','WeixinController@responseMsg');
        route::any('/tuling','WeixinController@tuling');

		route::any('/wxlogin','WX\\UserController@wxlogin');
		route::any('bindingdo','WX\\UserController@bindingdo');
		route::any('/wxcode','WX\\UserController@wxcode');
		route::any('/wxcodelogin/{id}','WX\\UserController@wxcodelogin');


		route::any('/create','WX\\QrcodeController@create');
		route::any('/getstatus','WX\\QrcodeController@getstatus');

		route::any('/index','WX\\YqController@index');







});

//模板后台
//route::group(['middleware'=>['web','checkoutlogin']],functionc(){

    route::any('/admin','Admin\\IndexController@login');

    route::any('/admin/logindo','Admin\\IndexController@logindo');

//route::prefix('admin')->middleware('checkoutlogin')->group(function(){
route::prefix('admin')->middleware('checkoutlogin')->group(function(){

    route::any('index','Admin\\IndexController@index');

    route::any('subscribe','Admin\\SubscribeController@index');
	route::any('subscribe/settype','Admin\\SubscribeController@setResponseType');
	route::any('subscribe/add','Admin\\SubscribeController@add');
	route::any('subscribe/token','Admin\\SubscribeController@add');
	Route::any('/loginout','Admin\\IndexController@loginout');

	Route::any('subscribelist','Admin\\MaterialController@index');
	Route::any('materiallist','Admin\\MaterialController@getlist');
 	Route::any('materiallist/del/{media_id}','Admin\\MaterialController@del');
	//后台群发管理
	Route::any('/group/index','Admin\\GroupController@index');
	Route::any('/group/send','Admin\\GroupController@SendByOpenid');
	Route::any('/group/taghtml','Admin\\GroupController@tagHtml');

	Route::any('/group/createtag','Admin\\GroupController@createTag');
	Route::any('/group/gettaglist','Admin\\GroupController@GetTagList');
	Route::any('/group/sendbytag','Admin\\GroupController@sendByTag');
	Route::any('/group/addopenid','Admin\\GroupController@addopenid');
	Route::any('/group/setopenid','Admin\\GroupController@setopenid');
	Route::any('/group/sendopenid','Admin\\GroupController@sendopenid');
	Route::any('/group/getopenid','Admin\\GroupController@getopenid');


	//菜单

	Route::any('/menu/index','Admin\\MenuController@index');
	Route::any('/menu/add','Admin\\MenuController@add');
	Route::any('/menu/addmenu','Admin\\MenuController@addmenu');

	Route::any('/menu/menuupd/{id}','Admin\\MenuController@menuupd');
	Route::any('/menu/menuupddo/{id}','Admin\\MenuController@menuupddo');

	Route::any('/menu/set','Admin\\MenuController@wxmenu');
	Route::any('/menu/del','Admin\\MenuController@del');
	Route::any('/menu/personmenu','Admin\\MenuController@personmenu');


	Route::any('/menu/getmenu/{id}','Admin\\MenuController@getmenu');
	Route::any('/menu/forbidden/{id}','Admin\\MenuController@forbidden');


	//验证码操作
	Route::any('/menu/forbidden/{id}','Admin\\MenuController@forbidden');

});

//1811微信

    route::any('/wechat/index',"Wechat\\IndexController@index");


//1811微信后台管理

route::prefix('admins')->group(function(){
    route::any('index','Admins\\IndexController@index');


    route::any('replay',"Admins\\ReplayController@index");

});


//首次关注回复图片
route::group(['prefix'=>'material'],function(){
    route::any('index',"Wechat\\MaterialController@index");
    route::post('add',"Wechat\\MaterialController@add");

});

//周末作业
Route::prefix('/apiht')->group(function(){

	Route::any('index','apiht\UserController@index');
	Route::any('doindex','apiht\UserController@doindex');
	Route::any('dologin','apiht\UserController@dologin');
	Route::any('login','apiht\UserController@login');
});

//

//app接口开发手机号测试题A
Route::any('/tel/reg','exam\\TelController@reg');
Route::any('/tel/rand','exam\\TelController@rand');//验证码

Route::any('/tel/login','exam\\TelController@login');
Route::any('/tel/index','exam\\TelController@index');

Route::group(['middleware'=>'TelLogin'],function(){
	Route::any('/tel/doindex','exam\\TelController@doindex');
});


//app接口开发测试题B
route::any('exam/login',"exam\\UserController@login");
route::resource('exam/goods',"exam\\GoodsController")->middleware(['Elogin']);
route::any('exam/good',"exam\\GoodsController@good");





