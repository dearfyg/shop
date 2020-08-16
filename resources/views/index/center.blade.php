<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="http://www.yingmoo.com/img/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/static/index/css/common.css" />
    <link rel="stylesheet" href="/static/index/css/shopsManager.css" />
    <script type="text/javascript" src="/static/index/js/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="/static/index/js/common.js" ></script>
    <script type="text/javascript" src="/static/index/js/navTop.js"></script>
    <script type="text/javascript" src="/static/index/js/jquery.circliful.min.js"></script>
    <title>店铺管理中心</title>
</head>

<body>
<!--[if lte IE 7]>
<div class="old-browser-popup" id="old" >
    亲，您当前正在使用旧版本的IE浏览器，为了保证您的浏览体验，鹰目建议您使用：
    <label class="chrome-borwser-ico"></label>
    <a href="http://rj.baidu.com/soft/detail/14744.html?ald" target="_blank">谷歌浏览器</a>&nbsp;或&nbsp;&nbsp;
    <label class="firefox-borwser-ico"></label>
    <a href="http://rj.baidu.com/soft/detail/11843.html?ald" target="_blank">火狐浏览器</a>
    <span id="oldclose"></span>
</div>
<![endif]-->
<!--头部  开始-->
<div class="top" style="position: relative; top: 0px; z-index: 999999;">
    <div class="c100">
        <div class="link_01">

        </div>
        <div class="top_mem top_nm">
            <div class="loginup">
                <ul>
                    <li class="login_txt">
                        <input type="hidden" id="ymMemLoginID" value="" />

                        <a target="_self" rel="nofollow" href="javascript:;" title="欢迎您来闪电组">欢迎您来闪电组，尊贵的<font style="color:#ff6561;">{{$userinfo['user_name']}}</font></a>
                        <span class="midActive">
									<a  href="/" title="首页">首页</a>
									<a  href="javascript:;" title="这里就是，别点了">个人中心</a>
								</span>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>
<!-- 头部  结束-->

<!-- 会员公共头部  开始-->
<div class="shop_wrap">
    <div class="c100 nav_wrap">
        <div class="fl shop_logo">
            <img src="/static/index/img/sd.jpg" width="50"  height="50"/>
            <a href="/" title="主站" class="midMag">主站</a>
        </div>
        <div class="fl nav act_nav">
            <ul>
                <li class="index-page-link hide"><a href="#" class="on">个人中心</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- 会员公共头部  结束-->

<!-- 内容  开始-->
<div class="wrap">
    <div class="vip_cont c100 clearfix">
        <!--左边列表导航  开始-->
        <div class="fl vip_left vip_magLeft">
            <dl>
                <dt>查看</dt>
                <dd>
                    <p><a  target="_blank">我的信息</a></p>
                    <p><a href="/center/reviews" >我的评论</a></p>
                    <p><a href="/wish" >我的收藏</a></p>
                    <p><a href="/cartlist" >购物车</a></p>
                    <p><a href="/prize/prize" >抽奖</a></p>
                </dd>

        </div>
        <!--左边列表导航  结束-->

        <!--右边列表内容  开始-->
        <div class="fr vip_right vip_magRight">
            <!--用户信息  开始 -->
            <div class="cus01">
                <div class="cusImg">

                </div>
                <div class="cusName">
                   <h3>用户信息</h3>
                    <span title="闪电组">用户名称：{{$userinfo['user_name']}}</span>
                    <span title="闪电组">手机号绑定：{{$userinfo['user_phone']}}</span>
                    <span title="我是闪电">邮箱绑定：{{$userinfo['user_email']}}</span>
                </div>
            </div>


        </div>
        <!--右边列表内容  结束-->
    </div>
</div>

<!-- 内容  结束-->



</body>

</html>