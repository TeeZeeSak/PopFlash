<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


date_default_timezone_set("Europe/Prague"); 

require("./lib/TeamSpeak3.php");
$ts3_VirtualServer = null;

$lastTime = time();
main();
function main(){
    global $ts3_VirtualServer, $lastTime;
    $ts3_VirtualServer = TeamSpeak3::factory("serverquery://PopFrag_data:HQVqy0UY@82.208.17.98:10011/?server_port=6376&blocking=0&timeout=60");
    $ts3_VirtualServer->selfUpdate(array("client_nickname" => "" . rand(0,1000000) . ""));
    $ts3_VirtualServer->selfUpdate(array("client_nickname" => "PopFrag.eu BOT"));


    $queryId = $ts3_VirtualServer->whoami()["client_id"];
    $ts3_VirtualServer->clientMove($queryId, 81798);

    $ts3_VirtualServer->notifyRegister("textprivate");
    $ts3_VirtualServer->notifyRegister("server");
    $ts3_VirtualServer->notifyRegister("textserver");

    TeamSpeak3_Helper_Signal::getInstance()->subscribe("notifyTextmessage", "onTextmessage");
    TeamSpeak3_Helper_Signal::getInstance()->subscribe("notifyCliententerview", "onClientEnterView");
    try{
        while(true){
            $ts3_VirtualServer->getAdapter()->wait();
        }
    }
    catch (Exception $e){
        $ts3_VirtualServer->wakeup();
    }
}
function isClientVIP($client){
    $groups = $client["client_servergroups"];

    $groups_array = array();
    $groups_array = explode(",", $groups);

    if(in_array("23085", $groups_array, TRUE)){
        return true;
    }else{
        return false;
    }
}

function onTextmessage(TeamSpeak3_Adapter_ServerQuery_Event $event, TeamSpeak3_Node_Host $host){
	global $ts3_VirtualServer;
	
	$msg = $event["msg"];
  	$invoker = $event["invokername"];
    $invokerId = $event["invokerid"];
    $client = $ts3_VirtualServer->clientGetById($invokerId);
    $VIP = isClientVIP($client);
	if($msg == "!help"){
		$ts3_VirtualServer->execute("sendtextmessage", array("msg" => "Zvládám tyto příkazy:\n[b]!help[/b] - zobrazím ti tuto nápovědu\n[b]!afk[/b] - vypnu/zapnu ti AFK status\t[color=#ffda00][b][VIP][/b][/color]\n[b]!aktivovat [i][kod][/i][/b] - aktivuji VIP\n[b]!vip[/b] - ukážu, kde koupit VIP", "target" => $invokerId, "targetmode" => TeamSpeak3::TEXTMSG_CLIENT));
	}else if($msg == "!afk"){
        if($VIP == true){
            resolveAFKStatus($client, $ts3_VirtualServer);
        }
        else{
            messageNotVIP($invokerId, $ts3_VirtualServer);
        }
    }else if($msg == "!vip"){
        $ts3_VirtualServer->execute("sendtextmessage", array("msg" => "VIP kód můžeš zakoupit zde: [url=https://{DOMENA}.{TLS}/vip/teamspeak/]Klikni[/url]", "target" => $invokerId, "targetmode" => TeamSpeak3::TEXTMSG_CLIENT));
        return;
    }else if(preg_match("^!aktivovat^", $msg)){
        if(preg_match("^!aktivovat ^", $msg)){
            if($VIP){
                $ts3_VirtualServer->execute("sendtextmessage", array("msg" => "Již jsi VIP! Děkuji za podporu! :)", "target" => $invokerId, "targetmode" => TeamSpeak3::TEXTMSG_CLIENT));
                return;
            }
            $kod = $msg;
            $kod = str_replace("!aktivovat ", "", $kod); //8
            $kod = strtoupper($kod);

            if(strlen($kod) == 8 && ctype_alnum($kod)){
                require("db.php");
                $uuid = $client["client_unique_identifier"];
                $sql = "SELECT * FROM vip WHERE code=\"$kod\" AND (activated=0 OR uuid=\"$uuid\")";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $ts3_VirtualServer->serverGroupClientAdd("23085", $client["client_database_id"]);
                    $ts3_VirtualServer->execute("sendtextmessage", array("msg" => "[b]VIP výhody ti byly aktivovány![/b] Děkuji za podporu! :)", "target" => $invokerId, "targetmode" => TeamSpeak3::TEXTMSG_CLIENT));
                    devaluateCode($kod, $client);
                } else {
                    $ts3_VirtualServer->execute("sendtextmessage", array("msg" => "Bohůžel tento kod byl již aktivován, nebo jsi přihlášený přes novou identitu. [url=https://{DOMENA}.{TLS}/forum/viewforum.php?f=27]Potřebuješ pomoct?[/url]", "target" => $invokerId, "targetmode" => TeamSpeak3::TEXTMSG_CLIENT));

                }
            }else{
                $ts3_VirtualServer->execute("sendtextmessage", array("msg" => "Bohůžel tento kod byl již aktivován, nebo je neplatný. [url=https://{DOMENA}.{TLS}/forum/viewforum.php?f=27]Potřebuješ pomoct?[/url]", "target" => $invokerId, "targetmode" => TeamSpeak3::TEXTMSG_CLIENT));
            }
        }else{
            $ts3_VirtualServer->execute("sendtextmessage", array("msg" => "[b]Použití:[/b] !aktivovat <kod>", "target" => $invokerId, "targetmode" => TeamSpeak3::TEXTMSG_CLIENT));
        }
    }
}

function devaluateCode($code, $client){
    require("db.php");

    $uuid = $client["client_unique_identifier"];
    $sql = "UPDATE vip SET activated=\"1\", uuid=\"$uuid\" WHERE code=\"$code\"";
    $conn->query($sql);
}

function resolveAFKStatus($client, $ts3_VirtualServer){
    $groups = $client["client_servergroups"];

    $groups_array = array();
    $groups_array = explode(",", $groups);

    if(in_array("23530", $groups_array, TRUE)){
        $ts3_VirtualServer->serverGroupClientDel("23530", $client["client_database_id"]);
    }else{
        $ts3_VirtualServer->serverGroupClientAdd("23530", $client["client_database_id"]);

    }
}

function messageNotVIP($clid, $ts3){
    $ts3->execute("sendtextmessage", array("msg" => "AFK status můžu bohůžel aktivovat jen VIP uživatelům :( [url=https://{DOMENA}.{TLS}/vip/teamspeak/]Můžeš si ho ale koupit![/url]", "target" => $clid, "targetmode" => TeamSpeak3::TEXTMSG_CLIENT));
}

function onClientEnterView(TeamSpeak3_Adapter_ServerQuery_Event $event, TeamSpeak3_Node_Host $host){
    global $ts3_VirtualServer;
	
  	$invoker = $event["client_nickname"];
    $invokerId = $event["clid"];
	
	$ts3_VirtualServer->execute("sendtextmessage", array("msg" => "Ahoj " . $invoker . "! Vítej na TS3 serveru herního portálu PopFrag.eu! Pokuď ode mne budeš vyžadovat pomoc, napiš mi [b]!help[/b] do soukromé zprávy!", "target" => $invokerId, "targetmode" => TeamSpeak3::TEXTMSG_CLIENT));
	
  } 
?>
