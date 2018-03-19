<?php
include_once ROOTPATH.'/modules/menu/inc/menu.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/includes/pagging.class.php';

if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
	$pag_cls = new Paginate();
}

$p = getParam('p', 0);
if ($p <= 0) {
	$p = 1;
}
$smarty->assign(array('menu_ar' => Menu_getList(0, 0, str_repeat(' &nbsp; ', 2)),
				'property_ar' => Property_getList('', $p, 50, '', '/?module=sitemap')));	
