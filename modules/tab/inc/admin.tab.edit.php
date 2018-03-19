<?php
if (!isset($check)) {
	$check = new CheckingForm();
}

$check->arr = array('firstname','lastname','street','suburb','state',
					'postcode','country','telephone','mobilephone',
					'email_address','license_number','preferred_contact_method',
					'security_question','security_answer');

$form_data = $tab_cls->getFields();
$form_data[$tab_cls->id] = $tab_id;

if (@$_SERVER['REQUEST_METHOD'] == 'POST') {
	//set form data (form POST) to $data
	$data = $form_data;
	
	foreach ($data as $key => $val) {
		if (isset($_POST[$key])) {
			$data[$key] = $tab_cls->escape($_POST[$key]);
		} else {
			unset($data[$key]);
		}
	}
	$data['active'] = isset($_POST['active']) ? 1 : 0;
	
	//begin valid
	$error = false;
	if (!$check->checkForm()) {
		$error = true;
		$check->showRed();
		$message = "The form is not complete. <A href='#here' name='here' onclick=\"msgAlert();\">Click here</A> to view the missing fields.";
	} 
	
	//end valid
	
	
	if ($error) {
		$form_data = $data;
	} else {
		
		if ($form_data[$tab_cls->id] > 0) {//update
			$tab_cls->update($data,$tab_cls->id.'='.$form_data[$tab_cls->id]);
		} else {//new
			$tab_cls->insert($data);
			$tab_id = $tab_cls->insertId();
			Permission_addByTab($tab_id);
		}
		
		if ($tab_cls->hasError()) {
			$message = $tab_cls->getError();
			//re-set data to form in error state
			$form_data = $data;
			//$act = 'edit';
		} else {
			$form_action = '?module=tab&action='.$action.'&tab_id='.$tab_id.'&token='.$token;
			$message = $form_data[$tab_cls->id] > 0 ? 'Edited successful.' : 'Added successful.';
			
			if ($_POST['next'] == 1) {
				redirect(ROOTURL.'/admin/?module='.$module.'&action=add&token='.$token);
			} else {
				$form_data = $data;
			}
		}	
	}
} else {//GET for backing
	//begin for updating
	$row = $tab_cls->getRow('tab_id='.(int)$tab_id);
	if ($tab_cls->hasError()) {
		$message = $tab_cls->getError();
	} else if (is_array($row) and count($row)) {
		//set form data 
		foreach ($form_data as $key => $val) {
			if (isset($row[$key])) {
				$form_data[$key] = $row[$key];
			}
		}
		
		$form_data['password'] = '';
		//to show to form for updating
	}
	//end
}
$smarty->assign('options_parent',combineArray(array(0 => 'Select'),Tab_getTreeOptionsLevelOne()));
$smarty->assign('form_data',formUnescapes($form_data));
$rows = $tab_cls->getRows('SELECT * FROM '.$tab_cls->getTable('tabs_image').' ORDER BY title ASC',true);
$icon = array();
if(is_array($rows) and count($rows)> 0){
    foreach ($rows as $row){
        $icon[$row['class']] = $row['title'];
    }
    $smarty->assign('icon',$icon);
}


?>