<?php
include_once ROOTPATH.'/modules/banner/parse.php';
$smarty->assign('ROOTURL',ROOTURL);
$smarty->assign('ROOTPATH',ROOTPATH);
echo $smarty->fetch(ROOTPATH.'/modules/fb/templates/fb.tpl');
?>