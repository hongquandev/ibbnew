<?php
$property_id = isset($_GET['property_id'])?intval($_GET['property_id']):0;
include_once ROOTPATH.'/modules/agent/inc/agent.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent_creditcard.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent_history.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent_lawyer.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent_contact.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent_option.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent.logo.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent.payment.class.php';
include_once ROOTPATH.'/modules/agent/inc/message.php';
include_once ROOTPATH.'/modules/agent/inc/company.php';
include_once ROOTPATH.'/modules/agent/inc/agent_site.class.php';

include_once ROOTPATH.'/modules/general/inc/sendmail.php';
include_once ROOTPATH.'/modules/general/inc/card_type.class.php';
include_once ROOTPATH.'/modules/general/inc/bids.php';
include_once ROOTPATH.'/modules/general/inc/getbanner.php';
include_once ROOTPATH.'/modules/note/inc/note.php';


//Order By
$auction_sale_ar = PEO_getAuctionSale();
$start_price = '(SELECT pro_term.value
FROM '.$property_cls->getTable('property_term').' AS pro_term
LEFT JOIN '.$property_cls->getTable('auction_terms'). ' AS term
ON pro_term.auction_term_id = term.auction_term_id
WHERE term.code = \'auction_start_price\'
AND pro.property_id = pro_term.property_id)';
$wh_price = '(SELECT CASE
WHEN pro.auction_sale = '.$auction_sale_ar['auction'].' THEN
(SELECT CASE
WHEN pro.pay_status = '.Property::PAY_COMPLETE.' THEN
(SELECT CASE
WHEN (date(pro.start_time) > \''.date('Y-m-d H:i:s').'\' OR isnull(max(bid.price)) ) THEN
'.$start_price.'
ELSE max(bid.price)
END
FROM bids AS bid WHERE bid.property_id = pro.property_id) + 0
ELSE
(SELECT CASE
WHEN !isnull('.$start_price.') THEN '.$start_price.'
ELSE pro.price
END)
END)
WHEN auction_sale != '.$auction_sale_ar['auction'].' AND pro.price != 0 THEN pro.price
WHEN auction_sale != '.$auction_sale_ar['auction'].' AND pro.price = 0 AND pro.price_on_application != 0 THEN pro.price_on_application
END)';

if (getParam('order_by') != '') {
	$_SESSION['order_by'] = (getParam('order_by') != '')?getParam('order_by'):"notcomplete";
}

$order_by = isset($_SESSION['order_by']) ? $_SESSION['order_by'] : '';
$sub_select =null;
switch ($order_by) {
	case 'highest':
		$order_ar = $wh_price. ' DESC';
		break;
	case 'lowest':
		$order_ar = $wh_price;
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
	case 'offer':
		$order_ar = ' offer_number DESC';
		$sub_select = ',
		(SELECT CASE
		WHEN    pro.auction_sale = 9
		AND pro.start_time < \''.date('Y-m-d H:i:s').'\'
		AND pro.end_time > \''.date('Y-m-d H:i:s').'\'
		AND pro.stop_bid = 0
		AND pro.confirm_sold = 0
		AND pro.active = 1
		THEN
		(SELECT count(*)
		FROM '.$property_cls->getTable('message').' AS msg
		WHERE msg.entity_id = pro.property_id AND msg.abort = 0 AND
		msg.offer_price > bid_price
		)
		ELSE    (SELECT count(*)
		FROM '.$property_cls->getTable('message').' AS msg
		WHERE msg.entity_id = pro.property_id AND msg.abort = 0 AND
		TRUE
		)
		END
		)AS offer_number
		';
		break;
	case 'switch':
		$order_ar = ' ID DESC';
		$sub_select = ',(SELECT pro_his.property_id FROM property_transition_history AS pro_his
		WHERE pro_his.property_id=pro.property_id AND pro.confirm_sold !='.Property::PAY_COMPLETE.' ORDER BY pro_his.property_transition_history_id DESC LIMIT 0,1) as ID';
		break;
	case 'notcomplete':
		$order_ar = ' pro.pay_status ASC,pro.property_id DESC';
		break;
	case 'active':
		$order_ar = ' pro.active,pro.confirm_sold ASC,pro.pay_status DESC';
		break;
	case 'passed-in':
		$order_ar = ' pro.stop_bid DESC, pro.confirm_sold ASC';
		$sub_select = ',((SELECT pro_term.value
		FROM '.$property_cls->getTable('property_term').' AS pro_term
		LEFT JOIN '.$property_cls->getTable('auction_terms').' AS term
		ON pro_term.auction_term_id = term.auction_term_id
		WHERE term.code = \'reserve\'
		AND pro.property_id = pro_term.property_id ) - pro.price) AS Order_price ';
		break;
	case 'sold':
		$order_ar = 'pro.confirm_sold DESC';
		break;
	default:
		//$order_ar = ' pro.confirm_sold, pro.stop_bid,pro.pay_status, pro.property_id DESC';
		$order_ar = '   pro.confirm_sold, pro.stop_bid,pro.property_id DESC';
		break;
}

