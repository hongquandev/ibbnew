<?php 
$_SESSION['ROOTPATH'] = ROOTPATH;
$smarty->assign('part', "../modules/cms/");
$smarty->assign('imagepart' , "../modules/general/templates/images/");
$smarty->assign('ROOTPATH',ROOTPATH);
include_once ROOTPATH.'/admin/functions.php';
include_once 'inc/video.php';

$message = '';
$video_id = getParam('video_id', 0);
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
    case 'add':
	case 'edit':
		if ($perm_ar[$action] == 0) {
			$session_cls->setMessage($perm_msg_ar[$action]);
			redirect('/admin/?module='.$module.'&token='.$token);
		}
		
		$form_action = '?module=video&action='.$action.'&token='.$token;
		$url = '?module=video&token='.$token;
		
		include 'inc/admin.video.edit.php';
	break;

}

if (strlen($message) == 0) {
	$message = $session_cls->getMessage();
}

$smarty->assign(array('action' => $action,
	'action_ar' => explode('-',$action),
	'video_id' => $video_id,
	'message' => $message,
	'url' => $url,
	'form_action' => $form_action));
?>