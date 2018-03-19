<?php
include_once ROOTPATH.'/modules/general/inc/timetable.class.php';
if (!isset($timetable_cls) || !($timetable_cls instanceof Timetable)) {
	$timetable_cls = new Timetable();
}
$key_time = 'server';
$timetable_cls->update(array('begin_time' => date('Y-m-d H:i:s')),'`key`=\''.$key_time.'\'');


 
