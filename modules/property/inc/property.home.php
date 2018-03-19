<?php
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once 'property.php';

include_once ROOTPATH.'/modules/general/inc/medias.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent.class.php';
include_once ROOTPATH.'/modules/general/inc/bids.php';

if (!isset($media_cls) or !($media_cls instanceof Medias)) {
	$media_cls = new Medias();
}

if (!isset($agent_cls) or !($agent_cls instanceof Agent)) {
	$agent_cls = new Agent();
}

//BEGIN FOR AUCTION-SALE
$auction_sale_ar = PEO_getAuctionSale();
//END


//BEGIN FOR FOCUS
$row = $property_cls->getRow('SELECT COUNT(*) num 
			FROM '.$property_cls->getTable().' AS pro
			WHERE  pro.active = 1 AND pro.focus = 1 AND pro.stop_bid = 0',true);
$len = 1;
if (isset($row['num']) and $row['num'] > 0) {
	//$start = rand($start,$row['num']-1);
	$len = $row['num'];
}
 
$wh_arr = Property_getCondition();
/*IBB-1022:Hide The Block properties from view in the Online Auctions section: NHUNG*/
        $show_theblock_focus = (int)$config_cls->getKey('theblock_show_focus');
        $wh_arr[] = $show_theblock_focus > 0?'1':' (SELECT agtype.title
                       FROM '.$agent_cls->getTable('agent_type')." AS agtype
                       WHERE agtype.agent_type_id = agt.type_id) != 'theblock'";

$wh_str = count($wh_arr) > 0 ? ' AND ' . implode(' AND ', $wh_arr) : '';

$rows = $property_cls->getRows("SELECT  pro.property_id, 
										pro.description,
										pro.address, 
										pro.price, 
										pro.suburb, 
										pro.state, 
										pro.postcode, 
										pro.auction_sale,
										pro.confirm_sold,
										pro.owner,
										
										(SELECT pro_term.value
										FROM ".$property_cls->getTable('property_term')." AS pro_term 
										LEFT JOIN ".$property_cls->getTable('auction_terms')." AS term
											ON pro_term.auction_term_id = term.auction_term_id
										WHERE term.code = 'auction_start_price' AND pro.property_id = pro_term.property_id
										) AS start_price,
										
										(SELECT reg1.name 
										FROM ".$region_cls->getTable().' AS reg1 
										WHERE reg1.region_id = pro.state
										) AS state_name,
										
										(SELECT reg2.name 
										FROM '.$region_cls->getTable().' AS reg2 
										WHERE reg2.region_id = pro.country
										) AS country_name,
										
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
							
										(SELECT pro_opt4.code
										FROM '.$property_entity_option_cls->getTable().' AS pro_opt4
										WHERE pro_opt4.property_entity_option_id = pro.auction_sale
										) AS auctionsale_code
											
									FROM '.$property_cls->getTable().' AS pro
									INNER JOIN '.$agent_cls->getTable().' AS agt
													ON pro.agent_id = agt.agent_id
									
									WHERE   pro.active = 1 
											AND pro.agent_active = 1 
											AND pro.focus = 1 
											AND pro.stop_bid = 0
											AND pro.confirm_sold = 0
											AND IF(pro.hide_for_live = 1 AND pro.start_time < "'.date('Y-m-d H:i:s').'", 0, 1) = 1
											AND pro.pay_status = '.Property::CAN_SHOW.
                                            $wh_str.'
									LIMIT 0,'.$len,true);//
		

$focus_property_id_ar = array();
$focus_data = array();	
$focus_first_href = '';
if (is_array($rows) and count($rows)>0) {
	foreach ($rows as $row) {
		$media_row = $property_media_cls->getRow('SELECT med.media_id, 
														 med.file_name
												  FROM '.$media_cls->getTable().' AS med,'.$property_media_cls->getTable()." AS pro_med
												  WHERE med.media_id = pro_med.media_id 
														AND med.type = 'photo' 
														AND pro_med.property_id = ".$row['property_id'].'
												  ORDER BY pro_med.default DESC',true);
								
		if ($property_media_cls->hasError()) {
		
		} elseif (is_array($media_row) and count($media_row) > 0) {
			$row['file_name'] = trim($media_row['file_name'],'/');
			
			$file_name = basename($row['file_name']);
			$ar = explode('/',$row['file_name']);
			unset($ar[count($ar) - 1]);
			$dir_rel = implode('/',$ar);
			$row['file_name'] = $dir_rel.'/crop_'.$file_name;
		}
		
		if (!is_file($row['file_name'])) {
			$row['file_name'] = 'modules/general/templates/images/hero-img.jpg';
		}
	
		$type = $row['auction_sale'] != $auction_sales['private_sale'] ? 'auction': 'sale';

		//$row['href'] = '/?module=property&action=view-'.$type.'-detail&id='.$row['property_id'];
		//$row['href'] = $row['detail_link'] = '/view-'.$type.'-detail-'.$row['property_id'].'.html';
		$row['href'] = shortUrl(array('module' => 'property', 'action' => 'view-'.$type.'-detail', 'id' => $row['property_id']) + array('data' => $row), (PE_isTheBlock($row['property_id'],'agent')?Agent_getAgent($row['property_id']):array()));
		
		if ($focus_first_href == '') {
			$focus_first_href = $row['href'];
		}
		$rowaddress = str_replace(' ', '-', $row['address']);
		$rowaddress = str_replace(',', '', $rowaddress);
		$rowaddress = (substr($rowaddress,-1) == '-') ? substr($rowaddress, 0, -1) : $rowaddress;
		$rowsuburb = str_replace(' ', '-', $row['suburb']);
		$row['detail_link'] = "/".$row['state_code']."/for-sale/$rowsuburb/$rowaddress/id-".$row['property_id'];

		$row['price'] = showPrice($row['start_price']);
		$row['address_full'] = $row['address'].', '.$row['suburb'].', '.$row['state_name'].', '.$row['postcode'];
		$row['description'] = safecontent_focus($row['description'], 160);
		$focus_property_id_ar[] = $row['property_id'];
        $row['isBlock'] = PE_isTheBlock($row['property_id']);
		$focus_data[] = $row; 
	}
    $_SESSION['focus'] = $focus_property_id_ar;
    //echo '<pre>'; print_r($_SESSION['focus']); echo'</pre>';
}

//print_r(date('Y-m-d H:i:s'));
$smarty->assign('focus_first_href',$focus_first_href);
$smarty->assign('focus_data',$focus_data);
$smarty->assign('auction_data',@$auction_data);
$smarty->assign('sale_data',@$sale_data);
$smarty->assign('feature_data',@$feature_data);
?>