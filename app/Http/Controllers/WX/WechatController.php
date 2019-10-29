<?php

namespace App\Http\Controllers\WX;

use App\Model\Order;
use App\Model\Subscribe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Wechat;

class WechatController extends Controller
{
    /**
    *微信推送消息到开发者服务器
     *
     */
    public function valid(Request $request)
    {
        //链接微信接口
//        $echostr = $request->echostr;
//        if (CheckSignature($request)){
//            echo $echostr;
//        }

        $nonce = request()->nonce;
        $token =  'wx1810';
        $timestamp = request()->timestamp;
        $echostr = $request->echostr;
        $signature = request()->signature;

        //形成数组，然后按字典序排序
        $array = array();
        $array = array($nonce, $timestamp, $token);
        sort($array);
        //拼接成字符串,sha1加密 ，然后与signature进行校验
        $str = sha1(implode($array));
        if($str == $signature && $echostr){
                echo $echostr;
                exit;
         }else{
            $this->responseMsg();
        }
    }


 //关注回复
    public function responseMsg()
    {
        //接收微信推送过来的消息
        $postStr = file_get_contents("php://input");
//        dd($postStr);
        //处理xml
        $postObj = simplexml_load_string($postStr,"SimpleXMLElement",LIBXML_NOCDATA);
//         /   dd($postObj);
        $keywords = $postObj->Content;
        $toUserName = $postObj->ToUserName;
        $fromUserName = $postObj->FromUserName;
//        dd($fromUserName);
        //判断是不是事件
        if($postObj->MsgType == 'event'){
            //判断是不是关注事件
            if($postObj->Event == 'subscribe'){
                //首次回复图文、文本、图片 消息
                $responsetype =config('wx.Responsetype');
                $info = Subscribe::where('type',$responsetype)->orderBy('id','desc')->first();
                $type = ucfirst($responsetype);
                $actionName = "send".$type."Message";
                switch($responsetype)
                {
                    case 'text';
                        Wechat::$actionName($fromUserName,$toUserName,$info->content);
                        break;
//                    case 'news';
//                        Wechat::$actionName($fromUserName,$toUserName,$info->$info);
//                        break;
                    case 'news':
                        $title=$info->title;
                        $des=$info->des;
                        $url=$info->url;
                        $materail_url=$info->materail_url;
                        Wechat::sendNewsMessage($fromUserName,$toUserName,$title,$des,$url,$materail_url);
                        break;

                    case 'image';
                        Wechat::$actionName($fromUserName,$toUserName,$info->media_id);
                }
//                 $content = "你好哇,关注成功!!!";
//                $content = $info->content;
//                $this->sendTextMessage($fromUserName,$toUserName,$content);
            }
        }
//关键词回复
        if($keywords == '实况'){
            $content = "实况转播";
            Wechat::sendTextMessage($fromUserName,$toUserName,$content);
//            $this->sendTextMessage($fromUserName,$toUserName,$content);
        }elseif($keywords == '你不好'){
            $content = "你也好吗!!@@@@!????";
            Wechat::sendTextMessage($fromUserName,$toUserName,$content);

        }
        elseif(strstr($keywords,'订单')){
            $ordernum  = Wechat::GetOrderNum($keywords);
            $data = Order::getOrderinfo($ordernum);
            if (empty($data)){
                $content = "订单查阅失败了，请确认订单号之后再查询";
                Wechat::sendTextMessage($fromUserName,$toUserName,$content);
            }else{
                Order::OrderTplMessage($fromUserName,$data);
            }
        }elseif($keywords =='图片'){
            Wechat::sendImageMessage($fromUserName,$toUserName);
        }elseif($keywords =='视频'){
            Wechat::sendVideoMessage($fromUserName,$toUserName);
        }elseif($keywords =='语音'){
            Wechat::sendVoiceMessage($fromUserName,$toUserName);
        }elseif(strstr($keywords,'天气')){
                //获取城市名称
                $cityname = Wechat::GetCity($keywords);
//                dd($cityname);
                 //根据城市名获取天气发送模板
                Wechat::sendTplWeather($cityname,$fromUserName);
        }elseif( $keywords =='登录'){
            //微信授权登录
            $appid =env('WXAPPID');
            $uri = urlencode("http://47.103.4.61/wechat/wxlogin");
            $content = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$uri&response_type=code&scope=snsapi_userinfo&state=2121#wechat_redirect";
            Wechat::sendTextMessage($fromUserName,$toUserName,$content);
        }else{
//            $content = Wechat::tuling($keywords);
            //图灵机器人回复
            $content = Wechat::tuling($keywords);
            $res=Wechat::sendTextMessage($fromUserName,$toUserName,$content);
//            echo $res;
//            exit();
//            Wechat::sendTextMessage($fromUserName,$toUserName,$content);
//            $this->sendTextMessage($fromUserName,$toUserName,$content);
        }
    }


    //判定服务器
//    public  function CheckSignatrue($request)
//    {
////        dd($request);
//        $nonce =$request->nonce;
////        echo $nonce;
//        $timestamp =$request->timestamp;
//        $signature =$request->signature;
//        $token=env("                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         ");
////        echo $token;
//        $tmparr = array($token,$timestamp,$nonce);
////        dd($tmparr);
//        sort($tmparr,SORT_STRING);
//        $tmpstr = implode($tmparr);
//        $str = sha1($tmpstr);
//        if($str == $signature){
//            return true;
//        }else{
//            return false;
//        }
//    }



}
