<?php
include_once ROOTPATH.'/admin/functions.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once 'inc/option.php';

$message = '';
$module = 'option';
$option_id = (int)restrictArgs(getParam('option_id', 0));
$action = getParam('action', 'view-contact_method');
$token = getParam('token');
$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));

$action_ar = explode('-', $action);
switch (@$action_ar[1]) {
	case 'contact_method':
	case 'security_question':
		$perm_tmp_ar = array('view' => 'return "view";',
							 'edit' => 'return "edit";',
							 'save' => 'return ($option_id == 0 ? "add" :"edit");',
							 'active' => 'return "edit";',
							 'delete' => 'return "delete";');
							 
		if ($perm_ar[$act = eval($perm_tmp_ar[@$action_ar[0]])] == 0) {
			$session_cls->setMessage($perm_msg_ar[$act]);
			redirect('/admin/?module='.$module.'&action=view-deny&token='.$token);
		}			
	
		$link_ar = array('module' => 'option', 
						 'action' => 'save-'.$action_ar[1], 
						 'token' => $token);
		$form_action = '?'.http_build_query($link_ar);
		
		$title_ar = array('contact_method' => 'Preferred contact method',
						  'security_question' => 'Security question');			
		
		$bar_data = array();
		
		if (is_array($title_ar) && count($title_ar) > 0) {
			foreach ($title_ar as $key => $title) {
				$bar_data[$key] = array('link' => '?module=option&action=view-'.$key.'&token='.$token, 'title' => $title);
			}
		}
					
		
		include_once 'inc/admin.option.'.$action_ar[1].'.php';
		
		$smarty->assign(array('bar_data' => $bar_data,
							  'action_ar' => $action_ar,
							  'form_action' => $form_action,
							  'title' => $title_ar[$action_ar[1]],
							  'limit_click_ar' => $limit_click_ar));
	break;
	case 'deny':
	break;
}

if (strlen(trim($message)) == 0) {
	$message = $session_cls->getMessage();
}
$smarty->assign(array('option_id' => $option_id,
					  'action' => $action,
					  'message' => $message));
?>