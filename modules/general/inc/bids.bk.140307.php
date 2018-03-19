<?php

include_once 'bids.class.php';

include_once 'bids_first.class.php';

include_once ROOTPATH.'/modules/general/inc/bids_mailer.php';

include_once ROOTPATH.'/modules/general/inc/regions.php';

include_once ROOTPATH.'/modules/general/inc/sendmail.php';

include_once ROOTPATH.'/modules/property/inc/property.php';

include_once ROOTPATH.'/modules/agent/inc/agent.php';

include_once ROOTPATH.'/modules/general/inc/bids_stop.class.php';

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

@function : Bid_first_isValid

@param : $agent_id, $property_id

@return :

**/



function bid_first_isvalid($property_id = 0,$agent_id = 0)

{

    global $bid_first_cls,$bid_cls,$property_cls,$agent_cls;



    if ($_SESSION['agent']['type'] != 'theblock' && $_SESSION['agent']['type'] != 'agent'){

        $row = $bid_first_cls->getCRow(array('pay_bid_first_status'),'property_id='.$property_id.' AND agent_id='.$agent_id);

        if(is_array($row) and count($row) > 0){

            return ((int) $row['pay_bid_first_status'] > 0);

        }

    }else{

        $row = $property_cls->getRow("SELECT property_id

                                      FROM ".$property_cls->getTable()." AS pro

                                      WHERE

                                            pro.property_id = {$property_id}

                                                AND

                                                IF((SELECT p.pay_bid_first_status FROM " . $bid_first_cls->getTable() . " AS p

                                                   WHERE p.property_id = {$property_id} AND p.agent_id = " . $_SESSION['agent']['id'] . ")> 0

                                                   ,1

                                                   ,IF(ISNULL(pro.agent_manager) OR pro.agent_manager = 0 OR (SELECT parent_id FROM ".$agent_cls->getTable()." WHERE agent_id = {$_SESSION['agent']['id']}) = 0

                                                       ,pro.agent_id = {$_SESSION['agent']['id']}

                                                       ,pro.agent_manager = {$_SESSION['agent']['id']}

                                                       )

                                                   OR (SELECT a.parent_id FROM ".$agent_cls->getTable()." AS a

                                                       WHERE a.agent_id = pro.agent_id

                                                       ) = {$_SESSION['agent']['id']}

                                                   )"

                                     ,true);

        if (is_array($row) and count($row)>0){

            return true;

        }

    }

    return false;

}



function getRegisterBidValue($property_id = 0,$agent_id = 0){

    global $bid_first_cls,$bid_cls,$property_cls,$agent_cls;

    if ($_SESSION['agent']['type'] == 'theblock'){

        //isManager

        $row = $property_cls->getRow("SELECT property_id

                                      FROM ".$property_cls->getTable()." AS pro

                                      WHERE property_id = {$property_id}

                                      AND (IF(ISNULL(pro.agent_manager) OR pro.agent_manager = 0 OR (SELECT parent_id FROM ".$agent_cls->getTable()." WHERE agent_id = {$_SESSION['agent']['id']}) = 0

                                               ,pro.agent_id = {$agent_id}

                                               ,pro.agent_manager = {$agent_id}

                                               )

                                           OR (SELECT a.parent_id FROM ".$agent_cls->getTable()." AS a

                                               WHERE a.agent_id = pro.agent_id

                                               ) = {$agent_id})

                                           "

                                     ,true);

        if (is_array($row) and count($row)>0){

            return 1;

        }

    }

    $row = $bid_first_cls->getRow('property_id='.$property_id.' AND agent_id='.$agent_id);

    if(is_array($row) and count($row) > 0){

            return $row['pay_bid_first_status'];

    }

    return null;

}

function registerToBid_($property_id = 0,$agent_id = 0)

