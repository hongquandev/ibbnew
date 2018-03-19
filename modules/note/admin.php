<?php 
$module = 'note';
include_once 'lang/'.$module.'.en.lang.php';
include_once ROOTPATH.'/admin/functions.php';
include_once ROOTPATH.'/modules/role/inc/role.php';
include_once 'inc/'.$module.'.php';
include_once 'inc/admin.'.$module.'.php';
include_once ROOTPATH.'/includes/checkingform.class.php';

if (!($check instanceof CheckingForm)) {
	$check = new CheckingForm();
}

$message = '';
$note_id = (int)restrictArgs(getParam('note_id',0));
$action = getParam('action');
$token = getParam('token');
$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));
switch ($action) {
	case 'add':
	case 'edit':
		if ($perm_ar[$action] == 0) {
			$session_cls->setMessage($perm_msg_ar[$action]);
			redirect('/admin/?module=note&action=list&token='.$token);
		}
	
		if ($action == 'edit' or $action == 'add') {
			$action = 'edit';
		}
		
		$form_action = '?module='.$module.'&action='.$action;
		$action_ar = explode('-', $action);
					
		include_once 'inc/admin.'.$module.'.edit.php';
		
		$smarty->assign(array('action_ar' => $action_ar,
						      'form_action' => $form_action,
							  'note_id' => $note_id,
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