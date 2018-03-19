<?php
$row = $agent_contact_cls->getRow('SELECT al.*,
				(SELECT r1.name FROM '.$region_cls->getTable('regions').' AS r1 WHERE r1.region_id = al.state) AS state_name,
				(SELECT r2.name FROM '.$region_cls->getTable('regions').' AS r2 WHERE r2.region_id = al.country) AS country_name
				FROM '.$agent_contact_cls->getTable().' AS al WHERE al.agent_id = '.$_SESSION['agent']['id'],true);

//FOR LAWYER INFORMATION
$form_data = $agent_contact_cls->getFields();
if (is_array($row) and count($row) > 0) {
	foreach ($row as $key => $val) {
		if (isset($form_data[$key])) {
			$form_data[$key] = $val;
		}
	}
}

$postcode_prev = $form_data['postcode'];
$state_prev = $form_data['state'];
$suburb_prev = $form_data['suburb'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['field']) && is_array($_POST['field']) && (count($_POST['field']) > 0) ) {
		$check->arr = array();
        $error = false;
//		if (!$check->checkForm()) {
//			$check->showRed();
//            $error = true;
//			$message = "The form is not complete. <A href='#here' name='here' onclick=\"msgAlert();\">Click here</A> to view the missing fields.";
//		}
        if (!$error) {
			if($_POST['field']['country'] == 1) {
				if ($agent_cls->invalidRegion(trim($_POST['field']['suburb']).' '.trim($_POST['field']['state']).' '.trim($_POST['field']['postcode']))) {
						//print_r($sql);
						$error = true;
	
						$message = 'Wrong suburb/postcode or state!';
						//$message = $form_data['suburb'].' '.$form_data['state'].' '.$form_data['postcode'];
						//$form_data['postcode'] = $postcode_prev;
						//$form_data['state'] = $state_prev;
						//$form_data['suburb'] = $suburb_prev;
				}
			}	
	    }

        if (!$error)
        {
			foreach ($_POST['field'] as $key => $val) {
				if (isset($form_data[$key])) {
					$form_data[$key] = ($val);
				}
			}
			
			$row = $agent_contact_cls->getRow('agent_id = '.$_SESSION['agent']['id']);
			if (is_array($row) && count($row) > 0) {
			
				if ($_POST['field']['state'] > 0 && $_POST['field']['country'] == 1) {
					
					$form_data['other_state'] = '';
				}
				
				if ($_POST['field']['other_state'] != '' && $_POST['field']['country'] > 1) {
					
					$form_data['other_state'] = $_POST['field']['other_state'];	
					$form_data['state'] = '';
				}
				
				$agent_contact_cls->update($form_data,'agent_id = '.$_SESSION['agent']['id']);
				
				
			} else {
			
				if ($_POST['field']['state'] > 0 && $_POST['field']['country'] == 1) {
					
					$form_data['other_state'] = '';
				}
				
				if ($_POST['field']['other_state'] != '' && $_POST['field']['country'] > 1) {
					
					$form_data['other_state'] = $_POST['field']['other_state'];	
					$form_data['state'] = '';
				}
				
				$form_data['agent_id'] = $_SESSION['agent']['id'];
				$agent_contact_cls->insert($form_data);
			}
			
			if ($agent_contact_cls->hasError()) {
				$message = $agent_contact_cls->getError();
			}
			else {
				$message = 'Updated Successfully.';
			}
		}
	}
}
if (!((int)$form_data['country'] > 0)) {
		$form_data['country'] = COUNTRY_DEFAULT;
}

$smarty->assign('options_state',R_getOptions(($form_data['country'] > 0 ? $form_data['country'] : -1 ),array(0=>'Select...')));
$smarty->assign('options_country',R_getOptions());
$smarty->assign('subState', subRegion());
$smarty->assign('form_data',formUnescapes($form_data));
?>