<?php
if (isSubmit()) {
	$message = configPostDefault();
}



$form_action = '?module=configuration&action='.$action.'&token='.$token;
$options_notification_schedule = array(30 => '30 minutes',
										60 => '1 hour',
										60*3 => '3 hours',
										60*6 => '6 hours',
										60*12 => '12 hours',
										60*24 => '1 day',
										60*24*2 => '2 days',
										60*24*5 => '5 days');
$smarty->assign('options_notification_schedule',$options_notification_schedule);

$options_status_notification_schedule = array(0 => 'Disable',1 => 'Enable');
$smarty->assign('options_status_notification_schedule',$options_status_notification_schedule);
$show = getParam('show','');

if( $show == 'full')
{
    $smarty->assign('isShow',true);
}
else{
    $smarty->assign('isShow',false);
}
?>