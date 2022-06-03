<?php
	function is_admin($id){
		$servername = "host";
		$username = "username";
		$password = "password";
		$dbname = "forum";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

				
		
		$sql = "SELECT blog_auth_level FROM phpbb_users WHERE user_id=$id";
				
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				if($row["blog_auth_level"] == "1"){
					return true;
				}
			}
		}
		$conn->close();
		return false;
	}


	define('IN_PHPBB', true);
	define('ROOT_PATH', "../forum");

	if (!defined('IN_PHPBB') || !defined('ROOT_PATH')) {
		exit();
	}

	$phpEx = "php";
	$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : ROOT_PATH . '/';
	include($phpbb_root_path . 'common.' . $phpEx);

	$user->session_begin();
	$auth->acl($user->data);
	
	$user_id = $user->data["user_id"];
	if(!is_admin($user_id)){
		header("Location: https://{DOMENA}.{TLS}/forum/ucp.php?mode=login");
		die();
	}
?>

<head>
	<link rel="stylesheet" type="text/css" href="style/main.css?<?php echo rand(0,10000000); ?>">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a00bceb363.js?  crossorigin="anonymous"></script>
	<script src="resources/js/interactive.js?<?php echo rand(0,10000000); ?>"></script>
	<title>PopFrag.eu - Administrace</title>
</head>

<body>
	<?php include "leftbar.php" ?>
</body>