<?php
include_once ROOTPATH.'/modules/banner/inc/banner.php';
include_once ROOTPATH.'/modules/cms/inc/cms.php';
include_once ROOTPATH.'/modules/menu/inc/menu.php';
include_once ROOTPATH.'/modules/banner_setting/inc/banner_setting.php';

function getBanner($display = 1, $url = '', $wh_str = '') {
	global $banner_cls, $menu_cls;
	$rs = array();
	$date = date('Y-m-d');
	$wh_str = 'a.status = 1 
			AND a.agent_status = 1 
			AND a.display = '.$display.' 
			AND a.pay_status = 2 
			AND a.date_from <= "'.$date.'" 
			AND "'.$date.'" <= a.date_to '.$wh_str;

	if ($url != 'abort') {
		$url = trim($menu_cls->escape($url), '/');
		$row = $menu_cls->getCRow(array('menu_id', 'banner_area_ids'), '(url = \''.$url.'\' OR url = \'/'.$url.'\')');
		if (!is_array($row) || count($row) == 0) {
			return $rs;
		}
		$wh_str = 'CONCAT_WS(\'\', \',\', a.page_id, \',\') LIKE \'%,'.$row['menu_id'].',%\' AND '.$wh_str;
	}
	
	$rows = $banner_cls->getRows('SELECT a.page_id , a.banner_id, a.url, a.banner_file 
								 FROM '.$banner_cls->getTable().' AS a										
								 WHERE '.$wh_str.'			 
								 ORDER BY a.position ASC, RAND()', true);
	//echo $banner_cls->sql;
	if (is_array($rows) && count($rows) > 0) {
		foreach($rows as $row) { 
			$rs[] = array('file' => $row['banner_file'], 'url' => $row['url'], 'banner_id' => $row['banner_id']);
			$banner_cls->update(array('views' => array('fnc' => 'views + 1')), 'banner_id = '.$row['banner_id']);
            Report_bannerAdd($row['banner_id'],'view',false);
		}
	}
	
	return $rs;
}
?>