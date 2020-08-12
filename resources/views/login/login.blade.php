@extends("layouts.layout")
@section("title","登录页面")
@section("content")
<!-- login -->
<div class="pages section">
    <div class="container">
        <div class="pages-head">
            <h3>LOGIN</h3>
        </div>
        <div class="login">
            <div class="row">
                <form class="col s12">
                    <div class="input-field">
                        <input type="text" class="validate" placeholder="USERNAME" required>
                    </div>
                    <div class="input-field">
                        <input type="password" class="validate" placeholder="PASSWORD" required>
                    </div>
                    <a href=""><h6>Forgot Password ?</h6></a>
                    <a href="" class="btn button-default">LOGIN</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end login -->

<!-- loader -->
<div id="fakeLoader"></div>
<!-- end loader -->
@endsection