<?php
include_once ROOTPATH.'/modules/property/inc/property.php';
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
$result = array();

    $id = (int)restrictArgs(getParam('property_id', 0));

    //get Data
    $count = array();
    $count['once'] = $config_cls->getKey('count_going_once');
    $count['twice'] = $config_cls->getKey('count_going_twice');
    $count['third'] = $config_cls->getKey('count_going_third');

    $auction_sale_ar = PEO_getAuctionSale();

    //BEGIN FOR PROPERTY
    if (!isset($_SESSION['agent']['id'])) $_SESSION['agent']['id'] = 0;


    //BEGIN SQL FOR CHECK ACTIVE
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


    $wh_arr = array();

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
											pro.livability_rating_mark,
											pro.green_rating_mark,
											pro.owner,
											pro.agent_manager,
											agt.type_id,
											pro.agent_active,
											pro.active,
											pro.set_count,
											pro.price_on_application,
											pro.show_agent_logo,

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
                                            FROM bids AS bid WHERE bid.property_id = pro.property_id) AS price


									FROM ' . $property_cls->getTable() . ' AS pro
									INNER JOIN ' . $property_cls->getTable('agent') . ' AS agt ON pro.agent_id = agt.agent_id

									WHERE pro.property_id = ' . $id
                                    . $wh_str . '

                                    ORDER BY pro.confirm_sold, pro.stop_bid, pro.property_id DESC'


        , true);
    $result = array();
    if ($property_cls->hasError()) {
    } else if (is_array($row) && count($row) > 0) {
        $isAgent = Property_isVendorOfProperty($row['property_id']);
        $result['bidder'] = !$isAgent?1:0;

        $result['info']['views'] = (int)$row['views'] > 0 ? $row['views'] : 0;
        $result['info']['bid'] = $row['bids'] > 0?$row['bids']:0;
        $result['info']['sustainability_rating_mark'] = $row['livability_rating_mark'];
        $result['info']['type_name'] = $row['type_name'];

        $result['info']['extra'] = array();
        if ($row['kind'] == 1){
            $extra = array('carport'=> $row['carport_value'] == null && $row['parking'] == 1?$row['carspace_value']:$row['carport_value'],
                           'bedroom'=>$row['bedroom_value'],
                           'bathroom'=>$row['bathroom_value']);
            $result['info']['extra'] = $extra;
        }
        $result['info']['land_size'] = $row['land_size'] != ''?'Land size: '.$row['land_size']:'';

        //STATUS(BID, TITLE, WATERMARK, COUNTDOWN)
        $result['info']['price'] = showPrice($row['price']);
        $result['info']['isBlock'] = PE_isTheBlock($row['property_id'])?1:0;
        $result['info']['ofAgent'] = PE_isTheBlock($row['property_id'], 'agent') ? 1 : 0;

        $row['reserve_price'] = PT_getValueByCode($row['property_id'], 'reserve');

        if(in_array($row['pay_status'],array(Property::PAY_PENDING,Property::PAY_UNKNOWN))
           || ($row['auction_sale'] == $auction_sale_ar['auction'] && $row['start_time'] == '0000-00-00 00:00:00')){//NOT COMPLETE
            if ($isAgent){
                $result['watermark'] = 'not_complete';
            }
        }else{//COMPLETE
            if ($row['confirm_sold'] == 1) { //SOLD
                $result['countdown'] = 'SOLD';
                $result['watermark'] = 'sold';
            } elseif ($row['auction_sale'] == $auction_sale_ar['auction']) {
                if ($row['stop_bid'] == 1) { //SOLD OR PASSEDIN
                    $result['watermark'] = $row['reserve_price'] < $row['bid_price'] && $row['reserve_price'] > 0 ? 'sold': 'passed_in';
                    $result['countdown'] = $row['reserve_price'] < $row['bid_price'] && $row['reserve_price'] > 0 ? 'SOLD': 'PASSED IN';
                     if (($result['info']['isBlock'] || $result['info']['ofAgent'])){
                           $result['countdown'] = $row['set_count'];
                           $result['watermark'] = $row['set_count'] == 'SOLD'?'sold':'passed_in';
                     }
                } else {
                    $start_time = new DateTime($row['start_time']);
                    $end_time = new DateTime($row['end_time']);
                    $current_time = new DateTime(date('Y-m-d H:i:s'));

                    $result['info']['end_time'] = $end_time->format($config_cls->getKey('general_date_format'));

                    if ($start_time <= $current_time AND $current_time <= $end_time) { //LIVE
                        if ($row['reserve_price'] <= $row['bid_price'] && $row['reserve_price'] > 0) {
                            $result['watermark'] = 'on_the_market';
                        }
                        if (($result['info']['isBlock'] || $result['info']['ofAgent']) && !$result['countdown']) {
                            $result['countdown'] = $row['set_count'];
                        }

                        $result['info']['pro_type'] = 'auction';
                        $result['info']['remain_time'] = remainTime($row['end_time']);
                        $result['title'] = $end_time < $current_time?'AUCTION ENDED: ' . $result['info']['end_time']:'AUCTION ENDS: ' . $result['info']['end_time'];

                    } else { //FORTH
                        $start_time = new DateTime($row['start_time']);
                        $result['info']['start_time'] = $start_time->format($config_cls->getKey('general_date_format'));
                        $result['countdown'] = 'Auction starts: ' . $result['info']['start_time'];
                        $result['info']['pro_type'] = 'forthcoming';
                        $result['title'] = 'FORTHCOMING:' . $result['info']['end_time'];
                        $result['info']['price'] = $row['price_on_application'] == 1 ? 'Price On Application': showLowPrice($row['reserve_price']) . '-' . showHighPrice($row['reserve_price']);
                        $result['info']['remain_time'] = remainTime($row['start_time']);

                    }
                }

                $result['watermark'] = $row['agent_active'] == 0 || $row['active'] == 0 ? 'wait_for_activation' : $result['watermark'];
            } else {
                $result['info']['pro_type'] = 'sale';
                $result['title'] = 'FOR SALE : ' . $row['suburb'];
                $result['info']['price'] = $row['price_on_application'] == 1 ? 'Price On Application': showPrice($row['price']);
            }
        }

        if ($result['info']['isBlock'] || $result['info']['ofAgent']) {
            $company_info = A_getCompanyInfo($row['property_id']);
            $agent_info = A_getAgentManageInfo($row['property_id']);

            //agent_info
            $_agent = array('name'=>$agent_info['full_name'],
                            'company'=>$company_info['company_name'],
                            'website'=>$agent_info['website'],
                            'telephone'=>$agent_info['telephone'],
                            'address'=>$agent_info['full_address'],
                            'email'=>$agent_info['email_address'],
                            'description'=>$agent_info['description'],
                            'logo'=>$row['logo']
                            );
            $result['agent_info'] = $_agent;
            $result['title'] = $agent_info['company_name'];
            $result['info']['no_more_bids'] = PE_isNoMoreBids($row['property_id'], isset($_SESSION['agent'])? $_SESSION['agent']['id']:0);
        }

        //bid status
        if($result['info']['pro_type'] == 'forthcoming'){
            $result['bid_status'] = $result['info']['start_time'];
        }elseif ($result['info']['pro_type'] != 'sale'){
            $isLastBidVendor = Bid_isLastBidVendor($row['property_id'],$in_room);
	        $bidder = formUnescape(Bid_getShortNameLastBidder($row['property_id']));
            if ($isLastBidVendor){
               $result['bid_status']['bidder'] = $in_room?'In Room Bid':'Vendor Bid';
            }else{
               $result['bid_status']['bidder'] = $row['stop_bid'] == 1 || $row['confirm_sold'] == 1?'Last Bidder: '.$bidder:'Current Bidder: '.$bidder;
            }

            if ($result['info']['bid'] == 0){
               $result['bid_status']['price'] = 'Start Price: '.$result['info']['price'];
            }else{
               $result['bid_status']['price'] = $row['stop_bid'] == 1 || $row['confirm_sold'] == 1?'Last Bid: '.$result['info']['price']:'Current Bid: '.$result['info']['price'];
            }
        }


        //END STATUS
        $result['info']['description'] = strip_tags(nl2br($row['description']));
        $result['info']['address_full'] = implode(', ', array($row['address'], $row['suburb'], $row['state_name'], $row['postcode'], $row['country_name']));
        $result['info']['address_short'] = strlen($result['info']['address_full']) > 30 ? substr($result['info']['address_full'],0,27).' ...' : $result['info']['address_full'];


        //BEGIN FOR MEDIA
        $_photo = PM_getPhoto($row['property_id'], true);
        //$result['photo'] = $_photo['photo'];
        $result['photo'] = $_photo['photo_thumb'];
        $result['photo_default'] = $_photo['photo_default'];
        if (count($result['photo']) == 0) {
            $result['info']['photo_default'] = $_photo['photo_default_detail'];

        }
        //END MEDIA

    }
    die(json_encode($result));
?>