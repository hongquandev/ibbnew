<?php 
include_once 'notes.class.php';
if (!isset($note_cls) or !($note_cls instanceof Notes)) {
	$note_cls = new Notes();
}

function Note_count($wh_str = '1') {
	global $note_cls;
	$num = 0;
	$row = $note_cls->getRow('SELECT COUNT(*) AS num 
								FROM '.$note_cls->getTable().'
								WHERE '.$wh_str,true);
	if (is_array($row) && count($row) > 0) {
		return $row['num'];
	}								
	return $num;
}
?>