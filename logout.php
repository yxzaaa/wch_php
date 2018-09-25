<?php
    session_start();
    include './init.php';
    @$userid = $_REQUEST['userid'];
    if(isset($_SESSION['uname'])){
        session_destroy();
        mysqli_query($connect,"UPDATE wch_users SET statelog=0 WHERE userid='$userid'");
        // $res = mysqli_affected_rows($connect);
        // if($res>0){
        $response = [
            'code' => 200,
            'msg' => '退出成功'
        ];
        // }
    }else{
        $response = [
            'code' => 400,
            'msg' => '退出失败'
        ];
    };
    echo json_encode($response);
?>