<?php
include_once ROOTPATH.'/modules/note/inc/note.php';
//BEGIN FOR PAGGING
$p = (int)restrictArgs(getParam('p',0));
$p = $p <= 0 ? 1: $p;
$len = 9;
//END

//END

//Order By
$auction_sale_ar = PEO_getAuctionSale();

if (getParam('order_by') != '') {
	$_SESSION['order_by'] = (getParam('order_by') != '')?getParam('order_by'):"notcomplete";
}

$order_by = isset($_SESSION['order_by']) ? $_SESSION['order_by'] : '';
$sub_select =null;
switch ($order_by) {
	case 'highest':
		$order_ar =  ' price DESC';
		$sub_select = '(SELECT pro_his.bid_price FROM property_transition_history AS pro_his
		WHERE pro_his.property_id=pro.property_id ORDER BY pro_his.property_transition_history_id DESC LIMIT 0,1) as last_price,';
		break;
	case 'lowest':
		$order_ar =  ' price ASC';
		$sub_select = '(SELECT pro_his.bid_price FROM property_transition_history AS pro_his
		WHERE pro_his.property_id=pro.property_id ORDER BY pro_his.property_transition_history_id DESC LIMIT 0,1) as  last_price,';
		break;
	case 'newest':
		$order_ar = ' pro.property_id DESC';
		break;
	case 'oldest':
		$order_ar = ' pro.property_id ASC';
		break;
	case 'suburb':
		$order_ar = ' pro.suburb ASC';
		break;
	case 'state':
		$order_ar = ' pro.state ASC';
		break;
	case 'switch':
		$order_ar = ' ID DESC';
		$sub_select = '(SELECT pro_his.property_id FROM property_transition_history AS pro_his
		WHERE pro_his.property_id=pro.property_id
		AND pro.active = 0

		ORDER BY pro_his.property_transition_history_id DESC LIMIT 0,1) as ID,';
		break;

	case 'sold':
		$order_ar = ' pro.confirm_sold DESC';
		break;
	default:
		$order_ar = ' pro.confirm_sold, pro.stop_bid,pro.pay_status, pro.property_id DESC';
		//$order_ar = " pro.property_id DESC ";
		//$order_ar = '   pro.stop_bid,pro.confirm_sold ASC pro.property_id DESC';
		break;
}

$order_ar = ($order_ar != '') ? ' ORDER BY ' . $order_ar : '';
$smarty->assign('order_by',$order_by);
//End Order By

// Begin Bid and Reg to bid
$strBidFilter = "my-reg-to-bids";

if($strBidFilter == 'my-reg-to-bids') // FOR reg to bid and not bid in property
{
	$wh_str  = ' AND (pro.property_id IN (SELECT DISTINCT b.property_id FROM `'.$bid_cls->getTable('bids_first_payment').'` AS b WHERE b.agent_id = \''.$_SESSION['agent']['id'].'\' AND b.pay_bid_first_status > 0 AND b.abort = 0 ) ) ';
	//$wh_str .= ' AND (pro.start_time < \''.date('Y-m-d H:i:s').'\') ';

	/*IBB-1129: NHUNG
	 [INT] The Block- My watchlist/ My register to bid - show pro false*/
	$wh_str .= ' AND IF(datediff(\''.date('Y-m-d H:i:s').'\',pro.sold_time) >= 14 ,0,1) AND pro.auction_sale =  '.$auction_sale_ar['auction'];
	/*$wh_str .= '  AND 1
	 AND pro.pay_status = '.Property::PAY_COMPLETE.'
	AND pro.active = 1
	AND pro.agent_active = 1';*/
	//$wh_str .= ' AND (pro.confirm_sold = '.Property::SOLD_UNKNOWN.')';
	$wh_str .= ' AND (pro.property_id NOT IN (SELECT DISTINCT bid.property_id FROM '.$bid_cls->getTable().' AS bid WHERE bid.agent_id = '.$_SESSION['agent']['id'].' ) ) ';
	$wh_str .= ' AND (pro.property_id NOT IN (SELECT DISTINCT bid_his.property_id FROM '.$bid_transition_history_cls->getTable().' AS bid_his WHERE bid_his.agent_id = '.$_SESSION['agent']['id'].' ))';
}
else{         // For bid on properties
	
}


