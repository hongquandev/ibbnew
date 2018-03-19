<?php
include_once ROOTPATH.'/modules/agent/inc/agent.php';

/*
$rows = $agent_cls->getRows('SELECT COUNT(*) AS num, DATE_FORMAT(creation_time,\'%Y-%m\') AS time 
				FROM '.$agent_cls->getTable().' 
				GROUP BY DATE_FORMAT(creation_time,\'%Y-%m\')',true);
if (is_array($rows) && count($rows) > 0) {
	$smarty->assign('agent_report',$rows);
}
*/
?>