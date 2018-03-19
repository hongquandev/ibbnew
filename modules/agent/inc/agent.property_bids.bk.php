<?php

include_once ROOTPATH . '/modules/note/inc/note.php';
global $config_cls;
if (!($rating_cls) || !($rating_cls instanceof Ratings)) {
    $rating_cls = new Ratings();
}

if (!($bid_transition_history_cls) || !($bid_transition_history_cls instanceof bids_transition_history)) {
    $bid_transition_history_cls = new bids_transition_history();
}
if (!isset($property_history_cls) || !($property_history_cls instanceof property_history)) {
    $property_history_cls = new property_history();
}

$form_data = array();

switch ($action_ar[0]) {
    case 'delete':
        $id = (int)restrictArgs(getParam('id', 0));
        $mode = getParam('mode') == 'grid' ? 'grid' : 'list';
        $page = getParam('page', 'my-property-bids');
        if ($page == 'my-reg-to-bids') {
            if ($_SESSION['agent']['id'] > 0 and $id > 0) {
                $bid_first_cls->update(array('abort' => 1), 'property_id =' . $id . ' AND agent_id=' . $_SESSION['agent']['id']);
                $session_cls->setMessage('Delete #' . $id . ' in your property register to bid list.');
            }

        } elseif ($id > 0 && $_SESSION['agent']['id'] > 0) {
            $row = $bid_cls->getRow('property_id = ' . $id . ' AND agent_id = ' . $_SESSION['agent']['id']);
            if (is_array($row) && count($row) > 0) {
                $bid_cls->delete('property_id = ' . $id . ' AND agent_id = ' . $_SESSION['agent']['id']);
                $session_cls->setMessage('Delete #' . $id . ' in your property bid list.');
            }
            $tran_row = $bid_transition_history_cls->getRow('property_id = ' . $id . ' AND agent_id = ' . $_SESSION['agent']['id']);
            if (is_array($tran_row) and count($tran_row) > 0) {
                $bid_transition_history_cls->delete('property_id = ' . $id . ' AND agent_id = ' . $_SESSION['agent']['id']);
                $session_cls->setMessage('Delete #' . $id . ' in your property bid list.');
            }

        }
        $restrict_page = '&bids_filter=' . $page;
        $link = ($mode == 'list') ? '/?module=agent&action=view-property_bids' . $restrict_page : '/?module=agent&action=view-property_bids&mode=grid' . $restrict_page;
        redirect(ROOTURL . $link);

        break;
    default:
        $count = array();
        $count['once'] = $config_cls->getKey('count_going_once');
        $count['twice'] = $config_cls->getKey('count_going_twice');
        $count['third'] = $config_cls->getKey('count_going_third');

        $mode_fix = getParam('mode') == 'grid' ? getParam('mode') : 'list';
        //$mode = getParam('mode');
        //$auction_sale_ar = PEO_getAuctionSale();
        //BEGIN FOR PAGGING
        $p = (int)restrictArgs(getParam('p', 0));
        $p = $p <= 0 ? 1 : $p;
        $len = 9;
        //END
        if (getPost('len', 0) > 0) {
            $_SESSION['len'] = (int)restrictArgs(getPost('len'));
        }
        $len = isset($_SESSION['len']) ? $_SESSION['len'] : 9;
        //END

        //Order By
        $auction_sale_ar = PEO_getAuctionSale();

        if (getPost('order_by') != '' || $_POST['search']['order_by'] != '') {
            $_SESSION['order_by'] = (getPost('order_by') != '') ? getPost('order_by') : $_POST['search']['order_by'];
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
                //$order_ar = " pro.property_id DESC ";
                //$order_ar = '   pro.stop_bid,pro.confirm_sold ASC pro.property_id DESC';
                break;
        }

        $order_ar = ($order_ar != '') ? ' ORDER BY ' . $order_ar : '';
        $smarty->assign('order_by', $order_by);
        //End Order By

        // Begin Bid and Reg to bid
        $strBidFilter = getParam('bids_filter', 'my-property-bids');
        $smarty->assign('bids_filter_select', $strBidFilter);
        if ($strBidFilter == 'my-reg-to-bids') // FOR reg to bid and not bid in property
        {
            $wh_str = ' AND (pro.property_id IN (SELECT DISTINCT b.property_id FROM `' . $bid_cls->getTable('bids_first_payment') . '` AS b WHERE b.agent_id = \'' . $_SESSION['agent']['id'] . '\' AND b.pay_bid_first_status > 0 AND b.abort = 0 ) ) ';
            //$wh_str .= ' AND (pro.start_time < \''.date('Y-m-d H:i:s').'\') ';

            /*IBB-1129: NHUNG
              [INT] The Block- My watchlist/ My register to bid - show pro false*/
            $wh_str .= ' AND IF(datediff(\'' . date('Y-m-d H:i:s') . '\',pro.sold_time) >= 14 ,0,1) AND pro.auction_sale !=  ' . $auction_sale_ar['private_sale'];
            /*$wh_str .= '  AND 1
                          AND pro.pay_status = '.Property::PAY_COMPLETE.'
                          AND pro.active = 1
                          AND pro.agent_active = 1';*/
            //$wh_str .= ' AND (pro.confirm_sold = '.Property::SOLD_UNKNOWN.')';
            $wh_str .= ' AND (pro.property_id NOT IN (SELECT DISTINCT bid.property_id FROM ' . $bid_cls->getTable() . ' AS bid WHERE bid.agent_id = ' . $_SESSION['agent']['id'] . ' ) ) ';
            $wh_str .= ' AND (pro.property_id NOT IN (SELECT DISTINCT bid_his.property_id FROM ' . $bid_transition_history_cls->getTable() . ' AS bid_his WHERE bid_his.agent_id = ' . $_SESSION['agent']['id'] . ' ))';
        } else {         // For bid on properties
            // END
            /*$wh_str = ' AND pro.property_id IN (SELECT DISTINCT bid.property_id FROM '.$bid_cls->getTable().' AS bid WHERE bid.agent_id = '.$_SESSION['agent']['id'].' )
                        OR (pro.property_id IN (SELECT DISTINCT bid_his.property_id FROM '.$bid_transition_history_cls->getTable().' AS bid_his WHERE bid_his.agent_id = '.$_SESSION['agent']['id'].' ))
                        AND pro.start_time < \''.date('Y-m-d H:i:s').'\'';*/
            $pro_his_wh = " IF( (SELECT COUNT(pro_his.property_id) FROM " . $property_history_cls->getTable() . " as pro_his
                                                   WHERE pro_his.property_id = pro.property_id) > 0 ,
                                 IF( ( 1
                                      AND pro.pay_status =" . Property::PAY_COMPLETE . "
                                      ),
                                      pro.auction_sale != " . $auction_sale_ar['private_sale'] . "
                                      AND pro.active = 1
                                      AND pro.agent_active = 1
                                      ,
                                      1
                                 )
                            ,1
                            )";
            //$pro_his_wh = " 1 " ;
            $wh_str = ' AND ((pro.property_id IN (SELECT DISTINCT bid.property_id
                                              FROM ' . $bid_cls->getTable() . ' AS bid
                                              WHERE bid.agent_id = ' . $_SESSION['agent']['id'] . ' )
                          AND pro.start_time < \'' . date('Y-m-d H:i:s') . '\'
                          AND pro.active = 1
                          AND IF(pro.auction_sale != ' . $auction_sale_ar['private_sale'] . ' , pro.end_time != "0000-00-00 00:00:00" AND pro.start_time != "0000-00-00 00:00:00" ,1)
                          AND pro.agent_active = 1
                          AND pro.pay_status = ' . Property::PAY_COMPLETE . '
                          AND pro.auction_sale !=' . $auction_sale_ar['private_sale'] . ' )
                    OR ( pro.property_id IN (SELECT DISTINCT bid_his.property_id
                                            FROM ' . $bid_transition_history_cls->getTable() . ' AS bid_his
                                            WHERE bid_his.agent_id = ' . $_SESSION['agent']['id'] . ')
                         AND pro.property_id IN (SELECT DISTINCT pro_his.property_id
                                            FROM ' . $property_history_cls->getTable() . ' AS pro_his
                                            WHERE pro_his.property_id = pro.property_id )
                         AND ' . $pro_his_wh . '
                        )
                    )';
        }


        $_SESSION['agent_detail']['prev_next'] = $wh_str . ' AND IF(datediff(\'' . date('Y-m-d H:i:s') . '\',pro.sold_time) >= 14 ,0,1)';
        $_SESSION['join'] = null;
        $_SESSION['where'] = 'list';
        $_SESSION['type_prev'] = 'property_bids';
        unset($_SESSION['wh_str']);

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
						(SELECT reg1.name FROM ' . $region_cls->getTable() . ' AS reg1 WHERE reg1.region_id = pro.state) AS state_name,
						(SELECT reg2.code FROM ' . $region_cls->getTable() . ' AS reg2 WHERE reg2.region_id = pro.state) AS state_code,
						(SELECT reg3.name FROM ' . $region_cls->getTable() . ' AS reg3 WHERE reg3.region_id = pro.country) AS country_name,
						(SELECT reg4.code FROM ' . $region_cls->getTable() . ' AS reg4 WHERE reg4.region_id = pro.country) AS country_code,
						(SELECT pro_opt1.value 
							FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt1
							WHERE pro_opt1.property_entity_option_id = pro.bathroom) AS bathroom_value,
						(SELECT pro_opt2.value 
							FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt2
							WHERE pro_opt2.property_entity_option_id = pro.bedroom) AS bedroom_value,
						(SELECT pro_opt3.value 
							FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt3
							WHERE pro_opt3.property_entity_option_id = pro.car_port) AS carport_value,
				        (SELECT pro_opt8.value
                        FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt8
                        WHERE pro_opt8.property_entity_option_id = pro.car_space
                        ) AS carspace_value,
						(SELECT pro_opt6.code
							FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt6
							WHERE pro_opt6.property_entity_option_id = pro.auction_sale) AS auction_sale_code,

					    ' . $sub_select . '
					    (SELECT CASE
							WHEN auction_sale != ' . $auction_sale_ar['private_sale'] . " AND ( pro.start_time > '" . date('Y-m-d H:i:s') . "' OR isnull(max(bid.price)) ) THEN
								(SELECT pro_term.value
								FROM " . $property_cls->getTable('property_term') . " AS pro_term
								LEFT JOIN " . $property_cls->getTable('auction_terms') . " AS term
								ON pro_term.auction_term_id = term.auction_term_id
								WHERE term.code = 'auction_start_price' AND pro.property_id = pro_term.property_id
								)
							WHEN auction_sale = " . $auction_sale_ar['private_sale'] . " AND pro.price != 0 THEN pro.price
                            WHEN auction_sale = " . $auction_sale_ar['private_sale'] . " AND pro.price = 0 AND pro.price_on_application != 0 THEN pro.price_on_application
							ELSE (max(bid.price))
							END
					    FROM " . $property_cls->getTable('bids') . ' AS bid
						WHERE bid.property_id = pro.property_id ) AS price

				FROM ' . $property_cls->getTable() . ' AS pro
				LEFT JOIN ' . $agent_cls->getTable() . ' AS agt ON agt.agent_id = pro.agent_id

				WHERE 1
                '
            . $wh_str
            . $wh_string
            . $order_ar . '
				LIMIT ' . (($p - 1) * $len) . ',' . $len;

        $rows = $property_cls->getRows($sql, true);
        $total_row = $property_cls->getFoundRows();
        $review_pagging = (($p - 1) * $len) . ' - ' . (($p * $len) > $total_row ? $total_row : ($p * $len)) . ' (' . $total_row . ' items)';
        $v = 'view-property_bids';
        $bids_filter = '';
        if ($strBidFilter == 'my-reg-to-bids') {
            $bids_filter = "&bids_filter=my-reg-to-bids";
        }
        if ($mode_fix == 'grid') {
            $pag_cls->setTotal($total_row)
                ->setPerPage($len)
                ->setCurPage($p)
                ->setLenPage(10)
                ->setUrl('?module=agent&action=' . $v . $bids_filter . '&mode=grid')
                ->setLayout('link_simple');
        } else {
            $pag_cls->setTotal($total_row)
                ->setPerPage($len)
                ->setCurPage($p)
                ->setLenPage(10)
                ->setUrl('?module=agent&action=' . $v . $bids_filter . '&mode=list')
                ->setLayout('link_simple');
        }

        $smarty->assign('mode_fix', $mode_fix);
        $smarty->assign('review_pagging', $review_pagging);
        $smarty->assign('pag_str', $pag_cls->layout());
        $results = array();
        if ($property_cls->hasError()) {

        } else if (is_array($rows) and count($rows) > 0) {
            foreach ($rows as $k => $row) {
                //print_r_pre($row['property_id']);
                $link_ar = array('module' => 'property', 'action' => 'view-auction-detail', 'id' => $row['property_id']);
                $title = '';
                $dt = new DateTime($row['end_time']);
                $dt1 = new DateTime($row['start_time']);
                $dt2 = new DateTime(date('Y-m-d H:i:s'));
                $auction_option = PEO_getOptionById($row['auction_sale']);
                $title = $row['auction_sale_code'] == 'auction' ? 'AUCTION' : strtoupper($auction_option['title']);

                $results[$k]['info'] = $row;
                $results[$k]['info']['isBlock'] = PE_isTheBlock($row['property_id']) ? 1 : 0;
                $results[$k]['info']['ofAgent'] = PE_isTheBlock($row['property_id'], 'agent') ? 1 : 0;
                if ($results[$k]['info']['ofAgent']) {
                    $results[$k]['agent'] = A_getCompanyInfo($row['property_id']);
                }
                if (in_array($row['auction_sale_code'], array('auction', 'ebiddar', 'ebidda30', 'bid2stay'))) {
                    if ($dt1 > $dt2) { //FORTHCOMING
                        $results[$k]['info']['type'] = 'forthcoming';
                        $results[$k]['info']['remain_time'] = remainTime($row['start_time']);
                        $results[$k]['info']['price'] = $row['price_on_application'] == 1 ? 'Price On Application' : showLowPrice($row['price']) . ' - ' . showHighPrice($row['price']);
                        if (in_array($row['auction_sale_code'], array('ebiddar', 'bid2stay')) && $row['price_on_application'] == 0) {
                            $results[$k]['info']['price'] = 'Starting at ' . showPrice($row['price']);
                        }
                    } else { //LIVE
                        $results[$k]['info']['type'] = 'live';
                        $results[$k]['info']['remain_time'] = remainTime($row['end_time']);
                        $results[$k]['info']['price'] = showPrice($row['price']);
                    }
                } else {
                    $results[$k]['info']['type'] = 'sale';
                }

                $address = $row['address'] . ' ' . $row['suburb'] . ' ' . $row['postcode'] . ' ' . $row['state_name'] . ' ' . $row['country_name'];
                $results[$k]['info']['full_address'] = $address;
                $results[$k]['info']['isLastBidVendor'] = Bid_isLastBidVendor($row['property_id']);
                $results[$k]['info']['livability_rating_mark'] = showStar($row['livability_rating_mark']);
                $results[$k]['info']['green_rating_mark'] = showStar($row['green_rating_mark']);
                $results[$k]['info']['description'] = strlen($row['description']) > 150 ? safecontent(strip_tags($row['description']), 150) . '...' : strip_tags($row['description']);
                $results[$k]['info']['bidder'] = Bid_getShortNameLastBidder($row['property_id']);
                $results[$k]['info']['reserve'] = PT_getValueByCode($row['property_id'], 'reserve');
                $results[$k]['info']['o4i'] = Calendar_createPopup($row['property_id'], $row['open_for_inspection']);
                $results[$k]['info']['mao'] = Property_makeAnOfferPopup($row['property_id']);

                $results[$k]['info']['register_bid'] = Property_registerBid($row['property_id']);
                if ($row['confirm_sold'] == 1) {
                    $results[$k]['info']['count'] = 'Sold';
                } else {
                    if ($results[$k]['info']['remain_time'] <= $count['once'] and $results[$k]['info']['remain_time'] > $count['twice']) {
                        $results[$k]['info']['count'] = 'Going Once';
                    } elseif ($results[$k]['info']['remain_time'] <= $count['twice'] and $results[$k]['info']['remain_time'] > $count['third']) {
                        $results[$k]['info']['count'] = 'Going Twice';
                    } elseif ($results[$k]['info']['remain_time'] <= $count['third'] and $row['stop_bid'] != 1) {
                        $results[$k]['info']['count'] = 'Third and Final call';
                    } else {
                        $results[$k]['info']['count'] = '';
                    }
                }

                $results[$k]['info']['status'] = 'Enable';

                if ($row['agent_active'] == 0) {
                    $results[$k]['info']['status'] = 'Disable';
                }
                if ($results[$k]['info']['carport_value'] == null AND $results[$k]['info']['parking'] == 1) {
                    $results[$k]['info']['carport_value'] = $results[$k]['info']['carspace_value'];
                }
                //check price>reserve price ?
                if ((int)$row['price'] >= (int)$results[$k]['info']['reserve'] && (int)$results[$k]['info']['reserve'] > 0) {
                    $results[$k]['info']['check_price_fix'] = $results[$k]['info']['check_price'] = true;
                } else {
                    $results[$k]['info']['check_price_fix'] = $results[$k]['info']['check_price'] = false;
                }

                //BEGIN GET START PRICE
                $start_price = PT_getValueByCode($row['property_id'], 'auction_start_price');
                $results[$k]['info']['check_start'] = ($start_price == $row['price']) ? true : false;

                $type = (in_array($row['auction_sale_code'], array('auction', 'ebiddar', 'ebidda30', 'bid2stay'))) ? 'auction' : 'sale';
                //$results[$k]['info']['link'] = '/?'.http_build_query($link_ar);
                $results[$k]['info']['link'] = shortUrl(array('module' => 'property', 'action' => 'view-' . $type . '-detail', 'id' => $row['property_id'], 'data' => ($row + array('auctionsale_code' => $row['auction_sale_code']))),
                    (PE_isTheBlock($row['property_id'], 'agent') ? Agent_getAgent($row['property_id']) : array()));
                $results[$k]['info']['link_detail'] = $results[$k]['info']['link'];
                $link_ar['module'] = 'agent';
                $link_ar['action'] = 'delete-property_bids';
                $link_ar['page'] = $strBidFilter;
                $results[$k]['info']['link_del'] = '/?' . http_build_query($link_ar);
                unset($link_ar['page']);
                if ($mode_fix == 'grid') {
                    $results[$k]['info']['link_del'] .= '&mode=grid';
                    $results[$k]['info']['full_address'] = safecontent($address, 20) . '...';
                }

                $_media = PM_getPhoto($row['property_id'], true);
                $results[$k]['photos'] = $_media['photo_thumb'];
                $results[$k]['photo_default'] = $_media['photo_thumb_default'];
                $results[$k]['photos_count'] = count($results[$k]['photos']);
                $results[$k]['num_note'] = Note_count("entity_id_to = " . $row['property_id'] . " AND entity_id_from = " . $_SESSION['agent']['id'] . " AND type = 'customer2property'");
                /*$results[$k]['info']['isVendor'] = ($row['agent_id'] == $_SESSION['agent']['id']) ? true : false;*/
                $results[$k]['info']['ebidda_watermark'] = PE_getEbiddaWatermark($row['property_id']);
                $results[$k]['info']['isVendor'] = Property_isVendorOfProperty($row['property_id'], $_SESSION['agent']['id']);
                if ($row['confirm_sold'] == Property::SOLD_UNKNOWN) {
                    $results[$k]['confirm_sold'] = false;
                } else {
                    $results[$k]['confirm_sold'] = $row['confirm_sold'];
                }


                if ($results[$k]['info']['type'] == 'forthcoming') {
                    $results[$k]['info']['title'] = $title . ' STARTS: <span style="font-size:11px;">' . $dt1->format($config_cls->getKey('general_date_format')) . '</span>';
                } else {
                    if ($dt > $dt2) {
                        $title .= ' ENDS: ';
                    } else {
                        $title .= ' ENDED: ';
                    }
                    $results[$k]['info']['title'] = $title . ' <span style="font-size:11px">' . $dt->format($config_cls->getKey('general_date_format')) . '</span>';
                }

                $results[$k]['info']['title'] = $results[$k]['info']['isBlock'] == 1 ? 'OWNER: ' . $row['owner'] : $results[$k]['info']['title'];
                $results[$k]['info']['isShowLinkDetail'] = ($row['pay_status'] == 2 AND $row['active'] == 1 AND $row['agent_active'] == 1);
                //$results[$k]['info']['title'] = $results[$k]['info']['ofAgent'] == 1?'OWNER: '.$results[$k]['agent']['company_name']:$results[$k]['info']['title'];

                //For switch Pro
                $results[$k]['info']['transition'] = false;
                $row_history = $property_history_cls->get_Field($row['property_id']);

                $results[$k]['info']['start_time'] = $dt1->format($config_cls->getKey('general_date_format'));
                if (is_array($row_history) and count($row_history) > 0 and $row['confirm_sold'] == Property::SOLD_UNKNOWN) {
                    if ((!PE_isLiveProperty((int)$row['property_id']))) {
                        if (!PE_isstopAuction($row['property_id'])) {
                            $results[$k]['info']['transition'] = true;

                            $results[$k]['info']['type'] = 'auction';
                            if ($row_history['auction_sale'] == $auction_sale_ar['private_sale']) {
                                $results[$k]['info']['type'] = 'sale';
                                $results[$k]['info']['title'] = 'FOR SALE: ' . $row['suburb'];
                                $results[$k]['info']['price'] = showPrice($row_history['reserve_price']);
                            } else {
                                $results[$k]['info']['type'] = 'auction';
                                $dt = new DateTime($row_history['end_time']);
                                $results[$k]['info']['bidder'] = $row_history['last_bidder'];
                                $results[$k]['info']['price'] = showPrice($row_history['bid_price']);
                                $results[$k]['info']['title'] = 'AUCTION ENDED: ' . $dt->format($config_cls->getKey('general_date_format'));
                                $results[$k]['info']['check_start'] = false;
                            }

                            /*NH EDIT*/
                            $results[$k]['info']['transition_code'] = $row['auction_sale_code'];
                            $results[$k]['info']['transition_to'] = PEO_getTitleOfAuctionSaleFromCode($row['auction_sale_code'], $row['property_id']);
                            $results[$k]['info']['transition_from'] = PEO_getTitleOfAuctionSale($row_history['auction_sale'], $row['property_id']);


                            /*if ($row['auction_sale_code'] != 'private_sale') {
                                $results[$k]['info']['transition_to'] = 'Auction';
                            }else{
                                $results[$k]['info']['transition_to'] = 'Private Sale';
                            }*/
                            $results[$k]['info']['can_offer'] = false;
                            if (PE_isForthAuction((int)$row['property_id']) OR PE_isLiveSale($row['property_id'])) {
                                $results[$k]['info']['can_offer'] = true;
                            }
                            if ($results[$k]['info']['transition'] == true) {
                                $results[$k]['info']['link'] = '';
                            }
                        }
                    }
                }
                // end switch
            }// END foreach
        }

        $form_action = array('module' => 'agent', 'action' => 'view-property_bids');

        $title_bar = 'MY PROPERTY BIDS';
        if ($strBidFilter == 'my-reg-to-bids') // FOR reg to bid and not bid in property
        {
            $title_bar = 'MY PROPERTY REGISTER TO BIDS';
        }
        // BEGIN Bid and Register to Bid Filter;
        $bids_filter = array('my-property-bids' => 'My Property Bids', 'my-reg-to-bids' => 'My Register To Bid');
        $smarty->assign('bids_filter', $bids_filter);
        // End
        $smarty->assign('len', $len);
        $smarty->assign('len_ar', PE_getItemPerPage());
        $smarty->assign('property_title_bar', $title_bar);
        $form_action = '?' . http_build_query($form_action);
        $smarty->assign('form_action', $form_action);
        $smarty->assign('order_by_action', 'property_bids');
        $smarty->assign('agent_info', $_SESSION['agent']);

        $smarty->assign('agent_id', $_SESSION['agent']['id']);
        $smarty->assign('form_data', formUnescapes($form_data));
        $smarty->assign('results', formUnescapes($results));
        break;
}
?>