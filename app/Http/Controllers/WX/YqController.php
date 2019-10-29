<?php

namespace App\Http\Controllers\WX;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class YqController extends Controller
{
    public function index()
    {
        return view('admin.yq');
    }
}
