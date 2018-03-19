<?php 
	
		if ($_SESSION['language'] == 'vn') {
			include 'lang/propertystatistics.vn.lang.php';
		}else{
			include 'lang/propertystatistics.en.lang.php';
		}
		
	//	$result= mysql_query("SELECT * FROM `cms_page`");
	//	while($row=mysql_fetch_assoc($result)){
		//	$cms[$row['page_id']] = $row['page_id'];
	//	} 
		
		// assign Part;
		
		$smarty->assign('part', "../modules/propertystatistics/");
		$smarty->assign('imagepart' , "../modules/general/templates/images/");
		if(isset($_GET['action'])) {
			
			$smarty->assign('action', $_GET['action']);		 	
		}

?>