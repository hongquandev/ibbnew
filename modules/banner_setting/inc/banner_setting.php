<?php 
include_once 'banner_setting.class.php';

if (!isset($banner_setting_cls) || !($banner_setting_cls instanceof BannerSetting)) {
	$banner_setting_cls = new BannerSetting();
}

function getSettingBanner($key = '') {
	global $banner_setting_cls;
	$sql = 'Select * from '.$banner_setting_cls->getTable().' Where keyword = "'.$key.'"';
	$row = $banner_setting_cls->getRows($sql ,true);
    if (is_array($row) > 0 && count($row) > 0) {
		return (int)$row[0]['setting_value'];
	}				
		
}

?>