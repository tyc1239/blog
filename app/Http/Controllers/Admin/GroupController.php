<?php

namespace App\Http\Controllers\Admin;

use App\Model\Wechat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\Tag;

class GroupController extends Controller
{
    //
    public  function index()
    {
//       // 获取所有关注者
//        $optionlist = Wechat::GetOpenIDList();
//        foreach($optionlist as $key=>$val){
//         $data = [
//           'openid'=>$val
//        ];
//         DB::table('openid')->insert($data);
//         }

        $data = DB::table('openid')->get();
        $dta = DB::table('tag')->get();
        return view('admin.openid',['data'=>$data],['dta'=>$dta]);
//        $obj =new Wechat();
//        //获取所有的关注者
//        $openidlist =$obj->GetOpenIDList();
//        return view('admin.openid',['openid'=>$openidlist]);

    }

    public function SendByOpenid(Request $request)
    {
        $openid=request()->openid;
//        print_r($openid);die;
        $aa=explode(',',$openid);
        $url ="https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=".Wechat::GetAccessToken();
        $content = '这个是群发不是单个发!!!!';

        $postjson = [
            "touser"=>[
                $aa
            ],
            "msgtype"=>"text",
            "text"=>[
                "content"=>$content
            ]
        ];
        $res=json_encode($postjson,JSON_UNESCAPED_UNICODE);
//        dd($postjson);
//        echo $postjson;
        echo Wechat::HttpPost($url,$res);
    }


//    //根据标签进行群发
//    public function sendByTag(Request $request)
//    {
//        $openid =request()->openid;
//        $url ="https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=".Wechat::GetAccessToken();
//
//        $postjson =json_encode($postdata,JSON_UNESCAPED_UNICODE);
//        $re =Wechat::HttpPost($url,$postjson);
//
//      }

    //创建标签的表单页面
    public function tagHtml()
    {
        return view('admin.taghtml');
    }


    //创建标签
    public  function createTag(Request $request)
    {
        $username =$request->username;
//         $username ='boy';
        $url = "https://api.weixin.qq.com/cgi-bin/tags/create?access_token=".Wechat::GetAccessToken();
        $postdata =[
                'tag'=>['name'=>$username]
        ];
        $postjson =json_encode($postdata,JSON_UNESCAPED_UNICODE);
        $re =Wechat::HttpPost($url,$postjson);
        $info =json_decode($re,true);
//        dd($info);
        $tagid =$info['tag']['id'];
        $filename =public_path().'/fans/'.$tagid.'.php';
//        dd($filename);
        touch($filename);
    }

    //获取标签列表
    public function GetTagList()
    {
        $url ="https://api.weixin.qq.com/cgi-bin/tags/get?access_token=".Wechat::GetAccessToken();
        $re = file_get_contents($url);
        $info =json_decode($re,true);
//        dd($info);
        $data =$info['tags'];
//        dd($data);
//        Tag::insert($data);


    }

    //给用户添加标签列表
    public function addopenid()
    {
        $data = DB::table('openid')->get();
        $dta = DB::table('tag')->get();
        return view('admin.addopenid',['data'=>$data],['dta'=>$dta]);
    }

    //给用户添加标签
    public function getopenid(Request $request)
    {
        $openid = request()->openid;
        $name=request()->name;
         $url = "https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token=".Wechat::GetAccessToken();
        $data = [
            "openid_list" => [
                "ofYEo5xml-JmyE1UOeH0APyX0CyU",
                "ofYEo5_kdOuiym5AOI_upJ9Bhg2E"
//                "oOm1w1WJjD-X1KfTUdr-A50Cb9Q0",
//                "oOm1w1anDZrRFMnVKbJauHsNY1Xo"

            ],
            "tagid" => $name
        ];
//        dd($data);
         $res = json_encode($data,JSON_UNESCAPED_UNICODE);
        $json = Wechat::HttpPost($url,$res);
        echo $json;
//        dd($json);

    }

    //获取粉丝列表
    public function GetFansList()
    {


    }

    //标签添加


    //根据标签获取群发列表
    public function setopenid()
    {
        $dta = DB::table('tag')->get();

        return view('admin.setopenid',['dta'=>$dta]);
    }

    //根据标签进行群发
    public function sendopenid(Request $request)
    {
//        $post = request()->except('_token');
        $content=request()->text;
        $name=request()->name;
          $url = "https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=".Wechat::GetAccessToken();
         $data = [
            "filter"=>[
                "is_to_all"=>false,
                "tag_id"=>$name
            ],
            "text"=>[
                "content"=>$content
            ],
            "msgtype"=>"text"
        ];
//        dd($data);
        $res = json_encode($data,JSON_UNESCAPED_UNICODE);
        $json = Wechat::HttpPost($url,$res);
        echo $json;
     }



}
