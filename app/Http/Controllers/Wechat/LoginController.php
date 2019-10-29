<?php

namespace App\Http\Controllers\Wechat;

use App\Model\Code;
use App\Model\WXchate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    //生成二维码 视图
    public function index()
    {
         include_once app_path().'/Tools/phpqrcode.php';
        //获取当前路径
        $server = $_SERVER['HTTP_HOST'];
        //生成唯一标识
        $userid =uniqid();
        $content = 'http://'.$server.'/user/oauthlogin/'.$userid;
        $file_name = 'code/code.png';
        if(file_exists($file_name)){
            //删除文件
            unlink($file_name);
        }
        \QRcode::png($content,'code/code.png');

        return view('user.code',['userid'=>$userid]);

    }

    //授权登录
    public function oauthlogin($userid)
    {
        $data=[
            'userid'=>$userid,
            'status'=>1,
            'update_time'=>date('Y-m-d H:i:s')
        ];

         Code::insert($data);
        sleep(5);
         $appid = env('WXAPPID');

        //授权后重定向的回调链接地址,使用 urlEncode 对链接进行处理
         $redirect_uri = urlencode("http://47.103.4.61/material/hongbao");
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=$userid#wechat_redirect";
        return redirect($url);
    }


    //扫码登录
    public function scanlogin()
    {
        $code=request()->code;
        $state=request()->state;
         $appid = env('WXAPPID');
        $secret = env('WXAPPSECRET');
        //请求方法  获取code后，请求以下链接获取access_token
        $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
        $re=json_decode(file_get_contents($url),true);

         //获取用户信息
        $token=$re['access_token'];
         $openid=$re['openid'];

        Code::where('userid',$state)->update(['openid'=>$openid,'status'=>2]);
        // echo "ok";
        $user_url="https://api.weixin.qq.com/sns/userinfo?access_token=$token&openid=$openid&lang=zh_CN";
        $userinfo=file_get_contents($user_url);
        $info=json_decode($userinfo,true);

        //模板消息
        $tplurl="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".WXchate::getAccessToken();
        $data = [
            'touser'=>$openid,
            'template_id'=>'M9TNrrIaFPmZlikkZH5kG3BILA22-FWnYwbwBwlt3LU',
            'data'=>[
                'time'=>[
                    'value'=>date('Y-m-d')
                ],
                'name'=>[
                    'value'=>$info['nickname']
                ],
                'url'=>[
                    'value'=>$_SERVER['HTTP_HOST']
                ],
            ],
        ];
        $str=json_encode($data,JSON_UNESCAPED_UNICODE);
        WXchate::HttpPost($tplurl,$str);
    }




    //扫描状态

    public function scanstatus(Request $request)
    {
        $userid=$request->userid;
        $status=Code::where('userid',$userid)->first();
        // dd($status);
        if (empty($status)){
            return 0;
        }else{
            return $status->status;
        }
    }


}
