@extends("layouts.layout")
@section("title","支付成功")
@section("content")

    <!-- checkout -->

    <div class="checkout pages section">
        <div class="container">
            <div class="pages-head">
                <h1> 支付成功</h1>
            </div>
        </div>
    </div>

    <div class="checkout pages section">
        <div class="container">
            <div class="pages-head">
                <h2> 您的外部订单号为:{{$order["trade_no"]}}</h2>
            </div>
        </div>
    </div>

    <div class="checkout pages section">
        <div class="container">
            <div class="pages-head">
                <h3> 您的支付时间为:{{$order["timestamp"]}}</h3>
            </div>
        </div>
    </div>

    <div class="checkout pages section">
        <div class="container">
            <div class="pages-head">
                <h3>祝您本次购物愉快</h3>
            </div>
        </div>
    </div>
    <!-- end checkout -->


@endsection