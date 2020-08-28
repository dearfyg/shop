<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function Json($code,$msg,$data){
        $arr = [
            'code'=>$code,
            'msg'=>$msg,
            'data'=>$data
        ];
        $arr = json_encode($arr);
        return $arr;
    }
}
