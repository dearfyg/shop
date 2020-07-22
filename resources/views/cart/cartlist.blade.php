@extends("layouts.layout")
@section("content")
    <div class="cart section">
        <div class="container">
            <div class="pages-head">
                <h3>CART</h3>
            </div>

            @foreach($cartInfo as $k=>$v)
            <div class="content" >
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
                        <div class="col s7 goods"   user_id="{{$v->user_id}}">
                            <input class="buy_num" value="{{$v->buy_num}}" type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s5">
                            <h5>Price</h5>
                        </div>
                        <div class="col s7">
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
        //点击生成订单
        $("document").ready(function(){
            var user_id=$(".goods").attr("user_id")
            $.get(
                "/cart/gopay",
                {user_id:user_id},
                function(res){
                   $("#total").text('￥'+res)
                }
            )
        })
       $("#gopay").click(function(){
           window.location.href="/order/order/1";
       })
    </script>


@endsection
