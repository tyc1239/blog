<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    //
    protected $table = 'menus';
    protected $primaryKey = 'menu_id';
    public $timestamps =false;

    public static function GetMenuList($pid)
    {
        $list = self::where('pid',$pid)->get()->toArray();

        $now = date("Y-m-d");
        if (!empty($list) && $now == $list[0]['update_time']) {
            return $list;
        } else {
            $re = WXchate::getMenuList($pid);
            return $re;
        }
    }

}
