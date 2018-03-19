<?php
$form_data = $package_basic_cls->getFields();
if (isSubmit()) {
	$data = array();
	foreach ($form_data as $key => $value) {
		if (isset($_POST[$key])) {
			$data[$key] = $_POST[$key];
		}
	}
	
	$package_basic_cls->addValid(array('field' => 'home', 'label' => 'Home\' price', 
										'fnc' => array('isRequire' => null, 'isMaxLen' => array(10))));
	$package_basic_cls->addValid(array('field' => 'focus', 'label' => 'Focus\' price', 
										'fnc' => array('isRequire' => null, 'isMaxLen' => array(10))));
	$package_basic_cls->addValid(array('field' => 'bid', 'label' => 'Bid / Make an offer\' price', 
										'fnc' => array('isRequire' => null, 'isMaxLen' => array(10))));
	$package_basic_cls->addValid(array('field' => 'bid_block', 'label' => 'Bid \' price', 
										'fnc' => array('isRequire' => null, 'isMaxLen' => array(10))));
										
	$package_basic_cls->addValid(array('field' => 'banner_notification_email', 'label' => 'Bid / Make an offer\' price', 
										'fnc' => array('isRequire' => null, 'isMaxLen' => array(10))));
	
	try {
		if (!$package_basic_cls->isValid($data)) {
			throw new Exception(implode('<br/>', $package_basic_cls->getErrorsValid()));
		}
		
		if (count($row = PABasic_getInfo()) > 0) { //UPDATE
			$package_basic_cls->update($data, $package_basic_cls->id .' = '.$row['package_id']);
		} else { //INSERT
			$package_basic_cls->insert($data);
		}
		
		if ($package_basic_cls->hasError()) {
			throw new Exception('Error when inserting / updating data.');
		}
		
		$message = 'Updated / Inserted successful.';
	} catch (Exception $e) {
		$message = $e->getMessage();
	}
	
	$form_data = $data;
	if (is_array($form_data) && count($form_data) > 0) {
		foreach ($form_data as $key => $val) {
			$form_data[$key] = str_replace('.00', '', $form_data[$key]);
            $form_data['show_'.$key]= showPrice_cent($form_data[$key]);
            $form_data['show_'.$key] = str_replace('.00', '', $form_data['show_'.$key]);
		}
	}
} else {
	$form_data = PABasic_getInfo();
	if (is_array($form_data) && count($form_data) > 0) {
		foreach ($form_data as $key => $val) {
			$form_data[$key] = str_replace('.00', '', $form_data[$key]);
            $form_data['show_'.$key]= showPrice_cent($form_data[$key]);
            $form_data['show_'.$key] = str_replace('.00', '', $form_data['show_'.$key]);
		}
	}
}

$smarty->assign(array('form_data' => $form_data));
?>