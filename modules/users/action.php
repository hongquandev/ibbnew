<?php 
	header("Content-Type: application/xml; charset=utf-8");
	require '../../configs/config.inc.php';
    require '../../includes/smarty/Smarty.class.php';
    require_once '../../includes/functions.php';
	$smarty = new Smarty;  
	if(detectBrowserMobile()){ 
            $smarty->compile_dir = '../../m.templates_c/';
        }else{
            $smarty->compile_dir = '../../templates_c/';
        }

		
switch ($_GET['action']) {
	case 'delete':
		mysql_query("DELETE FROM agent
						WHERE `agent_id` = '{$_GET['ID']}'"); 			
		
	break;
	
	case 'active':
		mysql_query("UPDATE  agent
					SET is_active = 1
						WHERE `agent_id` = '{$_GET['ID']}'");
		 
	break;
	
	case 'inactive':
		mysql_query("UPDATE  agent
						SET is_active = 0
						WHERE `agent_id` = '{$_GET['ID']}'");
		 
	break;
}		


	
?>