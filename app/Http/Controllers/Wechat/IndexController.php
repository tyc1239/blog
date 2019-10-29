<?php

namespace App\Http\Controllers\Wechat;

 use App\Model\Materials;
 use App\Model\Orders;
 use App\Model\Replay;
 use App\Model\WXchate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
 use Illuminate\Support\Facades\DB;


 class IndexController extends Controller
{
    /*
     *
     * */
    public function index(Request $request)
    {
        if($request->isMethod('get')){
            if($this->checkSignature($request)){
                echo$request->echostr;
            }
        }else{
            $this->responseMsg();
        }


    }

    /*
     * 首次关注回复
     * */
    public function responseMsg()
    {
        //接收微信推送过来的消息
        $postStr = file_get_contents("php://input");
        //处理xml
        $postObj = simplexml_load_string($postStr,"SimpleXMLElement",LIBXML_NOCDATA);
             $keyword = $postObj->Content;
            $pattern = "/^\d{6}$/";
            $tousername = $postObj->ToUserName;
            $fromusername = $postObj->FromUserName;

        $responsetype =config('wx.Responsetype');

        $info = Replay::where('type',$responsetype)->orderBy('id','desc')->first();

        if($postObj->MsgType == 'event') {
            //判断是不是关注事件
//            if ($postObj->Event == 'subscribe') {
                $type = config('wechat.type');
                switch($type){
                    case 'text';
                        $content = DB::table('replay')->orderBy('id', 'desc')->first()->content;
                        WXchate::sendTextMessage($fromusername, $tousername, $content);
                        break;

                    case 'image';
                        $mediaid =  Materials::where('material_type','image')->where('create_time','>',time())->first()->media_id;
                        WXchate::sendImageMessage($fromusername,$tousername,$mediaid);
                        break;

                    case 'news':
                        $title=$info->title;
                        $des=$info->des;
                        $url=$info->url;
                        $materail_url=$info->materail_url;
                        WXchate::NewsTypeMessage($fromusername,$tousername,$title,$des,$url,$materail_url);
                        break;
                }
            }
        }

        if($keyword =='你好'){
            $content = "你也好啊！！！";
            WXchate::sendTextMessage($fromusername,$tousername,$content);
        }elseif($keyword =='红包'){
            $content ="抢红包：http://47.103.4.61/material/hblist";

            WXchate::sendTextMessage($fromusername,$tousername,$content);
        }elseif($keyword =='抢红包'){
            $appid = env('WXAPPID');
            $redirect_uri = urlencode("http://47.103.4.61/material/gethb");
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=123452121#wechat_redirect";
            $content = "<a href='".$url."'>点击抢红包</a>";
            WXchate::sendTextMessage($fromusername,$tousername,$content);
        }elseif(strstr($keyword,'天气')){
            $cityname = WXchate::GetCity($keyword);
            $content =WXchate::GetWeather($cityname);
            WXchate::sendTextMessage($fromusername,$tousername,$content);

        }elseif($keyword == 'token'){
            $content = WXchate::GetAccessToken();
            WXchate::sendTextMessage($fromusername,$tousername,$content);

        }elseif(preg_match($pattern,$keyword,$result)) {
            //邮编
        $content = WXchate::GetPostCode($keyword);
        WXchate::sendTextMessage($fromusername,$tousername,$content);

        }elseif($keyword =='图片'){
             $mediaid =  Materials::where('material_type','image')->where('is_show',1)->where('create_time','>',time())->first()->media_id;
             WXchate::sendImageMessage($fromusername,$tousername,$mediaid);
        } elseif($keyword=="图文"){
            $info=DB::table('text')->where('is_show',1)->where('material_type','news')->first();
            WXchate::SendNewsMessage($fromusername,$tousername,$info);
        }elseif($keyword =='视频'){
            $mediaid =  Materials::where('material_type','video')->where('create_time','>',time())->first()->media_id;
            WXchate::sendVideoMessage($fromusername,$tousername,$mediaid);
        }elseif($keyword =='音频'){
            $mediaid =  Materials::where('material_type','voice')->where('create_time','>',time())->first()->media_id;
            WXchate::sendVoiceMessage($fromusername,$tousername,$mediaid);
        }elseif(strstr($keyword,'订单')){
            $ordernum = WXchate::getOrderNum($keyword);
            $info = Orders::where('ordernum',$ordernum)->first();

            if (empty($info)){
                $content = "订单查阅失败了，请确认订单号之后再查询";
                WXchate::sendTextMessage($fromusername,$tousername,$content);
            }else{
               $re =  WXchate::OrderTplMessage($fromusername,$info);
                dd($re);
            }

        }else{
            $content = WXchate::tl($keyword);
            WXchate::sendTextMessage($fromusername,$tousername,$content);
        }

    }

    private function checkSignature(Request $request)
    {
         $nonce = $request->nonce;
        $timestamp = $request->timestamp;
         $signature = $request->signature;
        $token =env('WCTOKEN');
        $arr =[$token,$timestamp,$nonce];
        sort($arr,SORT_STRING);
        $str =implode($arr);
        $tmpstr =sha1($str);
        if($tmpstr ==$signature)
        {
             return true;
        }else{
             return false;
        }

     }


}
