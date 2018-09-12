<?php
    require_once './init.php';
    @$userid = $_REQUEST['userid'];
    @$username = $_REQUEST['username'];
    @$kind = $_REQUEST['kind'];
    @$pay = $_REQUEST['pay'];
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
    }else if($kind == 'changerest'){
        $res = mysqli_fetch_row(mysqli_query($connect,"SELECT restmoney FROM wch_users WHERE userid='$userid' AND username='$username'"));
        if($res){
            if($res[0]>=$pay){
                $resmoney = $res[0] - $pay;
                mysqli_query($connect,"UPDATE wch_users SET restmoney='$resmoney' WHERE userid='$userid' AND username='$username'");
                $res = mysqli_affected_rows($connect);
                if($res>0){
                    $response = [
                        'code' => 200
                    ];
                }else{
                    $response = [
                        'code' => 400
                    ];
                }
            }else{
                $response = [
                    'code' => 300
                ];
            }
        }
    }
    echo json_encode($response);
?>