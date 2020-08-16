<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Model\GithubUser;
use App\Model\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use Illuminate\Support\Facades\Redis;

class LoginController extends Controller
{
    /**
     * 登陆
     */
    public function login(){
        //判断用户是否登陆
        if(empty(session("userinfo"))){
            return view("login.login");
        }
        return redirect("/");
    }
    /**
     * 退出登陆
     */
    public function quit(){
        request()->session()->flush("userinfo");
        return redirect("/");
    }
    /**
     * 执行登陆
     */
    public function loginDo(){
        //表单验证
        request()->validate([
            'user' => 'bail|required',
            'user_pwd' => 'bail|required',
        ],[
            "user.required"=>"用户名手机号或邮箱不可为空",
            "user_pwd.required"=>"密码不可为空",
        ]);
        //接值
        $user=request()->post("user");
        $pwd=request()->post("user_pwd");
        //判断用户名 or 手机号 or 邮箱 是否存在
        $res=User::where("user_name",$user)->orWhere("user_phone",$user)->orWhere("user_email",$user)->first();
        if($res){
            //判断密码是否正确
            if(password_verify($pwd,$res->user_pwd)){
                //判断账号状态，是否锁定
                if($res["error_num"]>=3 && time()-$res["error_time"]<600){
                    return redirect("/login")->with("msg","账号已锁定，请在十分钟后重试");
                }
                //登陆成功清空错误次数和时间
                User::where("user_id",$res["user_id"])->update(["error_num"=>0,"error_time"=>null]);
                //登陆成功
                //将用户信息冲入session
                session(["userinfo"=>$res->toArray()]);
                return redirect("/login")->with("msg","登陆成功");
            }
            $user_id=$res["user_id"];       //当前用户id
            $error_num=$res["error_num"];   //错误次数
            $error_time=$res["error_time"];     //最后错误时间
            //判断错误次数
            if($error_num>=3){
                //判断最后登陆错误时间和当前时间是否超过十分钟
                if(time()-$error_time > 600){
                    //超过十分钟修改错误次数为1 错误时间为当前时间戳
                    User::where("user_id",$user_id)->update(["error_num"=>1,"error_time"=>time()]);
                    //登陆失败
                    return redirect("/login")->with("msg","账号或密码错误");
                }else{
                    //未超过十分钟提示账号已锁定
                    return redirect("/login")->with("msg","账号已锁定，请在十分钟后重试");
                }
            }else{
                //错误次数加1
                $error_num=$error_num+1;
                //修改错误次数以及错误时间
                User::where("user_id",$user_id)->update(["error_num"=>$error_num,"error_time"=>time()]);
                //判断如果错误次数加1等于3锁定账号
                if($error_num<3){
                    //登陆失败
                    return redirect("/login")->with("msg","账号或密码错误");
                }
                return redirect("/login")->with("msg","账号已锁定，请在十分钟后重试");
            }
        }
        //登陆失败
        return redirect("/login")->with("msg","账号或密码错误");
    }
    /**
     * github登陆
     */
    public function loginGithub(){
        $url="https://github.com/login/oauth/authorize?client_id=".env('OAUTH_GITHUB_ID')."&redirect_uri=".env("APP_URL")."/oauth/github";
        return redirect($url);
    }
    /**
     * github回调
     */
    public function github(){
        //接受github返回的code
        $code=$_GET["code"];
        //换取access_token
        $token=$this->getToken($code);
        //获取github用户信息
        $UserInfo=$this->githubUserInfo($token);
        //判断该github是否存在
        $res=GithubUser::where("guid",$UserInfo["id"])->first();
        if(!$res){
            //将用户信息填入数据库
            //判断github用户名是否为空
            if(empty($UserInfo["name"])){
                //生成随机用户名
                $UserInfo["name"]=substr(md5(rand(10000,99999).time()),5,15);
            }
            $data=[
                "guid"=>$UserInfo["id"],     //github返回id
                "avatar_url"=>$UserInfo["avatar_url"],
                "github_url"=>$UserInfo["html_url"],
                "github_username"=>$UserInfo["name"],
                "github_email"=>$UserInfo["email"],
                "create_time"=>time()
            ];
            $github=GithubUser::create($data);

            //将用户名和github表id存入主用户表
            $user=User::create(["user_name"=>$UserInfo["name"],"g_id"=>$github["g_id"],"time_create"=>time()])->toArray();
            //将用户信息存入session
            session(["userinfo"=>$user]);
        }else{
            $user=User::where("g_id",$res["g_id"])->first()->toArray();
            //将用户信息存入session
            session(["userinfo"=>$user]);
        }
        return redirect("/");
    }
    /**
     * 根据code 换取 token
     */
    protected function getToken($code){
        $url = 'https://github.com/login/oauth/access_token';

        //post 接口  Guzzle or  curl
        $client = new Client();
        $response = $client->request('POST',$url,[
            'form_params'   => [
                'client_id'         => env('OAUTH_GITHUB_ID'),
                'client_secret'     => env('OAUTH_GITHUB_SEC'),
                'code'              => $code
            ]
        ]);
        //将查询到的字符串解析到变量中
        parse_str($response->getBody(),$str);
        return $str['access_token'];
    }
    /**
     * 获取github个人信息
     */
    public function githubUserInfo($token){
        $url = 'https://api.github.com/user';
        //请求接口
        $client = new Client();
        $response = $client->request('GET',$url,[
            'headers'   => [
                'Authorization' => "token $token"
            ]
        ]);
        return json_decode($response->getBody(),true);
    }

