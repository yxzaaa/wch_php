<?php
    require_once './init.php';
    //查询本期信息
    $sql = "SELECT pid,pagename,count,opentimestamp,delaytime,opencode,expect,opentime FROM pagekind WHERE ispage=1";
    $res = fetchRows($connect,$sql);
    $t = time();
    //遍历本期信息
    foreach($res as $r){
        $pid = $r['pid'];
        $pagename = $r['pagename'];
        $opentimestamp = $r['opentimestamp'];
        $opentime = $r['opentime'];
        $expect = $r['expect'];
        $opencode = $r['opencode'];
        $delaytime = intval($r['delaytime']);
        //准备开奖
        if($pagename != '重庆时时彩' && $pagename != '北京赛车'){
            if($t>=$opentimestamp){
                //将本期信息加入历史开奖记录
                $sql = "INSERT INTO pagehis VALUES(NULL,'$pid','$pagename','$expect','$opencode','$opentimestamp','$opentime');";
                add($connect,$sql);
                //开始计算下一期开奖信息：开奖号码，开奖时间戳，开奖期号，开奖时间等
                if($opentimestamp == ''){
                    $opentimestamp = $t;
                }else{
                    $opentimestamp = intval($opentimestamp);
                }
                if($t>=$delaytime+$opentimestamp){
                    $opentimestamp = $t;
                };
                $count = intval($r['count'])+1;
                if($count<10){
                    $strcount ='000'.$count;
                }else if($count<100){
                    $strcount ='00'.$count;
                }else if($count<1000){
                    $strcount ='0'.$count;
                }else{
                    $strcount = $count;
                }
                $expect = date('Ymd').$pid.$strcount;
                $opentimestamp = $opentimestamp + $delaytime; 
                $opencode = getOpenNum();
                $opentime = date('Y-m-d h:i:s',$opentimestamp);
                //计算完成，将计算结果加入下一期开奖信息中
                $sql = "UPDATE pagekind SET count='$count',opentimestamp='$opentimestamp',opencode='$opencode',expect='$expect',opentime='$opentime' WHERE pid='$pid' AND pagename='$pagename'";
                if(add($connect,$sql)){
                    require_once './computeget.php';
                }
            }
        }
    }
    function getOpenNum(){
        return rand(0,9).','.rand(0,9).','.rand(0,9).','.rand(0,9).','.rand(0,9);
    }
    function add($connect,$sql){
        mysqli_query($connect,$sql);
        return mysqli_affected_rows($connect);
    }
    function fetchRows($connect,$sql){
        return mysqli_fetch_all(mysqli_query($connect,$sql),MYSQLI_ASSOC);
    }
    function queryLocation($url,$post_data){
        $postdata = http_build_query($post_data);    
        $options = array(    
            'http' => array(    
                'method' => 'POST',    
                'header' => 'Content-type:application/x-www-form-urlencoded',    
                'content' => $postdata,    
                'timeout' => 15 * 60 // 超时时间（单位:s）    
            )    
        );    
        $context = stream_context_create($options);    
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result,true);
        return $result;
    }
?>