<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Model\Goods;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /*
     * 博客列表
     */
    public function list(){
        $data=Goods::where("is_up",1)->orderBy("goods_id","desc")->paginate(3);
        return view("blog.list",["data"=>$data]);
    }
    /*
     * 博客详情
     */
    public function detail()
    {
        $goods_id=request()->goods_id;
        $data=Goods::where("goods_id",$goods_id)->first();
        return view("blog.detail",["data"=>$data]);
    }
}
