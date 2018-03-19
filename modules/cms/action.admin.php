<?php
ini_set('display_errors', 0);
//session_start();
include '../../configs/config.inc.php';
include ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
include ROOTPATH.'/admin/functions.php';
include ROOTPATH.'/utils/ajax-upload/server/php.php';
include_once ROOTPATH.'/modules/cms/inc/cms.php';
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
		__cmsListAction();
    break;
    case 'tourguide-view':
        if ($perm_ar['view'] == 0) {
            die(json_encode($perm_msg_ar['view']));
        }
        __tourguideListAction();
        break;
    case 'tourguide-del':
    case 'multidelete-tourguide':
        if ($perm_ar['view'] == 0) {
            die(json_encode($perm_msg_ar['view']));
        }
        __tourguideDeleteAction();
        break;

    case 'multiaddcenter-page':
        __cmsAddCenterAction();
        break;

    case 'multidelete-page':
    case 'delete-page':
		if ($perm_ar['delete'] == 0) {
			die(json_encode($perm_msg_ar['delete']));
		}
		__cmsDeleteAction();
    break;
    case 'change-status-page':
		if ($perm_ar['edit'] == 0) {
			die(json_encode($perm_msg_ar['edit']));
		}
		__cmsStatusAction();
    break;
}

function __cmsAddCenterAction(){
    global $cms_cls, $systemlog_cls;
    $page_ids = getParam('page_id');
    if (strlen($page_ids) > 0) {
        $cms_cls->update(array('allow_display_center_banner' => 1),' type = 1 AND page_id IN ('.$page_ids.')');
        $page_arr = explode(',',$page_ids);
    }
    die(json_encode('Add display center banner successful!'));
}
/*---*/

/**
@ function : __cmsListAction
*/

function __cmsListAction() {
	global $cms_cls, $menu_cls, $config_cls, $token;
	$start = getParam('start', 0);
	$limit = getParam('limit', 20);
	$search_query = getParam('query');
    $search_str = '';
	if (strlen($search_query) > 0) {
		$search_str .= "  AND (cms.page_id = '".$search_query."'
						  OR cms.title LIKE '%".$search_query."%'
						  OR cms.content LIKE '%".$search_query."%'
						  )";
	}

    $rows = $cms_cls->getRows('SELECT SQL_CALC_FOUND_ROWS cms.*, menu.level
							   FROM '.$cms_cls->getTable().' AS cms
							   LEFT JOIN '.$menu_cls->getTable().' AS menu
							   ON cms.parent_id = menu.menu_id
							   WHERE cms.title != \'\' '.$search_str.'
							         AND cms.is_tour_guide = 0
							   ORDER BY menu.iurl, cms.parent_id, cms.sort_order
							   LIMIT '.$start.','.$limit,true);
						   
	$totalCount = $cms_cls->getFoundRows();
	$retArray = array();
	if (is_array($rows) and count($rows) > 0) {
		$g_first = '';
		foreach ($rows as $row) {
			$level_ar = unserialize($row['level']);
			if (is_array($level_ar)) {
				$e_first = array_shift($level_ar);
				if ($g_first != $e_first) {
					$retArray[] = array('title' => $e_first);
					$g_first = $e_first;
				}
				
				$row['title'] = str_repeat(' - - ', count($level_ar)).$row['title'];
			}

			$dt = new DateTime($row['creation_time']);
			$row['creation_time'] = $dt->format($config_cls->getKey('general_date_format'));
			$dt = new DateTime($row['update_time']);
			$row['update_time'] = $dt->format($config_cls->getKey('general_date_format'));
			
			$edit_link = '?module=cms&action=edit&page_id='.$row['page_id'].'&token='.$token;
			$row['edit_link'] = '<a href="'.$edit_link.'"><img src="/admin/resources/images/default/dd/table_edit.png"/></a>';
			 
			$delete_link = '../modules/cms/action.admin.php?action=delete-page&page_id='.$row['page_id'].'&token='.$token;
			$row['delete_link'] = '<a onclick ="outAction(\'delete\','.$row['page_id'].')"><img src="/admin/resources/images/default/dd/delete.png"/></a>';
			
			$retArray[] = $row;
		}
	}

	$arr = array("totalCount" => $totalCount, "topics" => $retArray, "count" => count($retArray), 'CmsTitle' => count($retArray) - $totalCount);
	die(json_encode($arr));
}


