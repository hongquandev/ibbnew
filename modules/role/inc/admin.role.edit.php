<?php
if (!isset($check)) {
	$check = new CheckingForm();
}

$check->arr = array('title','description','order');

$form_data = $role_cls->getFields();
$form_data[$role_cls->id] = $role_id;

if (@$_SERVER['REQUEST_METHOD'] == 'POST') {
	//set form data (form POST) to $data
	$data = $form_data;
	
	foreach ($data as $key => $val) {
		if (isset($_POST[$key])) {
			$data[$key] = $role_cls->escape($_POST[$key]);
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
		
		if ($form_data[$role_cls->id] > 0) {//update
			$role_cls->update($data,$role_cls->id.'='.$form_data[$role_cls->id]);
		} else {//new
			$role_cls->insert($data);
			$role_id = $role_cls->insertId();
			Permission_addByRole($role_id);
		}
		
		if ($role_cls->hasError()) {
			$message = $role_cls->getError();
			//re-set data to form in error state
			$form_data = $data;
			//$act = 'edit';
		} else {
			$form_action = '?module=role&action='.$action.'&role_id='.$role_id.'&token='.$token;
			$message = $form_data[$role_cls->id] > 0 ? 'Edited successful.' : 'Added successful.';
			
			if ($_POST['next'] == 1) {
				redirect(ROOTURL.'/admin/?module='.$module.'&action=add&token='.$token);
			} else {
				$form_data = $data;
			}
		}	
	}
} else {//GET for backing
	//begin for updating
	$row = $role_cls->getRow('role_id='.(int)$role_id);
	if ($role_cls->hasError()) {
		$message = $role_cls->getError();
	} else if (is_array($row) and count($row)) {
		//set form data 
		foreach ($form_data as $key => $val) {
			if (isset($row[$key])) {
				$form_data[$key] = $row[$key];
			}
		}
	}
	//end
}
$smarty->assign('form_data',formUnescapes($form_data));
?>