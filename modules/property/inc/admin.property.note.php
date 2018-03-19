<?php
include_once ROOTPATH.'/modules/user/inc/user.php';

$form_data = $note_cls->getFields();
$form_data['active'] = 1;

$note_id = (int)preg_replace('#[^0-9]#','',(isset($_POST['note_id']) and $_POST['note_id'] > 0) ? $_POST['note_id'] : (isset($_GET['note_id']) ? $_GET['note_id']: 0));

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
			$note_cls->update(array('content' => $form_data['content'],'active' => 1),'note_id = '.$note_id);
			
			// Write Logs					
			$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
					 'Action' => 'UPDATE',
					 'Detail' => "UPDATE NOTE ID :". $note_id, 
					 'UserID' => $_SESSION['Admin']['EmailAddress'],
					 'IPAddress' =>$_SERVER['REMOTE_ADDR']
					  ));	
						
		} else {//ADD
			$message = 'Inserted successful.';
			$_data = array('content' => $form_data['content'],
							'active' => $form_data['active'],
							'time' => date('Y-m-d H:i:s'),
							'entity_id_to' => $property_id,
							'entity_id_from' => $_SESSION['Admin']['ID'], 
							'type' => 'admin2property',
							'active' => 1
							);
			$note_cls->insert($_data);
			$note_id = $note_cls->insertId();
			
			// Write Logs					
			$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
					 'Action' => 'INSERT',
					 'Detail' => "ADD NEW NOTE ID :". $note_id, 
					 'UserID' => $_SESSION['Admin']['EmailAddress'],
					 'IPAddress' =>$_SERVER['REMOTE_ADDR']
					  ));	
						
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
			$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
					 'Action' => 'DELETE',
					 'Detail' => "DELETE NOTE ID :". $note_id, 
					 'UserID' => $_SESSION['Admin']['EmailAddress'],
					 'IPAddress' =>$_SERVER['REMOTE_ADDR']
					  ));	
						
			//BEGIN VERY IMPORTANT
			$note_id = 0;
			$form_action = '?module=property&action=edit-note&property_id='.$property_id.'&token='.$token;
			//END
		break;
		case 'active-note':
			$message = 'Active successful.';
			$note_cls->update(array('active' => 1),'note_id = '.$note_id);
			
		// Write Logs					
			$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
					 'Action' => 'UPDATE',
					 'Detail' => "UPDATE NOTE ID :". $note_id ."SET ACTIVE = YES", 
					 'UserID' => $_SESSION['Admin']['EmailAddress'],
					 'IPAddress' =>$_SERVER['REMOTE_ADDR']
					  ));	
						
		break;
		case 'inactive-note':
			$message = 'Inactive successful.';
			$note_cls->update(array('active' => 0),'note_id = '.$note_id);		
			
			// Write Logs					
			$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
					 'Action' => 'UPDATE',
					 'Detail' => "UPDATE NOTE ID :". $note_id ."SET ACTIVE = NO", 
					 'UserID' => $_SESSION['Admin']['EmailAddress'],
					 'IPAddress' =>$_SERVER['REMOTE_ADDR']
					  ));	
						
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

$rows = $note_cls->getRows('SELECT note.note_id, note.content,note.active, note.time, note.type, note.entity_id_to AS property_id,
			IF(note.type = \'customer2property\',(SELECT agt.firstname
											FROM '.$agent_cls->getTable().' AS agt
											WHERE agt.agent_id = note.entity_id_from),
											
											(SELECT usr.firstname
											FROM '.$user_cls->getTable().' AS usr
											WHERE usr.user_id = note.entity_id_from)
											) AS firstname,
			IF(note.type = \'customer2property\',(SELECT agt.lastname
											FROM '.$agent_cls->getTable().' AS agt
											WHERE agt.agent_id = note.entity_id_from),
											
											(SELECT usr.lastname
											FROM '.$user_cls->getTable().' AS usr
											WHERE usr.user_id = note.entity_id_from)
											) AS lastname
											
		FROM '.$note_cls->getTable().' AS note
		WHERE note.entity_id_to = '.$property_id." AND (note.type = 'admin2property' OR note.type='admin2customer')
		ORDER BY note.note_id DESC",true);

if (is_array($rows) and count($rows) > 0) {
	foreach ($rows as $key => $row) {
		$dt = new DateTime($row['time']);
		$rows[$key]['time'] = $dt->format('d M Y');
		$ntid = $row['note_id'];
		$rows[$key]['edit_link'] = '?module=property&action=edit-note&property_id='.$property_id.'&note_id='.$row['note_id'].'&token='.$token;
		$rows[$key]['delete_link'] = '?module=property&action=delete-note&property_id='.$property_id.'&note_id='.$row['note_id'].'&token='.$token;
		
		// Write Logs					
		$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
				 'Action' => 'DELETE',
				 'Detail' => "DELETE NOTE ID :". $ntid, 
				 'UserID' => $_SESSION['Admin']['EmailAddress'],
				 'IPAddress' =>$_SERVER['REMOTE_ADDR']
				  ));	
					  
	}
	$smarty->assign('notes',$rows);
}

$smarty->assign('note_id',$note_id);
$smarty->assign('form_data',formUnescapes($form_data));
?>