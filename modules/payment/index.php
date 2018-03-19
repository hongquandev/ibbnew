<?php
//ini_set("zlib.output_compression", "On");
//session_start();
include_once ROOTPATH . '/modules/property/inc/property.php';
include_once ROOTPATH . '/modules/package/inc/package.php';
include_once ROOTPATH . '/modules/payment/inc/paypal.class.php';
include_once ROOTPATH . '/modules/payment/inc/payment.php';
include_once ROOTPATH . '/modules/cms/inc/cms.php';
include_once ROOTPATH . '/modules/agent/inc/agent.php';
include_once ROOTPATH . '/modules/general/inc/sendmail.php';
include_once ROOTPATH . '/modules/notification/notification.php';
include_once ROOTPATH . '/modules/notification/notification.php';
include_once ROOTPATH . '/modules/notification/notification_app.class.php';
include_once ROOTPATH . '/modules/configuration/inc/config.class.php';
include_once ROOTPATH . '/modules/general/inc/sendmail.php';
if (!isset($config_cls) || !($config_cls instanceof Config)) {
    $config_cls = new Config();
}
include_once ROOTPATH . '/modules/general/inc/card_type.class.php';
include_once ROOTPATH . '/modules/agent/inc/company.php';
if (!isset($region_cls) or !($region_cls instanceof Region)) {
    $region_cls = new Regions();
}
$action = restrictArgs(getParam('action'), '[^0-9a-zA-Z_-]');
if (!isset($paypal_cls) || !($paypal_cls instanceof Paypal)) {
    $options = array('sandbox_mode' => $config_cls->getKey('payment_paypal_sandbox_enable'));
    $paypal_cls = new Paypal($options);
}
switch ($action) {
    case 'success':
    case 'success-property':
    case 'success-extra-options':
    case 'success-banner':
    case 'success-bid':
    case 'success-offer':
    case 'success-buynow':
    case 'success-agent':
        successAction();
        break;
    case 'cancel':
    case 'cancel-property':
    case 'cancel-banner':
    case 'cancel-bid':
    case 'cancel-offer':
    case 'cancel-agent':
        break;
    case 'ipn':
    case 'ipn-property':
    case 'ipn-extra-options':
    case 'ipn-banner':
    case 'ipn-bid':
    case 'ipn-offer':
    case 'ipn-buynow':
    case 'ipn-agent':
        ipnAction();
        break;
    case 'option':
        optionAction();
        break;
    case 'option-post':
        optionPostAction();
        break;
    case 'test':
        testAction();
        break;
    case 'testemail':
        __paymentAlert('1487');
        break;
    default:
        $action = 'default';
        Report_pageRemove(Report_parseUrl());
        //redirect(ROOTURL.'/notfound.html');
        redirect('/notfound.html');
        break;
}
/**
 *
 * @ method : successAction
 **/
function successAction()
{
    global $paypal_cls, $property_cls, $smarty, $config_cls, $payment_store_cls, $type, $action, $session_cls;
    $url = ROOTURL;
    $id = (int)getParam('id');
    $row = $payment_store_cls->getRow('id = ' . (int)$id);
    switch ($action) {
        case 'success':
        case 'success-buynow':
            $property_id = 0;
            if (is_array($row) && count($row) > 0) {
                $property_id = $row['property_id'];
            } else if ((int)getParam('item_number') > 0) {
                $property_id = (int)getParam('item_number');
            }
            if ($property_id > 0) {
                $url = ROOTURL . '/?module=agent&action=view-property';
                $type = getParam('mode', 'payment');
                $smarty->assign('ROOTPATH', ROOTPATH);
                $smarty->assign('review', PE_getInfo($property_id));
                $smarty->assign('contact_email', $config_cls->getKey('general_contact_email'));
                $smarty->assign('type', $type);
                $smarty->assign('item_number', $property_id);
                // SEND ALERT POST
            }
            break;
        case 'success-property':
            $property_id = 0;
            $agent_id = 0;
            if (is_array($row) && count($row) > 0) {
                $property_id = $row['property_id'];
                $agent_id = $row['agent_id'];
            } else if ((int)getParam('item_number') > 0) {
                $property_id = (int)getParam('item_number');
                $property_row = $property_cls->getRow('property_id = ' . (int)$property_id);
                $agent_id = (int)@$property_row['agent_id'];
            }
            $agent_type = AgentType_getTypeAgent($agent_id);
            if ($property_id > 0 && $agent_id > 0) {
                $url = ROOTURL . '/?module=agent&action=view-property';
                $type = getParam('mode', 'payment');
                $smarty->assign('ROOTPATH', ROOTPATH);
                $smarty->assign('review', PE_getReview($agent_id, $property_id, $agent_type));
                $smarty->assign('contact_email', $config_cls->getKey('general_contact_email'));
                $smarty->assign('type', $type);
                $smarty->assign('item_number', $property_id);
                // SEND ALERT POST
                $payment_id = getParam('id', 0);
                __paymentAlert($property_id, $payment_id);
            }
            break;
        case 'success-extra-options':
            $property_id = 0;
            $agent_id = 0;
            if (is_array($row) && count($row) > 0) {
                $property_id = $row['property_id'];
                $agent_id = $row['agent_id'];
            } else if ((int)getParam('item_number') > 0) {
                $property_id = (int)getParam('item_number');
                $property_row = $property_cls->getRow('property_id = ' . (int)$property_id);
                $agent_id = (int)@$property_row['agent_id'];
            }
            $agent_type = AgentType_getTypeAgent($agent_id);
            if ($property_id > 0 && $agent_id > 0) {
                $url = ROOTURL . '/?module=agent&action=view-property';
                $type = getParam('mode', 'payment');
                $smarty->assign('ROOTPATH', ROOTPATH);
                $smarty->assign('review', PE_getReview($agent_id, $property_id, $agent_type));
                $smarty->assign('contact_email', $config_cls->getKey('general_contact_email'));
                $smarty->assign('type', $type);
                $smarty->assign('item_number', $property_id);
                // SEND ALERT POST : Extra Options
                $payment_id = getParam('id', 0);
                __paymentAlertExtraOptions($property_id, $payment_id);
            }
            break;
        case 'success-banner':
            $url = ROOTURL . '/?module=banner&action=my-banner';
            if (getParam('mode') == 'nopay' && (int)getParam('item_number') > 0) {
                $smarty->assign('item_number', getParam('item_number'));
            } else {
                $smarty->assign('item_number', (int)@$row['banner_id']);
            }
            break;
        case 'success-bid':
        case 'success-offer':
            $isDownloadTerm = $config_cls->getKey('termdoc_method_download');
            if ($isDownloadTerm) {
                $url = ROOTURL . '/?module=property&action=view-auction-detail&id=' . (int)@$row['property_id'];
            } else if (@$row['auction_sale'] == 58) {
                $url = ROOTURL . '/?module=term&action=view&pid=' . (int)@$row['property_id'];
            }
            $smarty->assign('item_number', (int)@$row['property_id']);
            break;
        case 'success-agent':
            $url = ROOTURL . '/?module=agent&action=view-payment';
            break;
    }
    $smarty->assign('meta_refresh', '<META HTTP-EQUIV=Refresh CONTENT="2; URL=' . $url . '">');
}

