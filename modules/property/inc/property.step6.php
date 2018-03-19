<?php
$form_data = $agent_creditcard_cls->getFields();
$property_id = $_SESSION['property']['id'];
//die('a');
if (isSubmit()) {
    if ($_SESSION['property']['id'] > 0) {
		$data = array('focus' => isset($_POST['set_focus']) ? 1 : 0,
						'set_jump' => isset($_POST['set_home']) ? 1 : 0,
                        'step' => 6,
                      );
		$property_cls->update($data, 'property_id = '.$_SESSION['property']['id']);		
		redirect(ROOTURL.'?module=payment&action=option&type=property&item_id='.$_SESSION['property']['id']);
	} else{
        redirect(ROOTURL.'?module=agent&action=view-property');
    }
}
// reset


$row = $property_cls->getRow('property_id = '.$property_id);
if ($row['pay_status'] != Property::PAY_COMPLETE ) {
    $property_cls->update(array('focus_status' => 0, 'jump_status' => 0), 'property_id = '.$property_id);
}

$property_cls->update(array('focus_flag' =>0,'jump_flag' => 0 ), 'property_id = '.$property_id);

$focus_status = $row['focus'] == 1? true : false;
$jump_status = $row['set_jump'] == 1? true : false;

$smarty->assign('focus_status',$focus_status);
$smarty->assign('jump_status',$jump_status);

$smarty->assign('focus_price',showPrice_cent(PABasic_getPrice(array('focus'))));
$smarty->assign('home_price',showPrice_cent(PABasic_getPrice(array('home'))));

$smarty->assign(array('review' =>formUnescapes(PE_getReview($_SESSION['agent']['id'], $_SESSION['property']['id'],$_SESSION['agent']['type'])),
				'form_data' => $form_data,
                'property_kinds' => PEO_getKind(),
				'pro_type' => PE_isAuction($property_id) ? 'auction' : 'sale',
				'payment_money' => PE_getMoneyPayment($_SESSION['property']['id'])));

?>
