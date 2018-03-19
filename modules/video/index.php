<?php
include_once 'inc/video.php';
$action = getParam('action', '');
$row = $video_cls->getRow('video_id > 0');
if (is_array($row) && isset($row['video_file'])) {
	//459,276
	//width="560" height="315"
	$videoFile = preg_replace('/(width="\d+")/i', 'width="460"', $row['video_file']);
	$videoFile = preg_replace('/(height="\d+")/i', 'height="276"', $videoFile);
	
	$row['video_file'] = $videoFile;
}

$smarty->assign('row', $row);
$smarty->assign('action', $action);
$smarty->assign('ROOTPATH', ROOTPATH);
?>