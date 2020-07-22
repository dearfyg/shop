<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Model\Goods;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        $img=Goods::select("goods_id","goods_img","goods_name","goods_desc")->where("is_new",1)->orderBy("goods_id","desc")->take(3)->get();
        $new=Goods::select("goods_id","goods_img","goods_name","goods_price")->where("is_new",1)->orderBy("goods_id","desc")->take(4)->get();
        $hot=Goods::select("goods_id","goods_img","goods_name","goods_price")->where("is_hot",1)->orderBy("goods_id","desc")->paginate(4);
        return view("index.index",["img"=>$img,"new"=>$new,"hot"=>$hot]);
    }
}
