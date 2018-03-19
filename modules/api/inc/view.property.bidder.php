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
$auction_sale_ar = PEO_getAuctionSale();
$row = $property_cls->getRow('SELECT property_id,
		autobid_enable,
		min_increment,
		max_increment,
		stop_bid,
		confirm_sold,
		set_count,
		agent_id,
		pro.price_on_application,
		(SELECT MAX(bid.price)
		FROM '.$property_cls->getTable('bids').' AS bid
		WHERE bid.property_id = pro.property_id ) AS bid_price,
		IF(pro.auction_sale = '.$auction_sale_ar['auction'].',
		(SELECT IF( ISNULL( MAX(b.price)) OR pro.start_time > \''.date('Y-m-d H:i:s').'\' ,
		(SELECT  pro_term.value
		FROM '.$property_term_cls->getTable().' AS pro_term
		LEFT JOIN '.$auction_term_cls->getTable().' AS term
		ON pro_term.auction_term_id = term.auction_term_id
		WHERE term.code = \'auction_start_price\' AND pro.property_id = pro_term.property_id
),
		MAX(b.price) )
		FROM '.$bid_cls->getTable().' AS b
		WHERE b.property_id = pro.property_id
)
		,pro.price) AS price
		FROM '.$property_cls->getTable().' AS pro
		WHERE property_id = '.$property_id,true);
//$smarty->assign('refresh_time',$config_cls->getKey('no_more_bids_refresh') * 1000);
//$smarty->assign('refresh_time',100);

if (is_array($row) and count($row)> 0){
	$row['isLastBidVendor'] = Bid_isLastBidVendor($row['property_id']);
	$row['bidder'] = formUnescape(Bid_getShortNameLastBidder($row['property_id']));
	$row['last_bidder'] = formUnescape(Bid_getShortNameLastBidder($row['property_id']));
	//BEGIN GET RESERVE PRICE
	$row['reserve'] = PT_getValueByCode($row['property_id'],'reserve');
	$row['check_price'] = $row['price'] >= $row['reserve'] && $row['reserve'] > 0;
	$row['price'] = showPrice($row['price']);

	$inc_default = PT_getValueByCode($row['property_id'], 'initial_auction_increments');
	$price_inc_default = showPrice($inc_default);
	if(($row['min_increment']) == "" or !isset($row['min_increment'])){
		$row['min_increment'] = $inc_default;
		$row['min_increment_'] = $price_inc_default;
	}else{
		$row['min_increment_'] = showPrice($row['min_increment']);
	}

	if(($row['max_increment']) == "" or !isset($row['max_increment'])){
		$row['max_increment'] = "";
		$row['max_increment_'] = "";
	}else{
		$row['max_increment_'] = showPrice($row['max_increment']);
	}

	//$row['max_increment_'] = showPrice($row['max_increment']) != "$0"  ? showPrice($row['max_increment']) : "" ;
	//$row['min_increment_'] = showPrice($row['min_increment']) != "$0" ? showPrice($row['min_increment']) : "" ;

	if($row['max_increment_'] != "" and $row['min_increment_'] != "" )
	{
		$row['min_max_increment_mess'] = $row['min_increment_']." to ".$row['max_increment_'];
	}elseif($row['max_increment_'] != ""){
		$row['min_max_increment_mess'] = $row['max_increment_']."(max) ";
	}elseif($row['min_increment_'] != ""){
		$row['min_max_increment_mess'] = $row['min_increment_']."(min) ";
	}else{
		$row['min_max_increment_mess'] = "none";
	}
	$row['owner'] = '"'.implode('","', Property_getOwner($property_id)).'"';
	$row['is_mobile'] = (int)detectMobile();
	$row['is_mobile_nexus7'] = (int)detectNexus7();

	$iai_id = AT_getIdByCode('price_options_popup');
	$step_options_detail = AT_getOptions($iai_id,0,'DESC');
	$no_more_bid = PE_isNoMoreBids($row['property_id'], isset($_SESSION['agent'])? $_SESSION['agent']['id']: 0);
	$row['step_options_detail'] = $step_options_detail;
	$row['no_more_bid'] = $no_more_bid;
	$row['refresh_time'] = $config_cls->getKey('no_more_bids_refresh') * 1000;
	if (Property_isVendorOfProperty($row['property_id'],$row['agent_id'])){
	$row['in_room'] = 'Vendor Bid';
	}else
	$row['in_room'] = 'In Room Bid';
	$_last_agent_id = $property_cls->getRow("SELECT bid.agent_id FROM bids AS bid WHERE bid.property_id = ".$property_id." AND bid.agent_id=".$row['agent_id']." ORDER BY bid.time DESC", true);
if (is_array($_last_agent_id) and count($_last_agent_id) > 0){
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
		WHERE b.property_id = '.$property_id.'
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
		WHERE bid.property_id = '.$property_id.' AND bid.agent_id = pay.agent_id
) AS bid_number
		FROM '.$payment_store_cls->getTable().' AS pay,'.$agent_cls->getTable().' AS agt
		WHERE   pay.agent_id = agt.agent_id
		AND pay.property_id = '.$property_id.'
		AND (pay.bid = 1 OR pay.offer = 1)
		AND pay.is_paid > 0
		GROUP BY pay.agent_id
		ORDER BY pay.creation_time DESC',true);

$row['no_more_bids']=count($bids_out_rows)>=count($reg_bid_rows)&&count($bids_out_rows)>0&&count($reg_bid_rows)>0?"1":"0";
//TEST
//$row['min_increment'] = 100;
	die(json_encode($row));
}


/**
function : __getWinnerInfo
 * return Array of Info Winner or array();
 **/

function __getWinnerInfo($property_id = 0) {
    global $bid_cls, $region_cls, $agent_cls, $agent_company_cls, $property_cls;
    if (!isset($bid_cls) || !($bid_cls instanceof Bids)) {
        $bid_cls = new Bids();
    }
    if($property_id <= 0){
        return array();
    }
    $rs = array();
    $pro_row = $property_cls->getCRow(array('stop_bid','confirm_sold','set_count'),' property_id ='.$property_id);
    if(is_array($pro_row) and count($pro_row) > 0)
    {
        if($pro_row['confirm_sold'] == Property::SOLD_COMPLETE ){
            //WINNER INFO
            $b_row = $bid_cls->getCRow(array('agent_id', 'property_id', 'price', 'type_approved'), 'property_id = '.(int)$property_id.' ORDER BY price DESC LIMIT 1');
            if (@$b_row['agent_id'] > 0 && @$b_row['type_approved'] == 0 and !Property_isVendorOfProperty($property_id, $b_row['agent_id'])) {
                $rs = array('property_id' => $property_id);
                $rs['agent_id'] = $b_row['agent_id'];
                $rs['price'] = $b_row['price'];

                //AGENT INFO
                $agent_id = Property_getParent($property_id);
                $sql = 'SELECT agent.firstname, agent.lastname, agent.telephone, agent.mobilephone
				FROM '.$agent_cls->getTable().' AS agent
				WHERE agent.agent_id = '.(int)$agent_id;
                $a_row = $agent_cls->getRow($sql, true);
                if (count($a_row) > 0) {
                    $rs['agent_fullname'] = $a_row['firstname'] . ' ' . $a_row['lastname'];
                    $rs['agent_phone'] = strlen(trim($a_row['telephone'])) > 0 ? $a_row['telephone'] : $a_row['mobiphone'];
                    $add1 = A_getAddress($agent_id);
                    $add2 = A_getCompanyAddress($agent_id);
                    $rs['agent_address'] = strlen($add2) > 0 ? $add2: $add1;

                    /*-- FOR MOBILE*/
                    $rs['msg1'] = 'Congratulations!';
                    $rs['msg2'] = 'You are the winning bidder and as the Highest bidder, you are buying this property.';
                    $rs['msg3'] = 'Please contact the Managing Agent.';
                }
                //update Winner;
                $bid_cls->update(array('type_approved' => 1), 'property_id = '.$property_id.' AND agent_id = '.$b_row['agent_id'].' AND price = '.$b_row['price']);
            }
        }
    }

    return $rs;
}
?>