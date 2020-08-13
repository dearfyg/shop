<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    protected $primaryKey = "id";
    public $table = "p_goods_video";
    public $timestamps = false;

}
