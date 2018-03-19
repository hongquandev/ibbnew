<?php 
$step = getParam('step');
$property_id = restrictArgs(getParam('property_id',0));
$text = '';
$data = array();
$result = array('error'=>1);
if ($property_id > 0){
	$row = $property_cls->getRow('SELECT no_more_bid,
			stop_bid,
			confirm_sold
			FROM '.$property_cls->getTable().' WHERE property_id = '.$property_id,true);
	switch ($step){
		case 1:
			$text = 'Going Once';
			break;
		case 2:
			$text = 'Going Twice';
			break;
		case 3:
			$text = 'Third and Final Call';
			break;
		case 'sold':
			$text = 'Sold';
			$data['confirm_sold'] = 1;
			$data['sold_time'] = date('Y-m-d H:i:s');
			break;
		case 'reset':

			//$bid = $bid_cls->getRows('property_id = '.$property_id);
			//$text = (is_array($bid) and count($bid) > 0)?'Auction Live':'Looking For Opening Bid';

			$text = $row['no_more_bid'] == 0?'Auction Live':'No More Online Bids';
			break;
		case 'passedin':
			$text = 'Passed In';
			$data['stop_bid'] = 1;
			$data['stop_time'] = date('Y-m-d H:i:s');
			break;
		case 'pre_amble':
			$text = 'Auctioneer pre amble';
			$data['lock_bid'] = 1;
			break;
		case 'start':
			$text = 'Auction Live';
			$data['lock_bid'] = 0;
			break;
		default:
			break;
	}
	if ($row['stop_bid'] == 0 and $row['confirm_sold'] == 0){
		$data['set_count'] = $text;
		$property_cls->update($data,'property_id = '.$property_id);
		if (!$property_cls->getError()){
			$result = array('success'=>1,'property_id'=>$property_id,'step'=>$step,'property_id'=>$property_id);
		}
	}
}
 die(json_encode($result));
?>