<?php 
include_once 'cms.class.php';
if (!isset($cms_cls) or !($cms_cls instanceof Cms)) {
	$cms_cls = new Cms();
}

include_once ROOTPATH.'/modules/cms/inc/infographic.class.php';

function CMS_creAlias($title,$id){
    //format string
    $title = strtolower($title);

    //remove space
    $title = str_replace("  ",'',$title);
    $title = ($title[0] == ' ')?substr($title,0,1):$title;
    $title = ($title[strlen($title)-1] == ' ')?substr($title,strlen($title) - 1,1):$title;

    //remove special charater
    $specialChar = array('/','\\','{','}','[',']','\'','"','?','*','$','@','#','%','^','&','(',')','+',':','>','<',',','.','|','~','`','!');
    $title = str_replace($specialChar,'',$title);
    $aChar = array('â','ă','á','à','ạ','ã','ậ','ấ','ầ','ẫ','ặ','ẵ','ằ','ắ');$title = str_replace($aChar,'a',$title);
    $eChar = array('ê','ế','ề','ễ','ệ','é','è','ẽ','ẹ');$title = str_replace($eChar,'e',$title);
    $uChar = array('ụ','ù','ú','ũ','ư','ứ','ừ','ữ','ự');$title = str_replace($uChar,'u',$title);
    $oChar = array('o','ọ','ò','õ','ô','ồ','ộ','ỗ','ơ','ờ','ợ','ỡ');$title = str_replace($oChar,'o',$title);
    $iChar = array('ì','ĩ','ị','í','ý','ỳ','ỹ','ỵ');$title = str_replace($iChar,'o',$title);
    $title = str_replace('đ','d',$title);
    $title = str_replace(' ', '-', $title);
    while (CMS_hasAlias($title,$id)){
        $title = $title.'-'.strrand(3);;
    }
    return $title;
}

function CMS_hasAlias($title,$id){
    global $cms_cls;
    $row = $cms_cls->getRow('alias_title = \''.$title.'\' AND page_id != '.$id);
    if (is_array($row) and count($row) > 0){
        return true;
    }
    return false;
}

function CMS_formatAction($action){
    //format string
    $title = strtolower($action);
    //remove space
    $title = str_replace('  ','', $title);
    $title = ($title[0] == ' ')?substr($title,0,1):$title;
    $title = ($title[strlen($title)-1] == ' ')?substr($title,strlen($title) - 1,1):$title;
    $title = str_replace(' ', '-', $title);

    //remove special charater
    $specialChar = array('\\','{','}','[',']','\'','"','*','@','#','%','^','(',')','+',':','>','<',',','|','~','`','!','$');
    $title = str_replace($specialChar,'',$title);
    $aChar = array('â','ă','á','à','ạ','ã','ậ','ấ','ầ','ẫ','ặ','ẵ','ằ','ắ');$title = str_replace($aChar,'a',$title);
    $eChar = array('ê','ế','ề','ễ','ệ','é','è','ẽ','ẹ');$title = str_replace($eChar,'e',$title);
    $uChar = array('ụ','ù','ú','ũ','ư','ứ','ừ','ữ','ự');$title = str_replace($uChar,'u',$title);
    $oChar = array('o','ọ','ò','õ','ô','ồ','ộ','ỗ','ơ','ờ','ợ','ỡ');$title = str_replace($oChar,'o',$title);
    $iChar = array('ì','ĩ','ị','í','ý','ỳ','ỹ','ỵ');$title = str_replace($iChar,'o',$title);
    $title = str_replace('đ','d',$title);

    return $title;
}


/**

**/

function CMS_getTypePage() {
	global $cms_cls;
	$option_ar = array(0 => 'All',
					   10000 => 'Cms page',
					   118 => 'Online Auction',
					   242 => 'Forthcoming Online Auction',
					   322 => 'Passed In',
					   119 => 'For Sale',
					   116 => 'Search');
	return $option_ar;
}

/**
@ function : CMS_getArea
@ in :
@ out :
**/

function CMS_getArea() {
	global $cms_cls;
	$rs = array();
	$rows = $cms_cls->getRows('SELECT display, title FROM '.$cms_cls->getTable('display_position'), true);
	foreach ($rows as $row) {			
		$rs[$row['display']] = $row['title'];		
	}
	return $rs;
}

/**
@ function : CMS_getBlockByMenuId
@ input :
@ output :
**/

function CMS_getBlockByArea($area_id = 0) {
	global $menu_cls, $cms_cls;
	
	$wh_str = 'CONCAT_WS(\'\', \',\', area_ids, \',\') LIKE \'%,'.$area_id.',%\'';
	$row = $cms_cls->getRow('SELECT cms.title, cms.content, `order`
						FROM '.$cms_cls->getTable().' AS cms
						INNER JOIN '.$menu_cls->getTable().' AS menu ON cms.parent_id = menu.menu_id
						WHERE menu.active = 1 AND '.$wh_str, true);
						
	if (is_array($row) && count($row) > 0) {
		return $row;
	}					
	
	return array();
}
?>