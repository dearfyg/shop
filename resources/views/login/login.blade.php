
@extends("layouts.layout")
@section("title","登录页面")
@section("content")
<!-- login -->
<div class="pages section" xmlns="http://www.w3.org/1999/html">
    <div class="container">
        <div class="pages-head">
            <h3>LOGIN</h3>
        </div>
        <div class="login">
            <div class="row">
                <form class="col s12" action="{{url('/loginDo')}}" method="post">
                    @csrf
                    <div class="input-field">
                        <input type="text" id="user" name="user" class="validate" placeholder="USERNAME PHONE EMAIL" required>
                        <span style="color:red" >{{$errors->first("user")}}</span>
                    </div>
                    <div class="input-field">
                        <input type="password" id="pwd" name="user_pwd" class="validate" placeholder="PASSWORD" required>
                        <span style="color:red" >{{$errors->first("user_pwd")}}{{session("msg")}}</span>
                    </div>
                        <a href="/forgot"><h6>Forgot Password ?</h6></a>
                        <a href="{{url('/register')}}"><h6>Register</h6></a>
                        <input class="btn button-default" type="submit" value="LOGIN">
                    <div class="input-field">
                        <a href="/login/github"><img src="static/index/img/github.jpg" width="25" alt=""></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end login -->

<!-- loader -->
<div id="fakeLoader"></div>
<!-- end loader -->
<script>
    //阻止表单提交
    var flag1=false
    var flag2=false
    //判断用户名是否为空
    $("#user").blur(function () {
        flag1=false
        var user = $(this).val()
        //判断不可为空
        if(!user){
            $(this).next().html("用户名手机号或邮箱不可为空")
            return false
        }
        $(this).next().html("")
        flag1=true
    })
    //判断密码是否为空
    $("#pwd").blur(function () {
        flag2=false
        var pwd = $(this).val()
        //判断不可为空
        if(!pwd){
            $(this).next().html("密码不可为空")
            return false
        }
        $(this).next().html("")
        flag2=true
    })
    //验证表单是否可以提交
    $("form").submit(function (event) {
        // 终止默认事件的传递
        if(flag1==false || flag2==false){
            event.preventDefault()
        }else{

        }
    })
</script>
@endsection

