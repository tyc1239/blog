<?php

namespace App\Http\Controllers\WX;

use App\Model\User;
use App\Model\Wxcode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    //微信授权登录
    public  function wxlogin()
    {
        $code=request()->code;
        $appid = env('WXAPPID');
        $secret = env('WXAPPSECRET');
        $redirect_uri = urlencode("http://".$_SERVER['HTTP_HOST']."/wechat/wxcode");
        $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
         $re =file_get_contents($url);

        $token = json_decode($re,true)['access_token'];
        $openid = json_decode($re,true)['openid'];

        $user_url ="https://api.weixin.qq.com/sns/userinfo?access_token=$token&openid=$openid&lang=zh_CN";
        $userinfo =file_get_contents($user_url);

         $info =  User:: where('openid',$openid)->first();

        if(empty($info))
        {
            //绑定
            return view('/admin/binding',['userinfo'=>serialize($userinfo)]);

        }else{
            //绑定成功 直接登录
            request()->session()->put('name',$info);
            $data=request()->session()->get('name');
            return redirect('/');
        }

     }



    public function  bindingdo (Request $request)
    {
        $post = request()->all();
         $username = $post['username'];
        $userinfo =unserialize($post['userinfo']);

         $data =[
            'openid'=>$userinfo['openid'],
             'nickname'=>$userinfo['nickname'],
            'headimgurl'=>$userinfo['headimgurl']
        ];

        $res = DB::table('users')->where('tel',$username)->update($data);

//        if($res){
//            request()->session()->put('user',$user);
//            echo"<script>alert('绑定成功');location.href='/'</script>";
//        }else{
//            echo"<script>alert('绑定失败，没有该用户');location.href='/admin/binding'</script>";
//        }
    }

    //微信扫码登录
    public function wxcodelogin($id)
    {
        $data=[
            'userid'=>$id,
            'status'=>1
        ];

        Wxcode::insert($data);
        $appid =env('WXAPPID');
        $uri = urlencode("http://".$_SERVER['HTTP_HOST']."/wechat/wxcode");
         $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$uri&response_type=code&scope=snsapi_userinfo&state=$id#wechat_redirect";
        return redirect($url);
     }


    public function wxcode(Request $request)
    {
        $userid = $request->state;
        Wxcode::where('userid',$userid)->update(['status'=>2]);
        $code=request()->code;
        $appid = env('WXAPPID');
        $secret = env('WXAPPSECRET');
        $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
        $res=file_get_contents($url);
        $token=json_decode($res,true)['access_token'];
         $openid = json_decode($res,true)['openid'];
        $user_url ="https://api.weixin.qq.com/sns/userinfo?access_token=$token&openid=$openid&lang=zh_CN";

        $userinfo =file_get_contents($user_url);
        $json_user = json_decode($userinfo,true);
        $info =DB::table('users')->where('openid',$json_user['openid'])->first();

//        dd($userinfo);
//        $info =  User:: where('openid',$openid)->first();
//        dd($info);
        if(empty($info))
        {
            //绑定
             return view('/admin/binding',['openid'=>serialize($json_user)]);

        }else{
            //绑定成功 直接登录


            request()->session()->put('name',$info);
            $data=request()->session()->get('name');
            return redirect('/');
        }
    }



}
