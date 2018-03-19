<?php
	$action = isset($_GET['action']) ? $_GET['action'] : '';
	$smarty->assign('action', $action);
	
?>