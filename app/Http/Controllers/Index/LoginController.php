<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Http\Request;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use Illuminate\Support\Facades\Redis;

class LoginController extends Controller
{
    //登录
    public function login(){
        return view("login.login");
    }
    /**
     * 注册
     */
    public function register(){
        return view("login.register");
    }
    /**
     * 获取验证码
     */
    public function gain(){
        $phone=request()->phone;
        if(!$phone){
            return $this->returnArr(0,"参数缺失");
        }
        $code=rand(100000,999999);
        //将验证码存入redis五分钟有效

        $res=$this->message($phone,$code);
        if($res["Message"]!="OK"){
            return $this->returnArr(0,"发送失败");
        }
        return $this->returnArr(1,"发送成功");
    }
    /**
     * 验证验证码
     */
    public function code(){

    }
    /**
     * 验证用户名是否存在
     */
    public function name(){
        $name=request()->name;
        if(!$name){
            return $this->returnArr(0,"参数缺失");
        }
        //查询用户名是否存在
        $res=User::where("user_name",$name)->first();
        if($res){
            return $this->returnArr(0,"用户名已存在");
        }
        return $this->returnArr(1,"ok");
    }
    /**
     * 短信发送验证码
     */
    public function message($phone,$code){
        // Download：https://github.com/aliyun/openapi-sdk-php
        // Usage：https://github.com/aliyun/openapi-sdk-php/blob/master/README.md

        AlibabaCloud::accessKeyClient(env("APP_ACCESSKEY"), env("APP_CLIEN"))
            ->regionId('cn-hangzhou')
            ->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => "cn-hangzhou",
                        'PhoneNumbers' => $phone,
                        'SignName' => "米米小院",
                        'TemplateCode' => "SMS_185230293",
                        'TemplateParam' => "{\"code\":\"$code\"}",
                    ],
                ])
                ->request();
            return $result->toArray();
        } catch (ClientException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        }

        //return view("message.message");
    }
    /**
     * 返回数据结构
     */
    public function returnArr($error,$msg){
        $arr=[
            "error"=>$error,
            "msg"=>$msg
        ];
        return $arr;
    }
}
