<?php
require '../../configs/config.inc.php';
require ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
include ROOTPATH.'/admin/functions.php';
include 'inc/background.php';
include_once ROOTPATH.'/modules/cms/inc/cms.php';
include_once ROOTPATH.'/modules/menu/inc/menu.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';

if (!isset($config_cls) || !($config_cls instanceof Config)) {
    $config_cls = new Config();
}

define('SITE_TITLE',$config_cls->getKey('site_title'));
$smarty->assign('site_title_config',$config_cls->getKey('site_title'));

//restrict4AjaxBackend();
$action = getParam('action');
$dir = ROOTPATH.'/store/uploads/background/';
switch ($action){
	case 'load-banner':
		die(json_encode(__loadBanner()));
	break;
}

function __loadBanner() {
	global $theblock_banner_cls, $menu_cls;
	$id = (int)getParam('id', 0);
	$link_page = getParam('link_page');
	$url = MEDIAURL.'/store/uploads/background/img/';
	$rs = array('error' => true, 'content' => array('link_header' => '', 'link_footer' => ''));
	$wh_str = ' AND 1 = 2';
	if ($id == 0 && strlen($link_page) > 0) {
		$row = $menu_cls->getCRow(array('menu_id'), 'menu.url = \''.trim($menu_cls->escape($link_page), '/').'\'');
		if (isset($row['menu_id']) && $row['menu_id'] > 0) {
			$wh_str = ' AND CONCAT_WS(\'\', \',\', cms_page, \',\') LIKE \'%,'.$row['menu_id'].',%\'';
			$rs['error'] = false;
		}
	} else if ($id > 0 && PE_isTheBlock($id)) {
		$wh_str = ' AND 1 = 1';
		$rs['error'] = false;
	}
	
	$row = $theblock_banner_cls->getCRow(array('link_header', 'link_footer'), 'active = 1'.$wh_str);
	//$rs['test'] = $link_page ;
	if (is_array($row) && count($row) > 0) {
		$rs['content'] = array('link_header' => $url.$row['link_header'], 'link_footer' => $url.$row['link_footer']);
	}
	return $rs;
}
?>