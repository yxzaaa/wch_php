<?php
    require_once './init.php';
    @$kind = $_REQUEST['kind'];
    @$userkind = $_REQUEST['userkind'];
    @$userid = $_REQUEST['userid'];
    @$username = $_REQUEST['username'];
    @$pid = $_REQUEST['pid'];
    @$code = $_REQUEST['code'];
    @$expect = $_REQUEST['expect'];
    @$pagestart = $_REQUEST['pagestart'];
    @$pagesize = $_REQUEST['pagesize'];
    if($kind == 'gettab'){
        $res = mysqli_fetch_all(mysqli_query($connect,"SELECT pid,pagename,icon,pagepath,pageimg FROM pagekind WHERE userkind='$userkind'"),MYSQLI_ASSOC);
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
    }else if($kind == 'getpageinfo'){
        $res = mysqli_fetch_row(mysqli_query($connect,"SELECT * FROM pagekind WHERE pid='$pid'"));
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
    }else if($kind == 'getallpage'){
        $res = mysqli_fetch_row(mysqli_query($connect,"SELECT userkind FROM wch_users WHERE userid='$userid' AND username='$username'"));
        if($res[0] == 1){
            $res = mysqli_fetch_all(mysqli_query($connect,"SELECT * FROM pagekind WHERE ispage=1"),MYSQLI_ASSOC);
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
    }else if($kind == 'changecode'){
        mysqli_query($connect,"UPDATE pagekind SET opencode='$code' WHERE pid='$pid' AND expect='$expect'");
        $res = mysqli_affected_rows($connect);
        if($res>0){
            $response = [
                'code' => 200
            ];
        }else{
            $response = [
                'code' =>400
            ];
        }
    }else if($kind == 'gethis'){
        $res = mysqli_fetch_all(mysqli_query($connect,"SELECT * FROM userpagehis WHERE userid='$userid' AND username='$username' ORDER BY uhid DESC LIMIT $pagestart,$pagesize"),MYSQLI_ASSOC);
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
    }else if($kind == 'getpagehis'){
        $res = mysqli_fetch_all(mysqli_query($connect,"SELECT * FROM pagehis ORDER BY hid DESC LIMIT $pagestart,$pagesize"),MYSQLI_ASSOC);
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
    }else if($kind == 'gethiscount'){
        $res = mysqli_fetch_all(mysqli_query($connect,"SELECT COUNT(*) FROM userpagehis WHERE userid='$userid' AND username='$username'"));
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
    }else if($kind == 'getpagecount'){
        $res = mysqli_fetch_all(mysqli_query($connect,"SELECT COUNT(*) FROM pagehis"));
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