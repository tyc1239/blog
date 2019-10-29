<?php

namespace App\Http\Controllers\Admin;

use App\Model\Menu;
use App\Model\Wechat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    //菜单展示
    public  function index()
    {
        $re = Menu::where(['status'=>1,'pid'=>0])->get()->toArray();
        return view('admin.menuindex',['menu'=>$re]);
    }

    //获取二级分类
    public  function getmenu($id)
    {
        $data =Menu::getMenu($id)->toArray();
        return $data;
    }


    //修改
    public function menuupd($id)

    {
        $data =DB::table('menu')->where('pid',0)->get();
        return view('admin.menuupd',['data'=>$data]);
    }

    //修改执行页面
    public function menuupddo()
    {

    }

    //删除
    public function forbidden($id)
    {
            $re =Menu::where(['status'=>1,'pid'=>$id])->get()->toArray();
        if(!empty($re)){
            //
            $data =[
                    'code'=>'10001',
                'message'=>'该菜单存在子菜单，先删除子菜单'
            ];
        }else{
            //软删除
            $re = Menu::where('m_id',$id)->update(['status'=>2]);
            if($re){
                $data=[
                    'code'=>'200',
                    'message'=>'删除成功了！！！'
                ];
            }else{
                $data =[
                    'code'=>10000,
                    'message'=>'删除失败？？？？'
                ];
            }
        }
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    //添加
    public function add()
    {
        $data =DB::table('menu')->where('pid',0)->get();
        return view('admin.menuadd',['data'=>$data]);
    }
    //添加执行页面
    public function addmenu(Request $request)
    {

        $post = request()->except('_token');

        $data = [
            'pid' => $post['pid'],
            'type' => $post['type'],
            'name' => $post['name'],
            'status' => 1
        ];
        $num = DB::table('menu')->where('pid', 0)->count();
        if ($num >= 3 && $post['pid'] == 0) {
            echo "<script>alert('顶级菜单超过三个');location.href='/admin/menu/add'</script>";
        } else {
            $ress = DB::table('menu')->where(['pid' => $post['pid']])->count();
            if ($ress >= 5) {
                echo "<script>alert('子菜单超过五个');location.href='/admin/menu/add'</script>";
            } else {
                $res = DB::table('menu')->insert($data);
                if ($res) {
                    echo "<script>alert('添加成功');location.href='/admin/menu/index'</script>";
                } else {
                    echo "<script>alert('添加失败');location.href='/admin/menu/add'</script>";
                }
            }

        }
    }

    //菜单上传
    public  function wxmenu()
    {
        $url ="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".Wechat::GetAccessToken();
        $info =Menu::where('status',1)->get()->toArray();
//        dd($info);
        $menuinfo =[];
        foreach($info as $k=>$v)
        {
            if($v['pid']==0)
            {
                $son_pid =$v['m_id'];
//                dd($son_pid);

                $soninfo =$this->getmenu($son_pid);
//                dd($soninfo);
                if(empty($soninfo)){
                    //一级菜单
                    if($v['type']=='view'){
                        $menuinfo[]=[
                            'type'=>'view',
                            'name'=>$v['name'],
                            'url'=>$v['url']
                        ];
                    }elseif($v['type']=='click')
                    {
                        $menuinfo[]=[
                            'type'=>'click',
                            'name'=>$v['name'],
                            'key'=>$v['key']
                        ];
                     }
                }else{
                    $sonarr = [];
                    //二级菜单
                    foreach($soninfo as $kk=>$vv)
                    {
                        //一级菜单
                        if($vv['type']=='view'){
                            $sonarr[]=[
                                'type'=>'view',
                                'name'=>$vv['name'],
                                'url'=>$vv['url']
                            ];
                        }elseif($vv['type']=='click')
                        {
                            $sonsrr[]=[
                                'type'=>'click',
                                'name'=>$vv['name'],
                                'key'=>$vv['key']
                            ];
                        }

                    }
                    $menuinfo[] =[
                        'name'=>$v['name'],
                        'sub_button'=>$soninfo
                    ];
//                    dd($menuinfo);
                }
            }
        }

//        dd($menuinfo);
        $menu =[
                'button'=>$menuinfo
        ];
        $postjson =json_encode($menu,JSON_UNESCAPED_UNICODE);
        $re =Wechat::HttpPost($url,$postjson);
        print_r($re);

    }

    //删除
    public  function del()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".Wechat::GetAccessToken();
        $re = file_get_contents($url);
        dd($re);
    }

    /*
     * @content 个性化菜单创建
     * */
    public function  personmenu()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token=" . Wechat::GetAccessToken();
        $data = [
            'button' =>
            [
                [
                    'type' => 'click',
                    'name' => '我的微信',
                    'key' => 123456
                ],
                [
                    'name' => '我的测试',
                    'sub_button' => [
                        [
                            'type' => 'click',
                            'name' => 'test',
                            'key' => 1234526
                        ]

                    ]

                ]

            ],
            'matchrule'=>[
                    'sex'=>1
            ]
        ];


        $postjson =json_encode($data,JSON_UNESCAPED_UNICODE);
        $re =Wechat::HttpPost($url,$postjson);
        dd($re);
    }


}
