<?php
include_once ROOTPATH.'/admin/functions.php';
include_once 'inc/report.php';

$message = '';
$module = getParam('module');
$action = getParam('action');
$token = getParam('token');
$action_ar = explode('-', $action);

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));
switch ($action) {
	case 'view-agent':
	case 'view-email_alert':
	case 'view-email_system':
	case 'view-email_enquire':
	case 'view-property':
	case 'view-page':
	case 'view-banner':
	case 'view-price_range':
	case 'view-bid':
    case 'view-soldpassedin':
    case 'view-developments':
		if ($perm_ar['view'] == 0) {
			$session_cls->setMessage($perm_msg_ar['view']);
			redirect('/admin/?module='.$module.'&token='.$token);
		}
		include_once ROOTPATH.'/modules/report/inc/admin.'.$action_ar[1].'.php';
	break;
    case 'view-developments_CSV':
        include_once ROOTPATH . '/modules/report/inc/admin.developments.php';
        _exportCSV_developments();
        break;
	default:
		$action_ar[1] = '';
	break;
}

if (strlen($message) == 0) {
	$message = $session_cls->getMessage();
}

$smarty->assign(array('action' => $action,
			'action_ar' => $action_ar,
			'message' => $message));
?>