{

    global $bid_first_cls,$bid_cls;

    //$row = $bid_first_cls->getRow('property_id='.$property_id.' AND agent_id='.$agent_id);

	$row = $bid_first_cls->getRow('SELECT pay_bid_first_status FROM '.$bid_first_cls->getTable().' WHERE property_id='.$property_id.' AND agent_id='.$agent_id, true);

    if(is_array($row) and count($row) > 0) {

        if((int) $row['pay_bid_first_status'] > 0) {

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

@function : Bid_isValid

@param : $agent_id, $property_id

@return :

**/

function Bid_isValid($agent_id = 0, $property_id = 0, $is_autobid = false,$is_makeOffer =false,$agent_type = 'buyer') {

	global $bid_cls, $property_cls, $agent_creditcard_cls, $agent_cls,$bids_stop_cls,$payment_store_cls;

	$output = array();

	try {

		if ($agent_id <= 0 || $property_id <= 0) {

			throw new Exception('Input invalided data.');

		}



        $row = $agent_cls->getRow('SELECT agent_id FROM '.$agent_cls->getTable().' WHERE agent_id = '.$agent_id, true);

        if (!is_array($row) or count($row) <= 0 ) {

			throw new Exception('You account had been deleted.');

        }



        $row = $property_cls->getRow('SELECT property_id, auction_sale, confirm_sold FROM '.$property_cls->getTable().' WHERE property_id = '.$property_id, true);

        if(count($row) > 0 and is_array($row)) {

            if ($row['confirm_sold'] == Property::SOLD_COMPLETE) {

				throw new Exception('This property had been sold.');

			}

        }



        $bid_row = $payment_store_cls->getCRow(array('is_disable','allow'), 'property_id = ' . $property_id . ' AND agent_id = ' . $agent_id . ' AND (bid = 1 OR offer = 1)');

        if (is_array($bid_row) and count($bid_row) > 0) {

            if ($bid_row['allow'] == 0) {
				$err = 'You have not been approved to accept bid.';

				if (@$row['auction_sale'] == 58) { // bid2rent
					$err = 'You have not completed registration bid form OR have not been approved to accept bid. If you have not fill registration form, please <a style="color:#980000;font-size: 14px;" href="javascript:void(0)" onclick="term.goToTerm('.$property_id.','.$agent_id.')"><strong>CLICK HERE</strong></a> to fill form. Thank you !';			
				}
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

		$row = $property_cls->getRow('SELECT property_id, auction_sale, agent_id, active, agent_active, stop_bid, end_time

									  FROM '.$property_cls->getTable().' 

									  WHERE property_id = '.$property_id, true);

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

                            throw new Exception('This is the first time you bid on iBB. We need your full information to notice if you win.<br/>Please  <a style="color:#980000;font-size: 14px;" href="'.ROOTURL.'/?module=agent&action=add-info'.'"> <b>Click Here</b> </a> to complete. Thank you !');

                    }else{

                        $output['redirect'] = ROOTURL.'/?module=payment&action=option&type=bid&item_id='.$property_id;

                        throw new Exception('This is the first time you bid on this property.<br/>Please  <a style="color:#980000;font-size: 14px;" href="'.ROOTURL.'/?module=payment&action=option&type=bid&item_id='.$property_id.'"> <b>Click Here</b> </a> to pay the fee for joining this auction. Thank you !');

                    }

                }

            }else{

                $output['term'] = 1;

            }*/



            if (!bid_first_isvalid($property_id,$agent_id) and $row['agent_id'] != $agent_id ){

                $_SESSION['item_number'] = $property_id;

                if (AI_infoNull($_SESSION['agent']['id'])){

                        throw new Exception('This is the first time you have placed a bid or made an offer on iBB. We need your full information before you can proceed. <br/>Please  <a style="color:#980000;font-size: 14px;" href="'.ROOTURL.'/?module=agent&action=add-info'.'"> <b>Click Here</b> </a> to complete. Thank you !');

                }else{

                    $output['term'] = 1;

                }

            }elseif (Property_isLockBid($property_id)){

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

@function : Bid_isValid

@param : $agent_id, $property_id

@return :

**/

function Bid_isValid_Mobile($agent_id = 0, $property_id = 0, $is_autobid = false,$is_makeOffer =false,$agent_type = 'buyer') {

	global $bid_cls, $property_cls, $agent_creditcard_cls, $agent_cls,$bids_stop_cls,$payment_store_cls;

	$output = array();

	try {

		if ($agent_id <= 0 || $property_id <= 0) {

			throw new Exception('Input invalided data.');

		}



        $row = $agent_cls->getRow('SELECT agent_id FROM '.$agent_cls->getTable().' WHERE agent_id = '.$agent_id, true);

        if (!is_array($row) or count($row) <= 0 ) {

			throw new Exception('You account had been deleted.');

        }



        $row = $property_cls->getRow('SELECT property_id, confirm_sold FROM '.$property_cls->getTable().' WHERE property_id = '.$property_id, true);

        if(count($row) > 0 and is_array($row)) {

            if ($row['confirm_sold'] == Property::SOLD_COMPLETE) {

				throw new Exception('This property had been sold.');

			}

        }



        $bid_row = $payment_store_cls->getCRow(array('is_disable','allow'), 'property_id = ' . $property_id . ' AND agent_id = ' . $agent_id . ' AND (bid = 1 OR offer = 1)');

        if (is_array($bid_row) and count($bid_row) > 0) {

            if ($bid_row['allow'] == 0) {

                throw new Exception('You have not completed registration bid form OR have not been approved to accept bid. Thank you !');

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

									  FROM '.$property_cls->getTable().' 

									  WHERE property_id = '.$property_id, true);

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

                            throw new Exception('This is the first time you bid on iBB. We need your full information to notice if you win.<br/>Please  <a style="color:#980000;font-size: 14px;" href="'.ROOTURL.'/?module=agent&action=add-info'.'"> <b>Click Here</b> </a> to complete. Thank you !');

                    }else{

                        $output['redirect'] = ROOTURL.'/?module=payment&action=option&type=bid&item_id='.$property_id;

                        throw new Exception('This is the first time you bid on this property.<br/>Please  <a style="color:#980000;font-size: 14px;" href="'.ROOTURL.'/?module=payment&action=option&type=bid&item_id='.$property_id.'"> <b>Click Here</b> </a> to pay the fee for joining this auction. Thank you !');

                    }

                }

            }else{

                $output['term'] = 1;

            }*/



            if (!bid_first_isvalid($property_id,$agent_id) and $row['agent_id'] != $agent_id ){

                $_SESSION['item_number'] = $property_id;

                if (AI_infoNull($_SESSION['agent']['id'])){

                        throw new Exception('This is the first time you have placed a bid or made an offer on iBB. We need your full information before you can proceed. Thank you !');

                }else{

                    $output['term'] = 1;

                }

            }elseif (Property_isLockBid($property_id)){

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

@function : Bid_isValid

@param : $agent_id, $property_id

@return :

**/

function AutoBid_isValid($agent_id = 0, $property_id = 0, $is_autobid = false,$is_makeOffer =false) {

	global $bid_cls, $property_cls, $agent_creditcard_cls,$payment_store_cls;



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

									  FROM '.$property_cls->getTable().' 

									  WHERE property_id = '.$property_id, true);

									  

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

                        throw new Exception('This is the first time you bid on iBB. We need your full information to notice if you win.<br/>Please  <a style="color:#980000;font-size: 14px;" href="'.ROOTURL.'/?module=agent&action=add-info'.'"> <b>Click Here</b> </a> to complete. Thank you !');

                   }else{

                        $_SESSION['item_number'] = $property_id;

                        throw new Exception('This is the first time you bid on this property.<br/>Please  <a style="color:#980000;font-size: 14px;" href="'.ROOTURL.'?module=payment&action=option&type=bid&item_id='.$property_id.'"> <b>Click Here</b> </a> to pay the fee for joining this auction. Thank you !');

                   }

               }

            }else{

                $output['error'] = 1;

                $output['term'] = 1;

            }*/



            if (!bid_first_isvalid($property_id,$agent_id)){

                $_SESSION['item_number'] = $property_id;

                if (AI_infoNull($agent_id)){

                    throw new Exception('This is the first time you have placed a bid or made an offer on iBB. We need your full information before you can proceed. <br/>Please  <a style="color:#980000;font-size: 14px;" href="'.ROOTURL.'/?module=agent&action=add-info'.'"> <b>Click Here</b> </a> to complete. Thank you !');

                }else{

                    $output['term'] = 1;

                    $output['error'] = 1;

                }

            }else{

                $bid_row = $payment_store_cls->getCRow(array('is_disable','allow'),'property_id = '.$property_id.' AND agent_id = '.$agent_id.' AND (bid = 1 OR offer = 1)');

                if ($bid_row['allow'] == 0) {

                        throw new Exception('You have not completed registration bid form OR have not been approved to accept bid. If you have not fill registration form, please <a style="color:#980000;font-size: 14px;" href="javascript:void(0)" onclick="term.goToTerm('.$property_id.','.$agent_id.')"><strong>CLICK HERE</strong></a> to fill form. Thank you !');

                }

                if (is_array($bid_row) and count($bid_row) > 0){

                    if ($bid_row['is_disable'] == 1){

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

@function : Bid_autoInfo

@param : $agent_id, $property_id

*/



function Autobid_info($agent_id = 0, $property_id = 0) {



}



/**

@function : Bid_addByBidder

@param : $agent_id, $property_id

@return :

*/



function Bid_addByBidder($agent_id = 0, $property_id = 0, $money_step = 0, $money_full = 0,$allow_mine = false ,$isAutobid = false,$isSendMail = true,$in_room = false) {

	global $bid_cls, $property_cls, $property_term_cls, $auction_term_cls,$bids_mailer_cls,$agent_cls, $config_cls,$property_entity_option_cls;

	if ($money_step == 0) {

		//$money_step = (float)getPost('money_step',0.0);//WHEN BIDDER CHOSE FROM COMBOBOX

		$money_step = (float)restrictArgs(getParam('money_step',0.0));//WHEN BIDDER CHOSE FROM COMBOBOX

	}

	$auction_sale_ar = PEO_getAuctionSale();

    //

    $allow_mine =  Property_isVendor($agent_id,$property_id) ? true : $allow_mine;



    $where = $allow_mine?'':' AND pro.agent_id != '.$agent_id;

	//BEGIN GETTING VALUE FROM PROPERTY

	$row = $property_cls->getRow('SELECT pro.end_time,

										(SELECT pt.value

										FROM '.$property_term_cls->getTable().' AS pt, '.$auction_term_cls->getTable().' AS at

										WHERE pt.auction_term_id = at.auction_term_id 

											  AND pt.property_id = pro.property_id

											  AND at.code = \'auction_start_price\'

										) AS start_price,

											  

										(SELECT pt.value

										FROM '.$property_term_cls->getTable().' AS pt, '.$auction_term_cls->getTable().' AS at

										WHERE pt.auction_term_parent_id = at.auction_term_id 

											  AND pt.property_id = pro.property_id

											  AND at.code = \'initial_auction_increments\'

										) AS money_step,

											  

									    (SELECT 

											IF (ISNULL(bid.price), 0, bid.price)

										FROM '.$bid_cls->getTable().' AS bid

										WHERE bid.property_id = pro.property_id

										ORDER BY bid.price DESC LIMIT 1

										) AS bid_price,



										(SELECT agt.title

										FROM '.$agent_cls->getTable('agent_type').' AS agt

										WHERE agt.agent_type_id = a.type_id

										) AS pro_type,



										(SELECT pro_opt4.code

										FROM '.$property_entity_option_cls->getTable().' AS pro_opt4

										WHERE pro_opt4.property_entity_option_id = pro.auction_sale

										) AS pro_type_code



								  FROM '.$property_cls->getTable().' AS pro

								  LEFT JOIN '.$agent_cls->getTable().' AS a

								  ON a.agent_id = pro.agent_id



								  WHERE pro.property_id = '.$property_id.' 

								  		AND pro.auction_sale != '.$auction_sale_ar['private_sale'].'

										AND pro.stop_bid = 0

										AND pro.active = 1

										AND pro.agent_active = 1 '.$where,true);

	 

	if (is_array($row) && count($row) > 0) {

		$floor_price = (int)$row['bid_price'] > 0 ? $row['bid_price'] : $row['start_price'];

		if ((int)$money_step == 0) {

			$money_step = $row['money_step'];

		}

		

		//BEGIN INSERTING TO DB

		

		$price = $floor_price + $money_step;

		if ($money_full > 0 ) {

			$price = $money_full;

			$money_step = 0.00;

		}



		$data = array('property_id' => $property_id,

					  'agent_id' => $agent_id,

					  'step' => $money_step,

					  'price' => $price,

					  'time' => date('Y-m-d H:i:s'),

					  'data' => ''/*serialize($_SERVER)*/,

                      'in_room'=>($in_room?1:0));

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



		if (!($row['pro_type'] == 'theblock' || ($row['pro_type'] == 'agent' && $row['pro_type_code'] == 'auction'))){

            //BEGIN UPDATE TIME, 5 MINUTES

            $dt = new DateTime($row['end_time']);

            if ( remainTime($row['end_time']) < ((int)$config_cls->getKey('general_loop_bid_time')) ) {

                $new_end_time = date("Y-m-d H:i:s", mktime($dt->format('H'), $dt->format('i'), $dt->format('s') + (int)$config_cls->getKey('general_loop_bid_time') - remainTime($row['end_time']) , $dt->format('m'), $dt->format('d'), $dt->format('Y')));

                $property_cls->update(array('end_time' => $new_end_time),'property_id = '.$property_id);

            }

            //END

        }else{



            $property_cls->update(array('set_count'=>'Auction Live',

                                  'no_more_bid'=>PE_isNoMoreBid($property_id)?1:0),'property_id ='.$property_id);

        }

		return true;

	} 

	

	return false;	

}

/**

@function : Bid_getLastBidByPropertyId

 */

function Bid_isLastBidVendor($property_id = 0,&$in_room = 0) {

    global $bid_cls,$property_cls,$agent_cls;

    $rs = array();

    $result = false;

    if ($property_id > 0) {

        $row = $bid_cls->getRow('SELECT bid.property_id,

                                        bid.agent_id as bid_agent_id,

                                        bid.in_room,

                                        pro.agent_id,pro.agent_manager,

                                        agt.parent_id

                                 FROM '.$bid_cls->getTable().' as bid

                                 LEFT JOIN     '.$property_cls->getTable().' as pro

                                      ON bid.property_id = pro.property_id,

                                      '.$agent_cls->getTable().' AS agt

                                 WHERE  bid.property_id = '.$property_id.'

                                        AND bid.agent_id = agt.agent_id

                                 ORDER BY bid.price DESC', true);

        if (is_array($row) and count($row) > 0 ) {

            $in_room = $row['in_room'];

            if($row['agent_id'] == $row['bid_agent_id'])

            {

                $result = true;

                return $result;

            }

            if (PE_isTheBlock($row['property_id']) || PE_isTheBlock($row['property_id'],'agent')){



                if ($row['agent_manager'] == '' || $row['agent_manager'] == 0 || !isset($row['agent_manager'])){

                    $result = ((in_array($row['agent_id'],A_getChildSimple($row['bid_agent_id'])) ));

                }else{

                    $child = array();

                    if ($row['parent_id'] == 0){

                        $child = A_getChildSimple($row['bid_agent_id']);

                    }

                    $result = ($row['agent_manager'] == $row['bid_agent_id'] || in_array($row['agent_id'],$child));

                }

            }

        }

    }

    return $result;

}

/**

@function : Bid_getLastBidByPropertyId

*/

function Bid_getLastBidByPropertyId($property_id = 0) {

	global $bid_cls;

	$rs = array();

	if ($property_id > 0) {

		$row = $bid_cls->getRow('SELECT property_id,agent_id,price,time,step FROM '.$bid_cls->getTable().' WHERE property_id = '.$property_id.' ORDER BY price DESC', true);

		if (is_array($row) and count($row) > 0 ) {

			$rs = $row;

		}

	}

	return $rs;

}

/**

@function : Bid_getCountBidByPropertyIdAgentId

*/

function Bid_getCountBidByPropertyIdAgentId($property_id = 0, $agent_id = 0) {

	global $bid_cls;

	$rs = 0;

	if ($property_id > 0 AND $agent_id > 0) {

		$row = $bid_cls->getRow('SELECT COUNT(*) AS num FROM '.$bid_cls->getTable().' WHERE property_id = '.$property_id.' AND agent_id = '.$agent_id, true);

		$rs = $row->num;

	}

	return $rs;

}

/**

@function : Bid_getLastBid

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

@function : Bid_showBox

**/

function Bid_showBox($property_id) {

	global $smarty, $autobid_setting_cls;

	$iai_id = AT_getIdByCode('initial_auction_increments');

	$asp_id = AT_getIdByCode('auction_start_price');



	$term_ar = PT_getTermsKeyParentId($property_id);

	$smarty->assign('step_init',$term_ar[$iai_id]);

	$smarty->assign('step_options',AT_getOptions($iai_id));

	$autobid_label = 'Accept';

	

	$row = $autobid_setting_cls->getRow('SELECT money_step, money_max, accept

										 FROM '.$autobid_setting_cls->getTable().' 

										 WHERE agent_id = '.$_SESSION['agent']['id'].' AND property_id = '.$property_id, true);

	$autobid_label = 'Accept';

	$is_autobid = 0;

	

	if (is_array($row) && count($row) > 0) {

		$agent_auction_step = $row['money_step'];

		$agent_maximum_bid = $row['money_max'];

		

		if ($row['accept'] == 1) {

			$autobid_label = 'UnAccept';

			$is_autobid = 1;

		}

		$smarty->assign('agent_auction_step',number_format($agent_auction_step, 0, '', ''));

		$smarty->assign('agent_maximum_bid',number_format($agent_maximum_bid, 0, '', ''));

        $smarty->assign('agent_auction_step_show',showPrice(number_format($agent_auction_step, 0, '', '')));

		$smarty->assign('agent_maximum_bid_show',showPrice(number_format($agent_maximum_bid, 0, '', '')));

	}

	$smarty->assign('is_autobid', $is_autobid);		

	$smarty->assign('autobid_label', $autobid_label);



	return $smarty->fetch(ROOTPATH.'/modules/property/templates/property.auto-bid.popup.tpl');

}



function Bid_getNameLastBidder($property_id = 0) {

	global $agent_cls, $bid_cls;

	$rs = array();

	$row = $agent_cls->getRow('SELECT agt.firstname, 

										agt.lastname

								FROM '.$agent_cls->getTable().' AS agt,'.$bid_cls->getTable().' AS bid

								WHERE agt.agent_id = bid.agent_id AND bid.property_id = '.$property_id.'

								ORDER BY bid.price DESC

								LIMIT 1',true);

	if (is_array($row) && count($row) > 0) {

		$rs = array('firstname' => $row['firstname'], 'lastname' => $row['lastname']);

	}

	return $rs;

}



/**

@function : Bid_getFullNameLastBidder

**/



function Bid_getFullNameLastBidder($property_id = 0) {

	$rs = Bid_getNameLastBidder($property_id);

	if (count($rs) > 0) {

		return implode(' ', $rs);

	}

	return '--';

}



/**

@function : Bid_getFullNameLastBidder

**/



function Bid_getShortNameLastBidder($property_id = 0) {

	$rs = Bid_getNameLastBidder($property_id);

	if (count($rs) > 0) {

		return getShortName(@$rs['firstname'], @$rs['lastname']);

	}

	return '--';

}

/**

@function : Bid_sendSMSEmail

**/



include_once 'report_email.php';

include_once ROOTPATH.'/modules/banner/inc/banner.php';



//include_once 'randomBanner.php';



function Bid_PossMessage_Fb_Tw($property_id, $bid_id)

{

    global $property_cls,$agent_cls,$bid_cls,$config_cls,$fb_cls,$tw_cls,$banner_cls,$region_cls;

    include_once ROOTPATH.'/modules/facebook-twitter/inc/twitter.class.php';

    //POST MESSAGE TO FB/TW

    $bidder = $agent_cls->getRow('SELECT allow_facebook,

                                         allow_twitter,

                                         firstname,

                                         lastname,

                                         email_address

                                  FROM '.$agent_cls->getTable().

                                  ' WHERE agent_id = '.$bid_id,true);

    if (is_array($bidder) and count($bidder) > 0){

             //$fb_cls->postMessage('made a bid at '.ROOTURL.'/?module=property&action=view-auction-detail&id='.$property_id);

            $row = $property_cls->getRow('SELECT pro.property_id, pro.description,pro.address,pro.suburb,pro.postcode,

											(SELECT reg1.name

											FROM '.$region_cls->getTable().' AS reg1

											WHERE reg1.region_id = pro.state

											) AS state_name,



											(SELECT reg3.name

											FROM '.$region_cls->getTable().' AS reg3

											WHERE reg3.region_id = pro.country

											) AS country_name

									     FROM '.$property_cls->getTable().' AS pro

									     WHERE pro.property_id = '.$property_id,true);

            if (is_array($row) and count($row) > 0){

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

                                 (PE_isTheBlock($row['property_id'],'agent')?Agent_getAgent($row['property_id']):array()));

                if ($bidder['allow_facebook'] == 1){

                    $content = array('message' => 'I made a bid for: '.implode(', ',array($row['address'], $row['suburb'], $row['state_name'], $row['postcode'], $row['country_name'])),

                                'name' => 'bidRhino.com',

                                'caption' => implode(', ',array($row['address'], $row['suburb'], $row['state_name'], $row['postcode'], $row['country_name'])),

                                'link' => $link,

                                'description' => strip_tags($row['description']),

                                'picture' =>ROOTURL.'/'.$photo);

                    $fb_cls->postFull($content);

                }



                if ($bidder['allow_twitter'] == 1){

                    $tw_cls = new Twitter($config_cls->getKey('twitter_consumer_key'),$config_cls->getKey('twitter_consumer_secret'));

                    $tw_cls->tweet('made a bid at '.$link);

                }



                //IBB-1642: Email to Agent

                if (PE_isTheBlock($property_id,'agent')){

                    $agentInfo = A_getAgentManageInfo($property_id);

                    $msg = $config_cls->getKey('email_agent_bid_success_msg');

                    $link = '<a href="' . $link . '">' . $link . '</a> ';

                    $subject = str_replace(array('[agent_name]', '[ID]', '[link]', '[rooturl]', '[bidder_name]', '[bidder_email]'),

                                           array($agentInfo['full_name'], $data['property_id'], $link, ROOTURL, $bidder['firstname'] . ' ' . $bidder['lastname'], $bidder['email_address']),

                                           $config_cls->getKey('email_agent_bid_success_subject'));

                    $msg = str_replace(array('[agent_name]', '[ID]', '[link]', '[rooturl]', '[bidder_name]', '[bidder_email]'),

                                       array($agentInfo['full_name'], $data['property_id'], $link, ROOTURL, $bidder['firstname'] . ' ' . $bidder['lastname'], $bidder['email_address']), $msg);

                    sendEmail($config_cls->getKey('general_contact_email'), $agentInfo['agent_email'], $msg, $subject, '');

                }

            }

    }



}



function Bid_sendSMSEmail($property_id, $bid_id,$money = null) {

	global $property_cls,$agent_cls,$bid_cls,$config_cls,$fb_cls,$tw_cls,$banner_cls,$log_cls;

    include_once ROOTPATH.'/modules/facebook-twitter/inc/twitter.class.php';

    //POST MESSAGE TO FB/TW

   /* $bidder = $agent_cls->getRow('SELECT allow_facebook,

                                         allow_twitter

                                  FROM '.$agent_cls->getTable().' 

								  WHERE agent_id = '.$bid_id,true);

    if (is_array($bidder) and count($bidder) > 0){

        if ($bidder['allow_facebook'] == 1){

            $fb_cls->postMessage('made a bid at '.ROOTURL.'/?module=property&action=view-auction-detail&id='.$property_id);

        }

        if ($bidder['allow_twitter'] == 1){

             $tw_cls = new Twitter($config_cls->getKey('twitter_consumer_key'),$config_cls->getKey('twitter_consumer_secret'));

            $tw_cls->tweet('made a bid at '.ROOTURL.'/?module=property&action=view-auction-detail&id='.$property_id);

        }

    }*/



    //END

	$sms_enable = $config_cls->getKey('sms_enable');

	include_once ROOTPATH.'/modules/general/inc/SMS.class.php';

	include_once ROOTPATH.'/modules/general/inc/sms_log.class.php';



	if (!isset($sms_log_cls) || !($sms_log_cls instanceof SMS_log)) {

		$sms_log_cls = new SMS_log();

	}



    if (!isset($message_cls) || !($message_cls instanceof SMS_log)) {

		$message_cls = new Message();

	}

	

	if (!isset($sms_cls) || !($sms_cls instanceof SMS)) {

		$sms_cls = new SMS(array('username' => $config_cls->getKey('sms_username'),

								'password' => $config_cls->getKey('sms_password'),

								'sender_id' => $config_cls->getKey('sms_sender_id'),

								'portal_url' => $config_cls->getKey('sms_gateway_url')));

	}

	

	$msg = '';

	$vendor = array();

	$to_ar = array();

	$data = array();

	

	//VENDER

    if (PE_isTheBlock($property_id,'agent')){

        $vendor = A_getAgentManageInfo($property_id);

    }else{

        $vendor_row = $agent_cls->getRow('SELECT pro.property_id,

											 agt.notify_sms,

											 agt.mobilephone,

											 agt.notify_email,

											 agt.notify_email_bid,

											 agt.email_address,

											 agt.firstname,

											 agt.lastname

									FROM '.$agent_cls->getTable().' AS agt,'.$property_cls->getTable().' AS pro

									WHERE agt.agent_id = pro.agent_id AND pro.property_id = '.$property_id,true);

        if (is_array($vendor_row) && count($vendor_row) > 0) {

            if ($vendor_row['notify_sms'] == 1 && strlen(trim($vendor_row['mobilephone'])) > 0) {

                $vendor['mobilephone'] = $vendor_row['mobilephone'];

            }



            if ($vendor_row['notify_email_bid'] == 1) {

                $vendor['email_address'] = $vendor_row['email_address'];

                $vendor['username'] = $vendor_row['firstname'].' '.$vendor_row['lastname'];

            }

        }

    }





	//BIDDER

	$bidder_rows = $agent_cls->getRows('SELECT DISTINCT 

											agt.agent_id, 

											agt.notify_sms, 

											agt.mobilephone,

											agt.notify_email, 

											agt.notify_email_bid,

											agt.allow_facebook,

											agt.allow_twitter,

											agt.email_address

										FROM '.$agent_cls->getTable().' AS agt,'.$bid_cls->getTable().' AS bid

										WHERE agt.agent_id = bid.agent_id AND bid.property_id = '.$property_id,true);

	if (is_array($bidder_rows) && count($bidder_rows) > 0) {

		foreach ($bidder_rows as $bidder) {

			$_ar = array();

			if ($bidder['notify_sms'] == 1 && strlen(trim($bidder['mobilephone'])) > 0) {

				$_ar['mobilephone'] = $bidder['mobilephone'];

				

			}

			

			if ($bidder['notify_email_bid'] == 1) {

				$_ar['email_address'] = $bidder['email_address'];

                $_ar['name_member'] = A_getFullName($bidder['agent_id']);

			}

			

			if (count($_ar) > 0) {

				$to_ar[] = $_ar;

			}

		}

	}



    // Offer

    $offer_row = $message_cls->getRows("SELECT DISTINCT

                                                 mes.entity_id

                                                ,mes.email_from

                                                ,mes.agent_id_from

                                        FROM ".$message_cls->getTable()." as mes

                                        WHERE mes.entity_id = ".$property_id, true);

    if(is_array($offer_row) and count($offer_row) > 0 )

    {

        foreach($offer_row as $row)

        {

            $offer_email = array();

            $agent_row = $agent_cls->getRow('agent_id='.$row['agent_id_from']);

            if(count($agent_row) > 0 and is_array($agent_row) )

            {

                if($agent_row['notify_email_bid'] == 1 )

                {

                    $offer_email['email_address']= $row['email_from'];

                    $offer_email['name_member'] = A_getFullName($row['agent_id_from']);

                }

                if ($agent_row['notify_sms'] == 1 && strlen(trim($agent_row['mobilephone'])) > 0)

                {

				    $offer_email['mobilephone'] = $agent_row['mobilephone'];

			    }

            }

            if(count($offer_email) > 0)

            {

                $to_ar[] = $offer_email;

            }

            

        }

        /*$content = $config_cls->getKey('email_bidder_msg');

		$link = '<a href="'.ROOTURL.'?module=property&action=view-auction-detail&id='.$property_id.'">'.ROOTURL.'?module=property&action=view-auction-detail&id='.$property_id.'</a>';

		$rooturl = '<a href="'.ROOTURL.'">'.ROOTURL.'</a>';

        $content = str_replace(array('[ID]','[username]','[rooturl]','[link]'),array($property_id,'member',$rooturl,$link),$content);

		sendEmail_func($config_cls->getKey('general_contact_email'),$offer_email,nl2br($content),'Offer Information');*/



    }

    //END offer email





		$pxorows = $property_cls->getRow('SELECT state, suburb

										  FROM '.$property_cls->getTable().' 

										  WHERE property_id ='.$property_id, true);

										  

		$date = date('Y-m-d');

		if (count($pxorows) > 0 && is_array($pxorows) > 0) {

			$brows = $banner_cls->getRows('SELECT banner_file, url FROM '.$banner_cls->getTable().' AS ba

												WHERE  ba.status = 1 AND ba.agent_status = 1 AND ba.notification_email = 1

												AND ba.pay_status = 2 AND ba.date_from <= "'.$date.'" AND "'.$date.'" <= ba.date_to

												AND ba.state = '.$pxorows['state'].' 

												OR ba.suburb IN (SELECT pob.suburb FROM '.$property_cls->getTable().' AS pob

												WHERE  pob.suburb="'.$pxorows['suburb'].'") 

												AND ba.status = 1 AND ba.agent_status = 1 AND ba.notification_email = 1

												AND ba.pay_status = 2 AND ba.date_from <= "'.$date.'" AND "'.$date.'" <= ba.date_to

												ORDER BY RAND() LIMIT 0,5' ,true);

											

			$totalRec = $banner_cls->getFoundRows();



					

			if (count($brows) > 0) {

				foreach($brows as $brow) {

					$waitBanner = '<img src='.ROOTURL.'/store/uploads/banner/images/'.$brow['banner_file'].' width="280" alt="" />';

					$linkBanner = '<li style="padding-bottom:15px; padding-top:10px; margin-left:0px;list-style-type: none"><a href="'.$brow['url'].'" target="_blank" >

									 '.$waitBanner.' </a> </li>';

					$lkB.= $linkBanner;

				}



			} else {

				$brows = $banner_cls->getRows('SELECT banner_file, url FROM '.$banner_cls->getTable().' AS ba

												   WHERE ba.status = 1 AND ba.agent_status = 1 AND ba.notification_email = 1

												   AND ba.pay_status = 2 AND ba.date_from <= "'.$date.'" AND "'.$date.'" <= ba.date_to

												   AND ba.state = 0 

												   OR ba.state IN (SELECT pob.state FROM '.$property_cls->getTable().' AS pob

												   WHERE pob.state='.$pxorows['state'].')

												   AND ba.status = 1 AND ba.agent_status = 1 AND ba.notification_email = 1

												   AND ba.pay_status = 2 AND ba.date_from <= "'.$date.'" AND "'.$date.'" <= ba.date_to

												   ORDER BY RAND() LIMIT 0,5' ,true);



					if(count($brows) > 0) {

						foreach($brows as $brow) {

							$linkBanner = '<li style="padding-bottom:15px; padding-top:10px; margin-left:0px;list-style-type: none"><a href="'.$brow['url'].'" target="_blank" >

											<img src='.ROOTURL.'/store/uploads/banner/images/'.$brow['banner_file'].' width="280" alt="" /> </a> </li>';

							$lkB.= $linkBanner;

						}

					}

				}	

		}	



	if (is_array($vendor) && count($vendor) > 0) { // Send mail To Vendor when there Property had been bidd

		if ($sms_enable == 1 && isset($vendor['mobilephone'])) {

			$text = $config_cls->getKey('sms_vendor_msg');

			$text = str_replace('{property_id}',$property_id,$text);

		

			$sms_cls->send($text,$vendor['mobilephone']);

			$sms_cls->parseResponse();

			$msg = $text."<br/> TO ".$vendor['email_address'].'-'.$vendor['mobilephone']."<br/> RESPONSE :".$sms_cls->getResponse();

			$sms_log_cls->insert(array('message' => $msg,'created_at' => date('Y-m-d H:i:s'),'status' => $sms_cls->getStatus()));

		}

		/*if (isset($vendor['email_address'])) {

			$text = $config_cls->getKey('email_vendor_msg');

            $rooturl = '<a href="'.ROOTURL.'">'.ROOTURL.'</a>';

			$text = str_replace(array('[ID]','[username]','[rooturl]'),array($property_id,$vendor['username'],$rooturl),$text);

			sendEmail_func($config_cls->getKey('general_contact_email'),$vendor['email_address'],nl2br($text),'Bidding Information', $lkB);

            include_once ROOTPATH.'/modules/general/inc/email_log.class.php';

            $log_cls->createLog('bid');

		}*/

	}





	if (is_array($to_ar) && count($to_ar) > 0) { // Begin Send mail to all bidder and Offer

		$to = array();

		$email_ar = array();

        $email_bcc = array();

		$msg = '';

		foreach ($to_ar as $item) {

            $data =array();

			$to[] = $item['mobilephone'];

            $email_bcc[] = $item['email_address'];

            $data['email_address'] = $item['email_address'];

            $data['name_member'] = $item['name_member'];

			$email_ar[]= $data ;

			if (strlen($msg) > 0) {

				$msg .= '<->';

			}

			$msg .= $item['email_address'].'-'.$item['mobilephone'];

		}		

	

		$text = $config_cls->getKey('sms_bidder_msg');

		$text = str_replace(array('{property_id}','{$username}'),array($property_id,'you'),$text);

		

		if ($sms_enable == 1) {

			$sms_cls->send($text,$to);

			$sms_cls->parseResponse();

			$msg = $text."<br/>".$msg."<br/> RESPONSE :".$sms_cls->getResponse();

			$sms_log_cls->insert(array('message' => $msg,'created_at' => date('Y-m-d H:i:s'),'status' => $sms_cls->getStatus()));

		}



        //Begin send Email confirm Bid successful to last bidder

		$text = $config_cls->getKey('email_bid_confirm_msg');

        $rooturl = '<a href="'.ROOTURL.'">'.ROOTURL.'</a>';

        $link = '<a href="'.ROOTURL.'?module=property&action=view-auction-detail&id='.$property_id.'">'.ROOTURL.'?module=property&action=view-auction-detail&id='.$property_id.'</a>';

		$Bid_price = Bid_getLastBidByPropertyId($property_id);

        $agent_email=A_getEmail($bid_id);

        $agent_fullname = A_getFullName($bid_id);

        $subject = str_replace(array('[ID]','[username]','[bidder_name]','[link]','[price]'),array($property_id,$agent_fullname,$agent_fullname,$link,showPrice($Bid_price['price'])),nl2br($config_cls->getKey('email_bid_confirm_subject')));

		$text = str_replace(array('[ID]','[username]','[bidder_name]','[link]','[price]'),array($property_id,$agent_fullname,$agent_fullname,$link,showPrice($Bid_price['price'])),nl2br($text));

        sendEmail_func($config_cls->getKey('general_contact_email'),$agent_email,nl2br($text),$subject,$lkB);

        include_once ROOTPATH.'/modules/general/inc/email_log.class.php';

        $log_cls->createLog('bid');

        

        //End



		//Send for another bidder

		/*foreach($email_ar as $email_addr)

		{

			if($email_addr['email_address'] != $agent_email)

			{



				$content = $config_cls->getKey('email_bidder_msg');

				$link = '<a href="'.ROOTURL.'?module=property&action=view-auction-detail&id='.$property_id.'">'.ROOTURL.'?module=property&action=view-auction-detail&id='.$property_id.'</a>';

				$rooturl = '<a href="'.ROOTURL.'">'.ROOTURL.'</a>';

				$content = str_replace(array('[ID]','[username]','[rooturl]','[link]'),array($property_id,$email_addr['name_member'],$rooturl,$link),$content);

				sendEmail_func($config_cls->getKey('general_contact_email'),$email_addr['email_address'],nl2br($content),'Bidding Information', $lkB);

			}

		}*/

                $email_to = array_diff($email_bcc,array($agent_email));



				$content = $config_cls->getKey('email_bidder_msg');

				$link = '<a href="'.ROOTURL.'?module=property&action=view-auction-detail&id='.$property_id.'">'.ROOTURL.'?module=property&action=view-auction-detail&id='.$property_id.'</a>';

				$rooturl = '<a href="'.ROOTURL.'">'.ROOTURL.'</a>';

                $subject = str_replace(array('[ID]','[username]','[bidder_name]','[rooturl]','[link]','[price]'),array($property_id,'Member','Member',$rooturl,$link,showPrice($Bid_price['price'])),$config_cls->getKey('email_bidder_subject'));

				$content = str_replace(array('[ID]','[username]','[bidder_name]','[rooturl]','[link]','[price]'),array($property_id,'Member','Member',$rooturl,$link,showPrice($Bid_price['price'])),$content);

				sendEmail_func($config_cls->getKey('general_contact_email'),$email_to,nl2br($content),$subject, $lkB);

                include_once ROOTPATH.'/modules/general/inc/email_log.class.php';

                $log_cls->createLog('bid');



		//END

		StaticsReport('bids');



	}					

}



?>