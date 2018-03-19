<?php
include_once ROOTPATH.'/modules/package/inc/package.class.php';
include_once ROOTPATH.'/modules/comment/inc/comment.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/note/inc/note.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/modules/general/inc/search_data.php';

if (!($rating_cls) || !($rating_cls instanceof Ratings)) {
	$rating_cls = new Ratings();
}
if (!isset($message_cls) || !($message_cls instanceof Message)) {
	$message_cls = new Message();
}
if (!isset($package_cls) || !($package_cls instanceof Package)) {
	$package_cls = new Package();
}

$property_id = (int)getParam('id',0);
//print_r($_SESSION);
$action=getParam('action');

switch ($action) {
	case 'view-property-rs-sale'://~reset SALE
    case 'view-property-rs-live':
        $act = explode('-',$action);
        $switch_to = '';
        $sale = '';
        switch ($act[3]){
            case 'sale':
                $sale  = '&auction_sale=sale';
                $switch_to = 'private_sale';
                break;
            case 'live':
                $switch_to = $type = getParam('type','auction');
                if (is_numeric($type)){
                    $code_arr = PEO_getOptionById($type);
                    $switch_to = $code_arr['code'];
                }
                break;

        }
        $page = getParam('page','');

		$row = $property_cls->getRow('property_id = '.$property_id.' AND agent_id = '.$_SESSION['agent']['id']);
		if (is_array($row) && count($row) > 0) {
            if($row['confirm_sold'] != Property::SOLD_COMPLETE)
            {
                $_SESSION['property']['id'] = $property_id;
                $_SESSION['property']['step'] = 2;
                //print_r($action.'act='.$act.$sale);
                include_once ROOTPATH.'/modules/payment/inc/payment.php';
                $payment_store_cls->update(array('is_change' => 1), 'property_id = '.(int)$property_id);
                if($page == 'reg-property'){
                    Property_transition($property_id,$_SESSION['agent']['id'],'register',$switch_to,$row);
                }
                else{
                    Property_transition($property_id,$_SESSION['agent']['id'],'passed-in',$switch_to,$row);

                }
                $_SESSION['property']['default_step'] = 2;
                redirect(ROOTURL.'?module=property&action=register&step=2'.$sale);
                exit();
            }
            else
            {
                throw new Exception('This property had been sold');
            }
		}
		redirect(ROOTURL.'/?module=agent&action=view-property');
	break;
}
$browserMobile = detectBrowserMobile();
if ($browserMobile) {
    // LIST
    include_once ''.$module.'.property.mobile.php';
}else{
    $_SESSION['where'] = 'list';
    $_SESSION['order_by'] = 'newest';
    __viewProperty($action);
}



/*
==================================
*/