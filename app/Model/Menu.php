<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $table = 'menu';
    protected $primaryKey = 'm_id';
    public $timestamps =false;

    public static function getMenu($id)
    {
        $data =self::where('pid',$id)->where('status',1)->get();
        return $data;
    }
}
