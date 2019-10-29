<?php

namespace App\Http\Controllers\Tyc;

use App\Model\Check;
use App\Model\Tuser;
use App\Tools\Auth\JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * 登录
     * @param Request $request
     */
    public function login(Request $request)
    {
        $obj =  new Tuser();
        $username = $request->username;
        $pwd = $request->pwd;
        $callback =$request->getuser;
        $format = $request->input('format','json');
        Check::checkformat($format,$callback);
        Check::checkloginparams($username,$pwd,$callback);
         $userinfo = Tuser::where('username',$username)->first();
        if(empty($userinfo)){
            $data =[
                'code'=>'1001',
                'message'=>'用户不存在',
                'data'=>[
                ]
            ];
            die ($callback."(".json_encode($data,JSON_UNESCAPED_UNICODE).")");
        }else{
            if(md5($pwd)==$userinfo->pwd){
                $uid = $userinfo->uid;
                $token = $obj->setsalt()->createtoken($uid,$username);
                $data =[
                    'code'=>'200',
                    'message'=>'success',
                    'data'=>[
                        'token'=>$token
                    ]
                ];
            }else{
                $data =[
                    'code'=>'1002',
                    'message'=>'密码错误',
                    'data'=>[
                    ]
                ];
            }
        }
        die ($callback."(".json_encode($data,JSON_UNESCAPED_UNICODE).")");


    }

    /**
     * 注册
     * @param Request $request
     * @return string
     */
    public function  reg(Request $request)
    {
        $username = $request->username;
        $pwd = $request->pwd;
        $email = $request->email;
        $regs =$request->regs;
        $data =[
          'username'=>$username,
            'pwd'=>md5($pwd),
            'email'=>$email
        ];

        $search = DB::table('tuser')->where('username',$username)->first();
        if($search){
            $json=[
                'code'=>110,
                'msg'=>'用户名已经存在',
                'data'=>[]
            ];
            return $regs."(".json_encode($json).")";
        }else{
            $res =DB::table('tuser')->insert($data);
            if($res){
                $json=[
                    'code'=>200,
                    'msg'=>'成功',
                    'data'=>[]
                ];
            }else{
                $json=[
                    'code'=>100,
                    'msg'=>'失败',
                    'data'=>[]
                ];

                return $regs."(".json_encode($json).")";
            }
        }

    }

    /**
     * 展示所有商品
     * @return mixed|string
     */
    public function goodlist()
    {
        $data=DB::table('goods')->get();
        //dd($data);
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    /**
     * 商品详情
     * @return string
     */
    public function goods()
    {
        $g_id=request()->g_id;

        $goods=DB::table('goods')->where('g_id',$g_id)->first();

        return json_encode($goods,JSON_UNESCAPED_UNICODE);
    }

    //添加购物车
    public function addcart()
    {
        //接受商品id  购买数量
        $g_id=request()->g_id;
        $c_num=1;
        //dd($goods_id);
        //根据用户id，商品id判断用户是否买过此商品
        //反序列化 解密
        $uid=unserialize(decrypt(request()->token))['uid'];
        //dd($uid);
        $where=[
            'uid'=>$uid,
            'g_id'=>$g_id,
            'is_del'=>1
        ];
        // dd($where);
        $cartInfo=DB::table('cart')->where($where)->first();
        // print_r($cartInfo);die;
        if(!empty($cartInfo)){
            // echo "累加";die;
            //用户买过之后 判断库存 累加
            // print_r($cartInfo);die;
            $number=$cartInfo->c_num;
            // echo $number;
            //根据id查询商品库存
            $g_stock=DB::table('goods')->where('g_id',$g_id)->value('c_num');
            // echo $goods_number;exit;
            //监测商品库存
            if($c_num+$number>$g_stock){
                $data=[
                    'code'=>'4001',
                    'message'=>'超出库存',
                    'data'=>[]
                ];
                die(json_encode($data,JSON_UNESCAPED_UNICODE));
            }
            // echo $buy_number;die;
            //没超库存执行修改数据
            $updateInfo=[
                //已加入购车的数量+将要购买数量
                'c_num'=>$number+$c_num
            ];
            // print_r($updateInfo);
            $result=DB::table('cart')->where($where)->update($updateInfo);
        }else{
            //echo "添加";die;
            //没买过 判断库存 添加
            //根据id查询商品库存
            $g_stock=DB::table('goods')->where('g_id',$g_id)->value('g_stock');
            // echo $goods_number;exit;
            //监测商品库存
            if($c_num>$g_stock){
                $data=[
                    'code'=>'4001',
                    'message'=>'超出库存',
                    'data'=>[]
                ];
                die(json_encode($data,JSON_UNESCAPED_UNICODE));
            }
            $info=[
                'g_id'=>$g_id,
                'c_num'=>$c_num,
                'uid'=>$uid
            ];
            // print_r($info);die;
            $result=DB::table('cart')->insert($info);
        }
        if($result){
            $data=[
                'code'=>'4000',
                'message'=>'加入购物车成功',
                'data'=>[]
            ];
            die(json_encode($data,JSON_UNESCAPED_UNICODE));
        }else{
            $data=[
                'code'=>'4004',
                'message'=>'加入购物车失败',
                'data'=>[]
            ];
            die(json_encode($data,JSON_UNESCAPED_UNICODE));
        }
    }


        //购物车
        public function cart()
    {
        //反序列化 解密
        $uid=unserialize(decrypt(request()->token))['uid'];
         $where=[
            ['uid','=',$uid],
             ['is_del','=',1],
         ];
        // dd($where);
        $data=DB::table('cart')
            ->join('goods','cart.g_id','=','goods.g_id')
            ->where($where)
            ->orderBy('c_id')
            ->get();
         // 获取小计
        if(!empty($data)){
            foreach ($data as $k => $v) {
                $total=$v->g_price*$v->c_num;
                $data[$k]->total=$total;
            }
        }
//        dd($data);
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    //购物车更改购买数量
    public function changenum()
    {
        $g_id=request()->g_id;
        $c_num=request()->c_num;
        // echo $g_id;exit;
       //  echo $c_num;exit;
        //根据id查询商品库存
        $g_stock=DB::table('goods')->where('g_id',$g_id)->value('g_stock');
        // echo $g_stock;exit;
        //监测商品库存
        if($c_num>$g_stock){
            $data=[
                'code'=>'4001',
                'message'=>'超出库存',
                'data'=>[]
            ];
            die(json_encode($data,JSON_UNESCAPED_UNICODE));
        }

        //获取用户id
        //反序列化 解密
        $uid=unserialize(decrypt(request()->token))['uid'];
        //dd($uid);
        $where=[
            'g_id'=>$g_id,
            'uid'=>$uid
        ];
        $updateInfo=[
            'c_num'=>$c_num
        ];
        $result=DB::table('cart')->where($where)->update($updateInfo);
        //dd($result);
        if($result){
            $data=[
                'code'=>'4000',
                'message'=>'更改成功',
                'data'=>[]
            ];
            die(json_encode($data,JSON_UNESCAPED_UNICODE));
        }else{
            $data=[
                'code'=>'4002',
                'message'=>'更改失败',
                'data'=>[]
            ];
            die(json_encode($data,JSON_UNESCAPED_UNICODE));
        }
    }

    public function getallprice()
    {
        //获取用户id
        //反序列化 解密
        $uid=unserialize(decrypt(request()->token))['uid'];
        //dd($uid);
        $where=[
            'uid'=>$uid,
            'is_del'=>1
        ];
        // print_r($where);exit;
        $info=DB::table('cart')
            ->select('g_price','c_num')
            ->join('goods','cart.g_id','=','goods.g_id')
            ->where($where)
            ->get();
        // print_r($info);exit;
        $count=0;
        foreach ($info as $k => $v) {
            $count+=$v->g_price*$v->c_num;
        }
        echo $count;
    }

    //删除购物车
    public function delcart()
    {
        $g_id=request()->g_id;
        // print_r($goods_id);die;
        //获取用户id
        //反序列化 解密
        $uid=unserialize(decrypt(request()->token))['uid'];
        //dd($uid);
        $where=[
            ['uid','=',$uid],
            ['g_id','=',$g_id]
        ];
        $updateWhere=[
            'is_del'=>2
        ];
        $res=DB::table('cart')->where($where)->update($updateWhere);
        if($res){
            $data=[
                'code'=>4005,
                'message'=>'删除成功',
                'data'=>[]
            ];
            die(json_encode($data,JSON_UNESCAPED_UNICODE));
        }else{
            $data=[
                'code'=>4006,
                'message'=>'删除失败',
                'data'=>[]
            ];
            die(json_encode($data,JSON_UNESCAPED_UNICODE));
        }
    }

}
