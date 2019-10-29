<?php 
// echo '1234'; die;

//$echostr=$_GET['echostr'];
// echo $echostr; die;

//接收用户发送sml数据 post方式
$xml = file_get_contents ('php://input');
//把 xml数据记录到本地文件里
file_put_contents('1.txt',$xml);
//xml转乘对象
$xmlObj = simplexml_load_string($xml);
//得到用户留言
$content = trim($xmlObj->Content);
if ($content == '1'){

	$msg = '你好';
}elseif ($content == '2'){
	$msg = '班级是1810B班';
}elseif ($content == '3'){
	$array = [1, 2, 3, 4, 5];
	$msg = array_rand($array);
 }
//回复文本消息 输出xml数据
echo"<xml>
  <ToUserName><![CDATA[".$xmlObj->FromUserName."]]></ToUserName>
  <FromUserName><![CDATA[".$xmlObj->ToUserName."]]></FromUserName>
  <CreateTime>".time()."</CreateTime>
  <MsgType><![CDATA[text]]></MsgType>
  <Content><![CDATA[".$msg."]]></Content>
</xml>";die;
