<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUserPost;
use Illuminate\Validation\Rule;
use App\Model\Users;
use Mail;
use Illuminate\Support\Facades\Auth;


// use \DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data=DB::select('select * from user');
        // $data=DB::table('user')->select('uid','username','sex','age','class','head')->get();
        // dd($data);

        // dd($request->user());
        // dd(Auth::id());

        $query=request()->all();
        $where=[];
        $username=$query['username']??'';
        if ($username) {
            $where[]=['username','like',"%$username%"];
        }
        $age=$query['age']??'';
        if ($age) {
            $where['age']=$age;
        }


        $pageSize=config('app.pageSize');
        $data=DB::table('user')->where($where)->orderBy('uid','desc')->paginate($pageSize);
        return view('users.list',compact('data','username','age','query'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //表单验证2
    // public function store(StoreUserPost $request)

    public function store(Request $request)

    {
        //接收值
        // $post=$request->post();
        //except接收除了指定键外的
        $post=request()->except('_token');
        //only 值接收指定键的
        // $post=$request->only(['username','age','class']);
        if($request->hasFile('head')){
           $post['head']= $this->upload($request,'head');
        }
        // dd($post);
        // die;
        // unset($post['_token']);
        //原生SQL
        // $res=DB::insert('insert into user (username,age,class) value(?,?,?)',["$post[username]",$post['age'],$post['class']]);


        //表单验证1
        // $vali_data=$request->validate([
        //      'username' => 'required|unique:user|max:30|min:3',
        //      'age' => 'required|integer',
        //     ],
        //         [
        //             'username.required'=>'用户名不能为空',
        //             'username.unique'=>'用户名已经存在',
        //             'username.max'=>'用户名最大长度三十个字符',
        //             'username.min'=>'用户名最少三个字符',
        //             'age.required'=>'年龄不能为空',
        //             'age.integer'=>'年龄必须为数字',

        //         ]

        //     );
        // dd($vali_data);
        // die;

        


        //表单验证3
           $validator= \Validator::make($post, [
             'username' => 'required|unique:user|max:30|min:3',
             'age' => 'required|integer',
             ],
                [
                    'username.required'=>'用户名不能为空',
                    'username.unique'=>'用户名已经存在',
                    'username.max'=>'用户名最大长度三十个字符',
                    'username.min'=>'用户名最少三个字符',
                    'age.required'=>'年龄不能为空',
                    'age.integer'=>'年龄必须为数字',

                ]

             );

              if ($validator->fails()) {
                 return redirect('user/add')
                 ->withErrors($validator)
                 ->withInput();
                }



         // $res=DB::table('user')->insert($post);
        // dd($res);
         $res=Users::create($post);

        if($res){
            return redirect('/user/list')->with('msg','添加成功');

        }

        // dd($res);
        // echo 12345;
    }

    public function upload(Request$request,$name)
    {
        if ( $request->file($name)->isValid()) {
             $photo = $request->file($name);
              // $store_result = $photo->store('php');
             // $store_result = $photo->storeAs('photo', 'test.jpg');
             $extension=$request->$name->extension();
             $store_result=$photo->storeAs(date('Ymd'),date('YmdHis').rand(100,999).'.'.$extension);

             // print_r($store_result);exit();
                return $store_result;
             }
             exit('上传文件出错');

    }

    public function del(Request $request)
    {
        $uid=$request->uid;
        // dd($uid);
        //原生
        // $res=DB::delete('delete from user where uid='.$uid);
        // dd($res);
        //查询构造器
         // $res=DB::table('user')->where('uid',$uid)->delete();
        // 查询构造器（适用于主键字段是id）
        // $res=Db::table('user')->delete($uid);

        //  ORM
        // $res=Users::destroy($uid);
        $res=Users::where('uid',$uid)->delete();

        if($res){
            return redirect('/user/list')->with('msg','删除成功');

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *修改
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($id) {
            //原生SQL
            // $data=DB::select('select * from user where uid=:uid',['uid'=>$id]);
            //查询构造器
            // $data=DB::table('user')->where('uid',$id)->first();
            // dd($data);

            //ORM
            $data=Users::find($id);
            // dd($data);

            if (!$data) {
                return redirect('/user/list(varname)');
            }
            return view('users.edit',['data'=>$data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserPost $request, $id)
    {
        $post=$request->except('_token');
        // dump($post);

         if($request->hasFile('edit_head')){
           $post['head']= $this->upload($request,'edit_head');
           unset($post['edit_head']);
        }
        // dd($psot);
        //原生SQL更新
        // $res= DB::update('update user set username=:username,age=:age,head=:head,class=:class where uid='.$id,['username'=>$post['username'],'age'=>$post['age'],'head'=>$post['head'],'class'=>$post['class']]);
        //查询构造器
            // $res=DB::table('user')
            //         ->where('uid',$id)
            //         ->update($post);

        //ORM
        // $res=Users::where('uid',$id)->update($post);

        $users=new Users();
        $users->username=$post['username'];
        $users->age=$post['age'];
        $users->head=$post['head'];
        $users->class=$post['class'];
        $res=$users->save();
        dd($res);

       // if($res){
       //      return redirect('/user/list')->with('msg','修改成功');

       //  }
        // echo $id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkName()
    {
        $username=request()->username;
        if (!$username) {
            return['code'=>00000,'msg'=>'请填写用户名'];
        }
        $count=DB::table('user')->where('username',$username)->count();
        if (!$count) {
            return['code'=>1,'msg'=>'用户名可用'];
        }else{
            return['code'=>00000,'msg'=>'用户名已经存在'];
        }

    }

    public function send()
    {
       $email=request()->email;
       // dd($email);
       if ($email) {
           Mail::send('emailcon',['name'=>'tyc'],function($message)use($email){
                 //设置主题
                $message->subject("我爱北京天安门");
                 //设置接收方
                $message->to($email);



           });
       }
    }

    public function login()
    {
        // $data=request()->all();
        // dd($data);
        // $email=request()->email;
        $name=request()->name;
        // echo $name;
        $password=request()->password;
        // echo $email;
        // echo $password;
        // dd(Auth::attempt(['name'=>$name,'password'=>$password]));
        if (Auth::attempt(['name'=>$name,'password'=>$password])) {
            return redirect()->intended('/');
            // dd(request()->user());
        }

    }

    
}
