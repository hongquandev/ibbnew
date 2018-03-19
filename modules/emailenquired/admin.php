<?php 
		if ($_SESSION['language'] == 'vn') {
			include 'lang/emailenquired.vn.lang.php';
		}else{
			include 'lang/emailenquired.en.lang.php';
		}
		// assign Part;
		$smarty->assign('part', "../modules/emailenquired/");
		$smarty->assign('imagepart' , "../modules/general/templates/images/");
		if(isset($_GET['action'])) {
			$smarty->assign('action', $_GET['action']);
		}
			
?>