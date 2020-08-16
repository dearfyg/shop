@extends("layouts.layout")
@section("title","首页")
@section("content")

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

<!-- slider -->
<div class="slider">

    <ul class="slides">
        @foreach($img as $i)
        <li>
            <img src="{{env("APP_URL")}}{{"/storage/".$i->goods_img}}" alt="">
            <div class="caption slider-content  center-align">
                <h2>{{$i->goods_name}}</h2>
                <h4>{{$i->goods_desc}}</h4>
                <a goods_id="{{$i->goods_id}}" href="javascript:;" class="btn button-default gocart">SHOP NOW</a>
            </div>
        </li>
        @endforeach
    </ul>

</div>
<!-- end slider -->

<!-- features -->
<div class="features section">
    <div class="container">
        <div class="row">
            <div class="col s6">
                <div class="content">
                    <div class="icon">
                        <i class="fa fa-car"></i>
                    </div>
                    <h6>Free Shipping</h6>
                    <p>Lorem ipsum dolor sit amet consectetur</p>
                </div>
            </div>
            <div class="col s6">
                <div class="content">
                    <div class="icon">
                        <i class="fa fa-dollar"></i>
                    </div>
                    <h6>Money Back</h6>
                    <p>Lorem ipsum dolor sit amet consectetur</p>
                </div>
            </div>
        </div>
        <div class="row margin-bottom-0">
            <div class="col s6">
                <div class="content">
                    <div class="icon">
                        <i class="fa fa-lock"></i>
                    </div>
                    <h6>Secure Payment</h6>
                    <p>Lorem ipsum dolor sit amet consectetur</p>
                </div>
            </div>
            <div class="col s6">
                <div class="content">
                    <div class="icon">
                        <i class="fa fa-support"></i>
                    </div>
                    <h6>24/7 Support</h6>
                    <p>Lorem ipsum dolor sit amet consectetur</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end features -->

<!-- quote -->
<div class="section quote">
    <div class="container">
        <h4>FASHION UP TO 50% OFF</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid ducimus illo hic iure eveniet</p>
    </div>
</div>
<!-- end quote -->

<!-- product -->
<div class="section product">
    <div class="container">
        <div class="section-head">
            <h4>NEW PRODUCT</h4>
            <div class="divider-top"></div>
            <div class="divider-bottom"></div>
        </div>
        <div class="row">
            @foreach($new as $n)
            <div class="col s6">
                <div class="content">
                    <img src="{{env("APP_URL")}}{{"/storage/".$n["goods_img"]}}" height = "30px" width="50px">
                    <h6><a href="{{url('/goods/detail?goods_id=').$n->goods_id}}">{{$n->goods_name}}</a></h6>
                    <div class="price">
                        ${{$n->goods_price}}
                    </div>
                    <a class="btn button-default gocart" goods_id="{{$n->goods_id}}" href="javascript:;">ADD TO CART</a>
                    <a class="btn button-default" href="{{url('/goods/rob?goods_id=').$n->goods_id}}">抢购</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- end product -->

<!-- promo -->
<div class="promo section">
    <div class="container">
        <div class="content">
            <h4>PRODUCT BUNDLE</h4>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
            <button class="btn button-default">SHOP NOW</button>
        </div>
    </div>
</div>
<!-- end promo -->

<!-- product -->
<div class="section product">
    <div class="container">
        <div class="section-head">
            <h4>TOP PRODUCT</h4>
            <div class="divider-top"></div>
            <div class="divider-bottom"></div>
        </div>

        <div class="pagination-product">
        </div>
    </div>
</div>
<!-- end product -->

<!-- loader -->
<div id="fakeLoader"></div>
<!-- end loader -->

<!-- footer -->

<!-- end footer -->

<!-- scripts -->
<script src="/static/index/js/cart.js"></script>
@endsection