@extends("layouts.layout")
@section("title","订单列表")
@section("content")
    <center><font color="red" size="20">{{session("msg")}}</font></center>
    <div class="cart section">
        <div class="container">
            <div class="pages-head">
                <h3>CART</h3>
            </div>


            <div class="content" >
                @foreach($cartInfo as $k=>$v)
                <div class="cart-1 order" id="Dbox" goods_id="{{$v["goods_id"]}}" buy_num="{{$v["num"]}}">
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
                            <h5><a href="">{{$v['goods_name']}}</a></h5>
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
                    <div class="row" id="aaa">
                        <div class="col s5">
                            <h5>Quantity</h5>
                        </div>
                        <div class="col s7 goods"  price="{{$v['goods_price']}}"  goods_id="{{$v['goods_id']}}">
                            <input class="buy_num"  value="{{$v['num']}}" type="text">
                        </div>
                    </div>

                    <div class="row" id="bbb">
                        <div class="col s5">
                            <h5>SubTotal</h5>
                        </div>
                        <div class="col s7" >
                            <h5 class="price">￥{{$v['goods_price']*$v['num']}}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s5">
                            <h5>Action</h5>
                        </div>
                        <div class="col s7" goods_id="{{$v['goods_id']}}">
                            <h5><i class="fa fa-trash del"></i></h5>
                        </div>
                    </div>
                </div>
                <div class="divider" id="Dbox1"></div>
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
//                    alert(res)
                    }
                )
            }
            //点击跳转支付
            $("#gopay").click(function(){
                //空字符串
                var str = "";
                //获取对象
                $(".order").each(function(){
                    str += $(this).attr("goods_id")+",";
                })
                console.log(str);
                var goods_id = str.substring(0,str.length-1);
                //空字符串
                var string = "";
                $(".order").each(function(){
                    string += $(this).attr("buy_num")+",";
                })
                console.log(string);
                var buy_num = string.substring(0,string.length-1);
                //跳转
                location.href = "/order/order?goods_id="+goods_id+"&buy_num="+buy_num;
            })
            //更改数量后重新获取
            $(".buy_num").blur(function(){
                var buy_num=$(this).val()
                var goods_id=$(this).parent().attr("goods_id")
                var price=$(this).parent().attr("price")
                var _this=$(this)
                $.get(
                    "/cart/subtotal",
                    {price:price,buy_num:buy_num,goods_id:goods_id},
                    function(res){
                        _this.parents("#aaa").next().find(".price").text('￥'+res)
                        getTotal()
                        window.location.reload()
                    }
                )
            })
            //删除商品
            $(".del").click(function(){
                var goods_id=$(this).parents("div").attr("goods_id")
                myConfirm("系统确认框","是否删除该商品",function(r){
                    if(r){
                    var _this=$(this)
                        $.get(
                            "/cart/del",
                            {goods_id:goods_id},
                            function(res){
                                _this.parents("#Dbox").attr("style","display:none;")
                                _this.parents("#Dbox").next("#Dbox1").attr("style","display:none;")
                                getTotal()
                                window.location.reload()
                            }
                        )
                    }
                })
            })
        })

    </script>


@endsection
