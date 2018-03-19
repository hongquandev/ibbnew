<?php 
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/modules/note/inc/note.php';
$id = isset($_GET['property_id'])?intval($_GET['property_id']):0;

//BEGIN SQL FOR CHECK ACTIVE
$auction_sale_ar = PEO_getAuctionSale();
$_active = " pro.pay_status = " . Property::CAN_SHOW . '
AND IF (pro.auction_sale = ' . $auction_sale_ar['auction'] . ',
(SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\'
,0
,pro_term.value)
FROM ' . $property_term_cls->getTable() . ' AS pro_term
LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
ON pro_term.auction_term_id = term.auction_term_id
WHERE term.code = \'auction_start_price\'
AND pro.property_id = pro_term.property_id ) != 0
, 1)
AND pro.active = 1
AND pro.agent_active = 1';


//BEGIN FOR LOCK THE BLOCK PROPERTY: NHUNG
$wh_arr = array();
$date_lock = (int)$config_cls->getKey('date_lock');

if (isset($_SESSION['agent']) and $_SESSION['agent']['id'] > 0) {
	//agent is the block/is not the block
	$lock_str = "  IF(
	(SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at WHERE agt.type_id = at.agent_type_id) IN ('theblock'),

	(SELECT p.pay_bid_first_status FROM " . $bids_first_cls->getTable() . " AS p
	WHERE p.property_id = pro.property_id AND p.agent_id = " . $_SESSION['agent']['id'] . ")> 0
	OR '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY),pro.date_to_reg_bid)
	OR (IF(ISNULL(pro.agent_manager)
	OR pro.agent_manager = 0
	,pro.agent_id = {$_SESSION['agent']['id']}
	, pro.agent_manager = '{$_SESSION['agent']['id']}')
	|| pro.agent_id IN (SELECT a.agent_id FROM agent AS a WHERE a.parent_id = {$_SESSION['agent']['id']})
	|| (pro.agent_id = '{$_SESSION['agent']['id']}' AND agt.parent_id = 0))

	,IF (pro.agent_id = {$_SESSION['agent']['id']},1, {$_active}))";
} else {
$lock_str = " IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at
WHERE agt.type_id = at.agent_type_id) IN ('theblock'),
'" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY),pro.date_to_reg_bid),1) = 1
AND {$_active}";
	}

	//IBB-1224: unlock/lock the block properties after the auctions
	$lock_status = (int)$config_cls->getKey('theblock_status');
	if ($lock_status == 0) { //unlock
	$lock_type = $config_cls->getKey('theblock_show_type_properties');
	$lock_type_ar = explode(',', $lock_type);
	$unlock_str = 1;
	if (count($lock_type_ar) > 0) {
	foreach ($lock_type_ar as $type) {
	switch ($type) {
	case 'sold':
	$unlock_arr[] = "pro.confirm_sold = 1";
	break;
	case 'passed_in':
	$unlock_arr[] = "(pro.confirm_sold = 0 AND pro.stop_bid = 1)";
		break;
		case 'live':
		$unlock_arr[] = "(pro.end_time > '" . date('Y-m-d H:i:s') . "'
		AND pro.confirm_sold = 0
		AND pro.stop_bid = 0
		AND pro.end_time > pro.start_time
		AND pro.start_time <= '" . date('Y-m-d H:i:s') . "')";
			break;
			case 'forthcoming':
			$unlock_arr[] = "(pro.start_time > '" . date('Y-m-d H:i:s') . "'
			AND pro.confirm_sold = 0
			AND pro.stop_bid = 0)";
			break;
			}
			}

			$_unlock_str = ' OR ' . implode(' OR ', $unlock_arr);

			if (isset($_SESSION['agent']) and $_SESSION['agent']['id'] > 0) {
			$unlock_str = " IF(
					(SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at WHERE agt.type_id = at.agent_type_id) IN ('theblock'),

							(SELECT p.pay_bid_first_status FROM " . $bids_first_cls->getTable() . " AS p
							WHERE p.property_id = pro.property_id AND p.agent_id = " . $_SESSION['agent']['id'] . ")> 0
							OR '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY),pro.date_to_reg_bid)
							OR (IF(ISNULL(pro.agent_manager)
							OR pro.agent_manager = 0
							,pro.agent_id = {$_SESSION['agent']['id']}
							, pro.agent_manager = '{$_SESSION['agent']['id']}')
							|| pro.agent_id IN (SELECT a.agent_id FROM agent AS a WHERE a.parent_id = {$_SESSION['agent']['id']})
							|| (pro.agent_id = '{$_SESSION['agent']['id']}' AND agt.parent_id = 0))
							{$_unlock_str}

								,IF (pro.agent_id = {$_SESSION['agent']['id']},1, {$_active}))";
							} else {
										$unlock_str = "
										IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at
										WHERE agt.type_id = at.agent_type_id) IN ('theblock'),
										'" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,
										DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY)
										,pro.date_to_reg_bid)
										{$_unlock_str}
										,IF (pro.agent_id = {$_SESSION['agent']['id']},1, {$_active}))
										";
							}

							}
										$date_open_lock = $config_cls->getKey('theblock_date_lock');
										$wh_arr[] = " IF ('" . date('Y-m-d H:i:s') . "' < '" . $date_open_lock . "',{$lock_str},{$unlock_str})";
							} else {
							$wh_arr[] = $lock_str;
							}

							//HIDE AGENT's PROPERTIES DIDN'T PAYMENT
							$wh_arr[] = " IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at
							WHERE agt.type_id = at.agent_type_id) IN ('agent')
							,(SELECT ap.payment_id FROM " . $agent_payment_cls->getTable() . " AS ap
							WHERE ap.agent_id = IF(agt.parent_id = '',agt.agent_id,agt.parent_id)
							AND ap.date_from <= '" . date('Y-m-d H:i:s') . "' AND ap.date_to >= '" . date('Y-m-d H:i:s') . "'
							) != ''
							,1)";
							//DON'T ALLOW SHOW PROPERTIES OF INACTIVE AGENT
							$wh_arr[] = " IF(ISNULL(pro.agent_manager) || pro.agent_manager = '' || pro.agent_manager = 0
							, agt.is_active = 1
							,(SELECT a.is_active FROM " . $agent_cls->getTable() . " AS a WHERE a.agent_id = pro.agent_manager) = 1)
							";
							$wh_arr[] = " IF(pro.agent_id = ".$_SESSION['agent']['id'].", 1 , pro.active = 1 AND pro.agent_active = 1 AND pro.pay_status = ".Property::PAY_COMPLETE." ) ";
							$wh_str = count($wh_arr) > 0 ? ' AND ' . implode(' AND ', $wh_arr) : '';
		