    /**
     * 注册
     */
    public function register(){
        return view("login.register");
    }

    /**
     * 执行注册
     */
    public function reg(){
        //表单验证
        request()->validate([
            'user_name' => 'bail|required|unique:user|regex:/^[a-zA-Z0-9_-]{4,16}$/',
            'user_email' => 'bail|required|regex:/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/',
            'user_pwd' => 'bail|required|regex:/^[0-9A-Za-z]{8,16}$/',
            'password' => 'bail|required|same:user_pwd',
            'user_phone' => 'bail|required|regex:/^1[3-578]\d{9}$/',
        ],[
            "user_name.required"=>"用户名不可为空",
            "user_name.unique"=>"用户名已存在",
            "user_name.regex"=>"用户名必须由4到16位（字母，数字，下划线，减号）",
            "user_email.required"=>"邮箱不可为空",
            "user_email.regex"=>"邮箱格式不正确",
            "user_pwd.required"=>"密码不可为空",
            "user_pwd.regex"=>"密码必须由8-16位数字或这字母组成",
            "password.required"=>"确认密码不可为空",
            "password.same"=>"确认密码必须和密码一致",
            "user_phone.required"=>"手机号不可为空",
            "user_phone.regex"=>"手机号格式不正确",

        ]);
        $data=request()->except("_token","code","password");
        $code=request()->post("code");
        //获取redis中该uuid的验证码
        $uuid=$_COOKIE["uuid"];
        $codeRedis=Redis::get($uuid);
        //不存在失效
        if(empty($codeRedis)){
            return redirect("/register")->with("msg","验证码错误或已失效");
        }
        //判断验证码是否正确
        if($codeRedis!=$code){
            return redirect("/register")->with("msg","验证码错误或已失效");
        }
        //添加用户数据
        $data["time_create"]=time();
        //密码加密
        $data["user_pwd"]=password_hash($data["user_pwd"],PASSWORD_DEFAULT);
        $res=User::create($data);
        if($res){
            session(["userinfo"=>$res]);
            return redirect("/");
        }else{
            return redirect("/register");
        }

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
        $uuid=$_COOKIE["uuid"];
        Redis::set($uuid,$code);
        Redis::expire($uuid,300);
        //调用短信发送验证码方法
        $res=$this->message($phone,$code);
        $text=json_encode($res);
        //将短信返回数据写到文件
        file_put_contents(storage_path("/logs/message.log"),$text);
        //判断是否发送成功
        if($res["Message"]!="OK"){
            return $this->returnArr(0,"发送失败");
        }
        return $this->returnArr(1,"发送成功");
    }
    /**
     * 验证验证码
     */
    public function code(){
        $code=request()->code;
        //获取redis中该uuid的验证码
        $uuid=$_COOKIE["uuid"];
        $codeRedis=Redis::get($uuid);
        //判断是否存在
        if($codeRedis){
            //判断是否正确
            if($codeRedis==$code){
                return $this->returnArr(1,"ok");
            }
        }
        return $this->returnArr(0,"验证码错误或已失效");
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

        AlibabaCloud::accessKeyClient('LTAI4FtjShQ7uxBcxCRGZmN9', 'jwYGmfLavtAL7RBCyntGcztfcmHzZa')
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
                        'SignName' => "佳璇便利",
                        'TemplateCode' => "SMS_183241729",
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
    /**
     * 忘记密码
     */
    public function forgot(){
        return view("login.forgot");
    }
    /**
     * 修改密码
     */
    public function forgotDo(){
        //表单验证
        request()->validate([
            'user_pwd' => 'bail|required|regex:/^[0-9A-Za-z]{8,16}$/',
            'password' => 'bail|required|same:user_pwd',
            'user_phone' => 'bail|required|regex:/^1[3-578]\d{9}$/',
        ],[
            "user_pwd.required"=>"密码不可为空",
            "user_pwd.regex"=>"密码必须由8-16位数字或这字母组成",
            "password.required"=>"确认密码不可为空",
            "password.same"=>"确认密码必须和密码一致",
            "user_phone.required"=>"手机号不可为空",
            "user_phone.regex"=>"手机号格式不正确",
        ]);
        $data=request()->except("_token");
        //获取redis中该uuid的验证码
        $uuid=$_COOKIE["uuid"];
        $codeRedis=Redis::get($uuid);
        //不存在失效
        if(empty($codeRedis)){
            return redirect("/register")->with("msg","验证码错误或已失效");
        }
        //判断验证码是否正确
        if($codeRedis!=$data["code"]){
            return redirect("/register")->with("msg","验证码错误或已失效");
        }
        //密码加密
        $pwd=password_hash($data["user_pwd"],PASSWORD_DEFAULT);
        $res=User::where("user_phone",$data["user_phone"])->update(["user_pwd"=>$pwd]);
        if($res){
            return redirect("/login");
        }else{
            return redirect("/forgot")->with("msg","修改失败");
        }
    }
}
