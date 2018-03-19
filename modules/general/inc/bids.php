<?php
include_once 'bids.class.php';
include_once 'bids_first.class.php';
include_once ROOTPATH . '/modules/general/inc/bids_mailer.php';
include_once ROOTPATH . '/modules/general/inc/regions.php';
include_once ROOTPATH . '/modules/general/inc/sendmail.php';
include_once ROOTPATH . '/modules/property/inc/property.php';
include_once ROOTPATH . '/modules/agent/inc/agent.php';
include_once ROOTPATH . '/modules/general/inc/bids_stop.class.php';
if (!isset($bids_mailer_cls) || !($bids_mailer_cls instanceof Bids_mailer)) {
    $bids_mailer_cls = new Bids_mailer();
}
if (!isset($bids_stop_cls) || !($bids_stop_cls instanceof Bids_stop)) {
    $bids_stop_cls = new Bids_stop();
}
if (!isset($bid_cls) || !($bid_cls instanceof Bids)) {
    $bid_cls = new Bids();
}
if (!isset($bid_first_cls) || !($bid_first_cls instanceof Bids_first)) {
    $bid_first_cls = new Bids_first();
}
include_once 'autobid_setting.class.php';
if (!isset($autobid_setting_cls) || !($autobid_setting_cls instanceof Autobid_setting)) {
    $autobid_setting_cls = new Autobid_setting();
}
include_once 'bid_room.class.php';
if (!isset($bid_room_cls) || !($bid_room_cls instanceof Bid_room)) {
    $bid_room_cls = new Bid_room();
}
/**
 *
 * @function : Bid_first_isValid
 *
 * @param : $agent_id, $property_id
 *
 * @return :
 **/
function bid_first_isvalid($property_id = 0, $agent_id = 0)
{
    global $bid_first_cls, $bid_cls, $property_cls, $agent_cls;
    if ($_SESSION['agent']['type'] != 'theblock' && $_SESSION['agent']['type'] != 'agent') {
        $row = $bid_first_cls->getCRow(array('pay_bid_first_status'), 'property_id=' . $property_id . ' AND agent_id=' . $agent_id);
        if (is_array($row) and count($row) > 0) {
            return ((int)$row['pay_bid_first_status'] > 0);
        }
    } else {
        $row = $property_cls->getRow("SELECT property_id
                                      FROM " . $property_cls->getTable() . " AS pro
                                      WHERE
                                            pro.property_id = {$property_id}
                                                AND
                                                IF((SELECT p.pay_bid_first_status FROM " . $bid_first_cls->getTable() . " AS p
                                                   WHERE p.property_id = {$property_id} AND p.agent_id = " . $_SESSION['agent']['id'] . ") > 0
                                                   ,1
                                                   ,IF(ISNULL(pro.agent_manager) OR pro.agent_manager = 0 OR (SELECT parent_id FROM " . $agent_cls->getTable() . " WHERE agent_id = {$_SESSION['agent']['id']}) = 0
                                                       ,pro.agent_id = {$_SESSION['agent']['id']}
                                                       ,pro.agent_manager = {$_SESSION['agent']['id']}
                                                       )
                                                   OR (SELECT a.parent_id FROM " . $agent_cls->getTable() . " AS a
                                                       WHERE a.agent_id = pro.agent_id
                                                       ) = {$_SESSION['agent']['id']}
                                                   )"
            , true);
        if (is_array($row) and count($row) > 0) {
            return true;
        }
    }
    return false;
}

function getRegisterBidValue($property_id = 0, $agent_id = 0)
{
    global $bid_first_cls, $bid_cls, $property_cls, $agent_cls;
    if ($_SESSION['agent']['type'] == 'theblock') {
        //isManager
        $row = $property_cls->getRow("SELECT property_id

                                      FROM " . $property_cls->getTable() . " AS pro

                                      WHERE property_id = {$property_id}

                                      AND (IF(ISNULL(pro.agent_manager) OR pro.agent_manager = 0 OR (SELECT parent_id FROM " . $agent_cls->getTable() . " WHERE agent_id = {$_SESSION['agent']['id']}) = 0

                                               ,pro.agent_id = {$agent_id}

                                               ,pro.agent_manager = {$agent_id}

                                               )

                                           OR (SELECT a.parent_id FROM " . $agent_cls->getTable() . " AS a

                                               WHERE a.agent_id = pro.agent_id

                                               ) = {$agent_id})

                                           "
            , true);
        if (is_array($row) and count($row) > 0) {
            return 1;
        }
    }
    $row = $bid_first_cls->getRow('property_id=' . $property_id . ' AND agent_id=' . $agent_id);
    if (is_array($row) and count($row) > 0) {
        return $row['pay_bid_first_status'];
    }
    return null;
}

function registerToBid_($property_id = 0, $agent_id = 0)
{
    global $bid_first_cls, $bid_cls;
    //$row = $bid_first_cls->getRow('property_id='.$property_id.' AND agent_id='.$agent_id);
    $row = $bid_first_cls->getRow('SELECT pay_bid_first_status FROM ' . $bid_first_cls->getTable() . ' WHERE property_id=' . $property_id . ' AND agent_id=' . $agent_id, true);
    if (is_array($row) and count($row) > 0) {
        if ((int)$row['pay_bid_first_status'] > 0) {
            //print_r($property_id.'---'.$agent_id);
            return true;
        } else {
            return false;
        }
    } else {
        /*$data=array('property_id' => $property_id, 'agent_id' => $agent_id, 'pay_bid_first_status' => 0,'bid_first_time' => date('Y-m-d H:i:s'));

        $bid_first_cls->insert($data);*/
        return false;
    }
}

/**
 *
 * @function : Bid_isValid
 *
 * @param : $agent_id, $property_id
 *
 * @return :
 **/
