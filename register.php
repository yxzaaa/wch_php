<?php
    require_once './init.php';
    @$uname = $_REQUEST['uname'];
    @$upwd = $_REQUEST['upwd'];
    @$prjid = $_REQUEST['prjid'];
    $time = time();
    $res = mysqli_fetch_row(mysqli_query($connect,"SELECT userid FROM wch_users WHERE username='$uname'"));
    if($res){
        $response = [
            'code' => 300
        ];
    }else{
        mysqli_query($connect,"INSERT INTO wch_users VALUES(NULL,'$uname','$upwd','','123456','','','',0,0,1,'$prjid','$time',0,0)");
        $res = mysqli_affected_rows($connect);
        if($res>0){
            $response = [
                'code' => 200,
                'uname' => $uname,
                'upwd' => $upwd
            ];
        }else{
            $response = [
                'code' => 400
            ];
        }
    }
    echo json_encode($response);
?>