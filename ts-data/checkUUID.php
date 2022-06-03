<?php
    function getUserIpAddr(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    require("db.php");
    
    $uuid = $_GET["uuid"];
    $ts_uuid = htmlentities($uuid, ENT_QUOTES);
    $ip = htmlentities(getUserIpAddr(), ENT_QUOTES);
    $sql = "SELECT cluid FROM users WHERE IP=\"$ip\" AND cluid=\"$uuid\"";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "ok";
    }else{
        echo "fail";
    }

?>