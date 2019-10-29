<?php

namespace App\Http\Controllers\Api;

use App\Tools\Auth\JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    //
    public function getToken()
    {
        $uid =1;
         $jwtAuth = JWTAuth::getInstance();

        $token = $jwtAuth->setuid($uid)->encode()->GetToken();

        $data = [
          'code'=>200,
            'msg'=>'success',
            'data'=>[
                'token'=>$token,
                'expire_in'=>time()+3600
            ],
        ];

        dd(json_encode($data,JSON_UNESCAPED_UNICODE));
        //$jwtAuth->SetToken($token)->decode();
    }

    //

    public function check(Request $request)
    {
        echo 123456;
//       $token = $request->token;
//        if(isset($token)){
//            $jwt =JWTAuth::getInstance();
//            $re = $jwt->SetToken($token)->validate();
//            dd($re);
//        }else{
//
//        }


    }

    //周一小测试
    public function TestMonday()
    {
        $color = array('蓝色','黄色','白色','黑色');
        $size  = array(36,37,38,39,40);
        $class = array('男士','女士');
        $goods = array('衬衫','裤子','鞋子');
        foreach ($class as $k=>$v)
        {
            foreach ($color as $ckey => $cval) {
                foreach ($goods as $gkey => $gval){
                    foreach ($size as $skey => $sval){
                        echo $v.$cval.$gval.$sval.'码';
                    }
                }
            }
        }


        $arr1 = ['blue'=>'蓝色','red'=>'红色','white'=>'白色','pink'=>'粉色'];
        $arr2 = ['first'=>'第一个','second'=>'第二个','third'=>'第三个'];

        foreach ($arr1 as $k=>$v){
            $arr[$v] = $k;
        }
        foreach ($arr2 as $k=>$v){
            $arr[$v] = $k;
        }
        dd($arr);



    }


    public function encode()
    {
        $re = openssl_pkey_new();
        openssl_pkey_export($re,$res);
        $file = './prikey.txt';
        file_put_contents($file,$res);
        var_dump($res);
    }
}
