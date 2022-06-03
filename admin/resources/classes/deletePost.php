

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
	define('ROOT_PATH', "../../../forum");

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
	
	ini_set('display_errors', 1); 
	ini_set('display_startup_errors', 1); 
	error_reporting(E_ALL);
	
	$id = $request->variable("post", "unset", true);
	

	function is_valid_post($id){
		include("../../../db.php");
		$sql = "SELECT id FROM news WHERE id=$id";
				
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$conn->close();
			return true;
		} else {
			$conn->close();
			return false;
		}
					
	}
		
	if(!is_numeric($id)){
		header("Location: https://popfrag.eu");
		die();
	}
	if(!is_valid_post($id)){
		header("Location: https://popfrag.eu");
		die();
	}

	include("../../../db.php");
	
	$sql = "DELETE FROM news WHERE id=$id";
				
	$result = $conn->query($sql);
	
	if ($conn->query($sql) === TRUE) {
		echo "success";
	}else{
		
	}
	$conn->close();
	
?>