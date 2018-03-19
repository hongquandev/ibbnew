<?php
	include_once ROOTPATH.'/modules/property/inc/property.home.php';
	// DUc Coding Call file Check User Login Is Vendor OR Buyer OR Partner
	include_once ROOTPATH.'/modules/agent/inc/check.partner.php';
	// End Duc Coding
	$smarty->assign('ROOTPATH',ROOTPATH);	
	$action = getQuery('action');
	$smarty->assign('action', $action);


?>