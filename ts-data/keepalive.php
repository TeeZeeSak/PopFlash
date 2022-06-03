<?php

require_once("lib/TeamSpeak3.php");

$ts3_VirtualServer = TeamSpeak3::factory("serverquery://PopFrag_data:HQVqy0UY@82.208.17.98:10011/?server_port=6376");


$queryId = $ts3_VirtualServer->whoami()["client_id"];
$ts3_VirtualServer->setPredefinedQueryName("Data");
$ts3_VirtualServer->clientMove($queryId, 79352);

while(true){
    usleep(50);
}

?>