<?php 
include_once 'user.class.php';
if (!isset($user_cls) or !($user_cls instanceof User)) {
	$user_cls = new User();
}

function User_isExist($username = '') {
	global $user_cls;
	$row = $user_cls->getRow("username='".$user_cls->escape($username)."'");
	if (is_array($row) and count($row) > 0) {
		return true;
	}
	return false;
}
?>