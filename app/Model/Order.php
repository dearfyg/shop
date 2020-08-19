<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table="admin_order";
    //关联商品表
public $timestamps = false;
    public function order()
    {
        return $this->belongsTo(Order_goods::class,"goods_id","goods_id");
    }


}
