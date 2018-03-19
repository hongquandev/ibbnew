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
include_once ROOTPATH . '/modules/general/inc/getbanner.php';
include_once ROOTPATH . '/modules/note/inc/note.php';

try {
    //Order By
    $auction_sale_ar = PEO_getAuctionSale();

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
											pro.no_more_bid,
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

(SELECT CONCAT(a.firstname,\' \',a.lastname) FROM ' . $agent_cls->getTable() . ' AS a
WHERE a.agent_id = pro.agent_id) AS agent_name,

(SELECT reg1.name FROM ' . $region_cls->getTable() . ' AS reg1 WHERE reg1.region_id = pro.state) AS state_name,
(SELECT reg2.code FROM ' . $region_cls->getTable() . ' AS reg2 WHERE reg2.region_id = pro.state) AS state_code,
(SELECT reg3.name FROM ' . $region_cls->getTable() . ' AS reg3 WHERE reg3.region_id = pro.country) AS country_name,
(SELECT reg4.code FROM ' . $region_cls->getTable() . ' AS reg4 WHERE reg4.region_id = pro.country) AS country_code,

(SELECT pt.value
		FROM ' . $property_cls->getTable('property_term') . ' AS pt,' . $property_cls->getTable('auction_terms') . ' AS at
		WHERE pt.property_id = pro.property_id AND pt.auction_term_id = at.auction_term_id AND at.code = "reserve")
AS reserve_price,
(SELECT pro_opt7.title
           FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt7
           WHERE pro_opt7.property_entity_option_id = pro.type
           ) AS office,
(SELECT pro_term.value
FROM ' . $property_cls->getTable('property_term') . ' AS pro_term LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
ON pro_term.auction_term_id = term.auction_term_id
WHERE term.code = "auction_start_price" AND pro.property_id = pro_term.property_id) AS start_price,

(SELECT pro_opt1.value
FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt1
WHERE pro_opt1.property_entity_option_id = pro.bathroom) AS bathroom_value,

(SELECT pro_opt2.value
FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt2
WHERE pro_opt2.property_entity_option_id = pro.bedroom) AS bedroom_value,

(SELECT pro_opt3.value
FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt3
WHERE pro_opt3.property_entity_option_id = pro.car_port) AS carport_value,

(SELECT pro_opt5.title
FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt5
WHERE pro_opt5.property_entity_option_id = pro.land_size) AS landsize_title,

(SELECT pro_opt6.code
FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt6
WHERE pro_opt6.property_entity_option_id = pro.auction_sale) AS auction_sale_code,
(SELECT pro_opt8.value
FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt8
WHERE pro_opt8.property_entity_option_id = pro.car_space
) AS carspace_value,
 (SELECT SUM(pro_opt10.view)
							FROM property_log AS pro_opt10
							WHERE pro_opt10.property_id = pro.property_id) AS visits,
(SELECT count(*)
                            FROM ' . $property_cls->getTable('bids') . ' AS bid
                            WHERE pro.property_id = bid.property_id) AS bids,
(SELECT bid.in_room
FROM ' . $property_cls->getTable('bids') . ' AS bid,' . $agent_cls->getTable() . ' AS agt, property_entity AS pro
WHERE bid.agent_id = agt.agent_id AND bid.property_id = pro.property_id AND bid.agent_id = ' . $_SESSION['agent']['id'] . ' GROUP BY pro.property_id
ORDER BY bid.time DESC
LIMIT 1) AS in_room,
(SELECT pt.value
FROM ' . $property_cls->getTable('property_term') . ' AS pt,' . $property_cls->getTable('auction_terms') . ' AS at
WHERE pt.property_id = pro.property_id AND pt.auction_term_id = at.auction_term_id AND at.code = "reserve")	AS reserve,



(SELECT CASE
WHEN pro.auction_sale = ' . $auction_sale_ar['auction'] . ' AND ( date(pro.start_time) > \'' . date('Y-m-d H:i:s') . '\' OR isnull(max(bid.price)) ) THEN

(SELECT pro_term.value
FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term ON pro_term.auction_term_id = term.auction_term_id
WHERE term.code = \'auction_start_price\' AND pro.property_id = pro_term.property_id)

WHEN auction_sale != ' . $auction_sale_ar['auction'] . ' AND pro.price != 0 THEN pro.price
WHEN auction_sale != ' . $auction_sale_ar['auction'] . ' AND pro.price = 0 AND pro.price_on_application != 0 THEN pro.price_on_application
ELSE max(bid.price)
END
FROM bids AS bid WHERE bid.property_id = pro.property_id) AS bid_price,

(SELECT MAX(bid.price)
FROM ' . $property_cls->getTable('bids') . ' AS bid
WHERE bid.property_id = pro.property_id ) AS bid_prices

FROM ' . $property_cls->getTable() . ' AS pro
WHERE pro.property_id= ' . $property_id;

    $row = $property_cls->getRow($sql, true);
    if ($row != null) {
        //GET INFO
        $_photo = PM_getPhoto($row['property_id'], true);
        $row['photo'] = $_photo['photo_thumb'];
        $row['photo_default'] = $_photo['photo_default'];
        $row['last_bidder'] = Bid_getShortNameLastBidder($row['property_id']);
        //GET AGENT COMPANY
        $row['full_adrress'] = $row['address'];
        $row['full_adrress'] .= ', ' . $row['suburb'];
        $row['full_adrress'] .= ', ' . $row['state_name'];
        $row['full_adrress'] .= ', ' . $row['postcode'];
        $row['full_adrress'] .= ', ' . $row['country_name'];
        $_company = $agent_cls->getRow('SELECT a.*,
        (SELECT reg1.code FROM ' . $region_cls->getTable() . ' AS reg1 WHERE reg1.region_id = a.state) AS state_name,
        (SELECT reg3.name FROM ' . $region_cls->getTable() . ' AS reg3 WHERE reg3.region_id = a.country) AS country_name,
         agent_logo.logo as agent_logo
			FROM agent_company AS a LEFT JOIN agent_logo ON agent_logo.agent_id = a.agent_id
			WHERE a.agent_id = ' . $row['agent_id'], true);

        $row['agent_company_id'] = $_company['company_id'];
        $row['agent_company_name'] = $_company['company_name'];
        $row['agent_company_address'] = $_company['address'] . ', ' . $_company['suburb'];
        $row['agent_company_suburb'] = $_company['suburb'];
        $row['agent_company_state'] = $_company['state_name'];
        $row['agent_company_postcode'] = $_company['postcode'];
        $row['agent_company_country'] = $_company['country_name'];
        $row['agent_company_abn'] = $_company['abn'];
        $row['agent_company_website'] = str_replace('/', '', str_replace('http://', '', $_company['website']));
        $row['agent_company_telephone'] = $_company['telephone'];
        $row['agent_company_email_address'] = $_company['email_address'];
        $row['agent_company_description'] = $_company['description'];
        $row['agent_company_logo'] = $_company['logo'];
        $row['agent_logo'] = $_company['agent_logo'];
        if (Property_isVendorOfProperty($row['property_id'], $row['agent_id'])) {
            $row['in_room'] = 'Vendor Bid';
        } else {
            $row['in_room'] = 'In Room Bid';
        }
        $row['num_note'] = Note_count("entity_id_to = " . $row['property_id'] . " AND entity_id_from = " . $_SESSION['agent']['id'] . " AND type = 'customer2property'");
        $_last_agent_id = $property_cls->getRow("SELECT bid.agent_id FROM bids AS bid WHERE bid.property_id = " . $row['property_id'] . " AND bid.agent_id=" . $row['agent_id'] . " ORDER BY bid.time DESC", true);
        if (is_array($_last_agent_id) and count($_last_agent_id) > 0) {

            $row['last_agent'] = "1";
        } else
            $row['last_agent'] = "0";

        $start_time = new DateTime($row['start_time']);
        $end_time = new DateTime($row['end_time']);
        $dt2 = new DateTime(date('Y-m-d H:i:s'));
        $title = '';
        if ($end_time > $dt2) {
            $title = 'AUCTION ENDS: ';
        } else {
            $title = 'AUCTION ENDED: ';
        }

        $watermark = '';
        $countdown = '';
        $agent_logo = '';
        $block_image = '';
        $title = '';

        $current_time = new DateTime(date('Y-m-d H:i:s'));
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
            $row['bid_price'] = $row['price_on_application'] == 1 ? 'Price On Application'
                    : showLowPrice($row['reserve']) . ' - ' . showHighPrice($row['reserve']);
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

        if ($row['isBlock'] || $row['ofAgent']) {
            $row['agent_company_name'] = $agent["company_name"];
            $row['agent_company_website'] = $agent["website"];

            $me = A_getAgentManageInfo($row['property_id']);
            if ($me != null)
                $row['agent_company_telephone'] = $me["telephone"];
        }

        $title = $status == 'forthcoming'
                ? 'AUCTION STARTS: ' . $start_time->format($config_cls->getKey('general_date_format'))
                : $title . ' ' . $end_time->format($config_cls->getKey('general_date_format'));

        $title = $row['ofAgent'] == 1
                ? 'OWNER: ' . $agent['company_name'] : $title;
        $row['company_name'] = $agent['company_name'];
        $start_price = PT_getValueByCode($row['property_id'], 'auction_start_price');
        $row['check_start'] = ($start_price == $row['bid_price']) ? true : false;
        $row['agent_company_logo'] = $agent['logo'];
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

        // END

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
        $row['countdown'] =  $row['no_more_bid'] == 1? 'No More Online Bids' : $countdown;//$row['no_more_bid'] == 1
        $row['status'] = $status;
        $row['title'] = $title;
        $row['bid_status_bidder'] = $bid_status['bidder'];
        $row['bid_status_price'] = $bid_status['price'];
        $row['is_mine'] = Property_isVendorOfProperty($row['property_id']) ? 1 : 0;
        /*if($row['agent_id'] == $_SESSION['agent']['id'] || $row['agent_manager']==$_SESSION['agent']['id']){
            $row['is_mine'] =1;
        }else{
            $row['is_mine']=0;
        } */
        // $row['is_mine'] = ($row['agent_id'] == $_SESSION['agent']['id'])?1:0;
    }

    out('1', '', $row);
} catch (Exception $e) {
    out('0', $e->getMessage());
}
?>