<?php 
		if ($_SESSION['language'] == 'vn') {
			include 'lang/pagestatistics.vn.lang.php';
		}else{
			include 'lang/pagestatistics.en.lang.php';
		}
		
	//	$result= mysql_query("SELECT * FROM `cms_page`");
	//	while($row=mysql_fetch_assoc($result)){
		//	$cms[$row['page_id']] = $row['page_id'];
	//	} 
		
		// assign Part;
		
		$smarty->assign('part', "../modules/pagestatistics/");
		$smarty->assign('imagepart' , "../modules/general/templates/images/");
		if(isset($_GET['action'])) {
			
			$smarty->assign('action', $_GET['action']);		 	
		}

?>