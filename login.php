<?php
    session_start();
    include './init.php';
    @$uname = $_REQUEST['uname'];
    @$upwd = $_REQUEST['upwd'];
    @$statelog = $_REQUEST['statelog'];
    @$prjid = $_REQUEST['prjid'];
    @$userid = $_REQUEST['userid'];
    @$kind = $_REQUEST['kind'];
    if($kind == 'login'){
        $res = mysqli_fetch_all(mysqli_query($connect,"SELECT userid,userkind FROM wch_users WHERE username='$uname' AND userpwd='$upwd' AND prjid='$prjid'"),MYSQLI_ASSOC);
        if($res){
            $userid = $res[0]['userid'];
            $userkind = $res[0]['userkind'];
            $_SESSION['uname'] = $uname;
            $_SESSION['upwd'] = $upwd;
            $_SESSION['uid'] = $userid;
            $_SESSION['ukind'] = $userkind;
            mysqli_query($connect,"UPDATE wch_users SET statelog='$statelog' WHERE userid='$userid'");
            $response = [
                'code'=>200,
                'resMsg'=>'登录成功！',
                'userid'=>$userid
            ];
        }else{
            $response = [
                'code'=>400,
                'resMsg'=>'登录失败！'
            ];
        };
    }else if($kind == 'check'){
        $res = mysqli_fetch_all(mysqli_query($connect,"SELECT statelog,username FROM wch_users WHERE userid='$userid'"),MYSQLI_ASSOC);
        if($res[0]['statelog'] == 1){
            $response = [
                'code'=>200,
                'uname'=>$res[0]['username'],
            ];
        }else{
            $response = [
                'code'=>400,
            ];
        }
    }
    echo json_encode($response);
?>