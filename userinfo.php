<?php
    require_once './init.php';
    @$userid = $_REQUEST['userid'];
    @$username = $_REQUEST['username'];
    @$kind = $_REQUEST['kind'];
    if($kind == 'maininfo'){
        $res = mysqli_fetch_row(mysqli_query($connect,"SELECT restmoney,avatar,usercardnum,cardopen,cardname,cardstate FROM wch_users WHERE userid='$userid' AND username='$username'"));
        if($res){
            $response = [
                'code' => 200,
                'data' => $res
            ];
        }else{
            $response = [
                'code' => 400
            ];
        }
    }
    echo json_encode($response);
?>