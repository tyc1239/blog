<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class WXchate extends Model
{
    //文本

    public static function sendTextMessage($fromusername,$tousername,$content)
    {
        $textTpl =
            "<xml>
                          <ToUserName><![CDATA[%s]]></ToUserName>
                          <FromUserName><![CDATA[%s]]></FromUserName>
                          <CreateTime>%s</CreateTime>
                          <MsgType><![CDATA[text]]></MsgType>
                          <Content><![CDATA[%s]]></Content>
                        </xml>";
        $time = time();
        $str = sprintf($textTpl,$fromusername,$tousername,$time,$content);
        echo $str;
        exit;
    }

    //语音
     public static function sendVoiceMessage($fromusername,$tousername,$mediaid)
    {
         $time =time();
        $texttpl ="<xml>
                      <ToUserName><![CDATA[%s]]></ToUserName>
                      <FromUserName><![CDATA[%s]]></FromUserName>
                      <CreateTime>%s</CreateTime>
                      <MsgType><![CDATA[voice]]></MsgType>
                      <Voice>
                        <MediaId><![CDATA[%s]]></MediaId>
                      </Voice>
                    </xml>";

        $result = sprintf($texttpl,$fromusername,$tousername,$time,$mediaid);
        echo $result;
        exit;
    }

    //视频
     public static function  sendVideoMessage($fromusername,$tousername,$mediaid)
    {
         $time =time();
        $texttpl ="<xml>
                      <ToUserName><![CDATA[%s]]></ToUserName>
                      <FromUserName><![CDATA[%s]]></FromUserName>
                      <CreateTime>%s</CreateTime>
                      <MsgType><![CDATA[video]]></MsgType>
                      <Video>
                        <MediaId><![CDATA[%s]]></MediaId>
                        <Title><![CDATA[title]]></Title>
                        <Description><![CDATA[description]]></Description>
                      </Video>
                    </xml>";

        $result = sprintf($texttpl,$fromusername,$tousername,$time,$mediaid);
        echo $result;
        exit;
    }

    //图灵
    public static function tl($keyword)
    {
        $url = "http://openapi.tuling123.com/openapi/api/v2";
      //  $keyword = sprintf($keyword);
        $data = [
            'perception'=>[
                'inputText'=>[
                    'text'=>$keyword
                ]
            ],

            'userInfo'=>[
                'apiKey'=>env('TLKEY'),
                'userId'=>env('TLID')
            ]
        ];
         $post_data = json_encode($data,JSON_UNESCAPED_UNICODE);
           $re = self::HttpPost($url,$post_data);
           $data = json_decode($re,true);
            return $data['results'][0]['values']['text'];

    }


    //httppost

    public static function HttpPost($url,$post_data)
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL,$url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        return $data;
    }



    //httpget
    public  static function HttpGet()
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, 'http://www.baidu.com');
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER,0);
        //忽略ssl证书
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据
        $post_data = array(
            "username" => "coder",
            "password" => "12345"
        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        print_r($data);
    }


    //天气--获取城市
    public static function GetCity($keyword)
    {
        //正则
        $patten = "/^(.*)天气.*$/";
        preg_match($patten,$keyword,$result);
        $cityname = empty($result[1])?"北京":$result[1];
        return $cityname;
    }

    //获取天气
    public static function GetWeather($cityname)
    {
        $url ="https://www.tianqiapi.com/api/?version=v1&city=$cityname";
        $re = file_get_contents($url);
        $data = json_decode($re,true)['data'][0];

        $str ="当前城市.$cityname\n今天是".$data['date'].$data['week']."\n天气：：".$data['wea'];
        return $str;

    }

    //获取access_token
    public static function GetAccessToken()
    {
        $filename = public_path().'/wechat/access_token.txt';
        $info =file_get_contents($filename);
         $data = json_decode($info,true);
        if(!empty($data)){
            if($data['expire_time']<time()){
                $token = self::CreatAccessToken();
                $data =[
                    'access_token'=>$token,
                    'expire_time'=>time()+7000
                ];
                $str = json_encode($data,JSON_UNESCAPED_UNICODE);
                file_put_contents($filename,$str);
            }else{
                $token = $data ['access_token'];
            }

        }else{
            $token = self::CreatAccessToken();
            $data =[
                'access_token'=>$token,
                'expire_time'=>time()+7000
            ];
            $str = json_encode($data,JSON_UNESCAPED_UNICODE);
            file_put_contents($filename,$str);
        }

        return $token;


    }

    //生成 access_token
    public static function CreatAccessToken()
    {
        $appid = env("WXAPPID");
        $appsecret = env("WXAPPSECRET");
        $url ="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        //模拟get请求的方式
        $re = file_get_contents($url);
        return json_decode($re,true)['access_token'];


    }

    //周考 获取邮编
    public static function GetPostCode($keyword)
    {

        $appkey = env('POSTAPPKEY');
        $sign = env('POSTSIGN');
        $url = "http://api.k780.com/?app=life.postcode&postcode=$keyword&appkey=$appkey&sign=$sign&format=json";
         $content = file_get_contents($url);
        $con = json_decode($content,true);
         return $con['result']['lists'][0]['areanm'];

    }

    //发送图片消息
    public static function sendImageMessage($fromusername,$tousername,$mediaid)
    {
         $imageTpl ="<xml>
                      <ToUserName><![CDATA[%s]]></ToUserName>
                      <FromUserName><![CDATA[%s]]></FromUserName>
                      <CreateTime>%s</CreateTime>
                      <MsgType><![CDATA[image]]></MsgType>
                      <Image>
                        <MediaId><![CDATA[%s]]></MediaId>
                      </Image>
                    </xml>";
        $time = time();
        $result =sprintf($imageTpl,$fromusername,$tousername,$time,$mediaid);
         echo $result;
        exit;
    }

    //文件上传操作
    public  static function UploadFile($file)
    {
        //获取文件的后缀名
        $ext = $file->getClientoriginalExtension();
        $type = $file->getClientMimeType();
         //获取临时文件路径
        $path = $file->getRealpath();
        $newfilename ="uploads/".date('Ymd')."/".time().mt_rand(1111,9999).".".$ext;

        $re = Storage::disk('material')->put($newfilename,file_get_contents($path));

        if ($re){
            return [
                'path'=>$newfilename,
                'type'=>$type

            ];
        }else{
            die("上传出错");
        }

    }
