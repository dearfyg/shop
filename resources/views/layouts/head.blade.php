<!-- navbar top -->
<div class="navbar-top">
    <!-- site brand	 -->
    <div class="site-brand">
        <a href="index.html"><h1>Mstore</h1></a>
    </div>
    <div class="site-brand">
        <a href="{{url('sign')}}"><h1>签到</h1></a>
    </div>
    <!-- end site brand	 -->
    <div class="side-nav-panel-right">
        <a href="#" data-activates="slide-out-right" class="side-nav-left"><i class="fa fa-user"></i></a>
    </div>
</div>
<!-- end navbar top -->
<!-- side nav right-->
<div class="side-nav-panel-right">
    <ul id="slide-out-right" class="side-nav side-nav-panel collapsible">
        <li class="profil">
            <img src="{{env("APP_URL")}}/static/index/img/tou.jpeg" alt="">
            <h2>{{session("userinfo.user_name")}}</h2>
        </li>
        <li><a href="setting.html"><i class="fa fa-cog"></i>Settings</a></li>

        @if($_SERVER["is_login"]==1)
        <li><a href="/center"><i class="fa fa-user"></i>Personal Center</a></li>
        @endif
        <li><a href="contact.html"><i class="fa fa-envelope-o"></i>Contact Us</a></li>
        @if($_SERVER["is_login"]==0)
        <li>
            <a href="{{env('PASS_PORT')."/web/login".'?return_url='.env("APP_URL").$_SERVER['REQUEST_URI']}}">
            <i class="fa fa-sign-in">
            </i>
            Login
            </a>
        </li>
        @else
        <li><a href="{{env('PASS_PORT')."/web/quit".'?return_url='.env("APP_URL").$_SERVER['REQUEST_URI']}}"><i class="fa fa-sign-in"></i>Quit</a></li>
        @endif
        <li><a href="{{env('PASS_PORT')."/web/register".'?return_url='.env("APP_URL").$_SERVER['REQUEST_URI']}}"><i class="fa fa-user-plus"></i>Register</a></li>
    </ul>
</div>
<!-- end side nav right-->
