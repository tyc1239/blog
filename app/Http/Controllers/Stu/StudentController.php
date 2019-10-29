<?php

namespace App\Http\Controllers\Stu;

use App\Model\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    //添加
    public function create()
    {
        return view('student.addstudent');
    }

    public function store(Request $request)
    {
        $all=$request->all();
        $data=Student::insert($all);
        if($data){
            $res=[
                'error'=>'1',
                'msg'=>'添加成功'
            ];
        }else{
            $res=[
                'error'=>'2',
                'msg'=>'添加失败'
            ];
        }
        return json_encode($res);
    }



    //删除

    public function destroy($id)
    {
        $data=Student::destroy($id);
        if($data){
            $res=[
                'error'=>'1',
                'msg'=>'删除成功'
            ];
        }else{
            $res=[
                'error'=>'2',
                'msg'=>'删除失败'
            ];
        }
        return json_encode($res);
    }



    //修改

    public function edit($id)
    {
        $data=Student::where(['id'=>$id])->first();
        return view('student.updatestudent',compact('data'));
    }

    public function update(Request $request, $id)
    {
        $all=$request->all();
        $data=Student::where(['id'=>$id])->update($all);
        if($data){
            $res=[
                'error'=>'1',
                'msg'=>'修改成功'
            ];
        }else{
            $res=[
                'error'=>'2',
                'msg'=>'修改失败'
            ];
        }
        return json_encode($res);
    }

    //查询

    public function index()
    {

         $data=Student::get();

        return view('student.indexstudent',compact('data'));
    }
}



