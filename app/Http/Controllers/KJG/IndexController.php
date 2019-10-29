<?php

namespace App\Http\Controllers\KJG;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //首页
    public function index()
    {
        return view('kjgindex.index');
    }

    //注册
    public function register()
    {
        return view('kjgindex.register');
    }

    public function registerdo(Request $request)
    {
         //return $request;
        
    }

}
