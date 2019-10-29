<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //
    public function index()
    {

        return view('admins.index');
    }

    //登录
    public function login ()
    {
        return view('admins.login');
    }


}
