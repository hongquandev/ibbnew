<?php
include_once 'options.class.php';
$options_cls = new Options();

function getOptions(){
	global $options_cls;
	
	$rs = array();
	$rows = $options_cls->getRows('1 ORDER BY `order` ASC');
	if(is_array($rows) and count($rows)){
		foreach($rows as $row){
			$rs[$row['option_id']] = $row;
		}
	}
	return $rs;
}
?>