<?PHP
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
date_default_timezone_set("Europe/Prague");
// load framework files
require_once("lib/TeamSpeak3.php");

// connect to local server, authenticate and spawn an object for the virtual server on port 9987
$ts3_VirtualServer = TeamSpeak3::factory("serverquery://PopFrag_data:HQVqy0UY@82.208.17.98:10011/?server_port=6376");
// build and display HTML treeview using custom image paths (remote icons will be embedded using data URI sheme)

$queryId = $ts3_VirtualServer->whoami()["client_id"];
$ts3_VirtualServer->selfUpdate(array("client_nickname" => "PFTEMP"));
$ts3_VirtualServer->selfUpdate(array("client_nickname" => "PopFrag.eu"));
$ts3_VirtualServer->clientMove($queryId, 81798);



function banExists($banid){
	require("db.php");
	$sql = "SELECT banid FROM banlist WHERE banid=\"$banid\"";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		return true;
	} else {
		return false;
	}
}





function updateBanData($ban){

		//update the ban data
		require("db.php");

		$banid = $ban["banid"];
		$invoker = htmlentities($ban["invokername"], ENT_QUOTES);
		$invokerUUID = $ban["invokeruid"];
		$invokerClDBID = $ban["invokercldbid"];
		$duration = $ban["duration"];
		$reason = htmlentities($ban["reason"], ENT_QUOTES);
		$ip = htmlentities($ban["ip"], ENT_QUOTES);
		$created = $ban["created"];
		$UUID = $ban["uid"];
		$name = htmlentities($ban["name"], ENT_QUOTES);
		$lastNickName = htmlentities($ban["lastnickname"], ENT_QUOTES);

		$sql = "UPDATE banlist SET invoker='$invoker', invokerUUID='$invokerUUID', invokerClDBID='$invokerClDBID', duration='$duration', reason='$reason', ip='$ip', created='$created', uuid='$UUID', name='$name', lastNickName='$lastNickName' WHERE banid='$banid'";

		if ($conn->query($sql) === TRUE) {
		//	echo " - \033[32mOK\033[39m\n";
		} else {
		//	echo "  - \033[31mFAILED\033[39m [" . $conn->error . "]\n";
		}
	
}

function insertBanData($ban){
	require("db.php");

	$banid = $ban["banid"];
	$invoker = htmlentities($ban["invokername"], ENT_QUOTES);
	$invokerUUID = $ban["invokeruid"];
	$invokerClDBID = $ban["invokercldbid"];
	$duration = $ban["duration"];
	$reason = htmlentities($ban["reason"], ENT_QUOTES);
	$ip = htmlentities($ban["ip"], ENT_QUOTES);
	$created = $ban["created"];
	$UUID = $ban["uid"];
	$name = htmlentities($ban["name"], ENT_QUOTES);
	$lastNickName = htmlentities($ban["lastnickname"], ENT_QUOTES);

	$sql = "INSERT INTO banlist (banid, invoker, invokerUUID, invokerClDBID, duration, reason, ip, created, UUID, name, lastNickName) VALUES ('$banid', '$invoker', '$invokerUUID', '$invokerClDBID', '$duration', '$reason', '$ip', '$created', '$UUID', '$name', '$lastNickName')";

	if ($conn->query($sql) === TRUE) {
		
	} else {
		
	}
}

function requestBanData($banList){
	foreach($banList as $ban){
		if(banExists($ban["banid"])){
			updateBanData($ban);
		}else{
			insertBanData($ban);
		}
	}
}

function getUpdateData($serverInfo){

	$status = $serverInfo["virtualserver_status"];
	$clients = $serverInfo["virtualserver_clientsonline"] - 1;
	$slots = $serverInfo["virtualserver_maxclients"];
	$uptime = $serverInfo["virtualserver_uptime"];
	$version = $serverInfo["virtualserver_version"];
	$minVersion = $serverInfo["virtualserver_min_client_version"];
	$topOnline = getTopClients($clients);
	
	updateServerData($status, $clients, $slots, $uptime, $version, $minVersion, $topOnline);
}

function updateServerData($status, $clients, $slots, $uptime, $version, $minVersion, $topOnline){
	require("db.php");
	$sql = "UPDATE server SET status='$status', clients='$clients', slots='$slots', uptime='$uptime', version='$version', minVersion='$minVersion', topOnline='$topOnline'";

	$conn->query($sql);
}

function getTopClients($currentOnline){
	require("db.php");
	$sql = "SELECT topOnline FROM server";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if($currentOnline > $row["topOnline"]){
				return $currentOnline;
			}else{
				return $row["topOnline"];
			}
		}
	}
}

function getRank($time){
	$time = $time / 60 / 60; // get time in hours (seconds -> minutes -> hours)
	$time = ceil($time);
	if($time >= 2000){
		return "23100"; // level 13
	}else if($time >= 1500 && $time < 2000){
		return "23099"; // level 12 
	}else if($time >= 1200 && $time < 1500){
		return "23098"; // level 11
	}else if($time >= 1000 && $time < 1200){
		return "23097"; // level 10
	}else if($time >= 750 && $time < 1000){
		return "23096"; // level 9 
	}else if($time >= 500 && $time < 750){
		return "23095"; // level 8
	}else if($time >= 400 && $time < 500){
		return "23094"; // level 7
	}else if($time >= 200 && $time < 400){
		return "23093";// level 6
	}else if($time >= 100 && $time < 200){
		return "23092"; // level 5 
	}else if($time >= 50 && $time < 100){
		return "23091"; // level 4
	}else if($time >= 20 && $time < 50){
		return "23090"; // level 3
	}else if($time >= 10 && $time < 20){
		return "23089"; // level 2
	}

	return "23201"; //default -> level 1
}