$order_ar = ($order_ar != '') ? ' ORDER BY ' . $order_ar : '';

//$smarty->assign('order_by',$order_by);
//End Order By

$min =0;
$max = 5;

$where_clause = '';
$_SESSION['type_prev'] = 'my_detail';
if (in_array($_SESSION['agent']['type'],array('theblock','agent'))){
	$where_clause .= ' AND (pro.agent_id IN (SELECT agent_id FROM '.$agent_cls->getTable().' WHERE parent_id = '.$_SESSION['agent']['id'].')
	OR IF(ISNULL(pro.agent_manager)
	OR pro.agent_manager = 0
	OR (SELECT parent_id FROM '.$agent_cls->getTable().' WHERE agent_id = '.$_SESSION['agent']['id'].') = 0
	,pro.agent_id = '.$_SESSION['agent']['id'].'
	, pro.agent_manager = '.$_SESSION['agent']['id'].'))';
}else{
	$where_clause = ' AND pro.agent_id = '.$_SESSION['agent']['id'];
}
if($act == 'view-property')
{
	$min = (($p - 1) * $len);
	$max = $len;
}
elseif($act == 'view-auction')
{
	$min = (($p - 1) * $len);
	$max = $len;
	$where_clause .= '  AND pro.auction_sale = '.$auction_sale_ar['auction'].'
	AND pro.confirm_sold = '.Property::SOLD_UNKNOWN.'
	AND (pro.stop_bid = 0
	OR   pro.pay_status != '.Property::PAY_COMPLETE.')';

}

$sql = 'SELECT SQL_CALC_FOUND_ROWS pro.property_id,
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
											pro.price, 
											pro.suburb,
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
											pro.agent_active,
											pro.active,
											pro.set_count,
											pro.min_increment,
											pro.max_increment,
											pro.autobid_enable,
											pro.price_on_application,
											pro.show_agent_logo,
