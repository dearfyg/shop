@extends("layouts.layout")
@section("title","blog列表")
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


<!-- blog -->
<div class="pages section">
    <div class="container">
        <div class="blog">
            @foreach($data as $v)
            <div class="row">
                <div class="col s12">
                    <div class="blog-content">
                        <a href="{{url('/blog/detail?goods_id='.$v->goods_id)}}"><img src="{{env('APP_URL').'/storage/'.$v->goods_img}}" alt=""></a>
                        <div class="blog-detailt">
                            <h5><a href="{{url('/blog/detail?goods_id='.$v->goods_id)}}">{{$v->goods_name}}</a></h5>
                            <div class="date">
                                <span><i class="fa fa-calendar"></i> July 22, 2017</span>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste quasi sit aperiam quia voluptatem odio, facere iusto magni sunt, cumque quae, molestias temporibus ducimus repellendus!</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="row">
                <div class="col s12">
                    <div class="pagination-blog">
                        <ul>
                            {{$data->links()}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end blog -->


<!-- loader -->
<div id="fakeLoader"></div>
<!-- end loader -->

<!-- footer -->

<!-- end footer -->

<!-- scripts -->
@endsection