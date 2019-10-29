<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
   	protected $table='test';
    protected $primaryKey='tid';
    public $timestamps=false;

    protected $fillable = ['name','web','class','line','logo','ptc','desc','show'];
}
