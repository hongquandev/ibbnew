<?php 
session_start();
include '../../configs/config.inc.php';
include ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
include ROOTPATH.'/admin/functions.php';
include 'lang/note.en.lang.php';
include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';
include_once ROOTPATH.'/modules/configuration/inc/config.class.php';
include_once ROOTPATH.'/includes/pagging.class.php';
if (!isset($config_cls) || !($config_cls instanceof Config)) {
	$config_cls = new Config();
}

if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
	$pag_cls = new Paginate();
}
if (!isset($systemlog_cls) or !($systemlog_cls instanceof SystemLog)) {
	$systemlog_cls = new SystemLog();
}
$action = getParam('action');
$token = getParam('token');

restrict4AjaxBackend();

include_once ROOTPATH.'/modules/role/inc/role.php';
include_once ROOTPATH.'/modules/general/inc/regions.class.php';
include_once ROOTPATH.'/modules/note/inc/note.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/user/inc/user.php';
include_once ROOTPATH.'/modules/property/inc/property.php';

if (!isset($region_cls) or !($region_cls instanceof Regions)) {
	$region_cls = new Regions();
}

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));
switch ($action) {
	case 'list-note':
		if ($perm_ar['view'] == 1) {
			__noteListAction();
		} else {
			die(json_encode($perm_msg_ar['view']));
		}
	break;
	case 'active-note':
		if ($perm_ar['edit'] == 1) {
			__noteActiveAction();
		} else {
			die(json_encode($perm_msg_ar['edit']));
		}
	break;
	case 'delete-note':
		if ($perm_ar['delete'] == 1) {
			__noteDeleteAction();
		} else {
			die(json_encode($perm_msg_ar['delete']));
		}
	break;
	case 'multidelete-note':
		if ($perm_ar['delete'] == 1) {
			__noteMultiDeleteAction();
		} else {
			die(json_encode($perm_msg_ar['delete']));
		}
	break;
    case 'edit-note':
		if ($perm_ar['edit'] == 1) {
			$note_id = getParam('note_id');
			$row = $note_cls->getRow('note_id = '.$note_id);
			if (is_array($row) and count($row) > 0) {
				die(_response($row));
			}
		} else {
			die(json_encode($perm_msg_ar['edit']));
		}
    break;
    case 'update-note':
		if ($perm_ar['edit'] == 1) {
			__noteUpdateAction();
		} else {
			die(json_encode($perm_msg_ar['edit']));
		}
	break;
}

/**
@ function : __noteListAction
**/

function __noteListAction() {
	global $note_cls, $agent_cls, $user_cls, $property_cls, $config_cls, $token;
	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',20));
	$sort_by = getParam('sort','note.note_id');
	$dir = getParam('dir','ASC');	
	
	$search_query = getParam('query');

	$search_where = 'WHERE note.type = \'admin2property\' OR note.type = \'admin2customer\'';
	
	if (strlen($search_query) > 0) {
		$search_where .= " AND (note.note_id ='".$search_query."' 
								OR note.content LIKE '%".$search_query."%'
								OR (SELECT CONCAT(a.firstname,' ',a.lastname)
								    FROM ".$agent_cls->getTable()." AS a
								    WHERE note.entity_id_to = a.agent_id) LIKE '%".$search_query."%')";
	}

			
	$rows = $note_cls->getRows('SELECT note.note_id, 
									   note.content,
									   note.active, 
									   note.time, 
									   note.type, 
									   note.entity_id_to,

										IF(note.type = \'customer2property\',
											(SELECT CONCAT(agt.firstname," ",agt.lastname)
											FROM '.$agent_cls->getTable().' AS agt
											WHERE agt.agent_id = note.entity_id_from),
																		
											(SELECT CONCAT(usr.firstname," ",usr.lastname)
											FROM '.$user_cls->getTable().' AS usr
											WHERE usr.user_id = note.entity_id_from)
										) AS fullname
												
								FROM '.$note_cls->getTable().' AS note
										'.$search_where.'
								ORDER BY '.$sort_by.' '.$dir.'
								LIMIT '.$start.','.$limit,true);
			
	$total = $note_cls->getFoundRows();
	$topics = array();
	if (is_array($rows) && count($rows) > 0) {
		foreach ($rows as $row) {
			$dt = new DateTime($row['time']);
			$row['time'] = $dt->format($config_cls->getKey('general_date_format'));
			
			$row['author'] = $row['fullname'];
			if ($row['type'] == 'customer2property') {
				$row['type'] = 'Customer';
				$row['to'] = $property_cls->getAddress($row['entity_id_to']);
				$row['link_to'] = '?module=property&action=edit&property_id='.$row['entity_id_to'].'&token='.$token;
			} else {
				$row['type'] = 'Admin';
				$row['to'] = $agent_cls->getFullname($row['entity_id_to']);
				$row['link_to'] = '?module=agent&action=edit&agent_id='.$row['entity_id_to'].'&token='.$token;
			}
			
			
			$delete_link = '../modules/note/action.admin.php?action=delete-note-admin&note_id='.$row['note_id'].'&token='.$token;
			$edit_link = '?module=note&action=edit&note_id='.$row['note_id'].'&token='.$token;
			$topics[] = $row;
		}
	}
	
	$result = array('totalCount' => $total,'topics' => $topics);			
	die(json_encode($result));	
}

/**
@ function : __noteDeleteAction
**/