$_SESSION['agent_detail']['prev_next'] = $wh_str.' AND IF(datediff(\''.date('Y-m-d H:i:s').'\',pro.sold_time) >= 14 ,0,1)';
$_SESSION['join'] = null;
$_SESSION['where'] = 'list';
$_SESSION['type_prev'] = 'property_bids';
$_SESSION['wh_str'] = $wh_str;

$wh_arr = Property_getCondition();
$wh_string = count($wh_arr) > 0 ? ' AND ' . implode(' AND ', $wh_arr) : '';

$sql = 'SELECT SQL_CALC_FOUND_ROWS pro.property_id,
pro.kind,
pro.parking,
pro.address,
pro.suburb,
pro.postcode,
pro.end_time,
pro.agent_id,
pro.start_time,
pro.open_for_inspection,
pro.agent_active,
pro.pay_status,
pro.active,
pro.description,
pro.auction_sale,
pro.state,
pro.stop_bid,
pro.sold_time,
pro.confirm_sold,
pro.livability_rating_mark,
pro.green_rating_mark,
pro.set_count,
pro.owner,
pro.price_on_application,
(SELECT reg1.name FROM '.$region_cls->getTable().' AS reg1 WHERE reg1.region_id = pro.state) AS state_name,
(SELECT reg2.code FROM '.$region_cls->getTable().' AS reg2 WHERE reg2.region_id = pro.state) AS state_code,
(SELECT reg3.name FROM '.$region_cls->getTable().' AS reg3 WHERE reg3.region_id = pro.country) AS country_name,
(SELECT reg4.code FROM '.$region_cls->getTable().' AS reg4 WHERE reg4.region_id = pro.country) AS country_code,
(SELECT pro_opt1.value
FROM '.$property_entity_option_cls->getTable().' AS pro_opt1
WHERE pro_opt1.property_entity_option_id = pro.bathroom) AS bathroom_value,
(SELECT pro_opt2.value
FROM '.$property_entity_option_cls->getTable().' AS pro_opt2
WHERE pro_opt2.property_entity_option_id = pro.bedroom) AS bedroom_value,
(SELECT pro_opt3.value
FROM '.$property_entity_option_cls->getTable().' AS pro_opt3
WHERE pro_opt3.property_entity_option_id = pro.car_port) AS carport_value,
(SELECT pro_opt8.value
FROM '.$property_entity_option_cls->getTable().' AS pro_opt8
WHERE pro_opt8.property_entity_option_id = pro.car_space
) AS carspace_value,
(SELECT pro_opt6.code
FROM '.$property_entity_option_cls->getTable().' AS pro_opt6
WHERE pro_opt6.property_entity_option_id = pro.auction_sale) AS auction_sale_code,
(SELECT pt.value
FROM '.$property_cls->getTable('property_term').' AS pt,'.$property_cls->getTable('auction_terms').' AS at
WHERE pt.property_id = pro.property_id AND pt.auction_term_id = at.auction_term_id AND at.code = "reserve")	AS reserve,



