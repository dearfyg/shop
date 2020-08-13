<?php

namespace App\Http\Controllers\Prize;

use App\Http\Controllers\Controller;
use App\Model\Userprize;
use Illuminate\Http\Request;
use App\Model\Prize;
use App\Model\User;
use Illuminate\Support\Facades\DB;
class PrizeController extends Controller
{
    /**
    抽奖页面
     ***/
    public function prize(){
        //中奖用户倒叙
        $info = Userprize::orderby("id","desc")->take(10)->get();
        //奖品信息
        $prize = Prize::all();
        return view("prize.index",["prize"=>$prize,"info"=>$info]);
    }
    /**抽奖规则***/
    public function prizeDo(){
        session(["user_id"=>1]);
        //查询用户抽奖机会
        $prize = User::select("prize")->first("user_id",session("user_id"));

        //查看抽奖机会是否充足
        if($prize->prize <=0){
            //不充足提示机会已用完
            $data = [
                "code"=>"您今日抽奖机会已用完",
            ];
            return $data;
        }else{
            //充足更新抽奖次数
            $count = $prize->prize - 1;

            User::where("id",session("user_id"))->update(["prize"=>$count]);
        }
        $count = rand(1,1000);
        $one = 1000 * 0.001;//一等奖中奖
        $two = 1000 * 100;           ;//二等奖中奖几率
       //判断落在一等奖范围内
        if($count >= 1 && $count<= $one){
            $num = Prize::select("prize_num")->where("prize_level",1)->first();
            if($num->prize_num<=0){
                $data = [
                    "code"=>"谢谢惠顾",
                ];
                return $data;
            }
            //运行到这里说明中奖
            DB::beginTransaction(); //开启事务
            //添加到中奖表
            $data = [
                "user_id" => session("user_id"),
                "prize_id" => 1,
                "prize_time"=>time(),
                "prize_last"=>time(),
            ];
            $ok = Userprize::insert($data);
            //抽奖表库存减一
            $kc = $num->prize_num - 1;
            $prizeOk = Prize::where("prize_level",1)->update(["prize_num"=>$kc]);
            // 判断俩条是否全部执行成功 成功提交否则回滚
            if($ok && $prizeOk){
                DB::commit();  //提交
                $data = [
                    "code"=>"恭喜您获得一等奖",
                    "sum" =>$kc
                ];
                 return $data;
            }else{
                DB::rollback();  //回滚
                $data = [
                    "code"=>"抽奖系统错误,请稍后再试",
                ];
                return $data;
            }
        }else if($count >=($one+1) && $count<=($two + $one) ){
            $two_num= Prize::select("prize_num")->where("prize_level",2)->first();
            if($two_num->prize_num<=0){
                return "谢谢惠顾";
            }
            //运行到这里说明中奖
            DB::beginTransaction(); //开启事务
            //添加到中奖表
            $data = [
                "user_id" => session("user_id"),
                "prize_id" => 2,
                "prize_time"=>time(),
                "prize_last"=>time(),
            ];
            $two_ok = Userprize::insert($data);
            //抽奖表库存减一
            $two_kc = $two_num->prize_num - 1;
            $prizeOk = Prize::where("prize_level",2)->update(["prize_num"=>$two_kc]);
            // 判断俩条是否全部执行成功 成功提交否则回滚
            if($two_kc && $prizeOk){
                DB::commit();  //提交
                $two_data = [
                    "code"=>"恭喜您获得二等奖",
                    "sum" =>$two_kc
                ];
                return $two_data;
            }else{
                DB::rollback();  //回滚
                $data = [
                    "code"=>"抽奖系统错误,请稍后再试",
                ];
                return $data;
            }
        }else{
            $data = [
                "code"=>"谢谢惠顾",
            ];
            return $data;
        }
    }
}
