<?php

namespace App\Http\Controllers\exam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($good_id)
    {
        //echo $goods_id;
        $data=DB::table('good')->where(['good_id'=>$good_id])->delete();
        //dd($data);
        if($data){
            $data = [
                'code'=>200,
                'message'=>'删除成功',
                'data'=>[]
            ];
            return json_encode($data,JSON_UNESCAPED_UNICODE);
        }else{
            $data = [
                'code'=>101,
                'message'=>'删除失败',
                'data'=>[]
            ];
            die(json_encode($data,JSON_UNESCAPED_UNICODE));
        }
    }

    public function good()
    {
        $data=DB::table('good')->limit(10)->get();
        return (json_encode($data,JSON_UNESCAPED_UNICODE));
    }


}
