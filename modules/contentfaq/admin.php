<?php 
include_once ROOTPATH.'/admin/functions.php';
include_once 'inc/contentfaq.php';

$message = '';
$id = (int)$_GET['ID'];
$module = getParam('module');
$action = getParam('action');
$token = getParam('token');

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));

$perm_tmp_ar = array('add' => 'add', 'edit' => 'edit', 'manager' => 'edit');

if (strlen($act = @$perm_tmp_ar[$action]) > 0) {
	if ($perm_ar[$act] == 0) {
		$session_cls->setMessage($perm_msg_ar[$act]);
		redirect('/admin/?module='.$module.'&action=deny&token='.$token);
	}
} 


switch ($action) {
	case 'add':
    case 'edit':
        $form_action = ($action == 'add')?'?module=contentfaq&action=add':'?module=contentfaq&action=edit&id='.$_GET['id'];
        $form_action .= '&token='.$token;
	
		include'inc/admin.contentfaq.form.php';
        $smarty->assign('id',$_GET['id']);
	break;
	case 'deny':
	break;
    default:
		if ($perm_ar['view'] == 0) {
			$session_cls->setMessage($perm_msg_ar['view']);
			redirect('/admin/?module='.$module.'&action=deny&token='.$token);
		}
	break;
	
}

if (strlen($message) == 0) {
	$message = $session_cls->getMessage();
}
//bar
$url = array('add'=>'?module=contentfaq&action=add&token='.$token,
             'manager'=>'?module=contentfaq&token='.$token);
$smarty->assign(array('action' => $action,
					  'ROOTPATH' => ROOTPATH,
					  'message' => $message,
                      'form_action'=>$form_action,
                      'url'=>$url));
?>