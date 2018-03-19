<?php
//session_start();
include_once '../../configs/config.inc.php';
include_once ROOTPATH.'/includes/functions.php';
include_once ROOTPATH.'/includes/model.class.php';
include_once ROOTPATH.'/admin/functions.php';
include_once ROOTPATH.'/utils/ajax-upload/server/php.php';
include_once ROOTPATH.'/modules/video/inc/video.php';
include_once ROOTPATH.'/modules/menu/inc/menu.php';
include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/configuration/inc/config.class.php';

if (!isset($systemlog_cls) or !($systemlog_cls instanceof SystemLog)) {
	$systemlog_cls = new SystemLog();
}

if (!$_SESSION['Admin']) {
	die('logout');
}

restrict4AjaxBackend();

$module = getParam('module');
$action = getParam('action');
$token = getParam('token');

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));

switch ($action){
    case 'list':
		if ($perm_ar['view'] == 0) {
			die(json_encode($perm_msg_ar['view']));
		}
		__videoListAction();
    break;
    case 'multidelete-page':
    case 'delete-page':
		if ($perm_ar['delete'] == 0) {
			die(json_encode($perm_msg_ar['delete']));
		}
		__videoDeleteAction();
    break;
}

/**
@ function : __videoListAction
*/

function __videoListAction() {
	global $video_cls, $menu_cls, $config_cls, $token;
	$start = getParam('start', 0);
	$limit = getParam('limit', 20);
	$search_query = getParam('query');
    $search_str = '';
	if (strlen($search_query) > 0) {
		$search_str .= "  AND (video.video_id = '".$search_query."'
						  OR video.video_name LIKE '%".$search_query."%'
						  )";
	}

    $rows = $video_cls->getRows('SELECT SQL_CALC_FOUND_ROWS video.*
							   FROM '.$video_cls->getTable().' AS video
							   LIMIT '.$start.','.$limit,true);
						   
	$totalCount = $video_cls->getFoundRows();
	$retArray = array();
	if (is_array($rows) and count($rows) > 0) {
		$g_first = '';
		foreach ($rows as $row) {
			$edit_link = '?module=video&action=edit&video_id='.$row['video_id'].'&token='.$token;
			$row['edit_link'] = '<a href="'.$edit_link.'"><img src="/admin/resources/images/default/dd/table_edit.png"/></a>';
			$delete_link = '../modules/video/action.admin.php?action=delete-page&video_id='.$row['video_id'].'&token='.$token;
			$row['delete_link'] = '<a onclick ="outAction(\'delete\','.$row['video_id'].')"><img src="/admin/resources/images/default/dd/delete.png"/></a>';
			$retArray[] = $row;
		}
	}

	$arr = array("totalCount" => $totalCount, "topics" => $retArray, "count" => count($retArray), 'CmsTitle' => count($retArray) - $totalCount);
	die(json_encode($arr));
}



function __videoDeleteAction() {
	global $video_cls, $systemlog_cls;
	$video_ids = getParam('video_id');
	if (strlen($video_ids) > 0) {
		$rows = $video_cls->getRows('SELECT SQL_CALC_FOUND_ROWS video.*
								   FROM '.$video_cls->getTable().' AS video
								   WHERE video.video_id IN ('.$video_ids.')',true);
		if (is_array($rows) && count($rows) > 0) {
			foreach ($rows as $row) {
				if ($row['is_embed'] == 0) {
					@unlink(ROOTPATH.'/'.trim($row['video_content'], '/'));
				}
			}
		} 
		$video_cls->delete('video_id IN ('.$video_ids.')');
	}
	die(json_encode('Deleted successful!'));
}
?>