(SELECT  company_name
FROM  agent_company AS ac
WHERE  ac.agent_id = pro.agent_id) AS owner,
(SELECT l.logo
		FROM ' . $agent_logo_cls->getTable() . ' AS l
		WHERE l.agent_id = IF(pro.agent_manager = \'\' OR ISNULL(pro.agent_manager),pro.agent_id,pro.agent_manager)
		) AS logo,
pro.set_count,
pro.agent_id,
pro.agent_manager,
pro.show_agent_logo,
pro.price_on_application,

(SELECT CONCAT(a.firstname,\' \',a.lastname) FROM '.$agent_cls->getTable().' AS a
WHERE a.agent_id = pro.agent_id) AS agent_name,

(SELECT reg1.name FROM '.$region_cls->getTable().' AS reg1 WHERE reg1.region_id = pro.state) AS state_name,
(SELECT reg2.code FROM '.$region_cls->getTable().' AS reg2 WHERE reg2.region_id = pro.state) AS state_code,
(SELECT reg3.name FROM '.$region_cls->getTable().' AS reg3 WHERE reg3.region_id = pro.country) AS country_name,
(SELECT reg4.code FROM '.$region_cls->getTable().' AS reg4 WHERE reg4.region_id = pro.country) AS country_code,

(SELECT pro_term.value
FROM '.$property_cls->getTable('property_term').' AS pro_term LEFT JOIN '.$property_cls->getTable('auction_terms').' AS term
ON pro_term.auction_term_id = term.auction_term_id
WHERE term.code = "auction_start_price" AND pro.property_id = pro_term.property_id) AS start_price,

(SELECT pro_opt1.value
FROM '.$property_entity_option_cls->getTable().' AS pro_opt1
WHERE pro_opt1.property_entity_option_id = pro.bathroom) AS bathroom_value,

(SELECT pro_opt2.value
FROM '.$property_entity_option_cls->getTable().' AS pro_opt2
WHERE pro_opt2.property_entity_option_id = pro.bedroom) AS bedroom_value,

(SELECT pro_opt3.value
FROM '.$property_entity_option_cls->getTable().' AS pro_opt3
WHERE pro_opt3.property_entity_option_id = pro.car_port) AS carport_value,

(SELECT pro_opt5.title
FROM '.$property_entity_option_cls->getTable().' AS pro_opt5
WHERE pro_opt5.property_entity_option_id = pro.land_size) AS landsize_title,

(SELECT pro_opt6.code
FROM '.$property_entity_option_cls->getTable().' AS pro_opt6
WHERE pro_opt6.property_entity_option_id = pro.auction_sale) AS auction_sale_code,
(SELECT pro_opt8.value
FROM '.$property_entity_option_cls->getTable().' AS pro_opt8
WHERE pro_opt8.property_entity_option_id = pro.car_space
) AS carspace_value,
 (SELECT SUM(pro_opt10.view)
							FROM property_log AS pro_opt10 
							WHERE pro_opt10.property_id = pro.property_id) AS visits,
(SELECT count(*)
                            FROM '.$property_cls->getTable('bids').' AS bid
                            WHERE pro.property_id = bid.property_id) AS bids,
(SELECT bid.in_room
FROM '.$property_cls->getTable('bids').' AS bid,' . $agent_cls->getTable() . ' AS agt, property_entity AS pro
WHERE bid.agent_id = agt.agent_id AND bid.property_id = pro.property_id AND bid.agent_id = '.$_SESSION['agent']['id'].' GROUP BY pro.property_id
ORDER BY bid.time DESC 
LIMIT 1) AS in_room,
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

(SELECT MAX(bid.price)
FROM '.$property_cls->getTable('bids').' AS bid
WHERE bid.property_id = pro.property_id ) AS bid_prices

'.$sub_select.'

FROM '.$property_cls->getTable().' AS pro
WHERE pro.property_id= '.$property_id.' AND 1
'.$where_clause.'
'.$order_ar;//.'
//LIMIT '.$min.','.$max;

//echo'<pre>'; print_r($sql); echo '</pre>';die();
$rows = $property_cls->getRows($sql,true);
for($i=0;$i<count($rows);$i++){
	//GET INFO
	$_photo = PM_getPhoto($rows[$i]['property_id'], true);
	$rows[$i]['photo'] = $_photo['photo_thumb'];
	$rows[$i]['photo_default'] = $_photo['photo_default'];
	$rows[$i]['last_bidder'] = Bid_getShortNameLastBidder($rows[$i]['property_id']);
	//GET AGENT COMPANY
	
	$row = $agent_cls->getRow('SELECT a.*, agent_logo.logo as agent_logo
			FROM agent_company AS a LEFT JOIN agent_logo ON agent_logo.agent_id = a.agent_id
			WHERE a.agent_id = ' . $rows[$i]['agent_id'], true);
	
	$rows[$i]['agent_company_id'] =$row['company_id'];
	$rows[$i]['agent_company_name'] =$row['company_name'];
	$rows[$i]['agent_company_address'] =$row['address'];
	$rows[$i]['agent_company_suburb'] =$row['suburb'];
	$rows[$i]['agent_company_state'] =$row['state'];
	$rows[$i]['agent_company_postcode'] =$row['postcode'];
	$rows[$i]['agent_company_country'] =$row['country'];
	$rows[$i]['agent_company_abn'] =$row['abn'];
	$rows[$i]['agent_company_website'] =$row['website'];
	$rows[$i]['agent_company_telephone'] =$row['telephone'];
	$rows[$i]['agent_company_email_address'] =$row['email_address'];
	$rows[$i]['agent_company_description'] =$row['description'];
	$rows[$i]['agent_company_logo'] =$row['logo'];
	$rows[$i]['agent_logo'] =$row['agent_logo'];
   if (Property_isVendorOfProperty($rows[$i]['property_id'],$rows[$i]['agent_id'])){
   	$rows[$i]['in_room'] = 'Vendor Bid';
   }else 
   	$rows[$i]['in_room'] = 'In Room Bid';
   	$rows[$i]['num_note'] = Note_count("entity_id_to = ".$rows[$i]['property_id']." AND entity_id_from = ".$_SESSION['agent']['id']." AND type = 'customer2property'");
   $_last_agent_id = $property_cls->getRow("SELECT bid.agent_id FROM bids AS bid WHERE bid.property_id = ".$rows[$i]['property_id']." AND bid.agent_id=".$rows[$i]['agent_id']." ORDER BY bid.time DESC", true);
   if (is_array($_last_agent_id) and count($_last_agent_id) > 0){
   //	if(intval($_SESSION['agent']['id'])==intval($_last_agent_id[0]["last_agent_id"])==intval($rows[$i]['agent_id']))
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

die(json_encode(count($rows)>0?$rows[0]:array()));
?>