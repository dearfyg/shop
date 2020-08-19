@extends("layouts.layout")
@section('title', '产品详情')
@section('content')
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="IE=edge" >
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no"/>
        <title>Aliplayer Online Settings</title>
        <link rel="stylesheet" href="https://g.alicdn.com/de/prismplayer/2.8.8/skins/default/aliplayer-min.css" />
        <script type="text/javascript" charset="utf-8" src="https://g.alicdn.com/de/prismplayer/2.8.8/aliplayer-min.js"></script>
    </head>
<!-- navbar top -->

<!-- end navbar top -->

<!-- side nav right-->

<!-- end side nav right-->

<!-- navbar bottom -->

<!-- end navbar bottom -->

<!-- menu -->

<!-- end menu -->

<!-- cart menu -->

<!-- end cart menu -->

<!-- shop single -->


<div class="pages section">
    <div class="container">
        <div class="shop-single">

            <img src="{{env("APP_URL")}}{{"/storage/".$data["goods_img"]}}" alt="">
            <h5>{{$data["goods_name"]}}</h5>
            <div class="price">${{$data["goods_price"]}} <p>积分:<span>{{$data["goods_score"]}}</span></p></div>
            <p>{{$data["goods_desc"]}}</p>
            <h2> 该商品浏览量为<font color="red" size="18">{{$sum}}</font></h2>
            <a type="button" class="btn button-default gocart"  goods_id="{{$data['goods_id']}}" href="javascript:;">加入购物车</a>
            <a type="button" class="btn button-default" id="gowish"  goods_id="{{$data['goods_id']}}" href="javascript:;">收藏</a>
        </div>
        <div class="prism-player" id="player-con"></div>
        <script>
            var player = new Aliplayer({
                    "id": "player-con",
                    "source": "{{$video}}",
                    "width": "20%",
                    "height": "300px",
                    "autoplay": true,
                    "isLive": false,
                    "rePlay": false,
                    "playsinline": true,
                    "preload": true,
                    "controlBarVisibility": "hover",
                    "useH5Prism": true
                }, function (player) {
                    console.log("The player is created");
                }
            );
        </script>


        </div>
        <div  class="prism-player" id="J_prismPlayer"></div>



        <div class="review">
            <h5>{{count($reviews)}} reviews</h5>
            <div class="review-details">
                <div class="row">

                    @foreach($reviews as $v)
                    <div class="col s9">
                        <div class="review-title">
                            <p>
                            <span><strong>{{$v['user_id']}}</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{date('Y-m-d H:i:s',$v['reviews_time'])}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="">Reply</a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <i class="fa fa-trash del" reviews_id="{{$v['reviews_id']}}"></i>
                            </p>
                        </div>
                        <p>{{$v['content']}}</p>
                    </div>
                        @endforeach
                </div>
            </div>
        </div>
        <div class="review-form">
            <div class="review-head">
                <h5>Post Review in Below</h5>
                <p>Lorem ipsum dolor sit amet consectetur*</p>
            </div>
            <div class="row">
                <form  method="post" class="col s12 form-details">
                    <div class="input-field">
                        <textarea name="textarea-message" id="textarea1" cols="30" rows="10" class="materialize-textarea" class="validate" placeholder="YOUR REVIEW"></textarea>
                    </div>
                    <div class="form-button">
                        <div class="btn button-default" goods_id="{{$data['goods_id']}}" id="reviews">POST REVIEW</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end shop single -->

<!-- loader -->
<div id="fakeLoader"></div>
<!-- end loader -->

<!-- footer -->

<!-- end footer -->

<!-- scripts -->
<script src="/static/index/js/cart.js"></script>
    <script>
        //点击评论
        $("#reviews").click(function(){
            var content =$("#textarea1").val();
            var goods_id= $(this).attr("goods_id");
            if(content==''){
                myAlert("系统通知","评论不能为空",function () {

                })
            }
            $.post(
                "/goods/reviews",
                {content:content,goods_id:goods_id},
                function(res){
                    if(res.code==000000){
                        myAlert("系统通知",res.msg,function () {
                            window.location.reload()
                        });
                    }else if(res.code==100006){
                        myAlert("系统通知",res.msg,function () {

                        });
                        location.href="/login"
                    }
                }
            )
        })
        //点击删除评论
        $(".del").click(function(){
            if(window.confirm("是否确认删除该评论")){
                var reviews_id=$(this).attr("reviews_id")//获取评论id
                $.get(
                    "/reviews/del",
                    {reviews_id:reviews_id},
                    function(res){
                        if(res.code==000000){
                            myAlert("系统通知",res.msg,function () {
                                
                            })
                            window.location.reload();
                        }else{
                            myAlert("系统通知",res.msg,function () {
                                
                            })
                        }
                    }
                )
            }else{
                alert("不要瞎点!")
            }
        })
        $("#gowish").click(function(){
            var goods_id=$(this).attr("goods_id")
            $.get(
                "/wish/add",
                {goods_id:goods_id},
                function(res){
                    myAlert("系统通知",res.msg,function(){

                    })
                }
            )
        })
    </script>

@endsection