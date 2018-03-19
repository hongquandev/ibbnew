<?php
include_once ROOTPATH.'/modules/user/inc/user.php';
include_once ROOTPATH.'/modules/note/inc/note.php';

$form_data = $note_cls->getFields();
//$form_data['active'] = 1;
//print_r($agent_id);

//PREPARE SHOW NOTE (NHUNG)
/*$rows = array();
$rows = $note_cls->getRows('SELECT note.note_id,
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
                            ORDER BY note.note_id DESC",true);

if (is_array($rows) and count($rows) > 0) {
	foreach ($rows as $key => $row) {
		$dt = new DateTime($row['time']);
		$rows[$key]['time'] = $dt->format('d M Y');
		$rows[$key]['edit_link'] = '?module=agent&action=edit-note2&agent_id='.$agent_id.'&note_id='.$row['note_id'].'&token='.$token;
		$rows[$key]['delete_link'] = '?module=agent&action=delete-note2&agent_id='.$agent_id.'&note_id='.$row['note_id'].'&token='.$token;
	}

}*/
//$note_id = (isset($_POST['note_id']) and $_POST['note_id'] > 0) ? $_POST['note_id'] : (isset($_GET['note_id']) ? $_GET['note_id']: 0);
//$note_id = (int)$note_id;
if (@$_SERVER['REQUEST_METHOD'] == 'POST') {
    $note_id = (int)$_POST['note_id'];

	if (isset($_POST['fields']) and is_array($_POST['fields']) and count($_POST['fields']) > 0) {
		foreach ($form_data as $key => $val) {
			if (isset($_POST['fields'][$key])) {
				$form_data[$key] = $note_cls->escape($_POST['fields'][$key]);
			} else {
				unset($form_data[$key]);
			}
		}
		
		if ($note_id != 0) {//UPDATE
			$note_cls->update(array('content' => $form_data['content'],'active' => 1),'note_id = '.$note_id);
            if (!$note_cls->hasError()){
                $message = 'Updated successful.';
            }
			//Write log
            $systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
										  'Action' => 'UPDATE',
										  'Detail' => "UPDATE NOTE AGENT ID :". $agent_id,
									      'UserID' => $_SESSION['Admin']['EmailAddress'],
										  'IPAddress' =>$_SERVER['REMOTE_ADDR']));
			
		} else {//ADD
            if ($_POST['submit_'] == 1) {
                $_data = array('content' => $form_data['content'],
                                'time' => date('Y-m-d H:i:s'),
                                'entity_id_to' => getParam('agent_id'),
                                'entity_id_from' => $_SESSION['Admin']['ID'],
                                'type' => 'admin2customer',
                                'active' => 1
                                );
                $note_cls->insert($_data);

                //$note_id = $note_cls->insertId();
                if (!$note_cls->hasError()){
                    $message = 'Inserted successful.';
                }
                //Write log
                $systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
                                              'Action' => 'INSERT',
                                              'Detail' => "INSERT NOTE AGENT ID :". $agent_id,
                                              'UserID' => $_SESSION['Admin']['EmailAddress'],
                                              'IPAddress' =>$_SERVER['REMOTE_ADDR']));
                $session_cls->setMessage($message);
            }
		}
		$form_data = array();
        $note_id = 0;
        //$session_cls->setMessage($message);
		if ($_POST['next'] == 1) {
			//redirect(ROOTURL.'/admin/'.$form_action);
            redirect(ROOTURL.'/admin/?module=agent&token='.$token);
		}else{
            redirect(ROOTURL.'/admin/'.$form_action);
        }
	}
}

/*if ($note_id > 0) {
	switch ($action) {
		case 'delete-note2':
			$message = 'Deleted successful.';
			$note_cls->delete('note_id = '.$note_id);
			//BEGIN VERY IMPORTANT
			$note_id = 0;
			$form_action = '?module=agent&action=edit-note2&agent_id='.$agent_id.'&token='.$token;

            $systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
										  'Action' => 'DELETE',
										  'Detail' => "DELETE NOTE AGENT ID :". $agent_id,
									      'UserID' => $_SESSION['Admin']['EmailAddress'],
										  'IPAddress' =>$_SERVER['REMOTE_ADDR']));


			//END
		break;
		default://FOR EDIT
			$row = $note_cls->getRow('note_id = '.$note_id);
			if (is_array($row) and count($row) > 0) {
				$form_data['content'] = $row['content'];
				$form_data['active'] = $row['active'];
			}
		break;
	}
}*/

$smarty->assign('message',$message);
$smarty->assign('notes',$rows);
$smarty->assign('note_id',$note_id);
$smarty->assign('form_data',formUnescapes($form_data));
$smarty->assign('agent_id',$agent_id);
?>