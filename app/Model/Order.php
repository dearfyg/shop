<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table="admin_order";
    //关联商品表

    public function order()
    {
        return $this->belongsTo(Goods::class,"goods_id","goods_id");
    }


}