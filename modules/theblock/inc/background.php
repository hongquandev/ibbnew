<?php
include_once 'background.class.php';
include_once ROOTPATH.'/modules/agent/inc/company.php';
if (!isset($background_cls) || !($background_cls instanceof Background)) {
	$background_cls = new Background();
}

include_once 'theblock_banner.class.php';
if (!isset($theblock_banner_cls) || !($theblock_banner_cls instanceof Theblock_Banner)) {
	$theblock_banner_cls = new Theblock_Banner();
}

function TB_getBackgroundStatus($background_id){
    global $background_cls;
    $row = $background_cls->getRow('background_id = '.$background_id);
    if (is_array($row) and count($row)> 0){
        return $row['active'];
    }
    return '';
}

/**
@ function : Bg_uploadMedia
**/

function Bg_uploadMedia($name) {
	global $dir;
	$rs = array('error' => false, 'msg' => '', 'file_name' => '');
	$allowedType = array('image/jpeg', 'image/jpg','image/png', 'image/gif', 'image/x-png');
	if (strlen(@$_FILES[$name]['name']) == 0) return $rs;
	
	if (in_array($_FILES[$name]['type'], $allowedType)) {
		if ($_FILES[$name]['size'] <= 500000) {
			$rs['file_name'] = $file_name = date('YmdHis').'_'.formatFilename($_FILES[$name]['name']);
			//$file_name = $_FILES['img']['name'];
			if (move_uploaded_file($_FILES[$name]['tmp_name'],$dir.'img/'.$file_name)){
				createThumb($file_name, $dir.'img/',$dir.'thumbs/', $_FILES[$name]['type']);
				ftp_mediaUpload($dir.'img/', $file_name);
				ftp_mediaUpload($dir.'thumbs/', $file_name);
			} else {
				$rs['error'] = true;
				$rs['msg'] = 'Error upload !';
			}
		} else {
			$rs['error'] = true;
			$rs['msg'] = 'is large !';
		}
	} else {
		$rs['error'] = true;
		$rs['msg'] = '\'s type is invalid !';
	}
	
	return $rs;
}

function BG_getBackgroundForAgent($agent_id){
    global $background_cls,$agent_cls,$agent_site_cls,$company_cls;

    //LEFT, RIGHT
    $rows = $background_cls->getRows("agent_id = (SELECT IF(a.parent_id > 0,a.parent_id,a.agent_id)
                                                      FROM " . $agent_cls->getTable() . " AS a
                                                      WHERE a.agent_id = {$agent_id})");
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $k=>$row) {
            if ($row['link'] != ''){
                $bg_data[$row['type']] = MEDIAURL . '/store/uploads/background/img/' . $row['link'];
            }
            $bg_data[$row['type'].'_config'] = $row;
        }
    }
    $bg_data['agent_id'] = $agent_id;
    //TOP
    $site = $agent_site_cls->getRow("agent_id = (SELECT IF(a.parent_id > 0,a.parent_id,a.agent_id)
                                                      FROM " . $agent_cls->getTable() . " AS a
                                                      WHERE a.agent_id = {$agent_id})
                                     AND type = 'agency'");
    if (is_array($site) and count($site) > 0){
        $bg_data['top_background'] = $site['background_logo'];
        if ($site['logo'] == 'default'){
            $logo = $company_cls->getRow("agent_id = (SELECT IF(a.parent_id > 0,a.parent_id,a.agent_id)
                                                      FROM " . $agent_cls->getTable() . " AS a
                                                      WHERE a.agent_id = {$agent_id})");
            if (is_array($logo) and count($logo) > 0){
                $bg_data['top'] = MEDIAURL.$logo['logo'];
            }else{
                $bg_data['top'] = '';
            }
        }
    }
    return $bg_data;
}

?>
