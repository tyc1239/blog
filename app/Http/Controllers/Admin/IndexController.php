<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class IndexController extends Controller
{

    public function login ()
    {
        return view('admin.login');
    }
    //登陆
    public function logindo(Request $request)
    {
        $password=$request->password;
        $email=$request->email;

        if(!$email==''){
            $res=DB::table('reg')->where('email',$email)->where('password',$password)->first();
            if($res){
                echo"<script>alert('登录成功');location.href='/admins/index'</script>";
                request()->session()->put('email',123);
            }else{
                echo"<script>alert('登录失败');location.href='/admins'</script>";
            }
        }
    }
    //退出
    public function loginout(){
        request()->session()->forget('email');
        echo "<script>location.href='/admin'</script>";
    }

    public function index()
    {

        return view('admin.index');
    }
}
