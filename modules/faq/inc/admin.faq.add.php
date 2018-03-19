<?php
	include_once 'faq.php';
	if (!isset($faq_cls) or !($faq_cls instanceof Faq)) {
		$faq_cls = new Faq();
	}
	// Insert Faq.
	$form_data = $faq_cls->getFields();
	
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		$check->arr = array('title', 'description', 'active', 'create_date', 'update_date');
		
		if (isset($_POST['fields'])) {
			$data = $form_data;
			
		if (is_array($_POST['fields']) and count($_POST['fields']) > 0) {
		
			foreach ($data as $key => $val) {
				if (isset($_POST['fields'][$key])) {
					$data[$key] = $faq_cls->escape($_POST['fields'][$key]);
				} else {
					unset($data[$key]);
				}
			} 
			$data['active'] = isset($_POST['active']) ? 1 : 0;
			
			$data['create_date'] = date('Y-m-d');
			$data['update_date'] = date('Y-m-d');
			$faq_cls->insert($data);
			$message = 'Added successful';
			$smarty->assign('message', $message);
			//print_r($data);
		} // End is_array($_POST['fields']) and count($_POST['fields']) > 0
	} 
}	
?>