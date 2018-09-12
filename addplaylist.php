<?php
    require_once './init.php';
    @$userid=$_REQUEST['userid'];
    @$username=$_REQUEST['username'];
    @$pageid=$_REQUEST['pageid'];
    @$pagename=$_REQUEST['pagename'];
    @$expect=$_REQUEST['expect'];
    @$playname=$_REQUEST['playname'];
    @$playkind=$_REQUEST['playkind'];
    @$pagenums=$_REQUEST['pagenums'];
    @$pagecount=$_REQUEST['pagecount'];
    @$pagebei=$_REQUEST['pagebei'];
    @$pagepay=$_REQUEST['pagepay'];
    mysqli_query($connect,"INSERT INTO userpagehis VALUES
    (NULL,'$userid','$username','$pageid','$pagename','$expect','$playname','$pagebei','$playkind','$pagenums','$pagepay',0,0)");
    mysqli_query($connect,$sql);
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
    echo json_encode($response);
?>