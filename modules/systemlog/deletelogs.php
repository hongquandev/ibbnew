<?php 
	
	header("Content-Type: application/xml; charset=utf-8");
	require '../../configs/config.inc.php';
    require '../../includes/smarty/Smarty.class.php';
    include_once '../../includes/functions.php';
	$smarty = new Smarty;  
	if (detectBrowserMobile()) {
            $smarty->compile_dir = '../../m.templates_c/';
        } else {
            $smarty->compile_dir = '../../templates_c/';
        }

	$smarty->cache_dir = 'cache';
	$smarty->compile_check = true;
	$smarty->caching = true; //caching
	
	
	if ($_SESSION['language'] == 'vn') {
	
		include 'lang/systemlog.vn.lang.php';
	}else{
		include 'lang/systemlog.en.lang.php';
	}
	
		switch ($_GET['action']) {
			case 'delete':
			
				mysql_query("DELETE FROM `systemlogs`
								WHERE `ID` = '{$_GET['ID']}'"); 							
			break; 
			
			
	 
}		

	
	
		
?>
