<?php
include_once ROOTPATH.'/modules/note/inc/note.php';
global $config_cls;
if (!($rating_cls) || !($rating_cls instanceof Ratings)) {
    $rating_cls = new Ratings();
}
if (!($bid_transition_history_cls ) || !($bid_transition_history_cls instanceof bids_transition_history)) {
    $bid_transition_history_cls = new bids_transition_history();
}
if (!isset($property_history_cls) || !($property_history_cls instanceof property_history)) {
    $property_history_cls = new property_history();
}
$form_data = array();
$action = getParam('action','view-property-bids');
$action_ar = explode('-',$action);
switch ($action) {
    case 'delete':
        break;
    default:
        $count = array();
        $count['once'] = $config_cls->getKey('count_going_once');
        $count['twice'] = $config_cls->getKey('count_going_twice');
        $count['third'] = $config_cls->getKey('count_going_third');

        $mode_fix = getParam('mode') == 'grid' ? getParam('mode'):'list';
        $mode = $mode_fix;
        //BEGIN FOR PAGGING
        $p = (int)restrictArgs(getParam('p',0));
        $p = $p <= 0 ? 1: $p;
        $len = 9;
        //END
        if (getPost('len',0) > 0) {
            $_SESSION['len'] = (int)restrictArgs(getPost('len'));
        }
        $len = isset($_SESSION['len']) ? $_SESSION['len'] : 9;
        //END

        //Order By
        $auction_sale_ar = PEO_getAuctionSale();
        if (getPost('order_by') != '' || $_POST['search']['order_by'] != '') {
            $_SESSION['order_by'] = (getPost('order_by') != '')?getPost('order_by'):$_POST['search']['order_by'];
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
                //$order_ar = ' pro.confirm_sold, pro.stop_bid,pro.pay_status, pro.property_id DESC';
                $order_ar = " pro.property_id DESC ";
                break;
        }

        $order_ar = ($order_ar != '') ? ' ORDER BY ' . $order_ar : '';
        //$smarty->assign('order_by',$order_by);
        //End Order By

        // Begin Bid and Reg to bid
        $strBidFilter = "view-property-bids";
        if($strBidFilter == 'my-reg-to-bids')// FOR reg to bid and not bid in property
        {
            $wh_str  = ' AND (pro.property_id IN (SELECT DISTINCT b.property_id FROM `'.$bid_cls->getTable('bids_first_payment').'` AS b WHERE b.agent_id = \''.$_SESSION['agent']['id'].'\' AND b.pay_bid_first_status > 0 AND b.abort = 0 ) ) ';

            /*IBB-1129: NHUNG
              [INT] The Block- My watchlist/ My register to bid - show pro false*/
            $wh_str .= ' AND IF(datediff(\''.date('Y-m-d H:i:s').'\',pro.sold_time) >= 14 ,0,1) AND pro.auction_sale =  '.$auction_sale_ar['auction'];

            $wh_str .= ' AND (pro.property_id NOT IN (SELECT DISTINCT bid.property_id FROM '.$bid_cls->getTable().' AS bid WHERE bid.agent_id = '.$_SESSION['agent']['id'].' ) ) ';
            $wh_str .= ' AND (pro.property_id NOT IN (SELECT DISTINCT bid_his.property_id FROM '.$bid_transition_history_cls->getTable().' AS bid_his WHERE bid_his.agent_id = '.$_SESSION['agent']['id'].' ))';
        }
        else{// For bid on properties
            $pro_his_wh = " IF( (SELECT COUNT(pro_his.property_id) FROM ".$property_history_cls->getTable()." as pro_his
                                                   WHERE pro_his.property_id = pro.property_id) > 0 ,
                                 IF( ( 1
                                      AND pro.pay_status =".Property::PAY_COMPLETE."
                                      ),
                                      pro.auction_sale = ".$auction_sale_ar['auction']."
                                      AND pro.active = 1
                                      AND pro.agent_active = 1
                                      ,
                                      1
                                 )
                            ,1
                            )";
            $wh_str = ' AND ((pro.property_id IN (SELECT DISTINCT bid.property_id
                                              FROM '.$bid_cls->getTable().' AS bid
                                              WHERE bid.agent_id = '.$_SESSION['agent']['id'].' )
                          AND pro.start_time < \''.date('Y-m-d H:i:s').'\'
                          AND pro.active = 1
                          AND IF(pro.auction_sale = '.$auction_sale_ar['auction'].' , pro.end_time != "0000-00-00 00:00:00" AND pro.start_time != "0000-00-00 00:00:00" ,1)
                          AND pro.agent_active = 1
                          AND pro.pay_status = '.Property::PAY_COMPLETE.'
                          AND pro.auction_sale ='.$auction_sale_ar['auction'].' )
                    OR ( pro.property_id IN (SELECT DISTINCT bid_his.property_id
                                            FROM '.$bid_transition_history_cls->getTable().' AS bid_his
                                            WHERE bid_his.agent_id = '.$_SESSION['agent']['id'].')
                         AND pro.property_id IN (SELECT DISTINCT pro_his.property_id
                                            FROM '.$property_history_cls->getTable().' AS pro_his
                                            WHERE pro_his.property_id = pro.property_id )
                         AND '.$pro_his_wh.'
                        )
                    )';
        }


        $_SESSION['agent_detail']['prev_next'] = $wh_str.' AND IF(datediff(\''.date('Y-m-d H:i:s').'\',pro.sold_time) >= 14 ,0,1)';
        $_SESSION['join'] = null;
        $_SESSION['where'] = 'list';
        $_SESSION['type_prev'] = 'property_bids';
        $_SESSION['wh_str'] = $wh_str;

        $wh_arr = Property_getCondition();
        $wh_string = count($wh_arr) > 0 ? ' AND ' . implode(' AND ', $wh_arr) : '';
        $auction_sale = $auction_sale_ar['auction'];
        $filter_property = '   AND pro.auction_sale = ' . $auction_sale . '
                               AND pro.confirm_sold = '.Property::SOLD_UNKNOWN.'
                               AND IF((SELECT agt_typ.title FROM ' . $property_cls->getTable('agent_type') . ' AS agt_typ
                                       LEFT JOIN ' . $agent_cls->getTable() . ' AS agt ON agt.type_id = agt_typ.agent_type_id
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
                                            FROM '.$property_cls->getTable('bids').' AS bid
                                            WHERE pro.property_id = bid.property_id
                                                  AND (SELECT IF(ISNULL(max(bid.price)),0,max(bid.price))
                                                    FROM '.$property_cls->getTable('bids').' AS bid
                                                    WHERE pro.property_id = bid.property_id) = bid.price
                                            ) = pro.agent_id
                                            AND
                                             ((SELECT IF(ISNULL(max(bid.price)),0,max(bid.price))
                                            FROM '.$property_cls->getTable('bids').' AS bid
                                            WHERE pro.property_id = bid.property_id)
                                                >=
                                            (SELECT pro_term.value
                                            FROM '.$property_term_cls->getTable().' AS pro_term
                                            LEFT JOIN '.$auction_term_cls->getTable().' AS term
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
            .$filter_property
            .$wh_string
            .$order_ar.'
				LIMIT '.(($p - 1) * $len).','.$len;

        $rows = $property_cls->getRows($sql,true);
        $total_row = $property_cls->getFoundRows();
        $review_pagging = (($p - 1) * $len).' - '.(($p * $len) > $total_row ? $total_row : ($p * $len)).' ('.$total_row.' items)';
        $v = 'view-property_bids';
        $bids_filter = '';
        if($strBidFilter == 'my-reg-to-bids')
        {
            $bids_filter = "&bids_filter=my-reg-to-bids";
        }

        $results = array();
        if ($property_cls->hasError()) {
        } else if (is_array($rows) and count($rows) > 0) {
            $i = 0;
            foreach ($rows as $k => $row) {
                $k = $i;$i++;
                $link_ar = array('module' => 'property', 'action' => 'view-auction-detail' , 'id' => $row['property_id']);
                $title = '';
                $dt = new DateTime($row['end_time']);
                $dt1 = new DateTime($row['start_time']);
                $dt2 = new DateTime(date('Y-m-d H:i:s'));
                if ($dt > $dt2 ){
                    $title = 'AUCTION ENDS: ';
                }else {
                    $title = 'AUCTION ENDED: ';
                }
                $results[$k] = $row;
                $results[$k]['isBlock'] = PE_isTheBlock($row['property_id'])?1:0;
                $results[$k]['ofAgent'] = PE_isTheBlock($row['property_id'],'agent')?1:0;
                if ($results[$k]['ofAgent']){
                    $results[$k]['agent'] = A_getCompanyInfo($row['property_id']);
                }
                if ($row['auction_sale_code'] == 'auction') {
                    if ($dt1 > $dt2) { //FORTHCOMING
                        $results[$k]['type'] = 'forthcoming';
                        $results[$k]['remain_time'] = remainTime($row['start_time']);
                        $results[$k]['price'] = $row['price_on_application'] == 1?'Price On Application':showLowPrice($row['price']).' - '.showHighPrice($row['price']);
                    } else { //LIVE
                        $results[$k]['type'] = 'live';
                        $results[$k]['remain_time'] = remainTime($row['end_time']);
                        $results[$k]['price'] = showPrice($row['price']);
                    }
                }else{
                    $results[$k]['type'] = 'sale';
                }

                $address = $row['address'].' '.$row['suburb'].' '.$row['postcode'].' '.$row['state_name'].' '.$row['country_name'];
                $results[$k]['full_address'] = $address;
                $results[$k]['isLastBidVendor'] = Bid_isLastBidVendor($row['property_id']);
                //$results[$k]['livability_rating_mark'] = showStar($row['livability_rating_mark']);
                //$results[$k]['green_rating_mark'] = showStar($row['green_rating_mark']);
                $results[$k]['description'] = strlen($row['description']) > 150 ? safecontent(strip_tags($row['description']),150).'...':strip_tags($row['description']);
                $results[$k]['bidder'] = Bid_getShortNameLastBidder($row['property_id']);
                $results[$k]['reserve'] = PT_getValueByCode($row['property_id'],'reserve');
                //$results[$k]['o4i'] = Calendar_createPopup($row['property_id'],$row['open_for_inspection']);
                //$results[$k]['mao'] = Property_makeAnOfferPopup($row['property_id']);

                $results[$k]['register_bid'] = Property_registerBid($row['property_id']);
                if ($row['confirm_sold'] == 1){
                    $results[$k]['count'] = 'Sold';
                }else{
                    if ($results[$k]['remain_time'] <= $count['once'] and $results[$k]['remain_time'] > $count['twice']){
                        $results[$k]['count'] = 'Going Once';
                    }elseif ($results[$k]['remain_time'] <= $count['twice'] and $results[$k]['remain_time'] > $count['third']){
                        $results[$k]['count'] = 'Going Twice';
                    }elseif ($results[$k]['remain_time'] <= $count['third'] and $row['stop_bid'] != 1){
                        $results[$k]['count'] = 'Third and Final call';
                    }else{
                        $results[$k]['count'] = '';
                    }
                }
                $results[$k]['status'] = 'Enable';
                if ($row['agent_active'] == 0) {
                    $results[$k]['status'] = 'Disable';
                }
                if($results[$k]['carport_value'] == null AND $results[$k]['parking'] == 1)
                {
                    $results[$k]['carport_value'] = $results[$k]['carspace_value'];
                }
                //check price>reserve price ?
                if ((int)$row['price'] >= (int)$results[$k]['reserve'] && (int)$results[$k]['reserve'] > 0) {
                    $results[$k]['check_price_fix'] = $results[$k]['check_price'] = true;
                } else {
                    $results[$k]['check_price_fix'] = $results[$k]['check_price'] = false;
                }

                //BEGIN GET START PRICE
                $start_price = PT_getValueByCode($row['property_id'],'auction_start_price');
                $results[$k]['check_start'] = ($start_price == $row['price'])? true : false;

                $type = ($row['auction_sale_code'] == 'auction') ? 'auction' : 'sale';
                //$results[$k]['link'] = '/?'.http_build_query($link_ar);
                $results[$k]['link'] = shortUrl(array('module' => 'property', 'action' => 'view-'.$type.'-detail', 'id' => $row['property_id'], 'data' => ($row + array('auctionsale_code' => $row['auction_sale_code']))),
                    (PE_isTheBlock($row['property_id'],'agent')?Agent_getAgent($row['property_id']):array()));
                $results[$k]['link_detail'] = $results[$k]['link'];
                $link_ar['module'] = 'agent';
                $link_ar['action'] = 'delete-property_bids';
                $link_ar['page'] = $strBidFilter;
                $results[$k]['link_del'] = '/?'.http_build_query($link_ar);
                unset($link_ar['page']);
                if ($mode_fix == 'grid'){
                    $results[$k]['link_del'] .= '&mode=grid';
                    $results[$k]['full_address'] = safecontent($address,20).'...';
                }

                $_media = PM_getPhoto($row['property_id'],true);
                $results[$k]['photos'] = $_media['photo_thumb'];
                $results[$k]['photo_default'] = $_media['photo_thumb_default'];
                $results[$k]['photos_count'] = count($results[$k]['photos']);
                $results[$k]['num_note'] = Note_count("entity_id_to = ".$row['property_id']." AND entity_id_from = ".$_SESSION['agent']['id']." AND type = 'customer2property'");
                /*$results[$k]['isVendor'] = ($row['agent_id'] == $_SESSION['agent']['id']) ? true : false;*/
                $results[$k]['isVendor'] = Property_isVendorOfProperty($row['property_id'],$_SESSION['agent']['id']);
                if($row['confirm_sold'] == Property::SOLD_UNKNOWN){
                    $results[$k]['confirm_sold'] = false;
                }
                else{
                    $results[$k]['confirm_sold'] = true;
                }
                $results[$k]['title'] = $results[$k]['type'] == 'forthcoming'?'AUCTION STARTS: '.$dt1->format($config_cls->getKey('general_date_format')):$title.' '.$dt->format($config_cls->getKey('general_date_format'));
                $results[$k]['title'] = $results[$k]['isBlock'] == 1?'OWNER: '.$row['owner']:$results[$k]['title'];
                $results[$k]['isShowLinkDetail'] = ( $row['pay_status'] == 2 AND $row['active'] == 1 AND $row['agent_active'] == 1 );
                $results[$k]['title'] = $results[$k]['ofAgent'] == 1?'OWNER: '.$results[$k]['agent']['company_name']:$results[$k]['title'];

                //For switch Pro
                $results[$k]['transition'] = false;
                $row_history = $property_history_cls->get_Field($row['property_id']);

                $results[$k]['start_time'] =$dt1->format($config_cls->getKey('general_date_format'));
                if (is_array($row_history) and count($row_history) > 0 and $row['confirm_sold'] == Property::SOLD_UNKNOWN) {
                    if ((!PE_isLiveProperty((int)$row['property_id']))) {
                        if (!PE_isstopAuction($row['property_id'])) {
                            $results[$k]['transition'] = true;

                            $results[$k]['type'] = 'auction';
                            if($row_history['auction_sale'] != $auction_sale_ar['auction']){
                                $results[$k]['type'] = 'sale';
                                $results[$k]['title']  = 'FOR SALE: '.$row['suburb'];
                                $results[$k]['price'] = showPrice($row_history['reserve_price']);
                            }else{
                                $results[$k]['type'] = 'auction';
                                $dt = new DateTime($row_history['end_time']);
                                $results[$k]['bidder'] = $row_history['last_bidder'];
                                $results[$k]['price'] = showPrice($row_history['bid_price']);
                                $results[$k]['title'] = 'AUCTION ENDED: ' . $dt->format($config_cls->getKey('general_date_format'));
                                $results[$k]['check_start'] = false;
                            }
                            if ($row['auction_sale_code'] == 'auction') {
                                $results[$k]['transition_to'] = 'Auction';
                            }else{
                                $results[$k]['transition_to'] = 'Private Sale';
                            }
                            $results[$k]['can_offer'] = false;
                            if (PE_isForthAuction((int)$row['property_id']) OR PE_isLiveSale($row['property_id'])) {
                                $results[$k]['can_offer'] = true;
                            }
                            if($results[$k]['transition'] == true){
                                $results[$k]['link'] = '';
                            }
                        }
                    }
                }// end Switch pro

                /*====== BEGIN API========*/
                $watermark = ''; // SUCH AS: On the Market
                $countdown = ''; //SUCH AS: time for count down, Auction Start,Switch,...
                $countdown_color = ''; //Such AS: '#007700'(green),..;
                $status = '';
                $bidder_content = ''; // Such As: vendor bid,Last bidder abc,Current Bidder ABC.;
                $price_content = '' ;//Such AS: Start price: $100, Current Bid: $100, Last Bid: $100;

                if($results[$k]['type'] == 'forthcoming'){
                    if( $results[$k]['isBlock'] == 1){
                        $countdown = $results[$k]['remain_time'];
                    }else{
                        $countdown = 'Auction Starts: '.$results[$k]['start_time'];
                    }
                }else{
                    if($results[$k]['isBlock'] and $results[$k]['ofAgent']){
                        $countdown = $results[$k]['set_count'];
                    }elseif(!$results[$k]['transition']){
                        $countdown = $results[$k]['remain_time'];
                        if($results[$k]['type']== 'live' AND $results[$k]['check_price'] AND $results[$k]['stop_bid'] == 0 AND !$results[$k]['confirm_sold']){
                            $watermark = 'on_the_market';
                        }
                    }else{
                        $countdown = 'Switch';
                    }

                    //BEGin Bidder
                    if($results[$k]['isLastBidVendor']){
                        $bidder = 'Vendor Bid';
                    }else{
                        if($results[$k]['stop_bid'] == 1 or $results[$k]['confirm_sold'] or $results[$k]['transition']){
                            $bidder = 'Last Bidder: '.$results[$k]['bidder'];
                        }else{
                            $bidder = 'Current Bidder: '.$results[$k]['bidder'];
                        }
                    }
                    //END Bidder
                    //BEGIN Price Content
                    if($results[$k]['stop_bid'] == 1 OR $results[$k]['confirm_sold'] OR $results[$k]['transition']){
                        if($results[$k]['']['bidder'] == '--'){
                            $price_content = "Start Price:";
                        }else{
                            $price_content = "Last Bid:";
                        }
                    }elseif($results[$k]['check_start']){
                        $price_content = "Start Price:";
                    }else{
                        $price_content = "Current Bid:";
                    }
                    $price_content .= $results[$k]['price'];
                    //END Price Content
                }
                if($results[$k]['confirm_sold']){
                    $countdown = "SOLD";
                }
                //Begin Countdown color
                if($results[$k]['check_price'] AND !$results[$k]['transition'] AND $results[$k]['stop_bid'] == 0 AND !$results[$k]['confirm_sold']){
                    $countdown_color = "#007700";
                }
                //END Coundown color

                //$results[$k]['o4i_show'] = 'Open for Inspection: '.$results[$k]['o4i'];
                $results[$k]['notes'] = 'Notes('.$results[$k]['num_note'].")";
                $results[$k]['bidder_content'] = $bidder;
                $results[$k]['watermark']= $watermark;
                $results[$k]['countdown']= $countdown;
                $results[$k]['countdown_color']= $countdown_color;
                $results[$k]['price_content']= $price_content;
                $$results[$k]['status']= $status;
                /*=======END API*/
            }// END foreach
        }
        $rows = $results;
        die(json_encode($rows));
        break;
}
?>