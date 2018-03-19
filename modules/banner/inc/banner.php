<?php 
include_once 'banner.class.php';
include_once ROOTPATH.'/modules/cms/inc/cms.php';
include_once ROOTPATH.'/modules/menu/inc/menu.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';

if (!isset($banner_cls) or !($banner_cls instanceof Banner)) {
	$banner_cls = new Banner();
}

function B_valid($path, $display) {
	$rs = array();
	if (is_file($path)) {
		$file_info_ar = getimagesize($path);
		if ($display == 2) {
			if ($file_info_ar[0] > 616 || $file_info_ar[1] > 200) {
				$rs[] = 'Width or height image center area max size 616, 200.';
			} 
		} else if ($file_info_ar[0] > 280 ||  $file_info_ar[1] > 500) {
			$rs[] = 'Width or height image right area max size 280, 500.';
		} 
		
		$mime_ar = array('image/jpeg', 'image/pjpeg', 'image/gif', 'image/png', 'image/x-png', 'image/bmp', 'image/x-ms-bmp');
		if (!in_array($file_info_ar['mime'], $mime_ar)) {
			//$rs[] = 'You must upload a file with one of the following extensions: '.implode(', ', $mime_ar);
		}
	}
	return $rs;
}

/**
@ function : B_checkErrorAgent
**/

function B_checkErrorAgent($agent_id) {
	global $banner_cls, $agent_cls;
	$banner_id = (int)$_GET['id'];
	$sql = 'SELECT * 
			FROM '.$banner_cls->getTable().' AS a 
			INNER JOIN '.$agent_cls->getTable().' AS b ON a.agent_id = b.agent_id AND a.agent_id ='.$agent_id.' AND a.banner_id = '.$banner_id;
	$rowAgent = $banner_cls->getRow($sql,true);
	if (is_array($rowAgent) && count($rowAgent) > 0) {
		return true;
	}
	return false;	
}

/**
@ function : B_getPage
**/
// 'll be remove
function B_getPage($default){
    global $cms_cls, $menu_cls;
    if ($default != ''){
        $options[0] = $default;
    }
	
    $rows = $cms_cls->getRows('SELECT c.*,
                               (SELECT m.title FROM '.$menu_cls->getTable().' AS m
                                WHERE m.menu_id = c.parent_id
                               ) AS parent_name

                               FROM '.$cms_cls->getTable().' AS c
                               WHERE c.type = 0 AND c.title != "" AND c.page_id != 106 AND c.page_id != 107 
							   AND c.page_id != 108 AND c.page_id != 138 AND c.page_id != 139
                               ORDER BY c.parent_id',true);
    if (is_array($rows) and count($rows)> 0){
        foreach ($rows as $row){
            $row['title_name'] = $row['title_frontend'] == ''?$row['title']:$row['title_frontend'];
            $options[$row['page_id']] = $row['parent_name'].' >> '.$row['title_name'];
        }
    }
    return $options;
}

/**
@ function : B_getOptionsDisplay
**/

function B_getOptionsDisplay(){
    global $banner_cls;
    $rows = $banner_cls->getRows('SELECT * FROM '.$banner_cls->getTable('display_position'),true);
    if (is_array($rows) and count($rows)> 0){
        foreach ($rows as $row){
            $options[$row['display_id']] = $row['title'];
        }
    }
    return $options;
}

/**
@ function : B_getOptionsPos
**/

function B_getOptionsPos($value){
    for($i = 1;$i<$value;$i++){
       $options[$i] = $i;
    }
    return $options;
}

/**
@ function : B_delete
**/

function B_delete($banner_id = 0) {
	global $banner_cls;
	if ((int)$banner_id > 0) {
		$row = $banner_cls->getRow('banner_id = '.(int)$banner_id);
		if (is_array($row) && count($row) > 0) {
			$file_ar = explode('/',$row['banner_file']);
			$file_name = $file_ar[count($file_ar)-1];
			B_deleteImage($file_name);
			$banner_cls->delete('banner_id = '.(int)$banner_id);
			return true;	
		}
	}
	return false;
}

/**
@ function : B_deleteImage
@ in : file_name
**/

function B_deleteImage($file_name) {
	@unlink(ROOTPATH.'/store/uploads/banner/images/'.$file_name);
	@unlink(ROOTPATH.'/store/uploads/banner/images/thumbs/'.$file_name);
	@unlink(ROOTPATH.'/store/uploads/banner/images/thumbs/dashboard/'.$file_name);
	@unlink(ROOTPATH.'/store/uploads/banner/images/thumbs/mybanner/'.$file_name);
}

/**
@ function : B_getNav
@ in : $direct = next|prev, $id 
**/

function B_getNav($direct = '', $id = 0) {
	global $banner_cls, $token;
	$rs = '';
	$wh_str = $direct == 'next' ? 'banner_id > '.(int)$id.' ORDER BY banner_id ASC' : 'banner_id < '.(int)$id.' ORDER BY banner_id DESC';
	$row = $banner_cls->getCRow(array('banner_id'), 'AND '.$wh_str);
	if (is_array($rownext) and count($rownext) > 0) {
		$rs = 'index.php?module=banner&action=edit&id='.$row['banner_id'].'&token='.$token;
	}
	return $rs;
}
?>