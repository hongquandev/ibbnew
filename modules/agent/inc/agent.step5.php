<?php
/*print_r($_SESSION);*/
$form_data = $agent_creditcard_cls->getFields();
$confirm_payment = 0;
$form_data['creditcard'] = 0;

include_once ROOTPATH.'/modules/payment/inc/payment.php';
include_once ROOTPATH.'/modules/payment/inc/payment_store.class.php';

if (!$payment_store_cls || !($payment_store_cls instanceof Payment_store)) {
    $payment_store_cls = new Payment_store();
}

$package = PK_getPackage($_SESSION['new_agent']['agent']['package_id']);
if(is_null($package)){
    $package['title'] = 'Agent account';
    $package['price'] = 0;
}
$item_name = 'Register new '.$_type.' account';
if (isSubmit()) {
	if ((int)$package['price'] == 0) {
        $row = $agent_payment_cls->getCRow(array('payment_id'),'agent_id = '.$_SESSION['new_agent']['id']);
        if (!(is_array($row) and count($row) > 0)){
            $current_date = new DateTime(date('Y-m-d'));
            $last_date = new DateTime('0000-00-00');

            $date_from = $current_date < $last_date ? date('Y-m-d H:i:s', strtotime($payment_arr['date_to'] . " +1 day"))
                    : date('Y-m-d H:i:s');
            $agent_payment_cls->insert(array('creation_date'=>date('Y-m-d H:i:s'),
                                            'package_id' => $_SESSION['new_agent']['agent']['package_id'],
                                            'agent_id' => $_SESSION['new_agent']['id'],
                                            'date_from' => $date_from,
                                            'date_to' => date('Y-m-d H:i:s', strtotime($date_from . " +1 month"))));
        }
        redirect(ROOTURL . '?module=agent&action=finish-register');
	} else {
        $payment_store_cls->_insert(array('package_id'=>$_SESSION['new_agent']['agent']['package_id'],
                                         'package_price'=>$package['price'],
                                         'agent_id'=>$_SESSION['new_agent']['id'],
                                         'amount'=>$package['price']));
        $item_number = $payment_store_cls->insertId();
		// BEGIN PAYMENT ARGUMENT 
		$payment_cls = new stdClass();
		$payment_cls->success_url = ROOTURL.'?module=agent&action=finish-register';
		$payment_cls->cancel_url = ROOTURL.'/?module=payment&action=cancel-agent';
		$payment_cls->ipn_url = ROOTURL.'/?module=payment&action=ipn-agent';
		$payment_cls->item_name = $item_name;
		$payment_cls->item_number = $item_number;
		$payment_cls->amount = $package['price'];
		$payment_cls->currency_code = 'AUD';
		// END
		$method = getPost('payment');
        unset($_SESSION['new_agent']);
		paymentProcess(@$method[0], $payment_cls);
	}
}

//BEGIN CC-OPTION
$options_creditcard = ACC_getOptions($_SESSION['new_agent']['id']);
$options_creditcard[0] = 'New Credit Card';
$show_cc_container = $form_data['creditcard'] == 0? true : false;
//END
$smarty->assign(array('cc_id' => $cc_id,
					'options_card_type' => CT_getOptions(),
					'options_year' => ACC_getOptionsYear(date('Y') + 10),
					'options_month' => ACC_getOptionsMonth(),
					'options_creditcard' => $options_creditcard,
					'show_cc_container' => $show_cc_container,
					'payment_money' => $package['price'])
					);
if (!isset($_SESSION['new_agent']['id']) or  $_SESSION['new_agent']['id'] < 1) {
    redirect(ROOTURL.'?module='.$module.'&action='.$action);
}

$smarty->assign('package',$package);
$smarty->assign('item_name',$item_name);
paymentLayout();
?>
