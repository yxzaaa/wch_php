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
    @$moneypwd = $_REQUEST['moneypwd'];
    @$oldpwd = $_REQUEST['oldpwd'];
    @$newpwd = $_REQUEST['newpwd'];
    @$type = $_REQUEST['type'];
    @$rid = $_REQUEST['rid'];
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
        $res = mysqli_fetch_row(mysqli_query($connect,"SELECT new,nid,pagename,expect,getpay FROM news WHERE userid='$userid' AND username='$username' AND newstate=0 LIMIT 1"));
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
        // 充值申请
        $t = time();
        mysqli_query($connect,"INSERT INTO userequest VALUES(NULL,1,'$addmoney','$userid','$username','$cardnum','$t','未处理',0)");
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
        // 提现申请
        $t = time();
        mysqli_query($connect,"INSERT INTO userequest VALUES(NULL,0,'$getmoney','$userid','$username','$cardnum','$t','未处理',0)");
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
        $res = mysqli_fetch_row(mysqli_query($connect,"SELECT * FROM wch_users WHERE userid='$userid' AND username='$username' AND moneypwd='$moneypwd' LIMIT 1"));
        if($res){
            $response = [
                'code' => 200
            ];
        }else{
            $response = [
                'code' => 400
            ];
        } 
    }else if($kind == 'changeuserpwd'){
        $pwd = mysqli_fetch_row(mysqli_query($connect,"SELECT * FROM wch_users WHERE userid='$userid' AND username='$username' AND userpwd='$oldpwd' LIMIT 1"));
        if($pwd){
            mysqli_query($connect,"UPDATE wch_users SET userpwd='$newpwd' WHERE userid='$userid' AND username='$username'");
            $res = mysqli_affected_rows($connect);
            if($res>0){
                $response = [
                    'code' => 200
                ];
            }else{
                $response = [
                    'code' => 300
                ];
            }
        }else{
            $response = [
                'code' => 400
            ];
        } 
    }else if($kind == 'changemoneypwd'){
        $pwd = mysqli_fetch_row(mysqli_query($connect,"SELECT * FROM wch_users WHERE userid='$userid' AND username='$username' AND moneypwd='$oldpwd' LIMIT 1"));
        if($pwd){
            mysqli_query($connect,"UPDATE wch_users SET moneypwd='$newpwd' WHERE userid='$userid' AND username='$username'");
            $res = mysqli_affected_rows($connect);
            if($res>0){
                $response = [
                    'code' => 200
                ];
            }else{
                $response = [
                    'code' => 300
                ];
            }
        }else{
            $response = [
                'code' => 400
            ];
        } 
    }else if($kind == 'getrequests'){
        $res = mysqli_fetch_all(mysqli_query($connect,"SELECT * FROM userequest WHERE rstate=0 ORDER BY rid DESC"),MYSQLI_ASSOC);
        if($res){
            $response = [
                'code' => 200,
                'data' => $res
            ];
        }else{
            $response =[
                'code' => 400
            ];
        }
    }else if($kind == 'gethisres'){
        $res = mysqli_fetch_all(mysqli_query($connect,"SELECT * FROM userequest WHERE rstate=1 ORDER BY rid DESC LIMIT 50"),MYSQLI_ASSOC);
        if($res){
            $response = [
                'code' => 200,
                'data' => $res
            ];
        }else{
            $response =[
                'code' => 400
            ];
        }
    }else if($kind == 'reqsuccess'){
        // 通过申请
        $restMoney = mysqli_fetch_row(mysqli_query($connect,"SELECT restmoney FROM wch_users WHERE username='$username' AND userid='$userid'"));
        $rnum = mysqli_fetch_row(mysqli_query($connect,"SELECT rnum FROM userequest WHERE rid='$rid'"));
        if($type == 0){
            // 充值操作
            $nowRest = $restMoney[0] + $rnum[0];
            mysqli_query($connect,"UPDATE wch_users SET restmoney='$nowRest' WHERE userid='$userid' AND username='$username'");
            $res = mysqli_affected_rows($connect);
            if($res>0){
                $response = [
                    'code' => 200
                ];
                mysqli_query($connect,"UPDATE userequest SET resultstate='已通过',rstate=1 WHERE rid='$rid'");
                $new = '您的充值申请已经通过，如有疑问请联系客服！';
                mysqli_query($connect,"INSERT INTO news VALUES(NULL,'$userid','$username','$new','','','',0);");
            }else{
                $response = [
                    'code' => 400,
                    'rest' => $nowRest
                ];
            }
        }else if($type == 1){
            // 提现操作
            $nowRest = $restMoney[0] - $rnum[0];
            if($nowRest >= 0){
                mysqli_query($connect,"UPDATE wch_users SET restmoney='$nowRest' WHERE userid='$userid' AND username='$username'");
                $res = mysqli_affected_rows($connect);
                if($res>0){
                    $response = [
                        'code' => 200,
                        'rest' => $nowRest
                    ];
                    mysqli_query($connect,"UPDATE userequest SET resultstate='已通过',rstate=1 WHERE rid='$rid'");
                    $new = '您的提现申请已经处理！';
                    mysqli_query($connect,"INSERT INTO news VALUES(NULL,'$userid','$username','$new','','','',0);");
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
    }else if($kind == 'reqerror'){
        // 驳回申请
        mysqli_query($connect,"UPDATE userequest SET resultstate='已驳回',rstate=1 WHERE rid='$rid'");
        $res = mysqli_affected_rows($connect);
        if($res>0){
            $response = [
                'code' => 200
            ];
            $new = '您的充值/提现申请被驳回，如有疑问请联系客服！';
            mysqli_query($connect,"INSERT INTO news VALUES(NULL,'$userid','$username','$new','','','',0);");
        }else{
            $response = [
                'code' => 400
            ];
        }
    }else if($kind == 'getallusers'){
        $res = mysqli_fetch_row(mysqli_query($connect,"SELECT userkind FROM wch_users WHERE userid='$userid' AND username='$username' AND userstate=1"));
        if($res[0] == 1){
            $res = mysqli_fetch_all(mysqli_query($connect,"SELECT * FROM wch_users WHERE userstate=1"),MYSQLI_ASSOC);
            if($res){
                $response = [
                    'code' => 200,
                    'data' => $res
                ];
            }else{
                $response = [
                    'code' =>400
                ];
            }
        }
    }else if($kind == 'getuserhis'){
        $res = mysqli_fetch_all(mysqli_query($connect,"SELECT * FROM userpagehis WHERE userid='$userid' AND username='$username' ORDER BY uhid DESC LIMIT 20"),MYSQLI_ASSOC);
        if($res){
            $response = [
                'code' => 200,
                'data' => $res
            ];
        }else{
            $response = [
                'code' =>400
            ];
        }
    }
    echo json_encode($response);
?>