<?php

namespace App\Http\Controllers\Admin;

use App\Model\Subscribe;
use App\Model\Wechat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use CURLFile;
use Illuminate\Support\Facades\Redis;

class SubscribeController extends Controller
{
    //设置首次关注 回复
    public  function index()
    {
//       $res =  Wechat::GetAccessToken();
//        dd($res);
        // 08O5NcfVVyUmmbIUVsQCi-4iDJcJfwIgJfBtun0X6z6N0gO4rYmOM5tJuckEwxeQ
        //efa1tn_lkpNnEAmkvhZH_umhP9wJ9FO4qBlWXImofme48KrDYekN_vPngACAd12b
        return view('admin.subscribe');
    }

    //
    public  function add (Request $request)
    {
        $type = $request->type;
        $content = $request->input('text',null);
        $des = $request->input('des',null);
        $title = $request->input('title',null);
        $click_url = $request->input('url',null);
        //判断请求中是否存在指定文件
         if($request->hasFile('picurl')){
             //执行文件上传操作
             //获取上传文件
            $file = $request->picurl;
            $res =  $this->PremanentMeterial($file);
         }
        $media_id = isset($res['media_id'])?$res['media_id']:null;
        $url = isset($res['url'])?$res['url']:null;
        $data =[
            'type'=>$type,
            'content'=>$content,
            'title'=>$title,
            'des'=>$des,
            'url'=>$url,
            'media_id'=>$media_id,
            'material_url'=>$url,
        ];
//        dd($data);
            $re = Subscribe::insert($data);
//        dd($re);


    }

    //上传永久素材
    public function PremanentMeterial($file)
    {
        $data = Wechat::UploadFile($file);
        $ext = $data['ext'];
        $path =public_path()."/". $data['path'];
        //根据后缀名  获取素材类型
        $type = Wechat::GetMaterialType($ext);

        $token = Wechat::GetAccessToken();
//            dd($token);
//                $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=$token&type=$type";
        $url="https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=$token&type=$type";
        $data = ['media'=>new CURLFile(realpath($path))];
//            dd($data);
        $re = Wechat::HttpPost($url,$data);
         $data = json_decode($re,true);
//        return $res =['url'=>$url,'data'=>$data];
//        dd($data);
        return $data;
 //        dd( $data);
         /*  "media_id" => "8HiSR-Qr1-8hl3BVb468asbmFEudGEl2Flr4dW5IVTE"
  "url" => "http://mmbiz.qpic.cn/mmbiz_jpg/709rsb5BQudy3JXBBZzL9icpW8jERiaLGHXDcETdUmAxOjv3NnL3juMe8cwVYJvmug0fKgNxyyTzDxgdUuneeQ4w/0?wx_fmt=jpeg"*/
    }


    /*
     * @content 将后台设置的回复类型存入到配合文件
     * */

    public function setResponseType(Request $request)
    {
        $type = $request->input('type','text');
        $configpath = config_path('wx.php');
        $config = ['Responsetype'=>$type];
        $str ='<?php return '.var_export($config,true).'?>';
        file_put_contents($configpath,$str);

    }


    //上传临时素材
    private function TemporaryMaterial()
    {
        $token = Wechat::GetAccessToken();
        //根据上传的后缀名 确定上传类型 需要一个文件的后缀名
        //上传文件的路径和文件名 必须是真是的文件路径
        // 文件上传
        $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=$token&type=TYPE";

    }

}
