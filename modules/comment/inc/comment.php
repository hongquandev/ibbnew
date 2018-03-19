<?php 
include_once 'comments.class.php';
if (!isset($comment_cls) or !($comment_cls instanceof Comments)) {
	$comment_cls = new Comments();
}

function Comment_count($property_id = 0) {
	global $comment_cls;
	$num = 0;
	$row = $comment_cls->getRow('SELECT COUNT(*) AS num FROM '.$comment_cls->getTable().' WHERE property_id = '.$property_id,true);
	if (is_array($row) && count($row) > 0) {
		return $row['num'];
	}
	return $num;
}
?>