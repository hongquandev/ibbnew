<?php 
$_SESSION['ROOTPATH'] = ROOTPATH;
$smarty->assign('part', "../modules/cms/");
$smarty->assign('imagepart' , "../modules/general/templates/images/");
$smarty->assign('ROOTPATH',ROOTPATH);
include_once ROOTPATH.'/admin/functions.php';
include_once 'inc/cms.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/menu/inc/menu.php';


$message = '';
$page_id = getParam('page_id', 0);
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
		
		$form_action = '?module=cms&action='.$action.'&token='.$token;
		$url = '?module=cms&token='.$token;
		include 'inc/admin.cms.edit.php';
		$smarty->assign(array('options_menu' => array(0 => '- - - Default - - -') + Menu_getOptions(0, 0, '- - ')));
	break;
    case 'tourguide-add':
        /*if ($perm_ar[$action] == 0) {
            $session_cls->setMessage($perm_msg_ar[$action]);
            redirect('/admin/?module='.$module.'&token='.$token);
        }*/
        $form_action = '?module=cms&action='.$action.'&token='.$token;
        $url = '?module=cms&token='.$token;
        include_once 'inc/admin.cms.tourguide-add.php';
        break;
    case 'landing-page':

        $form_action = '?module=cms&action='.$action.'&token='.$token;
        $url = '?module=cms&token='.$token;
        include_once 'inc/admin.cms.landing-page.php';
        break;
}

if (strlen($message) == 0) {
	$message = $session_cls->getMessage();
}

$smarty->assign(array('action' => $action,
                'action_ar' => explode('-',$action),
				'page_id' => $page_id,
			    'message' => $message,
			    'url' => $url,
			    'form_action' => $form_action));
?>