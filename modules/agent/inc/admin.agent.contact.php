<?php
$agent_contact_id = restrictArgs(getParam('agent_contact_id', 0));
$form_data = $agent_contact_cls->getFields();
$form_data[$agent_contact_cls->id] = $agent_contact_id;

if (isSubmit()) {
	$data = array();
	foreach ($form_data as $key => $val) {
		if (isset($_POST[$key])) {
			$data[$key] = $agent_contact_cls->escape($_POST[$key]);
		}
	}
	
	$agent_contact_cls->addValid(array('field' => 'name', 'label' => 'Name', 'fnc' => array('isRequire' => null)));
	$agent_contact_cls->addValid(array('field' => 'company', 'label' => 'Company', 'fnc' => array('isRequire' => null)));
	$agent_contact_cls->addValid(array('field' => 'address', 'label' => 'Address', 'fnc' => array('isRequire' => null)));
	$agent_contact_cls->addValid(array('field' => 'suburb', 'label' => 'Suburb', 'fnc' => array('isRequire' => null)));
	$agent_contact_cls->addValid(array('field' => 'state', 'label' => 'State', 'fnc' => array('isRequire' => null)));
	$agent_contact_cls->addValid(array('field' => 'postcode', 'label' => 'Postcode', 'fnc' => array('isRequire' => null)));
	$agent_contact_cls->addValid(array('field' => 'country', 'label' => 'Country', 'fnc' => array('isRequire' => null)));
	/*$agent_contact_cls->addValid(array('field' => 'telephone', 'label' => 'Telephone', 'fnc' => array('isRequire' => null)));
	$agent_contact_cls->addValid(array('field' => 'mobilephone', 'label' => 'Mobilephone', 'fnc' => array('isRequire' => null)));*/
	$agent_contact_cls->addValid(array('field' => 'email', 'label' => 'Email', 'fnc' => array('isEmail' => null)));
	
	try {
		if (!$agent_contact_cls->isValid($data)) {
			throw new Exception(implode('<br/>', $agent_contact_cls->getErrorsValid()));
		}
		
		if ($data['country'] == 1 && $agent_cls->invalidRegion(implode(' ', array_map('trim', array($data['suburb'], $data['state'], $data['postcode']))))) {
			throw new Exception('Wrong suburb/postcode or state!');
		}
		
		if ($form_data[$agent_contact_cls->id] > 0) { //UPDATE
			$agent_contact_cls->update($data,$agent_contact_cls->id.'='.$form_data[$agent_contact_cls->id]);
			/*
			// Write Logs					
			mysql_query("INSERT INTO `systemlogs` SET  `Updated`='".date("Y-m-d H:i:s")."', `Action`='UPDATE',  `Detail`='UPDATE AGENT CONTACT ID: $agent_id ',`UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '".$_SERVER['REMOTE_ADDR']."'");	
			*/	
		} else { //INSERT
			$other_state = getPost('other_state');	
			if ($other_state != '') {
				$data['state'] = 0;
			} 
			$data['agent_id'] = $agent_id;
			$agent_contact_id = $agent_contact_cls->insert($data);
			/*
			// Write Logs					
			mysql_query("INSERT INTO `systemlogs` SET  `Updated`='".date("Y-m-d H:i:s")."', `Action`='INSERT',  `Detail`='ADD AGENT CONTACT ID: $agent_id ',`UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '".$_SERVER['REMOTE_ADDR']."'");	
			*/
		}
		
		if ($agent_contact_cls->hasError()) {
			throw new Exception('Error when inserting / updating data.');
		}
		
		if (getParam('next', 0) == 1) {
			redirect(ROOTURL.'/admin/?module='.$module.'&action=edit-note2&agent_id='.$agent_id.'&token='.$token);
		}
		
		$message = $form_data[$agent_contact_cls->id] > 0 ? 'Edited successful.' : 'Added successful.';
	} catch (Exception $e) {
		$message = $e->getMessage();
	}
	$form_data = $data;
} else {
	$row = $agent_contact_cls->getRow('agent_id='.$agent_id);
	if (is_array($row) && count($row)) {
		//set form data 
		$agent_contact_id = $row['agent_contact_id'];
		foreach ($form_data as $key => $val) {
			if (isset($row[$key])) {
				$form_data[$key] = $row[$key];
			}
		}
	}
}

if ((int)$form_data['country'] == 0) {
	$form_data['country'] = $config_cls->getKey('general_country_default');
}

$smarty->assign(array('agent_contact_id' => $agent_contact_id,
					  'options_state' => R_getOptions(($form_data['country'] > 0 ? $form_data['country'] : -1 ),array(0=>'Select...')),
					  'options_country' => R_getOptions(),
					  'subState' => subRegion(),
					  'form_data' => formUnescapes($form_data)));
?>