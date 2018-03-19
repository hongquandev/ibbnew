<?php
$auction_sale_ar = PEO_getAuctionSale();

$wh_arr = Property_getCondition();
$wh_str = count($wh_arr) > 0 ? ' AND ' . implode(' AND ', $wh_arr) : '';


$rows = $property_cls->getRows('SELECT pro.property_id,
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
									   pro.stop_bid,
									   pro.active,
									   pro.auction_blog,
									   pro.confirm_sold,
									   pro.land_size,
									   pro.pay_status,
									   pro.focus,
									   pro.livability_rating_mark,
									   pro.green_rating_mark,
                                       pro.owner,
                                       pro.open_for_inspection,
                                       pro.set_count,
									   pro.autobid_enable,
                                       pro.min_increment,
                                       pro.max_increment,
                                       pro.price_on_application,
									(SELECT SUM(pro_log.view)
									FROM '.$property_cls->getTable('property_log').' AS pro_log
									WHERE pro_log.property_id = pro.property_id 
									)AS views,	
									
									(SELECT reg1.name 
									FROM '.$region_cls->getTable().' AS reg1 
									WHERE reg1.region_id = pro.state
									) AS state_name,
									
									(SELECT reg2.code 
									FROM '.$region_cls->getTable().' AS reg2 
									WHERE reg2.region_id = pro.state
									) AS state_code,
									
									(SELECT reg3.name 
									FROM '.$region_cls->getTable().' AS reg3 
									WHERE reg3.region_id = pro.country
									) AS country_name,
									
									(SELECT reg4.code 
									FROM '.$region_cls->getTable().' AS reg4 
									WHERE reg4.region_id = pro.country
									) AS country_code,
									
									(SELECT pro_opt1.value
									FROM '.$property_entity_option_cls->getTable().' AS pro_opt1
									WHERE pro_opt1.property_entity_option_id = pro.bathroom
									) AS bathroom_value,
										
									(SELECT pro_opt2.value
									FROM '.$property_entity_option_cls->getTable().' AS pro_opt2
									WHERE pro_opt2.property_entity_option_id = pro.bedroom
									) AS bedroom_value,
										
									(SELECT pro_opt3.value
									FROM '.$property_entity_option_cls->getTable().' AS pro_opt3
									WHERE pro_opt3.property_entity_option_id = pro.car_port
									) AS carport_value,
									(SELECT pro_opt8.value
                                    FROM '.$property_entity_option_cls->getTable().' AS pro_opt8
                                    WHERE pro_opt8.property_entity_option_id = pro.car_space
                                    ) AS carspace_value,
									(SELECT pro_opt5.title
									FROM '.$property_entity_option_cls->getTable().' AS pro_opt5
									WHERE pro_opt5.property_entity_option_id = pro.land_size
									) AS landsize_title,
										
									(SELECT pro_opt6.title
									FROM '.$property_entity_option_cls->getTable().' AS pro_opt6
									WHERE pro_opt6.property_entity_option_id = pro.type
									) AS type_name,
									(SELECT count(*)
											FROM '.$property_cls->getTable('bids').' AS bid
											WHERE bid.property_id = pro.property_id
											) AS bids,
									
			
									IF(pro.auction_sale = '.$auction_sale_ar['auction'].',
										(SELECT IF( ISNULL( MAX(b.price) ) ,
													(SELECT pro_term.value
													FROM '.$property_term_cls->getTable().' AS pro_term 
													LEFT JOIN '.$auction_term_cls->getTable().' AS term
														ON pro_term.auction_term_id = term.auction_term_id
													WHERE term.code = \'auction_start_price\' AND pro.property_id = pro_term.property_id
													),
													MAX(b.price) )
										FROM '.$bid_cls->getTable().' AS b
										WHERE b.property_id = pro.property_id
										)							
									, pro.price) AS price


							FROM '.$property_cls->getTable().' AS pro
							
							INNER JOIN '.$property_cls->getTable('agent').' AS agt ON pro.agent_id = agt.agent_id AND agt.type_id IN
									(SELECT agt_typ.agent_type_id FROM '.$property_cls->getTable('agent_type').' AS agt_typ WHERE agt_typ.title = \'theblock\')
							
							WHERE   pro.pay_status = '.Property::CAN_SHOW.'
									AND pro.active = 1
									AND pro.agent_active = 1'.
                                    $wh_str.'
									
							ORDER BY pro.confirm_sold, pro.stop_bid, pro.property_id DESC',true);

//IF(pro.hide_for_live = 1 AND pro.start_time > \''.date('Y-m-d H:i:s').'\', 0, 1) = 1 AND
$_SESSION['where'] = 'list';
$_SESSION['join'] = ' INNER JOIN '.$property_cls->getTable('agent').' AS agt ON pro.agent_id = agt.agent_id AND agt.type_id IN
									(SELECT agt_typ.agent_type_id FROM '.$property_cls->getTable('agent_type').' AS agt_typ WHERE agt_typ.title = \'theblock\')';
$_SESSION['type_prev'] = 'the_block';
$data = array();
if ($property_cls->hasError()) {

} else if(is_array($rows) and count($rows) > 0) {
	foreach ($rows as $key => $row) {
		$data[$key] = array();
		$data[$key] = $row;
		$data[$key]['views'] = $row['views'] > 0?$row['views']:0;
		//BEGIN FOR SALE
		$data[$key]['pro_type'] = 'sale';
		$data[$key]['title'] = 'FOR SALE:'.$row['suburb'];
		//END
        $link_ar = array('module' => 'property',
                                 //'action' => 'view-'.$data[$key]['pro_type'].'-detail',
                                 'action' => '',
                                 'id' => $row['property_id']);
		$link_ar['action'] = 'view-auction-detail';
		if ($row['auction_sale'] == $auction_sale_ar['auction']) {
			$time = '-:-:-';
			if ($row['end_time'] != '0000-00-00 00:00:00') {
				$dt = new DateTime($row['end_time']);
				$time = $dt->format($config_cls->getKey('general_date_format'));
			}
			$dt = new DateTime($row['end_time']);
			$data[$key]['end_time'] = $dt->format($config_cls->getKey('general_date_format'));
			if ($row['start_time'] > date('Y-m-d H:i:s')) {//FORTHCOMING
				$dt = new DateTime($row['start_time']);

				$data[$key]['pro_type'] = 'forthcoming';
				$link_ar['action'] = 'view-forthcoming-detail';
				$data[$key]['title'] = 'AUCTION STARTS: '.$dt->format($config_cls->getKey('general_date_format'));
                $reserve_price = PT_getValueByCode($row['property_id'],'reserve');
				$data[$key]['price'] = $row['price_on_application'] == 1?'POA':showLowPrice($reserve_price).' - '.showHighPrice($reserve_price);

				$data[$key]['start_time'] = $dt->format($config_cls->getKey('general_date_format'));
                $now = null;
				$data[$key]['remain_time'] = remainTime($row['start_time'],$now);
			} else {//AUCTION
				$data[$key]['pro_type'] = 'auction';
				$link_ar['action'] = 'view-auction-detail';
				$data[$key]['title'] = /*'OWNER: '.*/$row['owner'];
                $data[$key]['bid_price'] = $row['price'];
				$data[$key]['price'] = showPrice($row['price']);

				//BEGIN BIDDER
				$data[$key]['bidder'] = Bid_getShortNameLastBidder($row['property_id']);;
				//END
				//CALC REMAIN TIME Nhung edit
				$now = null;
				$data[$key]['remain_time'] = remainTime($row['end_time'],$now);
			}
		}
        //BEGIN GET RESERVE PRICE
		$data[$key]['reprice'] = PT_getValueByCode($row['property_id'],'reserve');
		$data[$key]['start_price'] = PT_getValueByCode($row['property_id'],'auction_start_price');
		//check price>reserve price ?
		//print_r('ID='.$row['property_id'].' bid='.$data[$key]['bid_price'].' Reserve='.$data[$key]['reprice']);
		if ($data[$key]['bid_price'] >= $data[$key]['reprice'] && $data[$key]['reprice'] > 0) {
			$data[$key]['check_price'] = true;
		} else {
			$data[$key]['check_price'] = false;
		}
		// Check start price
		$data[$key]['check_start']= false;
		if($data[$key]['start_price'] == $data[$key]['price'] ){
			$data[$key]['check_start']= true;
		}
				
        //$data[$key]['detail_link'] = ROOTURL.'/?'.http_build_query($link_ar);
		$data[$key]['detail_link'] = shortUrl($link_ar + array('data' => $row),
                                              (PE_isTheBlock($row['property_id'],'agent')?Agent_getAgent($row['property_id']):array()));
        $data[$key]['o4i'] = Calendar_createPopup($row['property_id'],$row['open_for_inspection']);
		$data[$key]['livability_rating_mark'] =  showStar((float)$row['livability_rating_mark']);
		$data[$key]['green_rating_mark'] = showStar((float)$row['green_rating_mark']);
        //print($row['property_id'].','.$row['livability_rating_mark'].','.$row['green_rating_mark']);
		$data[$key]['address_full'] = implode(', ',array($row['address'], $row['suburb'], $row['state_name'], $row['postcode'], $row['country_name']));
		$data[$key]['meta_description'] = strip_tags($row['description']);
        $data[$key]['description'] = safecontent(strip_tags($row['description']),370);
		//$data[$key]['description'] = $data[$key]['meta_description'] = nl2br($row['description']);
        /*if (strlen($row['description']) > 370) {
            $data[$key]['description'] = safecontent($row['description'],370).'...';
        }*/

        //$data[$key]['is_mine'] = Property_isMine($_SESSION['agent']['id'],$row['property_id']);
        $data[$key]['is_mine'] = Property_isVendorOfProperty($row['property_id']);

		//END

		//BEGIN FOR DOCUMENT
		$data[$key]['docs'] = PD_getDocs($row['property_id']);
		//END
        if($data[$key]['carport_value'] == null AND $data[$key]['parking'] == 1)
        {
            $data[$key]['carport_value'] = $data[$key]['carspace_value'];
        }
		//BEGIN FOR MEDIA
		$_media = PM_getPhoto($row['property_id']);
		$data[$key]['photo'] = $_media['photo'];
        $data[$key]['photo_count'] = count($_media['photo']);
		$data[$key]['photo_default'] = $_media['photo_default'];
        if(count($_media['photo']) == 0)
        {
            $data[$key]['photo_default'] = 'modules/property/templates/images/auction-img.jpg';
            $data[$key]['photo_default'] = $_media['photo_default_detail'];
            $data[$key]['photo_default_thumb'] = $_media['photo_default_thumb'];
        }
		$data[$key]['video'] = $_media['video'];
		$data[$key]['video_default'] = $_media['video_default'];
        $data[$key]['photo_facebook'] = $_media['photo_default'];
        //$data[$key]['photo_facebook'] = ROOTURL.'/'.PM_getThumbFacebook($_media['photo_default']);
		//END MEDIA

		//BEGIN VIEWMORE
		$smarty->assign('property_id',$row['property_id']);
		$smarty->assign('item', $data[$key]);
		$_str = '<a href="javascript:void(0)"  onClick="showPVM2(\''.$row['property_id'].'\')" class="viewmore pvm">&raquo;MORE INFORMATION</a>';
		//$_str .= $smarty->fetch(ROOTPATH.'/modules/property/templates/property.viewmore.popup.tpl');
        
		$data[$key]['view_more'] = $_str;
		$data[$key]['mao'] = Property_makeAnOfferPopup($row['property_id']);
        //$data[$key]['countdown'] = Property_makeCountDownPopup($row['property_id'], $row['autobid_enable'],$row['min_increment'],$row['max_increment']);
		//$data[$key]['is_paid'] = $bid_first_cls->getStatus(@$_SESSION['agent']['id'],$row['property_id']) || $_SESSION['agent']['type']== 'theblock';
        $data[$key]['is_paid'] = $bid_first_cls->getStatus(@$_SESSION['agent']['id'],$row['property_id']) || $data[$key]['is_mine'];
		//END
		//BEGIN FOR BID, AUTO BID
		//if (@$_SESSION['agent']['id'] > 0) {
			//abs~auto bid settings
			//$data[$key]['abs_tpl'] = Bid_showBox($row['property_id']);
		//}
		//END

        $iai_id = AT_getIdByCode('initial_auction_increments');
        $asp_id = AT_getIdByCode('auction_start_price');
        $term_ar = PT_getTermsKeyParentId($row['property_id']);
        $step_init = $term_ar[$iai_id];
        $inc_options = AT_getIncOptionsByMinMax($iai_id,$row['min_increment'],$row['max_increment']);
        $step_init = !in_array($step_init,array_keys($inc_options)) ? min(array_keys($inc_options)) : $step_init;
        $data[$key]['step_init_full'] = showPrice($term_ar[$iai_id]);
        $data[$key]['step_options'] =  $inc_options;
        $data[$key]['step_init'] = $step_init;
        //BEGIN FOR BID, AUTO BID
			if (@$_SESSION['agent']['id'] > 0) {
				//abs~auto bid settings
				//$data[$key]['abs_tpl'] = Bid_showBox($row['property_id']);
			} else {

			}
			//END
        $default_inc = PT_getValueByCode($row['property_id'],'initial_auction_increments');
        $data[$key]['default_inc'] = showPrice($default_inc);
        $data[$key]['register_bid'] = Property_registerBid($row['property_id']);
        if ($_SESSION['agent']['id'] > 0){
            $data[$key]['no_more_bids'] = PE_isNoMoreBids($row['property_id'],$_SESSION['agent']['id']);
        }
        //$smarty->assign('default_inc',showPrice($default_inc));
	}
}


if (isset($_SESSION['agent']) and $_SESSION['agent']['id'] > 0){
    $smarty->assign('agent_info',$_SESSION['agent']);
   
}

$smarty->assign('vm_tpl',$smarty->fetch(ROOTPATH.'/modules/property/templates/property.viewmore.popup2.tpl'));

$smarty->assign('data',$data);
$smarty->assign('agent_id', (int)@$_SESSION['agent']['id']);
$smarty->assign('isLogin',A_isLogin());
$smarty->assign('auto_property_id', (int)@$_SESSION['agent']['auto_property_id']);
$smarty->assign('no_more_bids_msg',$config_cls->getKey('no_more_bids_msg'));
