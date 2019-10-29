<?php

namespace App\Http\Controllers\Wechat;

use App\Model\WXchate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayController extends Controller
{
    //
    public function NativePay()
    {
        $url="https://api.mch.weixin.qq.com/pay/unifiedorder";
        //参数
        $param=[
            'appid'=>'wxd5af665b240b75d4',
            //商户号
            'mch_id'=>'1500086022',
            //随机字符串 
            'nonce_str'=>uniqid(),
            //签名类型
            'sign_type'=>'MD5',
            //商品描述
            'body'=>'充值中心',
            //商品详情
            'detail'=>'detail',
            //商户订单号
            'out_trade_no'=>time().rand(10000,99999),
            //标价金额（分）
            'total_fee'=>1,
            //终端IP
            'spbill_create_ip'=>$_SERVER['REMOTE_ADDR'],
            //回调通知地址
            'notify_url'=>'http://47.103.4.61/wxpay/pay',
            //交易类型
            'trade_type'=>'NATIVE'
        ];
        //参数名ASCII码从小到大排序
        ksort($param);
        //使用URL键值对的格式（即key1=value1&key2=value2…）拼接成字符串stringA。
        $str=urldecode(http_build_query($param));
        //dd($str);
        //key为商户平台设置的密钥key
        $str .= '&key=7c4a8d09ca3762af61e59520943AB26O';
        //MD5签名方式
        $sign=MD5($str);
        //转为大写
        $signvalue=strtoupper($sign);
        //dd($signvalue);
        $param['sign']=$signvalue;
        //dd($param);
        //参数值(数组)用XML转义
        $info=$this->arr2xml($param);
        //dd($info);
        $re=WXchate::HttpPost($url,$info);
        //dd($re);
        $info=simplexml_load_string($re,'SimpleXMLElement',LIBXML_NOCDATA);
        $url=$info->code_url;
        include app_path().'/Tools/phpqrcode.php';
        \QRcode::png($url,'pay.png','H',6,2);
        echo "<img src='/pay.png' />";
    }


    //回调通知地址
    public function pay()
    {

    }


    public function arr2xml($arr)
    {
        $xml='<xml version="1.0" encoding="UTF-8">';
        foreach($arr as $key=>$value){
            if(is_numeric($value)){
                $xml.="<".$key.">".$value."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$value."]]></".$key.">";
            }

        }
        $xml.='</xml>';
        return $xml;
    }

}