function __noteDeleteAction() {
	global $note_cls, $systemlog_cls;
	$message = '';					
	$note_id = (int)restrictArgs(getParam('note_id',0));
	if ($note_id > 0) {
		//delete all it's child
		$note_cls->delete('note_id = '.$note_id);
		$message = 'Deleted successful !';
		
		// Write Logs					
		$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
				 'Action' => 'DELETE',
				 'Detail' => "DELETE NOTE ID :". $note_id, 
				 'UserID' => $_SESSION['Admin']['EmailAddress'],
				 'IPAddress' =>$_SERVER['REMOTE_ADDR']
				  ));	
	  
	}
	die(array('data' => $message));
}

/**
@ function : __noteMultiDeleteAction
**/

function __noteMultiDeleteAction() {
	global $note_cls,$systemlog_cls;
	$note_ids = getParam('note_id');
	if (strlen($note_ids) > 0) {
		/*$note_id_ar = explode(',',$note_ids);
		if (count($note_id_ar) > 0) {
			foreach ($note_id_ar as $note_id) {
				$row = $note_cls->getRow('note_id = '.$note_id);
				if (is_array($row) && count($row) > 0) {
					$note_cls->delete('note_id = '.$note_id);
					$message = 'Deleted #'.$note_id;
					// Write Logs					
					$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
												 'Action' => 'DELETE',
												 'Detail' => "DELETE NOTE ID :". $note_id, 
												 'UserID' => $_SESSION['Admin']['EmailAddress'],
												 'IPAddress' =>$_SERVER['REMOTE_ADDR']));
				}		  
			}
            
		}*/
        $note_cls->delete('note_id IN (\''.str_replace(",","','",$note_ids).'\')');
		$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
									 'Action' => 'DELETE',
									 'Detail' => "DELETE NOTE ID :". $note_ids,
									 'UserID' => $_SESSION['Admin']['EmailAddress'],
									 'IPAddress' =>$_SERVER['REMOTE_ADDR']));
	}
	die(json_encode('Deleted successful !'));
}

/**
@ function : __noteActiveAction
**/

function __noteActiveAction() {
	global $note_cls, $systemlog_cls;
	$note_id = (int)restrictArgs(getParam('note_id',0));
	$message = '';
	if ($note_id > 0) {
		$note_cls->update(array('active' => array('fnc' => 'abs(`active` - 1)')),'note_id = '.$note_id);
		$row = $note_cls->getRow('note_id = '.$note_id);
		if (is_array($row) && count($row) > 0) {
			$msg = "UPDATE NOTE ID :". $note_id ." SET ACTIVE = Inactived";
			$message = 'This note #'.$note_id.' has been updated.';
			if ($row['active'] > 0) {
				$msg = "UPDATE NOTE ID :". $note_id ." SET ACTIVE = Actived";
			}
			$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
					 'Action' => 'UPDATE',
					 'Detail' => $msg, 
					 'UserID' => $_SESSION['Admin']['EmailAddress'],
					 'IPAddress' =>$_SERVER['REMOTE_ADDR']
					  ));	
		}
	}
	
	die($message);
}

/**
@ function : __noteUpdateAction
**/
function __noteUpdateAction() {
	global $note_cls, $user_cls, $pag_cls;
	$agent_id = (int)restrictArgs(getQuery('agent_id',0));
	$p = (int)restrictArgs(getQuery('p',1));
	$p = $p <= 0 ? 1 : $p;
	$len = 6;
	$str = '';
	$page = '';
	$rows = array();
	$rows = $note_cls->getRows('SELECT SQL_CALC_FOUND_ROWS note.note_id,
						note.content,
						note.active,
						note.time,
						note.type,
						note.entity_id_to AS agent_id,

						(SELECT user.firstname
						FROM '.$user_cls->getTable().' AS user
						WHERE user.user_id = note.entity_id_from) AS firstname,

						(SELECT user.lastname
						FROM '.$user_cls->getTable().' AS user
						WHERE user.user_id = note.entity_id_from) AS lastname

						FROM '.$note_cls->getTable().' AS note
						WHERE note.entity_id_to = '.$agent_id." AND note.type = 'admin2customer'
						ORDER BY note.note_id DESC
						LIMIT ".(($p-1)*$len).','.$len,true);
	$total = $note_cls->getFoundRows();
	$pag_cls->setTotal($total)
			->setPerPage($len)
			->setCurPage($p)
			->setLenPage(10)
			->setUrl('/modules/note/action.admin.php?action=update-note&agent_id='.$agent_id)
			->setLayout('ajax')
			->setFnc('note.update_note');

	if ($note_cls->hasError()) {
	} else if (is_array($rows) and count($rows)>0) {
		$i = 1;
		foreach ($rows as $row) {
			$dt = new DateTime($row['time']);
			$row['time'] = $dt->format('d M Y');
			//$row['delete_link'] = '/modules/note/action.admin.php?action=delete-note&note_id='.$row['note_id'].'&token='.$token;
			$j = $i%2 == 0?1:2;
			$str .= '<div class="note-item'.$j.'">
						<p>'.$row['time'].'<span> by '.$row['firstname'].' '.$row['lastname'].'</span>
						<span class="link">
							<a href="javascript:void(0)" onclick="note.edit(\''.$row['note_id'].'\')"><img src="/admin/resources/images/default/dd/table_edit.png"/></a>
							<a href="javascript:void(0)" onclick ="note.delete_note(\''.$row['note_id'].'\')"><img src="/admin/resources/images/default/dd/delete.png"/></a>
						</span></p>
					<div>'.
					$row['content'].'
					</div>
					</div>';
			$i++;

		}
	}
	$page = $pag_cls->layout();
	$str .= '<div class="clearthis"></div>'.$page;
	die($str);
}
?>