<?php
	$servername = "host";
	$username = "username";
	$password = "password";
	$dbname = "ts3data";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

?>