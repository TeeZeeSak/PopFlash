<?php

define('IN_PHPBB', true);
define('ROOT_PATH', "../../forum");

if (!defined('IN_PHPBB') || !defined('ROOT_PATH')) {
	exit();
}

$phpEx = "php";
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : ROOT_PATH . '/';
include($phpbb_root_path . 'common.' . $phpEx);
 
// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();



$username = $request->variable('username', '', false, \phpbb\request\request_interface::REQUEST);
$password = $request->variable('password', '', false, \phpbb\request\request_interface::REQUEST);

$result = $auth->login($username, $password, true);

if ($result['status'] == LOGIN_SUCCESS)
{
	//User was successfully logged into phpBB
	echo "success";
}
else
{
	echo "failure";
}

?>