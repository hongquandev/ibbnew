<?php
include_once ROOTPATH.'/modules/infographic/inc/infographic.php';
include_once ROOTPATH.'/modules/menu/inc/menu.php';

$uri = getParam('uri', '');
$action = getParam('action', '');

$smarty->assign('action', $action);
$smarty->assign('ROOTPATH', ROOTPATH);
?>