function getClientRank($cldbid){
	return getRank(getClientTime($cldbid));
}

function updateClientRank($client, $ts3){

	require("db.php");
	$cldbid = $client["client_database_id"];
	$rank = getClientRank($client["client_database_id"]);
	
	$sql = "UPDATE users SET level='$rank' WHERE cldbid='$cldbid'";
	$clientGroups = $client["client_servergroups"];
	$clientGroupsArray = array();
	$clientGroupsArray = explode(",", $clientGroups);

	$conn->query($sql);
	
	if(!in_array($rank, $clientGroupsArray) && $rank != "23201"){
		
		removeOldRanks($client, $ts3);
		try{
			
			$ts3->serverGroupClientAdd($rank, $client["client_database_id"]);
			
		}catch(Exception $e){
			echo $e;
		}
	}
}

function removeOldRanks($client, $ts3){
	$clientGroups = $client["client_servergroups"];
	$currentClientRank = getClientRank($client["client_database_id"]);
	$ranks = array("23089", "23090", "23091", "23092", "23093", "23094", "23095", "23096", "23097", "23098", "23099", "23100");

	foreach($ranks as $rank){
		if(strpos($clientGroups, $rank) !== false){
			if($rank == $currentClientRank)
				continue;
			
			echo "removing Group " . $rank . " from " . $client["client_database_id"];
			$ts3->serverGroupClientDel($rank, $client["client_database_id"]);
				
		}
	}
}

function updateClient($cluid, $userName, $numConnections, $time, $lastConnected, $VIP, $IP, $online, $serverGroups){
	require("db.php");
	$sql = "UPDATE users SET userName='$userName', numConnections='$numConnections', time='$time', lastConnected='$lastConnected', VIP='$VIP', IP='$IP', online='$online', groups='$serverGroups' WHERE cluid='$cluid'";

	if ($conn->query($sql) === TRUE) {
		//echo " - \033[32mOK\033[39m\n";
	} else {
		//echo "  - \033[31mFAILED\033[39m [" . $conn->error . "]\n";
	}

}

function getClientTime($cldbid){
	require("db.php");
	$sql = "SELECT time FROM users WHERE cldbid=\"$cldbid\"";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			//echo $row["time"] . ' [' . $cldbid . ']';
			return $row["time"] + 1;
		}
	} else {
		return -1;
	}

}

function isClientInDB($cluid){
	require("db.php");
	$sql = "SELECT cluid FROM users WHERE cluid=\"$cluid\"";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		return true;
	} else {
		return false;
	}
	
	return false;
}



function addClientToDB($cluid, $cldbid, $firstConnected, $numConnections, $userName){
	require("db.php");
	$sql = "INSERT INTO users (cluid, cldbid, firstConnected, numConnections, userName, time) VALUES ('$cluid', '$cldbid', '$firstConnected', 0, '$userName', 0)";

	if ($conn->query($sql) === TRUE) {
		//echo "New record created successfully";
	} else {
		//echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

function updateAllUsers(){
	require("db.php");

	$sql = "UPDATE users SET online='0'";

	if ($conn->query($sql) === TRUE) {
		//echo " - \033[32mOK\033[39m\n";
	} else {
		//echo "  - \033[31mFAILED\033[39m [" . $conn->error . "]\n";
	}
}


while(true){

	try{
		$arr_ClientList = $ts3_VirtualServer->clientList();
	}catch(Exception $e){
		$ts3_VirtualServer->__wakeup();
				
		$queryId = $ts3_VirtualServer->whoami()["client_id"];

		$ts3_VirtualServer->clientMove($queryId, 81798);
	}
	
	$arr_ClientList = $ts3_VirtualServer->clientList();

	$serverInfo = $ts3_VirtualServer->getInfo();
	$banlist = $ts3_VirtualServer->banList();
	$clientPassed = array();

	getUpdateData($serverInfo);
	requestBanData($banlist);
	updateAllUsers();
	foreach($arr_ClientList as $client){
		require("db.php");
		$cluid = $client["client_unique_identifier"];
		$userName = htmlentities($client["client_nickname"], ENT_QUOTES);
		$cldbid = $client["client_database_id"];
		$clientGroups = $client["client_servergroups"];
		if(in_array($cldbid, $clientPassed))
			continue;
		if($client["client_type"] == 1)
			continue;
		
		array_push($clientPassed, $cldbid);
		$clientInfo = $ts3_VirtualServer->clientInfoDb($cldbid);
		updateClientRank($client, $ts3_VirtualServer);
		$numConnections = $clientInfo["client_totalconnections"];
		$VIP = 0;
		if(strpos($clientGroups, "23085") !== false){
			$VIP = 1;
		}
		$firstConnected = $client["client_created"];
		$lastConnected = $client["client_lastconnected"];
		$ip = $client["connection_client_ip"];
		$time = getClientTime($cldbid);
		if(isClientInDB($cluid)){
			updateClient($cluid, $userName, $numConnections, $time, $lastConnected, $VIP, $ip, "1", $clientGroups);
		}else{		
			addClientToDB($cluid, $cldbid, $firstConnected, $numConnections, $userName);
		}
	}

	sleep(1);
}
?>
