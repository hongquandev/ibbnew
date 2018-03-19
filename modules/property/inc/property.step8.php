<?php
$form_data = $agent_creditcard_cls->getFields();
$confirm_payment = 0;
$form_data['creditcard'] = 0;
$property_id = $_SESSION['property']['id'];

include ROOTPATH.'/modules/payment/inc/payment.php';
if (isSubmit()) {
	$price = PE_getMoneyPayment($_SESSION['property']['id']);
	if ((int)$price == 0) {
		$property_cls->update(array('pay_status' => Property::PAY_COMPLETE), 'property_id = '.$_SESSION['property']['id']);
		redirect(ROOTURL.'?module=agent&action=view-dashboard');
	} else {
		
		// BEGIN PAYMENT ARGUMENT 
		$payment_cls = new stdClass();
		$payment_cls->success_url = ROOTURL.'/'.$config_cls->getKey('payment_paypal_return_success');
		$payment_cls->cancel_url = ROOTURL.'/'.$config_cls->getKey('payment_paypal_return_cancel');
		$payment_cls->ipn_url = ROOTURL.'/'.$config_cls->getKey('payment_paypal_return_notify');
		$payment_cls->item_name = $property_cls->getAddress((int)$_SESSION['property']['id']);
		$payment_cls->item_number = $_SESSION['property']['id'];
		$payment_cls->amount = $price;
		$payment_cls->currency_code = 'AUD';
		// END
		print_r($payment_cls);
		die();
		$method = getPost('payment');
		paymentProcess(@$method[0], $payment_cls);
	}
}

//BEGIN CC-OPTION
$options_creditcard = ACC_getOptions($_SESSION['agent']['id']);
$options_creditcard[0] = 'New Credit Card';
$show_cc_container = $form_data['creditcard'] == 0? true : false;
//END
$smarty->assign(array('cc_id' => $cc_id,
					'confirm_payment' => $confirm_payment,
					'review' => PE_getReview($_SESSION['agent']['id'], $_SESSION['property']['id'],$_SESSION['agent']['type']),
					'options_card_type' => CT_getOptions(),
					'options_year' => ACC_getOptionsYear(date('Y') + 10),
					'options_month' => ACC_getOptionsMonth(),
					'options_creditcard' => $options_creditcard,
					'show_cc_container' => $show_cc_container,
					'form_data' => $form_data,
					'pro_type' => PE_isAuction($property_id) ? 'auction' : 'sale',
					//'pay_require' => number_format(PK_getAttribute('price',$_SESSION['property']['id'])), 0, '', ''),
					'payment_money' => PE_getMoneyPayment($_SESSION['property']['id'])
					));

paymentLayout();			
?>
