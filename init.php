<?php
    header("content-type:text/html;charset=utf-8");
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    $connect = mysqli_connect('localhost','wuchuang001','372105','wuchuang');
    mysqli_query($connect,'SET NAMES UTF8');
?>