<?php
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
            <div id="manualSelect" class="manualSelect">
                <h1 class="uuidInput">Vlož své Unique ID:</h1>
                <input id="uuidInput" placeholder="Y7VtZO5G362iBKUpTzi5B7ocRqU=" maxLength="30" type="text" class="uuidInput"/><br />
                <span id="uuidFail">Unique ID smí obsahovat pouze alfanumerické symboly a <i>+ / =</i></span>

            </div>
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
                
                function get_user_name($ts_uuid){
                    require("db.php");
                    
                    $ts_uuid = htmlentities($ts_uuid, ENT_QUOTES);
                    $sql = "SELECT * FROM users WHERE cluid=\"$ts_uuid\"";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $userName = $row["userName"];
                            return $userName;
                            
                        }
                    }else{
                        setcookie("ts_uuid", "-1", time()+86400*365);

                    }
                }

                function get_user_identities(){
                    if(isset($_COOKIE["ts_uuid"]) && $_COOKIE["ts_uuid"] != "-1"){
                        $uuid = $_COOKIE["ts_uuid"];
                        echo '<div id="clientAccountSelect">';
                        echo '<p class="usersContainerSelect">Jsi to ty?</p>';
             
                        echo "<div class='userSelect'>" . get_user_name($uuid) . "</div>";
                            
                        echo "<button id=\"btnYes\" uuid=\"$uuid\" class=\"selectYes\">Ano</button> <button id=\"btnNo\" class=\"selectNo\">Ne</button>";
                        echo '</div>';
                        return;
                    }


                    require("db.php");
                    $ip = htmlentities(getUserIpAddr(), ENT_QUOTES);
                    
                    $sql = "SELECT * FROM users WHERE ip=\"$ip\" AND online=\"1\"";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        if($result->num_rows == 1){
                            echo '<div id="clientAccountSelect">';
                                echo '<p class="usersContainerSelect">Jsi to ty?</p>';
                                $uuid = null;
                                while($row = $result->fetch_assoc()) {
                                    $userName = $row["userName"];
                                    echo "<div class='userSelect'>" . $userName . "</div>";
                                    $uuid = $row["cluid"];
                                    
                                }
                                echo "<button id=\"btnYes\" uuid=\"$uuid\" class=\"selectYes\">Ano</button> <button id=\"btnNo\" class=\"selectNo\">Ne</button>";
                            echo '<div>';
                        }else{
                            echo '<div id="clientAccountSelect">';
                            echo '<p class="usersContainerSelect">Vyber sebe:</p>';
                            $uuid = null;
                            while($row = $result->fetch_assoc()) {
                                $userName = $row["userName"];
                                $uuid = $row["cluid"];
                                echo "<div onclick=\"selectUser(this)\" uuid=\"$uuid\" class='userSelectSelf'>" . $userName . "</div>";                                
                            }
                        echo '<div>';
                        }
                    }else{
                        echo "Nebyl jsi na serveru nalezen. Ujisti se, že jsi připojený! <a href=\"https://{DOMENA}.{TLS}/tsdata/ikonky\" class=\"tryAgain\">Zkusit znovu</a>";
                    }
                }

                get_user_identities();
            ?>
		</div>
        <script>
            let uuidCheckFailed = false;
            function getCookie(cname) {
                var name = cname + "=";
                var decodedCookie = decodeURIComponent(document.cookie);
                var ca = decodedCookie.split(';');
                for(var i = 0; i <ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                    }
                }
                return "";
            }
            function setCookie(cname, cvalue, exdays) {
                var d = new Date();
                d.setTime(d.getTime() + (exdays*24*60*60*1000));
                var expires = "expires="+ d.toUTCString();
                document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            }
            let btnYes = document.getElementById("btnYes");
            btnYes.addEventListener("click", btnYesClick);
            let btnNo = document.getElementById("btnNo");
            btnNo.addEventListener("click", btnNoClick);
            let autoSelect = document.getElementById("clientAccountSelect");
            let manualSelect = document.getElementById("manualSelect");
            let manualSelectUUID = document.getElementById("uuidInput");
            let uuidFailInfo = document.getElementById("uuidFail");
            manualSelectUUID.addEventListener("input", checkText);

            

            function checkText(){
                let failed = false;

                //regex (?![A-Za-z0-9+=\/]).
                let text = manualSelectUUID.value;

                if(text.match("(?![A-Za-z0-9+=\/]).")){
                    manualSelectUUID.style.border = "2px solid red";
                    uuidFailInfo.style.display = "inline";
                    failed = true;
                }else{
                    manualSelectUUID.style.border = "1px solid #1e202f";
                    uuidFailInfo.style.display = "none";
                }
                
                if(text.length < 28){
                    failed = true;
                }

                if(!failed){
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            if(this.responseText == "ok"){
                                if(getCookie("ts_uuid").length < 4){
                                    setCookie("ts_uuid", text, 365);
                                }
                                location.reload();
                            }
                        }
                    };
                    xhttp.open("GET", "checkUUID.php?uuid=" + text, true);
                    xhttp.send();
                }
            }

            function btnNoClick(){
                if(getCookie("ts_uuid").length > 5){ // do we have got a wrong cookie?
                    setCookie("ts_uuid", "-1", 365);
                }

                //Manual select!
                autoSelect.style.display = "none";
                manualSelect.style.display = "block";

            }

            function btnYesClick(){
                let uuid = btnYes.getAttribute("uuid");
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if(this.responseText == "ok"){
                            if(getCookie("ts_uuid").length < 4){
                                setCookie("ts_uuid", uuid, 365);
                            }
                            window.location.href = "https://{DOMENA}.{TLS}/tsdata/ikonky";
                        }
                    }
                };
                xhttp.open("GET", "check_uuid.php?uuid=" + uuid, true);
                xhttp.send();
            }

            function selectUser(elm){
                let uuid = elm.getAttribute("uuid");
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if(this.responseText == "ok"){
                            
                            setCookie("ts_uuid", uuid, 365);
                            
                            window.location.href = "https://{DOMENA}.{TLS}/tsdata/ikonky";
                        }
                    }
                };
                xhttp.open("GET", "check_uuid.php?uuid=" + uuid, true);
                xhttp.send();
            }

        </script>
	</body>
</html>