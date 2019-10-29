<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreIndexPost;
use DB;
use Mail;

class IndexController extends Controller
{
    		public function index()
			{
//				dd(session('userinfo'));
			 	$data=DB::table('reg')->get();
                $email=request()->session()->get('email');
				$where=[];
                $data=DB::table('goods')->where($where)->paginate(3);
  				$g_name = $data['g_name'];
				if ($g_name) {
					$where[]=['g_name','like',"%$g_name%"];
				}
    			return view('index/index',['data'=>$data,'email'=>$email]);


			 
			}	

			public function logindo(Request $request)
			   {
			    	$post=$request->all();
			    	
			    	$where=[
			    		'email'=>$post['email'],
			    		'password'=>$post['password']
			    	];
			    	$email=$post['email'];
			    	$res=DB::table('reg')->where($where)->first();
			    	if($res){
		    		$request->session()->put('email',$email);
				    	echo"<script>alert('登录成功');location.href='/index'</script>";
				      }else{
				        echo"<script>alert('登录失败');location.href='/login'</script>";
				      }
			   	
			   }

			public function sendSms()
			{
					$email=request()->email;

					$reg = "/^1[0-9]\d{9}$/";
   					$chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
   					$rands=rand(10000,99999);
   					if (preg_match($reg, $email)) {

   					$host = "http://dingxin.market.alicloudapi.com";
				    $path = "/dx/sendSms";
				    $method = "POST";
				    $appcode = "aa9307b50f744255b13978d38cd34889";
				    $headers = array();
				    array_push($headers, "Authorization:APPCODE " . $appcode);
				    $querys = "mobile=13811636991&param=code%3A1234&tpl_id=TP1711063";
				    $bodys = "";
				    $url = $host . $path . "?" . $querys;

				    $curl = curl_init();
				    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
				    curl_setopt($curl, CURLOPT_URL, $url);
				    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
				    curl_setopt($curl, CURLOPT_FAILONERROR, false);
				    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				    curl_setopt($curl, CURLOPT_HEADER, false);
				    if (1 == strpos("$".$host, "https://"))
				    {
				        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				    }
				    var_dump(curl_exec($curl));
				    $res=request()->session()->put('email',$rands);
				    return['code'=>1,'msg'=>'手机号注册成功'];
   					}else if(preg_match($chars, $email)){
   						Mail::send('index/email',['rands'=>$rands],function($message)use($email){
   							$message->subject('你的验证码为');
   							$message->to($email);
   						});
   						$requ=request()->session()->put('email',$rands);
   							return['code'=>1,'msg'=>'请去邮箱检查，填写验证码'];
   					}else{
   							return['code'=>0,'msg'=>'注册失败'];
   					}



			}

		 

		public function checkname()
		{
			$email=request()->email;
			if (!$email) {
				return ['code'=>0,'msg'=>'请填写邮箱'];
			}
			$count=DB::table('reg')->where('email',$email)->count();
			if (!$count) {
				return['code'=>1,'msg'=>'邮箱可用'];
			}else{
				return['code'=>0,'msg'=>'邮箱已经被注册'];
			}
		}
		
		//退出登录
		public function logout(){
			request()->session()->forget('email');
			echo "<script>location.href='/login'</script>";
		}

		//注册
		public function addreg()
		{
			$post=request()->except('_token');
			$email=$post['email'];
			$data=DB::table('reg')->where('email',$email)->first();
			$res=DB::table('reg')->insert($post);
			if ($data) {
				echo "<script>alert('账号已存在');location.href='/reg'</script>";
			}elseif ($res) {
				echo "<script>alert('注册成功');location.href='/login'</script>";
			}else{
				echo "<script>alert('注册失败');location.href='/reg'</script>";
			}
		}

		//商品列表
		public function prolist()
		{
				$query=request()->all();
				$where=[];
				$g_name=$query['g_name']??'';
				if ($g_name) {
					$where[]=['g_name','like',"%$g_name%"];
				}
				$data=DB::table('goods')->where($where)->paginate(3);
				
				return view('index/prolist',['data'=>$data]);
		}

		//商品详情
		public function proinfo($g_id)
		{
			  $data=cache('data_'.$g_id);
			 if (!$data) {
			 	// echo 12345;
			 	$data=DB::table('goods')->where('g_id',$g_id)->first();
			 	cache(['data_'.$g_id=>$data],60*24); 
			 }
			

			// dd($data);
			return view('index/proinfo',['data'=>$data]);

		}

