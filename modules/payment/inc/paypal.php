<?php
/*
$_SESSION["Payment_Amount"] = 1;
include 'expresscheckout.php';
*/
include_once 'paypal.class.php';

if (!isset($paypal_cls) || !($paypal_cls instanceof Paypal)) {
	$options = array('sandbox_mode' => $config_cls->getKey('payment_paypal_sandbox_enable'));
	$paypal_cls = new Paypal($options);
}

if (!isset($property_cls) || !($property_cls instanceof Property)) {
	$property_cls = new Property();
}

if (!isset($agent_cls) || !($agent_cls instanceof Agent)) {
	$agent_cls = new Agent();
}

$paypal_cls->addField('business', $config_cls->getKey('payment_paypal_merchant_email'));
$paypal_cls->addField('return', $payment_cls->success_url);
$paypal_cls->addField('cancel_return', $payment_cls->cancel_url);
$paypal_cls->addField('notify_url', $payment_cls->ipn_url);
$paypal_cls->addField('item_name', $payment_cls->item_name);
$paypal_cls->addField('item_number', $payment_cls->item_number);
$paypal_cls->addField('amount', $payment_cls->amount);
$paypal_cls->addField('currency_code', $payment_cls->currency_code);
$paypal_cls->addField('no_note', '1');
$paypal_cls->addField('no_shipping', '1');
$paypal_cls->addField('paymentaction', 'sale');
$paypal_cls->addField('image_url', ROOTURL.'/modules/general/templates/images/ibb-logo-paypal.png');

//$paypal_cls->addField('address_status', 'confirmed ');
//$paypal_cls->addField('paymentaction', 'authorization');

$customer_ar = $agent_cls->getInfoBasic((int)$_SESSION['agent']['id']);
if (is_array($customer_ar) && count($customer_ar) > 0) {
	$paypal_cls->addField('first_name', $customer_ar['firstname']);
	$paypal_cls->addField('last_name', $customer_ar['lastname']);
	$paypal_cls->addField('address1', $customer_ar['street']);
	$paypal_cls->addField('city', $customer_ar['suburb']);
	$paypal_cls->addField('state', $customer_ar['state_name']);
	$paypal_cls->addField('zip', $customer_ar['postcode']);
	$paypal_cls->addField('country', $customer_ar['country_name']);
	$paypal_cls->addField('email', $customer_ar['email_address']);
	$paypal_cls->addField('address_override', 0);
//	$paypal_cls->addField('address_status', 'confirmed');
}

//$paypal_cls->addField('shipping', '0');
//$paypal_cls->addField('handling', '');
//$paypal_cls->addField('tax', '');
//$paypal_cls->addField('custom', '');
//$paypal_cls->addField('invoice', '');


echo $paypal_cls->exportForm();

exit();
?>