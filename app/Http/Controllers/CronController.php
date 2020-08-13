<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Video;
class CronController extends Controller
{
    public function cron(){
        //查询数据库未转码的视频
        $video=Video::where("status","0")->orderBy("id","desc")->get();
        echo " 开始转码 ： ". date("Y-m-d H:i:s");echo '</br>';
//        dd($video);
        //遍历数组，给每条视频转码
        if($video){
            foreach($video as $k=>$v){
                //获取商品id，更改数据库中转码状态
                $goods_id=$v->goods_id;
                Video::where("goods_id",$goods_id)->update(['status'=>1]);

                fastcgi_finish_request();//返回客户端或页面需要的数据，再进行后续的操作

                $video_url=$v->video_url;//获取源文件路径
                $video_url=substr($video_url,"6");
                $video_path='video_out';//转码后文件路径
                $m3u8_name=$video_path.$goods_id.'.m3u8';//m3u8文件名称
                $ts_file=$video_path.$goods_id.'_%03d.ts';//分片文件名称
                $ts_time='20';
                //执行命令转码
                $cmd="cd storage/files &&ffmpeg -i {$video_url} -codec:v libx264 -codec:a mp3 -map 0 -f ssegment -segment_format mpegts -segment_list $m3u8_name -segment_time $ts_time $ts_file";
                shell_exec($cmd);
                $m3u8_path="files/".$m3u8_name;
                Video::where("goods_id",$goods_id)->update(["status"=>2,"m3u8"=>$m3u8_path]);
            }
        }
    }
}
