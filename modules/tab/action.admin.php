<?php 
ini_set('display_errors', 0);
include '../../configs/config.inc.php';
include ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
include ROOTPATH.'/admin/functions.php';
include 'lang/tab.en.lang.php';

$action = getParam('action');
$token = getParam('token');
restrict4AjaxBackend();

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));

if ($action) {
	$action_ar = explode('-',$action);
	switch ($action_ar[1]) {
		case 'tab':
			include_once ROOTPATH.'/modules/role/inc/role.php';
			include_once ROOTPATH.'/modules/permission/inc/permission.php';
			include_once ROOTPATH.'/modules/general/inc/regions.class.php';
			include_once ROOTPATH.'/modules/tab/inc/tab.php';
			
			if (!isset($region_cls) or !($region_cls instanceof Regions)) {
				$region_cls = new Regions();
			}
			
			switch ($action_ar[0]) {
				case 'list':
					if ($perm_ar['view'] == 0) {
						$session_cls->setMessage($perm_msg_ar['view']);
						redirect('/admin/?module=tab&token='.$token);
					}
					__tabListAction();
				break;
				case 'delete':
					if ($perm_ar['delete'] == 0) {
						$session_cls->setMessage($perm_msg_ar['delete']);
						redirect('/admin/?module=tab&token='.$token);
					}
					__tabDeleteAction();
				break;
				case 'active':
				case 'inactive':
					if ($perm_ar['edit'] == 0) {
						$session_cls->setMessage($perm_msg_ar['edit']);
						redirect('/admin/?module=tab&token='.$token);
					}
					__tabActiveAction();
				break;
			}
		break;
	}
} 

/*-----*/

/**
@ function : __tabListAction
**/

function __tabListAction() {
	global $tab_cls, $token;
	$start = restrictArgs(getParam('start', 0));
	$limit = restrictArgs(getParam('limit', 20));
	$sort_by = getParam('sort', 'tab.tab_id');
	$dir = getParam('dir', 'ASC');	
	
	$search_query = $tab_cls->escape(getParam('search_query'));
	$search_where = '';
	if (strlen($search_query) > 0) {
		$search_where = "WHERE tab.tab_id ='".$search_query."' 
								OR tab.title LIKE '%".$search_query."%'
								OR tab.uri LIKE '%".$search_query."%'";
	}						
	
	$rows = $tab_cls->getRows('SELECT SQL_CALC_FOUND_ROWS 
									  tab.*
									  ,(SELECT tab2.title 
									  	FROM '.$tab_cls->getTable().' AS tab2 
										WHERE tab2.tab_id = tab.parent_id) AS parent_name
							  FROM '.$tab_cls->getTable().' AS tab
								   '.$search_where.'
							  ORDER BY `parent_id` ASC,`order` ASC,'.$sort_by.' '.$dir.'
							  LIMIT '.$start.','.$limit,true);
	$total = $tab_cls->getFoundRows();
	$topics = array();
	$option_ar = Tab_getTreeOptions('');
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$row['title'] = $option_ar[$row['tab_id']];
			$row['parent'] = strlen($row['parent_name']) == 0 ? '--' : $row['parent_name'];
			
			$delete_link = '../modules/tab/action.admin.php?action=delete-tab&tab_id='.$row['tab_id'].'&token='.$token;
			$row['delete_link'] = '<a style="cursor:pointer; color:#FF0000" onclick ="deleteItemF5(\''.$delete_link.'\');">Delete</a>';

			$edit_link = '?module=tab&action=edit&tab_id='.$row['tab_id'].'&token='.$token;							
			$row['edit_link'] = '<a href="'.$edit_link.'" style="color:#0000ff;text-decoration:none" onClick="">Edit</a>';
			 
			if ($row['active'] == 0) {
				$status_style = 'style="cursor:pointer; color:#FF0000"';
				$status_label = 'InActive';
				$status_link = '../modules/tab/action.admin.php?action=active-tab&tab_id='.$row['tab_id'].'&token='.$token;
			} else {
				$status_style = 'style="cursor:pointer; color:#009900"';
				$status_label = 'Active';
				$status_link = '../modules/tab/action.admin.php?action=inactive-tab&tab_id='.$row['tab_id'].'&token='.$token;
			
			} 
			$row['active_link'] =  '<a '.$status_style.' onclick="activeItemF5(\''.$status_link.'\');">'.$status_label.'</a>';
		
			$topics[] = $row;
		}
	}
	
	$result = array('totalCount' => $total,'topics' => $topics);			
	die(json_encode($result));	
}

/**
@ function : __tabDeleteAction
**/

function __tabDeleteAction() {
	global $tab_cls;
	$message = '';
	$tab_id = restrictArgs(getParam('tab_id', 0));
	if ($tab_id > 0) {
		//delete all it's child
		$tab_cls->delete('tab_id = '.$tab_id);
		Permission_deleteByTab($tab_id);
		$message = 'Deleted #'.$tab_id;
	}
	
	die($message);
}

/**
@ function : __tabActiveAction
**/

function __tabActiveAction() {
	global $tab_cls;
	$status_label = 'Actived / Inactived';
	$tab_id = restrictArgs(getParam('tab_id', 0));
	if ($tab_id > 0) {
		if ($action_ar[0] == 'active') {
			$action = 1;
			$status_label = 'Actived';
		} else {
			$action = 0;
			$status_label = 'Inactived';
		}
		
		$tab_cls->update(array('active' => $action),'tab_id = '.$tab_id);
	}
	$status_label = 'This information has been updated';
	die($status_label);
}
?>