<?php
include ROOTPATH.'/modules/payment/inc/payment.php';

$property_id = getParam('property_id',0);
$smarty->assign('property_id',$property_id);
if (isSubmit()) {
	$price = PE_getMoneyPayment($_SESSION['property']['id']);
	if ((int)$price == 0) {
		$property_cls->update(array('pay_status' => Property::PAY_COMPLETE), 'property_id = '.$_SESSION['property']['id']);
		redirect(ROOTURL.'?module=agent&action=view-dashboard');
	} else {
		$method = getPost('payment');
		paymentProcess(@$method[0]);
	}
}


paymentLayout();
 
