<?php 
include '../../configs/config.inc.php';
include ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
include_once ROOTPATH.'/admin/functions.php';
include_once 'inc/banner_setting.php';

include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';
if (!isset($systemlog_cls) or !($systemlog_cls instanceof SystemLog)) {
	$systemlog_cls = new SystemLog();
}

if (!$_SESSION['Admin']) {
	die('logout');
}

$module = getParam('module');
$action = getParam('action');
$token = getParam('token');

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));

switch($action)  {
	case 'list' :
		if ($perm_ar['view'] == 0) {	
			die(json_encode($perm_msg_ar['view']));
		}
		__settingListAction();
	break;

}	

/*--*/	

/*
@ function : __menuListAction
*/

function __settingListAction() {
	global $banner_setting_cls, $token;
	$start = getParam('start', 0);
	$limit = getParam('limit', 25);
	$sortby = getParam('sort', 'ID');
	$dir = getParam('dir', 'ASC');
	 
	$rows = $banner_setting_cls->getRows('SELECT SQL_CALC_FOUND_ROWS banner_setting.*
							FROM '.$banner_setting_cls->getTable().' AS banner_setting 
							ORDER BY setting_id '.$dir.'
							LIMIT '.$start.','.$limit,true);	

	$totalCount = $banner_setting_cls->getFoundRows();
	
	$retArray = array();	  
	
	if (is_array($rows) and count($rows) > 0) {	
		foreach ($rows as $row) {
			
			$edit_link = '?module=banner_setting&action=edit&id='.$row['setting_id'].'&token='.$token;
			$row['Edit'] = '<a href="'.$edit_link.'"><img src="/admin/resources/images/default/dd/table_edit.png"/></a>';
			
			$retArray[] = $row;
		} 
	}
	// $data = json_encode($retArray);
	
	$arrJS = array("totalCount" => $totalCount, "topics" => $retArray);
	die(json_encode($arrJS));
}

?>