<?php
    require_once './init.php';
    $res = mysqli_fetch_all(mysqli_query($connect,"SELECT * FROM userpagehis WHERE pagestate=0"),MYSQLI_ASSOC);
    if($res){
        for($i=0;$i<count($res);$i++){
            $uhid = $res[$i]['uhid'];
            $userid = $res[$i]['userid'];
            $username = $res[$i]['username'];
            $pageid = $res[$i]['pageid'];
            $pagename = $res[$i]['pagename'];
            $expect = $res[$i]['expect'];
            $playname = $res[$i]['playname'];
            $pagebei = $res[$i]['pagebei'];
            $playkind = $res[$i]['playkind'];
            $pagenums = $res[$i]['pagenums'];
            $num = mysqli_fetch_row(mysqli_query($connect,"SELECT opencode FROM pagehis WHERE pageid='$pageid' AND pagename='$pagename' AND expect='$expect'"));
            if($num){
                $numArray = explode(',',$num[0]);
                $shouldPay = computeGet($playname,$pagenums,$pagebei,$playkind,$numArray);
                print_r($shouldPay);
                print_r('<br>');
                $rest = mysqli_fetch_row(mysqli_query($connect,"SELECT restmoney FROM wch_users WHERE userid='$userid' AND username='$username'"));
                if($rest){
                    $resmoney = $shouldPay + $rest[0];
                    mysqli_query($connect,"UPDATE wch_users SET restmoney='$resmoney' WHERE userid='$userid' AND username='$username'");
                    mysqli_query($connect,"UPDATE userpagehis SET pagestate=1 WHERE uhid='$uhid'");
                    sleep(1);
                }
            }
        }
    }
    function computeGet($playname,$pagenums,$pagebei,$playkind,$num){
        $count = 0;
        $odds = 0.995;
        switch($playname){
            case '数字盘':
                $array = explode('|',$pagenums);
                for($j=0;$j<count($num);$j++){
                    $item = explode(',',$array[$j]);
                    $isIn = array_search($num[$j],$item);
                    if($isIn != false){
                        $count ++;
                    }
                }
                $paytotal = $count*10*$odds*$pagebei*$playkind;
                break;
            case '双面盘':
                $array = explode('|',$pagenums);
                for($j=0;$j<count($num);$j++){
                    $item = explode(',',$array[$j]);
                    $isIn = array_search($num[$j],$item);
                    if($isIn != false){
                        $count ++;
                    }
                }
                $paytotal = $count*10*$odds*$pagebei*$playkind;
                break;
            case '前三':
                $array = explode('|',$pagenums);
                $str = $num[0].$num[1].$num[2];
                $isGet = false;
                for($j=0;$j<count($array);$j++){
                    if($str == $array[$j]){
                        $isGet = true;
                    }
                }
                if($isGet == true){
                    $paytotal = 1000*$odds*$pagebei*$playkind;
                }else{
                    $paytotal = 0;
                }
                break;
            case '中三':
                $array = explode('|',$pagenums);
                $str = $num[1].$num[2].$num[3];
                $isGet = false;
                for($j=0;$j<count($array);$j++){
                    if($str == $array[$j]){
                        $isGet = true;
                    }
                }
                if($isGet == true){
                    $paytotal = 1000*$odds*$pagebei*$playkind;
                }else{
                    $paytotal = 0;
                }
                break;
            case '后三':
                $array = explode('|',$pagenums);
                $str = $num[2].$num[3].$num[4];
                $isGet = false;
                for($j=0;$j<count($array);$j++){
                    if($str == $array[$j]){
                        $isGet = true;
                    }
                }
                if($isGet == true){
                    $paytotal = 1000*$odds*$pagebei*$playkind;
                }else{
                    $paytotal = 0;
                }
                break;
        }
        return $paytotal;
    }
?>