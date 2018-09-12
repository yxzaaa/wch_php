<?php
    require_once './init.php';
    // 定时删除开奖历史，保留最新的100条
    $res = mysqli_fetch_all(mysqli_query($connect,"SELECT * FROM pagehis ORDER BY hid DESC LIMIT 1"),MYSQLI_ASSOC);
    $count = $res[0]['hid']-300;
    mysqli_query($connect,"DELETE FROM pagehis WHERE hid<$count");
    //初始化期数
    mysqli_query($connect,"UPDATE pagekind SET count=0");
?>