<?php
include_once ROOTPATH.'/admin/functions.php';
include_once ROOTPATH.'/modules/banner_setting/inc/banner_setting.php';

$message = '';
$module = getParam('module');
$action = getParam('action');
$token = getParam('token');

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));

if (in_array($action, array('add', 'edit'))) {
	if ($perm_ar[$action] == 0) {
		$session_cls->setMessage($perm_msg_ar[$action]);
		redirect('/admin/?module='.$module.'&action=deny&token='.$token);
	}
} 

switch($action) {
	case 'add':
    case 'edit':
        $id = getParam('id',0);
		$form_action = ($action == 'add')?'?module=banner_setting&action=add&token='.$token : '?module=banner_setting&action=edit&id='.$id.'&token='.$token;
        include_once 'inc/banner_setting.edit.php';
	break;
	case 'deny':
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

//prepare menu
$url = array('list_menu'=>'?module=banner_setting&action=list&token='.$token,
             'list_cms'=>'?module=cms&token='.$token);

$smarty->assign('form_action', $form_action);
$smarty->assign('imagepart' , "../modules/general/templates/images/");
$smarty->assign('action',$action);
$smarty->assign('url',$url);

$smarty->assign('message', $message);
?>