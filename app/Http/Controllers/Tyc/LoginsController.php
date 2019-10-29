<?php

namespace App\Http\Controllers\Tyc;
use App\Model\Check;
use App\Model\Tuser;
use App\Tools\Auth\JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;


class LoginsController extends Controller
{
    //


    public function index(Request $request)
    {

        $obj =  new Tuser();
        $username = $request->username;
        $pwd = $request->pwd;
        $callback =$request->getuser;
        $format = $request->input('format','json');
        Check::checkformat($format,$callback);
        Check::checkloginparams($username,$pwd,$callback);
        $userinfo = Tuser::where('username',$username)->first();
        if(empty($userinfo)){
            $data =[
                'code'=>'1001',
                'message'=>'用户不存在',
                'data'=>[
                ]
            ];
            die ($callback."(".json_encode($data,JSON_UNESCAPED_UNICODE).")");
        }else{
            if(md5($pwd)==$userinfo->pwd){
                $uid = $userinfo->uid;
                $token = $obj->setsalt()->createtoken($uid,$username);
                $data =[
                    'code'=>'200',
                    'message'=>'success',
                    'data'=>[
                        'token'=>$token
                    ]
                ];
            }else{
                $data =[
                    'code'=>'1002',
                    'message'=>'密码错误',
                    'data'=>[
                    ]
                ];
            }
        }
        die ($callback."(".json_encode($data,JSON_UNESCAPED_UNICODE).")");

    }

    public function logout(Request $request)
    {
        $token = $request->token;
        $callback = $request->getuser;
        if(!empty($token)){
            $uid = unserialize(decrypt($request->token))['uid'];
            $info = Tuser::where('uid',$uid)->first();
            if($info){
                $data =[
                    'code'=>'200',
                    'message'=>'success',
                    'data'=>[
                        'username'=>$info->username
                    ]
                ];

                die ($callback."(".json_encode($data,JSON_UNESCAPED_UNICODE).")");
            }else{
                $data =[
                    'code'=>'1000',
                    'message'=>'error',
                    'data'=>[

                    ]
                ];
                die ($callback."(".json_encode($data,JSON_UNESCAPED_UNICODE).")");
            }


        }else{
            $data =[
                'code'=>'1001',
                'message'=>'缺少参数',
                'data'=>[

                ]
            ];
            die ($callback."(".json_encode($data,JSON_UNESCAPED_UNICODE).")");
        }

    }

    public function jwtlogin(Request $request)
    {
        if(!true){
            $jwt = JWTAuth::getInstance();
            $uid =1;
            $token =$jwt->setuid($uid)->setsalt()->encode()->GetToken();
        }else{
        $ip =$_SERVER['REMOTE_ADDR'];
            echo Redis::get($ip);
        }
    }
}
