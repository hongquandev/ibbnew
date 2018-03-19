<?php
require '../../configs/config.inc.php';
require ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
include ROOTPATH.'/includes/validate.class.php';
include_once ROOTPATH.'/modules/menu/inc/menu.php';

$action = getParam('action');

if (!restrict4AjaxFrontend()) {
	die('!Permission.');
}

switch ($action) {
	case 'get-menu':
		die(json_encode(__getMenuByArea()));
	break;
}

/**
@ function : __getMenuByArea
**/

function __getMenuByArea() {
	global $menu_cls;
	$out = array('error' => 0, 'content' => array(), 'target' => getParam('target'));
	$area_id = getParam('area_id', 0);
	$out['content'] = Menu_getByBannerAreaId(0, getParam('area_id', 0));
	return $out;							
}
