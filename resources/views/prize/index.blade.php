@extends("layouts.layout")
@section("title","抽奖页面")
@section("content")
    <center><h1><b><a href="javascript:;" id="ok">开始抽奖</a></b></h1>
    <h1>--仅显示最近中奖的前十名--</h1> </center><br>
    @foreach($info as $k=>$v)
    <h2>中奖用户:{{$v->user_id}} 邮箱号:xxxxxxxxxxxxxxx</h2><br>
    @endforeach
    tip:请及时联系 <a href="javascript:;">客服</a>领奖
    <center>
    <h1>——————————————————以下公示——————————————————————</h1>
    </center>
    @foreach($prize as $k=>$v)
    奖品名称：{{$v->prize_name}}                   <br>
    奖品概率：{{$v->prize_rand}} %                  <br>
    商品库存：{{$v->prize_num}}                  <br>
    ------------------------------------------------------<br>
    @endforeach
    <center>
    <h1>——————————————————_________——————————————————————</h1>
    </center>
    <script>
        $(document).ready(function () {
           $("#ok").click(function(){
               $.ajax({
                   url:"prizeDo",
                   type:"get",
                   async:true,
                   success:function(res){
                       alert(res.code);
                       //刷新页面
                       window.location.reload();
                   }
               })


           })
        })
    </script>
@endsection