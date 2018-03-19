<?php 
include_once 'video.class.php';
if (!isset($video_cls) or !($video_cls instanceof Video)) {
	$video_cls = new Video();
}

function getVideo() {
	global $video_cls;
	$rs = '';
	$row = $video_cls->getRow('video_id > 0');
	if (is_array($row) && isset($row['video_file'])) {
		//459,276
		//width="560" height="315"
		$videoFile = preg_replace('/(width="\d+")/i', 'width="460"', $row['video_file']);
		$videoFile = preg_replace('/(height="\d+")/i', 'height="276"', $videoFile);
		$rs = $videoFile;
	}
	return $rs;
}
?>