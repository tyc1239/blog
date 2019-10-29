<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cach;
use Mail;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *展示资源列表
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
         $query=request()->all();
        $where=[];
        $name=$query['name']??'';
        if ($name) {
            $where[]=['name','like',"%$name%"];
        }
        
        $data=DB::table('test')->where($where)->paginate(3);

        $line=$data['line'];
        return view('goods/list',['data'=>$data,'line'=>$line,'name'=>$name, 'query'=> $query]);
  
    }

    public function del(Request $request)
    {
        $tid=$request->tid;
        $res=DB::table('test')->where('tid',$tid)->delete();
        if ($res) {
             cache::pull(['data_'.$tid]);
            return redirect('/goods/list')->with('msg','删除成功了');
        }
    }

  

    public function edit($tid)
    {
        $data=DB::table('test')->where('tid',$tid)->first();
        return view('goods/edit',['data'=>$data]);

    }

    public function update(request $request,$tid)
     {   

        $post=$request->except('_token');
        if($request->hasFile('edit_logo')){
           $post['logo']= $this->upload($request,'edit_logo');
           unset($post['edit_logo']);
        }
        $res=DB::table('test')
        ->where('tid',$tid)
        ->update($post);
        if ($res) {
             cache(['data_'.$tid=>$res],60*1);
            return redirect('/goods/list')->with('msg','修改成功');
        }else{
            return redirect('/goods/list')->with('msg','你啥也没改啊');
        }
    }    

    public function upload(Request $request,$name)
    {
        if ($request->file($name)->isValid()) {
            $post=$request->file($name);
            $extension=$request->$name->extension();
            $store_result=$post->storeAs(date('Ymd'),date('YmdHis').rand(100,999).'.'.$extension);
            return $store_result;
        }
        exit('上传文件出错');
    }         

     public function proinfo ($tid)
    {

        $data=cache('data'.$tid);
        if (!$data) {
            // echo 12345;
            $data=DB::table('test')->where('tid',$tid)->first();
            cache(['data'.$tid=>$data],60*0.2);
        }
        return view('goods/proinfo',['data'=>$data]);
    }  

    public function reg ()
    {
       return view('goods/reg');
    }

    public function sendSms()
    {
                    $email=request()->email;
                    $rand=request()->rand;
                    $reg = "/^1[0-9]\d{9}$/";
                    $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
                    $rands=rand(10000,99999);
                    if (preg_match($reg, $email)) {

                    $host = "http://dingxin.market.alicloudapi.com";
                    $path = "/dx/sendSms";
                    $method = "POST";
                    $appcode = "aa9307b50f744255b13978d38cd34889";
                    $headers = array();
                    array_push($headers, "Authorization:APPCODE " . $appcode);
                    $rand=rand(10000,99999);
                    $querys = "mobile=13811636991&param=code%3A1234&tpl_id=TP1711063";
                    $bodys = "";
                    $url = $host . $path . "?" . $querys;

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curl, CURLOPT_FAILONERROR, false);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HEADER, false);
                    if (1 == strpos("$".$host, "https://"))
                    {
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                    }
                    var_dump(curl_exec($curl));
                    $requ=request()->session()->put('email'.$rand);
                    return['code'=>1,'msg'=>'手机号注册成功'];
                    }else if(preg_match($chars, $email)){
                        Mail::send('index/email',['rands'=>$rands],function($message)use($email){
                            $message->subject('你的验证码为');
                            $message->to($email);
                        });
                        $requ=request()->session()->put('email',$rands);
                            return['code'=>1,'msg'=>'请去邮箱检查，填写验证码'];
                    }else{
                            return['code'=>0,'msg'=>'注册失败'];
                    }

    }

    public function addreg()
    {
        $post=request()->except('_token');
            $idc=$post['idc'];
            $post['password']=md5($post['password']);
             $emailidc = request()->session()->get('idc');
            // $data=DB::table('reg')->where('email',$email)->first();
            // $res=DB::table('reg')->insert($post);
               $res=DB::table('reg')->insert($post);
            if ($idc!=$emailidc) {

             echo"<script>alert('验证码有误');location.href='/goods/reg'</script>";
            }elseif ($res) {
                echo "<script>alert('注册成功');location.href='/goods/login'</script>";
            }else{
                echo "<script>alert('注册失败');location.href='/goods/reg'</script>";
            }
    }
}
