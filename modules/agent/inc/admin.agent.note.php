<?php
include_once ROOTPATH.'/modules/user/inc/user.php';
include_once ROOTPATH.'/modules/note/inc/note.php';

$form_data = $note_cls->getFields();
$form_data['active'] = 1;
$note_id = (int) (isset($_POST['note_id']) ? $_POST['note_id']: (isset($_GET['note_id']) ? $_GET['note_id']: 0)) ;


if (@$_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['fields']) and is_array($_POST['fields']) and count($_POST['fields']) > 0) {
		foreach ($form_data as $key => $val) {
			if (isset($_POST['fields'][$key])) {
				$form_data[$key] = $note_cls->escape($_POST['fields'][$key]);
			} else {
				unset($form_data[$key]);
			}
		}
		$form_data['content'] = scanContent($form_data['content']);		
		if ($note_id > 0) {//UPDATE
			$message = 'Updated successful.';
			$note_cls->update(array('content' => $form_data['content'],'active' => $form_data['active']),'note_id = '.$note_id);
			
			// Write Logs					
						mysql_query("INSERT INTO `systemlogs` SET  `Updated`='".date("Y-m-d H:i:s")."', `Action`='UPDATE',  `Detail`='UPDATE AGENT NOTE ID: $agent_id ',`UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '".$_SERVER['REMOTE_ADDR']."'");	
						
		} else {//ADD
			$message = 'Inserted successful.';
			$_data = array('content' => $form_data['content'],
							'active' => $form_data['active'],
							'time' => date('Y-m-d H:i:s'),
							'entity_id_to' => $property_id,
							'entity_id_from' => $_SESSION['Admin']['ID'], 
							'type' => 'admin2customer',
							'active' => 1
							);
			$note_cls->insert($_data);
			
			// Write Logs					
						mysql_query("INSERT INTO `systemlogs` SET  `Updated`='".date("Y-m-d H:i:s")."', `Action`='INSERT',  `Detail`='ADD AGENT NOTE ID: $agent_id ',`UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '".$_SERVER['REMOTE_ADDR']."'");	
						
		}
		
		if ($_POST['next'] == 1) {
			redirect(ROOTURL.'/admin/'.$form_action);
		}
	}
}

if ($note_id > 0) {
	switch ($action) {
		case 'delete-note':
			$message = 'Deleted successful.';
			$note_cls->delete('note_id = '.$note_id);
			// Write Logs					
						mysql_query("INSERT INTO `systemlogs` SET  `Updated`='".date("Y-m-d H:i:s")."', `Action`='DELETE',  `Detail`='DELETE  NOTE ID: $note_id ',`UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '".$_SERVER['REMOTE_ADDR']."'");	
						
		break;
		case 'active-note':
			$message = 'Active successful.';
			$note_cls->update(array('active' => 1),'note_id = '.$note_id);
			
			// Write Logs					
						mysql_query("INSERT INTO `systemlogs` SET  `Updated`='".date("Y-m-d H:i:s")."', `Action`='UPDATE',  `Detail`='UPDATE AGENT NOTE ID: $note_id SET ACTIVE = YES ',`UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '".$_SERVER['REMOTE_ADDR']."'");	
						
		break;
		case 'inactive-note':
			$message = 'Inactive successful.';
			$note_cls->update(array('active' => 0),'note_id = '.$note_id);	
				
				// Write Logs					
						mysql_query("INSERT INTO `systemlogs` SET  `Updated`='".date("Y-m-d H:i:s")."', `Action`='UPDATE',  `Detail`='UPDATE AGENT NOTE ID: $note_id SET ACTIVE = NO ',`UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '".$_SERVER['REMOTE_ADDR']."'");
						
		break;
		default://FOR EDIT
			$row = $note_cls->getRow('note_id = '.$note_id);
			if (is_array($row) and count($row) > 0) {
				$form_data['content'] = $row['content'];
				$form_data['active'] = $row['active'];
			}
		break;
	}
}



$rows = $note_cls->getRows('SELECT note_id, content,active, time, type, entity_id_to AS property_id
				FROM '.$note_cls->getTable().'
				WHERE entity_id_from = '.$agent_id." AND type = 'customer2property'
				ORDER BY note_id DESC",true);
				
if (is_array($rows) and count($rows) > 0) {
	foreach ($rows as $key => $row) {
		$dt = new DateTime($row['time']);
		$rows[$key]['time'] = $dt->format('d M Y H:i:s');
		
		$rows[$key]['property_link'] = '?module=property&action=edit&property_id='.$row['property_id'].'&token='.$token;
		$rows[$key]['delete_link'] = '?module=agent&action=delete-note&agent_id='.$agent_id.'&note_id='.$row['note_id'].'&token='.$token;
		
		$_tmp = $row['active'] == 1 ? 'inactive': 'active';
		
		$rows[$key]['active_label'] = $_tmp;
		$rows[$key]['active_link'] = '?module=agent&action='.$_tmp.'-note&agent_id='.$agent_id.'&note_id='.$row['note_id'].'&token='.$token;
	}
	$smarty->assign('notes',$rows);
}

$smarty->assign('note_id',$note_id);
$smarty->assign('form_data',formUnescapes($form_data));
?>