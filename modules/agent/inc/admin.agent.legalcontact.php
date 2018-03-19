<?php
if (!isset($check)) {
	$check = new CheckingForm();
}

$check->arr = array('lawyer_name','contact_name','street','suburb','state',
					'postcode','country','telephone','mobilephone',
					'email_address');

$lawyer_id = isset($_POST['lawyer_id']) ? $_POST['lawyer_id'] : (isset($_GET['lawyer']) ? $_GET['lawyer'] : 0);
$lawyer_id = (int)$lawyer_id;

$form_data = $agent_lawyer_cls->getFields();
$form_data[$agent_lawyer_cls->id] = $lawyer_id;

if (@$_SERVER['REQUEST_METHOD'] == 'POST') {

	//set form data (form POST) to $data
	$data = $form_data;
	foreach ($data as $key => $val) {
		if (isset($_POST[$key])) {
			$data[$key] = $agent_lawyer_cls->escape($_POST[$key]);
		} else {
			unset($data[$key]);
		}
	}
	
	//begin valid
	$error = false;
	if (!$check->checkForm() or $data['state']==0 or $data['country']==0) {
		$error = true;
		$check->showRed();
		$message = "The form is not complete. <A href='#here' name='here' onclick=\"msgAlert();\">Click here</A> to view the missing fields.";
	} else if (!$check->checkEmail($data['email_address'])) {
		$error = true;
		$data['email_address'] = '';
		$message = 'Email invalid!';
	}
	//end valid
	
	if ($error) {
		$form_data = $data;
	} else {
		$data['creation_time']  = date('Y-m-d H:i:s');
		
		unset($data[$agent_lawyer_cls->id]);
		if ($form_data[$agent_lawyer_cls->id] > 0) {//update
			
			$agent_lawyer_cls->update($data,$agent_lawyer_cls->id.'='.$form_data[$agent_lawyer_cls->id]);
			
			// Write Logs					
						mysql_query("INSERT INTO `systemlogs` SET  `Updated`='".date("Y-m-d H:i:s")."', `Action`='UPDATE',  `Detail`='UPDATE AGENT LEGALCONTACT ID: $agent_id ',`UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '".$_SERVER['REMOTE_ADDR']."'");	
						
		} else {//new
			$data['agent_id'] = $agent_id;
			$agent_lawyer_cls->insert($data);
			
			// Write Logs					
						mysql_query("INSERT INTO `systemlogs` SET  `Updated`='".date("Y-m-d H:i:s")."', `Action`='INSERT',  `Detail`='ADD AGENT LEGALCONTACT ID: $agent_id ',`UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '".$_SERVER['REMOTE_ADDR']."'");	
						
		}
		
		if ($agent_lawyer_cls->hasError()) {
			$message = $agent_lawyer_cls->getError();
			$form_data = $data;
		} else {
			$message = $form_data[$agent_lawyer_cls->id] > 0 ? 'Edited successful.' : 'Added successful.';
			if ($_POST['next'] == 1) {
				redirect(ROOTURL.'/admin/?module='.$module.'&action=edit-ccdetail&agent_id='.$agent_id.'&token='.$token);
			} else {
				$form_data = $data;
			}
		}	
	}
	
}
else {//GET for back action

	//begin for updating
	$row = $agent_lawyer_cls->getRow('agent_id='.$agent_id);
	if ($agent_lawyer_cls->hasError()) {
		$message = $agent_lawyer_cls->getError();
	} else if (is_array($row) and count($row)) {
		//set form data 
		$lawyer_id = $row['agent_lawyer_id'];
		foreach ($form_data as $key=>$val) {
			if (isset($row[$key])) {
				$form_data[$key] = $row[$key];
			}
		}
	}
	//end
}

if (!(((int)$form_data['country'])>0)) {
	$form_data['country'] = COUNTRY_DEFAULT;
}

$smarty->assign('lawyer_id',$lawyer_id);
$smarty->assign('options_state',R_getOptions(($form_data['country'] > 0 ? $form_data['country'] : -1 )),array(0=>'Select...'));
$smarty->assign('options_country',R_getOptions());
$smarty->assign('form_data',formUnescapes($form_data));
?>