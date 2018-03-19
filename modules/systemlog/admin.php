<?php 
include 'lang/systemlog.en.lang.php';
include_once ROOTPATH.'/admin/functions.php';

$message = '';
$action = getParam('action');
$token = getParam('token');
$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));
if (strlen($action) > 0) {
	$smarty->assign('action', $action);		 	
}

if ($perm_ar['view'] == 0) {
	$message = $perm_msg_ar['view'];
}

if (strlen($message) == 0) {
	$message = $session_cls->getMessage();
}

$smarty->assign(array('part' => '../modules/systemlog/',
					  'imagepart' => '../modules/general/templates/images/',
					  'message' => $message));		
?>