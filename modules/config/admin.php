<?php
$action = (isset($_POST['action']) and strlen($_POST['action']) > 0 ) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '') ;

if (strlen($action) == 0) {
	$action = 'edit-notification';
}

include_once 'inc/config.class.php';

if (!isset($config_cls) || !($config_cls instanceof Config)) {
	$config_cls = new Config();
}

switch ($action) {
	case 'edit-notification':
		$action_ar = explode('-',$action);
		$bar_data = array('notification' => array('link' => '?module=config&action=edit-notification&token='.$token,
												'title' => 'Notification') ,
							);					
							
		$title_ar = array('notification' => 'Notification',
							);		
							
		$limit_click_ar = array();
		
		include_once 'inc/admin.config.'.$action_ar[1].'.php';
		
		$form_data = array();
		$rows = $config_cls->getRows();
		if (is_array($rows) && count($rows) > 0) {
			foreach ($rows as $row) {
				$form_data[$row['key']] = $row['value'];
			}
		}
		
		$smarty->assign('form_data',$form_data);
		$smarty->assign('bar_data', $bar_data);			
		$smarty->assign('action_ar', $action_ar);
		$smarty->assign('form_action', $form_action);
		$smarty->assign('message',$message);
		$smarty->assign('title',$title_ar[$action_ar[1]]);
		$smarty->assign('limit_click_ar',$limit_click_ar);
		
	break;
}	
?>