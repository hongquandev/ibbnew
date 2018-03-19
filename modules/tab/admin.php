<?php 
$module = 'tab';
include 'lang/'.$module.'.en.lang.php';
include_once ROOTPATH.'/admin/functions.php';
include_once ROOTPATH.'/modules/role/inc/role.php';
include_once ROOTPATH.'/modules/permission/inc/permission.php';
include_once 'inc/tab.php';
include_once 'inc/admin.tab.php';
include_once ROOTPATH.'/includes/checkingform.class.php';

if (!($check instanceof CheckingForm)) {
	$check = new CheckingForm();
}

$message = '';
$tab_id = restrictArgs(getParam('tab_id', 0));
$action = getParam('action');
$token = getParam('token');
$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));

switch ($action) {
	case 'add':
	case 'edit':
		if ($perm_ar[$action] == 0) {
			$session_cls->setMessage($perm_msg_ar[$action]);
			redirect('/admin/?module=tab&token='.$token);
		}
		if ($action == 'edit' or $action == 'add') {
			$action = 'edit';
		}
		$form_action = '?module=tab&action='.$action.'&tab_id='.$tab_id.'&token='.$token;
		$action_ar = explode('-', $action);
		include_once 'inc/admin.tab.edit.php';
		$smarty->assign(array('action_ar' => $action_ar,
							  'form_action' => $form_action,
							  'tab_id' => $tab_id,
							  'title' => $title_ar[$action_ar[1]]));
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

$smarty->assign(array('action' => $action,
					  'message' => $message));
?>