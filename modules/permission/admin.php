<?php 
$module = 'permission';
include_once ROOTPATH.'/admin/functions.php';
include 'lang/'.$module.'.en.lang.php';
include_once ROOTPATH.'/modules/role/inc/role.php';
include_once ROOTPATH.'/modules/tab/inc/tab.php';

include_once 'inc/'.$module.'.php';
include_once 'inc/admin.'.$module.'.php';

$message = '';
$role_id = restrictArgs(getParam('role_id', 0));
$action = getParam('action');
$token = getParam('token');

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));
switch ($action) {
	case 'add':
	case 'edit':
		if ($perm_ar[$action] == 0) {
			$session_cls->setMessage($perm_msg_ar[$action]);
			redirect('module=permission&action=edit&token='.$token);
		}
	
		if ($action == 'edit' or $action == 'add') {
			$action = 'edit';
		}
		
		$message = '';
		$form_action = '?module='.$module.'&action='.$action.'&token='.$token;
		
		$action_ar = explode('-', $action);
					
		include_once 'inc/admin.'.$module.'.edit.php';
		
		$smarty->assign(array('action_ar' => $action_ar,
							  'form_action' => $form_action,
							  'permission_id' => $permission_id));
	break;
	default:
		if ($perm_ar['view'] == 0) {
			$message = $perm_msg_ar['view'];
		}
	break;
}

if ($role_id == 0) {
	$role_ar = Role_getFirst();
	if (isset($role_ar['role_id'])) {
		$role_id = $role_ar['role_id'];
	}
}

if (strlen($message) == 0) {
	$message = $session_cls->getMessage();
}

$smarty->assign(array('action' => $action,
					  'options_role' => Role_getOptions(),
					  'options_permission' => Permission_items($role_id),
					  'role_id' => $role_id,
					  'message' => $message));
?>