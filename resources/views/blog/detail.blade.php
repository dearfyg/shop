@extends("layouts.layout")
@section("title","blog详情")
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


<!-- single post -->
<div class="pages section">
    <div class="container">
        <div class="blog-single">
            <img src="{{env('APP_URL').'/storage/'.$data->goods_img}}" alt="">
            <div class="blog-single-content">
                <h5>{{$data->goods_name}}</h5>
                <div class="date">
                    <span><i class="fa fa-calendar"></i>{{$data->created_at}}</span>
                </div>
                <p>{{$data->goods_desc}}</p>

                <div class="share-post">
                    <ul>
                        <li><a href=""><i class="fa fa-facebook"></i></a></li>
                        <li><a href=""><i class="fa fa-twitter"></i></a></li>
                        <li><a href=""><i class="fa fa-google"></i></a></li>
                        <li><a href=""><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="comment">
                <h5>1 Comments</h5>
                <div class="comment-details">
                    <div class="row">
                        <div class="col s3">
                            <img src="img/user-comment.jpg" alt="">
                        </div>
                        <div class="col s9">
                            <div class="comment-title">
                                <span><strong>John Doe</strong> | Juni 5, 2016 at 9:24 am | <a href="">Reply</a></span>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis accusantium corrupti asperiores et praesentium dolore.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="comment-form">
                <div class="comment-head">
                    <h5>Post Comment in Below</h5>
                    <p>Lorem ipsum dolor sit amet consectetur*</p>
                </div>
                <div class="row">
                    <form class="col s12 form-details">
                        <div class="input-field">
                            <input type="text" required class="validate" placeholder="NAME">
                        </div>
                        <div class="input-field">
                            <input type="email" class="validate" placeholder="EMAIL" required>
                        </div>
                        <div class="input-field">
                            <input type="text" class="validate" placeholder="SUBJECT" required>
                        </div>
                        <div class="input-field">
                            <textarea name="textarea-message" id="textarea1" cols="30" rows="10" class="materialize-textarea" class="validate" placeholder="YOUR COMMENT"></textarea>
                        </div>
                        <div class="form-button">
                            <div class="btn button-default">POST COMMENTS</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end single post -->


<!-- loader -->
<div id="fakeLoader"></div>
<!-- end loader -->

<!-- footer -->

<!-- end footer -->

<!-- scripts -->
@endsection