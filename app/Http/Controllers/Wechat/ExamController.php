<?php

namespace App\Http\Controllers\Wechat;

use App\Model\Code;
use App\Model\Menus;
use App\Model\WXchate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExamController extends Controller
{
    /*
     * 微信自定义菜单
     * */

    //个性化菜单创建
    public function makemenu()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".WXchate::GetAccessToken();
        $list = Menus::where('status',1)->where('pid',0)->get()->toArray();
        $data =[];

        foreach($list as $key => $val){
            $pid = $val['menu_id'];
            $size = Menus::where('pid',$pid)->count();
            if($size == 0 && $val['pid'] == 0){
                if($val['type']=='view'){
                    $data[] =[
                        'type' => $val['type'],
                        'name' => $val['name'],
                        'url' => $val ['url']
                    ];
                }elseif(in_array($val['type'],['click','location_select'])){
                    $data[] =[
                        'type' => $val['type'],
                        'name' => $val['name'],
                        'key' => $val ['key']
                    ];
                }elseif(in_array($val['type'],['click','scancode_waitmsg','scancode_push','pic_sysphoto','pic_photo_or_album','pic_weixin'])){
                    $data[] =[
                        'type' => $val['type'],
                        'name' => $val['name'],
                        'key' => $val ['key'],
                        'sub_button'=>[]
                    ];
                }elseif(in_array($val['type'],['media_id','view_limited'])){
                    $data[] =[
                        'type' => $val['type'],
                        'name' => $val['name'],
                        'media_id' => $val ['media_id'],

                    ];
                }
            }elseif($val['pid']==0 && $size !=0){
                //print_r($val);die;
                //一级菜单下有二级菜单
                $pid=$val['menu_id'];
                //dd($pid);
                $sonlist=Menus::where('status',1)->where('pid',$pid)->get()->toArray();
                //dd($sonlist);
                $info=[];
                foreach($sonlist as $k=>$v){
                    if($v['type']=='view'){
                        $info[]=[
                            'type'=>$v['type'],
                            'name'=>$v['name'],
                            'url'=>$v['url']
                        ];
                    }elseif(in_array($v['type'],['click','location_select'])){
                        $info[]=[
                            'type'=>$v['type'],
                            'name'=>$v['name'],
                            'key'=>$v['key']
                        ];
                    }elseif(in_array($v['type'],['scancode_waitmsg','scancode_push','pic_sysphoto','pic_photo_or_album','pic_weixin'])){
                        $info[]=[
                            'type'=>$v['type'],
                            'name'=>$v['name'],
                            'key'=>$v['key'],
                            'sub_button'=>[]
                        ];
                    }elseif(in_array($v['type'],['media_id','view_limited'])){
                        $info[]=[
                            'type'=>$v['type'],
                            'name'=>$v['name'],
                            'media_id'=>$v['media_id']
                        ];
                    }
                }
                $data[]=[
                    'name'=>$val['name'],
                    'sub_button'=>$info
                ];
            }
        }
        $info ['button'] = $data;
        $postjson =json_encode($info,JSON_UNESCAPED_UNICODE);
        $re =WXchate::HttpPost($url,$postjson);
        return $re;
    }


    //删除
    public  function delmenu()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".WXchate::GetAccessToken();
        $re = file_get_contents($url);
        dd($re);
    }



    //菜单视图

    public function menuindex()
    {
        $menulist = Menus::GetMenuList(0);


        return view('menu.index',['menu'=>$menulist]);
    }

    //创建二级菜单
    public function getsecondmenu(Request $request)
    {
        $pid = $request->pid;
        $secondlist = Menus::where('pid',$pid)->get()->toArray();
        return $secondlist;
    }

    //微信红包

    public function hbaddindex()
    {
        return view('material.hongbao');
    }


    public function hbaddo()
    {


    }


    //授权登录
    public function oauthlogin($userid)
    {
        $data=[
            'userid'=>$userid,
            'status'=>1,
            'update_time'=>date('Y-m-d H:i:s')
        ];

        Code::insert($data);
        sleep(5);
        $appid = env('WXAPPID');

        //授权后重定向的回调链接地址,使用 urlEncode 对链接进行处理
        $redirect_uri = urlencode("http://47.103.4.61/material/hongbao");
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=$userid#wechat_redirect";
        dd($url);
        return redirect($url);
    }


    //获取粉丝列表
    public function GetFansList(Request $request)
    {
        //获取粉丝列表
        $fans=WXchate::GetFansList();
//            dd($fans);
//            $fans='{"user_info_list":[{"subscribe":1,"openid":"ofYEo5yYc-9cQTTlfF9U8yPVTHPw","nickname":"忆拉罐","sex":1,"language":"zh_CN","city":"衡水","province":"河北","country":"中国","headimgurl":"http:\/\/thirdwx.qlogo.cn\/mmopen\/PiajxSqBRaEKET3KOqHoJn3ic6BumQicWkOoY7wVbu0FiaEhz012RLIicppQibY8FDBvCvXKG7Fd5R4qev6gnr9Yk0Qg\/132","subscribe_time":1560761183,"remark":"","groupid":0,"tagid_list":[],"subscribe_scene":"ADD_SCENE_QR_CODE","qr_scene":0,"qr_scene_str":""},{"subscribe":1,"openid":"ofYEo5xml-JmyE1UOeH0APyX0CyU","nickname":"T","sex":1,"language":"zh_CN","city":"菏泽","province":"山东","country":"中国","headimgurl":"http:\/\/thirdwx.qlogo.cn\/mmopen\/eJE2K7MTAfzg1rMicSc9gzXKRGuDE6dsWjqQAUtQticALmrRvjs0ZEMF5B1cqMlPtEwicRWC8E4HHZATwTLLf0NicaUTUpnBJZDk\/132","subscribe_time":1560743005,"remark":"","groupid":101,"tagid_list":[101],"subscribe_scene":"ADD_SCENE_QR_CODE","qr_scene":0,"qr_scene_str":""},{"subscribe":1,"openid":"ofYEo55_HJfzAYGQklaVGXZAAVts","nickname":"เจ้าชายน้อย 👑","sex":1,"language":"zh_CN","city":"Others","province":"Alaska","country":"US","headimgurl":"http:\/\/thirdwx.qlogo.cn\/mmopen\/aXUpZVUYfjx6gBOsJxgXOoY1t5cia2HbCn8zAeQW7S3Eibu59G9f4ia8R4WJNn5XjecSm2icukc3zgusRpByroeaictuq4SrtLG0H\/132","subscribe_time":1560477297,"remark":"","groupid":0,"tagid_list":[],"subscribe_scene":"ADD_SCENE_QR_CODE","qr_scene":0,"qr_scene_str":""}]}';
        return view('material.hongbao',compact('fans'));
    }


}
