<?php 
$module = 'comment';
include 'lang/'.$module.'.en.lang.php';
include_once ROOTPATH.'/admin/functions.php';
include_once ROOTPATH.'/modules/role/inc/role.php';
include_once 'inc/'.$module.'.php';
include_once 'inc/admin.'.$module.'.php';
include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';

$comment_id = (int)restrictArgs(getParam('comment_id',0));
$action = getParam('action');
$token = getParam('token');
$message = '';
$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));

switch ($action) {
	case 'approve-comment':
		if ($perm_ar['edit'] == 0) {
			$session_cls->setMessage($perm_msg_ar['edit']);
			redirect('/admin/?module=comment&action=list&token='.$token);
		}
		
		$form_action = '?module='.$module.'&action='.$action.'&comment_id='.$comment_id.'&token='.$token;
		
		$action_ar = explode('-', $action);
					
		include_once 'inc/admin.'.$module.'.edit.php';
		$smarty->assign(array('action_ar' => $action_ar,
							  'form_action' => $form_action,
							  'comment_id' => $comment_id,
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