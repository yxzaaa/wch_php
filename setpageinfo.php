<?php
    require_once './init.php';
    $res = mysqli_fetch_all(mysqli_query($connect,'SELECT pid,pagename,count,opentimestamp,delaytime,opencode,expect,opentime FROM pagekind WHERE ispage=1'),MYSQLI_ASSOC);
    $t = time();
    for($i=0;$i<count($res);$i++){
        $pid = $res[$i]['pid'];
        $pagename = $res[$i]['pagename'];
        $opentimestamp = $res[$i]['opentimestamp'];
        $opentime = $res[$i]['opentime'];
        $expect = $res[$i]['expect'];
        $opencode = $res[$i]['opencode'];
        $delaytime = intval($res[$i]['delaytime']);
        if($pagename != '重庆时时彩' && $pagename != '北京赛车'){
            if($t>=$opentimestamp){
                $sql = "INSERT INTO pagehis VALUES(NULL,'$pid','$pagename','$expect','$opencode','$opentimestamp','$opentime');";
                mysqli_query($connect,$sql);
                if($opentimestamp == ''){
                    $opentimestamp = $t;
                }else{
                    $opentimestamp = intval($opentimestamp);
                }
                if($t>=$delaytime+$opentimestamp){
                    $opentimestamp = $t;
                };
                $count = intval($res[$i]['count'])+1;
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
                $sql="UPDATE pagekind SET count='$count',opentimestamp='$opentimestamp',opencode='$opencode',expect='$expect',opentime='$opentime' WHERE pid='$pid' AND pagename='$pagename'";
                mysqli_query($connect,$sql);
            }
        }else if($pagename == '重庆时时彩'){

        }else if($pagename == '北京赛车'){

        }
    }
    function getOpenNum(){
        return rand(0,9).','.rand(0,9).','.rand(0,9).','.rand(0,9).','.rand(0,9);
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