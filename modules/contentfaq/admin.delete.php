<?php 
	require '../../configs/config.inc.php';
    require '../../includes/smarty/Smarty.class.php';
	
	$id = (int)$_GET['id'];
		
		switch ($_GET['action']) {
			case 'delete':	
				mysql_query("DELETE FROM `content_faq`
								WHERE `content_id` = $id"); 					
				// Write System Logs
				
				mysql_query("INSERT INTO `systemlogs` SET  `Updated`='".date("Y-m-d H:i:s")."', `Action`='DELETE',  `Detail`='CONTENT FAQ WHERE ID : {$_GET['id']} ',`UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '".$_SERVER['REMOTE_ADDR']."'");		
								
			break; 
			
}		
	
?>