		//购物车
		public function cart($g_id)
		{
			// dd($g_id);
			
			if(!request()->session()->get('email')){
        		echo"<script>alert('请登录后再进行操作');location.href='/login'</script>";	
        	}
        	$email=request()->session()->get('email');
        	$where=['email'=>$email];
        	$u_id=DB::table('reg')->where('email',$email)->first();
        	// dd($u_id);
        	$uid=$u_id->uid;
        	// dd($uid);
        	$where=[
        	'uid'=>$uid,
        	'g_id'=>$g_id
        	];
         	// $res1=DB::table('cart')->where($where)->first();
         // 	$res1=DB::table('cart')->insert($where);

         // 	if ($res1) {
        	// 	echo"<script>alert('购物车已有');location.href='/prolist'</script>";
        	// 	die;
        	// }
        	$res=DB::table('cart')->insert($where);
        	if ($res) {
        		echo "<script>alert('加入购物车成功');location.href='/addcart'</script>";
        	}else{
        		echo "<script>alert('加入购物车失败');location.href='/prolist'</script>";
        	}


			// return view('index/cart',['data'=>$data]);
		}

		//添加购物车
		public function addcart()
		{
			if(!request()->session()->get('email')){
        		echo"<script>alert('请登录后再进行操作');location.href='/login'</script>";	
        	}

        	$shoping=DB::table('cart')->count();
        	// dd($shoping);
        	if ($shoping==0) {
        		echo"<script>alert('请添加一件商品到购物车');location.href='/prolist'</script>";
        	}
        	$email=request()->session()->get('email');
        	$u_id=DB::table('reg')->where('email',$email)->first();
        	// dd($u_id);
        	$uid=$u_id->uid;
        	$where=[
        		'uid'=>$uid,
        	];

        	$data=DB::table('cart')->where($where)->first();
        	$uid=$data->uid;
        	$cart=DB::table('cart')
        	->where('uid',$uid)
        	->join('goods','goods.g_id','=','cart.g_id')->get();
        	$num=DB::table('cart')
        	->where('uid',$uid)
        	->join('goods','goods.g_id','=','cart.g_id')->count();				
        	return view('index/addcart',['cart'=>$cart,'num'=>$num]);
		}

		//删除购物车商品
		public function delcart($c_id)
		{
			$res=DB::table('cart')->where('c_id',$c_id)->delete();
			if ($res) {
				echo "<script>alert('删除商品成功');location.href='/addcart'</script>";
			}else{
				echo "<script>alert('删除商品失败');location.href='/addcart'</script>";
			}

		}

		//订单提交
		public function addsuccess($g_id)
		{
			$rand=rand(100,999).time();
			$session=request()->session()->get('email');
			$email=DB::table('reg')->where('email',$session)->first();
			$uid=$email->uid;
			$g_price=DB::table('goods')->where('g_id',$g_id)->first();
			$success=DB::table('success')->get();
			foreach ($success as $key => $value) {
				$g_id=$value->g_id;
			}
			$g_price=$g_price->g_price;
			$data=[
				'g_id'=>$g_id,
				's_num'=>$rand,
				'uid'=>$uid,
				'g_price'=>$g_price,
				's_time'=>time(),
				'p_time'=>time()+3600
			];
			// dd($data);
			 $res=DB::table('success')->insert($data);
			if ($res) {
				echo"<script>alert('提交订单成功!!!');location.href='/success'</script>";
				DB::table('cart')->where('g_id',$g_id)->delete();
			}else if (!empty($g_id)) {
				echo"<script>alert('订单已存在???');location.href='/pay'</script>";
			}else{
				echo"<script>alert('订单提交失败！！！');location.href='/pay'</script>";
			}
		}

		public function success()
		{
			$data=DB::table('success')->get();
			$res=DB::table('success')->get()->toArray();
			foreach ($res as $key => $value) {
				$s_time=$value->p_time;
				$s_id=$value->s_id;
			}

			 	if(time()>=$s_time){
 				$ress=DB::table('success')->where('s_id',$s_id)->delete();
 			}
 			// dd($s_time);
			return view('index/success',['data'=>$data]);
		}



		//个人中心
		public function user()
		{
				$data=DB::table('reg')->get();
    			$email=request()->session()->get('email');
    			if ($email=='') {
    				echo"<script>alert('请登录后再进行操作');location.href='/login'</script>";
    			}
    			return view('index/user',['email'=>$email]);
		}

		//支付页面
		public function pay()
		{
				$g_id=request()->g_id;
				$data=DB::table('goods')->where('g_id',$g_id)->get();
				
				return view('index/pay',['data'=>$data]);

		}


		//我的订单
		public function order()
		{
			$data=DB::table('success')->get();
			foreach ($data as $key => $value) {
				$s_time=$value->s_time;
				$g_id=$value->g_id;
			}

			$res=DB::table('goods')->where('g_id',$g_id)->get();

			foreach ($res as $key => $value) {
				$g_img=$value->g_img;
				$g_price=$value->g_price;
			}
			// dd($g_price);
			return view('index/order',['data'=>$data,'g_img'=>$g_img,'g_prirce'=>$g_price]);
		}




		//memcache 缓存

		public function mamcache($id)
		{

			 $data=cache('data'.$id);
			 if (!$data) {
			 	echo "abcd";
			 	$data=DB::table('build')->where(['b_id'=>$id])->first();
			 	cache(['data'.$id=>$data],60*24); 
			 }
			 dd($data);
				
		}

}
 