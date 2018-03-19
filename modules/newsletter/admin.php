<?php 
include_once ROOTPATH.'/admin/functions.php';
include_once("../includes/class.phpmailer.php");
include_once ROOTPATH.'/modules/newsletter/inc/newsletter.php';
include_once ROOTPATH.'/modules/general/inc/bids.php';

$message = '';
$action = getParam('action');
$token = getParam('token');
$module = getParam('module');

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));

switch ($action) {
	case 'emailtemplate':
		if ($perm_ar['view'] == 0) {
			$session_cls->setMessage($perm_msg_ar['view']);
			redirect('/admin/?module='.$module.'&token='.$token);
		}
		
		if (($perm_ar['add'] + $perm_ar['edit']) <= 1) {
			$session_cls->setMessage('You do not have permission to send mail.');
			redirect('/admin/?module='.$module.'&token='.$token);
		}
		include 'inc/sendmail.php';
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
					  'message' => $message,
                      'token'=>$token));
?>