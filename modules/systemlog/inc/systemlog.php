<?php 
include_once 'systemlog.class.php';

if (!isset($systemlog_cls) or !($systemlog_cls instanceof SystemLog)) {
	$systemlog_cls = new SystemLog();
}

?>