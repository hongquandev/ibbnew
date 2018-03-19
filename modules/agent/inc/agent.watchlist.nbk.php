<?php
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/modules/note/inc/note.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/general/inc/bids_first.class.php';
if (!isset($property_history_cls) || !($property_history_cls instanceof property_history)) {
	$property_history_cls = new property_history();
}
if (!isset($bids_first_cls) or !($bids_first_cls instanceof Bids_first)) {
	$bids_first_cls = new Bids_first();
}
global $config_cls;
//$mode_fix = $_GET['mode'] == 'grid'? 'grid' : 'list';
$mode_fix = $_GET['mode'];

switch ($action_ar[0]) {
	case 'delete':
		$id = (int)restrictArgs(getParam('id',0));//product id
        //$mode = getParam('mode') == 'grid' ? getParam('mode') : 'list';
            $mode = getParam('mode');
		if ($id > 0 && $_SESSION['agent']['id'] > 0) {
			$row = $watchlist_cls->getRow('property_id = '.$id.' AND agent_id = '.$_SESSION['agent']['id']);
			if (is_array($row) && count($row) > 0) {
				$watchlist_cls->delete('property_id = '.$id.' AND agent_id = '.$_SESSION['agent']['id']);
				$session_cls->setMessage('Delete #'.$id.' from your watchlist.');
			}
		}
        $link = ($mode == '') ? '/?module=agent&action=view-watchlist' : '/?module=agent&action=view-watchlist&mode=grid';
		redirect(ROOTURL.$link);

	break;
	default:
        //$mode_fix = getParam('mode');
        $count = array();
        $count['once'] = $config_cls->getKey('count_going_once');
        $count['twice'] = $config_cls->getKey('count_going_twice');
        $count['third'] = $config_cls->getKey('count_going_third');

		$p = (int)restrictArgs(getQuery('p',0));
		$p = $p <= 0 ? 1 : $p;
		$len = 9;

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
                    $order_ar =  ' last_price,price DESC';
                    $sub_select = '(SELECT pro_his.bid_price FROM property_transition_history AS pro_his
                                                             WHERE pro_his.property_id=pro.property_id ORDER BY pro_his.property_transition_history_id DESC LIMIT 0,1) as last_price,';
                    break;
                case 'lowest':
                    $order_ar =  ' last_price,price ASC';
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
                    $order_ar = 'pro.confirm_sold DESC';
                    break;
                default:
                    $order_ar = ' pro.confirm_sold, pro.stop_bid,pro.pay_status, pro.property_id DESC';
                    //$order_ar = '  pro.property_id DESC';
                    break;
            }

            $order_ar = ($order_ar != '') ? ' ORDER BY ' . $order_ar : '';
            $smarty->assign('order_by',$order_by);
            //End Order By

        /*$wh_str = 'IF (pro.stop_bid = 1  AND pro.confirm_sold = 0 AND datediff(\''.date('Y-m-d H:i:s').'\', pro.end_time) >= 2 ,0,1) = 1
    				AND IF (pro.confirm_sold = 1  AND datediff(\''.date('Y-m-d H:i:s').'\',pro.sold_time) >= 14  ,0,1) = 1';
        $_SESSION['wh_str'] = $wh_str;*/

        $_SESSION['join'] = ' INNER JOIN '.$watchlist_cls->getTable().' AS whl  ON pro.property_id = whl.property_id AND whl.agent_id = '.$_SESSION['agent']['id'];

        $_SESSION['where'] = 'watchlist';
        unset($_SESSION['wh_str']);


        $wh_arr = Property_getCondition();
        $wh_str = count($wh_arr) > 0 ? ' AND ' . implode(' AND ', $wh_arr) : '';
        $pro_his_wh = " IF( (SELECT COUNT(pro_his.property_id) FROM ".$property_history_cls->getTable()." as pro_his
                                                   WHERE pro_his.property_id = pro.property_id) > 0 ,
                             IF( pro.pay_status =".Property::PAY_COMPLETE.",pro.active = 1 AND pro.agent_active = 1, 1 )
                            ,1
                            )";
        $wh_str .= ' AND (  ( pro.property_id IN (SELECT DISTINCT wl.property_id
                                              FROM '.$watchlist_cls->getTable().' AS wl
                                              WHERE wl.agent_id = '.$_SESSION['agent']['id'].' )
                              AND pro.active = 1
                              AND pro.agent_active = 1
                              AND pro.pay_status = '.Property::PAY_COMPLETE.'
                             )
                         OR (pro.property_id IN (SELECT DISTINCT pro_his.property_id
                                                FROM '.$property_history_cls->getTable().' AS pro_his
                                                WHERE pro_his.property_id = pro.property_id )
                             AND '.$pro_his_wh.'
                             )
                        )';

		$sql = 'SELECT SQL_CALC_FOUND_ROWS 
							pro.property_id,
							pro.pay_status, 
							pro.kind,
							pro.parking,
							pro.address, 
							pro.price AS prices, 
							pro.suburb, 
							pro.postcode, 
							pro.end_time,
							pro.start_time,
							pro.stop_bid,
							pro.active,
							pro.livability_rating_mark,
							pro.green_rating_mark,
							pro.description,
							pro.land_size,
							pro.sold_time,
							pro.confirm_sold,
							pro.open_for_inspection,
							pro.owner,
							pro.set_count,
							pro.auction_sale,
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
							'.$sub_select."
							(SELECT CASE
									WHEN auction_sale != ".$auction_sale_ar['private_sale']." AND ( pro.start_time > '".date('Y-m-d H:i:s')."' OR isnull(max(bid.price)) ) THEN
										(SELECT pro_term.value
										FROM ".$property_cls->getTable('property_term')." AS pro_term
										LEFT JOIN ".$property_cls->getTable('auction_terms')." AS term
										ON pro_term.auction_term_id = term.auction_term_id
										WHERE term.code = 'auction_start_price' AND pro.property_id = pro_term.property_id
										)
									WHEN auction_sale = ".$auction_sale_ar['private_sale']." AND pro.price != 0 THEN pro.price
                                    WHEN auction_sale = ".$auction_sale_ar['private_sale']." AND pro.price = 0 AND pro.price_on_application != 0 THEN pro.price_on_application

									ELSE max(bid.price)
									END
								FROM ".$property_cls->getTable('bids')." AS bid
								WHERE bid.property_id = pro.property_id) AS price

					FROM ".$property_cls->getTable().' AS pro
					LEFT JOIN '.$agent_cls->getTable().' AS agt ON agt.agent_id = pro.agent_id
					INNER JOIN '.$watchlist_cls->getTable().' AS whl ON whl.property_id = pro.property_id
					WHERE  pro.property_id = whl.property_id
					AND whl.agent_id = '.$_SESSION['agent']['id'].' '
                    .$wh_str
                    .$order_ar.'
					LIMIT '.(($p - 1) * $len).','.$len;
		
		
		$rows = $property_cls->getRows($sql,true);
		$total_row = $property_cls->getFoundRows();
		$review_pagging = (($p - 1) * $len).' - '.(($p * $len) > $total_row ? $total_row : ($p * $len)).' ('.$total_row.' items)';
        if(isset($mode_fix) == 'grid') {
                   $pag_cls->setTotal($total_row)
				->setPerPage($len)
				->setCurPage($p)
				->setLenPage(10)
				->setUrl('?module=agent&action='.$action.'&mode=grid')
				->setLayout('link_simple');
        }
        else
        {
            $pag_cls->setTotal($total_row)
				->setPerPage($len)
				->setCurPage($p)
				->setLenPage(10)
				->setUrl('?module=agent&action='.$action.'&')
				->setLayout('link_simple');
        }

        $smarty->assign('mode_fix',$mode_fix);

		$smarty->assign('review_pagging',$review_pagging);
		$smarty->assign('pag_str',$pag_cls->layout());
		
		if (is_array($rows) and count($rows) > 0) {
			foreach ($rows as $k => $row) {
				$watchlist_data[$k]['info'] = $row;
                $dt = new DateTime($row['end_time']);
                $dt = $dt->format($config_cls->getKey('general_date_format'));
				$watchlist_data[$k]['info']['transition']='false';
                $watchlist_data[$k]['info']['isBlock'] = PE_isTheBlock($row['property_id'])?1:0;
                $watchlist_data[$k]['info']['ofAgent'] = PE_isTheBlock($row['property_id'],'agent')?1:0;
			//INFO
				$title = '';
				if ($row['auction_sale_code'] != 'private_sale') {

                    if ($row['start_time'] > date('Y-m-d H:i:s')
                        OR ($row['confirm_sold'] == Property::SOLD_COMPLETE AND $row['sold_time'] < $row['start_time'])
                    ){//FORTHCOMING
                        $auction_option = PEO_getOptionById($row['auction_sale']);
                        $title = $row['auction_sale_code'] == 'auction'?'AUCTION':strtoupper($auction_option['title']);
                        $title .= ' ENDS: '.$dt;
                        $type = 'forthcoming';
                        $reserve_price = PT_getValueByCode($row['property_id'],'reserve');
                        $watchlist_data[$k]['info']['price'] = $row['price_on_application'] > 0?'Price On Application':showLowPrice($reserve_price).' - '.showHighPrice($reserve_price);
                        if ($mode_fix == 'grid'){
                            $watchlist_data[$k]['info']['price'] = $row['price_on_application'] > 0?'<span>Price On Application</span>':'<div class="price-fc-a">From<span>: '.showLowPrice($reserve_price).'</span></div><div class="price-fc-b">To<span>: '.showHighPrice($reserve_price).'</span></div>';
                        }
                        if ($row['auction_sale_code'] == 'ebiddar' && $row['price_on_application'] ==  0){
                            $watchlist_data[$k]['info']['price'] = 'Starting at '.showPrice($row['price']);
                        }
                        $watchlist_data[$k]['info']['remain_time'] = remainTime($row['start_time']);
                        $dt = new DateTime($row['start_time']);
                        $dt = $dt->format($config_cls->getKey('general_date_format'));
                        $watchlist_data[$k]['info']['start_time'] = $dt;

                    }else {//LIVE
                        $type = 'auction';
                        $watchlist_data[$k]['info']['price'] = showPrice($row['price']);
					    $watchlist_data[$k]['info']['bidder'] = Bid_getShortNameLastBidder($row['property_id']);

                        $watchlist_data[$k]['info']['reserve'] = PT_getValueByCode($row['property_id'],'reserve');

                       //check price>reserve price ?
					    if ($row['price'] >= $watchlist_data[$k]['info']['reserve'] && $watchlist_data[$k]['info']['reserve'] > 0) {
						        $watchlist_data[$k]['info']['check_price'] = true;
					    } else {
						       $watchlist_data[$k]['info']['check_price'] = false;
					    }

                        //BEGIN GET START PRICE
                        $start_price = PT_getValueByCode($row['property_id'],'auction_start_price');
                        $watchlist_data[$k]['info']['check_start'] = ($start_price == $row['price'])? true: false;

                        //title
                        $dt1 = new DateTime($row['end_time']);
                        $dt2 = new DateTime(date('Y-m-d H:i:s'));
                        $auction_option = PEO_getOptionById($row['auction_sale']);
                        $title = $row['auction_sale_code'] == 'auction'?'AUCTION':strtoupper($auction_option['title']);
                        if ($dt1 > $dt2) {
                           $title .= ' ENDS: '.$dt;
                        }
                        else {
                           $title .= ' ENDED: '.$dt;
                        }
                        $watchlist_data[$k]['info']['remain_time'] = remainTime($row['end_time']);
                    }

				} else {//FOR SALE

					$title = 'FOR SALE: '.$row['suburb'];
                    $type = 'sale';
                    $watchlist_data[$k]['info']['price'] = $row['price_on_application'] == 1?'Price On Application':showPrice($row['price']);
				}

                if($row['confirm_sold'] == Property::SOLD_UNKNOWN)
                {
                    $watchlist_data[$k]['info']['confirm_sold'] = false;
                }
                else{
                     $watchlist_data[$k]['info']['confirm_sold'] = true;
                }

                $watchlist_data[$k]['info']['title'] = $title;
                if ($watchlist_data[$k]['info']['isBlock']){
                    $watchlist_data[$k]['info']['title'] = 'OWNER: '.$row['owner'];
                }/*elseif($watchlist_data[$k]['info']['ofAgent']){
                    $watchlist_data[$k]['agent'] = A_getCompanyInfo($row['property_id']);
                    $watchlist_data[$k]['info']['title'] = 'OWNER: '.$watchlist_data[$k]['agent']['company_name'];
                }*/
                
                $watchlist_data[$k]['info']['type'] = $type;

                //$watchlist_data[$k]['info']['link'] = '?module=property&action=view-'.$type.'-detail&id='.$row['property_id'];
				$watchlist_data[$k]['info']['link'] = shortUrl(array('module' => 'property', 'action' => 'view-'.$type.'-detail', 'id' => $row['property_id'], 'data' => ($row + array('auctionsale_code' => $row['auction_sale_code']))),
                                                               (PE_isTheBlock($row['property_id'],'agent')?Agent_getAgent($row['property_id']):array()));
                /*- <a href="{$property.info.link}" style="color:#990000; text-decoration:none" > View detail</a>*/
                // PRO is show in detail page on 14 day with sold time : QUAN
                $watchlist_data[$k]['view_detail'] = '';
                if (function_exists('date_diff')) {
                    $be_time = new DateTime($row['sold_time']);
                    $en_time = new DateTime(date('Y-m-d H:i:s'));
                    $date = date_diff($be_time, $en_time)->format('%d');
                    if ($date < 14 or $row['confirm_sold'] == Property::SOLD_UNKNOWN) {
                        if(PE_isActiveDetail($row['property_id']))
                        {
                            $watchlist_data[$k]['view_detail'] = '- <a href="' . $watchlist_data[$k]['info']['link'] . '" class="highlighta-red"> View detail</a>';
                        }
                    }
                }
                // END
                $address = $row['address'].' '.$row['suburb'].' '.$row['postcode'].' '.$row['state_name'].' '.$row['country_name'];
				$watchlist_data[$k]['info']['full_address'] = $address;
				$watchlist_data[$k]['info']['description'] = safecontent($row['description'],100);
                //$watchlist_data[$k]['info']['description'] = nl2br($row['description']);
                if (strlen($row['description']) > 150) {
                    $watchlist_data[$k]['info']['description'] = safecontent($row['description'],150).'...';
                }
				$watchlist_data[$k]['info']['livability_rating_mark'] = showStar($row['livability_rating_mark']);
				$watchlist_data[$k]['info']['green_rating_mark'] = showStar($row['green_rating_mark']);
                $watchlist_data[$k]['info']['isLastBidVendor'] = Bid_isLastBidVendor($row['property_id']);
                if ($row['confirm_sold'] == 1){
                    $watchlist_data[$k]['info']['count'] = 'Sold';
                }else{
                    if ( $watchlist_data[$k]['info']['remain_time'] <= $count['once'] and  $watchlist_data[$k]['info']['remain_time'] > $count['twice']){
                                $watchlist_data[$k]['info']['count'] = 'Going Once';
                    }elseif ( $watchlist_data[$k]['info']['remain_time'] <= $count['twice'] and  $watchlist_data[$k]['info']['remain_time'] > $count['third']){
                                $watchlist_data[$k]['info']['count'] = 'Going Twice';
                    }elseif ( $watchlist_data[$k]['info']['remain_time'] <= $count['third'] and $row['stop_bid'] != 1){

                             $watchlist_data[$k]['info']['count'] = 'Third and Final call';
                    }else{
                                $watchlist_data[$k]['info']['count'] = '';
                    }
                }
                if($watchlist_data[$k]['info']['carport_value'] == null AND $watchlist_data[$k]['info']['parking'] == 1)
                {
                    $watchlist_data[$k]['info']['carport_value'] = $watchlist_data[$k]['info']['carspace_value'];
                }
                $watchlist_data[$k]['info']['register_bid'] = Property_registerBid($row['property_id']);
                $watchlist_data[$k]['info']['is_mine'] = Property_isVendorOfProperty($row['property_id']);
                $watchlist_data[$k]['info']['check_passedInAuction'] = PE_isPassedInAuction($row['property_id']);
				$watchlist_data[$k]['info']['link_del'] = '?module=agent&action=delete-watchlist&id='.$row['property_id'];
                if ($mode_fix == 'grid'){
                    $watchlist_data[$k]['info']['link_del'] .= '&mode=grid';
                    $watchlist_data[$k]['info']['full_address'] = safecontent($address,25);
                }
                $watchlist_data[$k]['info']['o4i'] = Calendar_createPopup($row['property_id'],$row['open_for_inspection']);
				$watchlist_data[$k]['info']['mao'] = Property_makeAnOfferPopup($row['property_id']);

				$photo_data = array();
				$media_rows = $property_media_cls->getRows('SELECT med.media_id, med.file_name, med.type
										FROM '.$property_media_cls->getTable().' AS pro_med
										LEFT JOIN '.$media_cls->getTable()." AS med ON pro_med.media_id = med.media_id
										WHERE pro_med.property_id = ".$row['property_id']." AND med.`type` = 'photo'",true);

				if ($property_media_cls->hasError()) {

				} else if (is_array($media_rows) and count($media_rows) > 0) {
					$photo_data = $media_rows;
				}
                $watchlist_data[$k]['info']['ebidda_watermark'] = PE_getEbiddaWatermark($row['property_id']);
                //For switch Pro
                $watchlist_data[$k]['info']['transition'] = false;
                $row_history = $property_history_cls->get_Field($row['property_id']);
                if (is_array($row_history) and count($row_history) > 0 and $row['confirm_sold'] == Property::SOLD_UNKNOWN) {
                    if ((!PE_isLiveProperty((int)$row['property_id']))) {
                        if (!PE_isstopAuction($row['property_id'])) {
                            $watchlist_data[$k]['info']['transition'] = true;

                            $watchlist_data[$k]['info']['type'] = 'auction';
                            if($row_history['auction_sale'] == $auction_sale_ar['private_sale'])
                            {
                                $watchlist_data[$k]['info']['type'] = 'sale';
                                $watchlist_data[$k]['info']['title']  = 'FOR SALE: '.$row['suburb'];
                                $watchlist_data[$k]['info']['price'] = showPrice($row_history['reserve_price']);
                            }
                            else{
                                $watchlist_data[$k]['info']['type'] = 'auction';
                                $dt = new DateTime($row_history['end_time']);
                                $watchlist_data[$k]['info']['bidder'] = $row_history['last_bidder'];
                                $watchlist_data[$k]['info']['price'] = showPrice($row_history['bid_price']);
                                $auction_option = PEO_getOptionById($row['auction_sale']);
                                $title = $row['auction_sale_code'] == 'auction'?'AUCTION':strtoupper($auction_option['title']);
                                $watchlist_data[$k]['info']['title'] = $title. ' ENDED: ' . $dt->format($config_cls->getKey('general_date_format'));
                                $watchlist_data[$k]['info']['check_start'] = false ;
                            }

                            $watchlist_data[$k]['info']['transition_code'] = $row['auction_sale_code'];
                            $watchlist_data[$k]['info']['transition_to'] = PEO_getTitleOfAuctionSaleFromCode($row['auction_sale_code'],$row['property_id']);
                            $watchlist_data[$k]['info']['transition_from'] = PEO_getTitleOfAuctionSale($row_history['auction_sale'],$row['property_id']);
                            /*if ($row['auction_sale_code'] != 'private_sale') {
                                $watchlist_data[$k]['info']['transition_to'] = 'Auction';
                            }
                            else{
                                $watchlist_data[$k]['info']['transition_to'] = 'Private Sale';
                            }*/
                        }
                    }
                }
                // end switch
				/*$watchlist_data[$k]['photos'] = $photo_data;
				$watchlist_data[$k]['photos_count'] = count($photo_data);*/
                if($watchlist_data[$k]['info']['transition'])
                {
                    $watchlist_data[$k]['view_detail'] = '';

                    $watchlist_data[$k]['info']['link'] = '';
                }
				$_media = PM_getPhoto($row['property_id'],true);
				$watchlist_data[$k]['photos'] = $_media['photo_thumb'];
				$watchlist_data[$k]['photo_default'] = $_media['photo_thumb_default'];
				$watchlist_data[$k]['photos_count'] = count($watchlist_data[$k]['photos']);
                $watchlist_data[$k]['num_note'] = Note_count("entity_id_to = ".$row['property_id']." AND entity_id_from = ".$_SESSION['agent']['id']." AND type = 'customer2property'");
			}
		}

        $form_action= array('module'=>'agent','action'=>'view-watchlist');
                $title_bar = 'MY WATCHLIST';
                $smarty->assign('len', $len);
                $smarty->assign('len_ar', PE_getItemPerPage());
                $smarty->assign('property_title_bar', $title_bar);
                $form_action = '?'.http_build_query($form_action);
                $smarty->assign('form_action', $form_action);
                $smarty->assign('order_by_action', 'watchlist');


		$smarty->assign('watchlist_data',formUnescapes($watchlist_data));
        $smarty->assign('agent_id',$_SESSION['agent']['id']);
        $smarty->assign('agent_info',$_SESSION['agent']);
	break;
}
?>