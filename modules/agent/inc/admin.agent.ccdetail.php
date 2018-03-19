<?php
if (!isset($check)) {
	$check = new CheckingForm();
}

$check->arr = array('card_type','card_name','card_number');

$cc_id = isset($_POST['cc_id']) ? $_POST['cc_id'] : (isset($_GET['cc_id']) ? $_GET['cc_id']: 0);
$cc_id = (int)$cc_id;

$form_data = $agent_creditcard_cls->getFields();
$form_data[$agent_creditcard_cls->id] = $cc_id;

if (@$_SERVER['REQUEST_METHOD'] == 'POST') {

	//set form data (form POST) to $data
	$data = $form_data;
	
	foreach ($data as $key => $val) {
		if (isset($_POST[$key])) {
			$data[$key] = $agent_creditcard_cls->escape(trim($_POST[$key]));
		} else {
			unset($data[$key]);
		}
	}

	$_month = $_POST['expiration_month'];
	if ($_month < 10) {
		$_month = '0'.$_month;
	}
	$data['expiration_date'] = 	$_POST['expiration_year'].'-'.$_month .'-01';
	//begin valid
	$error = false;
	if (!$check->checkForm() or strlen($data['card_type']) == 0) {
		$error = true;
		$check->showRed();
		$message = "The form is not complete. <a href='#here' name='here' onclick=\"msgAlert();\">Click here</a> to view the missing fields.";
	}
	//end valid
	
	
	if ($error) {
		$form_data = $data;
	} else {
		unset($data[$agent_creditcard_cls->id]);
		if ($form_data[$agent_creditcard_cls->id] > 0) {//update
			$row = $agent_creditcard_cls->getRow("card_number = '".$data['card_number']."' AND agent_id !=".$agent_id);
			if (is_array($row) && count($row) > 0) {
				$form_data = $data;
				$dt = new DateTime($data['expiration_date']);
				$form_data['expiration_year'] = $dt->format('Y');
				$form_data['expiration_month'] = (int)$dt->format('m');
				
				$message = 'Existed card number '.$data['card_number'].' on the other account.';
			} else {
				$agent_creditcard_cls->update($data,$agent_creditcard_cls->id.'='.$form_data[$agent_creditcard_cls->id]);
				
					// Write Logs					
						mysql_query("INSERT INTO `systemlogs` SET  `Updated`='".date("Y-m-d H:i:s")."', `Action`='UPDATE',  `Detail`='UPDATE CREDITCARD AGENT ID: $agent_id ',`UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '".$_SERVER['REMOTE_ADDR']."'");	
						
			}
		} else {//new
			$data['agent_id'] = $agent_id;
			
			$row = $agent_creditcard_cls->getRow("card_number = '".$data['card_number']."'");
			if (is_array($row) && count($row) > 0) {
				$form_data = $data;
				$dt = new DateTime($data['expiration_date']);
				$form_data['expiration_year'] = $dt->format('Y');
				$form_data['expiration_month'] = (int)$dt->format('m');
				
				$message = 'Existed card number '.$data['card_number'].' on system.';
			} else {
				$agent_creditcard_cls->insert($data);
				$cc_id = $agent_creditcard_cls->insertId();
				
				// Write Logs					
						mysql_query("INSERT INTO `systemlogs` SET  `Updated`='".date("Y-m-d H:i:s")."', `Action`='INSERT',  `Detail`='ADD CREDITCARD AGENT ID: $agent_id ',`UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '".$_SERVER['REMOTE_ADDR']."'");	
						
			}
		}
		
		if (strlen($message) == 0) {
			if ($agent_creditcard_cls->hasError()) {
				$message = $agent_creditcard_cls->getError();
				//re-set data to form in error state
				$form_data = $data;
				//$act = 'edit';
			} else {
			
				$message = $form_data[$agent_creditcard_cls->id] > 0 ? 'Edited successful.' : 'Added successful.';
				if ($_POST['next'] == 1) {
					redirect(ROOTURL.'/admin/?module='.$module.'&action='.$action.'&agent_id='.$agent_id.'&token='.$token);
				} else {
					$form_data = $data;
				}
			}	
		}
	}
} 


switch ($action) {
	case 'delete-ccdetail':
		if ($cc_id > 0 and $agent_id > 0) {
			$agent_creditcard_cls->delete($agent_creditcard_cls->id.'='.$cc_id.' AND agent_id = '.$agent_id);
			$form_action = '?module='.$module.'&action=edit-ccdetail&agent_id='.$agent_id.'&token='.$token;
			$cc_id = 0;
			$message = 'Deleted successful.';
				// Write Logs					
						mysql_query("INSERT INTO `systemlogs` SET  `Updated`='".date("Y-m-d H:i:s")."', `Action`='DELETE',  `Detail`='DELETE CREDITCARD AGENT ID: $agent_id ',`UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '".$_SERVER['REMOTE_ADDR']."'");	
			
		}
	break;
	default://EDIT
		if ($cc_id > 0) {
			$row = $agent_creditcard_cls->getRow($agent_creditcard_cls->id.'='.$cc_id);
			if ($agent_creditcard_cls->hasError()) {
				$message = 'Error when selecting data.';
			} elseif (is_array($row) and count($row)) {
				$cc_id = $row['agent_creditcard_id'];
				foreach ($form_data as $key => $val) {
					if (isset($row[$key])) {
						$form_data[$key] = $row[$key];
					}
					
				}
				
				$dt = new DateTime($row['expiration_date']);
				$form_data['expiration_year'] = $dt->format('Y');
				$form_data['expiration_month'] = (int)$dt->format('m');
				
				$form_action .= '&agent_id='.$agent_id.'&cc_id='.$form_data[$agent_creditcard_cls->id].'&token='.$token;
			}
		}
	break;
}


$rows = $agent_creditcard_cls->getRows('SELECT cc.*, ct.name
					FROM '.$agent_creditcard_cls->getTable().' AS cc,'.$agent_creditcard_cls->getTable('card_type').' AS ct
					WHERE cc.card_type = ct.code AND ct.active = 1 AND cc.agent_id = '.$agent_id."
					ORDER BY cc.agent_creditcard_id DESC",true);

if (is_array($rows) and count($rows) > 0) {
	foreach ($rows as $key => $row) {
		$dt = new DateTime($row['expiration_date']);
		$rows[$key]['expiration_date'] = $dt->format('F, Y');
		$rows[$key]['edit_link'] = '?module=agent&action='.$action.'&agent_id='.$agent_id.'&cc_id='.$row['agent_creditcard_id'].'&token='.$token;
		$rows[$key]['delete_link'] = '?module=agent&action=delete-ccdetail&agent_id='.$agent_id.'&cc_id='.$row['agent_creditcard_id'].'&token='.$token;
	}
	$smarty->assign('cc_ar',$rows);
}


$smarty->assign('options_month',ACC_getOptionsMonth());
$smarty->assign('options_year',ACC_getOptionsYear(date('Y')+10));
$smarty->assign('cc_id',$cc_id);
$smarty->assign('options_card_type',CT_getOptions());
$smarty->assign('form_data',formUnescapes($form_data));
?>