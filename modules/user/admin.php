<?php 
$module = 'user';
include_once ROOTPATH.'/admin/functions.php';
include_once 'lang/'.$module.'.en.lang.php';
include_once 'inc/'.$module.'.php';
include_once ROOTPATH.'/modules/role/inc/role.php';
include_once 'inc/admin.'.$module.'.php';
include_once ROOTPATH.'/includes/checkingform.class.php';

if (!($check instanceof CheckingForm)) {
	$check = new CheckingForm();
}

$message = '';
$title = '';
$form_action = '';
$user_id = restrictArgs(getParam('user_id', 0));
$action = getParam('action');
$token = getParam('token');
$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));

switch ($action) {
	case 'add':
	case 'edit':
		if ($perm_ar[$action] ==0) {
			$session_cls->setMessage($perm_msg_ar[$action]);
			redirect('/admin/?module=user&token='.$token);
		}
	
		if ($action == 'edit' or $action == 'add') {
			$action = 'edit';
		}
		
		
		$form_action = '?module='.$module.'&action='.$action.'&user_id='.$user_id.'&token='.$token;
		
		$action_ar = explode('-', $action);
		$title = 'User detail';			
		include_once 'inc/admin.'.$module.'.edit.php';
		
		$smarty->assign(array('action_ar' => $action_ar));
	break;
	case 'myaccount':
		if ($perm_ar['edit'] == 0 || $perm_ar['view'] == 0) {
			$session_cls->setMessage($perm_msg_ar['view']);
			redirect('/admin/?module=user&token='.$token);
		}
		$title = 'My account';
		include_once 'inc/admin.'.$module.'.myaccount.php';
	break;
	default:
		if ($perm_ar['view'] == 0) {
			$message = $perm_msg_ar['view'];
		}
	break;
}

if (strlen($message) == 0) {
	$message = $session_cls->getMessage();
}

$smarty->assign(array('title' => $title,
   					  'message' => $message,
					  'action' => $action,
					  'user_id' => $user_id,
					  'form_action' => $form_action));
?>