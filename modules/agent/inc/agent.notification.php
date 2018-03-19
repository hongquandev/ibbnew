<?php
//include_once(ROOTPATH."/includes/class.phpmailer.php");
//include_once ROOTPATH.'/configs/config.inc.php';
//$mail = new PHPMailer();
//FOR DASHBOARD
$db_notification_data = array();
$row = $agent_cls->getRow('agent_id = '.$_SESSION['agent']['id']);
if (is_array($row) and count($row) > 0) { 
	$db_notification_data = $row;
}
$smarty->assign('db_notification_data',$db_notification_data);

//--
$form_data = array('notify_email' => 0,
					'notify_email_bid' => 0,
					'notify_sms' => 0,
					'notify_turnon_sms' => 0,
                    'subscribe' => 0);
					
if (is_array($row) && count($row) > 0) {
	foreach ($row as $key => $val) {
		if (isset($form_data[$key])) {
			$form_data[$key] = $val;
		}
	}
}

$des = $config_cls->getKey('notification_des');
if (isSubmit()) {
	$form_data['notify_email'] = isset($_POST['field']['notify_email']) ? 1 : 0;
	$form_data['notify_email_bid'] = isset($_POST['field']['notify_email_bid']) ? 1 : 0;
	$form_data['notify_sms'] = isset($_POST['field']['notify_sms']) ? 1 : 0;
	$form_data['notify_turnon_sms'] = isset($_POST['field']['notify_turnon_sms']) ? 1 : 0;
    $form_data['subscribe'] = isset($_POST['field']['subscribe']) ? 1 : 0;


    $agent_cls->update($form_data,'agent_id = '.$_SESSION['agent']['id']);
	if ($agent_cls->hasError()) {
		$message = $agent_cls->getError();
	} else {
        $message = 'Updated Successful.';
	}
}

$smarty->assign('form_data',$form_data);
$smarty->assign('description',$des);

?>