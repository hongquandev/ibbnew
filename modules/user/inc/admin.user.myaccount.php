<?php
if (!isset($check)) {
	$check = new CheckingForm();
}

$check->arr = array('firstname','lastname','username','email');

$form_data = $user_cls->getFields();
$form_data[$user_cls->id] = $_SESSION['Admin']['ID'];

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
			
			$row = $user_cls->getRow("username = '".$user_cls->escape($data['username'])."' AND user_id != ".$form_data[$user_cls->id]);
			if (is_array($row) and count($row) > 0) {
				$error = true;
				$message = 'New username is similar with other.';
			} else {
				$user_cls->update($data,$user_cls->id.'='.$form_data[$user_cls->id]);
			}
		} 
		
		if ($user_cls->hasError() || $error) {
			if (!$error) {
				$message = $user_cls->getError();
			}
			$form_data = $data;
		} else {
			$message = 'Edited successful.';
		}	
	}
} 

$row = $user_cls->getRow('SELECT user.*, role.title AS role_name
						FROM '.$user_cls->getTable().' AS user,'.$role_cls->getTable().' AS role
						WHERE user.role_id = role.role_id AND user.user_id = '.$_SESSION['Admin']['ID'],true);
if (is_array($row) and count($row) > 0) {
	$smarty->assign('form_data',$row);
}
?>