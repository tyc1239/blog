<?php

namespace App\Http\Controllers\exam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TelController extends Controller
{
    //注册
    public function reg(Request $request)
    {
        $email = $request->email;

        $rand = $request->rand;
        $pwd = $request->pwd;
        $restel = DB::table('reg')->where('email',$email)->count();

        if(!empty($restel)){
            $data = [
                'code'=>10003,
                'message'=>'手机号已注册',
                'data'=>[
                ]
            ];
            return json_encode($data,JSON_UNESCAPED_UNICODE);
        }else{
            DB::table('reg')->insert(['email'=>$email,'rand'=>$rand,'pwd'=>$pwd]);
            $data = [
                'code'=>200,
                'message'=>'注册成功',
                'data'=>[
                ]
            ];
            return json_encode($data,JSON_UNESCAPED_UNICODE);
        }

    }
    //验证码
    public function rand(Request $request)
    {
        $email = $request->email;
        $rand =rand(1111,9999);
        $host = "http://dingxinyx.market.alicloudapi.com";
        $path = "/dx/marketSendSms";
        $method = "POST";
        $appcode = "aa9307b50f744255b13978d38cd34889";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "mobile=".$email."&param=code%3A".$rand."&tpl_id=TP18041310";
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        var_dump(curl_exec($curl));
    }


    /**
     * 登录
     * @param Request $request
     * @return string
     */
    public function  login(Request $request)
    {
        $email = $request->email;
        $pwd = $request->pwd;
        $where = [
            'email'=>$email,
            'pwd'=>$pwd
        ];
        $time = time();
        $token = [
            'salt'=>'sadfghjklds2345678ds',
            'email'=>$email,
            'time'=>$time,
            'exprec'=>$time + 3600
        ];
        $tokens = serialize($token);
        $tokenkey = encrypt($tokens);

        $res = DB::table('reg')->where($where)->first();
        if(!empty($res)){
            DB::table('reg')->where('email',$email)->update(['time'=>$time]);
            $data = [
                'code'=>200,
                'message'=>'登录成功',
                'data'=>[
                    'token'=>$tokenkey
                ]
            ];
            return json_encode($data,JSON_UNESCAPED_UNICODE);

        }else{
            $data = [
                'code'=>1000,
                'message'=>'用户名密码错误',
                'data'=>[
                ]
            ];
            return json_encode($data,JSON_UNESCAPED_UNICODE);

        }
    }

    public function index(Request $request)
    {
        $token = $request->token;
        $tokens = decrypt($token);
        $tokenkey = unserialize($tokens);
        $res = DB::table('reg')->where('email',$tokenkey['email'])->first();

        if($res){
            if($tokenkey['exprec']<time()){
                $data = [
                    'code'=>1006,
                    'message'=>'验证过期',
                    'data'=>[
                    ]
                ];
                return json_encode($data,JSON_UNESCAPED_UNICODE);
            }else if($tokenkey['time']!=$res->time){
                $data = [
                    'code'=>1009,
                    'message'=>'此IP以在别处登录',
                    'data'=>[
                    ]
                ];
                return json_encode($data,JSON_UNESCAPED_UNICODE);
            }else{
                $data = [
                    'code'=>200,
                    'message'=>'验证成功',
                    'data'=>[
                    ]
                ];
                return json_encode($data,JSON_UNESCAPED_UNICODE);
            }
        }else{
            $data = [
                'code'=>1004,
                'message'=>'验证失败',
                'data'=>[
                ]
            ];
            return json_encode($data,JSON_UNESCAPED_UNICODE);
        }
    }

    public function indexs(Request $request)
    {

    }
}
