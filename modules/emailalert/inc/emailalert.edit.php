<?php
	include_once 'emailalert.class.php';
	include_once ROOTPATH.'/modules/general/inc/regions.php';
	
	// Call Constructor init();
	if (!isset($email_cls) || !($email_cls instanceof EmailAlert)) {
		$email_cls = new EmailAlert();
	}
	$form_data = $email_cls->getFields();
	$form_data[$email_cls->id] = $_SESSION['property']['id'];
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
	$check->arr = array('auction_sale','property_type','name_email','minprice', 'maxprice', 'schedule','address','suburb','postcode','country','price','price_range','bedroom','bathroom','land_size','car_space','car_port');
	
	if (isset($_POST['fields'])) {
		
		$data = $form_data;
		if (is_array($_POST['fields']) and count($_POST['fields']) > 0) {
			
			foreach ($data as $key => $val) {
				if (isset($_POST['fields'][$key])) {
					$data[$key] = $email_cls->escape($_POST['fields'][$key]);
					
				} else {
					unset($data[$key]);
				}
			} 
			
			$data['agent_id'] = $_SESSION['agent']['id'];
			
			$today = getdate();   
		  $data['end_time'] = $today["year"] . "-" . $today["mon"] ."-" . $today["mday"] . "-" . $today["hours"] . "-" . $today["minutes"] . "-" . $today["seconds"];

			$error = false;
			
			if ($error) {//error
				$form_data = $data;	
				
				extractDateTime($form_data['end_time'],$form_data);
			} else {//not error
				unset($data[$email_cls->id]);
					
			//	if ($form_data[$email_cls->id] > 0) {//edit
					$id = $_GET['id'];
					$email_cls->update($data,$email_cls->id.'='.$id);
					$messageup = "The email was reset successfully!";
  								$smarty->assign('messageup', $messageup);
				//$property_document_cls->update($datas,'property_document_id='.$row['property_document_id']);
				//} else {//insert
					//$email_cls->insert($data);
						
				//}	
				if ($email_cls->hasError()) {
					$message = $email_cls->getError();
					$form_data = $data;
					extractDateTime($form_data['end_time'],$form_data);
				} else {
				}
			}
		}
		
	}
	} 
	
	if (!((int)$form_data['country'] > 0)) {
		$form_data['country'] = COUNTRY_DEFAULT;
	}
	
	$smarty->assign('auction_sales',PEO_getOptions('auction_sale'));
	$smarty->assign('property_types',PEO_getOptions('property_type'));
	$smarty->assign('price_ranges',PEO_getOptions('price_range'));
	$smarty->assign('bedrooms',PEO_getOptions('bedrooms'));
	$smarty->assign('bathrooms',PEO_getOptions('bathrooms'));
	$smarty->assign('land_sizes',PEO_getOptions('land_size'));
	$smarty->assign('car_spaces',PEO_getOptions('car_spaces'));
	$smarty->assign('car_ports',PEO_getOptions('garage_carport'));
	
	$smarty->assign('states',R_getOptions($form_data['country']));
	$smarty->assign('countries',R_getOptionsStep2());	
	$smarty->assign('form_data',formUnescapes($form_data));
	
?>