<?php
    require_once './init.php';
    @$userid = $_REQUEST['userid'];
    @$username = $_REQUEST['username'];
    @$kind = $_REQUEST['kind'];
    @$pay = $_REQUEST['pay'];
    @$nid = $_REQUEST['nid'];
    @$newname = $_REQUEST['newname'];
    @$addmoney = $_REQUEST['addmoney'];
    @$getmoney = $_REQUEST['getmoney'];
    @$cardnum = $_REQUEST['cardnum'];
    @$cardname = $_REQUEST['cardname'];
    @$cardopen = $_REQUEST['cardopen'];
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
    }else if($kind == 'getnews'){
        $res = mysqli_fetch_row(mysqli_query($connect,"SELECT new,nid FROM news WHERE userid='$userid' AND username='$username' AND newstate=0 LIMIT 1"));
        if($res){
            $response = [
                'code' => 200,
                'data' =>$res
            ];
        }else{
            $response = [
                'code' => 400
            ];
        }
    }else if($kind == 'setnew'){
        mysqli_query($connect,"UPDATE news SET newstate=1 WHERE nid='$nid'");
    }else if($kind == 'changename'){
        mysqli_query($connect,"UPDATE wch_users SET username='$newname' WHERE userid='$userid' AND username='$username'");
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
    }else if($kind == 'addmoney'){
        $t = time();
        mysqli_query($connect,"INSERT INTO userequest VALUES(NULL,1,'$addmoney','$userid','$username','$t',0)");
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
    }else if($kind == 'getmoney'){
        $t = time();
        mysqli_query($connect,"INSERT INTO userequest VALUES(NULL,0,'$getmoney','$userid','$username','$t',0)");
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
    }else if($kind == 'addcard'){
        mysqli_query($connect,"UPDATE wch_users SET usercardnum='$cardnum',cardname='$cardname',cardopen='$cardopen' WHERE userid='$userid' AND username='$username'");
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
    }else if($kind == 'removecard'){
        mysqli_query($connect,"UPDATE wch_users SET usercardnum='',cardname='',cardopen='' WHERE userid='$userid' AND username='$username'");
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
    }else if($kind == 'checkpwd'){
        
    }
    echo json_encode($response);
?>