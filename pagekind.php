<?php
    require_once './init.php';
    @$kind = $_REQUEST['kind'];
    @$userkind = $_REQUEST['userkind'];
    @$pid = $_REQUEST['pid'];
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
    }
    echo json_encode($response);
?>