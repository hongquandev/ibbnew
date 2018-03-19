<?php
session_start();
require '../../configs/config.inc.php';
require ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
require ROOTPATH.'/includes/smarty/Smarty.class.php';
$smarty = new Smarty;  
if(detectBrowserMobile()){ 
    $smarty->compile_dir = ROOTPATH.'/m.templates_c/';
}else{
    $smarty->compile_dir = ROOTPATH.'/templates_c/';
}

include_once ROOTPATH.'/utils/ajax-upload/server/php.php';
$action = getParam('action');

include_once ROOTPATH.'/modules/general/inc/user_online.php';

if (!isset($user_online_cls) || !($user_online_cls instanceof UserOnline)) {
    $user_online_cls = new UserOnline();
}
$user_online_cls->checkOnline();
if (!isset($config_cls) || !($config_cls instanceof Config)) {
    $config_cls = new Config();
}

define('SITE_TITLE',$config_cls->getKey('site_title'));
$smarty->assign('site_title_config',$config_cls->getKey('site_title'));

switch ($action) {
	case 'upload-media':
		$target = getParam('target');			
		$allowedExtensions = array('gif','jpg','jpeg','bmp','png');
		$sizeLimit = 10 * 1024 * 1024 * 1024;
		$isCheckSetting = false;
		$path = ROOTPATH.'/store/uploads/media/';
		$path_relative = ROOTURL.'/store/uploads/media';
		
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit, $isCheckSetting);
		$result = $uploader->handleUpload($path);
		// to pass data through iframe you will need to encode all html tags
		if (isset($result['success'])) {
			$data = array('file_name' => $path_relative.'/'.$result['filename'], 'active' => 1);
			
			$result['nextAction'] = array();
			$result['nextAction']['method'] = 'showPhoto';
			$result['nextAction']['args'] = array('action' => '/modules/property/action.php?action=&media_id=',
						'target' => $target,
						'link' => $path_relative.'/'.$result['filename'],
						'file_name' => $result['filename'],
						'media_id' => @$datas['media_id']);
			die(_response($result));
		}
	break;
	
	case 'list-media':
		$path = ROOTPATH.'/store/uploads/media/*';
		$file_ar = glob($path);
		$rows = array();
		if (is_array($file_ar) && count($file_ar) > 0) {
			foreach ($file_ar as $file) {
				if (eregi('/gif|jpg|jpeg|bmp|png/$',$file)) {
					//$rows[] = ROOTURL.'/store/uploads/media/'.basename($file);
					$rows[] = array('link' => ROOTURL.'/store/uploads/media/'.basename($file), 
									'file_name' => basename($file));
				}
			}
		}
		$smarty->assign('file_ar',$rows);
		die($smarty->fetch(ROOTPATH.'/modules/media/templates/media.list.tpl'));
	break;
}			
?>