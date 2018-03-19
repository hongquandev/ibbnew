<?php
$property_id = getParam('property_id', 0); 
include_once ROOTPATH . '/modules/agent/inc/agent.class.php';
include_once ROOTPATH . '/modules/agent/inc/agent_creditcard.class.php';
include_once ROOTPATH . '/modules/agent/inc/agent_history.class.php';
include_once ROOTPATH . '/modules/agent/inc/agent_lawyer.class.php';
include_once ROOTPATH . '/modules/agent/inc/agent_contact.class.php';
include_once ROOTPATH . '/modules/agent/inc/agent_option.class.php';
include_once ROOTPATH . '/modules/agent/inc/agent.logo.class.php';
include_once ROOTPATH . '/modules/agent/inc/agent.payment.class.php';
include_once ROOTPATH . '/modules/agent/inc/message.php';
include_once ROOTPATH . '/modules/agent/inc/company.php';
include_once ROOTPATH . '/modules/agent/inc/agent_site.class.php';
include_once ROOTPATH . '/modules/general/inc/sendmail.php';
include_once ROOTPATH . '/modules/general/inc/card_type.class.php';
include_once ROOTPATH . '/modules/general/inc/bids.php';
$auction_sale_ar = PEO_getAuctionSale();
try {
    $row = $property_cls->getRow('SELECT property_id,
        pro.end_time,
		pro.start_time,
		pro.pay_status,
		pro.agent_active,
		pro.active,
		pro.owner,
		pro.auction_sale,
		pro.suburb,
		pro.sold_time,
		pro.autobid_enable,
		pro.min_increment,pro.agent_manager,
		pro.max_increment,
		pro.stop_bid,pro.land_size,
		pro.confirm_sold,
		pro.set_count,
		pro.no_more_bid,
		pro.agent_id,
		pro.price_on_application,
		(SELECT count(*)
		FROM ' . $property_cls->getTable('bids') . ' AS bid
		WHERE bid.property_id = pro.property_id
) AS bids,
(SELECT agtype.title
		FROM ' . $agent_cls->getTable('agent_type') . ' AS agtype
		WHERE agtype.agent_type_id = agt.type_id) AS agent_type,

		(SELECT pt.value
		FROM ' . $property_cls->getTable('property_term') . ' AS pt,' . $property_cls->getTable('auction_terms') . ' AS at
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
		FROM bids AS bid WHERE bid.property_id = pro.property_id) AS bid_price,
		
		IF(pro.auction_sale = ' . $auction_sale_ar['auction'] . ',
		(SELECT IF( ISNULL( MAX(b.price)) OR pro.start_time > \'' . date('Y-m-d H:i:s') . '\' ,
		(SELECT  pro_term.value
		FROM ' . $property_term_cls->getTable() . ' AS pro_term
		LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
		ON pro_term.auction_term_id = term.auction_term_id
		WHERE term.code = \'auction_start_price\' AND pro.property_id = pro_term.property_id
),
		MAX(b.price) )
		FROM ' . $bid_cls->getTable() . ' AS b
		WHERE b.property_id = pro.property_id
)
		,pro.price) AS price
		FROM ' . $property_cls->getTable() . ' AS pro
		INNER JOIN ' . $property_cls->getTable('agent') . ' AS agt ON pro.agent_id = agt.agent_id
		WHERE property_id = ' . $property_id, true);


    if (is_array($row) and count($row) > 0) {
        $row['isLastBidVendor'] = Bid_isLastBidVendor($row['property_id']);
        $row['bidder'] = formUnescape(Bid_getShortNameLastBidder($row['property_id']));
        $row['last_bidder'] = formUnescape(Bid_getShortNameLastBidder($row['property_id']));
        //BEGIN GET RESERVE PRICE
        $row['reserve'] = PT_getValueByCode($row['property_id'], 'reserve');
        $row['check_price'] = $row['price'] >= $row['reserve'] && $row['reserve'] > 0;
        $row['price'] = showPrice($row['price']);

        $inc_default = PT_getValueByCode($row['property_id'], 'initial_auction_increments');
        $price_inc_default = showPrice($inc_default);
        if (($row['min_increment']) == "" or !isset($row['min_increment'])) {
            $row['min_increment'] = $inc_default;
            $row['min_increment_'] = $price_inc_default;
        } else {
            $row['min_increment_'] = showPrice($row['min_increment']);
        }

        if (($row['max_increment']) == "" or !isset($row['max_increment'])) {
            $row['max_increment'] = "";
            $row['max_increment_'] = "";
        } else {
            $row['max_increment_'] = showPrice($row['max_increment']);
        }

        if ($row['max_increment'] != "" and $row['min_increment'] != "") {
            if((int)$row['max_increment'] <= 0){
                $row['min_max_increment_mess'] = $row['min_increment_'] . " (min)";
            }else{
                $row['min_max_increment_mess'] = $row['min_increment_'] . " to " . $row['max_increment_'];
            }
        } elseif ($row['max_increment'] != "" ) {
            $row['min_max_increment_mess'] = $row['max_increment_'] . " (max)";
        } elseif ($row['min_increment'] != "") {
            $row['min_max_increment_mess'] = $row['min_increment_'] . " (min)";
        } else {
            $row['min_max_increment_mess'] = "none";
        }
        $row['owner'] = '"' . implode('","', Property_getOwner($property_id)) . '"'; 

        $iai_id = AT_getIdByCode('price_options_popup');
        $step_options_detail = AT_getOptions($iai_id, 0, 'DESC');
        $no_more_bid = PE_isNoMoreBids($row['property_id'], isset($_SESSION['agent']) ? $_SESSION['agent']['id'] : 0);
        $row['step_options_detail'] = $step_options_detail;
        $row['enable_no_more_bid'] = $no_more_bid;
        $row['refresh_time'] = $config_cls->getKey('no_more_bids_refresh') * 1000;
        if (Property_isVendorOfProperty($row['property_id'], $row['agent_id'])) {
            $row['in_room'] = 'Vendor Bid';
        } else
            $row['in_room'] = 'In Room Bid';
        $_last_agent_id = $property_cls->getRow("SELECT bid.agent_id FROM bids AS bid WHERE bid.property_id = " . $property_id . " AND bid.agent_id=" . $row['agent_id'] . " ORDER BY bid.time DESC", true);
        if (is_array($_last_agent_id) and count($_last_agent_id) > 0) {
            $row['last_agent'] = "1";
        } else
            $row['last_agent'] = "0";

        $watermark = '';
        $countdown = '';
        $agent_logo = '';
        $block_image = '';
        $title = '';

        $start_time = new DateTime($row['start_time']);
        $end_time = new DateTime($row['end_time']);
        $current_time = new DateTime(date('Y-m-d H:i:s'));
        $dt2 = new DateTime(date('Y-m-d H:i:s'));
        $title = '';
        if ($end_time > $dt2) {
            $title = 'AUCTION ENDS: ';
        } else {
            $title = 'AUCTION ENDED: ';
        }

        if ($start_time <= $current_time AND $current_time <= $end_time) { //LIVE
            $status = 'live';
            if ($row['reserve_price'] <= $row['bid_price'] && $row['reserve_price'] > 0) {
                $watermark = 'on_the_market';
            }

            if (in_array($row['agent_type'], array('agent', 'theblock'))) {
                $countdown = $row['set_count'];
            }

            $row['bid_price'] = showPrice($row['bid_price']);
        } else { //FORTH
            $status = 'forthcoming';
            $row['bid_price'] = showLowPrice($row['price']) . ' - ' . showHighPrice($row['price']);
            $countdown = 'Auction starts: ' . $start_time->format($config_cls->getKey('general_date_format'));
            $row['auction_starts'] = 'Auction starts';
            $row['auction_starts_date'] = $start_time->format($config_cls->getKey('general_date_format'));
        }

        $watermark = $row['agent_active'] == 0 || $row['active'] == 0 ? 'wait_for_activation'
                : $watermark;

        $row['bid_status_bidder'] = $row['last_bidder'];
        $agent = A_getCompanyInfo($row['property_id']);

        $row['isBlock'] = PE_isTheBlock($row['property_id']);
        $row['ofAgent'] = PE_isTheBlock($row['property_id'], 'agent') ? 1 : 0;

        $title = $status == 'forthcoming'
                ? 'AUCTION STARTS: ' . $start_time->format($config_cls->getKey('general_date_format'))
                : $title . ' ' . $end_time->format($config_cls->getKey('general_date_format'));

        $title = $row['ofAgent'] == 1
                ? 'OWNER: ' . $agent['company_name'] : $title;
        $row['company_name'] = $agent['company_name'];
        $start_price = PT_getValueByCode($row['property_id'], 'auction_start_price');
        $row['check_start'] = ($start_price == $row['bid_price']) ? true : false;

        // end switch

        if ($row['isBlock'] == 1 || $row['ofAgent'] == 1) {
            $countdown = $row['set_count'];
        } else if ($countdown != 'Switch') {
            $countdown = '-d:-:-:-';
        }
        // end switch

        $row['isBlock'] = PE_isTheBlock($row['property_id']);
        $row['ofAgent'] = PE_isTheBlock($row['property_id'], 'agent') ? 1 : 0;


        if (strrpos($row['bid_price'], "$") === false) {
            $bid_price = showPrice($row['bid_price']);
        } else {
            $bid_price = $row['bid_price'];
        }



        //bid status
         if ($status == 'forthcoming') {
            if ($row['isBlock'] != 1) {
                $countdown = 'Auction Starts: ' . $start_time->format($config_cls->getKey('general_date_format'));
            }
        } elseif ($status != 'sale') {
            $isLastBidVendor = Bid_isLastBidVendor($row['property_id'], $in_room);
            $bidder = $row['bid_status_bidder'];
            if ($isLastBidVendor) {
                $bid_status['bidder'] = $in_room ? 'In Room Bid' : 'Vendor Bid';
            } else {
                $bid_status['bidder'] = $row['stop_bid'] == 1 || $row['confirm_sold'] == 1 || $countdown == 'Switch'
                        ? 'Last Bidder: ' . $bidder : 'Current Bidder: ' . $bidder;
            }

            if ((int)$row['stop_bid'] == 1 || (int)$row['confirm_sold'] == 1 || $countdown == 'Switch') {

                $temp = 0;
                if ($row['stop_bid'] == 1) {
                    if ($bidder == '--') {
                        $bid_status['price'] = 'Start Price: ' . $bid_price;
                        $temp = 1;
                    }
                }
                if ($temp == 0) {

                    $bid_status['price'] = 'Last Bid: ' . $bid_price;
                }
            } else if ($row['check_start']) {
                $bid_status['price'] = 'Start Price: ' . $bid_price;
            } else {
                if ($bidder == '--') {
                    $bid_status['price'] = 'Start Price: ' . $bid_price;
                } else {
                    $bid_status['price'] = 'Current Bid: ' . $bid_price;
                }
            }
        }
        $row['watermark'] = $watermark;
        $row['countdown'] = $row['no_more_bid'] == 1? 'No More Online Bids' : $countdown;//PE_isNoMoreBid($row['property_id'])
        $row['status'] = $status;
        $row['agent_logo'] = $agent_logo;
        $row['title'] = $title;
        $row['block_image'] = $block_image;
        $row['bid_status_bidder'] = $bid_status['bidder'];
        $row['bid_status_price'] = $bid_status['price'];
        $row['is_mine'] = Property_isVendorOfProperty($row['property_id'])?1:0;
        /*if($row['agent_id'] == $_SESSION['agent']['id'] || $row['agent_manager']==$_SESSION['agent']['id']){
            $row['is_mine'] =1;
        }else{
            $row['is_mine']=0;
        } */
       // $row['is_mine'] = ($row['agent_id'] == $_SESSION['agent']['id'])?1:0;
        out(1, '', $row);
    }
} catch (Exception $e) {
    out('0', $e->getMessage());
}


?>