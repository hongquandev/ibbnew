<?php 
$property_id = restrictArgs(getParam('property_id',0));
$jsons = array();
$mine = getParam('mine',0);
$in_room = getParam('room');
$jsons['property_id'] = $property_id;
//FIX ON APP
if(restrictArgs(getParam('money',0)) !== 0){
    if(getParam('money_step') == ''){
        $_GET['money_step'] = restrictArgs(getParam('money',0));
        $_POST['money_step'] = restrictArgs(getParam('money',0));
    }
}

if (in_array($_SESSION['agent']['type'],array('theblock','agent')) && $mine){
	$money = restrictArgs(getParam('money',0));
	if ($money == 0){
		$jsons['success'] = false;
		$jsons['msg'] = 'Error';
	}
	//$in_room = $room === 'true'?1:0;

	if (Bid_addByBidder($_SESSION['agent']['id'],$property_id,$money,0,true,false,true,$in_room)) {
		$jsons['success'] = true;
		$jsons['msg'] = 'Your bid is successful';
		if (APE_ENABLE) {
			$jsons['ape'] = __getBidAction($property_id);
		}
	}
}else{
	if ($bid_room_cls->isExist($_SESSION['agent']['id'], $property_id)) {
		$jsons['success'] = false;
		$jsons['msg'] = 'You have an Auto Bid set for this property and you are currenlty next in queue to bid on this property. If you want to manually place bids now please turn off your autobid.';
		return $jsons;
	}

	$output = Bid_isValid($_SESSION['agent']['id'], $property_id);
	if (count($output) > 0) {
		$jsons['success'] = false;
		$jsons['msg'] = $output['msg'];
	} else {
		$jsons['success'] = false;
		$jsons['msg'] = 'You have just been outbid, please bid again !';
		if (!$property_cls->isLocked($property_id) || $property_cls->isExpire($property_id)) {
			$property_cls->lock($property_id);

			if (Bid_addByBidder(@$_SESSION['agent']['id'],$property_id)) {
				$jsons['success'] = true;
				$jsons['msg'] = 'Your bid is successful';
				//Bid_sendSMSEmail($property_id,$_SESSION['agent']['id']);

				Bid_PossMessage_Fb_Tw($property_id,$_SESSION['agent']['id']);
				/*
					$row = Bid_getLastBidByPropertyId($property_id);
				$price = $row['price'];
				$data = array('property_id' => $property_id,
						'agent_id' => @$_SESSION['agent']['id'],
						'bid_price' => $price,
						'bid_time' => date('Y-m-d H:i:s'),
						'email' => @$_SESSION['agent']['email_address'],
						'sent' => 0);
				$bids_mailer_cls->insert($data);
				*/
				//ape_insert(array('key' => $property_id, 'data' => serialize(__getBidAction($property_id))));
				if (APE_ENABLE) {
					$jsons['ape'] = __getBidAction($property_id);
				}
			} else{
				$jsons['msg'] = 'Your bid is unsuccessful.';
			}

			$property_cls->unLock($property_id);
		}

	}
}

die(json_encode($jsons));
?>