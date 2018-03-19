<?php
$message = '';
$key = getParam('key');
if (strlen($key) > 0) {
	$row = $agent_cls->getRow("confirm = '".$agent_cls->escape($key)."'");
	if (is_array($row) && count($row) > 0) {
		$agent_cls->update(array('is_active' => 1),"confirm = '".$agent_cls->escape($key)."'");
		$message = 'Thank you! Your account has been activated. Now you can wait 3s to login to your account and begin using it.';
        $_SESSION['login-active']= $row['email_address'];
	} else {
		$message = 'Your information is invalid.';
	}
}
$smarty->assign('message',$message);
$smarty->assign('meta_refresh', '<META HTTP-EQUIV=Refresh CONTENT="2; URL='.ROOTURL.'/?module=agent&action=login'.'">');

?>