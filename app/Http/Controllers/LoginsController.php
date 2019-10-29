<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginsController extends Controller
{
	public function sendSms()
	{
					$email=request()->email;
				    $rand=request()->rand;
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
				    $rand=rand(10000,99999);
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
				    $requ=request()->session()->put('email'.$rand);
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

   public function reg()
   {
  		  $post=request()->except('_token');
			$idc=$post['idc'];
			$post['password']=md5($post['password']);
			 $emailidc = request()->session()->get('idc');
			// $data=DB::table('reg')->where('email',$email)->first();
			 $res=DB::table('reg')->insert($post);
			if ($idc!=$emailidc) {
			 echo"<script>alert('验证码有误');location.href='/goods/reg'</script>";
			}elseif ($res) {
				echo "<script>alert('注册成功');location.href='/goods/login'</script>";
			}else{
				echo "<script>alert('注册失败');location.href='/goods/reg'</script>";
			}

   }

   public function checkname (Request $request)
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
}
