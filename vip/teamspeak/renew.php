<?php
	ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
	$logtext = print_r($_GET, true);
	$myfile = fopen("test.txt", "a") or die("Unable to open file!");
	fwrite($myfile, $logtext);
	fclose($myfile);

	$response = "Dekujeme za zaslani SMS.";
	Header ('Content-type: text/plain');
	Header ('Content-length:'.strlen($response));
	echo $response;

?>
