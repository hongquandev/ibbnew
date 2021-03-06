<?php 
$property_id = restrictArgs(getParam('property_id',0));
$mine = getPost('mine',0);
$jsons = array();
$jsons['id'] = $property_id;
$jsons['isBlock'] = PE_isTheBlock($property_id) || PE_isTheBlock($property_id,'agent');
$min_incre = $max_incre = 0;
if ($jsons['isBlock']){
	$row = $property_cls->getRow('SELECT stop_bid,
			confirm_sold,
			min_increment,
			max_increment
			FROM '.$property_cls->getTable().'
			WHERE property_id = '.$property_id,true);
	if(is_array($row) and count($row) > 0){
		if ($row['confirm_sold'] == 1 || $row['stop_bid'] == 1){
			$jsons['error'] = 1;
			$jsons['msg'] = $row['confirm_solid'] == 1?'This property had been sold.':'Bidding has stopped on this property (the Auction has finished).';
			return $jsons;
		}else{
			$min_incre = $row['min_increment'];
			$max_incre = $row['max_increment'];
			$ok = (int)$min_incre > 0 || (int)$max_incre > 0;
		}

	}
	$step = $min_incre == $max_incre?0:$max_incre - $min_incre;
}
if (in_array($_SESSION['agent']['type'],array('theblock','agent')) && $mine == 1){
	if (Property_isLockBid($property_id)){
		$jsons['error'] = 1;
		$jsons['msg'] = 'Sorry, this property is not ready. Please click Start Auction button for opening bid.';
		return $jsons;
	}
	$price = getPost('money_step',0);
	$incre = PT_getValueByCode($property_id,'initial_auction_increments');
	$bid_price = PE_getBidPrice($property_id);

	if ($price <= $bid_price){
		$jsons['error'] = 1;
		$jsons['msg'] = 'Bid price must be larger than '.showPrice($bid_price);

	}else{
		$increment = $price - $bid_price;
		$jsons['error'] = 0;
		if($jsons['isBlock'] && $ok){
			if ($step == 0){
				if ($increment != $min_incre){
					$jsons['error'] = 1;
					$jsons['msg'] = 'This property is only bid with price is '.$min_incre.'.<br/>
					Please bid with price is '.showPrice(($bid_price + $min_incre)).'.';
				}
			}elseif ($step < 0){//only min_incre
				if ($increment < $min_incre){
					$jsons['error'] = 1;
					$jsons['msg'] = 'Min increment of this property is '.showPrice($min_incre).'<br />
					Please bid with price larger than '. showPrice(($bid_price + $min_incre)) .'.';
				}
			}else{
				if ($increment >= $min_incre && $increment <= $max_incre){
				}else{
					$jsons['error'] = 1;
					if ($min_incre > 0){
						$jsons['msg'] = 'Increment of this property between is '.showPrice($min_incre).' and '.showPrice($max_incre).'.<br />
						Please bid with price larger than '. showPrice(($bid_price + $min_incre)) .' and smaller than '. showPrice(($bid_price + $max_incre)).'.';
					}else{
						$jsons['msg'] = 'Max increment of this property is '.showPrice($max_incre).'<br />
						Please bid with price smaller than '. showPrice(($bid_price + $max_incre)) .'.';
					}
				}
			}
		}
		if ($jsons['error'] == 0){
			$jsons['msg'] = 'Please confirm your bid price ' . showPrice($price) .' ?';
			$jsons['money'] = $price - $bid_price;
		}
	}
}else{
	if ($bid_room_cls->isExist($_SESSION['agent']['id'], $property_id)) {
		$jsons['error'] = 1;
		//$jsons['msg'] = 'Your turn on autobid on this property.'."<br/>".'Please turn off autobid to use this feature.';

		$jsons['msg'] = 'It is currently your turn in the autobid queue for this property. If you want to manually bid, please turn off your autobid for this property by clicking on autobid and then the <font style="color:#2f2f2f;font-size:14px;font-weight:bold;">Cancel</font> button.';
		return $jsons;
	}

	$output = Bid_isValid($_SESSION['agent']['id'], $property_id,false,false,$_SESSION['agent']['type']);
	if (count($output) > 0) {
		/*$jsons['error'] = 1;
		 $jsons['msg'] = $output['msg'];
		$jsons['redirect'] = $output['redirect'];
		$jsons['']*/
		foreach($output as $k=>$item){
			$jsons[$k] = $output[$k];
		}
		$jsons['error'] = 1;
	} else {
		$jsons['error'] = 0;

		//get increment price
		$money_step = getPost('money_step',0);//WHEN BIDDER CHOSE FROM COMBOBOX
		$increment = ($money_step == 0)?PT_getValueByCode($property_id,'initial_auction_increments'):$money_step;
		$bid_price = PE_getBidPrice($property_id);

		if($jsons['isBlock'] && $ok){
			if ($step == 0){
				if ($increment != $min_incre){
					$jsons['error'] = 1;
					$jsons['msg'] = 'This property is only bid with price is '.$min_incre.'.<br/>
					Please bid with price is '.showPrice(($bid_price + $min_incre)).'.';
				}
			}elseif ($step < 0){//only min_incre
				if ($increment < $min_incre){
					$jsons['error'] = 1;
					$jsons['msg'] = 'Min increment of this property is '.showPrice($min_incre).'<br />
					Please bid with price larger than '. showPrice(($bid_price + $min_incre)) .'.';
				}
			}else{
				if ($increment >= $min_incre && $increment <= $max_incre){

				}else{
					$jsons['error'] = 1;
					if ($min_incre > 0){
						$jsons['msg'] = 'Increment of this property between is '.showPrice($min_incre).' and '.showPrice($max_incre).'.<br />
						Please bid with price larger than '. showPrice(($bid_price + $min_incre)) .' and smaller than '. showPrice(($bid_price + $max_incre)).'.';
					}else{
						$jsons['msg'] = 'Max increment of this property is '.showPrice($max_incre).'<br />
						Please bid with price smaller than '. showPrice(($bid_price + $max_incre)) .'.';
					}
				}
			}
		}
		if ($jsons['error'] == 0){
			$after_price =showPrice($increment+$bid_price);
			$jsons['msg'] = 'Please confirm your bid price ' . $after_price .' ?';
		}
	}
}
die(json_encode($jsons));
?>