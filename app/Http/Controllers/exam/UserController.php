<?php

namespace App\Http\Controllers\exam;

use App\Model\Elogin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //
    public function login(Request $request)
    {

        $username = $request->username;
        $pwd = $request->pwd;
        $where = [
            'username'=>$username,
            'pwd'=>md5($pwd)
        ];
        $token = [
            'salt'=>'123456tqwert',
            'username'=>$username,
            'time'=>time(),
            'expect'=>time()+3600
        ];
        //序列化
        $tokens = serialize($token);
        //加密
        $tokenkey = encrypt($tokens);
        $res = DB::table('tuser')->where($where)->first();
        if($res){
            $userinfo=DB::table('tuser')->where('username',$username)->first();
            if(md5($pwd)==$userinfo->pwd) {
                $uid = $userinfo->uid;
                $data = [
                    'code' => 200,
                    'message' => '登录成功',
                    'data' => [
                        'token' => $tokenkey
                    ]
                ];
                return (json_encode($data));
            }
        }else{
            //无用户名
            $data = [
                'code'=>100,
                'message'=>'登录失败',
                'data'=>[]
            ];
            return(json_encode($data));
        }

    }


}




