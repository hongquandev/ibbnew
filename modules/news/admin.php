<?php 
if ($_SESSION['language'] == 'vn') {
	include 'lang/news.vn.lang.php';
}else{
	include 'lang/news.en.lang.php';
}

$smarty -> assign("action",$_GET['action']);	 

switch ($_GET['action']) {
	
	default: 
		include 'inc/news.list.php';
	break;
	
	case 'add':  
		include 'inc/news.php';
	break;
	
}



?>