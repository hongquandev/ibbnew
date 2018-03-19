<?php
$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = (int)$_GET['id'];
switch($action) {
	
	case 'delete' :
		mysql_query("DELETE FROM `email_alert`
								WHERE `email_id` = $id"); 	
	break;
}
?>