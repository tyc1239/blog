<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Elogin extends Model
{
    //
    public  $salt ='sdafghjhkdfsgh';
    public function createtoken($uid,$username)
    {
        $time =time();
       $data =[
         'uid'=>$uid,
           'username'=>$username,
           'salt'=>$this->salt,
           'create_time'=>$time,
           'expire_time'=>$time+3600
       ];

        $tmpstr =serialize($data);
        $token = encrypt($tmpstr);
        return $token;
    }
}
