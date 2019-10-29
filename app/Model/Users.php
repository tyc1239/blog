<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table='user';
    protected $primaryKey='uid';
    public $timestamps=false;

    protected $fillable = ['username','age','class','head'];
}
