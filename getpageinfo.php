<?php
    require_once './init.php';
    @$kind = $_REQUEST['kind'];
    @$pid = $_REQUEST['pageid'];
    @$pname = $_REQUEST['pagename'];
    if($kind == 'initpageinfo'){
        $res = mysqli_fetch_row(mysqli_query($connect,"SELECT delaytime,expect,opentimestamp FROM pagekind WHERE pid='$pid' AND pagename='$pname'"));
        if($res){
            $response = [
                'code' =>200,
                'data' =>$res
            ];
        }else{
            $response = [
                'code' =>400
            ];
        }
    }else if($kind == 'gethisinfo'){
        $res = mysqli_fetch_all(mysqli_query($connect,"SELECT expect,opencode,opentime FROM pagehis WHERE pageid='$pid' AND pagename='$pname' ORDER BY hid DESC LIMIT 6"),MYSQLI_ASSOC);
        if($res){
            $response = [
                'code' =>200,
                'data' =>$res
            ];
        }else{
            $response = [
                'code' =>400
            ];
        }
    }
    echo json_encode($response);
?>