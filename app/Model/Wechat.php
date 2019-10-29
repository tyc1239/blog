<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Wechat extends Model
{
    //发送文本
    public static function sendTextMessage($fromUserName,$toUserName,$content)
     {
        $time = time();
        $msgtype = "text";
        $texttpl = "<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                  <FromUserName><![CDATA[%s]]></FromUserName>
                                  <CreateTime>%s</CreateTime>
                                  <MsgType><![CDATA[%s]]></MsgType>
                                  <Content><![CDATA[%s]]></Content>
                                </xml>";


        $result = sprintf($texttpl,$fromUserName,$toUserName,$time,$msgtype,$content);
        echo $result;
        exit;

    }

    //调用图灵
    public static function tuling($keywords)
    {
        //图灵机器人调用接口
        $url = "http://openapi.tuling123.com/openapi/api/v2";
//        $url = "http://www.tuling123.com/openapi/api?key=5bcf49321bd94a6b8a969f097459463e&info={$keywords}";
         //拼接参数
        $data = [
            'reqType'=>0,
            'preception'=>[
                'inputText'=>[
                    'text'=>$keywords
                ],
            ],
            'userInfo'=>[
                'apiKey'=>'830d05aecbe74627bc69701c8b8d97cc',
                'userId'=>'wx93a92d21d0a878b7',
            ]
        ];
        //将参数转化为json格式
         $postjson = json_encode($data,JSON_UNESCAPED_UNICODE);
        //可以实现post提交方式的 post ajax curl guzzle
        $re = self::HttpPost($url,$postjson);
        //返回值转化成数组
        $data = json_decode($re,true);
        return $data['results'][0]['values']['text'];
    }


    //httppost

    public static function HttpPost($url,$post_data){
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL,$url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //忽略ssl证书
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
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


    //调用图文
    public static  function sendImageMessage($fromUserName,$toUserName)
    {

        $media_id = "YkulV5ra67IMuXcxZlaU_sQ3sGABdEM9V_oIdm56iYM7QIG44n3SdyYq5A8DQln2";

        $time = time();
            $texttpl ="<xml>
                              <ToUserName><![CDATA[%s]]></ToUserName>
                              <FromUserName><![CDATA[%s]]></FromUserName>
                              <CreateTime>%s</CreateTime>
                              <MsgType><![CDATA[image]]></MsgType>
                              <Image>
                                <MediaId><![CDATA[%s]]></MediaId>
                              </Image>
                        </xml>";
        $result = sprintf($texttpl,$fromUserName,$toUserName,$time,$media_id);
        echo $result;
        exit;
    }


    //调用视频
    public static function  sendVideoMessage($fromUserName,$toUserName)
    {
        $media_id="08O5NcfVVyUmmbIUVsQCi-4iDJcJfwIgJfBtun0X6z6N0gO4rYmOM5tJuckEwxeQ";
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

        $result = sprintf($texttpl,$fromUserName,$toUserName,$time,$media_id);
        echo $result;
        exit;
    }

    //调用语音
    public static function sendVoiceMessage($fromUserName,$toUserName)
    {
        $media_id="efa1tn_lkpNnEAmkvhZH_umhP9wJ9FO4qBlWXImofme48KrDYekN_vPngACAd12b";
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

        $result = sprintf($texttpl,$fromUserName,$toUserName,$time,$media_id);
        echo $result;
        exit;
    }

//图文消息
    public static function sendNewsMessage($fromUserName,$toUserName,$title,$des,$url,$materail_url)
    {
//        $data =$info->toArray();

        $itemTpl ="<item>
                      <Title><![CDATA[%s]]></Title>
                      <Description><![CDATA[%s]]></Description>
                      <PicUrl><![CDATA[%s]]></PicUrl>
                      <Url><![CDATA[%s]]></Url>
                    </item>";

//        $item =sprintf($itemTpl,$data['title'],$data['des'],$data['material_url'],$data['url']);
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

    //获取access_toke
    //params 参数
    //return token 微信接口调用唯一凭证
    public static  function GetAccessToken()
    {
        //获取token文件的路径
        $filename = public_path()."/token.txt";
        //获取文件的内容
        $str = file_get_contents($filename);
//        dd($str);
        $info = json_decode($str,true);
//        dd($info);
        if($info['expire']<time()){
            //过期 重新生成
            $token = self::CreateAccessToken();
            $exprice = time()+7000;
            $data = ['token'=>$token,'expire'=>$exprice];
            $info = json_encode($data);
            //chmod($filename,0777);
            file_put_contents($filename,$info);
        }else{
            $token=$info['token'];
        }
        return $token;
    }
        //生成token
     static private function CreateAccessToken()
    {
        $appid = env("WXAPPID");
        $appsecret = env("WXAPPSECRET");
        $token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        $re = file_get_contents($token_url);
        $token = json_decode($re,true)['access_token'];

        return $token;
    }

    //文件上传操作
    public  static function UploadFile($file)
    {
//        dd($file);
        //获取文件的类型 后缀名
        $ext = $file->getClientOriginalExtension();
//        echo $ext;die;
        //获取文件的类型
        $type = $file->getClientMimeType();
        //获取当前文件位置
        $path = $file->getRealPath();
//        echo $path;
         //拼接新的文件名
//        storage::disk('uploads');
        $newfilename = "/uploads/".date("Ymd")."/".mt_rand(10000,99999).".".$ext;
        $re = storage::disk('uploads')->put($newfilename,file_get_contents($path));
//        dd($re);
        if($re){
            $data = [
              'ext' =>$type,
                'path' =>$newfilename
            ];
            return $data;
        }else{
            exit("操作失败");
        }
    }
        //根据后缀名获取素材类型
        public static function GetMaterialType($ext)
            {
//                dd($ext);
                $info = explode('/',$ext);
                $type = $info[0];
                $allow_type = ['audio','video','image'];
            if(in_array($type,$allow_type)){
                    $return_type =[
                        'image'=>'image',
                        'audio'=>'voice',
                        'video'=>'video'
                    ];
                return $return_type[$type];
                }else{
                    echo"文件格式不符合";
                sleep(2);
                return view('admin.subscribe');
            }
            }

    //获取模板消息
        public  static  function GetOrderNum($keywords)
        {
                $pattern = "/^订单(\\d+)$/";
                preg_match($pattern,$keywords,$re);
                return $re[1];
        }


    //天气获取城市名称
    public  static  function GetCity($keywords)
    {
        //截取
        $data = explode('天气',$keywords);
        $city = empty($data[0])?"北京":$data[0];
        return $city;


        //通过正则匹配  php做的网络扒虫程序
        $patten = "/^(.*)天气.*$/";
        preg_match($patten,$keywords,$result);
        $cityname = empty($result[1])?"北京":$result[1];
        return $cityname;

        //分割成数组
    }

    //发送天气的模板消息
    public static function sendTplWeather($city,$fromUserName)
    {
        //rewrite pathinfo
        $url ="https://www.tianqiapi.com/api/?version=v1&city=$city";
        $re = file_get_contents($url);

        $data =json_decode($re,true);

//        $result = json_decode($re,true);
//        $data = $result [$data][0];
//        $str ="当前城市".$result['city']."\n今天是".$data['date'].$data['week']."\n天气：".$data['wea'];
//        return $str;

        $todaywheather =($data['data'][0]);

        $token =Wechat::GetAccessToken();
        $url ="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$token";
         $data = [
            'touser'=>"$fromUserName",
            'template_id'=>'X6O5WdBnCYgJoIWNkB41utE4v1c029jtFj9RuqPODds',
             'data'=>[
                'city'=>[
                    'value'=>$data['city'],
                ],
                'date'=>[
                    'value'=>$todaywheather['date'].$todaywheather['week'],
                ],
                'weather' =>[
                    'value'=>$todaywheather['wea'],
                ],
                 'high' =>[
                     'value'=>$todaywheather['tem1'],
                 ],
                 'low' =>[
                     'value'=>$todaywheather['tem2'],
                 ],
                 'air' =>[
                     'value'=>$todaywheather['air_level'],
                 ],
                 'out' =>[
                     'value'=>$todaywheather['air_tips'],
                 ],
                 'wind' =>[
                     'value'=>$todaywheather['win'][0].$todaywheather['win_speed'],
                 ]
            ]
        ];
//        dd($data);
        $json =json_encode($data,JSON_UNESCAPED_UNICODE);

          $re = Wechat::HttpPost($url,$json);
      }

        //获取关注者列表 返回关注者
        public  static  function GetOpenIDList()
        {
            $token =self::GetAccessToken();
            $url= "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$token";
            $openlist = file_get_contents($url);
            $info =json_decode($openlist,true);
            $openid =$info['data']['openid'];
            return $openid;
        }
}
