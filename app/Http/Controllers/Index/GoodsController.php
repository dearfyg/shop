<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Model\Goods;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    /*
     * 产品列表
     */
    public function list(){
        //俩表联查
        $data=Goods::select("admin_goods.*","Category.id","Category.cate_name")
//                    ->where()
                    ->leftJoin("Category","admin_goods.cate_id","=","Category.id")
                    ->paginate(4);
        return view("goods.list",["data"=>$data]);
    }
    /*
     * 产品详情
     */
    public function detail(){
        //接产品id
        $id=request()->goods_id;
        //查询数据
        $data=Goods::where("goods_id",$id)
                    ->leftJoin("Category","admin_goods.cate_id","=","Category.id")
                    ->first();
        return view("goods.detail",["data"=>$data]);
    }
}
