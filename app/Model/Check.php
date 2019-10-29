<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    /**
     * 检验返回数据的格式
     * @param $format
     * @param $callback
     * @return bool
     */
    public static function checkformat($format,$callback)
    {
        $allow = ['xml','json'];
        if(in_array($format,$allow)){
            return true;
        }else{
            $data = [
                'code'=>'102',
                'message'=>'不允许的数据返回类型',
                'data'=>[

                ]
            ];
            die ($callback."(".json_encode($data,JSON_UNESCAPED_UNICODE).")");
        }
    }

    /**
     * 检查用户登录信息
     * @param $username
     * @param $pwd
     * @param $callback
     * @return bool
     */
    public static function checkloginparams($username,$pwd,$callback)
    {

        if(empty($username)||empty($pwd)||empty($callback)){
            $data = [
                'code'=>'101',
                'message'=>'不能为空la',
                'data'=>[
                    'username'=>$username,
                    'pwd'=>$pwd,
                    'callback'=>$callback,
                ]
            ];
            die ($callback."(".json_encode($data,JSON_UNESCAPED_UNICODE).")");
        }else{
            return true;
    }
    }
}
