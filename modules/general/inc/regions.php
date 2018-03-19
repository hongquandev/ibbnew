<?php
//include_once ROOTPATH.'/modules/gerenal/inc/regions.class.php';
include_once 'regions.class.php';
$region_cls = new Regions();

function R_getItemFromCode($code = '') {
	global $region_cls;
	$row = $region_cls->getRow('code = \''.$code.'\'');
	if (is_array($row) && count($row) > 0) {
		return $row;
	}
	return array();
}
function R_getItemFromCondition($where = ''){
    global $region_cls;
	$row = $region_cls->getRow($where);
	if (is_array($row) && count($row) > 0) {
		return $row;
	}
	return array();
}

function R_getOptions($parent_id = 0 , $def = array()){
	global $region_cls;
	//$options = (is_array($def) and count($def) > 0 )  ? $def: array(0 => 'Select...');
	$options = $def;
	$rows = $region_cls->getRows('SELECT region_id, name FROM '.$region_cls->getTable().' WHERE parent_id = '.$parent_id.' AND active = 1 ORDER BY `region_id` ASC', true);
	if($region_cls->hasError()){
		$message = $region_cls->getError();
	} else if (is_array($rows) and count($rows) > 0){
		foreach ($rows as $row) {
			$options[$row['region_id']] = $row['name'];
		}
	}
	return $options;
}


function subRegion($def = array()) {
	global $region_cls;
	
	$options = (is_array($def) and count($def) > 0 )  ? $def: array(0 => 'Select...');
	//$options = '';
	$rows = $region_cls->getRows('SELECT region_id, name FROM '.$region_cls->getTable().' WHERE parent_id = 1 AND active = 1 ORDER BY `region_id` ASC', true);
	
	if($region_cls->hasError()){
		$message = $region_cls->getError();
	} else if (is_array($rows) and count($rows) > 0){
		foreach ($rows as $row) {
			$options[$row['region_id']] = $row['name'];
		}
	}

	return $options;
	
}

// WIth Using At Step2

function R_getOptionsStep2($parent_id = 0 , $def = array()){
	global $region_cls;
	
	//$options = (is_array($def) and count($def) > 0 ) ;   ? $def: array(0 => 'Select...');
	$options = '';
	$rows = $region_cls->getRows('SELECT region_id, name FROM '.$region_cls->getTable().' WHERE parent_id = '.$parent_id.' AND active = 1 AND region_id = 1 ORDER BY `order` ASC', true);
	
	if($region_cls->hasError()){
		$message = $region_cls->getError();
	} else if (is_array($rows) and count($rows) > 0){
		foreach ($rows as $row) {
			$options[$row['region_id']] = $row['name'];
		}
	}

	return $options;
}
// ENd 

?>