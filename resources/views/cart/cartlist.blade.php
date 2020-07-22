@extends("layouts.layout")
@section("content")
    <div class="cart section">
        <div class="container">
            <div class="pages-head">
                <h3>CART</h3>
            </div>


            <div class="content" >
                @foreach($cartInfo as $k=>$v)
                <div class="cart-1">
                    <div class="row">
                        <input type="checkbox" class="box">
                        <div class="col s5">
                            <h5>Image</h5>
                        </div>
                        <div class="col s7">
                            <img src="" alt="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s5">
                            <h5>Name</h5>
                        </div>
                        <div class="col s7">
                            <h5><a href="">{{$v->goods_name}}</a></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s5">
                            <h5>Quantity</h5>
                        </div>
                        <div class="col s7 goods"   user_id="{{$v->user_id}}" goods_id="{{$v->goods_id}}">
                            <input class="buy_num" value="{{$v->buy_num}}" type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s5">
                            <h5>Price</h5>
                        </div>
                        <div class="col s7" price="{{$v->goods_price}}">
                            <h5 class="price">￥{{$v->goods_price}}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s5">
                            <h5>Action</h5>
                        </div>
                        <div class="col s7">
                            <h5><i class="fa fa-trash"></i></h5>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
                @endforeach



            </div>
            <div class="total">

                <div class="row">
                    <div class="col s7">
                        <h6>总计</h6>
                    </div>
                    <div class="col s5">
                        <h6 id="total"></h6>
                    </div>
                </div>
            </div>
            <button class="btn button-default" id="gopay">Process to Checkout</button>
        </div>
    </div>
    <script src="/static/index/js/jquery.min.js"></script>
    <script>
        //进入页面获取总价
        $("document").ready(function(){
            getTotal()
            function getTotal() {
                var user_id = $(".goods").attr("user_id")
                $.get(
                    "/cart/gopay",
                    {user_id: user_id},
                    function (res) {
                        $("#total").text('￥' + res)
                    }
                )
            }
            //点击跳转支付
            $("#gopay").click(function(){
                window.location.href="/order/order/1";
            })
            //更改数量后重新获取
            $(".buy_num").blur(function(){
                var buy_num=$(this).val()
                var goods_id=$(this).parent().attr("goods_id")
                $.get(
                    "/cart/subtotal",
                    {buy_num:buy_num,goods_id:goods_id},
                    function(res){
                        $(".price").text('￥'+res)
                        getTotal()
                    }
                )
            })
        })

    </script>


@endsection
