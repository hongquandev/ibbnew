<?php
//ini_set('display_errors', 1);
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/modules/general/inc/bids.php';
if ($action == 'view-message'){
	$action = 'view-message-inbox';
	$action_ar = explode('-',$action);
}

$message_id = ( isset($_POST['message_id']) and $_POST['message_id'] > 0 )? $_POST['message_id'] : (isset($_GET['message_id']) ? $_GET['message_id'] : 0);
$message_id = (int)$message_id;

$type = isset($_GET['type']) ? $_GET['type'] : '';

if (isset($action_ar[2])) {
	$where_str = '';
	
	$ids = array();
	if ($action_ar[0] == 'delete') {
		if (isset($_POST['chk'])) {
			$ids = $_POST['chk'];
		}
	}
	
	//LIST, DELETE, EDIT
	switch ($action_ar[2]) {
		case 'inbox':
			//echo 'inbox';
			$where_str = 'm.`agent_id_to`='.$_SESSION['agent']['id'].' AND m.draft = 0';
			if (count($ids) > 0) {
				$message_cls->update(array('draft' => 1), "message_id IN ('".implode("','",$ids)."') AND `agent_id_to`=".$_SESSION['agent']['id']);
				
				if ($message_cls->hasError()) {
					$message = $message_cls->getError();
				} else {
					//$message = 'Deleted Successful.';
				}
			}
			$form_action = '/?module=agent&action=view-message-inbox';
		break;	
		case 'outbox':
			//echo 'outbox';
			$where_str = 'm.`agent_id_from`='.$_SESSION['agent']['id'].' AND `abort`=0';
			if (count($ids)>0) {
				$message_cls->update(array('abort' => 1),"message_id IN ('".implode("','",$ids)."') AND `agent_id_from`=".$_SESSION['agent']['id']);
				if ($message_cls->hasError()) {
					$message = $message_cls->getError();
				} else {
					//$message = 'Deleted Successful.';
				}
			}
			$form_action = '/?module=agent&action=view-message-outbox';
		break;	
		case 'draft':
			//echo 'draft';
			$where_str = 'm.`agent_id_to`='.$_SESSION['agent']['id'].' AND m.draft=1';
			if (count($ids)>0) {
				$message_cls->delete("message_id IN ('".implode("','",$ids)."') AND `agent_id_to`=".$_SESSION['agent']['id']);
				if ($message_cls->hasError()) {
					$message = $message_cls->getError();
				} else {
					$message = 'Deleted Successful.';
				}
			}
			$form_action = '/?module=agent&action=view-message-draft';
		break;
		default:
			//board
			
		break;
	}//END SWITCH
	
	
	//SHOW LIST
	if (strlen($where_str)>0) {
		//BEGIN PAGGING
		$p = (int)preg_replace('#[^0-9]#','',isset($_GET['p']) ? $_GET['p'] : 1);
		if ($p <= 0) {
			$p = 1;
		}
		$len = 25;
		
		$rows = $message_cls->getRows('SELECT SQL_CALC_FOUND_ROWS m.* 
						,(SELECT a1.email_address FROM '.$agent_cls->getTable().' AS a1 WHERE a1.agent_id = m.agent_id_from) AS email_from2
						,(SELECT a2.email_address FROM '.$agent_cls->getTable().' AS a2 WHERE a2.agent_id = m.agent_id_to) AS email_to2
						FROM '.$message_cls->getTable().' AS m 
						WHERE '.$where_str.'
						ORDER BY m.message_id DESC
						LIMIT '.($p - 1) * $len.','.$len,true);
		
		$total_row = $message_cls->getFoundRows();										
									
		$pag_cls->setTotal($total_row)
				->setPerPage($len)
				->setCurPage($p)
				->setLenPage(25)
				->setUrl('?module=agent&action='.$action)
				->setLayout('simple_combobox');
				
		$smarty->assign('pag_str',$pag_cls->layout());
						
		if ($message_cls->hasError()) {
			$message = $message_cls->getError();
		} else {
			$smarty->assign('message_rows',$rows);	
		}
	}
}

//READ
if ($message_id > 0) {
	//READ
	$message_cls->update(array('read' => 1), 'message_id = '.$message_id);

	$row = $message_cls->getRow('SELECT m.* 
					,(SELECT a1.email_address FROM '.$agent_cls->getTable().' AS a1 WHERE a1.agent_id = m.agent_id_from) AS email_from2
					,(SELECT a2.email_address FROM '.$agent_cls->getTable().' AS a2 WHERE a2.agent_id = m.agent_id_to) AS email_to2
					FROM '.$message_cls->getTable().' AS m 
					WHERE m.message_id = '.$message_id,true);
					
					
	if (is_array($row) and count($row) > 0) {
		$dt = new DateTime($row['send_date']);
		$row['send_date'] = $dt->format('d M Y'). ' at '.$dt->format('h A');
		
		if (strlen(trim($row['email_from'])) > 0){
			$row['email_main'] = $row['email_from'];
		} else {
			$row['email_main'] = $row['email_from2'];
		}
		
		$row['content2'] = ($row['content']);
        $row['content_forward'] = $row['content_reply'] = stripAllTags( str_replace('-','',$row['content']));
		$smarty->assign('message_detail',$row);
	}
}


//REPLY-FORWARD
$req = isset($_POST['req']) ? $_POST['req'] : '';
if (in_array($req,array('reply','forward','new')) ) {
	include_once ROOTPATH.'/includes/class.phpmailer.php';
	
	$ok = false;
    $agent_id_to = 0;
    $subject = '';
	if (in_array($req,array('reply','forward')) and $message_id > 0 and is_array($row) and count($row) > 0) {
		$_req = $req == 'reply' ? 'Reply' : 'Forward';
		$subject = $_req.' : '.$row['title'];
		//$from_name = $_req." from ".ROOTURL;
		$from_name = $_req." ".$_SESSION['agent']['email_address'];
		$agent_id_to = $row['agent_id_from'];/* 5 stars */
		$ok = true;
	} else if ($req == 'new'){
		$subject = $_POST['subject'];
		//$from_name = "From ".ROOTURL;
		$from_name = $_SESSION['agent']['email_address'];
		$agent_id_to = 0;
		
		$agent_row = $agent_cls->getRow("email_address = '".$agent_cls->escape($_POST['email'])."'");
		if (is_array($agent_row) && count($agent_row) > 0) {
			$agent_id_to = $agent_row['agent_id'];
		}
		$ok = true;
	} 
	
	
	if ($ok) {
		$email = $_POST['email'];
		$content = $_POST['content'];

		$nd = '<h2 style="font-size: 16px; color: #2f2f2f;"> Message Information </h2>
				<div style="margin-top:8px;">Sender : '.$_SESSION['agent']['email_address'].'  </div>
				<div style="margin-top:8px;">Subject : '.stripslashes($subject).'  </div>
				<div style="margin-top:8px">Content : '.stripslashes($content).' </div> ';
																	


        $from_ = $_SESSION['agent']['email_address'];
        $to_ = $email ;
        sendEmail_func($from_,$to_,$nd,stripslashes($subject));
        include_once ROOTPATH.'/modules/general/inc/email_log.class.php';
        $log_cls->createLog('send_message');
        $content = stripslashes($content);
		$data = array('agent_id_from' => $_SESSION['agent']['id'],
					'email_from' => $_SESSION['agent']['email_address'],
					'agent_id_to' => $agent_id_to,
					'email_to' => $email,
					'title' => addslashes($subject),
					'content' => addslashes($content),
					'send_date' => date('Y-m-d H:i:s'));

		$message_cls->insert($data);
        //die('Test oki');
	} else {
		$message = 'Error when processing.';
	}	
}

$message_data = array('num_inbox' => M_numInbox(),
						'num_unread' => M_numUnread(),
						'num_outbox' => M_numOutbox());
$smarty->assign('message_data',$message_data);	
$smarty->assign('form_action',$form_action);
$smarty->assign('message_id',$message_id);
$smarty->assign('type',$type);

?>