<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tuser extends Model
{
    /**
     * @var string
     */
    protected $table='tuser';
    protected $primaryKey='uid';
    public $timestamps=false;
    private $salt;

    /**
     * @return $this
     */
    public function setsalt()
    {
        $this ->salt =env('APISALT');
        return $this;
    }

    /**
     * 生成token
     * @param $uid
     * @param $username
     * @return string
     */
    public  function createtoken($uid,$username)
    {
        $array =[
            'uid'=>$uid,
            'username'=>$username,
            'create_time'=>time(),
            'expire'=>time()+7200,
            'salt'=>$this ->salt
        ];

        $str = serialize($array);
        $token = encrypt($str);
        return $token;
    }


    public function checktoken($params,$callback)
    {
        $token = decrypt($params);
        $info = unserialize($token);
        $expire = $info['expire'];
        $uid =$info['uid'];
        $username =$info['username'];

        if(time()>$expire){
            $data = [
                'code'=>'1000',
                'message'=>'登录失败，请重新登录',
                'data'=>[
                ]
            ];
            die ($callback."(".json_encode($data,JSON_UNESCAPED_UNICODE).")");
        }
        $userinfo = Tuser::where('uid',$uid)->first();
        if(!empty($userinfo) && $userinfo->username == $username){
            return true;
        }else{
            $data = [
                'code'=>'102',
                'message'=>'token 验证失败',
                'data'=>[

                ]
            ];
            die ($callback."(".json_encode($data,JSON_UNESCAPED_UNICODE).")");

        }

    }

}
