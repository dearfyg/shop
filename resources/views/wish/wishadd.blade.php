@extends("layouts.layout")
@section("title","订单列表")
@section("content")
    <center><font color="red" size="20">{{session("msg")}}</font></center>
    <div class="cart section">
        <div class="container">
            <div class="content" >
                @foreach($wish as $v)
                    <div class="cart-1 order" id="Dbox">
                        <div class="row">
                            <div class="col s5">
                                <h5>Image</h5>
                            </div>
                            <div class="col s7">
                                <img src="{{env("APP_URL")}}{{"/storage/".$v["goods_img"]}}" alt="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s5">
                                <h5>Name</h5>
                            </div>
                            <div class="col s7">
                                <h5><a href="/goods/detail?goods={{$v['goods_id']}}">{{$v['goods_name']}}</a></h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s5">
                                <h5>Price</h5>
                            </div>
                            <div class="col s7">
                                <h5>￥{{$v['goods_price']}}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s5">
                                <h5>Action</h5>
                            </div>
                            <div class="col s7">
                                <h5><i class="fa fa-trash del" goods_id="{{$v['goods_id']}}"></i></h5>
                            </div>
                        </div>
                        <button class="btn button-default gocart" goods_id="{{$v['goods_id']}}">Add to Cart</button>
                    </div>
                    <div class="divider" id="Dbox1"></div>
                @endforeach

            </div>
        </div>
    </div>

    <script src="{{env("APP_URL")}}/static/index/js/cart.js"></script>
    <script>
        //删除收藏商品
        $(".del").click(function(){
            var goods_id=$(this).attr("goods_id")
            $.get(
                "/wish/del",
                {goods_id:goods_id},
                function(res){
                    myAlert("系统通知",res.msg,function () {
                        window.location.reload()
                    })

                }
            )
        })
    </script>
@endsection
