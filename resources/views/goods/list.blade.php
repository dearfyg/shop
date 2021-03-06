@extends('layouts.layout')
@section('title', '产品列表')
@section('content')

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

<!-- product -->
<div class="section product product-list">
    <center><h1>商品浏览量排行榜</h1></center>
    @foreach($rr as $kk=>$vv)
        <center>
            <ul>
                <li>商品名称：{{$vv["goods_name"]}}</li>
                <li> 浏览次数：{{$vv["score"]}}</li>
            </ul>
        </center>
    @endforeach




    <div class="container">
        <div class="pages-head">
            <h3>PRODUCT LIST</h3>
        </div>
        <div class="input-field">
            <select>
                <option value="">请选择</option>
                <option value="1">新品</option>
                {{--<option value="2">Best Sellers</option>--}}
                {{--<option value="3">Best Reviews</option>--}}
                {{--<option value="4">Low Price</option>--}}
                {{--<option value="5">High Price</option>--}}
            </select>
        </div>
        <div class="row">
            @foreach($data as $v)
                <div class="col s6">
                    <div class="content">
                        <img src="{{env("APP_URL")}}{{"/storage/".$v["goods_img"]}}" alt="">
                        <h6><a href="{{'/goods/detail?goods_id='.$v["goods_id"]}}">{{$v["goods_name"]}}</a></h6>
                        <div class="price">
                            {{$v["goods_price"]}}
                            <p>积分:<span>{{$v["goods_score"]}}</span></p>
                        </div>
                        <a class="btn button-default gocart"  goods_id="{{$v['goods_id']}}" href="javascript:;">加入购物车</a>

                    </div>
                </div>
            @endforeach

        </div>

        <div class="pagination-product">
            <ul>
                {{$link->links()}}
                {{--<li class="active">1</li>--}}
                {{--<li><a href="">2</a></li>--}}
                {{--<li><a href="">3</a></li>--}}
                {{--<li><a href="">4</a></li>--}}
                {{--<li><a href="">5</a></li>--}}
            </ul>
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
