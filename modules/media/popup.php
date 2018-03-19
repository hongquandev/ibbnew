<?php
session_start();
require '../../configs/config.inc.php';
require ROOTPATH.'/includes/functions.php';
require ROOTPATH.'/includes/smarty/Smarty.class.php';
$smarty = new Smarty;  
if(detectBrowserMobile()){ 
    $smarty->compile_dir = ROOTPATH.'/m.templates_c/';
}else{
    $smarty->compile_dir = ROOTPATH.'/templates_c/';
}

$action = getParam('action');
switch ($action) {
	case 'upload':
		echo $smarty->fetch(ROOTPATH.'/modules/media/templates/media.popup.tpl');
	break;
}
?>