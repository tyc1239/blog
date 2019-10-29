<?php

namespace App\Http\Controllers\WX;

use App\Model\Wxcode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\User;

class QrcodeController extends Controller
{
    //生成二维码
    public  function create()
    {
//        dd($_SERVER);
        //引入二维码类

        include_once public_path().'/Qrcode.php';
        $userid = uniqid();
        $value ="http://".$_SERVER['HTTP_HOST']."/wechat/wxcodelogin/".$userid;

          if(file_exists('/qrcode.png')){
            unlink('/qrcode.png');
        }
        \QRcode::png($value,'qrcode.png');
        return view('admin.qrcode',['userid'=>$userid]);
    }

    public function getstatus(Request $request)
    {
        $userid=request()->userid;
        $status=Wxcode::where('userid',$userid)->first();
        if(empty($status)){
            return 0;
        }else{
//            $data=json_decode($status,true);

            $status = $status->status;
//            if($status==2){
//                $openid=$data['openid'];
//                 $info=DB::table('users')->where('openid',$openid)->first();
//                request()->session()->put('name',$info);
//            }
            return $status;
        }
     }

}
