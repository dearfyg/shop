<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{

    protected $table="admin_goods";
    protected $primaryKey="goods_id";
    protected $guarded=[];

    public function Category()
    {
        return $this->belongsTo(Category::class,"cate_id","id");
    }




}