(SELECT CASE
WHEN pro.auction_sale = '.$auction_sale_ar['auction'].' AND ( date(pro.start_time) > \''.date('Y-m-d H:i:s').'\' OR isnull(max(bid.price)) ) THEN

(SELECT pro_term.value
FROM '.$property_cls->getTable('property_term').' AS pro_term
LEFT JOIN '.$property_cls->getTable('auction_terms'). ' AS term ON pro_term.auction_term_id = term.auction_term_id
WHERE term.code = \'auction_start_price\' AND pro.property_id = pro_term.property_id)

WHEN auction_sale != '.$auction_sale_ar['auction'].' AND pro.price != 0 THEN pro.price
WHEN auction_sale != '.$auction_sale_ar['auction'].' AND pro.price = 0 AND pro.price_on_application != 0 THEN pro.price_on_application
ELSE max(bid.price)
END
FROM bids AS bid WHERE bid.property_id = pro.property_id) AS bid_price,

(SELECT bid.in_room
FROM '.$property_cls->getTable('bids').' AS bid,' . $agent_cls->getTable() . ' AS agt, property_entity AS pro
WHERE bid.agent_id = agt.agent_id AND bid.property_id = pro.property_id AND bid.agent_id = '.$_SESSION['agent']['id'].' GROUP BY pro.property_id
ORDER BY bid.time DESC 
LIMIT 1) AS in_room,

(SELECT MAX(bid.price)
FROM '.$property_cls->getTable('bids').' AS bid
WHERE bid.property_id = pro.property_id ) AS bid_prices,
(SELECT pro_term.value
FROM '.$property_cls->getTable('property_term').' AS pro_term LEFT JOIN '.$property_cls->getTable('auction_terms').' AS term
ON pro_term.auction_term_id = term.auction_term_id
WHERE term.code = "auction_start_price" AND pro.property_id = pro_term.property_id) AS start_price,
'.$sub_select.'
(SELECT CASE
WHEN auction_sale = '.$auction_sale_ar['auction']." AND ( pro.start_time > '".date('Y-m-d H:i:s')."' OR isnull(max(bid.price)) ) THEN
(SELECT pro_term.value
FROM ".$property_cls->getTable('property_term')." AS pro_term
LEFT JOIN ".$property_cls->getTable('auction_terms')." AS term
ON pro_term.auction_term_id = term.auction_term_id
WHERE term.code = 'auction_start_price' AND pro.property_id = pro_term.property_id
)
WHEN auction_sale != ".$auction_sale_ar['auction']." AND pro.price != 0 THEN pro.price
WHEN auction_sale != ".$auction_sale_ar['auction']." AND pro.price = 0 AND pro.price_on_application != 0 THEN pro.price_on_application
ELSE (max(bid.price))
END
FROM ".$property_cls->getTable('bids').' AS bid
WHERE bid.property_id = pro.property_id ) AS price

FROM '.$property_cls->getTable().' AS pro
LEFT JOIN '.$agent_cls->getTable().' AS agt ON agt.agent_id = pro.agent_id

WHERE 1
'
.$wh_str
.$wh_string
.$order_ar;

$rows = $property_cls->getRows($sql,true);
for($i=0;$i<count($rows);$i++){
	//$rows[$i]['owner']=A_getCompanyInfo($rows[$i]['property_id']);
	$_photo = PM_getPhoto($rows[$i]['property_id'], true);
	$rows[$i]['photo'] = $_photo['photo_thumb'];
	$rows[$i]['photo_default'] = $_photo['photo_default'];
	$rows[$i]['last_bidder'] = Bid_getShortNameLastBidder($rows[$i]['property_id']);
	if (Property_isVendorOfProperty($rows[$i]['property_id'],$rows[$i]['agent_id'])){
		$rows[$i]['in_room'] = 'Vendor Bid';
	}else
		$rows[$i]['in_room'] = 'In Room Bid';
	$auction_sale_ar = PEO_getAuctionSale();
	$rows[$i]['auction_sale']=$auction_sale_ar['auction'] == $rows[$i]['auction_sale']?"true":"false";
	$rows[$i]['num_note'] = Note_count("entity_id_to = ".$rows[$i]['property_id']." AND entity_id_from = ".$_SESSION['agent']['id']." AND type = 'customer2property'");
	$_last_agent_id = $property_cls->getRow("SELECT bid.agent_id FROM bids AS bid WHERE bid.property_id = ".$rows[$i]['property_id']." AND bid.agent_id=".$rows[$i]['agent_id']." ORDER BY bid.time DESC", true);
	if (is_array($_last_agent_id) and count($_last_agent_id) > 0){
		$rows[$i]['last_agent']="1";
			
	}else
		$rows[$i]['last_agent']="0";
	
	$watermark = '';
	$countdown = '';
	$agent_logo = '';
	$block_image = '';
	$title = '';
	$_row = $property_cls->getRow('SELECT pro.auction_sale ,
			pro.end_time,
			pro.start_time,
			pro.agent_id,
			pro.stop_bid,
			pro.confirm_sold,
			pro.pay_status,
			pro.agent_manager,
			pro.agent_active,
			pro.active,
			pro.set_count,
			pro.owner,
			pro.auction_sale,
			pro.suburb,
			pro.sold_time,
	
			(SELECT count(*)
			FROM ' . $property_cls->getTable('bids') . ' AS bid
			WHERE bid.property_id = pro.property_id
	) AS bids,
	
			(SELECT agtype.title
			FROM '.$agent_cls->getTable('agent_type').' AS agtype
			WHERE agtype.agent_type_id = agt.type_id) AS agent_type,
	
			(SELECT pt.value
			FROM '.$property_cls->getTable('property_term').' AS pt,'.$property_cls->getTable('auction_terms').' AS at
			WHERE pt.property_id = pro.property_id AND pt.auction_term_id = at.auction_term_id AND at.code = "reserve")	AS reserve_price,
	
			(SELECT CASE
			WHEN pro.auction_sale = ' . $auction_sale_ar['auction'] . '
			AND ( date(pro.start_time) > \'' . date('Y-m-d H:i:s') . '\' OR isnull(max(bid.price)) ) THEN
			(SELECT pro_term.value
			FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
			LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
			ON pro_term.auction_term_id = term.auction_term_id
			WHERE term.code = \'auction_start_price\'
			AND pro.property_id = pro_term.property_id)
			WHEN auction_sale != ' . $auction_sale_ar['auction'] . ' AND pro.price != 0 THEN pro.price
			WHEN auction_sale != ' . $auction_sale_ar['auction'] . ' AND pro.price = 0 AND pro.price_on_application != 0 THEN pro.price_on_application
			ELSE max(bid.price)
			END
			FROM bids AS bid WHERE bid.property_id = pro.property_id) AS bid_price
	
	
			FROM ' . $property_cls->getTable() . ' AS pro
			INNER JOIN ' . $property_cls->getTable('agent') . ' AS agt ON pro.agent_id = agt.agent_id
			WHERE pro.property_id = ' . $rows[$i]['property_id']
	
			, true);
	if (is_array($_row) and count($_row) > 0){
	
		if(in_array($_row['pay_status'],array(Property::PAY_PENDING,Property::PAY_UNKNOWN))
				|| ($_row['auction_sale'] == $auction_sale_ar['auction'] && $_row['start_time'] == '0000-00-00 00:00:00')){//NOT COMPLETE
			if (Property_isVendorOfProperty($rows[$i]['property_id'],$rows[$i]['agent_id'])){
				$status = $watermark = 'not_complete';
			}
		}else{//COMPLETE
	
			if ($_row['confirm_sold'] == 1){//SOLD
				$status = 'sold';
				$countdown = 'SOLD';
				$watermark = 'sold';
			}elseif ($_row['auction_sale'] == $auction_sale_ar['auction']){
				if($_row['stop_bid'] == 1){//SOLD OR PASSEDIN
					$status = $watermark = $_row['reserve_price'] < $_row['bid_price'] && $_row['reserve_price'] > 0?'sold':'passed_in';
					$countdown =  $_row['reserve_price'] < $_row['bid_price'] && $_row['reserve_price'] > 0?'SOLD':'PASSED IN';
					if (in_array($_row['agent_type'],array('agent','theblock'))){
						$countdown = $_row['set_count'];
						$status = $watermark = $_row['set_count'] == 'SOLD'?'sold':'passed_in';
					}
				}else{
					$start_time = new DateTime($_row['start_time']);
					$end_time = new DateTime($_row['end_time']);
					$current_time = new DateTime(date('Y-m-d H:i:s'));
					if ($start_time <= $current_time AND $current_time <= $end_time){//LIVE
						$status = 'live';
						if ($_row['reserve_price'] <= $_row['bid_price'] && $_row['reserve_price'] > 0){
							$watermark = 'on_the_market';
						}
	
						if (in_array($_row['agent_type'],array('agent','theblock'))){
							$countdown = $_row['set_count'];
						}
					}else{//FORTH
						$status = 'forthcoming';
						$start_time = new DateTime($_row['start_time']);
						$countdown = 'Auction starts: '.$start_time->format($config_cls->getKey('general_date_format'));
					}
				}
	
				$watermark = $_row['agent_active'] == 0 || $_row['active'] == 0?'wait_for_activation':$watermark;
			}else{
				$status = 'sale';
			}
		}
	
		//For switch Pro
		$row_history = $property_history_cls->get_Field($rows[$i]['property_id']);
		if (is_array($row_history) and count($row_history) > 0 && !Property_isVendorOfProperty($rows[$i]['property_id'],$rows[$i]['agent_id'])) {
			if ((!PE_isLiveProperty((int)$rows[$i]['property_id']))) {
				if (!PE_isstopAuction($rows[$i]['property_id'])) {
					$countdown = 'Switch';
				}
			}
		}
		// end switch
	
		$of_agent = PE_isTheBlock($rows[$i]['property_id'], 'agent') ? 1 : 0;
		if ($of_agent) {
			$agent = A_getCompanyInfo($rows[$i]['property_id']);
			$agent_logo = MEDIAURL . '/' . $agent['logo'];
		}
	
		if (PE_isTheBlock($rows[$i]['property_id'])) {
			$block_image = ROOTURL . '/modules/general/templates/images/theblock.png';
		}
	
	
		// BEGIN
		$info_ar = array('property_id' => $rows[$i]['property_id'],
				'auction_sale' => $_row['auction_sale'],
				'suburb' => $_row['suburb'],
				'end_time' => $_row['end_time'],
				'start_time' => $_row['start_time'],
				'confirm_sold' => $_row['confirm_sold'],
				'sold_time' => $_row['sold_time'],
				'owner' => $_row['owner']);
		$title = Property_getTitle($info_ar);
		// END
	
		//bid status
		if($status == 'forthcoming'){
			$bid_status = $start_time->format($config_cls->getKey('general_date_format'));
		}elseif ($status != 'sale'){
			$isLastBidVendor = Bid_isLastBidVendor($rows[$i]['property_id'],$in_room);
			$bidder = formUnescape(Bid_getShortNameLastBidder($rows[$i]['property_id']));
			if ($isLastBidVendor){
				$bid_status['bidder'] = $in_room?'In Room Bid':'Vendor Bid';
			}else{
				$bid_status['bidder'] = $_row['stop_bid'] == 1 || $_row['confirm_sold'] == 1?'Last Bidder: '.$bidder:'Current Bidder: '.$bidder;
			}
	
			$bid_price = showPrice($_row['bid_price']);
			if ($_row['bids'] == 0){
				$bid_status['price'] = 'Start Price: '.$bid_price;
			}else{
				$bid_status['price'] = $_row['stop_bid'] == 1 || $_row['confirm_sold'] == 1?'Last Bid: '.$bid_price:'Current Bid: '.$bid_price;
			}
		}
	}
	$rows[$i]['watermark']=$watermark;
	$rows[$i]['countdown']=$countdown;
	$rows[$i]['status']=$status;
	$rows[$i]['agent_logo']=$agent_logo;
	$rows[$i]['title']=$title;
	$rows[$i]['block_image']=$block_image;
	$rows[$i]['bid_status_bidder']=$bid_status['bidder'];
	$rows[$i]['bid_status_price']=$bid_status['price'];
	
	$bids_out_rows = $bids_stop_cls->getRows('SELECT SQL_CALC_FOUND_ROWS a.firstname,
			a.lastname,
			a.agent_id,
			a.email_address,
			b.*
			FROM '.$agent_cls->getTable().' AS a
			LEFT JOIN '.$bids_stop_cls->getTable().' AS b
			ON a.agent_id = b.agent_id
			WHERE b.property_id = '.$rows[$i]['property_id'].'
			ORDER BY b.time DESC',true);
	$reg_bid_rows = $payment_store_cls->getRows(' SELECT SQL_CALC_FOUND_ROWS
			pay.property_id,
			pay.agent_id,
			pay.creation_time,
			pay.is_paid,
			pay.is_disable,
			agt.firstname,
			agt.lastname,
			agt.agent_id AS Agent_id,
			agt.email_address,
			(SELECT count(bid.agent_id)
			FROM '.$bid_cls->getTable().' AS bid
			WHERE bid.property_id = '.$rows[$i]['property_id'].' AND bid.agent_id = pay.agent_id
	) AS bid_number
			FROM '.$payment_store_cls->getTable().' AS pay,'.$agent_cls->getTable().' AS agt
			WHERE   pay.agent_id = agt.agent_id
			AND pay.property_id = '.$rows[$i]['property_id'].'
			AND (pay.bid = 1 OR pay.offer = 1)
			AND pay.is_paid > 0
			GROUP BY pay.agent_id
			ORDER BY pay.creation_time DESC',true);
	
	$rows[$i]['no_more_bids']=count($bids_out_rows)>=count($reg_bid_rows)&&count($bids_out_rows)>0&&count($reg_bid_rows)>0?"1":"0";
}
die(json_encode($rows));
?>