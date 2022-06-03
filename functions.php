<?php

	// Get user's blog_auth_level
	class Uzivatel {
		function get_blog_auth_level_by_id($id){
			$auth_level = null;
			
			$servername = "host";
			$username = "username";
			$password = "password";
			$dbname = "forum";

			// Create connection
			$forumcc = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($forumcc->connect_error) {
				die("Connection failed: " . $forumcc->connect_error);
			}
			$sql_authlevel = "SELECT blog_auth_level FROM phpbb_users WHERE user_id=$id";
						
			$result = $forumcc->query($sql_authlevel);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					$auth_level = $row["blog_auth_level"];
				}
			}
			
			return $auth_level;
		}
		
		function get_blog_auth_level(){
			$auth_level = null;
			
			$servername = "host";
			$username = "username";
			$password = "password";
			$dbname = "forum";
			$id = get_user_id();
			// Create connection
			$forumcc = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($forumcc->connect_error) {
				die("Connection failed: " . $forumcc->connect_error);
			}
			$sql_authlevel = "SELECT blog_auth_level FROM phpbb_users WHERE user_id=$id";
						
			$result = $forumcc->query($sql_authlevel);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					$auth_level = $row["blog_auth_level"];
				}
			}
			
			return $auth_level;
		}
		
		function get_user_id(){
			/*define('IN_PHPBB', true);
			define('ROOT_PATH', "./forum");

			if (!defined('IN_PHPBB') || !defined('ROOT_PATH')) {
				exit();
			}

			$phpEx = "php";
			$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : ROOT_PATH . '/';
			include($phpbb_root_path . 'common.' . $phpEx);

			$user->session_begin();
			$auth->acl($user->data);
			*/
			return $user->data["user_id"];
		}
	}
?>