function Bid_isValid($agent_id = 0, $property_id = 0, $is_autobid = false, $is_makeOffer = false, $agent_type = 'buyer')
{
    global $bid_cls, $property_cls, $agent_creditcard_cls, $agent_cls, $bids_stop_cls, $payment_store_cls;
    $output = array();
    $auction_sale_ar = PEO_getAuctionSale();
    try {
        if ($agent_id <= 0 || $property_id <= 0) {
            throw new Exception('Input invalided data.');
        }
        $row = $agent_cls->getRow('SELECT agent_id FROM ' . $agent_cls->getTable() . ' WHERE agent_id = ' . $agent_id, true);
        if (!is_array($row) or count($row) <= 0) {
            throw new Exception('You account had been deleted.');
        }
        $row = $property_cls->getRow('SELECT property_id, auction_sale, confirm_sold FROM ' . $property_cls->getTable() . ' WHERE property_id = ' . $property_id, true);
        if (count($row) > 0 and is_array($row)) {
            if ($row['confirm_sold'] == Property::SOLD_COMPLETE) {
                throw new Exception('This property had been sold.');
            }
        }
        $bid_row = $payment_store_cls->getCRow(array('is_disable', 'allow', 'is_paid'), 'property_id = ' . $property_id . ' AND agent_id = ' . $agent_id . ' AND (bid = 1 OR offer = 1) AND is_paid > 0');
        if (is_array($bid_row) and count($bid_row) > 0) {
            if ($bid_row['allow'] == 0) {
                $err = 'Your registration is still pending approval by the vendor, please await notification that you have been approved as a bidder before making an offer or placing a bid.';
                /*if (@$row['auction_sale'] == $auction_sale_ar['ebiddar']) { // bid2rent
                    $err = 'If you have not fill registration form, please <a style="color:#2f2f2f;font-size: 14px;" href="javascript:void(0)" onclick="term.goToTerm(' . $property_id . ',' . $agent_id . ')"><strong>CLICK HERE</strong></a> to fill form and then wait to approved to bid. Thank you !';
                    throw new Exception($err);
                }*/
                throw new Exception($err);
            }
            if ($bid_row['is_disable'] == 1) {
                throw new Exception('You have been restricted bidding. Please contact vendor/agent to be able to continue bid. Thank you !');
            }
        }
        //no-more-bids:NHUNG
        $stop = $bids_stop_cls->getRow('SELECT stop_id
                                                   FROM ' . $bids_stop_cls->getTable() . '
                                                   WHERE property_id = ' . $property_id . ' AND agent_id = ' . $agent_id, true);
        if (is_array($stop) and count($stop) > 0) {
            throw new Exception('You had registered no more bids.');
        }
        //end
        if (!$is_autobid AND !$is_makeOffer) {
            $row = Bid_getLastBidByPropertyId($property_id);
            if (@$row['agent_id'] == $agent_id) {
                throw new Exception('You are currently the top bid, you do not need to make another bid whilst you are the top bidder.');
            }
        }
        //CHECK CC IS EXIST
        /*$rows = $agent_creditcard_cls->getRows('agent_id = '.$agent_id);

        if (!is_array($rows) || count($rows) <= 0) {

            throw new Exception('Please finish updating your information (eg.: your payment information) before bidding.');

        }*/
        $auction_sale_ar = PEO_getAuctionSale();
        //BEGIN GETTING VALUE FROM PROPERTY
        $row = $property_cls->getRow('SELECT property_id, auction_sale, agent_id, active, agent_active, stop_bid, end_time, start_time
									  FROM ' . $property_cls->getTable() . '
									  WHERE property_id = ' . $property_id, true);
        if (!is_array($row) || count($row) == 0) {
            throw new Exception('This property is not exist.');
        } else {
            if ($row['auction_sale'] == $auction_sale_ar['private_sale']) {
                throw new Exception('You are unable to bid on this property as it is For Sale, not For Auction.');
            }
            /*if ($row['agent_id'] == $agent_id && $agent_type != 'theblock') {
                throw new Exception('You are not allowed to bid on your own property.');
            }*/
            if ($row['active'] == 0) {
                throw new Exception('This property is not approved.');
            }
            if ($row['agent_active'] == 0) {
                throw new Exception('The Vendor has not approved this property yet.');
            }
            // CHECK REGISTER TO BID FUNCTIONS
            if (!bid_first_isvalid($property_id, $agent_id) and $row['agent_id'] != $agent_id) {
                $_SESSION['item_number'] = $property_id;
                if (AI_infoNull($_SESSION['agent']['id'])) {
                    throw new Exception('This is the first time you have placed a bid or made an offer on site. We need your full information before you can proceed. <br/>Please  <a style="color:#2f2f2f;font-size: 14px;" href="' . ROOTURL . '/?module=agent&action=add-info' . '"> <b>Click Here</b> </a> to complete. Thank you !');
                } else {
                    //$output['term'] = 1;
                    throw new Exception('Sorry, You need register bid before.');
                }
            } elseif (Property_isLockBid($property_id)) {
                throw new Exception('Sorry, this property is not ready for bidding.');
            }
            if (!$is_makeOffer) {
                if ($row['start_time'] == '5000-05-05 00:00:00') {
                    throw new Exception('You have register to bid successful, Please wait property is going live auction to bid. Thank you !');
                }
                if ($row['start_time'] > date('Y-m-d H:i:s')) {
                    throw new Exception('You have register to bid successful, Please wait property is going live auction to bid. Thank you !');
                }
                if ($row['stop_bid'] == 1) {
                    throw new Exception('Bidding has stopped on this property (the Auction has finished).');
                }
                if ($row['end_time'] <= date('Y-m-d H:i:s')) {
                    throw new Exception('Bidding has stopped on this property (the Auction has finished).');
                }
                $info = PT_getKeyValue($property_id);
                if ((int)@$info['auction_start_price'] == 0) {
                    throw new Exception('The property information is not complete (Start price)..');
                }
                if ((int)@$info['initial_auction_increments'] == 0) {
                    throw new Exception('The property information is not complete (Initial increment)..');
                }
            }

            //end
        }
    } catch (Exception $e) {
        $output['error'] = true;
        $output['msg'] = $e->getMessage();
    }
    return $output;
}

/**
 *
 * @function : Bid_isValid
 *
 * @param : $agent_id, $property_id
 *
 * @return :
 **/
function Bid_isValid_Mobile($agent_id = 0, $property_id = 0, $is_autobid = false, $is_makeOffer = false, $agent_type = 'buyer')
{
    global $bid_cls, $property_cls, $agent_creditcard_cls, $agent_cls, $bids_stop_cls, $payment_store_cls;
    $output = array();
    try {
        if ($agent_id <= 0 || $property_id <= 0) {
            throw new Exception('Input invalided data.');
        }
        $row = $agent_cls->getRow('SELECT agent_id FROM ' . $agent_cls->getTable() . ' WHERE agent_id = ' . $agent_id, true);
        if (!is_array($row) or count($row) <= 0) {
            throw new Exception('You account had been deleted.');
        }
        $row = $property_cls->getRow('SELECT property_id, confirm_sold FROM ' . $property_cls->getTable() . ' WHERE property_id = ' . $property_id, true);
        if (count($row) > 0 and is_array($row)) {
            if ($row['confirm_sold'] == Property::SOLD_COMPLETE) {
                throw new Exception('This property had been sold.');
            }
        }
        $bid_row = $payment_store_cls->getCRow(array('is_disable', 'allow'), 'property_id = ' . $property_id . ' AND agent_id = ' . $agent_id . ' AND (bid = 1 OR offer = 1)');
        if (is_array($bid_row) and count($bid_row) > 0) {
            if ($bid_row['allow'] == 0) {
                throw new Exception('Your registration is still pending approval by the vendor, please await notification that you have been approved as a bidder before making an offer or placing a bid!');
            }
            if ($bid_row['is_disable'] == 1) {
                throw new Exception('You have been restricted bidding. Please contact vendor/agent to be able to continue bid. Thank you !');
            }
        }
        //no-more-bids:NHUNG
        $stop = $bids_stop_cls->getRow('SELECT stop_id

                                                   FROM ' . $bids_stop_cls->getTable() . '

                                                   WHERE property_id = ' . $property_id . ' AND agent_id = ' . $agent_id, true);
        if (is_array($stop) and count($stop) > 0) {
            throw new Exception('You had registered no more bids.');
        }
        //end
        if (!$is_autobid AND !$is_makeOffer) {
            $row = Bid_getLastBidByPropertyId($property_id);
            if (@$row['agent_id'] == $agent_id) {
                throw new Exception('You are currently the top bid, you do not need to make another bid whilst you are the top bidder.');
            }
        }
        //CHECK CC IS EXIST
        /*$rows = $agent_creditcard_cls->getRows('agent_id = '.$agent_id);

        if (!is_array($rows) || count($rows) <= 0) {

            throw new Exception('Please finish updating your information (eg.: your payment information) before bidding.');

        }*/
        $auction_sale_ar = PEO_getAuctionSale();
        //BEGIN GETTING VALUE FROM PROPERTY
        $row = $property_cls->getRow('SELECT property_id, auction_sale, agent_id, active, agent_active, stop_bid, end_time

									  FROM ' . $property_cls->getTable() . '

									  WHERE property_id = ' . $property_id, true);
        if (!is_array($row) || count($row) == 0) {
            throw new Exception('This property is not exist.');
        } else {
            if ($row['auction_sale'] == $auction_sale_ar['private_sale']) {
                throw new Exception('You are unable to bid on this property as it is For Sale, not For Auction.');
            }
            /*if ($row['agent_id'] == $agent_id && $agent_type != 'theblock') {

                throw new Exception('You are not allowed to bid on your own property.');

            }*/
            if ($row['active'] == 0) {
                throw new Exception('This property is not approved.');
            }
            if ($row['agent_active'] == 0) {
                throw new Exception('The Vendor has not approved this property yet.');
            }
            if ($row['stop_bid'] == 1) {
                throw new Exception('Bidding has stopped on this property (the Auction has finished).');
            }
            if ($row['end_time'] <= date('Y-m-d H:i:s')) {
                throw new Exception('Bidding has stopped on this property (the Auction has finished).');
            }
            $info = PT_getKeyValue($property_id);
            if ((int)@$info['auction_start_price'] == 0) {
                throw new Exception('The property information is not complete (Start price)..');
            }
            if ((int)@$info['initial_auction_increments'] == 0) {
                throw new Exception('The property information is not complete (Initial increment)..');
            }
            //check bid first : Quan code
            //NH EDIT:
            /*$bid_first_status = getRegisterBidValue($property_id,$agent_id);

            if($bid_first_status != null || $bid_first_status > 0){

                if ($bid_first_status == 0){

                    $_SESSION['item_number'] = $property_id;

                    if (AI_infoNull($_SESSION['agent']['id'])){

                            throw new Exception('This is the first time you bid on iBB. We need your full information to notice if you win.<br/>Please  <a style="color:#2f2f2f;font-size: 14px;" href="'.ROOTURL.'/?module=agent&action=add-info'.'"> <b>Click Here</b> </a> to complete. Thank you !');

                    }else{

                        $output['redirect'] = ROOTURL.'/?module=payment&action=option&type=bid&item_id='.$property_id;

                        throw new Exception('This is the first time you bid on this property.<br/>Please  <a style="color:#2f2f2f;font-size: 14px;" href="'.ROOTURL.'/?module=payment&action=option&type=bid&item_id='.$property_id.'"> <b>Click Here</b> </a> to pay the fee for joining this auction. Thank you !');

                    }

                }

            }else{

                $output['term'] = 1;

            }*/
            if (!bid_first_isvalid($property_id, $agent_id) and $row['agent_id'] != $agent_id) {
                $_SESSION['item_number'] = $property_id;
                if (AI_infoNull($_SESSION['agent']['id'])) {
                    throw new Exception('This is the first time you have placed a bid or made an offer on iBB. We need your full information before you can proceed. Thank you !');
                } else {
                    $output['term'] = 1;
                }
            } elseif (Property_isLockBid($property_id)) {
                throw new Exception('Sorry, this property is not ready for bidding.');
            }
            //end
        }
    } catch (Exception $e) {
        $output['error'] = true;
        $output['msg'] = $e->getMessage();
    }
    return $output;
}

/**
 *
 * @function : Bid_isValid
 *
 * @param : $agent_id, $property_id
 *
 * @return :
 **/
function AutoBid_isValid($agent_id = 0, $property_id = 0, $is_autobid = false, $is_makeOffer = false)
{
    global $bid_cls, $property_cls, $agent_creditcard_cls, $payment_store_cls;
    $output = array();
    try {
        if ($agent_id <= 0 || $property_id <= 0) {
            throw new Exception('Input invalided data.');
        }
        //CHECK CC IS EXIST
        /*

        $rows = $agent_creditcard_cls->getRows('agent_id = '.$agent_id);

        if (!is_array($rows) || count($rows) <= 0) {

            throw new Exception('Please finish updating your information (eg.: your payment information) before bidding.');

        }

        */
        $auction_sale_ar = PEO_getAuctionSale();
        //BEGIN GETTING VALUE FROM PROPERTY
        $row = $property_cls->getRow('SELECT confirm_sold, auction_sale, agent_id, active, agent_active, stop_bid, end_time

									  FROM ' . $property_cls->getTable() . '

									  WHERE property_id = ' . $property_id, true);
        if (!is_array($row) || count($row) == 0) {
            throw new Exception('This property is not exist.');
        } else {
            if ($row['confirm_sold'] == Property::SOLD_COMPLETE) {
                throw new Exception('This property had been sold.');
            }
            if ($row['auction_sale'] == $auction_sale_ar['private_sale']) {
                throw new Exception('You are unable to bid on this property as it is For Sale, not For Auction.');
            }
            if ($row['agent_id'] == $agent_id) {
                throw new Exception('You are not allowed to bid on your own property.');
            }
            if ($row['active'] == 0) {
                throw new Exception('This property is not approved.');
            }
            if ($row['agent_active'] == 0) {
                throw new Exception('The Vendor has not approved this property yet.');
            }
            if ($row['stop_bid'] == 1) {
                throw new Exception('Bidding has stopped on this property (the Auction has finished).');
            }
            if ($row['end_time'] <= date('Y-m-d H:i:s')) {
                throw new Exception('Bidding has stopped on this property (the Auction has finished).');
            }
            $info = PT_getKeyValue($property_id);
            if ((int)@$info['auction_start_price'] == 0) {
                throw new Exception('The property information is not complete (Start price)..');
            }
            if ((int)@$info['initial_auction_increments'] == 0) {
                throw new Exception('The property informaiton is not complete (Initial increment)..');
            }
            //check bid first : Quan code
            /*$bid_first_status = getRegisterBidValue($property_id,$agent_id);

            if($bid_first_status != null){

               if ($bid_first_status == 0){

                   if (AI_infoNull($_SESSION['agent']['id'])){

                        throw new Exception('This is the first time you bid on iBB. We need your full information to notice if you win.<br/>Please  <a style="color:#2f2f2f;font-size: 14px;" href="'.ROOTURL.'/?module=agent&action=add-info'.'"> <b>Click Here</b> </a> to complete. Thank you !');

                   }else{

                        $_SESSION['item_number'] = $property_id;

                        throw new Exception('This is the first time you bid on this property.<br/>Please  <a style="color:#2f2f2f;font-size: 14px;" href="'.ROOTURL.'?module=payment&action=option&type=bid&item_id='.$property_id.'"> <b>Click Here</b> </a> to pay the fee for joining this auction. Thank you !');

                   }

               }

            }else{

                $output['error'] = 1;

                $output['term'] = 1;

            }*/
            if (!bid_first_isvalid($property_id, $agent_id)) {
                $_SESSION['item_number'] = $property_id;
                if (AI_infoNull($agent_id)) {
                    throw new Exception('This is the first time you have placed a bid or made an offer on iBB. We need your full information before you can proceed. <br/>Please  <a style="color:#2f2f2f;font-size: 14px;" href="' . ROOTURL . '/?module=agent&action=add-info' . '"> <b>Click Here</b> </a> to complete. Thank you !');
                } else {
                    $output['term'] = 1;
                    $output['error'] = 1;
                }
            } else {
                $bid_row = $payment_store_cls->getCRow(array('is_disable', 'allow'), 'property_id = ' . $property_id . ' AND agent_id = ' . $agent_id . ' AND (bid = 1 OR offer = 1)');
                if ($bid_row['allow'] == 0) {
                    throw new Exception('Your registration is still pending approval by the vendor, please await notification that you have been approved as a bidder before making an offer or placing a bid!');
                    //new site not have this function.
                    //If you have not fill registration form, please <a style="color:#2f2f2f;font-size: 14px;" href="javascript:void(0)" onclick="term.goToTerm('.$property_id.','.$agent_id.')"><strong>CLICK HERE</strong></a> to fill form. Thank you !');
                }
                if (is_array($bid_row) and count($bid_row) > 0) {
                    if ($bid_row['is_disable'] == 1) {
                        throw new Exception('You have been restricted bidding. Please contact vendor/agent to be able to continue bid. Thank you !');
                    }
                }
            }
            //end
        }
    } catch (Exception $e) {
        $output['error'] = true;
        $output['msg'] = $e->getMessage();
    }
    return $output;
}

/**
 *
 * @function : Bid_autoInfo
 *
 * @param : $agent_id, $property_id
 */
function Autobid_info($agent_id = 0, $property_id = 0)
{
}

/**
 *
 * @function : Bid_addByBidder
 *
 * @param : $agent_id, $property_id
 *
 * @return :
 */
function Bid_addByBidder($agent_id = 0, $property_id = 0, $money_step = 0, $money_full = 0, $allow_mine = false, $isAutobid = false, $isSendMail = true, $in_room = false, $is_offer = false)
{
    global $bid_cls, $property_cls, $property_term_cls, $auction_term_cls, $bids_mailer_cls, $agent_cls, $config_cls, $property_entity_option_cls;
    if ($money_step == 0) {
        //$money_step = (float)getPost('money_step',0.0);//WHEN BIDDER CHOSE FROM COMBOBOX
        $money_step = (float)restrictArgs(getParam('money_step', 0.0));//WHEN BIDDER CHOSE FROM COMBOBOX
    }
    $auction_sale_ar = PEO_getAuctionSale();
    //
    $allow_mine = Property_isVendor($agent_id, $property_id) ? true : $allow_mine;
    $where = $allow_mine ? '' : ' AND pro.agent_id != ' . $agent_id;
    //BEGIN GETTING VALUE FROM PROPERTY
    $row = $property_cls->getRow('SELECT pro.end_time,

										(SELECT pt.value

										FROM ' . $property_term_cls->getTable() . ' AS pt, ' . $auction_term_cls->getTable() . ' AS at

										WHERE pt.auction_term_id = at.auction_term_id 

											  AND pt.property_id = pro.property_id

											  AND at.code = \'auction_start_price\'

										) AS start_price,

											  

										(SELECT pt.value

										FROM ' . $property_term_cls->getTable() . ' AS pt, ' . $auction_term_cls->getTable() . ' AS at

										WHERE pt.auction_term_parent_id = at.auction_term_id 

											  AND pt.property_id = pro.property_id

											  AND at.code = \'initial_auction_increments\'

										) AS money_step,

											  

									    (SELECT 

											IF (ISNULL(bid.price), 0, bid.price)

										FROM ' . $bid_cls->getTable() . ' AS bid

										WHERE bid.property_id = pro.property_id

										ORDER BY bid.price DESC LIMIT 1

										) AS bid_price,



										(SELECT agt.title

										FROM ' . $agent_cls->getTable('agent_type') . ' AS agt

										WHERE agt.agent_type_id = a.type_id

										) AS pro_type,



										(SELECT pro_opt4.code

										FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt4

										WHERE pro_opt4.property_entity_option_id = pro.auction_sale

										) AS pro_type_code



								  FROM ' . $property_cls->getTable() . ' AS pro

								  LEFT JOIN ' . $agent_cls->getTable() . ' AS a

								  ON a.agent_id = pro.agent_id



								  WHERE pro.property_id = ' . $property_id . '

								  		AND pro.auction_sale != ' . $auction_sale_ar['private_sale'] . '

										AND pro.stop_bid = 0

										AND pro.active = 1

										AND pro.agent_active = 1 ' . $where, true);
    if (is_array($row) && count($row) > 0) {
        $floor_price = (int)$row['bid_price'] > 0 ? $row['bid_price'] : $row['start_price'];
        if ((int)$money_step == 0) {
            $money_step = $row['money_step'];
        }
        //BEGIN INSERTING TO DB
        $price = $floor_price + $money_step;
        if ($money_full > 0) {
            $price = $money_full;
            $money_step = 0.00;
        }
        $data = array('property_id' => $property_id,
            'agent_id' => $agent_id,
            'step' => $money_step,
            'price' => $price,
            'time' => date('Y-m-d H:i:s'),
            'data' => ''/*serialize($_SERVER)*/,
            'in_room' => ($in_room ? 1 : 0),
            'is_offer' => ($is_offer ? 1 : 0));
        $bid_cls->insert($data);
        //END
        //Send Mail bid
        /*if($isSendMail)

        {

            if (!isset($bids_mailer_cls) || !($bids_mailer_cls instanceof Bids_mailer)) {

                $bids_mailer_cls = new Bids_mailer();

            }

            $data_bidsMail = array('property_id' => $property_id,

                                  'agent_id' => $agent_id,

                                  'bid_price' => $price,

                                  'bid_time' => date('Y-m-d H:i:s'),

                                  'email' => A_getEmail($agent_id),

                                  'sent' => 0);

             $bids_mailer_cls->insert($data_bidsMail);

        }*/
        //END
        if (!($row['pro_type'] == 'theblock' || ($row['pro_type'] == 'agent' && $row['pro_type_code'] == 'auction'))) {
            //BEGIN UPDATE TIME, 5 MINUTES
            $dt = new DateTime($row['end_time']);
            if (remainTime($row['end_time']) < ((int)$config_cls->getKey('general_loop_bid_time'))) {
                $new_end_time = date("Y-m-d H:i:s", mktime($dt->format('H'), $dt->format('i'), $dt->format('s') + (int)$config_cls->getKey('general_loop_bid_time') - remainTime($row['end_time']), $dt->format('m'), $dt->format('d'), $dt->format('Y')));
                $property_cls->update(array('end_time' => $new_end_time), 'property_id = ' . $property_id);
            }
            //END
        } else {
            $property_cls->update(array('set_count' => 'Auction Live',
                'no_more_bid' => PE_isNoMoreBid($property_id) ? 1 : 0), 'property_id =' . $property_id);
        }
        return true;
    }
    return false;
}

/**
 *
 * @function : Bid_getLastBidByPropertyId
 */
function Bid_isLastBidVendor($property_id = 0, &$in_room = 0)
{
    global $bid_cls, $property_cls, $agent_cls;
    $rs = array();
    $result = false;
    if ($property_id > 0) {
        $row = $bid_cls->getRow('SELECT bid.property_id,

                                        bid.agent_id as bid_agent_id,

                                        bid.in_room,

                                        pro.agent_id,pro.agent_manager,

                                        agt.parent_id

                                 FROM ' . $bid_cls->getTable() . ' as bid

                                 LEFT JOIN     ' . $property_cls->getTable() . ' as pro

                                      ON bid.property_id = pro.property_id,

                                      ' . $agent_cls->getTable() . ' AS agt

                                 WHERE  bid.property_id = ' . $property_id . '

                                        AND bid.agent_id = agt.agent_id

                                 ORDER BY bid.price DESC', true);
        if (is_array($row) and count($row) > 0) {
            $in_room = $row['in_room'];
            if ($row['agent_id'] == $row['bid_agent_id']) {
                $result = true;
                return $result;
            }
            if (PE_isTheBlock($row['property_id']) || PE_isTheBlock($row['property_id'], 'agent')) {
                if ($row['agent_manager'] == '' || $row['agent_manager'] == 0 || !isset($row['agent_manager'])) {
                    $result = ((in_array($row['agent_id'], A_getChildSimple($row['bid_agent_id']))));
                } else {
                    $child = array();
                    if ($row['parent_id'] == 0) {
                        $child = A_getChildSimple($row['bid_agent_id']);
                    }
                    $result = ($row['agent_manager'] == $row['bid_agent_id'] || in_array($row['agent_id'], $child));
                }
            }
        }
    }
    return $result;
}

/**
 *
 * @function : Bid_getLastBidByPropertyId
 */
function Bid_getLastBidByPropertyId($property_id = 0)
{
    global $bid_cls;
    $rs = array();
    if ($property_id > 0) {
        $row = $bid_cls->getRow('SELECT property_id,agent_id,price,time,step,is_offer FROM ' . $bid_cls->getTable() . ' WHERE property_id = ' . $property_id . ' ORDER BY price DESC', true);
        if (is_array($row) and count($row) > 0) {
            $rs = $row;
        }
    }
    return $rs;
}

/**
 *
 * @function : Bid_getCountBidByPropertyIdAgentId
 */
function Bid_getCountBidByPropertyIdAgentId($property_id = 0, $agent_id = 0)
{
    global $bid_cls;
    $rs = 0;
    if ($property_id > 0 AND $agent_id > 0) {
        $row = $bid_cls->getRow('SELECT COUNT(*) AS num FROM ' . $bid_cls->getTable() . ' WHERE property_id = ' . $property_id . ' AND agent_id = ' . $agent_id, true);
        $rs = $row->num;
    }
    return $rs;
}

/**
 *
 * @function : Bid_getLastBid
 */
/*

function Bid_getLastBid() {

	global $bid_cls;

	$rs = array();

	$row = $bid_cls->getRow();

	if (is_array($row) and count($row) > 0 ) {

		$rs = $row;

	}

	return $rs;

}

*/
/**
 *
 * @function : Bid_showBox
 **/
function Bid_showBox($property_id)
{
    global $smarty, $autobid_setting_cls;
    $iai_id = AT_getIdByCode('initial_auction_increments');
    $asp_id = AT_getIdByCode('auction_start_price');
    $term_ar = PT_getTermsKeyParentId($property_id);
    $smarty->assign('step_init', $term_ar[$iai_id]);
    $smarty->assign('step_options', AT_getOptions($iai_id));
    $autobid_label = 'Accept';
    $row = $autobid_setting_cls->getRow('SELECT money_step, money_max, accept

										 FROM ' . $autobid_setting_cls->getTable() . '

										 WHERE agent_id = ' . $_SESSION['agent']['id'] . ' AND property_id = ' . $property_id, true);
    $autobid_label = 'Accept';
    $is_autobid = 0;
    if (is_array($row) && count($row) > 0) {
        $agent_auction_step = $row['money_step'];
        $agent_maximum_bid = $row['money_max'];
        if ($row['accept'] == 1) {
            $autobid_label = 'UnAccept';
            $is_autobid = 1;
        }
        $smarty->assign('agent_auction_step', number_format($agent_auction_step, 0, '', ''));
        $smarty->assign('agent_maximum_bid', number_format($agent_maximum_bid, 0, '', ''));
        $smarty->assign('agent_auction_step_show', showPrice(number_format($agent_auction_step, 0, '', '')));
        $smarty->assign('agent_maximum_bid_show', showPrice(number_format($agent_maximum_bid, 0, '', '')));
    }
    $smarty->assign('is_autobid', $is_autobid);
    $smarty->assign('autobid_label', $autobid_label);
    return $smarty->fetch(ROOTPATH . '/modules/property/templates/property.auto-bid.popup.tpl');
}

function Bid_getNameLastBidder($property_id = 0)
{
    global $agent_cls, $bid_cls;
    $rs = array();
    $row = $agent_cls->getRow('SELECT agt.firstname,

										agt.lastname

								FROM ' . $agent_cls->getTable() . ' AS agt,' . $bid_cls->getTable() . ' AS bid

								WHERE agt.agent_id = bid.agent_id AND bid.property_id = ' . $property_id . '

								ORDER BY bid.price DESC

								LIMIT 1', true);
    if (is_array($row) && count($row) > 0) {
        $rs = array('firstname' => $row['firstname'], 'lastname' => $row['lastname']);
    }
    return $rs;
}

/**
 *
 * @function : Bid_getFullNameLastBidder
 **/
function Bid_getFullNameLastBidder($property_id = 0)
{
    $rs = Bid_getNameLastBidder($property_id);
    if (count($rs) > 0) {
        return implode(' ', $rs);
    }
    return '--';
}

/**
 *
 * @function : Bid_getFullNameLastBidder
 **/
function Bid_getShortNameLastBidder($property_id = 0)
{
    $rs = Bid_getNameLastBidder($property_id);
    if (count($rs) > 0) {
        return getShortName(@$rs['firstname'], @$rs['lastname']);
    }
    return '--';
}

/**
 *
 * @function : Bid_sendSMSEmail
 **/
include_once 'report_email.php';
include_once ROOTPATH . '/modules/banner/inc/banner.php';
//include_once 'randomBanner.php';
function Bid_PossMessage_Fb_Tw($property_id, $bid_id)
{
    global $property_cls, $agent_cls, $bid_cls, $config_cls, $fb_cls, $tw_cls, $banner_cls, $region_cls;
    include_once ROOTPATH . '/modules/facebook-twitter/inc/twitter.class.php';
    //POST MESSAGE TO FB/TW
    $bidder = $agent_cls->getRow('SELECT allow_facebook,

                                         allow_twitter,

                                         firstname,

                                         lastname,

                                         email_address

                                  FROM ' . $agent_cls->getTable() .
        ' WHERE agent_id = ' . $bid_id, true);
    if (is_array($bidder) and count($bidder) > 0) {
        //$fb_cls->postMessage('made a bid at '.ROOTURL.'/?module=property&action=view-auction-detail&id='.$property_id);
        $row = $property_cls->getRow('SELECT pro.property_id, pro.description,pro.address,pro.suburb,pro.postcode,

											(SELECT reg1.name

											FROM ' . $region_cls->getTable() . ' AS reg1

											WHERE reg1.region_id = pro.state

											) AS state_name,



											(SELECT reg3.name

											FROM ' . $region_cls->getTable() . ' AS reg3

											WHERE reg3.region_id = pro.country

											) AS country_name

									     FROM ' . $property_cls->getTable() . ' AS pro

									     WHERE pro.property_id = ' . $property_id, true);
        if (is_array($row) and count($row) > 0) {
            $_photo = PM_getPhoto($row['property_id']);
            $photo = $_photo['photo_default'];
            /*$data['photo'] = $_photo['photo'];

            $data['photo_default'] = $_photo['photo_default'];

            if(count($data['photo']) == 0){

                $data['info']['photo_default'] = $_photo['photo_default_detail'];

            }

            $_photo = PM_getPhoto($row['property_id']);*/
            /*if(count($_photo['photo']) == 0){

                $photo = $_photo['photo_default_detail'];

            }else{$photo = $_photo['photo'][0]['file_name'];}*/
            $link_ar = array('module' => 'property',
                'action' => '',
                'id' => $row['property_id']);
            $link_ar['action'] = 'view-auction-detail';
            $link = shortUrl($link_ar + array('data' => $row),
                (PE_isTheBlock($row['property_id'], 'agent') ? Agent_getAgent($row['property_id']) : array()));
            if ($bidder['allow_facebook'] == 1) {
                $content = array('message' => 'I made a bid for: ' . implode(', ', array($row['address'], $row['suburb'], $row['state_name'], $row['postcode'], $row['country_name'])),
                    'name' => SITE_TITLE,
                    'caption' => implode(', ', array($row['address'], $row['suburb'], $row['state_name'], $row['postcode'], $row['country_name'])),
                    'link' => $link,
                    'description' => strip_tags($row['description']),
                    'picture' => ROOTURL . '/' . $photo);
                $fb_cls->postFull($content);
            }
            if ($bidder['allow_twitter'] == 1) {
                $tw_cls = new Twitter($config_cls->getKey('twitter_consumer_key'), $config_cls->getKey('twitter_consumer_secret'));
                $tw_cls->tweet('made a bid at ' . $link);
            }
            //IBB-1642: Email to Agent
            if (PE_isTheBlock($property_id, 'agent')) {
                $agentInfo = A_getAgentManageInfo($property_id);
                $msg = $config_cls->getKey('email_agent_bid_success_msg');
                $link = '<a href="' . $link . '">' . $link . '</a> ';
                $subject = str_replace(array('[agent_name]', '[ID]', '[link]', '[rooturl]', '[bidder_name]', '[bidder_email]'),
                    array($agentInfo['full_name'], $data['property_id'], $link, ROOTURL, $bidder['firstname'] . ' ' . $bidder['lastname'], $bidder['email_address']),
                    $config_cls->getKey('email_agent_bid_success_subject'));
                $msg = str_replace(array('[agent_name]', '[ID]', '[link]', '[rooturl]', '[bidder_name]', '[bidder_email]'),
                    array($agentInfo['full_name'], $data['property_id'], $link, ROOTURL, $bidder['firstname'] . ' ' . $bidder['lastname'], $bidder['email_address']), $msg);
                sendEmail($config_cls->getKey('general_contact_email'), $agentInfo['agent_email'], $msg, $subject, '');
                //sendSMSByKey($agentInfo['agent_email'],'agent_bid_success',$data['property_id']);
            }
        }
    }
}

function Bid_sendSMSEmail($property_id, $bid_id, $money = null)
{
    global $property_cls, $agent_cls, $bid_cls, $config_cls, $payment_store_cls, $watchlist_cls, $log_cls, $message_cls;
    $watcher_list_emails = $bidder_emails = $register_bidder_emails = $vendor = array();
    $bid_price = showPrice(PE_getBidPrice($property_id));
    $total_price = showPrice(PT_getValueByCode($property_id, 'reserve'));
    //GET VENDORS
    $vendor = A_getAgentManageInfo($property_id);
    $params_email = array();
    $params_email['property_id'] = $property_id;
    $params_email['to'] = array($vendor['agent_email'], $config_cls->getKey('general_contact1_name'));
    sendNotificationByEventKey('user_bid_placed_in_an_auction', $params_email, array('[bid_amount]' => $bid_price, '[total_amount]' => $total_price));
    //GET BIDDER
    $bidder_rows = $agent_cls->getRows('SELECT DISTINCT
											agt.agent_id,
											agt.notify_sms,
											agt.mobilephone,
											agt.notify_email,
											agt.notify_email_bid,
											agt.allow_facebook,
											agt.allow_twitter,
											agt.email_address
										FROM ' . $agent_cls->getTable() . ' AS agt,' . $bid_cls->getTable() . ' AS bid
										WHERE agt.agent_id = bid.agent_id AND bid.property_id = ' . $property_id, true);
    if (is_array($bidder_rows) && count($bidder_rows) > 0) {
        foreach ($bidder_rows as $bidder) {
            if ($bidder['notify_email_bid'] == 1) {
                $bidder_emails[] = $bidder['email_address'];
            }
        }
    }
    // GET Offer
    $offer_row = $message_cls->getRows("SELECT DISTINCT
                                                 mes.entity_id
                                                ,mes.email_from
                                                ,mes.agent_id_from
                                        FROM " . $message_cls->getTable() . " as mes
                                        WHERE mes.entity_id = " . $property_id . "
                                            AND mes.offer_price > 0", true);
    if (is_array($offer_row) and count($offer_row) > 0) {
        foreach ($offer_row as $row) {
            $agent_row = $agent_cls->getRow('agent_id=' . $row['agent_id_from']);
            if (count($agent_row) > 0 and is_array($agent_row)) {
                if ($agent_row['notify_email_bid'] == 1) {
                    $bidder_emails[] = $row['email_from'];
                }
            }
        }
    }
    $params_email = array();
    $params_email['property_id'] = $property_id;
    $params_email['to'] = $bidder_emails;
    sendNotificationByEventKey('user_bid_placed_in_an_auction_previous_highest_bidder', $params_email, array('[bid_amount]' => $bid_price, '[total_amount]' => $total_price));
    /*REGISTER BIDDER*/
    $row_reg_bid = $payment_store_cls->getRows('SELECT SQL_CALC_FOUND_ROWS
                                                     pay.property_id,
                                                     pay.agent_id,
                                                     pay.creation_time,
                                                     pay.is_paid,
                                                     pay.is_disable,
                                                     pay.allow,
                                                     agt.firstname,
                                                     agt.lastname,
                                                     agt.agent_id AS Agent_id,
                                                     agt.email_address,
                                                     agt.notify_email_bid,
                                                     (SELECT count(bid.agent_id)
                                                            FROM ' . $bid_cls->getTable() . ' AS bid
                                                            WHERE 1 AND bid.agent_id = pay.agent_id
                                                            ) AS bid_number
                                                     FROM ' . $payment_store_cls->getTable() . ' AS pay,' . $agent_cls->getTable() . ' AS agt
                                            WHERE   pay.agent_id = agt.agent_id
                                                    AND 1
                                                    AND pay.property_id = ' . $property_id . '
                                                    AND (pay.bid = 1 OR pay.offer = 1)
                                                    AND pay.is_paid > 0
                                            ORDER BY pay.creation_time DESC', true);
    if (count($row_reg_bid) > 0 and is_array($row_reg_bid)) {
        foreach ($row_reg_bid as $row) {
            if ($row['notify_email_bid'] == 1) {
                $register_bidder_emails[] = $row['email_address'];
            }
        }
    }
    $params_email = array();
    $params_email['property_id'] = $property_id;
    $params_email['to'] = array_diff($register_bidder_emails, $bidder_emails);
    sendNotificationByEventKey('user_bid_placed_in_an_auction_registered_bidders', $params_email, array('[bid_amount]' => $bid_price, '[total_amount]' => $total_price));
    // GET WATCHER LIST
    $watchlist_rows = $watchlist_cls->getRows('SELECT DISTINCT agt.email_address, agt.mobilephone, agt.notify_email,agt.notify_email_bid,
                                                            agt.notify_sms, agt.firstname, agt.lastname
                                                            FROM ' . $watchlist_cls->getTable() . ' AS wl,' . $agent_cls->getTable() . ' AS agt
                                                            WHERE wl.agent_id = agt.agent_id
                                                                    AND agt.is_active = 1
                                                                    AND wl.property_id = ' . $property_id, true);
    if (is_array($watchlist_rows) && count($watchlist_rows) > 0) {
        foreach ($watchlist_rows as $wl_row) {
            if (true) {
                if ($wl_row['notify_email_bid'] == 1) {
                    $watcher_list_emails[] = $wl_row['email_address'];
                }
            }
        }//end foreach
    }//end if
    $params_email = array();
    $params_email['property_id'] = $property_id;
    $params_email['to'] = $watcher_list_emails;
    sendNotificationByEventKey('user_bid_placed_in_an_auction_user_in_watchlist', $params_email, array('[bid_amount]' => $bid_price, '[total_amount]' => $total_price));
    include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
    $log_cls->createLog('bid');
    //END
    StaticsReport('bids');
}

?>