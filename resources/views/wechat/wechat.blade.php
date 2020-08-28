<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Websocket</title>
</head>
<body>

<h1>Websocket 聊天室</h1>


<textarea name="" id="rev_cont" cols="100" rows="20"></textarea>
<hr>
<input type="text" id="msg" style="width: 300px;height: 30px">
<input type="button" id="btn_msg" style="width:100px;height: 30px" value="发送">
<script src="/static/index/js/jquery-1.8.0.min.js"></script>
<script>
    var url = 'ws://chat.1910.com';       //websocket 服务器地址
    var ws = new WebSocket(url); //实例化一个websocket
    //打开
    ws.onopen = function(){
        //显示证明成功
        console.log('open');
        //点击发送
        $("#btn_msg").on('click',function(){
            var msg = $("#msg").val();
            ws.send(msg);
            $("#msg").val("");
        });
    }
    //接收服务器响应
    ws.onmessage = function(d){
        console.log(d.data);
        $("#rev_cont").append(d.data +"\n")
    }
</script>

</body>
</html>