function __tourguideListAction() {
    global $cms_cls, $menu_cls, $config_cls, $token;
    $start = getParam('start', 0);
    $limit = getParam('limit', 20);
    $search_query = getParam('query');
    $search_str = '';

    if (strlen($search_query) > 0) {
        $search_str .= "  AND (cms.page_id = '".$search_query."'
						  OR cms.title LIKE '%".$search_query."%'
						  )";
    }

    $rows = $cms_cls->getRows('SELECT SQL_CALC_FOUND_ROWS cms.*
                               FROM '.$cms_cls->getTable().' as cms
                               WHERE 1
                                     AND cms.is_tour_guide = 1
                                     '.$search_str.'
                               ORDER BY cms.sort_order
							   LIMIT '.$start.','.$limit,true);

    $totalCount = $cms_cls->getFoundRows();
    $retArray = array();
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {

            $dt = new DateTime($row['creation_time']);
            $row['creation_time'] = $dt->format($config_cls->getKey('general_date_format'));
            $dt = new DateTime($row['update_time']);
            $row['update_time'] = $dt->format($config_cls->getKey('general_date_format'));

            $edit_link = '?module=cms&action=tourguide-add&page_id='.$row['page_id'].'&token='.$token;
            $row['edit_link'] = '<a href="'.$edit_link.'"><img src="/admin/resources/images/default/dd/table_edit.png"/></a>';

            $delete_link = '../modules/cms/action.admin.php?action=tourguide-del&page_id='.$row['page_id'].'&token='.$token;
            $row['delete_link'] = '<a onclick ="outAction(\'delete\','.$row['page_id'].')"><img src="/admin/resources/images/default/dd/delete.png"/></a>';

            $retArray[] = $row;
        }
    }

    $arr = array("totalCount" => $totalCount, "topics" => $retArray, "count" => count($retArray), 'CmsTitle' => count($retArray) - $totalCount);
    die(json_encode($arr));
}


/*
@ function : __cmsDeleteAction
*/

function __tourguideDeleteAction() {
    global $cms_cls, $systemlog_cls;
    $page_ids = getParam('page_id');
    if (strlen($page_ids) > 0) {
        $cms_cls->delete('page_id IN ('.$page_ids.')');
    }
    die(json_encode('Deleted successful!'));
}


function __cmsDeleteAction() {
	global $cms_cls, $systemlog_cls, $infographic_cls;
	$page_ids = getParam('page_id');
	if (strlen($page_ids) > 0) {
		  $cms_cls->delete('page_id IN ('.$page_ids.')');
          //Delete infographic
          $infographic_cls->delete('page_id IN ('.$page_ids.')');
		  $page_arr = explode(',',$page_ids);
		  $text = count($page_arr > 1)?"DELETE PAGES: ". $page_ids:"DELETE PAGE ID: ". $page_ids;
		  $systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
												 'Action' => 'DELETE',
												 'Detail' => $text,
												 'UserID' => $_SESSION['Admin']['EmailAddress'],
												 'IPAddress' =>$_SERVER['REMOTE_ADDR']));
          $page_arr = explode(',',$page_ids);

          include_once ROOTPATH.'/modules/report/inc/page_log.class.php';
          include_once ROOTPATH.'/modules/report/inc/page_log_time.class.php';
          if (!isset($page_log_cls) || !($page_log_cls instanceof Page_Log)) {
                $page_log_cls = new Page_Log();
          }
          if (!isset($page_log_time_cls) || !($page_log_time_cls instanceof Page_Log_Time)) {
                $page_log_time_cls = new Page_Log_Time();
          }
          // apply for cms page only
          foreach ($page_arr as $item){
              $wh_str = "`key` = 'cms_{$item}'";
              $row = $page_log_cls->getRow($wh_str);
              if (is_array($row) and count($row) > 0){
                  $page_log_time_cls->delete('page_log_id = '.$row['page_log_id']);
                  $page_log_cls->delete($wh_str);
              }
          }
	}
	die(json_encode('Deleted successful!'));
}

/*
@ function : __cmsStatusAction
*/

function __cmsStatusAction() {
	global $cms_cls, $systemlog_cls;
	$page_id = getParam('page_id');
	if ($page_id != '') {
		 $row = $cms_cls->getRow('page_id = '.$page_id);
		 if (is_array($row) and count($row) > 0){
			 $status = 1 - (int)$row['is_active'];
			 $_st = $status == 1?'ACTIVE':'INACTIVE';
			 $cms_cls->update(array('is_active'=>$status),
							  'page_id = '.$page_id );
			 $systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
												 'Action' => 'UPDATE',
												 'Detail' => $_st.' PAGE ID: '.$page_id,
												 'UserID' => $_SESSION['Admin']['EmailAddress'],
												 'IPAddress' =>$_SERVER['REMOTE_ADDR']));

		 }
	}
	die(json_encode('This information has been updated!'));
}

?>
 
