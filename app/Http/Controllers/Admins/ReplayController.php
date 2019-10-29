<?php

namespace App\Http\Controllers\Admins;

use App\Model\Replay;
use App\Model\WXchate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReplayController extends Controller
{

    //设置首次关注 回复
        public  function index()
    {
         return view('admins.replay');
    }

    //回复添加
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
            $info = $request->picurl;
            $res =  $this->PremanentMeterial($info);
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
         $re = Replay::insert($data);


    }



    public static function PremanentMeterial($info)
    {
         $type = $info->type;
        $type = WXchate::getMaterialType($type);
        $path = $info ['path'];
        $token =WXchate::GetAccessToken();
        $url ="https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=$token&type=$type";

        $postdata = ['media'=>new \CURLFile(realpath($path))];
        $re = WXchate::HttpPost($url,$postdata);

        $info = json_decode($re,true);
        return $info;
    }


    //内容设置页面

    public function setType()
    {

        $type = config('wechat.type');
        return view('admins.settype',['type'=>$type]);
    }


    //设置回复类型
    public function setTypedo (Request $request)
    {
        $type = $request->type;
        $path = config_path('wechat.php');
        $content = "<?php \n return ".var_export(array('type'=>$type),true)."; \n ?>";
        $re = file_put_contents($path,$content);
         return $re;
    }


    /*
     * @content 将后台设置的回复类型存入到配合文件
     * */

    public function setContent(Request $request)
    {
        $type = $request->input('type','text');
        $configpath = config_path('wx.php');
        $config = ['Responsetype'=>$type];
        $str ='<?php return '.var_export($config,true).'?>';
        file_put_contents($configpath,$str);

    }

    //图文消息
    public static function sendNewsMessage($fromUserName,$toUserName,$title,$des,$url,$materail_url)
    {

        $itemTpl ="<item>
                      <Title><![CDATA[%s]]></Title>
                      <Description><![CDATA[%s]]></Description>
                      <PicUrl><![CDATA[%s]]></PicUrl>
                      <Url><![CDATA[%s]]></Url>
                    </item>";

        $item =sprintf($itemTpl,$title,$des,$url,$materail_url);
        $time =time();
        $newsTpl ='<xml>
                  <ToUserName><![CDATA[%s]]></ToUserName>
                  <FromUserName><![CDATA[%s]]></FromUserName>
                  <CreateTime>%s</CreateTime>
                  <MsgType><![CDATA[news]]></MsgType>
                  <ArticleCount>1</ArticleCount>
                  <Articles>
                        %s
                  </Articles>
                </xml>';
        $re = sprintf($newsTpl,$fromUserName,$toUserName,$time,$item);
        echo $re;
        exit;
    }






}
