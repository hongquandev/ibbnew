<?php
header("Content-Type: application/xml; charset=utf-8");
include_once '../../configs/config.inc.php';
include_once ROOTPATH.'/includes/functions.php';
include_once ROOTPATH.'/admin/functions.php';
include_once ROOTPATH.'/includes/checkingform.class.php';
include_once ROOTPATH.'/modules/newsletter/inc/newsletter.php';
include_once ROOTPATH.'/includes/smarty/Smarty.class.php';
include_once ROOTPATH.'/modules/banner/inc/banner.php';

$smarty = new Smarty; 
if(detectBrowserMobile()){ 
    $smarty->compile_dir = ROOTPATH.'/m.templates_c/';
}else{
    $smarty->compile_dir = ROOTPATH.'/templates_c/';
}
$message = '';

//$id = getParam('ID');
$action = $_GET['action'];

switch ($action) {
	default: 
	break;
	case 'checkposis':
		 //die(json_encode(__bannerCheckExPosition()));
		 __bannerCheckExPosition();
	break;
}


function __bannerCheckExPosition() {
	global $banner_cls, $smarty;
	$position = getParam('position', 0);
	$areas = getParam('areas', 0);
	$page = getParam('page', 0);
	$data = array();
	if ($position > 0) {
		$sql = 'SELECT * FROM '.$banner_cls->getTable().'  
							 WHERE position = '.$position.' AND display = '.$areas.'
							 AND page_id = '.$page.'';
		$row = $banner_cls->getRow($sql,true);
		//die($sql);					 
		if (is_array($row) && count($row) > 0 ) {
			//if ($row['display'] == 1) {
				//echo 'This Position was selected in right banner id '.$row['banner_id'];
			//} if ($row['display'] == 2) {
			//	echo 'This Position was selected in center banner id '.$row['banner_id'];
			//}
			echo 'This Position was selected in banner id '.$row['banner_id'].'';
		} else {
				echo '';
			//echo 'Position Is Null';
		}					 
	
	}
	
	/*$data['data'] = $smarty->fetch(ROOTPATH.'/modules/banner/templates/banner.popup.showPos.tpl');
	return $data; */
	
}

?>