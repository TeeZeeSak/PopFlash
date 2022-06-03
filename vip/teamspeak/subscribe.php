<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
	$logtext = print_r($_GET, true);
	$myfile = fopen("test.txt", "a") or die("Unable to open file!");
	fwrite($myfile, $logtext);
	fclose($myfile);
	echo "Dekujeme za platbu..";
	header('Content-Type:text/plain');
	http_response_code(200);
?>
