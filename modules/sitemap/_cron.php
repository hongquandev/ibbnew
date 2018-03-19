<?php
include_once '../../configs/config.inc.php';
include_once ROOTPATH.'/includes/functions.php';
include_once ROOTPATH.'/includes/model.class.php';
include_once ROOTPATH.'/modules/configuration/inc/config.class.php';


include_once ROOTPATH.'/modules/menu/inc/menu.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/includes/pagging.class.php';

if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
	$pag_cls = new Paginate();
}

$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');
$menu_ar = Menu_getList(0, 0, str_repeat(' &nbsp; ', 2));
if (is_array($menu_ar) && count($menu_ar) > 0) {
	foreach ($menu_ar as $row) {
		$url = $xml->addChild('url');
		$url->addChild('loc', trim(ROOTURL, '/').'/'.trim($row['url'], '/'));
		$url->addChild('lastmod', date('Y-m-d'));
		$url->addChild('changefreq', 'daily');
		$url->addChild('priority', '0.5');
	}
}

$property_ar = Property_getListForSitemap();
if (isset($property_ar) && count($property_ar) > 0) {
	foreach ($property_ar as $row) {
		$url = $xml->addChild('url');
		$url->addChild('loc', $row['detail_link']);
		$url->addChild('lastmod', date('Y-m-d'));
		$url->addChild('changefreq', 'daily');
		$url->addChild('priority', '0.5');
	}
}

$file_name = ROOTPATH.'/sitemap.xml';
$handle = fopen($file_name, 'wb');
chmod($file_name, 0777);
fputs($handle, $xml->asXML());
fclose($handle);
