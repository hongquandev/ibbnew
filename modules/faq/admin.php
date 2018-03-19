<?php 			
	$id = (int)$_GET['ID'];
	switch ($_GET['action']) {
		default: 
			
		break;
		case 'manager':  
				include'inc/admin.faq.manager.php';
		break;
		case 'add':  
				include'inc/admin.faq.add.php';
		break;		
		case 'edit':
				include'inc/admin.faq.edit.php';	
				include'inc/admin.faq.home.php';	
		break;
		
	}
	$smarty->assign('action', $_GET['action']);			
	$smarty->assign('ROOTPATH',ROOTPATH);
	
?>