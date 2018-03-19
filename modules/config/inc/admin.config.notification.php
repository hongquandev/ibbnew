<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['fields']) && is_array($_POST['fields'])) {
		foreach ($_POST['fields'] as $key => $val) {
		
			$key = $config_cls->escape($key);
			$val = $config_cls->escape($val);	
			
			$row = $config_cls->getRow("`key` = '".$key."'");
			if (is_array($row) && count($row) > 0) {//UPDATE
				$config_cls->update(array('value' => $val),"`key` = '".$key."'");
				$message = 'Updated successful.';
			} else {//NEW
				$config_cls->insert(array('key' => $key, 'value' => $val));
				$message = 'Added successful.';
			}
		}
	}
}



$form_action = '?module=config&action='.$action.'&token='.$token;
$options_notification_schedule = array(30 => '30 minutes',
										60 => '1 hour',
										60*3 => '3 hours',
										60*6 => '6 hours',
										60*12 => '12 hours',
										60*24 => '1 day',
										60*24*2 => '2 days',
										60*24*5 => '5 days');
$smarty->assign('options_notification_schedule',$options_notification_schedule);
?>