<?php
/*１.很多同学发私信找视频，言辞肯切，所以提供一次。

２.百度网盘经常抽疯，如链接被封，是你我无缘，请勿再向我找视频。

３.视频只是船，渡人而已。如有心学习，芦苇也可渡江。非要找某老师的视频看，已经走了弯路。

４.有同学称团购视频，不用了，直接给你。玉米哥不需要那三瓜俩枣。

５.我在比特币上做的有进展，勿念。*/
    $config = [
        "host" => "127.0.0.1",
        "dbname" => "shop",
        "user" => "root",
        "pass" => "root"
    ];
    //连接数据库
    $dbh = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}",$config['user'],$config['pass']);
    //获取用户id    使用intval防注入  $user_id = intval($_GET["id"]);
    $user_id = $_GET["id"];
    $user_name = $_GET["name"];
    //写sql语句
    $sql = "select * from p_users where user_id=:id and user_name=:name";
    echo "<br>".var_dump($sql);
    //预处理
    $stmt = $dbh->prepare($sql);
    //绑定函数
    $stmt->bindParam(":id",$user_id);
    $stmt->bindParam(":name",$user_name);
    //执行
    $stmt->execute();
    //结果转换为二维数组
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";print_r($res); echo "<pre>";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="" method="get">
    账号：<input type="text" name="id">
    密码：<input type="password" name="name">
    <input type="submit" value="登录">
</form>
</body>
</html>
