@extends("layouts.layout")
@section("title","注册")
@section("content")
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- register -->
    <div class="pages section">
        <div class="container">
            <div class="pages-head">
                <h3>REGISTER</h3>
            </div>
            <div class="register">
                <div class="row">
                    <form class="col s12">
                        <div class="input-field">
                            <input type="text" id="name" class="validate" placeholder="NAME" required>
                            <span></span>
                        </div>
                        <div class="input-field">
                            <input type="email" id="email" placeholder="EMAIL" class="validate" required>
                            <span></span>
                        </div>
                        <div class="input-field">
                            <input type="password" id="pwd" placeholder="PASSWORD" class="validate" required>
                            <span></span>
                        </div>
                        <div class="input-field">
                            <input type="password" id="password" placeholder="CONFIRM PASSWORD" class="validate" required>
                            <span></span>
                        </div>
                        <div class="input-field">
                            <input type="text" id="phone" placeholder="CELL-PHONE NUMBER" class="validate" required>
                            <button class="btn button-default gain" id="gain">GET CODE</button>
                            <span id="phoneSpan"></span>
                        </div>
                        <div class="input-field">
                            <input type="text" placeholder="AUTH CODE" class="validate" required>
                        </div>
                        <center>
                            <div class="btn button-default">REGISTER</div>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end register -->


    <!-- loader -->
    <div id="fakeLoader"></div>
    <!-- end loader -->
    <script>
        var flag=false
        //发送验证码
        $("#gain").click(function () {
            var phone=$("#phone").val();
            $.ajax({
                type:"post",
                url:"/reg/gain",
                data:{phone:phone},
//                dataType:"json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res){
                    if(res.error==0){
                        $("#phoneSpan").html("<font color=red>"+res.msg+"</font>")
                        return false
                    }
                    $("#phoneSpan").html("<font color=green>"+res.msg+"</font>")
                }
            })
            //将按钮改为秒数
            $("#gain").text("5s");
            $("button").attr("disabled","true");
            //设置每秒提示
            times=setInterval(gotime,1000)
        })
        //每秒提示方法
        function gotime(){
            //获取按钮文本
            var s=$("#gain").text();
            //获取整型
            s=parseInt(s);
            if(s>0){
                s=s-1;
                //设置按钮文本
                $("#gain").text(s+"s");
                //将按钮改为不可点击
                $("button").attr("disabled","true");
            }else{
                //清楚每秒显示
                clearInterval(times);
                //设置按钮文本
                $("#gain").text("获取");
                //将按钮改为可点击
                $("button").removeAttr("disabled");
            }
        }
        //验证用户名
        $("#name").blur(function () {
            var name=$(this).val()
            //判断不可为空
            if(!name){
                $(this).next().html("<font color=red>用户名不可为空</font>")
                return false
            }
            //验证正则
            var reg=/^[a-zA-Z0-9_-]{4,16}$/
            if(!reg.test(name)){
                $(this).next().html("<font color=red>必须由4到16位（字母，数字，下划线，减号）</font>")
                return false
            }
            //验证是否已存在
            $.ajax({
                type:"post",
                url:"/reg/name",
                data:{name:name},
//                dataType:"json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res){
                    if(res.error == 0){
                        $("#name").next().html("<font color=red>"+res.msg+"</font>")
                        return false
                    }
                    $("#name").next().html("")
                }
            })
        })
        //验证邮箱
        $("#email").blur(function () {
            var email=$(this).val()
            //判断不可为空
            if(!email){
                $(this).next().html("<font color=red>邮箱不可为空</font>")
                return false
            }
            //验证正则
            var reg=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/
            if(!reg.test(email)){
                $(this).next().html("<font color=red>邮箱格式不正确</font>")
                return false
            }
            $(this).next().html("")
        })
        //验证密码
        $("#pwd").blur(function () {
            var pwd=$(this).val()
            //判断不可为空
            if(!pwd){
                $(this).next().html("<font color=red>密码不可为空</font>")
                return false
            }
            //验证正则
            var reg= /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[^]{8,16}$/
            if(!reg.test(pwd)){
                $(this).next().html("<font color=red>密码必须由至少8-16个字符，至少1个大写字母，1个小写字母和1个数字</font>")
                return false
            }
            $(this).next().html("")
        })
        //验证确认密码
        $("#password").blur(function () {
            var pwd=$("#pwd").val()
            var password=$(this).val()
            //判断确认密码是否和密码一致
            if(pwd!=password || password==""){
                $(this).next().html("<font color=red>确认密码和密码不一致</font>")
                return false
            }
            $(this).next().html("")
        })
        //验证手机号
        $("#phone").blur(function () {
            var phone=$(this).val()
            //判断不可为空
            if(!phone){
                $("#phoneSpan").html("<font color=red>手机号不可为空</font>")
                return false
            }
            //验证正则
            var reg= /^1[3-578]\d{9}$/
            if(!reg.test(phone)){
                $("#phoneSpan").html("<font color=red>手机号格式不正确</font>")
                return false
            }
            $("#phoneSpan").html("")
        })
    </script>
@endsection