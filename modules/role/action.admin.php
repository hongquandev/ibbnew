<?php 
//session_start();
include_once '../../configs/config.inc.php';
include_once ROOTPATH.'/includes/functions.php';
include_once ROOTPATH.'/includes/model.class.php';
include_once ROOTPATH.'/admin/functions.php';
include_once 'lang/role.en.lang.php';
include_once ROOTPATH.'/modules/tab/inc/tab.php';
include_once ROOTPATH.'/modules/permission/inc/permission.php';
include_once ROOTPATH.'/modules/general/inc/regions.class.php';
include_once ROOTPATH.'/modules/role/inc/role.php';
include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';

$action = getParam('action');
$token = getParam('token');

restrict4AjaxBackend();
$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));

if (eregi('-',$action)) {
	$action_ar = explode('-',$action);
	switch ($action_ar[1]) {
		case 'role':
			switch ($action_ar[0]) {
				case 'list':
					if ($perm_ar['view'] == 1) {
						__roleListAction();
					} else {
						die(json_encode($perm_msg_ar['view']));
					}
				break;
                case 'multidelete':
				case 'delete':
					if ($perm_ar['delete'] == 1) {
						__roleDeleteAction();
					} else {
						die(json_encode($perm_msg_ar['delete']));
					}
				break;
			}
		break;
	}
} 

/*-----*/
function __roleListAction() {
	global $role_cls, $token;
	$start = (int)$_REQUEST['start'] == 0 ? 0 : $_REQUEST['start'] ;
	$limit = (int)$_REQUEST['limit'] == 0 ? 20 : $_REQUEST['limit'] ;
	$sort_by = $_REQUEST['sort'] == '' ? 'rol.role_id' : $_REQUEST['sort'] ;
	$dir = $_REQUEST['dir'] == '' ? 'ASC' : $_REQUEST['dir'] ;	
	
	$rows = $role_cls->getRows('SELECT SQL_CALC_FOUND_ROWS rol.*
				FROM '.$role_cls->getTable().' AS rol
				ORDER BY '.$sort_by.' '.$dir.'
				LIMIT '.$start.','.$limit,true);
	$total = $role_cls->getFoundRows();
	$topics = array();
	
	
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$row['delete_link'] = '<a onclick ="outAction(\'delete\','.$row['role_id'].')"><img src="/admin/resources/images/default/dd/delete.png"/></a>';

			$edit_link = '?module=role&action=edit&role_id='.$row['role_id'].'&token='.$token;
			$row['edit_link'] = '<a href="'.$edit_link.'"><img src="/admin/resources/images/default/dd/table_edit.png"/></a>';
		
			$topics[] = $row;
		}
	}
	
	$result = array('totalCount' => $total,'topics' => $topics);			
	die(json_encode($result));	
}

function __roleDeleteAction() {
	global $role_cls, $systemlog_cls;
	$role_ids = getParam('role_id');
	if ($role_ids != ''){
		$row_arr = explode(',',$role_ids);
		foreach($row_arr as $role_id){
			$row = $role_cls->getRow('role_id ='.$role_id);
			if (is_array($row) and count($row)> 0){
				$role_cls->delete('role_id='.$role_id);
				Permission_deleteByRole($role_id);
				$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
					 'Action' => 'UPDATE',
					 'Detail' => 'DELETE ROLE:'. $row['title'],
					 'UserID' => $_SESSION['Admin']['EmailAddress'],
					 'IPAddress' =>$_SERVER['REMOTE_ADDR']
					  ));
			}
		}

	}
	die('');
}
?>