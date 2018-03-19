<?php
require '../../configs/config.inc.php';
require '../../includes/smarty/Smarty.class.php';
$id = (int)$_GET['id'];
switch ($_GET['action']) {
    case 'delete':
        mysql_query("DELETE FROM `faq`
								WHERE `faq_id` = $id");
        // Write System Logs
        mysql_query("INSERT INTO `systemlogs` SET  `Updated`='" . date("Y-m-d H:i:s") . "', `Action`='DELETE',  `Detail`='FAQ WHERE ID : {$_GET['id']} ',`UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '" . $_SERVER['REMOTE_ADDR'] . "'");
        break;
    case 'active':
        mysql_query("UPDATE  `faq`
							SET active = 1
								WHERE `faq_id` = $id");
        // Write Logs
        mysql_query("INSERT INTO `systemlogs` SET  `Updated`='" . date("Y-m-d H:i:s") . "', `Action`='UPDATE',  `Detail`='FAQ SET STATUS : Enabled ',`UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '" . $_SERVER['REMOTE_ADDR'] . "'");
        break;
    case 'inactive':
        mysql_query("UPDATE  `faq`
							SET active = 0
								WHERE `faq_id` = $id");
        // Write Logs
        mysql_query("INSERT INTO `systemlogs` SET  `Updated`='" . date("Y-m-d H:i:s") . "', `Action`='UPDATE', `Detail`='FAQ SET STATUS : Disabled ',`UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '" . $_SERVER['REMOTE_ADDR'] . "'");
        break;
}
?>