$row = $property_cls->getRow('SELECT pro.property_id,
		pro.address,
		pro.type,
		pro.kind,
		pro.parking,
		pro.suburb,
		pro.postcode,
		pro.auction_sale ,
		pro.end_time,
		pro.start_time,
		pro.last_bid_time,
		pro.agent_id,
		pro.description ,
		open_for_inspection,
		pro.stop_bid,
		pro.confirm_sold,
		pro.sold_time,
		pro.land_size,
		pro.pay_status,
		pro.auction_blog,
		pro.livability_rating_mark,
		pro.green_rating_mark,
		pro.owner,
		pro.agent_manager,
		agt.type_id,
		pro.agent_active,
		pro.active,
		pro.set_count,
		pro.min_increment,
		pro.max_increment,
		pro.autobid_enable,
		pro.price_on_application,
		pro.show_agent_logo,
(SELECT CONCAT(a.firstname,\' \',a.lastname) FROM '.$agent_cls->getTable().' AS a
WHERE a.agent_id = pro.agent_id) AS agent_name,
(SELECT pro_term.value
FROM '.$property_cls->getTable('property_term').' AS pro_term LEFT JOIN '.$property_cls->getTable('auction_terms').' AS term
ON pro_term.auction_term_id = term.auction_term_id
WHERE term.code = "auction_start_price" AND pro.property_id = pro_term.property_id) AS start_price,
		(SELECT pro_opt5.title
FROM '.$property_entity_option_cls->getTable().' AS pro_opt5
WHERE pro_opt5.property_entity_option_id = pro.land_size) AS landsize_title,
		(SELECT pro_opt6.code
FROM '.$property_entity_option_cls->getTable().' AS pro_opt6
WHERE pro_opt6.property_entity_option_id = pro.auction_sale) AS auction_sale_code,
 (SELECT SUM(pro_opt10.view)
							FROM property_log AS pro_opt10 
							WHERE pro_opt10.property_id = pro.property_id) AS visits,
		(SELECT l.logo
		FROM ' . $agent_logo_cls->getTable() . ' AS l
		WHERE l.agent_id = IF(pro.agent_manager = \'\' OR ISNULL(pro.agent_manager),pro.agent_id,pro.agent_manager)
) AS logo,

		(SELECT SUM(pro_log.view)
		FROM ' . $property_cls->getTable('property_log') . ' AS pro_log
		WHERE pro_log.property_id = pro.property_id
)AS views,

		(SELECT reg1.name
		FROM ' . $region_cls->getTable() . ' AS reg1
		WHERE reg1.region_id = pro.state
) AS state_name,

		(SELECT reg2.code
		FROM ' . $region_cls->getTable() . ' AS reg2
		WHERE reg2.region_id = pro.state
) AS state_code,

		(SELECT reg3.name
		FROM ' . $region_cls->getTable() . ' AS reg3
		WHERE reg3.region_id = pro.country
) AS country_name,

		(SELECT reg4.code
		FROM ' . $region_cls->getTable() . ' AS reg4
		WHERE reg4.region_id = pro.country
) AS country_code,

		(SELECT pro_opt1.value
		FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt1
		WHERE pro_opt1.property_entity_option_id = pro.bathroom
) AS bathroom_value,

		(SELECT pro_opt2.value
		FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt2
		WHERE pro_opt2.property_entity_option_id = pro.bedroom
) AS bedroom_value,

		(SELECT pro_opt3.value
		FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt3
		WHERE pro_opt3.property_entity_option_id = pro.car_port
) AS carport_value,

		(SELECT pro_opt6.title
		FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt6
		WHERE pro_opt6.property_entity_option_id = pro.type
) AS type_name,
		(SELECT pro_opt8.value
		FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt8
		WHERE pro_opt8.property_entity_option_id = pro.car_space
) AS carspace_value,
		(SELECT count(*)
		FROM ' . $property_cls->getTable('bids') . ' AS bid
		WHERE bid.property_id = pro.property_id
) AS bids,
(SELECT pt.value
FROM '.$property_cls->getTable('property_term').' AS pt,'.$property_cls->getTable('auction_terms').' AS at
WHERE pt.property_id = pro.property_id AND pt.auction_term_id = at.auction_term_id AND at.code = "reserve")	AS reserve,
		
		(SELECT MAX(bid.price)
FROM '.$property_cls->getTable('bids').' AS bid
WHERE bid.property_id = pro.property_id ) AS bid_prices,
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
		FROM bids AS bid WHERE bid.property_id = pro.property_id) AS price,
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

		WHERE pro.property_id = ' . $id
		. $wh_str . '

		ORDER BY pro.confirm_sold, pro.stop_bid, pro.property_id DESC'


		, true);
if(intval($row['property_id'])>0){
$_photo = PM_getPhoto($row['property_id'], true);
$row['photo'] = $_photo['photo_thumb'];
$row['photo_default'] = $_photo['photo_default'];
$row['last_bidder'] = Bid_getShortNameLastBidder($row['property_id']);
//GET AGENT COMPANY

$agent = $agent_cls->getRow('SELECT a.*, agent_logo.logo as agent_logo
		FROM agent_company AS a LEFT JOIN agent_logo ON agent_logo.agent_id = a.agent_id
		WHERE a.agent_id = ' . $row['agent_id'], true);

$row['agent_company_id'] =$agent['company_id'];
$row['agent_company_name'] =$agent['company_name'];
$row['agent_company_address'] =$agent['address'];
$row['agent_company_suburb'] =$agent['suburb'];
$row['agent_company_state'] =$agent['state'];
$row['agent_company_postcode'] =$agent['postcode'];
$row['agent_company_country'] =$agent['country'];
$row['agent_company_abn'] =$agent['abn'];
$row['agent_company_website'] =$agent['website'];
$row['agent_company_telephone'] =$agent['telephone'];
$row['agent_company_email_address'] =$agent['email_address'];
$row['agent_company_description'] =$agent['description'];
$row['agent_company_logo'] =$agent['logo'];
$row['agent_logo'] =$agent['agent_logo'];

if (Property_isVendorOfProperty($row['property_id'],$row['agent_id'])){
	$row['in_room'] = 'Vendor Bid';
}else
	$row['in_room'] = 'In Room Bid';
$row['num_note'] = Note_count("entity_id_to = ".$row['property_id']." AND entity_id_from = ".$_SESSION['agent']['id']." AND type = 'customer2property'");
$_last_agent_id = $property_cls->getRow("SELECT bid.agent_id FROM bids AS bid WHERE bid.property_id = ".$row['property_id']." AND bid.agent_id=".$row['agent_id']." ORDER BY bid.time DESC", true);
if (is_array($_last_agent_id) and count($_last_agent_id) > 0){
	//if(intval($_SESSION['agent']['id'])==intval($_last_agent_id[0]["last_agent_id"])==intval($row['agent_id']))
		$row['last_agent']="1";
}else
	$row['last_agent']="0";
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
		WHERE pro.property_id = ' . $row['property_id']

		, true);
if (is_array($_row) and count($_row) > 0){

	if(in_array($_row['pay_status'],array(Property::PAY_PENDING,Property::PAY_UNKNOWN))
			|| ($_row['auction_sale'] == $auction_sale_ar['auction'] && $_row['start_time'] == '0000-00-00 00:00:00')){//NOT COMPLETE
		if (Property_isVendorOfProperty($row['property_id'],$row['agent_id'])){
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
	$row_history = $property_history_cls->get_Field($row['property_id']);
	if (is_array($row_history) and count($row_history) > 0 && !Property_isVendorOfProperty($row['property_id'],$row['agent_id'])) {
		if ((!PE_isLiveProperty((int)$row['property_id']))) {
			if (!PE_isstopAuction($row['property_id'])) {
				$countdown = 'Switch';
			}
		}
	}
	// end switch

	$of_agent = PE_isTheBlock($row['property_id'], 'agent') ? 1 : 0;
	if ($of_agent) {
		$agent = A_getCompanyInfo($row['property_id']);
		$agent_logo = MEDIAURL . '/' . $agent['logo'];
	}

	if (PE_isTheBlock($row['property_id'])) {
		$block_image = ROOTURL . '/modules/general/templates/images/theblock.png';
	}


	// BEGIN
	$info_ar = array('property_id' => $row['property_id'],
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
		$isLastBidVendor = Bid_isLastBidVendor($row['property_id'],$in_room);
		$bidder = formUnescape(Bid_getShortNameLastBidder($row['property_id']));
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
$row['watermark']=$watermark;
$row['countdown']=$countdown;
$row['status']=$status;
$row['agent_logo']=$agent_logo;
$row['title']=$title;
$row['block_image']=$block_image;
$row['bid_status_bidder']=$bid_status['bidder'];
$row['bid_status_price']=$bid_status['price'];

$bids_out_rows = $bids_stop_cls->getRows('SELECT SQL_CALC_FOUND_ROWS a.firstname,
		a.lastname,
		a.agent_id,
		a.email_address,
		b.*
		FROM '.$agent_cls->getTable().' AS a
		LEFT JOIN '.$bids_stop_cls->getTable().' AS b
		ON a.agent_id = b.agent_id
		WHERE b.property_id = '.$row['property_id'].'
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
		WHERE bid.property_id = '.$row['property_id'].' AND bid.agent_id = pay.agent_id
) AS bid_number
		FROM '.$payment_store_cls->getTable().' AS pay,'.$agent_cls->getTable().' AS agt
		WHERE   pay.agent_id = agt.agent_id
		AND pay.property_id = '.$row['property_id'].'
		AND (pay.bid = 1 OR pay.offer = 1)
		AND pay.is_paid > 0
		GROUP BY pay.agent_id
		ORDER BY pay.creation_time DESC',true);

$row['no_more_bids']=count($bids_out_rows)>=count($reg_bid_rows)&&count($bids_out_rows)>0&&count($reg_bid_rows)>0?"1":"0";
}
die(json_encode($row));
?>