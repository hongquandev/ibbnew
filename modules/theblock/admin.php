<?php
include_once ROOTPATH.'/admin/functions.php';


$module = getParam('module');
$action = getParam('action');
$token = getParam('token');
$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));

switch ($action) {
	default:
		if ($perm_ar['view'] == 0) {
			$message = $perm_msg_ar['view'];
		}
	break;
}

$smarty->assign('action',$action);
$smarty->assign('token',$token);
?>
