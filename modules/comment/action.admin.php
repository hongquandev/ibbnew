<?php 
session_start();
include '../../configs/config.inc.php';
include ROOTPATH.'/includes/model.class.php';

include ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/admin/functions.php';

include_once 'lang/comment.en.lang.php';
include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';
include_once ROOTPATH.'/modules/configuration/inc/config.class.php';
include_once ROOTPATH.'/modules/permission/inc/permission.class.php';
if (!isset($config_cls) || !($config_cls instanceof Config)) {
	$config_cls = new Config();
}

if (!isset($permission_cls) or !($permission_cls instanceof Permission)) {
    $permission_cls = new Permission();
}

if (!isset($systemlog_cls) or !($systemlog_cls instanceof SystemLog)) {
	$systemlog_cls = new SystemLog();
}

$token = getParam('token');
$action = getParam('action');
restrict4AjaxBackend();

include_once ROOTPATH.'/modules/comment/inc/comment.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));
switch ($action) {
	case 'list-comment':
		if ($perm_ar['view'] == 1) {
			__commentListAction();
		} else {
			die(json_encode($perm_msg_ar['view']));
		}
	break;
	case 'active-comment':
		if ($perm_ar['edit'] == 1) {
			__commentActiveAction();
		} else {
			die(json_encode($perm_msg_ar['edit']));
		}
	break;
	case 'delete-comment':
		if ($perm_ar['delete'] == 1) {
			__commentDeleteAction();	
		} else {
			die(json_encode($perm_msg_ar['delete']));
		}
	break;
	case 'multidelete-comment':
		if ($perm_ar['delete'] == 1) {
			__commentMultiDeleteAction();	
		} else {
			die(json_encode($perm_msg_ar['delete']));
		}
	break;
}


/**
@ function : __commentListAction
**/

function __commentListAction() {
	global $comment_cls, $agent_cls, $property_cls, $config_cls;
	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',20));
	$sort_by = getParam('sort','com.comment_id');
	$dir = getParam('dir','DESC');
	$comment_id = (int)restrictArgs(getParam('comment_id',0));
	//$search_query = getParam('search_query');
	$search_where = '';
	$search_query = getParam('query');
	if (strlen($search_query) > 0) {
		$search_where = "WHERE  (com.comment_id = '".$search_query."'
								OR com.name LIKE '%".$search_query."%' 
								OR com.email LIKE '%".$search_query."%'
								OR com.title LIKE '%".$search_query."%'
								OR com.content LIKE '%".$search_query."%')";
	}
	
	
	$rows = $comment_cls->getRows('SELECT SQL_CALC_FOUND_ROWS com.*, agt.agent_id, pro.stop_bid, pro.confirm_sold
				FROM '.$comment_cls->getTable().' AS com
				LEFT JOIN '.$property_cls->getTable().' AS pro ON com.property_id = pro.property_id
				LEFT JOIN '.$agent_cls->getTable().' AS agt ON com.email = agt.email_address
				'.$search_where.'
				ORDER BY '.$sort_by.' '.$dir.'
				LIMIT '.$start.','.$limit,true);	
	
  
	$total = $comment_cls->getFoundRows();
	$topics = array();
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$dt = new DateTime($row['created_date']);
			$row['created_date'] = $dt->format($config_cls->getKey('general_date_format'));
			$row['goto_property'] = true;
			if ($row['stop_bid'] == 1 && $row['confirm_sold'] == 1) {
				$row['goto_property'] = false;
			}
			$topics[] = formUnescapes($row);
		}
	}		
	
	$result = array('totalCount' => $total, 'topics' => $topics);
	die(json_encode($result));	
}

/**
@ function : __commentDeleteAction
**/

function __commentDeleteAction() {
	global $comment_cls, $systemlog_cls;
	$comment_id = (int)restrictArgs(getParam('comment_id',0));
	if ($comment_id > 0) {
		$comment_cls->delete('comment_id = '.$comment_id);
		// Write Logs					
		$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
				 'Action' => 'DELETE',
				 'Detail' => "DELETE COMMENT ID :". $comment_id, 
				 'UserID' => $_SESSION['Admin']['EmailAddress'],
				 'IPAddress' =>$_SERVER['REMOTE_ADDR']
				  ));
	}
	die(json_encode('Data has been deleted.'));	
}

/**
@ function : __commentActiveAction
**/

function __commentActiveAction() {
	global $comment_cls, $systemlog_cls;
	$comment_id = (int)restrictArgs(getParam('comment_id',0));
	
	if ($comment_id > 0) {
		$comment_cls->update(array('active' => array('fnc' => 'abs(`active`-1)')),'comment_id = '.$comment_id);
		$row = $comment_cls->getRow('comment_id = '.$comment_id);
		if (is_array($row) && count($row) > 0) {
			$msg = "UPDATE COMMENT ID :". $comment_id ." SET STATUS = Pending";
			if ($row['active'] > 0) {
				$msg = "UPDATE COMMENT ID :". $comment_id ." SET STATUS = Approved";
			}
			$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
					 'Action' => 'UPDATE',
					 'Detail' => "UPDATE COMMENT ID :". $comment_id ." SET STATUS = ".$status, 
					 'UserID' => $_SESSION['Admin']['EmailAddress'],
					 'IPAddress' =>$_SERVER['REMOTE_ADDR']
					  ));	
			
		}
	}
	die(json_encode('Data has been updated.'));
}

/**
@ function : __commentMultiDeleteAction
**/

function __commentMultiDeleteAction() {
    global $comment_cls,$systemlog_cls;
	$comment_ids = getParam('comment_id');
	if (strlen($comment_ids) > 0) {
		$comment_cls->delete('comment_id IN (\''.str_replace(",","','",$comment_ids).'\')');
		//die($comment_cls->sql);
		$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
									 'Action' => 'DELETE',
									 'Detail' => "DELETE COMMENT ID :". $comment_ids,
									 'UserID' => $_SESSION['Admin']['EmailAddress'],
									 'IPAddress' =>$_SERVER['REMOTE_ADDR']));
	}
	die(json_encode('Data has been deleted.'));
}

?>