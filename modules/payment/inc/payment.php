<?php
include_once ROOTPATH.'/modules/payment/inc/payment_store.class.php';
if (!$payment_store_cls || !($payment_store_cls instanceof Payment_store)) {
	$payment_store_cls = new Payment_store();
}
/**
@ function : paymentProcess
@ param : method
@ output : 
**/

function paymentProcess($method = '', $payment_cls = null) {
	global $config_cls, $property_cls, $smarty;
	switch ($method) {
		case 'paypal':
		case 'securepay':
			include_once(ROOTPATH.'/modules/payment/inc/'.$method.'.php');
			$smarty->assign('message',$message);
		break;
	}
}

/**
@ function : paymentLayout
@ param : void
@ output : 
**/

function paymentLayout() {
	global $config_cls, $smarty;
	$rows = $config_cls->getRows('SELECT * 
								  FROM '.$config_cls->getTable().' 
								  WHERE `key` LIKE \'%payment_%\' 
								  ORDER BY `key` ASC',true);
	//GET ALL PAYMENTS							  
	$payment_ar = array();							  
	if (is_array($rows) && count($rows) > 0) {
		foreach ($rows as $row) {
			$key_ar = explode('_',$row['key']);
			if (!isset($payment_ar[$key_ar[1]])) {
				$payment_ar[$key_ar[1]] = array();
			}
			$payment_ar[$key_ar[1]][str_replace($key_ar[0].'_'.$key_ar[1].'_','',$row['key'])] = $row['value'];
		}
	}
	
	//FILTER PAYMENTS VALID
	$payment_valid_ar = array();
	if (is_array($payment_ar) && count($payment_ar) > 0) {
		foreach ($payment_ar as $key => $row) {
			if ($row['enable'] == 1) {
				$payment_valid_ar[$key] = $row['enable'];			
			}
		}
	}	
	$smarty->assign('ROOTPATH',ROOTPATH);
	$smarty->assign('payment_method_ar',$payment_valid_ar);
	$smarty->assign('payment_template',$smarty->fetch(ROOTPATH.'/modules/payment/templates/payment.methods.tpl'));
}

?>