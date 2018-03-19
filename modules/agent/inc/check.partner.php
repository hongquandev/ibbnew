<?php
/* 
	Author : StevenDuc
	Skype : stevenduc21
	Company : GOS
*/
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once 'agent.php';
if (isset($_SESSION['agent']['id'])) {
	$row = $agent_cls->getRow('agent_id = '.$_SESSION['agent']['id']);
		$db_checkpartner = array();
	if (is_array($row) and count($row) > 0) {
		$db_checkpartner = $row;
	}
		$smarty->assign('db_checkpartner',$db_checkpartner);
}		
?>