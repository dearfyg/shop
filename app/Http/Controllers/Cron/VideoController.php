<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Video;
class VideoController extends Controller
{
    //视频自动解码
    public function decoder(){
        //获取状态值为0的所有数据 （数据库表 0为未）
        $video = Video::where("video_status",0)->get();
        //给出提示 多会开始执行的转码
        echo "开始转码:".date("Y-m-d H:i:s");
        //判断是否有数据
        if($video){
            //循环执行 因为不一定是一条数据
            foreach($video as $k=>$v){
                //获取当前的id
                $id = $v->id;
                //开始转码
                Video::where(['id'=>$id])->update(['video_status'=>1]);      //更新转码状态为 1  开始转码
                //使得客户端结束连接后，需要大量时间运行的任务能够继续运行。
                fastcgi_finish_request();//必须要有此函数否则定时任务会报错
                //所需参数
                //当前视频路径
                $video_path = $v->video_url;
                //转码后的视频路径
                $decode_path = "video_out".$id."/";
                //m3u8文件名
                $m3u8 = $decode_path.$v->video_title.".m3u8";
                //分片文件名
                $ts = $decode_path.$v->video_title."%03d.ts";
                //创建文件夹 加 2>&1可以查看错误信息
                $dir = "cd storage/public/ && mkdir -p hls/$decode_path 2>&1";
                shell_exec($dir);
                //执行解码
                $cmd = "cd storage/public/ && ffmpeg -i {$video_path} -codec:v libx264 -codec:a mp3 -map 0 -f ssegment -segment_format mpegts -segment_list  hls/{$m3u8} -segment_time 15  hls/{$ts} 2>&1";
                //执行
                shell_exec($cmd);
                //获取m3u8路径
                $m3u8_path = "/storage/public/hls/".$m3u8;
                //修改数据库
                Video::where("id",$id)->update(["video_status"=>2,"video_m3u8"=>$m3u8_path]);
            }
        }

    }
}
