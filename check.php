<?php
    session_start();
    include './init.php';
    if(isset($_SESSION['uname'])){
        $uid = $_SESSION['uid'];
        $uname = $_SESSION['uname'];
        $upwd = $_SESSION['upwd'];
        $ukind = $_SESSION['ukind'];
        $response = [
            'code' => 200,
            'msg' => '在线！',
            'uid' => $uid,
            'uname' => $uname,
            'ukind' => $ukind
        ];
    }else{
        $response = [
            'code' => 400,
            'msg' => '离线！'
        ];
    };
    echo json_encode($response);
?>