<?php
include_once ROOTPATH.'/modules/general/inc/ape_data.class.php';
$ape_data_cls = new Ape_data();

/**
@ method : ape_insert
**/

function ape_insert($args = array()) {
	global $ape_data_cls;
	if (isset($args['key']) && strlen($args['key']) > 0) {
		$row = $ape_data_cls->getCRow(array('`key`'), '`key` = \''.$ape_data_cls->escape($args['key']).'\'');
		if (isset($row['key']) && strlen($row['key']) > 0) {
			$ape_data_cls->update(array('data' => $args['data']), '`key` = \''.$ape_data_cls->escape($args['key']).'\'');
		} else {
			$ape_data_cls->insert($args);
		}
	}
}

/**
@ method : ape_delete
**/

function ape_delete($key = '') {
	global $ape_data_cls;
	$ape_data_cls->delete('`key` = \''.$ape_data_cls->escape($key).'\'');
}

function ape_get($key = '') {
	global $ape_data_cls;
	$row = $ape_data_cls->getCRow(array('`key`'), '`key` = \''.$ape_data_cls->escape($key).'\'');
	if (isset($row['key'])) {
		return $row['key'];
	} else {
		return array();
	}
}

