<?php
include_once ROOTPATH.'/admin/functions.php';
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once ROOTPATH.'/includes/session.class.php';

include_once ROOTPATH.'/modules/banner/inc/banner.php';

// assign Part;
$smarty->assign('part', '../modules/banner/');
$smarty->assign('imagepart' , '../modules/general/templates/images/');

$message = '';
$module = getParam('module');
$id = restrictArgs(getParam('id', 0));
$action = getParam('action');
$token = getParam('token');
$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));

switch ($action) {
	default: 
		if ($perm_ar['view'] == 0) {
			$message = $perm_msg_ar['view'];
		}
		$token = Tab_getTokenFromUri('?module='.$module);
	break;
	case 'edit':
		if ($perm_ar[$action] == 0) {
			$session_cls->setMessage($perm_msg_ar[$action]);
			redirect('/admin/?module='.$module.'&token='.$token);
		}
		
		$form_action = ROOTURLS.'/admin/?module='.$module.'&action='.$action.'&id='.$id.'&token='.$token;
		include_once 'inc/admin.banner.edit.php';
	break;
}

$smarty->assign(array('action' => $action,
				'form_action' => $form_action,
				'id' => $id,
				'message' => strlen($message) > 0 ? $message : $session_cls->getMessage(),
				'next' => B_getNav('next', $id),
				'prev' => B_getNav('prev', $id),
				'countries' => R_getOptionsStep2()));
?>