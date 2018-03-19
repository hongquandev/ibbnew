<?php 
	require '../../configs/config.inc.php';
    require '../../includes/smarty/Smarty.class.php';
    require_once '../../includes/functions.php';
	$smarty = new Smarty;  
        if(detectBrowserMobile()){ 
            $smarty->compile_dir = '../../m.templates_c/';
        }else{
            $smarty->compile_dir = '../../templates_c/';
        } 

	$result=mysql_query("SELECT *
								FROM `cms_page` 
								WHERE  page_id  = '{$_GET['ID']}'");  	
	
		// H:i:s
	function changeFormatDate($cdate) {	
		list($month,$day,$year)=explode("/",$cdate);
			return $year."-".$month."-".$day;
} 

	// Search And Result 
	 if (isset($_POST['submit'])) {
		$date = $_POST['date'];
		$id = $_GET['ID'];
		$dateformat = changeFormatDate($date);
	//	echo $$dateformat;
		
		$ex = 	mysql_query("SELECT title, views, page_id from cms_page 
						 WHERE dateviews = '$dateformat' and page_id = $id ");
	
		$viewsearch = mysql_fetch_assoc($ex);	
	
		$smarty -> assign('viewsearch', $viewsearch);	
		
	}
									
	$row=mysql_fetch_assoc($result); 
	$smarty->assign('row', $row);
		
	$smarty->template_dir = 'templates/';
	$smarty->display('admin.searchpage.tpl'); 
	
	
?>