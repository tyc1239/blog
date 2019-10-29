<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
 // use App\Http\Requests\StoreUserPost;




class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *展示资源列表
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query=request()->all();
        $where=[];
        $name=$query['name']??'';
        if ($name) {
            $where[]=['name','like',"%$name%"];
        }
        
        $data=DB::table('test')->where($where)->paginate(2);

        $line=$data['line'];
        return view('test/list',['data'=>$data,'line'=>$line,'name'=>$name, 'query'=> $query]);
    }

    /**
     * Show the form for creating a new resource.
     *添加页面
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
    public function store(Request $request)
    {
         $post=request()->except('_token');

         if($request->hasFile('logo')){
           $post['logo']= $this->upload($request,'logo');
        }

         $validator= \Validator::make($post, [
             'name' => 'required|unique:test',
             'web' => 'required',
             ],
                [
                    'name.required'=>'网站名不能为空',
                    'name.unique'=>'网站名已经存在那',
                     'web.required'=>'网站不能为空',      
                ]
             );

              if ($validator->fails()) {
                 return redirect('test/add')
                 ->withErrors($validator)
                 ->withInput();
                }
             $res=DB::table('test')->insertGetId($post);
	        if($res){
	            return redirect('/test/list')->with('msg','添加成功');
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
          $data=DB::table('test')->where('tid',$id)->first();
          return view('test.edit',['data'=>$data]);

     }

      public function update(Request $request, $id)
    {
        $post=$request->except('_token');
          if($request->hasFile('edit_logo')){
           $post['logo']= $this->upload($request,'edit_logo');
           unset($post['edit_logo']);
        }
         $validator= \Validator::make($post, [
             'name' => 'required|unique:test',
             'web' => 'required',
             ],
                [
                    'name.required'=>'网站名不能为空',
                    'name.unique'=>'网站名已经存在那',
                     'web.required'=>'网站不能为空',      
                ]
             );
        if ($validator->fails()) {
                 return redirect('test/list')
                 ->withErrors($validator)
                 ->withInput();
                }

         $res=DB::table('test')
           ->where('tid',$id)
           ->update($post);
 
       if($res){
            return redirect('/test/list')->with('msg','修改成功');
        }else{
            return redirect('/test/list')->with('msg','你啥也没改啊');
        }
     }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request,$name)
    {
        if ($request->file($name)->isValid()) {
        	$post=$request->file($name);
         	$extension=$request->$name->extension();
        	$store_result=$post->storeAs(date('Ymd'),date('YmdHis').rand(100,999).'.'.$extension);
        	return $store_result;
        }
        exit('上传文件出错');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function del(Request $request)
    {
        $tid=$request->tid;
        $res=Test::where('tid',$tid)->delete();
        if ($res) {
        	return redirect('/test/list')->with('msg','删除成功了');
        }
    }


     public function checkName()
    {
        $name=request()->name;
        if (!$name) {
            return['code'=>00000,'msg'=>'请填写网站名'];
        }
        $count=DB::table('test')->where('name',$name)->count();
        if (!$count) {
            return['code'=>1,'msg'=>'网站名可用'];
        }else{
            return['code'=>00000,'msg'=>'网站名已经存在l'];
        }
        


    }

}