/**
 *
 * @ method : ipnAction
 **/
function ipnAction()
{
    global $action, $paypal_cls, $property_cls, $banner_cls, $bid_first_cls, $payment_store_cls, $smarty, $agent_cls, $agent_payment_cls, $property_package_payment_cls;
    $paypal_cls->setIpnLogFilePre('paypal_' . $action . '_confirm_');
    if (!$paypal_cls->validateIpn()) {
        die('Incorrect PayPal verified');
    }
    $rs = $paypal_cls->getIpnData();
    $agent_active = 0; //    Auto enable for Pro
    $active = 0; // For active bid , make offer first
    $payment_status = Property::PAY_PENDING;
    $step = 1;
    if ($action != 'ipn-register') {
        $payment_row = $payment_store_cls->getRow('id = ' . (int)@$rs['item_number']);
        if (!is_array($payment_row) || count($payment_row) == 0) {
            return;
        }
    } else {
        $agent_row = $agent_cls->getRow('agent_id = ' . (int)@$rs['item_number']);
        if (!is_array($agent_row) || count($agent_row) == 0) {
            return;
        }
    }
    switch (@$rs['payment_status']) {
        case 'Completed':
            $payment_status = Property::PAY_COMPLETE;
            $agent_active = 1;
            $active = 1;
            $step = 2;
            break;
        case 'Pending':
            $payment_status = Property::PAY_PENDING;
            $agent_active = 0;
            $active = 0;
            $step = 2;
            break;
    }
    if ($payment_status > 0) {
        switch ($action) {
            case 'ipn-property':
            case 'ipn':
                $row = $property_cls->getRow('property_id = ' . (int)@$payment_row['property_id']);
                $set_focus = $set_home = 0;
                if (is_array($row) and count($row) > 0) {
                    $set_focus = (int)$row['focus'] == 1 ? 1 : $row['focus_flag'];
                    $set_home = (int)$row['set_jump'] == 1 ? 1 : $row['jump_flag'];
                }
                $property_cls->update(array('pay_status' => $payment_status,
                    'agent_active' => $agent_active,
                    'set_jump' => $set_home,
                    'jump_status' => $set_home,
                    'focus' => $set_focus,
                    'focus_status' => $set_focus,
                    'step' => $step), 'property_id = ' . (int)@$payment_row['property_id']);
                /*Update package Payment*/
                $property_package_payment_cls->update(array('pay_status' => $payment_status, 'payment_id' => (int)@$rs['item_number']),
                    'property_id = ' . (int)@$payment_row['property_id'] . ' AND pay_status != ' . Property::PAY_COMPLETE . ' AND payment_id = 0');
                $smarty->assign('review', formUnescapes(PE_getReview($_SESSION['agent']['id'], (int)@$payment_row['property_id'], $_SESSION['agent']['type'])));
                break;
            case 'ipn-buynow':
                $property_id = (int)@$payment_row['property_id'];
                try {
                    $property_cls->update(array(
                        'confirm_sold' => 1,
                        'stop_bid' => 1,
                        'buynow_buyer_id' => $_SESSION['agent']['id'],
                        'sold_time' => date('Y-m-d H:i:s')),
                        'property_id=' . $property_id);
                    Property_afterSold($property_id);
                    //SEND EMAIL
                } catch (Exception $er) {
                }
                break;
            case 'ipn-extra-options':
                /*Update package Payment*/
                $property_package_payment_cls->update(array('pay_status' => $payment_status, 'payment_id' => (int)@$rs['item_number']),
                    'property_id = ' . (int)@$payment_row['property_id'] . ' AND pay_status != ' . Property::PAY_COMPLETE . ' AND payment_id = 0');
                $smarty->assign('review', formUnescapes(PE_getReview($_SESSION['agent']['id'], (int)@$payment_row['property_id'], $_SESSION['agent']['type'])));
                break;
            case 'ipn-banner':
                if (@$payment_row['agent_id'] > 0 && $payment_status > 0) {
                    include_once ROOTPATH . '/modules/banner/inc/banner.php';
                    $row = $banner_cls->getRow('banner_id = ' . (int)@$payment_row['banner_id']);
                    if (is_array($row) && count($row) > 0) {
                        $data = array('pay_status' => $payment_status, 'agent_status' => 1);
                        if ($row['notification_email'] > 0) {
                            $data['pay_notification_email'] = 1;
                        }
                        $banner_cls->update($data, 'banner_id = ' . (int)@$payment_row['banner_id']);
                    }
                }
                break;
            case 'ipn-bid':
            case 'ipn-offer':
                include_once ROOTPATH . '/modules/general/inc/bids.php';
                $data = array('agent_id' => (int)@$payment_row['agent_id'], 'property_id' => (int)@$payment_row['property_id'], 'active' => $active);
                __updateBidRegister($data);
                //$payment_store_cls->update(array('is_disable'=>1), 'id = '.(int)@$rs['item_number']);
                break;
            case 'ipn-agent':
                $d = fopen('test-payment.txt', 'w');
                $row = $payment_store_cls->getCRow(array('agent_id', 'package_id', 'package_price'), 'id =' . (int)@$rs['item_number']);
                if (is_array($row) and count($row) > 0) {
                    $month = (int)@$rs['mc_gross'] / $row['package_price'];
                    $payment_arr = $agent_payment_cls->getRow("SELECT agent_id, date_to

                                                              FROM " . $agent_payment_cls->getTable() . "

                                                              WHERE payment_id

                                                                    IN (

                                                                    SELECT MAX(payment_id)

                                                                    FROM " . $agent_payment_cls->getTable() . "

                                                                    GROUP BY agent_id

                                                                    )

                                                              AND agent_id = {$row['agent_id']}", true);
                    $current_date = new DateTime(date('Y-m-d H:i:s'));
                    if (is_array($payment_arr) and count($payment_arr) > 0) {
                        $last_date = new DateTime($payment_arr['date_to']);
                    } else {
                        $last_date = new DateTime('0000-00-00');
                    }
                    $date_from = $current_date < $last_date ? $payment_arr['date_to']
                        : date('Y-m-d H:i:s');
                    $agent_payment_cls->insert(array('store_id' => (int)@$rs['item_number'],
                        'package_id' => $row['package_id'],
                        'agent_id' => $row['agent_id'],
                        'date_from' => $date_from,
                        'date_to' => date('Y-m-d H:i:s', strtotime($date_from . " +{$month} month"))));
                    fwrite($d, $date_from . '\n' . $agent_payment_cls->sql);
                    fclose($d);
                }
                break;
        }
    }
    if ($payment_status == Property::PAY_COMPLETE) {
        $payment_store_cls->update(array('cross' => @$rs['mc_gross'], 'cc_transid' => @$rs['txn_id'], 'is_paid' => 1, 'creation_time' => date('Y-m-d H:i:s')), 'id = ' . (int)@$rs['item_number']);
    } else {
        $payment_store_cls->update(array('cross' => @$rs['mc_gross'], 'cc_transid' => @$rs['txn_id'], 'creation_time' => date('Y-m-d H:i:s')), 'id = ' . (int)@$rs['item_number']);
    }
}

/**
 *
 * @ method : optionAction
 **/
function optionAction()
{
    global $session_cls, $property_cls, $payment_store_cls, $banner_cls, $smarty, $config_cls, $property_package_payment_cls, $package_property_option_cls, $package_property_group_cls;
    if ((int)@$_SESSION['agent']['id'] == 0 && !(getParam('agent_id',0) > 0)) {
        $session_cls->setMessage('Please login to use this feature.');
        redirect(ROOTURL);
    }
    $type = getParam('type');
    $item_name = '';
    $item_number = (int)getParam('item_id', 0);
    if ($item_number == 0) {
        $session_cls->setMessage('Invalid action.');
        redirect(ROOTURL);
    }
    $payment_store_id = 0;
    $price = 0;
    $info = '';
    $order_review = array();
    switch ($type) {
        case 'extra-options':
        case 'property':
        case 'bid':
        case 'offer':
        case 'buynow':
            $payment_data = array();
            $row = $property_cls->getRow('property_id = ' . (int)$item_number);
            $item_name = str_replace(array("'", "\\", "/"), array("", "", ""), $property_cls->getAddress($item_number));
            if ($type == 'bid') {
                if ($property_cls->isTheBlock($item_number)) {
                    $payment_data['bid_price'] = PABasic_getPrice(array('bid_block'));
                    $order_review['block'] = array('title' => 'Block', 'price' => $payment_data['bid_price']);
                } else {
                    $payment_data['bid_price'] = PABasic_getPrice(array('bid'));
                    $order_review['bid'] = array('title' => 'Register bid', 'price' => $payment_data['bid_price']);
                }
                $price += $payment_data['bid_price'];
                $payment_data['bid'] = 1;
                push(0, array('type_msg' => 'update-property'));
                //push1(0, array('type_msg' => 'update-property'));
            } else if ($type == 'offer') {
                $payment_data['offer'] = 1;
                $payment_data['offer_price'] = PABasic_getPrice(array('bid'));
                $price += $payment_data['offer_price'];
                $order_review['offer'] = array('title' => 'Offer', 'price' => $payment_data['offer_price']);
            } else if ($type == 'property') {
                $payment_data['focus'] = $row['focus'];
                $payment_data['home'] = $row['set_jump'];
                $payment_data['focus_price'] = 0;
                $tmp_payment_row = $payment_store_cls->getRow('property_id = ' . $row['property_id'] . ' AND focus = 1 AND is_paid = 1 AND is_change = 0');
                if ($row['focus'] > 0 && (int)@$tmp_payment_row['id'] == 0) {
                    $payment_data['focus_price'] = PABasic_getPrice(array('focus'));
                    $order_review['focus'] = array('title' => 'Focus', 'price' => $payment_data['focus_price']);
                }
                $payment_data['home_price'] = 0;
                $tmp_payment_row = $payment_store_cls->getRow('property_id = ' . $row['property_id'] . ' AND home = 1 AND is_paid = 1 AND is_change = 0');
                if ($row['set_jump'] > 0 && (int)@$tmp_payment_row['id'] == 0) {
                    $payment_data['home_price'] = PABasic_getPrice(array('home'));
                    $order_review['home'] = array('title' => 'Home', 'price' => $payment_data['home_price']);
                }
                $payment_data['package_id'] = $row['package_id'];
                $payment_data['package_price'] = 0;
                if ($_SESSION['agent']['type'] != 'agent') {
                    $tmp_payment_row = $payment_store_cls->getRow('property_id = ' . $row['property_id'] . ' AND package_id = ' . (int)$row['package_id'] . ' AND is_paid = 1 AND is_change = 0');
                    if ((int)@$tmp_payment_row['id'] == 0) {
                        $payment_data['package_price'] = PA_getPrice((int)$row['package_id'], (int)$item_number);
                        //$order_review['package'] = array('title' => 'Package: ' . PA_getPackage($row['package_id']), 'price' => $payment_data['package_price']);
                        $packages = $property_package_payment_cls->getRows('property_id = ' . $item_number . '
                                        AND pay_status != ' . Property::PAY_COMPLETE . ' AND payment_id = 0');
                        if (is_array($packages) && count($packages) > 0) {
                            foreach ($packages as $data) {
                                $price_package = 0;
                                if ($data['group_id'] > 0) {
                                    $group_data = $package_property_group_cls->getRow('group_id = ' . $data['group_id']);
                                    if ($data['package_id'] > 0) {
                                        $price_package = PA_getPrice_byGroupPack($data['group_id'], $data['package_id']);
                                        $order_review[] = array('title' => $group_data['name'] . ': <i> ' . PA_getPackage($data['package_id']) . '</i>', 'price' => $price_package);
                                    }
                                    if ($data['option_id'] > 0) {
                                        $row = $package_property_option_cls->getRow('option_id = ' . $data['option_id'] . ' AND group_id = ' . $data['group_id']);
                                        $price_package = $row['price'];
                                        $order_review[] = array('title' => $group_data['name'] . ' #Option: <i>' . $row['name'] . '</i>', 'price' => $price_package);
                                    }
                                }
                            }
                        }
                    }
                }
                $price += $payment_data['home_price'] + $payment_data['focus_price'] + $payment_data['package_price'];
            } else if ($type == 'extra-options') {
                $payment_data['package_price'] = 0;
                if ($_SESSION['agent']['type'] != 'agent') {
                    $payment_data['package_price'] = PA_getPrice((int)$row['package_id'], (int)$item_number);
                    $extra_options = $property_package_payment_cls->getRows('property_id = ' . $item_number . '
                                            AND pay_status != ' . Property::PAY_COMPLETE . ' AND payment_id = 0');
                    if (is_array($extra_options) && count($extra_options) > 0) {
                        foreach ($extra_options as $data) {
                            if ($data['group_id'] > 0) {
                                $group_data = $package_property_group_cls->getRow('group_id = ' . $data['group_id']);
                                if ($data['option_id'] > 0) {
                                    $row = $package_property_option_cls->getRow('option_id = ' . $data['option_id'] . ' AND group_id = ' . $data['group_id']);
                                    $price_package = $row['price'];
                                    $order_review[] = array('title' => $group_data['name'] . ' #Option: <i>' . $row['name'] . '</i>', 'price' => $price_package);
                                }
                            }
                        }
                    }
                }
                $price += $payment_data['package_price'];
            } elseif ($type == 'buynow') {
                $price = floatval($row['buynow_price']);
                $order_review['buynow'] = array('title' => 'Buy Now', 'price' => $price);
            }
            /*---------------------------*/
            //print_r('$price='.$price);die();
            /*---------------------------*/
            if ($price == 0) {
                if ($type == 'extra-options') {
                    $payment_data['property_id'] = $item_number;
                    $payment_data['agent_id'] = $_SESSION['agent']['id'];
                    $payment_data['is_paid'] = 0;
                    $payment_data['amount'] = $price;
                    $payment_data['type'] = $type;
                    $payment_store_id = $payment_store_cls->parentInsert($payment_data);
                    /*Update package Payment*/
                    $property_package_payment_cls->update(
                        array('pay_status' => Property::PAY_COMPLETE, 'payment_id' => $payment_store_id),
                        'property_id = ' . $item_number . ' AND pay_status != ' . Property::PAY_COMPLETE . ' AND payment_id = 0'
                    );
                    //__paymentAlertExtraOptions($item_number, $payment_store_id);
                    redirect(ROOTURL . '?module=payment&action=success-extra-options&item_number=' . $item_number . '&id=' . $payment_store_id);
                } else {
                    if ($type == 'bid') {
                        /*if(getParam('isAjax',false)){
                            $result = array('redirect_link' => PE_getUrl($item_number));
                            async_output_finish($result);
                        }*/
                        //ini_set('display_errors', 1);
                        include_once ROOTPATH . '/modules/general/inc/bids.php';
                        $data = array('agent_id' => (int)getParam('agent_id',0), 'property_id' => (int)$item_number, 'active' => 1);
                        __updateBidRegister($data);
                        // SET value to Payment Store
                        $payment_data['property_id'] = $item_number;
                        $payment_data['agent_id'] = getParam('agent_id',0);
                        $payment_data['is_paid'] = 1;
                        $payment_data['amount'] = 0;
                        $payment_data['creation_time'] = date('Y-m-d H:i:s');
                        //IBB-1573: Approve bidder before start bidding
                        //$payment_data['is_disable'] = 1;
                        $payment_data['type'] = $type;
                        $payment_store_cls->insert($payment_data);
                        $isDownloadTerm = $config_cls->getKey('termdoc_method_download');
                        if ($isDownloadTerm) {
                            $_SESSION['is_showalert'] = in_array($type, array('bid', 'offer')) && ($property_cls->isTheBlock($item_number) || $property_cls->isAgent($item_number)) ? 1 : 0;
                            //redirect(PE_getUrl($item_number));
                        } else if (@$row['auction_sale'] == 58) {
                            //redirect(ROOTURL.'?module=term&action=view&pid='.$item_number);
                        }
                        if(getParam('isAjax',false)){
                            $result = array('redirect_link' => PE_getUrl($item_number));
                            die(json_encode($result));
                        }
                        redirect(PE_getUrl($item_number));
                    } else { //PROPERTY//BUYNOW//OFFER
                        $payment_data['property_id'] = $item_number;
                        $payment_data['agent_id'] = $_SESSION['agent']['id'];
                        $payment_data['is_paid'] = 0;
                        $payment_data['amount'] = $price;
                        //print_r($payment_data);
                        $payment_data['type'] = $type;
                        $payment_data['creation_time'] = date('Y-m-d H:i:s');
                        $payment_store_id = $payment_store_cls->insert($payment_data);
                        /*Update package Payment*/
                        $property_package_payment_cls->update(
                            array('pay_status' => Property::PAY_COMPLETE, 'payment_id' => $payment_store_id),
                            'property_id = ' . $item_number . ' AND pay_status != ' . Property::PAY_COMPLETE . ' AND payment_id = 0'
                        );
                        if($type == 'property'){
                            __paymentAlert($item_number, $payment_store_id);
                            //__paymentAlert($item_number);
                            $data = array('pay_status' => Property::PAY_COMPLETE, 'agent_active' => 1, 'step' => 2);
                            $property_cls->update($data, 'property_id = ' . $item_number);
                        }
                        redirect(ROOTURL . '?module=payment&action=success&mode=registration&item_number=' . $item_number . '&id=' . $payment_store_id);
                    }
                }
            } else {
                $payment_data['property_id'] = $item_number;
                $payment_data['agent_id'] = $_SESSION['agent']['id'];
                $payment_data['is_paid'] = 0;
                $payment_data['amount'] = $price;
                //print_r($payment_data);
                $payment_data['type'] = $type;
                $payment_data['creation_time'] = date('Y-m-d H:i:s');
                $payment_store_id = $payment_store_cls->insert($payment_data);
                //echo $payment_store_id; die();
                // END
                $smarty->assign('item_desc', $item_name);
                $smarty->assign('item_number', $item_number);
                $smarty->assign('order_review', $order_review);
            }
            break;
        case 'banner':
            $price = 0;
            $package_price = 0;
            $row = $banner_cls->getRow('banner_id = ' . $item_number . ' AND agent_id = ' . (int)@$_SESSION['agent']['id']);
            if (is_array($row) && count($row) > 0) {
                $st = strtotime(@$row['date_to']) - strtotime(@$row['date_from']);
                $days = (int)($st / (60 * 60 * 24) + 1);
                //begin
                $type_page_option_ar = array_keys(CMS_getTypePage());
                $page_id_ar = strlen(trim(@$row['page_id'])) > 0 ? explode(',', $row['page_id']) : null;
                if (is_array($page_id_ar) && count($page_id_ar) > 0) {
                    foreach ($page_id_ar as $key => $val) {
                        $page_id_ar[$key] = in_array($val, $type_page_option_ar) ? $val : 10000;
                    }
                } else {
                    $page_id_ar = array(0);
                }
                //end
                $args = array('property_type_id' => (int)@$row['type'],
                    'area' => (int)@$row['display'],
                    'position' => (int)@$row['position'],
                    'page_id_ar' => $page_id_ar,
                    'country_id' => (int)@$row['country'],
                    'state_id' => (int)@$row['state'],
                    'days' => $days);
                //$url_path = '-banner&agent_id='.(int)$_SESSION['agent']['id'];
                $item_name = str_replace(array('\\'), array(''), formUnescape($row['banner_name']));
                $tmp_payment_row = $payment_store_cls->getRow('banner_id = ' . (int)$row['banner_id'] . ' AND notification_email = 1 AND is_paid = 1');
                if ((int)@$tmp_payment_row['id'] == 0 && $row['notification_email'] == 1) {
                    $price = PABasic_getPrice(array('banner_notification_email'));
                    $order_review['notification_email'] = array('title' => 'Notification email', 'price' => $price);
                }
                $package_price = PABanner_getPrices($args);
                $tmp_payment_row = $payment_store_cls->getRow('banner_id = ' . (int)$row['banner_id'] . ' AND package_price = ' . (float)$package_price . ' AND is_paid = 1');
                if ((int)@$tmp_payment_row['id'] == 0) {
                    $price += $package_price;
                    $order_review['package'] = array('title' => 'Package', 'price' => $package_price);
                }
            }
            if ($price == 0) {
                $data = array('pay_status' => Property::PAY_COMPLETE);
                $banner_cls->update($data, 'banner_id = ' . $item_number . ' AND agent_id = ' . (int)$_SESSION['agent']['id']);
                redirect(ROOTURL . '?module=payment&action=success-banner&mode=nopay&item_number=' . $item_number);
            } else {
                // BEGIN PAYMENT STORE
                $payment_data = array('banner_id' => $item_number,
                    'agent_id' => $_SESSION['agent']['id'],
                    'amount' => $price,
                    'notification_email' => (int)$row['notification_email'],
                    'notification_email_price' => PABasic_getPrice(array('banner_notification_email')),
                    'package_id' => 0,
                    'package_price' => $package_price,
                    'is_paid' => 0);
                $payment_data['creation_time'] = date('Y-m-d H:i:s');
                $payment_data['type'] = $type;
                $payment_store_id = $payment_store_cls->insert($payment_data);
                // END
                $smarty->assign('item_desc', $row['banner_name']);
                $smarty->assign('item_number', $item_number);
                $smarty->assign('order_review', $order_review);
                /*
                $info = "<button class='btn-red back-btn-red' onclick=(document.location.href='/?module=banner&action=edit-advertising&id=".$item_number."')><span><span>Back</span></span></button>";
                */
                $info = "<button class='btn-gray' onclick=(document.location.href='/?module=banner&action=edit-advertising&id=" . $item_number . "')><span><span>Back</span></span></button>";
            }
            break;
        case 'agent':
            $payment_store_id = $item_number;
            $row = $payment_store_cls->getRow('id = ' . $item_number);
            if (is_array($row) and count($row) > 0) {
                $package_name = PA_getPackage($row['package_id']);
                $time = $row['amount'] / $row['package_price'];
                $item_desc = $package_name;
                $price = $row['amount'];
                $order_review = array(array('title' => $package_name . ' x ' . $time . ' month(s)',
                    'price' => $price));
                $payment_money = $row['amount'];
            }
            $smarty->assign('item_desc', $item_desc);
            $smarty->assign('order_review', $order_review);
            $smarty->assign('item_number', $item_number);
            break;
        default :
            $session_cls->setMessage('Invalid action.');
            redirect(ROOTURL);
            break;
    }
    $form_action = '/?module=payment&action=option-post&type=' . $type . '&id=' . $payment_store_id;
    //BEGIN CC-OPTION
    $options_creditcard = ACC_getOptions((int)$_SESSION['agent']['id']);
    $options_creditcard[0] = 'New Credit Card';
    //END
    $smarty->assign(array('cc_id' => $cc_id,
        'options_card_type' => CT_getOptions(),
        'options_year' => ACC_getOptionsYear(date('Y') + 10),
        'options_month' => ACC_getOptionsMonth(),
        'options_creditcard' => $options_creditcard,
        'show_cc_container' => $show_cc_container,
        'payment_money' => $price,
        'message' => $session_cls->getMessage(),
        'form_action' => $form_action,
        'info' => $info,
        'is_showalert' => in_array($type, array('bid', 'offer')) && ($property_cls->isTheBlock($item_number) || $property_cls->isAgent($item_number)) ? 1 : 0,
        'isSafari' => isSafari()
    ));
    paymentLayout();
    $smarty->assign('isSafari', isSafari());
}

/**
 *
 * @ method : optionPostAction
 **/
function optionPostAction()
{
    global $payment_store_cls, $banner_cls, $property_cls, $config_cls, $session_cls;
    $id = (int)getParam('id', 0);
    $method = getPost('payment');
    $type = getParam('type');
    if ($id <= 0 || !isSubmit() || !in_array($type, array('bid', 'offer', 'property', 'banner', 'agent', 'extra-options', 'buynow'))) {
        $session_cls->setMessage('Invalid action.');
        redirect(ROOTURL);
        return;
    }
    $payment_store_cls->update(array('payment_type' => @$method[0]), 'id = ' . (int)$id);
    $payment_row = $payment_store_cls->getRow('id = ' . $id);
    if ((int)@$payment_row['amount'] > 0) {
        if ($payment_row['property_id'] > 0) {
            $item_name = str_replace(array("'", "\\", "/"), array("", "", ""), $property_cls->getAddress($payment_row['property_id']));
        } else if ($payment_row['banner_id'] > 0) {
            $row = $banner_cls->getRow('banner_id = ' . $payment_row['banner_id']);
            $item_name = str_replace(array('\\'), array(''), formUnescape($row['banner_name']));
        } else { //register agent auction
            $item_name = 'Payment fee every month';
        }
        $url_path = '-' . $type . '&id=' . $id;
        // BEGIN PAYMENT ARGUMENT
        $payment_cls = new stdClass();
        $payment_cls->success_url = ROOTURL . '/' . $config_cls->getKey('payment_paypal_return_success') . $url_path;
        $payment_cls->cancel_url = ROOTURL . '/' . $config_cls->getKey('payment_paypal_return_cancel') . $url_path;
        $payment_cls->ipn_url = ROOTURL . '/' . $config_cls->getKey('payment_paypal_return_notify') . $url_path;
        $payment_cls->item_name = $item_name;
        $payment_cls->item_number = $id;
        $payment_cls->amount = floatval($payment_row['amount']);
        $payment_cls->currency_code = 'AUD';
        // END
        //var_dump($payment_cls);die();
        paymentProcess(@$method[0], $payment_cls);
    } else {
        redirect(ROOTURL . '?module=agent&action=view-dashboard');
    }
}

/**
 *
 * @ method : testAction
 **/
function testAction()
{
    global $banner_cls;
    $row = $banner_cls->getRow('banner_id = ' . getParam('id', 0));
    //$row = $banner_cls->getRow('banner_id = 35');
    $_SESSION['moha_test'] = '';
    //print_r($row);
    //echo getParam('id', 0);
    if (is_array($row) && count($row) > 0) {
        $st = (int)(strtotime(@$row['date_to']) - strtotime(@$row['date_from']));
        $days = (int)($st / (60 * 60 * 24) + 1);
        //begin
        $type_page_option_ar = array_keys(CMS_getTypePage());
        $page_id_ar = strlen(trim(@$row['page_id'])) > 0 ? explode(',', $row['page_id']) : null;
        //print_r($type_page_option_ar);
        //print_r($page_id_ar);
        if (is_array($page_id_ar) && count($page_id_ar) > 0) {
            foreach ($page_id_ar as $key => $val) {
                $page_id_ar[$key] = in_array($val, $type_page_option_ar) ? $val : 10000;
            }
        } else {
            $page_id_ar = array(0);
        }
        //end
        $args = array('property_type_id' => (int)@$row['type'],
            'area' => (int)@$row['display'],
            'position' => (int)@$row['position'],
            'page_id_ar' => $page_id_ar,
            'country_id' => (int)@$row['country'],
            'state_id' => (int)@$row['state'],
            'days' => $days);
        $url_path = '-banner&agent_id=' . $_SESSION['agent']['id'];
        $item_name = $row['banner_name'];
        $price = 0;
        if ($row['pay_status'] != 2) {
            $price = PABanner_getPrices($args);
            if ((int)$row['notification_email'] > 0) {
                $price += PABasic_getPrice(array('banner_notification_email'));
            }
        } else if ($row['notification_email'] > 0 && $row['pay_notification_email'] == 0) {
            $price = PABasic_getPrice(array('banner_notification_email'));
        }
    }
    //print_r($row);
    print_r($args);
    print_r($price);
    if (isset($_SESSION['moha_test'])) {
        print_r($_SESSION['moha_test']);
    }
    die();
}

/*

 * Push notification for iPhone

 */
/*

function push1($issuer_id = 0, $data = array())

{

    global $notification_app_cls;



    $reg_ids1 = $notification_app_cls->getRegIDs($issuer_id, Notification_app::IPHONE);

    if ($reg_ids1 != null && count($reg_ids1) > 0) {

        $data['issuer_id'] = '';

        push_IPhone($reg_ids1, $data);

    }

}

function push_IPhone($registrationIDs = array(), $data = array())

{

    $passphrase = '123456';

    $ctx = stream_context_create();

    stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');

    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);



    // Open a connection to the APNS server

    $fpstream = stream_socket_client(

        'ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

    //if (!$fp)

    // Encode the payload as JSON

    $payload = json_encode($data);

    foreach ($registrationIDs as $regId) {

        // Build the binary notification

        $deviceToken = utf8_encode($regId);

        $msg = chr (0) . chr (0) . chr (32) . pack ('H*', $deviceToken) . pack ('n', strlen ($payload)) . $payload;

        // Send it to the server

        $result = fwrite($fpstream, $msg, strlen($msg));

    }

    fclose($fp);

}

*/
/**
 *
 * @ method : __updateBidRegister
 **/
function __updateBidRegister($data = array())
{
    global $bid_first_cls, $property_cls, $config_cls, $payment_store_cls, $agent_cls, $property_provider_email_cls,$smarty;
    try {
        if ($data['agent_id'] > 0) {
            $row = $bid_first_cls->getRow('property_id = ' . (int)@$data['property_id'] . ' AND agent_id = ' . (int)@$data['agent_id']);
            if (is_array($row) && count($row) > 0) {
                $bid_first_cls->update(array('pay_bid_first_status' => $data['active'], 'bid_first_time' => date('Y-m-d H:i:s')), 'property_id = ' . (int)@$data['property_id'] . ' AND agent_id = ' . (int)@$data['agent_id']);
            } else {
                $bid_first_cls->insert(array('property_id' => (int)@$data['property_id'],
                    'agent_id' => (int)@$data['agent_id'],
                    'pay_bid_first_status' => $data['active'],
                    'bid_first_time' => date('Y-m-d H:i:s')));
            }
            //IBB-1124:[INT] Property of agent -> show status "No more online bids" is false
            $_row = $property_cls->getRow('SELECT set_count,no_more_bid FROM ' . $property_cls->getTable() . ' WHERE property_id = ' . @$data['property_id'], true);
            if ($_row['no_more_bid'] == 1) {
                $set_count = $_row['set_count'] == 'No More Online Bids' ? 'Auction Live' : $_row['set_count'];
                $property_cls->update(array('no_more_bid' => 0 /*,'set_count'=>$set_count*/), 'property_id = ' . @$data['property_id']);
            }
            /* I
             * SENT for BIDDER
            user_bidder_register_to_bid_bidder*/
            $agent = $agent_cls->getCRow(array('firstname', 'lastname', 'email_address'), 'agent_id = ' . $_SESSION['agent']['id']);
            $link_registered_bidders = ROOTURL . '/?module=agent&action=view-registered_bidders';
            $link_registered_bidders = '<a href="' . $link_registered_bidders . '">' . $link_registered_bidders . '</a> ';
            $params_user_bidder_register_to_bid_bidder = array();
            $params_user_bidder_register_to_bid_bidder['property_id'] = $data['property_id'];
            $params_user_bidder_register_to_bid_bidder['to'] = array($agent['email_address']);
            $params_user_bidder_register_to_bid_bidder['send_mymessage'] = true;
            sendNotificationByEventKey('user_bidder_register_to_bid_bidder', $params_user_bidder_register_to_bid_bidder);
            /* [II]
             * SEND FOR SYSTEM
             * system_property_registered_bid*/
            $params_system = array();
            $params_system['property_id'] = $data['property_id'];
            sendNotificationByEventKey('system_property_registered_bid', $params_system);
            /*
             * user_bidder_register_to_bid
            SEND for Vendor, Landlord, Agent
            */
            $params = array();
            $agentInfo = A_getAgentManageInfo($data['property_id']);
            $params['to'] = array();
            $params['to'][] = $agentInfo['agent_email'];

            $provider_email = $property_provider_email_cls->getRow('property_id = ' . @$data['property_id']);
            if (is_array($provider_email) & count($provider_email) > 0) {
                $params['to'][] = $provider_email['email'];
            }
            /*$vendorInfo = PE_getVendor($data['property_id']);
            $to = $vendorInfo['email_address'];
            $params['to'][] = $to;*/
            $params['to'][] =  $config_cls->getKey('general_contact1_name');
            $params['property_id'] = $data['property_id'];
            $variables = array('[email]' => $agent['email_address'],'[bidder_email_address]' => $agent['email_address'], '[link_approved_register_to_bid]' => $link_registered_bidders);
            include_once ROOTPATH . '/modules/term/inc/bid_term.class.php';
            if (!isset($bid_term_cls) || !($bid_term_cls instanceof Bids_term)) {
                $bid_term_cls = new Bids_term();
            }
            $subject = 'You have received an application for property ID '.$data['property_id'].' - '.PE_getAddressProperty($data['property_id']);
            $bidder = $agent_cls->getCRow(array('agent_id','firstname', 'lastname', 'email_address'), 'agent_id = ' . $data['agent_id']);
            $row_term = $bid_term_cls->getRow('bidder_id = ' . $data['agent_id'] . '');
            if (is_array($row_term) and count($row_term) > 0) {
                $files = unserialize($row_term['files_application_supporting']);
                $files_user = unserialize($row_term['data_user_detail']);
                $smarty->assign('files',$files);
                $smarty->assign('files_user',$files_user);
                $smarty->assign('term',$row_term);
                $file_application = $row_term['file_application'];
                $smarty->assign('file_application', $file_application);
            }
            $smarty->assign('bidder',$bidder);
            $smarty->assign('ROOTURL',ROOTURL);
            $smarty->assign('link_registered_user',$link_registered_bidders);
            if(PE_isRentProperty($data['property_id'])){
                $content = $smarty->fetch(ROOTPATH . '/modules/term/templates/rental_application.email.template.tpl');
            }else{
                $content = $smarty->fetch(ROOTPATH . '/modules/term/templates/sales_application.email.template.tpl');
            }
            /*-----*/
            $params['subject'] = $subject;
            $params['email_content'] = $content;
            //$params['to'][] = 'quan.nguyen@skylinesoft.net';
            $params['send_mymessage'] = true;
            sendNotificationByEventKey('user_bidder_register_to_bid_application', $params, $variables);
            unset( $params['email_content']);
            unset( $params['subject']);
            sendNotificationByEventKey('user_bidder_register_to_bid', $params, $variables);
        }
    } catch (Exception $er) {
        echo $er->getMessage();
    }
}

/**
 *
 * @ method : __paymentAlert
 **/
function __paymentAlert($property_id = 0, $payment_id = 0)
{
    try {
        global $config_cls, $smarty, $property_cls;
        $from = $config_cls->getKey('general_contact_email');
        $to = array($config_cls->getKey('general_alert_post_email'));
        /*
         * NI-178:
         * ADD-New Package Pricing: Send email include the users contact details,
         * property ID number and service to be provided to Admin
        */
        //$msg = 'The property {property_id} has just been posted to system , please login and approve it.';
        $msg = 'The property ID#{property_id} has just been posted to bidRhino.com';
        /*
         $message = 'The property ID#{property_id} has just been posted to system';
         $message = str_replace('{property_id}', $property_id, $message);
        */
        $data = array('contact_email' => $from);
        /* User Information */
        $agent_data = PE_getAgent(0, $property_id);
        $to[] = $agent_data['email_address'];
        $to[] = $config_cls->getKey('general_contact1_name');
        //$to[] = $config_cls->getKey('general_contact2_name');
        $data['agent'] = $agent_data;
        $data['agent']['name'] = $agent_data['firstname'] . ' ' . $agent_data['lastname'];
        $data['agent']['address'] = $agent_data['street'] . ' ' . implode(' ', array($agent_data['suburb'], $agent_data['state_code'], $agent_data['other_state'], $agent_data['postcode'], $agent_data['country_name']));
        /* Package Information*/
        include_once ROOTPATH . '/modules/package/inc/package.php';
        $property_data = $property_cls->getRow('property_id = ' . $property_id);
        $data['property'] = $property_data;
        $data['property']['is_pay'] = (isset($property_data['pay_status']) && $property_data['pay_status'] == Property::PAY_COMPLETE) ? 1 : 0;
        $data['property']['full_address'] = PE_getAddressProperty($property_id);
        $data['property']['pro_kind'] = PEO_getKindName($property_data['kind']);
        $data['property']['package_price'] = showPrice(PA_getPrice(0, $property_id, $payment_id));
        $data['property']['package_id'] = $property_data['package_id'];
        $smarty->assign('data', $data);
        $package = __listPackageByPropertyId($property_id, $payment_id);
        $smarty->assign('packageData', $package);
        $message = $smarty->fetch(ROOTPATH . '/modules/payment/templates/emailtemplate.property.success.tpl');
        $subject = str_replace('{property_id}', $property_id, $msg);
        sendEmail_func($from, $to, $message, $subject);
        /*when a service is purchased ( by anyone, buyer/vendor or Agent)*/
        $params['property_id'] = $property_id;
        $params['email_content'] = $message;
        sendNotificationByEventKey('system_service_purchased', $params);
        /*when a property is posted to bidRhino (to be reviewed)*/
        sendNotificationByEventKey('system_property_posted', $params);
        include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
        if (!isset($log_cls) || !($log_cls instanceof Email_log)) {
            $log_cls = new Email_log();
        }
        $log_cls->createLog('payment_alert');
    } catch (Exception $er) {
        print_r($er->getMessage());
    }
}

/**
 *
 * @ method : __paymentAlertExtraOptions
 **/
function __paymentAlertExtraOptions($property_id, $payment_id)
{
    try {
        if ($property_id > 0) {
            global $config_cls, $smarty, $property_cls;
            $from = $config_cls->getKey('general_contact_email');
            $to = array($config_cls->getKey('general_alert_post_email'));
            $msg = 'The property ID#{property_id} has been paid with extra options successful!';
            $data = array('contact_email' => $from);
            /* User Information */
            $agent_data = PE_getAgent(0, $property_id);
            $to[] = $agent_data['email_address'];
            $to[] = $config_cls->getKey('general_contact1_name');
            $to[] = $config_cls->getKey('general_contact2_name');
            $data['agent'] = $agent_data;
            $data['agent']['name'] = $agent_data['firstname'] . ' ' . $agent_data['lastname'];
            $data['agent']['address'] = $agent_data['street'] . ' ' . implode(' ', array($agent_data['suburb'], $agent_data['state_code'], $agent_data['other_state'], $agent_data['postcode'], $agent_data['country_name']));
            $agent_type = AgentType_getTypeAgent($agent_data['agent_id']);
            /* Property Information */
            $property_data = PE_getReview($agent_data['agent_id'], $property_id, $agent_type);
            $data['property'] = $property_data['info'];
            /* Package Information*/
            include_once ROOTPATH . '/modules/package/inc/package.php';
            $property_data = $property_cls->getRow('property_id = ' . $property_id);
            $property_data['is_pay'] = (isset($property_data['pay_status']) && $property_data['pay_status'] == Property::PAY_COMPLETE) ? 1 : 0;
            $property_data['package_price'] = PA_getPrice(0, $property_id, $payment_id);
            $package = __listPackageByPropertyId($property_id, $payment_id);
            $data['property']['package_id'] = $property_data['package_id'];
            $data['property']['package_price'] = showPrice_cent($property_data['package_price']);
            $data['property']['pro_kind'] = PEO_getKindName($property_data['kind']);
            $smarty->assign('data', $data);
            $smarty->assign('packageData', $package);
            //print_r($package);
            $message = $smarty->fetch(ROOTPATH . '/modules/payment/templates/emailtemplate.property-extra-options.success.tpl');
            //echo $message;
            $subject = str_replace('{property_id}', $property_id, $msg);
            sendEmail_func($from, $to, $message, $subject);
            /*if a change is made to a property*/
            $params = array();
            $params['property_id'] = $property_id;
            $params['email_content'] = $message;
            sendNotificationByEventKey('system_property_changed', $params);
            /*include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
            if (!isset($log_cls) || !($log_cls instanceof Email_log)) {
                $log_cls = new Email_log();
            }
            $log_cls->createLog('payment_alert');*/
        }
    } catch (Exception $er) {
        print_r($er->getMessage());
    }
}

function isSafari()
{
    $browserAsString = $_SERVER['HTTP_USER_AGENT'];
    if (strstr($browserAsString, " AppleWebKit/") && strstr($browserAsString, " Mobile/")) {
        return 1;
    }
    return 0;
}

//print_r($_REQUEST);
$smarty->assign('action', $action);
$smarty->assign('ROOTPATH', ROOTPATH);
?>