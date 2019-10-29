<?php

namespace App\Http\Controllers\Wechat;

use App\Model\Materials;
use App\Model\Menus;
use App\Model\WXchate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    //菜单首页

    public function index()
    {
        return view('material.index');
    }

    //上传素材
    public function add(Request $request)
    {
       if($request->hasFile('material')){
           $file = $request->material;
            $re = WXchate::UploadFile($file);
       }

        if($request->type==1){
          $res =  WXchate::TemporaryMaterial($re);
             $arr =[
                'media_id'=>$res['media_id'],
                'material_type'=>$res['type'],
                'type'=>1,
                'path'=>$re['path'],
                'create_time'=>$res['created_at']+3*24*60*59
            ];
        }else{
           $res = WXchate::PermanentMaterial($re);
              $arr =[
                'media_id'=>$res['media_id'],
                'material_type'=>WXchate::getMaterialType($re['type']),
                'type'=>2,
                'path'=>$res['url'],
                'create_time'=>time()+100*365*24*60*60
            ];
        }


        Materials::insert($arr);

    }



    //获取素材
    public function getMaterilas()
    {
        $token = WXchate::GetAccessToken();
        $mediaid = "XTj-mF_MeVTEd73CXh2eSOb5eQ5bsnZ1C_vdBbk8xycng1LrQlcpd8WxYZ_gWeBX";
        $url = "https://api.weixin.qq.com/cgi-bin/media/get?access_token=$token&media_id=$mediaid";
        $str = file_get_contents($url);
       // dd($str);
        $newname = 'abc.jpg';
        file_put_contents($newname,$str);
        echo "<img src='/abc.jpg' />";
    }



    /**
     *是否显示

     */
    public function changeShow()
    {
        $id = request()->id;
         $id = [$id];
        DB::beginTransaction();
        try{
            $res1 = DB::table('materials')->where('id',$id)->update(['is_show'=>1]);
            if ($res1 == 0){
                return ['msg'=>2,'font'=>'修改失败'];
            }
            $res2 = DB::table('materials')->whereNotIn('id',$id)->where('is_show',1)->update(['is_show'=>0]);
            if (!$res2){
                ['msg'=>2,'font'=>'修改失败'];
            }
            //提交
            DB::commit();
            return ['msg'=>1,'font'=>'修改成功'];
        }catch (Exception $a){
            DB::rollBack();
            report($a);
        }

    }


    //素材列表展示
   public function Materialslist (Request $request)

   {
       $page=request()->page??1;
       $query=request()->all();
       $material_type=$query['material_type']??'';
       $type=$query['type']??'';
       $where=[];
       if($material_type){
           $where['material_type']=$material_type;
       }
       if($type){
           $where['type']=$type;
       }

       $data=DB::table('materials')->where('material_type','image')->where($where)->paginate(3);
       return view('material.list',['data'=>$data],['query'=>$query]);
   }

    public function MaterialsTlist (Request $request)

    {
        $query=request()->all();
        $where=[];
        $data=DB::table('materials')->where('material_type','voice')->where($where)->paginate(3);
        return view('material.tlist',['data'=>$data],['query'=>$query]);
    }
    public function MaterialsSlist (Request $request)

    {
        $query=request()->all();
        $where=[];
        $data=DB::table('materials')->where('material_type','video')->where($where)->paginate(3);
        return view('material.slist',['data'=>$data],['query'=>$query]);
    }





    //素材删除
    public function Materialsdel($media_id)

    {
        $token =$token = WXchate::GetAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/material/del_material?access_token=$token";
        $media_id = [
            "media_id"=>$media_id
        ];
        $json = json_encode($media_id);
        $post = WXchate::HttpPost($url,$json);
        $res = json_decode($post,true);
        if($res){
            DB::table('materials')->where('media_id',$media_id)->delete();
            echo"<script>alert('删除成功');location.href='/material/list'</script>";
        }else{
            echo"<script>alert('删除失败');location.href='/material/list'</script>";
        }
    }

    //登陆
    public function login ()
    {
        return view('admin.login');
    }
    //登陆
    public function logindo(Request $request)
    {
        $password=$request->password;
        $email=$request->email;

        if(!$email==''){
            $res=DB::table('reg')->where('email',$email)->where('password',$password)->first();
            if($res){
                echo"<script>alert('登录成功');location.href='/admins/index'</script>";
                request()->session()->put('email',123);
            }else{
                echo"<script>alert('登录失败');location.href='/admins'</script>";
            }
        }
    }
    //退出
    public function loginout(){
        request()->session()->forget('email');
        echo "<script>location.href='/login'</script>";

    }



    //微信红包

    public function hbaddindex()
    {
        return view('material.hongbao');
    }

    public function hbadd()
    {
        $data = request()->all();
        $res = DB::table('hongbao')->insert($data);

    }



    public function hblist(Request $request)
    {
        $query=request()->all();
        $where=[];
        $data=DB::table('hongbao')->where($where)->paginate(2);
        $line=$data['line'];
        return view('material.hblist',['data'=>$data,'line'=>$line,'query'=> $query]);
    }

    //根据 openid 群发
    //获取视图
    public function groupsendopenid()
    {
        return view('message.index');
    }

    //发送
    public function sendmessage(Request $request)
    {
        $content = $request->desc;
        $token = WXchate::GetAccessToken();
        $url ="https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=$token";
        $openid =WXchate::GetOpenID();
//        dd($openid);
        $data= [
            'touser'=>$openid,
            'msgtype'=>'text',
            'text'=>[
                'content'=>$content
            ]
        ];

        $str = json_encode($data,JSON_UNESCAPED_UNICODE);
       echo WXchate::HttpPost($url,$str);


     }



    //根据标签进行群发
    //获取粉丝列表
    public function GetFansList(Request $request)
        {
            //获取粉丝列表
            $fans=WXchate::GetFansList();
//            dd($fans);
//            $fans='{"user_info_list":[{"subscribe":1,"openid":"ofYEo5yYc-9cQTTlfF9U8yPVTHPw","nickname":"忆拉罐","sex":1,"language":"zh_CN","city":"衡水","province":"河北","country":"中国","headimgurl":"http:\/\/thirdwx.qlogo.cn\/mmopen\/PiajxSqBRaEKET3KOqHoJn3ic6BumQicWkOoY7wVbu0FiaEhz012RLIicppQibY8FDBvCvXKG7Fd5R4qev6gnr9Yk0Qg\/132","subscribe_time":1560761183,"remark":"","groupid":0,"tagid_list":[],"subscribe_scene":"ADD_SCENE_QR_CODE","qr_scene":0,"qr_scene_str":""},{"subscribe":1,"openid":"ofYEo5xml-JmyE1UOeH0APyX0CyU","nickname":"T","sex":1,"language":"zh_CN","city":"菏泽","province":"山东","country":"中国","headimgurl":"http:\/\/thirdwx.qlogo.cn\/mmopen\/eJE2K7MTAfzg1rMicSc9gzXKRGuDE6dsWjqQAUtQticALmrRvjs0ZEMF5B1cqMlPtEwicRWC8E4HHZATwTLLf0NicaUTUpnBJZDk\/132","subscribe_time":1560743005,"remark":"","groupid":101,"tagid_list":[101],"subscribe_scene":"ADD_SCENE_QR_CODE","qr_scene":0,"qr_scene_str":""},{"subscribe":1,"openid":"ofYEo55_HJfzAYGQklaVGXZAAVts","nickname":"เจ้าชายน้อย 👑","sex":1,"language":"zh_CN","city":"Others","province":"Alaska","country":"US","headimgurl":"http:\/\/thirdwx.qlogo.cn\/mmopen\/aXUpZVUYfjx6gBOsJxgXOoY1t5cia2HbCn8zAeQW7S3Eibu59G9f4ia8R4WJNn5XjecSm2icukc3zgusRpByroeaictuq4SrtLG0H\/132","subscribe_time":1560477297,"remark":"","groupid":0,"tagid_list":[],"subscribe_scene":"ADD_SCENE_QR_CODE","qr_scene":0,"qr_scene_str":""}]}';
             return view('material.hongbao',compact('fans'));
        }

    //根据标签发送消息
    public function sendmessagebytag(Request $request)
    {

        $url = "https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=".WXchate::GetAccessToken();
        $data = [
            "filter"=>[
                "is_to_all"=>false,
                "tag_id"=>$request->tag
            ],
            "text"=>[
                "content"=>$request->contents
            ],
            "msgtype"=>"text"
        ];
        $res = json_encode($data,JSON_UNESCAPED_UNICODE);
        $json = WXchate::HttpPost($url,$res);
        echo $json;


    }



    public function GetTagList(Request $request)
    {
        $query=request()->all();
        $where=[];
        $data=DB::table('tag')->where($where)->paginate(5);
        $line=$data['line'];
        return view('message.taglist',['data'=>$data,'line'=>$line,'query'=> $query]);
    }




    //添加标签
    public function tagadd()
    {
        return view('message.tagadd');
    }

    //创建标签
    public  function createTag(Request $request)
    {
        $username =$request->username;
         $url = "https://api.weixin.qq.com/cgi-bin/tags/create?access_token=".WXchate::GetAccessToken();
        $postdata =[
            'tag'=>['name'=>$username]
        ];
        $str = json_encode($postdata,JSON_UNESCAPED_UNICODE);
        echo WXchate::HttpPost($url,$str);exit;

    }



    public function tagindex()
    {

        $url ="https://api.weixin.qq.com/cgi-bin/tags/get?access_token=".WXchate::GetAccessToken();
       // $re = file_get_contents($url);

       // dd($re);
        $re ="{\"tags\":[{\"id\":2,\"name\":\"星标组\",\"count\":0},{\"id\":100,\"name\":\"girl\",\"count\":0},{\"id\":101,\"name\":\"boy\",\"count\":1},{\"id\":102,\"name\":\"class\",\"count\":0},{\"id\":103,\"name\":\"teacher\",\"count\":0},{\"id\":104,\"name\":\"kid\",\"count\":0},{\"id\":105,\"name\":\"乐柠\",\"count\":0},{\"id\":106,\"name\":\"1811B\",\"count\":0}]}";
         $data =json_decode($re,true)['tags'];
      //  dd($data);
          return view('message.tagindex',['tags'=>$data]);
    }




    //给用户添加标签
    public function addusertag()
    {
        $data = DB::table('openid')->get();
        $dta = DB::table('tag')->get();
        return view('message.addusertag',['data'=>$data],['dta'=>$dta]);
    }

    public function addusertagdo(Request $request)
    {
        $openid = request()->openid;
        $name=request()->name;
        $url = "https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token=".WXchate::GetAccessToken();
        $data = [
            "openid_list" => [
                "ofYEo5xml-JmyE1UOeH0APyX0CyU",
                "ofYEo5yYc-9cQTTlfF9U8yPVTHPw",
                "ofYEo55_HJfzAYGQklaVGXZAAVts"

            ],
            "tagid" => $name
        ];
         $res = json_encode($data,JSON_UNESCAPED_UNICODE);
        $json = WXchate::HttpPost($url,$res);
       echo $json;
     }

    //为用户取消标签

    public function removeusertag()
    {

        $name=request()->name;
        $url = "https://api.weixin.qq.com/cgi-bin/tags/members/batchuntagging?access_token=".WXchate::GetAccessToken();
        $data = [
            "openid_list" => [
                "ofYEo5xml-JmyE1UOeH0APyX0CyU",
                "ofYEo5yYc-9cQTTlfF9U8yPVTHPw",
                "ofYEo55_HJfzAYGQklaVGXZAAVts"

            ],
            "tagid" => $name
        ];
        $res = json_encode($data,JSON_UNESCAPED_UNICODE);
        $json = WXchate::HttpPost($url,$res);
        echo $json;


    }

    //取消标签

    public function removetag()
    {

        $id = request()->id;
        $url = "https://api.weixin.qq.com/cgi-bin/tags/delete?access_token=".WXchate::GetAccessToken();
        $data = [

            "tagid" =>$id
        ];
          $res = json_encode($data,JSON_UNESCAPED_UNICODE);
        $json = WXchate::HttpPost($url,$res);
        echo $json;


    }


    //根据标签获取群发列表
    public function GetUserList()
    {

        $data = WXchate::getTagId();

        return view('message.getuserlist',compact('data'));

    }

    //根据标签发送消息
    public function sendmessagebytags(Request $request)
    {
        $content=request()->text;
        $name=request()->name;
        $url = "https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=".WXchate::GetAccessToken();
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
         $res = json_encode($data,JSON_UNESCAPED_UNICODE);
        $json = WXchate::HttpPost($url,$res);
        echo $json;


    }






    //授权登录获取红包
    public function gethb()
    {
        $code=request()->code;
         $appid = env('WXAPPID');
        $secret = env('WXAPPSECRET');
         $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
        $re =file_get_contents($url);
         $token = json_decode($re,true)['access_token'];
        $openid = json_decode($re,true)['openid'];

        $user_url ="https://api.weixin.qq.com/sns/userinfo?access_token=$token&openid=$openid&lang=zh_CN";
         $userinfo =file_get_contents($user_url);
        dd($userinfo);
    }


    /*
     * 微信自定义菜单
     * */

    //删除
    public  function delmenu()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".WXchate::GetAccessToken();
        $re = file_get_contents($url);
        dd($re);
    }


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

    //禁用该菜单
    public function forbidden(Request $request)
    {
        $id = $request->id;
        if($id == 'undefined'){
            $atr = [
                'code'=>10003,
                'message'=>'参数缺失'
            ];
            return json_encode($atr,true);
        }

        $list = Menus::where('menu_id',$id)->first()->toArray();
        $status =$list['status'];
        if($status == 1){
            $res =Menus::where('pid',$id)->where('status',1)->get()->toArray();
            if(empty($res)){
                $re =Menus::where('menu_id',$id)->update(['status'=>2]);
                if($re){
                    $atr = [
                        'code'=>10000,
                        'message'=>'禁用成功'
                    ];
                }else{
                    $atr = [
                        'code'=>10002,
                        'message'=>'禁用失败'
                    ];
                }
            }else{
                $atr = [
                    'code'=>10001,
                    'message'=>'该菜单包含子菜单，不可禁用'
                ];
            }
        }else{
            $pid = $list ['pid'];
            if($pid != 0){
                $info = Menus::where('menu_id',$pid)->first()->status;
                if($info ==2){
                    $atr = [
                        'code'=>10006,
                        'message'=>'请开启当前的一级菜单再启用'
                    ];
                    return json_encode($atr,true);
                }
            }
            $re = Menus::where('pid',$pid)->where('status',1)->count();
            if($pid == 0 && $re>=3 ){
                $atr = [
                    'code'=>10004,
                    'message'=>'一级菜单已经达到启用上限'
                ];
            }elseif($pid != 0 && $re>=5 ){
                $atr = [
                    'code'=>10005,
                    'message'=>'二级菜单已经达到启用上限'
                ];
            }else{
                $re =Menus::where('menu_id',$id)->update(['status'=>1]);
                if($re){
                    $atr = [
                        'code'=>20000,
                        'message'=>'启用成功'
                    ];
                }else{
                    $atr = [
                        'code'=>10002,
                        'message'=>'操作失败'
                    ];
                }
            }

        }
        return json_encode($atr,true);
    }

}
