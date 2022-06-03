<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

	function getRank($group){
		if($group == 23100){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%2013.png";
		}else if($group == 23099){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%2012.png";
		}else if($group == 23098){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%2011.png";
		}else if($group == 23097){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%2010.png";
		}else if($group == 23096){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%209.png";
		}else if($group == 23095){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%208.png";
		}else if($group == 23094){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%207.png";
		}else if($group == 23093){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%206.png";
		}else if($group == 23092){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%205.png";
		}else if($group == 23091){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%204.png";
		}else if($group == 23090){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%203.png";
		}else if($group == 23089){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%202.png";
		}else if($group == 23201){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%201.png";
		}else if($group == 23205){
            return "https://{DOMENA}.{TLS}/tsdata/icons/23205.png";
        }else if($group == 23553){
            return "https://{DOMENA}.{TLS}/tsdata/icons/23553.png";
        }
	}
?>

<!DOCTYPE html>
<html lang="cs">
	<head>
		<meta charset="utf-8">

		<title>PopFrag.eu TeamSpeak 3 </title>

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://{DOMENA}.{TLS}/tsdata/css/style.css">
		<link href="https://fonts.googleapis.com/css?family=Exo+2&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">


    </head>
		
	<body>
		<header>
			<div class="navbar">
				<div class="navbar_holder" id="navbar_holder">
					<div class="navbar_left">
						<a class="navbar_ip">ts.popfrag.eu</a>
						<div class="navbar_item_active">Přehled</div>
						<div class="splitter">|</div>
						<a href="https://{DOMENA}.{TLS}/tsdata/nahled"><div class="navbar_item">Náhled serveru</div></a>
						<div class="splitter">|</div>
						<div class="navbar_item">Ikonky</div>
						<div class="splitter">|</div>
						<div class="navbar_item">Bany</div>
					</div>
				</div>
			</div>
		</header>

		<div class="usersContainer">
			<?php

                    $uuid = $_COOKIE["ts_uuid"];

                    if($uuid == "-1" || !isset($uuid)){
                        header("Location: https://{DOMENA}.{TLS}/tsdata/overeni");
                        die();
                    }
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

                    function getAvailableIcons(){
                        require("db.php");

                        $sql = "SELECT icons FROM server WHERE 1";

                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()){
                                $groups = explode(",", $row["icons"]);
                                return $groups;
                            }
                        }
                        return "none";
                    }

                    function getClientGroups($uuid){
                        $sql = "SELECT groups FROM users WHERE ip=\"$ip\" AND cluid=\"$uuid\"";
                        $result = $conn->query($sql);
    
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                           
                            $groups = explode(",", $row["groups"]);
                            return $groups;
                            
                            
                        }else{
                            header("Location: https://{DOMENA}.{TLS}/tsdata/overeni");
                            die();
                        }
                    }

                    require("db.php");
                    $ip = htmlentities(getUserIpAddr(), ENT_QUOTES);
                    $uuid = htmlentities($uuid, ENT_QUOTES);
                    
                    $sql = "SELECT * FROM users WHERE ip=\"$ip\" AND cluid=\"$uuid\"";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $data = getAvailableIcons();
                        $clientGroups = getClientGroups($uuid);
                        $data = array_filter($data, "getClientGroups");
                        echo "Dostupné ikonky: <br>";
                        for($i = 0; $i < count($data); $i++){
                            echo "<img style=\"margin-right: 30px;\" src=\"" . getRank($data[$i]) . "\" />";
                        }
                        
                        
                        
                        
                    }else{
                        header("Location: https://{DOMENA}.{TLS}/tsdata/overeni");
                        die();
                    }
                
            ?>
		</div>
        <script>
            

        </script>
	</body>
</html>