<?php

namespace App\Http\Controllers\apiht;

 use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;


class UserController extends Controller
{
    public function index()
    {
        $data = DB::table('apiht')->get();
        return view('apiht.index',['data'=>$data]);
    }

    public function doindex(Request $request)
    {
        $token = $request->token;
        $detoken =decrypt($token);
        $tokens = unserialize($detoken);
//        echo time();
//        dd($tokens['expect']);
        $re =DB::table('apiht')->where('username',$tokens['username'])->first();

        if($tokens['expect']<time()){
            $data =[
              'code'=>'101',
                'msg'=>'登录过期',
                'data'=>[

                ]
            ];
            return json_encode($data);
        }else if($tokens['expect']!=$re->time){
            $data =[
                'code'=>'102',
                'msg'=>'在别处登录',
                'data'=>[

                ]
            ];
            return json_encode($data);
        }else{
            $data =[
                'code'=>'200',
                'msg'=>'成功',
                'data'=>[
                    'token'=>$token
                ]
            ];
            return json_encode($data);
        }
    }

    public function login()
    {
        return view('apiht.pclogin');
    }

    public function dologin(Request $request)
    {
            //dd($request->all());
        $username= $request->username;
        $pwd = $request->pwd;
        $where =[
          'username' =>$username,
            'pwd'=>md5($pwd)
        ];

        $token =[
            'salt'=>'dasfgfg12345678',
            'username'=>$username,
            'time'=>time(),
            'expect'=>time()+3600
        ];

        $tokens =serialize($token);
        $entoken =encrypt($tokens);
       // dd($entoken);
        $re =DB::table('apiht')->where($where)->first();
        if($re){
            $isMobile = $this->isMobile();
            if($isMobile){
                DB::table('apiht')->where('username',$username)->update(['ip'=>2]);
            }else{
                DB::table('apiht')->where('username',$username)->update(['ip'=>1]);
            }
            $time =DB::table('apiht')->where('username',$username)->update(['time'=>$token['expect']]);

            $data = [
              'code'=>200,
                'msg'=>'ok',
                'data'=>[
                    'token'=>$entoken
                ]
            ];
            return json_encode($data);
        }else{
            $data = [
                'code'=>100,
                'msg'=>'no',
                'data'=>[

                ]
                ];
            return json_encode($data);

        }
     }

    //验证登录设备
    public function isMobile()
    {

        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备

        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {

            return TRUE;

        }

        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息

        if (isset ($_SERVER['HTTP_VIA'])) {

            return stristr($_SERVER['HTTP_VIA'], "wap") ? TRUE : FALSE;// 找不到为flase,否则为TRUE

        }

        // 判断手机发送的客户端标志,兼容性有待提高

        if (isset ($_SERVER['HTTP_USER_AGENT'])) {

            $clientkeywords = array(

                'mobile',

                'nokia',

                'sony',

                'ericsson',

                'mot',

                'samsung',

                'htc',

                'sgh',

                'lg',

                'sharp',

                'sie-',

                'philips',

                'panasonic',

                'alcatel',

                'lenovo',

                'iphone',

                'ipod',

                'blackberry',

                'meizu',

                'android',

                'netfront',

                'symbian',

                'ucweb',

                'windowsce',

                'palm',

                'operamini',

                'operamobi',

                'openwave',

                'nexusone',

                'cldc',

                'midp',

                'wap'

            );

            // 从HTTP_USER_AGENT中查找手机浏览器的关键字

            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {

                return TRUE;

            }

        }

        if (isset ($_SERVER['HTTP_ACCEPT'])) { // 协议法，因为有可能不准确，放到最后判断

            // 如果只支持wml并且不支持html那一定是移动设备

            // 如果支持wml和html但是wml在html之前则是移动设备

            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== FALSE) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === FALSE || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {

                return TRUE;

            }

        }

        return FALSE;
    }
}


?>
