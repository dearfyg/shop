<?php
    $config = [
        "host" => "127.0.0.1",
        "dbname" => "shop",
        "user" => "root",
        "pass" => "root"
    ];
    //连接数据库
    $link = mysqli_connect($config["host"],$config["user"],$config["pass"],$config["dbname"]);
    //获取用户id    使用intval防注入  $user_id = intval($_GET["id"]);
    $user_id = $_GET["id"];
    $user_name = $_GET["name"];
    //写sql语句
    $sql = "select * from p_users where user_id=? and user_name=?";
    echo "<br>".var_dump($sql);
    //预处理
    $stmt = mysqli_prepare($link,$sql);
    //绑定函数
    mysqli_stmt_bind_param($stmt,"ss",$user_id,$user_name);
    //执行
    mysqli_stmt_execute($stmt);
    //获取结果
    $res = mysqli_stmt_get_result($stmt);
    //结果转换为二维数组
    $res = mysqli_fetch_all($res,1);
    echo "<pre>";print_r($res); echo "<pre>";
