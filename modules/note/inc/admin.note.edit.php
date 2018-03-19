<?php
include_once ROOTPATH.'/modules/user/inc/user.php';

include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';	

if (!isset($systemlog_cls) or !($systemlog_cls instanceof SystemLog)) {
	$systemlog_cls = new SystemLog();
}

$form_data = $note_cls->getFields();
$form_data['active'] = 1;
$note_id = $_POST['note_id'] > 0? $_POST['note_id'] : (isset($_GET['note_id'])?$_GET['note_id']:0);
if (@$_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['fields']) and is_array($_POST['fields']) and count($_POST['fields']) > 0) {
		foreach ($form_data as $key => $val) {
			if (isset($_POST['fields'][$key])) {
				$form_data[$key] = $note_cls->escape($_POST['fields'][$key]);
			} else {
				unset($form_data[$key]);
			}
		}
		
		if ($note_id > 0) {//UPDATE
		
			$message = 'Updated successful.';
			$note_cls->update(array('content' => $form_data['content'],'active' => 1),'note_id = '.$note_id);
			
			// Write Logs					
			$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
					 'Action' => 'UPDATE',
					 'Detail' => "UPDATE NOTE ID :". $note_id , 
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
							'type' => 'admin',
							'active' => 1
							);
			$note_cls->insert($_data);
			
			// Write Logs					
			$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
					 'Action' => 'INSERT',
					 'Detail' => "ADD NEW NOTE ID :". $note_id , 
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
		break;
		case 'active-note':
			$message = 'Active successful.';
			$note_cls->update(array('active' => 1),'note_id = '.$note_id);
		break;
		case 'inactive-note':
			$message = 'Inactive successful.';
			$note_cls->update(array('active' => 0),'note_id = '.$note_id);		
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


$smarty->assign('note_id',$note_id);
$smarty->assign('form_data',formUnescapes($form_data));
?>