//临时
    public static function TemporaryMaterial($info)
    {
        $type = $info['type'];
        $type = self::getMaterialType($type);
        $path = $info ['path'];
        $token =self::GetAccessToken();
        $url ="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=$token&type=$type";

        $postdata = ['media'=>new \CURLFile(realpath($path))];
        $re = self::HttpPost($url,$postdata);
         $info = json_decode($re,true);

        return $info;
    }

     static public function getMaterialType($type)
    {
        $data = explode('/',$type)[0];

        $allowtype =[
            'image'=>'image',
            'audio'=>'voice',
            'video'=>'video',
            'new'=>'new'
        ];

        return $allowtype[$data];
    }

    //永久

    public static function PermanentMaterial($info)
    {
        $type = $info['type'];
        $type = self::getMaterialType($type);
        $path = $info ['path'];
        $token =self::GetAccessToken();
        $url ="https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=$token&type=$type";

        $postdata = ['media'=>new \CURLFile(realpath($path))];
        $re = self::HttpPost($url,$postdata);

         $info = json_decode($re,true);
        return $info;
    }

    //获取订单号
    public static function getOrderNum($keyword)
    {
        $patten = "/^订单(.*)$/";
        preg_match($patten,$keyword,$re);
        return $re[1];
    }

    //发送订单模板消息
    public static function OrderTplMessage($fromusername,$info)
    {
        $token = self::GetAccessToken();
        $url ="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$token";
        $data = [
            'touser'=>"$fromusername",
            'template_id'=>'L-VIufAeHBFBXgmKo5xZfMAgw2R1AiQGu2Tfn-NWH0U',
             'data'=>[
                'ordernum'=>[
                    'value'=>$info['ordernum']
                ],
                 'goodsname'=>[
                     'value'=>$info['goodsname']
                 ],
                 'num'=>[
                     'value'=>$info['num']
                 ],
                 'price'=>[
                     'value'=>$info['goods_price']
                 ]
            ]
        ];

        $json =json_encode($data,JSON_UNESCAPED_UNICODE);
        $re =  self::HttpPost($url,$json);
        return $re;
    }

    //首次关注回复图文消息
    public static function SendNewsMessage($fromusername,$tousername,$info)
    {
        $voiceTpl =
            "<xml>
          <ToUserName><![CDATA[%s]]></ToUserName>
          <FromUserName><![CDATA[%s]]></FromUserName>
          <CreateTime>%s</CreateTime>
          <MsgType><![CDATA[news]]></MsgType>
          <ArticleCount>1</ArticleCount>
          <Articles>
            <item>
              <Title><![CDATA[%s]]></Title>
              <Description><![CDATA[%s]]></Description>
              <PicUrl><![CDATA[%s]]></PicUrl>
              <Url><![CDATA[%s]]></Url>
            </item>
          </Articles>
        </xml>";
        //dd($voiceTpl);
        $time = time();
        $title=$info->t_title;
        $content=$info->t_content;
        $path=$info->path;
        $url=$info->url;
        //格式化输出
        $str = sprintf($voiceTpl,$fromusername,$tousername,$time,$title,$content,$path,$url);
        echo $str;
        exit;
    }

    //获取openid
    public  static  function GetOpenID()
    {
        $token =self::GetAccessToken();
        $url= "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$token";
        $openlist = file_get_contents($url);
        $info =json_decode($openlist,true);
        $openid =$info['data']['openid'];
        return $openid;
    }

    //获取粉丝信息列表
    public static function GetFansList()
    {
        $token=self::getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token=$token";
        $openid=self::GetOpenID();
        $arr = [];
        foreach ($openid as $k=>$v){
            $arr[$k]['openid'] = $v;
        }
        $data = [
            'user_list' => $arr,
        ];
        $str = json_encode($data,JSON_UNESCAPED_UNICODE);
        $info = self::HttpPost($url,$str);
        //dd($info);
        return json_decode($info,true)['user_info_list'];
    }

    //获取标签列表
    static public function getTagId()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/tags/get?access_token=".self::getAccessToken();
        return json_decode(file_get_contents($url),true)['tags'];
    }


    //获取自定义菜单列表
    static public function getMenuList($pid)
    {

        // return file_get_contents($url);
        //$url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".self::getAccessToken();
        $res ='{"menu":{"button":[{"type":"view","name":"我的商城","url":"http:\/\/47.103.4.61","sub_button":[]},{"name":"操作","sub_button":[{"type":"click","name":"赞我一下","key":"clickme","sub_button":[]},{"type":"scancode_waitmsg","name":"扫码带提示","key":"rselfmenu_0_0","sub_button":[]},{"type":"scancode_push","name":"扫码推事件","key":"rselfmenu_0_1","sub_button":[]},{"type":"location_select","name":"发送位置","key":"rselfmenu_2_0","sub_button":[]},{"type":"media_id","name":"图片","sub_button":[],"media_id":"8HiSR-Qr1-8hl3BVb468agMJ9LbGVwudl4JLgzHcMRE"}]},{"name":"发送图片","sub_button":[{"type":"pic_sysphoto","name":"系统拍照发图","key":"rselfmenu_1_0","sub_button":[]},{"type":"pic_photo_or_album","name":"拍照或者相册发图","key":"rselfmenu_1_1","sub_button":[]},{"type":"pic_weixin","name":"微信相册发图","key":"rselfmenu_1_2","sub_button":[]}]}]}}';
        $res = json_decode($res,true)['menu']['button'];
        Menus::truncate();

      //  Menus::where('menu_id','>','0')->delete();
        $arr =[];
        foreach($res as $k=>$v){
            if(isset($v['type'])){
                //主菜单
                $arr[]=[
                    'pid'=>0,
                    'type'=>$v['type'],
                    'name'=>$v['name'],
                    'url'=>isset($v['url'])?$v['url']:null,
                    'key'=>isset($v['key'])?$v['key']:null,
                    'update_time'=>date('Y-m-d')
                ];
            }else{
                //次菜单
                $menu=[
                    'pid'=>0,
                    'type'=>null,
                    'name'=>$v['name'],
                    'url'=>isset($v['url'])?$v['url']:null,
                    'key'=>isset($v['key'])?$v['key']:null,
                    'update_time'=>date('Y-m-d')
                ];

                //返回刚刚添加的一条数据的id
                $pid=Menus::insertGetId($menu);
                //dd($pid);
                foreach($v['sub_button'] as $key=>$val){
                    $arr[]=[
                        'pid'=>$pid,
                        'type'=>$val['type'],
                        'name'=>$val['name'],
                        'url'=>isset($val['url'])?$val['url']:null,
                        'key'=>isset($val['key'])?$val['key']:null,
                        'update_time'=>date('Y-m-d')
                    ];
                }
            }
        }

        $re = Menus::insert($arr);
        if($re){
            $list = Menus::where('pid',$pid)->get()->toArray();
        }
        return $list;
     }

}
