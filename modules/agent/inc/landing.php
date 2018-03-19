<?php
include_once ROOTPATH.'/modules/menu/inc/menu.php';
include_once ROOTPATH.'/modules/cms/inc/cms.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';

$type_ar = AgentType_getOptions();
$data = array();
if (is_array($type_ar) && count($type_ar) > 0) {
	foreach ($type_ar as $type) {
		$key = Menu_areaByKey('landing-'.$type);
		if ($key > 0) {
			$item = CMS_getBlockByArea($key);
			if (is_array($item) && count($item) > 0) {
				$item['key'] = $type;
				$data[$item['order']] = $item;
			}
		}
	}
}
ksort($data);
$smarty->assign('data', $data);
?>