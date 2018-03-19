<?php 
//session_start();
include_once '../../configs/config.inc.php';
include_once ROOTPATH.'/includes/functions.php';
include_once ROOTPATH.'/includes/model.class.php';
include_once ROOTPATH.'/admin/functions.php';
include_once 'lang/user.en.lang.php';
include_once ROOTPATH.'/modules/general/inc/regions.class.php';
include_once ROOTPATH.'/modules/user/inc/user.php';
include_once ROOTPATH.'/modules/role/inc/role.php';
include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';

$action = getParam('action');
$token = getParam('token');

restrict4AjaxBackend();
$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));

if (eregi('-',$action)) {
	$action_ar = explode('-',$action);
	switch ($action_ar[1]) {
		case 'user':
			switch ($action_ar[0]) {
				case 'list':
					if ($perm_ar['view'] == 1) {
						__userListAction();	
					} else {
						die(json_encode($perm_msg_ar['view']));
					}
				break;
				case 'delete':
                case 'multidelete':
					if ($perm_ar['delete'] == 1) {
						__userDeleteAction();
					} else {
						die(json_encode($perm_msg_ar['delete']));
					}
				break;
                case 'change_status':
					if ($perm_ar['edit'] == 1) {
						__userChangeStatusAction();
					} else {
						die(json_encode($perm_msg_ar['edit']));
					}
                break;
	        }
		break;	
    }
} 

/*------*/

/**
@ function : __userListAction
**/

function __userListAction() {
	global $user_cls, $role_cls, $token;
	$start = (int)$_REQUEST['start'] == 0 ? 0 : $_REQUEST['start'] ;
	$limit = (int)$_REQUEST['limit'] == 0 ? 20 : $_REQUEST['limit'] ;
	$sort_by = $_REQUEST['sort'] == '' ? 'user.user_id' : $_REQUEST['sort'] ;
	$dir = $_REQUEST['dir'] == '' ? 'ASC' : $_REQUEST['dir'] ;	
	
	$search_query = getParam('query');
	$search_where = '';
	if (strlen($search_query) > 0) {
		$search_where = " AND (user.user_id ='".$search_query."' 
								OR user.firstname LIKE '%".$search_query."%'
								OR user.lastname LIKE '%".$search_query."%'
								OR user.username LIKE '%".$search_query."%'
								OR user.email LIKE '%".$search_query."%')";
	}						
	
	$rows = $user_cls->getRows('SELECT SQL_CALC_FOUND_ROWS user.*,rol.title AS role
				FROM '.$user_cls->getTable().' AS user,'.$role_cls->getTable().' AS rol
				WHERE user.role_id = rol.role_id '.$search_where.'
				ORDER BY '.$sort_by.' '.$dir.'
				LIMIT '.$start.','.$limit,true);
				
	$total = $user_cls->getFoundRows();
	
	$topics = array();
	
	
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$row['fullname'] = $row['firstname'].' '.$row['lastname'];
			$row['delete_link'] = '<a onclick ="outAction(\'delete\','.$row['user_id'].')"><img src="/admin/resources/images/default/dd/delete.png"/></a>';
			$edit_link = '?module=user&action=edit&user_id='.$row['user_id'].'&token='.$token;
			$row['edit_link'] = '<a href="'.$edit_link.'"><img src="/admin/resources/images/default/dd/table_edit.png"/></a>';
			$topics[] = $row;
		}
	}
	
	$result = array('totalCount' => $total,'topics' => $topics);			
	die(json_encode($result));
}

/**
@ function : __userDeleteAction
**/

function __userDeleteAction() {
	global $user_cls, $systemlog_cls;
	$user_ids = getParam('user_id');
	if (strlen($user_ids) > 0) {
		$user_cls->delete('user_id IN ('.$user_ids.')');
		$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
									 'Action' => 'DELETE',
									 'Detail' => "DELETE USER ID :". $user_ids,
									 'UserID' => $_SESSION['Admin']['EmailAddress'],
									 'IPAddress' =>$_SERVER['REMOTE_ADDR']));
	}
	die(json_encode('Deleted successful !'));
}

/**
@ function : __userChangeStatusAction
**/

function __userChangeStatusAction() {
	global $user_cls, $systemlog_cls;
	$user_id = getParam('user_id',0);
	$row = $user_cls->getRow('user_id = '.$user_id);
	if (is_array($row) and count($row) > 0) {
		$msg = ($row['active'] == 1)?'INACTIVE':'ACTIVE';
		$user_cls->update(array('active'=>1-$row['active']),'user_id = '.$user_id);
		$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
					 'Action' => 'UPDATE',
					 'Detail' => $msg." USER ID :". $user_id,
					 'UserID' => $_SESSION['Admin']['EmailAddress'],
					 'IPAddress' =>$_SERVER['REMOTE_ADDR']
					  ));
	}
	die(json_encode('This information has been changed !'));
}
?>