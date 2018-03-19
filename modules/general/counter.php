<?php

/*
  Author : StevenDuc
  Company : GOS
 */
include_once ROOTPATH.'/modules/banner/inc/banner.php';
$id = (int)getParam('id',0);
$rows = $banner_cls->getRow('SELECT * FROM '.$banner_cls->getTable().' WHERE banner_id = '.$id.'',true);
if (count($rows) > 0) {
	redirect('http://'.$rows['url']);
}

?>