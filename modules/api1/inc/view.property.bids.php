<?php
include_once ROOTPATH . '/modules/note/inc/note.php';
include_once ROOTPATH . '/modules/general/inc/auction_terms.class.php';
include_once ROOTPATH . '/modules/property/inc/property_term.class.php';
if (!isset($property_term_cls) || !($property_term_cls instanceof Property_term)) {
    $property_term_cls = new Property_term();
}
if (!isset($auction_term_cls) || !($auction_term_cls instanceof Auction_terms)) {
    $auction_term_cls = new Auction_terms();
}


global $config_cls;
//BEGIN FOR PAGGING
$p = (int)restrictArgs(getParams('p', 1));
$p = $p <= 0 ? 1 : $p;
$len = 10;
$min = (($p - 1) * $len);
$max = $len; 
//END
try {
    //Order By
    $auction_sale_ar = PEO_getAuctionSale();

    if (getParam('order_by') != '') {
        $_SESSION['order_by'] = (getParam('order_by') != '') ? getParam('order_by') : "notcomplete";
    }
    $order_by = isset($_SESSION['order_by']) ? $_SESSION['order_by'] : '';
    $sub_select = null;
    switch ($order_by) {
        case 'highest':
            $order_ar = ' price DESC';
            $sub_select = '(SELECT pro_his.bid_price FROM property_transition_history AS pro_his
                                                             WHERE pro_his.property_id=pro.property_id ORDER BY pro_his.property_transition_history_id DESC LIMIT 0,1) as last_price,';
            break;
        case 'lowest':
            $order_ar = ' price ASC';
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
            break;
    }

    $order_ar = ($order_ar != '') ? ' ORDER BY ' . $order_ar : '';
    //End Order By

    // Begin Bid and Reg to bid
    $strBidFilter = '';
    if ($strBidFilter == 'get-list-property-bids') // FOR reg to bid and not bid in property
    {
        $wh_str = ' AND (pro.property_id IN (SELECT DISTINCT b.property_id FROM `' . $bid_cls->getTable('bids_first_payment') . '` AS b WHERE b.agent_id = \'' . $_SESSION['agent']['id'] . '\' AND b.pay_bid_first_status > 0 AND b.abort = 0 ) ) ';

        $wh_str .= ' AND IF(datediff(\'' . date('Y-m-d H:i:s') . '\',pro.sold_time) >= 14 ,0,1) AND pro.auction_sale =  ' . $auction_sale_ar['auction'];

        $wh_str .= ' AND (pro.property_id NOT IN (SELECT DISTINCT bid.property_id FROM ' . $bid_cls->getTable() . ' AS bid WHERE bid.agent_id = ' . $_SESSION['agent']['id'] . ' ) ) ';
        $wh_str .= ' AND (pro.property_id NOT IN (SELECT DISTINCT bid_his.property_id FROM ' . $bid_transition_history_cls->getTable() . ' AS bid_his WHERE bid_his.agent_id = ' . $_SESSION['agent']['id'] . ' ))';
    }
    else { // For bid on properties

        $pro_his_wh = " IF( (SELECT COUNT(pro_his.property_id) FROM " . $property_history_cls->getTable() . " as pro_his
                                                   WHERE pro_his.property_id = pro.property_id) > 0 ,
                                 IF( ( 1
                                      AND pro.pay_status =" . Property::PAY_COMPLETE . "
                                      ),
                                      pro.auction_sale = " . $auction_sale_ar['auction'] . "
                                      AND pro.active = 1
                                      AND pro.agent_active = 1
                                      ,
                                      1
                                 )
                            ,1
                            )"; 
        $wh_str = ' AND ((pro.property_id IN (SELECT DISTINCT bid.property_id
                                              FROM ' . $bid_cls->getTable() . ' AS bid
                                              WHERE bid.agent_id = ' . $_SESSION['agent']['id'] . ' )
                          AND pro.start_time < \'' . date('Y-m-d H:i:s') . '\'
                          AND pro.start_time <> "0000-00-00 00:00:00" 
                          AND pro.active = 1
                          AND IF(pro.auction_sale = ' . $auction_sale_ar['auction'] . ' , pro.end_time <> "0000-00-00 00:00:00" AND pro.start_time <> "0000-00-00 00:00:00" ,1)
                          AND pro.agent_active = 1
                          AND pro.confirm_sold = 0
                          AND pro.stop_bid = 0
                          AND pro.pay_status = ' . Property::PAY_COMPLETE . '
                          AND pro.auction_sale =' . $auction_sale_ar['auction'] . ' )
                   
                    )';
    }

    $filter_property = '   AND pro.auction_sale = ' . $auction_sale_ar['auction'] . '
                               AND pro.confirm_sold = ' . Property::SOLD_UNKNOWN . '
                               AND IF((SELECT agt_typ.title FROM ' . $property_cls->getTable('agent_type') . ' AS agt_typ
                                       INNER JOIN ' . $agent_cls->getTable() . ' AS agt ON agt.type_id = agt_typ.agent_type_id
                                       WHERE pro.agent_id = agt.agent_id)
                                       = \'agent\',1,
                                       (
                                            IF(  (SELECT IF(ISNULL(max(bid.price)),0,max(bid.price))
                                                FROM ' . $property_cls->getTable('bids') . ' AS bid
                                                WHERE pro.property_id = bid.property_id)  <
                                               (SELECT pro_term.value
                                                FROM ' . $property_term_cls->getTable() . ' AS pro_term
                                                LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
                                                     ON pro_term.auction_term_id = term.auction_term_id
                                                WHERE term.code = \'reserve\'
                                                AND pro.property_id = pro_term.property_id)
                                                AND pro.stop_bid = 1
                                            ,0,1)

                                       )
                                       AND(
                                            IF((SELECT bid.agent_id
                                            FROM ' . $property_cls->getTable('bids') . ' AS bid
                                            WHERE pro.property_id = bid.property_id
                                                  AND (SELECT IF(ISNULL(max(bid.price)),0,max(bid.price))
                                                    FROM ' . $property_cls->getTable('bids') . ' AS bid
                                                    WHERE pro.property_id = bid.property_id) = bid.price
                                            ) = pro.agent_id
                                            AND
                                             ((SELECT IF(ISNULL(max(bid.price)),0,max(bid.price))
                                            FROM ' . $property_cls->getTable('bids') . ' AS bid
                                            WHERE pro.property_id = bid.property_id)
                                                >=
                                            (SELECT pro_term.value
                                            FROM ' . $property_term_cls->getTable() . ' AS pro_term
                                            LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
                                                 ON pro_term.auction_term_id = term.auction_term_id
                                            WHERE term.code = \'reserve\'
                                            AND pro.property_id = pro_term.property_id )),0,1)
                                       )
                                   )
                               AND (SELECT agt_typ.title FROM ' . $property_cls->getTable('agent_type') . ' AS agt_typ
                                     LEFT JOIN ' . $agent_cls->getTable() . ' AS agt ON agt.type_id = agt_typ.agent_type_id
                                     WHERE pro.agent_id = agt.agent_id)
                                    != \'theblock\'
                               ';
    //end filter

    $filter_by_agent = ' AND (SELECT agt_typ.title FROM ' . $property_cls->getTable('agent_type') . ' AS agt_typ
                                       INNER JOIN ' . $agent_cls->getTable() . ' AS agt ON agt.type_id = agt_typ.agent_type_id
                                       WHERE pro.agent_id = agt.agent_id) = \'agent\'';
    // begin filter live or forthcoming

    $filter_by_live_forthcoming = ' AND (SELECT pro_opt6.code
FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt6
WHERE pro_opt6.property_entity_option_id = pro.auction_sale) = \'auction\'';

    // end filter live or forthcoming

    $_SESSION['agent_detail']['prev_next'] = $wh_str . ' AND IF(datediff(\'' . date('Y-m-d H:i:s') . '\',pro.sold_time) >= 14 ,0,1)';
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
									       pro.no_more_bid,
									       pro.state,pro.land_size,
										   pro.stop_bid,pro.agent_manager,
										   pro.sold_time,
										   pro.confirm_sold,
									       pro.livability_rating_mark,
									       pro.green_rating_mark,
									       pro.set_count,
									       pro.owner, 
									       pro.price_on_application,
									       (SELECT CONCAT(a.firstname,\' \',a.lastname) FROM ' . $agent_cls->getTable() . ' AS a
WHERE a.agent_id = pro.agent_id) AS agent_name,
						(SELECT reg1.name FROM ' . $region_cls->getTable() . ' AS reg1 WHERE reg1.region_id = pro.state) AS state_name,
						(SELECT reg2.code FROM ' . $region_cls->getTable() . ' AS reg2 WHERE reg2.region_id = pro.state) AS state_code,
						(SELECT reg3.name FROM ' . $region_cls->getTable() . ' AS reg3 WHERE reg3.region_id = pro.country) AS country_name,
						(SELECT reg4.code FROM ' . $region_cls->getTable() . ' AS reg4 WHERE reg4.region_id = pro.country) AS country_code,
 
(SELECT pt.value
       FROM ' . $property_cls->getTable('property_term') . ' AS pt,' . $property_cls->getTable('auction_terms') . ' AS at
       WHERE pt.property_id = pro.property_id AND pt.auction_term_id = at.auction_term_id AND at.code = "reserve")	AS reserve_price,
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
						(SELECT pro_opt6.code
							FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt6
							WHERE pro_opt6.property_entity_option_id = pro.auction_sale) AS auction_sale_code,
					    ' . $sub_select . '
					    (SELECT CASE
							WHEN auction_sale = ' . $auction_sale_ar['auction'] . " AND ( pro.start_time > '" . date('Y-m-d H:i:s') . "' OR isnull(max(bid.price)) ) THEN
								(SELECT pro_term.value
								FROM " . $property_cls->getTable('property_term') . " AS pro_term
								LEFT JOIN " . $property_cls->getTable('auction_terms') . " AS term
								ON pro_term.auction_term_id = term.auction_term_id
								WHERE term.code = 'auction_start_price' AND pro.property_id = pro_term.property_id
								)
							WHEN auction_sale != " . $auction_sale_ar['auction'] . " AND pro.price != 0 THEN pro.price
                            WHEN auction_sale != " . $auction_sale_ar['auction'] . " AND pro.price = 0 AND pro.price_on_application != 0 THEN pro.price_on_application
							ELSE (max(bid.price))
							END
					    FROM " . $property_cls->getTable('bids') . ' AS bid
						WHERE bid.property_id = pro.property_id ) AS price,
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
						
						(SELECT bid.in_room
						FROM ' . $property_cls->getTable('bids') . ' AS bid,' . $agent_cls->getTable() . ' AS agt, property_entity AS pro
						WHERE bid.agent_id = agt.agent_id AND bid.property_id = pro.property_id AND bid.agent_id = ' . $_SESSION['agent']['id'] . ' GROUP BY pro.property_id
						ORDER BY bid.time DESC 
						LIMIT 1) AS in_room,

						(SELECT MAX(bid.price)
						FROM ' . $property_cls->getTable('bids') . ' AS bid
						WHERE bid.property_id = pro.property_id ) AS bid_prices

				FROM ' . $property_cls->getTable() . ' AS pro
				LEFT JOIN ' . $agent_cls->getTable() . ' AS agt ON agt.agent_id = pro.agent_id

				WHERE 1
                '
           . $wh_str
           . $wh_string
           . $filter_property
           . $filter_by_live_forthcoming
           . $filter_by_agent
           . $order_ar
           . ' LIMIT ' . $min . ',' . $max;

    $rows = $property_cls->getRows($sql, true);
    $item_count = $property_cls->getFoundRows();
    $size = count($rows);
    for ($i = 0; $i < $size; $i++) {
        //$rows[$i]['owner']=A_getCompanyInfo($rows[$i]['property_id']);
        $_photo = PM_getPhoto($rows[$i]['property_id'], true);
        $rows[$i]['photo'] = $_photo['photo_thumb'];
        $rows[$i]['photo_default'] = $_photo['photo_default'];
        $rows[$i]['full_adrress'] = $rows[$i]['address'];
        $rows[$i]['full_adrress'] .= ', ' . $rows[$i]['suburb'];
        $rows[$i]['full_adrress'] .= ', ' . $rows[$i]['state_name'];
        $rows[$i]['full_adrress'] .= ', ' . $rows[$i]['postcode'];
        $rows[$i]['full_adrress'] .= ', ' . $rows[$i]['country_name'];

        $row = $agent_cls->getRow('SELECT a.*,
        (SELECT reg1.code FROM ' . $region_cls->getTable() . ' AS reg1 WHERE reg1.region_id = a.state) AS state_name,
        (SELECT reg3.name FROM ' . $region_cls->getTable() . ' AS reg3 WHERE reg3.region_id = a.country) AS country_name
        , agent_logo.logo as agent_logo
                    FROM agent_company AS a LEFT JOIN agent_logo ON agent_logo.agent_id = a.agent_id
                    WHERE a.agent_id = ' . $rows[$i]['agent_id'], true);
        $rows[$i]['agent_company_id'] = $row['company_id'];
        $rows[$i]['agent_company_name'] = $row['company_name'];
        $rows[$i]['agent_company_address'] = $row['address'].', '.$row['suburb'];
        $rows[$i]['agent_company_suburb'] = $row['suburb'];
        $rows[$i]['agent_company_state'] = $row['state_name'];
        $rows[$i]['agent_company_postcode'] = $row['postcode'];
        $rows[$i]['agent_company_country'] = $row['country_name'];
        $rows[$i]['agent_company_abn'] = $row['abn'];
        $rows[$i]['agent_company_website'] = str_replace('/','',str_replace('http://','',$row['website']));
        $rows[$i]['agent_company_telephone'] = $row['telephone'];
        $rows[$i]['agent_company_email_address'] = $row['email_address'];
        $rows[$i]['agent_company_description'] = $row['description'];
        $rows[$i]['agent_company_logo'] = $row['logo'];
        $rows[$i]['agent_logo'] = $row['agent_logo'];
 
        $rows[$i]['last_bidder'] = Bid_getShortNameLastBidder($rows[$i]['property_id']);
        if (Property_isVendorOfProperty($rows[$i]['property_id'], $rows[$i]['agent_id'])) {
            $rows[$i]['in_room'] = 'Vendor Bid';
        } else
            $rows[$i]['in_room'] = 'In Room Bid';


        $auction_sale_ar = PEO_getAuctionSale();
        $rows[$i]['auction_sale'] = $auction_sale_ar['auction'] == $rows[$i]['auction_sale'] ? "true" : "false";
        $rows[$i]['num_note'] = Note_count("entity_id_to = " . $rows[$i]['property_id'] . " AND entity_id_from = " . $rows[$i]['agent_id'] . " AND type = 'customer2property'");
        $_last_agent_id = $property_cls->getRow("SELECT bid.agent_id FROM bids AS bid WHERE bid.property_id = " . $rows[$i]['property_id'] . " AND bid.agent_id=" . $rows[$i]['agent_id'] . " ORDER BY bid.time DESC", true);
        if (is_array($_last_agent_id) and count($_last_agent_id) > 0) {
            //	if(intval($_SESSION['agent']['id'])==intval($_last_agent_id[0]["last_agent_id"])==intval($rows[$i]['agent_id']))
            $rows[$i]['last_agent'] = "1";
        } else
            $rows[$i]['last_agent'] = "0";

        $watermark = '';
        $countdown = '';
        $agent_logo = '';
        $block_image = '';
        $title = '';

        $title = '';
        $start_time = new DateTime($rows[$i]['start_time']);
        $end_time = new DateTime($rows[$i]['end_time']);
        $dt2 = new DateTime(date('Y-m-d H:i:s'));
        if ($end_time > $dt2) {
            $title = 'AUCTION ENDS: ';
        } else {
            $title = 'AUCTION ENDED: ';
        }

        /*if (in_array($rows[$i]['pay_status'], array(Property::PAY_PENDING, Property::PAY_UNKNOWN))
            || ($rows[$i]['auction_sale'] == $auction_sale_ar['auction'] && $rows[$i]['start_time'] == '0000-00-00 00:00:00')
        ) { //NOT COMPLETE
            if (Property_isVendorOfProperty($rows[$i]['property_id'], $rows[$i]['agent_id'])) {
                $status = $watermark = 'not_complete';
            }
        } else { //COMPLETE*/

        $current_time = new DateTime(date('Y-m-d H:i:s'));
        if ($start_time <= $current_time AND $current_time <= $end_time) { //LIVE
            $status = 'live';
            if ($rows[$i]['reserve_price'] <= $rows[$i]['bid_price'] && $rows[$i]['reserve_price'] > 0) {
                $watermark = 'on_the_market';
            }

            if (in_array($rows[$i]['agent_type'], array('agent', 'theblock'))) {
                $countdown = $rows[$i]['set_count'];
            }
            $rows[$i]['bid_price'] = showPrice($rows[$i]['bid_price']);
        } else { //FORTH
            $status = 'forthcoming';
            $rows[$i]['bid_price'] = showLowPrice($rows[$i]['reserve']) . ' - ' . showHighPrice($rows[$i]['reserve']);
            $countdown = 'Auction starts: ' . $start_time->format($config_cls->getKey('general_date_format'));
            $rows[$i]['auction_starts'] = 'Auction starts';
            $rows[$i]['auction_starts_date'] = $start_time->format($config_cls->getKey('general_date_format'));
        }

        $watermark = $rows[$i]['agent_active'] == 0 || $rows[$i]['active'] == 0 ? 'wait_for_activation'
                : $watermark;

        // }

        $rows[$i]['bid_status_bidder'] = Bid_getShortNameLastBidder($rows[$i]['property_id']);

        $agent = A_getCompanyInfo($rows[$i]['property_id']);

        $rows[$i]['isBlock'] = PE_isTheBlock($rows[$i]['property_id']);
        $rows[$i]['ofAgent'] = PE_isTheBlock($rows[$i]['property_id'], 'agent') ? 1 : 0;

         if ($rows[$i]['isBlock'] || $rows[$i]['ofAgent']) {
            $rows[$i]['agent_company_name'] = $agent["company_name"];
            $rows[$i]['agent_company_website'] = $agent["website"];
            $me = A_getAgentManageInfo($rows[$i]['property_id']);
            if($me!=null)
                $rows[$i]['agent_company_telephone'] = $me["telephone"];
        }

        $title = $status == 'forthcoming'
                ? 'AUCTION STARTS: ' . $start_time->format($config_cls->getKey('general_date_format'))
                : $title . ' ' . $end_time->format($config_cls->getKey('general_date_format'));


        $title = $rows[$i]['ofAgent'] == 1
                ? 'OWNER: ' . $agent['company_name'] : $title;

        $rows[$i]['company_name'] = $agent['company_name'];
        $start_price = PT_getValueByCode($rows[$i]['property_id'], 'auction_start_price');
        $rows[$i]['check_start'] = ($start_price == $rows[$i]['bid_price']) ? true : false;

        //For switch Pro
        $row_history = $property_history_cls->get_Field($rows[$i]['property_id']);
        if (is_array($row_history) and count($row_history) > 0 && $rows[$i]['confirm_sold'] == Property::SOLD_UNKNOWN) { // !Property_isVendorOfProperty($rows[$i]['property_id'], $rows[$i]['agent_id'])) {
            if ((!PE_isLiveProperty((int)$rows[$i]['property_id']))) {
                if (!PE_isstopAuction($rows[$i]['property_id'])) {
                    $countdown = 'Switch';
                    if ($row_history['auction_sale'] != $auction_sale_ar['auction']) {
                        $title = 'FOR SALE: ' . $rows[$i]['suburb'];
                        $rows[$i]['bid_price'] = showPrice($row_history['reserve_price']);
                    } else {
                        $rows[$i]['check_start'] = false;
                        $rows[$i]['bid_status_bidder'] = $row_history['last_bidder'];
                        $rows[$i]['bid_price'] = showPrice($row_history['bid_price']);
                        $dt = new DateTime($row_history['end_time']);
                        $title = 'AUCTION ENDED: ' . $dt->format($config_cls->getKey('general_date_format'));
                    }
                }
            }
        }

        if ($rows[$i]['isBlock'] == 1 || $rows[$i]['ofAgent'] == 1) {
            $countdown = $rows[$i]['set_count'];
        } else if ($countdown != 'Switch') {
            $countdown = '-d:-:-:-';
        }

       /* if ($rows[$i]['ofAgent']) {
            $rows[$i]['agent_logo'] =  $agent['logo'];
        }*/

        //bid status


        if (strrpos($rows[$i]['bid_price'], "$") === false) {
            $bid_price = showPrice($rows[$i]['bid_price']); //showPrice($_row['bid_price']);
        } else {
            $bid_price = $rows[$i]['bid_price'];
        }
        if ($status == 'forthcoming') {
            if ($rows[$i]['isBlock'] != 1) {
                $countdown = 'Auction Starts: ' . $start_time->format($config_cls->getKey('general_date_format'));
            }
            //$bid_status = $start_time->format($config_cls->getKey('general_date_format'));
        } else {
            $isLastBidVendor = Bid_isLastBidVendor($rows[$i]['property_id'], $in_room);
            $bidder = $rows[$i]['bid_status_bidder'];
            if ($isLastBidVendor) {
                $bid_status['bidder'] = $in_room ? 'In Room Bid' : 'Vendor Bid';
            } else {
                $bid_status['bidder'] = $rows[$i]['stop_bid'] == 1 || $rows[$i]['confirm_sold'] == 1 || $countdown == 'Switch'
                        ? 'Last Bidder: ' . $bidder : 'Current Bidder: ' . $bidder;
            }

            if ((int)$rows[$i]['stop_bid'] == 1 || (int)$rows[$i]['confirm_sold'] == 1 || $countdown == 'Switch') {

                $temp = 0;
                if ($rows[$i]['stop_bid'] == 1) {
                    if ($bidder == '--') {
                        $bid_status['price'] = 'Start Price: ' . $bid_price;
                        $temp = 1;
                    }
                }
                if ($temp == 0) {

                    $bid_status['price'] = 'Last Bid: ' . $bid_price;
                }
            } else if ($rows[$i]['check_start']) {
                $bid_status['price'] = 'Start Price: ' . $bid_price;
            } else {
                if ($bidder == '--') {
                    $bid_status['price'] = 'Start Price: ' . $bid_price;
                } else {
                    $bid_status['price'] = 'Current Bid: ' . $bid_price;
                }
            }
        }
        // }

        $rows[$i]['watermark'] = $watermark;
        $rows[$i]['countdown'] = $rows[$i]['no_more_bid'] == 1 ?'No More Online Bids':$countdown;//PE_isNoMoreBid($rows[$i]['property_id'])
        $rows[$i]['status'] = $status;
        //   $rows[$i]['agent_logo'] = $agent_logo;
        $rows[$i]['title'] = $title;
        $rows[$i]['bid_status_bidder'] = $bid_status['bidder'];
        $rows[$i]['bid_status_price'] = $bid_status['price'];
       // $rows[$i]['is_mine'] = ($rows[$i]['agent_id'] == $_SESSION['agent']['id'])?1:0;
        $rows[$i]['is_mine'] = Property_isVendorOfProperty($rows[$i]['property_id'])?1:0;
         /*if($rows[$i]['agent_id'] == $_SESSION['agent']['id'] || $rows[$i]['agent_manager']==$_SESSION['agent']['id']){
            $rows[$i]['is_mine'] =1;
        }else{
            $rows[$i]['is_mine']=0;
        }*/
    }
    $data = array('p' => $p, 'item_per_page' => $len, 'item_count' => $item_count, 'data' => $rows);
    out('1', '', $data);
} catch (Exception $e) {
    out('0', $e->getMessage());
}
?>