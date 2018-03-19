<?php	
include_once ROOTPATH.'/modules/general/inc/securepay.class.php';
if (!isset($securepay_cls) or !($securepay_cls instanceof SecurePay)) {
	$_options = array('gateway_url' => $config_cls->getKey('payment_securepay_gateway_url'),
					  'merchant_id' => $config_cls->getKey('payment_securepay_merchant_id'),
					  'password' => $config_cls->getKey('payment_securepay_transaction_password'));
	$securepay_cls = new SecurePay($_options);
}

include_once ROOTPATH.'/modules/agent/inc/agent_creditcard.class.php';
if (!isset($agent_creditcard_cls) or !($agent_creditcard_cls instanceof Agent_creditcard)) {
	$agent_creditcard_cls = new	Agent_creditcard();
}

		
switch (getPost('rq')) {
	/*
	case 'update':
		$property_cls->update(array('pay_status' => Property::PAY_PENDING,'step' => 2),'property_id = '.$_SESSION['property']['id']);
		redirect(ROOTURL.'?module=agent&action=view-property');
	break;
	*/
	case 'update':
	case 'add':
		$data = getPost('fields');
		if (is_array($data) && count($data) > 0) {
			
			$agent_creditcard_cls->addValid(array('field' => 'card_type', 'label' => 'Card type', 'fnc' => array('isRequire' => null)));
			$agent_creditcard_cls->addValid(array('field' => 'card_name', 'label' => 'Name on card', 'fnc' => array('isRequire' => null)));
			$agent_creditcard_cls->addValid(array('field' => 'card_number', 'label' => 'Credit card number', 'fnc' => array('isCardNumber' => null)));
			$agent_creditcard_cls->addValid(array('field' => 'card_verification_value', 'label' => 'Card Verification Value', 
											'fnc' => array('isRequire' => null, 'isNumber' => null, 'isEqualLen' => 3)));
			$agent_creditcard_cls->addValid(array('field' => 'expiration_date', 'label' => 'Expiration date', 
											'fnc' => array('isBigger' => date('Ym')),
											'fnc_msg' => array('isBigger' => 'Expiration date is not invalid.')));
			
			foreach ($data as $key => $val) {
				//if (isset($form_data[$key])) {
					$form_data[$key] = $agent_creditcard_cls->escape($val);
				//}
			}
			
			try {
				
				if ($form_data['creditcard'] > 0) {//update
					if (!$agent_creditcard_cls->isValid(array('card_verification_value' => $data['card_verification_value']))) {
						throw new Exception(implode("<br/>",$agent_creditcard_cls->getErrorsValid()));
					}
					//GET CC-INFORMATION TO PROCESS
				} else {//add
					
					unset($form_data['creditcard']);
					$form_data['agent_id'] = $_SESSION['agent']['id'];
					$form_data['expiration_date'] = $data['expiration_year'].'-'.$data['expiration_month'].'-01';
					$row = array();
					if (strlen(@$form_data['card_number']) > 0) {
						$row = $agent_creditcard_cls->getRow("card_number = '".$form_data['card_number']."'");
					}
					
					if (is_array($row) && count($row) > 0) {
						throw new Exception('Existed card number '.$form_data['card_number'].' in system');
					} else {
						if (!$agent_creditcard_cls->isValid(array('card_type' => $data['card_type'],
														'card_name' => $data['card_name'], 
														'card_number' => $data['card_number'], 
														'card_verification_value' => $data['card_verification_value'], 
														'expiration_date' => $data['expiration_year'].substr('0'.$data['expiration_month'],-2)))) {
							throw new Exception(implode("<br/>",$agent_creditcard_cls->getErrorsValid()));
						}
					
						unset($form_data['expiration_year'],$form_data['expiration_month']);
						$agent_creditcard_cls->insert($form_data);
						$form_data['creditcard'] = $agent_creditcard_cls->insertId();
					}
				}
				
				if ($agent_creditcard_cls->hasError()) {
					throw new Exception('Error during saving data.');
				}
				
				//WE CAN PROCESS IT HERE
				$agent_creditcard_row = $agent_creditcard_cls->getRow('agent_creditcard_id = '.$form_data['creditcard']);
				
				if (is_array($agent_creditcard_row) && count($agent_creditcard_row) > 0) {
					$dt = new DateTime($agent_creditcard_row['expiration_date']);
					//BEGIN PAYMENT
					$pk_price = PK_getAttribute('price',$_SESSION['property']['id']);
					$data = array('amount' => number_format($pk_price, 0, '', ''),
									'card_number' => $agent_creditcard_row['card_number'] ,
									'expiry_month' => $dt->format('m'),
									'expiry_year' => $dt->format('y'),
									'cvv' => $form_data['card_verification_value'],
									'card_name' => $agent_creditcard_row['card_name'],
									'order_no' => 'Order_'.microtime());


					$securepay_cls->send($data);
					$securepay_cls->parseResponse();
					
					if ($securepay_cls->isOk()) {//OR for CC test ||($data_test==$CC_GOS)
						$property_cls->update(array('pay_status' => Property::PAY_COMPLETE, 'step' => 2,'agent_active'=>1),'property_id = '.$_SESSION['property']['id']);
						$_SESSION['property']['id'] = 0;
						$_SESSION['property']['step'] = 0;

						unset($_SESSION['property']['step']);
						$message = 'Saved successful.';

						/* Begin Delete CC for Test - Quan code */
						if (!isset($agent_creditcard_cls) || !($agent_creditcard_cls instanceof Agent_creditcard)) {
							$agent_creditcard_cls = new Agent_creditcard();
						}
						//$agent_creditcard_cls->delete('card_number=4444333322220000');
						/* end Delete CC for Test*/
						$confirm_payment=1;
						//msg_alert('Thank you for complete payment !',ROOTURL.'?module=agent&action=view-property');
						//redirect(ROOTURL.'?module=agent&action=view-dashboard');
					} else {
						$message = $securepay_cls->getStatusMsg();
					}
					//END
					
					$row = $property_cls->getRow('property_id = '.$_SESSION['property']['id']);
					if($row['pay_status'] != Property::PAY_COMPLETE) {
						$property_cls->update(array('pay_status' => Property::PAY_PENDING,'step' => 8),'property_id = '.$_SESSION['property']['id']);
					}
					$property_cls->update(array('step' => 8),'property_id = '.$_SESSION['property']['id']);
				}
			} catch (Exception $e) {
				$form_data = $data;
				$message = $e->getMessage();
			}	
		}	
	break;
}		
?>