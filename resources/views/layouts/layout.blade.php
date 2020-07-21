<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1  maximum-scale=1 user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="HandheldFriendly" content="True">
    <link rel="stylesheet" href="/static/index/css/materialize.css">
    <link rel="stylesheet" href="/static/index/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/static/index/css/normalize.css">
    <link rel="stylesheet" href="/static/index/css/owl.carousel.css">
    <link rel="stylesheet" href="/static/index/css/owl.theme.css">
    <link rel="stylesheet" href="/static/index/css/owl.transitions.css">
    <link rel="stylesheet" href="/static/index/css/fakeLoader.css">
    <link rel="stylesheet" href="/static/index/css/animate.css">
    <link rel="stylesheet" href="/static/index/css/style.css">
    <link rel="shortcut icon" href="/static/index/img/favicon.png">
</head>
<body>
{{--头部--}}
@include("layouts.head")
{{--指定区块--}}
@yield("content")
{{--浮动--}}
@include("layouts.navbar")
{{--足部引用--}}
@include("layouts.foot")
<!-- scripts -->
<script src="/static/index/js/jquery.min.js"></script>
<script src="/static/index/js/materialize.min.js"></script>
<script src="/static/index/js/owl.carousel.min.js"></script>
<script src="/static/index/js/fakeLoader.min.js"></script>
<script src="/static/index/js/animatedModal.min.js"></script>
<script src="/static/index/js/main.js"></script>
</body>
</html>