<?php
if (!isset($check)) {
	$check = new CheckingForm();
}

$check->arr = array('firstname','lastname','username','email');

$form_data = $user_cls->getFields();
$form_data[$user_cls->id] = $user_id;

if (@$_SERVER['REQUEST_METHOD'] == 'POST') {
	//set form data (form POST) to $data
	$data = $form_data;
	
	foreach ($data as $key => $val) {
		if (isset($_POST[$key])) {
			$data[$key] = $user_cls->escape($_POST[$key]);
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
	
	if (!$error and !isUsername($data['username'])) {
		$message = 'Username is invalid.';
		$error = true;
	} 
	
	
	//end valid
	
	if ($error) {
		$form_data = $data;
	} else {
		
		if ($form_data[$user_cls->id] > 0) {//update
			if (strlen($data['password']) > 0) {
				$data['password'] = encrypt($data['password']);
			} else {
				unset($data['password']);
			}
			
			$row = $user_cls->getRow("username = '".$user_cls->escape($data['username'])."' AND user_id != ".$user_id);
			if (is_array($row) and count($row) > 0) {
				$error = true;
				$message = 'New username is similar with other.';
			} else {
				$user_cls->update($data,$user_cls->id.'='.$form_data[$user_cls->id]);
			}
		} else {//new
			if (User_isExist($data['username'])) {
				$message = 'Username is exist.';
				$error = true;
			} else {
				$data['password'] = encrypt($data['password']);
				$user_cls->insert($data);
				$user_id = $user_cls->insertId();
			}
		}
		
		if ($user_cls->hasError() || $error) {
			if (!$error) {
				$message = $user_cls->getError();
			}
			$form_data = $data;
		} else {
			$form_action = '?module='.$module.'&action='.$action.'&user_id='.$user_id.'&token='.$token;
			$message = $form_data[$user_cls->id] > 0 ? 'Edited successful.' : 'Added successful.';
			
			if ($_POST['next'] == 1) {
				redirect(ROOTURL.'/admin/?module='.$module.'&action=add&token='.$token);
			} else {
				$form_data = $data;
			}
		}	
	}
} else {//GET for backing
	//begin for updating
	$row = $user_cls->getRow('user_id='.(int)$user_id);
	if ($user_cls->hasError()) {
		$message = $user_cls->getError();
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
$smarty->assign('options_role',Role_getOptions());
$smarty->assign('form_data',formUnescapes($form_data));
?>