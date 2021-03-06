<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Goods;
class GoodsController extends Controller
{
    public function goods(){
        //查询所有数据
        $goodsInfo = Goods::all()->toArray();
        //返回json
        return $this->Json("00000","成功",$goodsInfo);
    }
    //详情
    public function detail(){
       $id = request()->id;
        //查询
        $goodsInfo = Goods::find($id);
        //返回json
        return $this->Json("000000","成功",$goodsInfo);
    }
    //轮播图
    public function search(){
        $image = Goods::select("goods_img","goods_id")->where("is_up",1)->get();
        return $this->Json("00000","成功",$image);
    }
}
