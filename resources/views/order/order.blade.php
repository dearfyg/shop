@extends("layouts.layout")
@section("title","订单列表")
@section("content")
<!-- side nav right-->
<div class="side-nav-panel-right">
    <ul id="slide-out-right" class="side-nav side-nav-panel collapsible">
        <li class="profil">
            <img src="/static/index/img/profile.jpg" alt="">
            <h2>John Doe</h2>
        </li>
        <li><a href="setting.html"><i class="fa fa-cog"></i>Settings</a></li>
        <li><a href="about-us.html"><i class="fa fa-user"></i>About Us</a></li>
        <li><a href="contact.html"><i class="fa fa-envelope-o"></i>Contact Us</a></li>
        <li><a href="login.html"><i class="fa fa-sign-in"></i>Login</a></li>
        <li><a href="register.html"><i class="fa fa-user-plus"></i>Register</a></li>
    </ul>
</div>
<!-- end side nav right-->





<!-- checkout -->
<div class="checkout pages section">
    <div class="container">
        <div class="pages-head">
            <h3>收银台</h3>
        </div>
        <div class="checkout-content">
            <div class="row">
                <div class="col s12">
                    <ul class="collapsible" data-collapsible="accordion">
                        <li class="active">
                            <div class="collapsible-header active"><h5>订单详情</h5></div>
                            <div class="collapsible-body">
                                @foreach($goodsInfo as $k=>$v)
                                <div class="order-review order" order_no ="{{$v->order_no}}">
                                    <div class="row">
                                        <div class="col s12">
                                            <div class="divider"></div>
                                            <div class="cart-details">
                                                <div class="col s5">
                                                    <div class="cart-product">
                                                        <h5>商品名称</h5>
                                                    </div>
                                                </div>
                                                <div class="col s7">
                                                    <div class="cart-product">
                                                        {{$v->goods_name}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="divider"></div>
                                                <div class="cart-details">
                                                    <div class="col s5">
                                                        <div class="cart-product">
                                                            <h5>商品图片</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col s7">
                                                        <div class="cart-product">
                                                            <img src="{{env("APP_URL")."/storage/".$v->goods_img}}" width="40" height="20">
                                                        </div>
                                                    </div>
                                            <div class="divider"></div>
                                            <div class="cart-details">
                                                <div class="col s5">
                                                    <div class="cart-product">
                                                        <h5>购买数量</h5>
                                                    </div>
                                                </div>
                                                <div class="col s7">
                                                    <div class="cart-product">
                                                        {{$v->buy_num}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="divider"></div>
                                            <div class="cart-details">
                                                <div class="col s5">
                                                    <div class="cart-product">
                                                        <h5>商品单价</h5>
                                                    </div>
                                                </div>
                                                <div class="col s7">
                                                    <div class="cart-product">
                                                        <span>${{$v->goods_price}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cart-details">
                                                <div class="col s5">
                                                    <div class="cart-product">
                                                        <h5>总价</h5>
                                                    </div>
                                                </div>
                                                <div class="col s7">
                                                    <div class="cart-product">
                                                        <span>${{$v->goods_price*$v->buy_num}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <hr/>
                                @endforeach
                                <div class="order-review final-price">
                                    <div class="row">
                                        <div class="col s12">
                                            <div class="cart-details">
                                                <div class="col s8">
                                                    <div class="cart-product">
                                                        <h5>合计</h5>
                                                    </div>
                                                </div>
                                                <div class="col s4">
                                                    <div class="cart-product">
                                                        <span id="sum">${{$sum}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="javascript:;" class="btn button-default button-fullwidth pay" >去支付</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end checkout -->
<script>
    $(".pay").click(function(){
        var order_no = $(".order").attr("order_no");
        location.href = "/order/pay?order_no="+order_no;
    })
</script>
@endsection
