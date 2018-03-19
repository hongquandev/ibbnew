<?php

require '../../configs/config.inc.php';
require ROOTPATH . '/includes/functions.php';
require ROOTPATH . '/includes/smarty/Smarty.class.php';
$smarty = new Smarty;
include_once ROOTPATH . '/modules/general/inc/regions.php';
include_once 'inc/property.php';
include_once ROOTPATH . '/modules/general/inc/medias.class.php';
include_once ROOTPATH . '/modules/agent/inc/agent.class.php';
include_once ROOTPATH . '/modules/general/inc/bids.php';


//BEGIN SMARTY
include_once ROOTPATH . '/includes/smarty/Smarty.class.php';
$smarty = new Smarty;
if (detectBrowserMobile()) {
    $smarty->compile_dir = ROOTPATH . '/m.templates_c/';
} else {
    $smarty->compile_dir = ROOTPATH . '/templates_c/';
}
//END
//BEGIN LAN
include_once ROOTPATH . '/modules/configuration/inc/config.class.php';

if (!isset($config_cls) || !($config_cls instanceof Config)) {
    $config_cls = new Config();
}

//END
//set timezone default (test time)
//date_default_timezone_set('Australia/Melbourne');

if (!isset($media_cls) or !($media_cls instanceof Medias)) {
    $media_cls = new Medias();
}

if (!isset($agent_cls) or !($agent_cls instanceof Agent)) {
    $agent_cls = new Agent();
}
$i = 0;
$nRandom = rand(0, 3);
$auction_sale_ar = PEO_getAuctionSale();
//echo $nRandom;
if ($nRandom == 0) {
    //echo 'AAAAAAAA';
    $order_by = 'DESC';
} elseif ($nRandom == 1) {
    //echo 'BBBBBBBB';
    $order_by = 'ASC';
} elseif ($nRandom == 2) {

    $order_by = 'ASC';
    //echo 'CCCCCCC';
} elseif ($nRandom == 3) {

    $order_by = 'DESC';
    //echo 'DDDDDDDDDD';
}

$auction_sale_ar = PEO_getAuctionSale();

$ex_where = '';
$numrow = 6;
//print_r(date('Y-m-d h:m:s'));
//BEGIN FOR FORTHCOMING
$rows = $property_cls->getRows("SELECT pro.property_id, pro.active, pro.agent_active, pro.address, pro.price, pro.set_jump, pro.suburb, pro.state,
								pro.end_time, pro.postcode,pro.start_time,pro.stop_bid, pro_rat_mrk.livability_rating_mark, pro_rat_mrk.green_rating_mark,pro.open_for_inspection,
			(SELECT pro_term.value
					     FROM " . $property_cls->getTable('property_term') . " AS pro_term LEFT JOIN " . $property_cls->getTable('auction_terms') . " AS term
                         ON pro_term.auction_term_id = term.auction_term_id
                         WHERE term.code = 'auction_start_price' AND pro.property_id = pro_term.property_id) AS start_price,
			(SELECT reg1.name FROM " . $region_cls->getTable() . ' AS reg1 WHERE reg1.region_id = pro.state) AS state_name,
			(SELECT reg2.name FROM ' . $region_cls->getTable() . ' AS reg2 WHERE reg2.region_id = pro.country) AS country_name,
			(SELECT pro_opt1.value 
				FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt1 
				WHERE pro_opt1.property_entity_option_id = pro.bathroom) AS bathroom_value,
			(SELECT pro_opt2.value 
				FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt2 
				WHERE pro_opt2.property_entity_option_id = pro.bedroom) AS bedroom_value,
			(SELECT pro_opt3.value 
				FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt3 
				WHERE pro_opt3.property_entity_option_id = pro.car_port) AS carport_value

		FROM ' . $property_cls->getTable() . ' AS pro
		LEFT JOIN ' . $property_rating_mark_cls->getTable() . " AS pro_rat_mrk ON pro.property_id = pro_rat_mrk.property_id
		INNER JOIN " . $property_cls->getTable('agent') . " AS agt ON pro.agent_id = agt.agent_id AND agt.type_id IN 
				(SELECT agt_typ.agent_type_id FROM " . $property_cls->getTable('agent_type') . " AS agt_typ WHERE agt_typ.title != 'theblock')
		
		WHERE pro.auction_sale = 9
				AND pro.start_time > '" . date('Y-m-d H:m:d') . "'
				AND pro.stop_bid = 0
				AND pro.active = 1
				AND pro.confirm_sold = 0
				AND pro.agent_active = 1
				AND IF(pro.hide_for_live = 1 AND pro.start_time > '" . date('Y-m-d H:i:s') . "',0,1) = 1
				AND pro.pay_status = " . Property::CAN_SHOW . "

		ORDER BY pro.property_id " . $order_by . '
		LIMIT 0,' . $numrow, true); //
//AND pro.set_jump = 1
$total = $property_cls->getFoundRows();



if ($total < 6) {


    $rows = $property_cls->getRows("SELECT pro.property_id, pro.address,pro.stop_bid,  pro.price, pro.set_jump, pro.suburb, pro.state,pro.open_for_inspection,
								date_format(pro.end_time, '%d %M %Y') as end_time , pro.postcode,pro.start_time, pro_rat_mrk.livability_rating_mark, pro_rat_mrk.green_rating_mark, pro.active, pro.agent_active,
			(SELECT pro_term.value
					     FROM " . $property_cls->getTable('property_term') . " AS pro_term LEFT JOIN " . $property_cls->getTable('auction_terms') . " AS term
                         ON pro_term.auction_term_id = term.auction_term_id
                         WHERE term.code = 'auction_start_price' AND pro.property_id = pro_term.property_id) AS start_price,
			(SELECT reg1.name FROM " . $region_cls->getTable() . ' AS reg1 WHERE reg1.region_id = pro.state) AS state_name,
			(SELECT reg2.name FROM ' . $region_cls->getTable() . ' AS reg2 WHERE reg2.region_id = pro.country) AS country_name,
			(SELECT pro_opt1.value 
				FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt1 
				WHERE pro_opt1.property_entity_option_id = pro.bathroom) AS bathroom_value,
			(SELECT pro_opt2.value 
				FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt2 
				WHERE pro_opt2.property_entity_option_id = pro.bedroom) AS bedroom_value,
			(SELECT pro_opt3.value 
				FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt3 
				WHERE pro_opt3.property_entity_option_id = pro.car_port) AS carport_value

		FROM ' . $property_cls->getTable() . ' AS pro
		LEFT JOIN ' . $property_rating_mark_cls->getTable() . " AS pro_rat_mrk ON pro.property_id = pro_rat_mrk.property_id
		INNER JOIN " . $property_cls->getTable('agent') . " AS agt ON pro.agent_id = agt.agent_id AND agt.type_id IN 
				(SELECT agt_typ.agent_type_id FROM " . $property_cls->getTable('agent_type') . " AS agt_typ WHERE agt_typ.title != 'theblock')
		
		WHERE pro.auction_sale = 9
				AND pro.active = 1
				AND pro.agent_active = 1
				AND pro.start_time > '" . date('Y-m-d H:m:d') . "'
				AND pro.stop_bid = 0
				AND pro.confirm_sold = 0
				AND IF(pro.hide_for_live = 1 AND pro.start_time > '" . date('Y-m-d H:i:s') . "',0,1) = 1
				AND pro.pay_status = " . Property::CAN_SHOW . "
				
		ORDER BY pro.set_jump " . $order_by . "
		LIMIT 0," . $numrow . '', true); //
//
//	AND pro.set_jump = 1
//	OR pro.set_jump = 0
//	AND pro.auction_sale = 9
//				And date(start_time) > Now()
//				AND pro.active = 1
//				AND pro.agent_active = 1
//				AND pro.focus = 0
//				AND pro.feature = 0
//				AND pro.start_time > '" .date('Y-m-d H:m:d'). "'
    //print_r($total);
    if ($order_by == 'ASC') {

        $rows = $property_cls->getRows("SELECT pro.property_id, pro.address,pro.stop_bid, pro.price, pro.set_jump, pro.suburb, pro.state,pro.open_for_inspection,
								date_format(pro.end_time, '%d %M %Y') as end_time , pro.postcode,pro.start_time, pro_rat_mrk.livability_rating_mark, pro_rat_mrk.green_rating_mark, pro.active, pro.agent_active,
			(SELECT pro_term.value
					     FROM " . $property_cls->getTable('property_term') . " AS pro_term LEFT JOIN " . $property_cls->getTable('auction_terms') . " AS term
                         ON pro_term.auction_term_id = term.auction_term_id
                         WHERE term.code = 'auction_start_price' AND pro.property_id = pro_term.property_id) AS start_price,
			(SELECT reg1.name FROM " . $region_cls->getTable() . ' AS reg1 WHERE reg1.region_id = pro.state) AS state_name,
			(SELECT reg2.name FROM ' . $region_cls->getTable() . ' AS reg2 WHERE reg2.region_id = pro.country) AS country_name,
			(SELECT pro_opt1.value 
				FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt1 
				WHERE pro_opt1.property_entity_option_id = pro.bathroom) AS bathroom_value,
			(SELECT pro_opt2.value 
				FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt2 
				WHERE pro_opt2.property_entity_option_id = pro.bedroom) AS bedroom_value,
			(SELECT pro_opt3.value 
				FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt3 
				WHERE pro_opt3.property_entity_option_id = pro.car_port) AS carport_value

		FROM ' . $property_cls->getTable() . ' AS pro
		LEFT JOIN ' . $property_rating_mark_cls->getTable() . " AS pro_rat_mrk ON pro.property_id = pro_rat_mrk.property_id
		INNER JOIN " . $property_cls->getTable('agent') . " AS agt ON pro.agent_id = agt.agent_id AND agt.type_id IN 
				(SELECT agt_typ.agent_type_id FROM " . $property_cls->getTable('agent_type') . " AS agt_typ WHERE agt_typ.title != 'theblock')
		
		WHERE pro.auction_sale = 9 
				AND pro.active = 1
				AND pro.agent_active = 1
				AND pro.start_time > '" . date('Y-m-d H:m:d') . "'
				AND pro.stop_bid = 0
				AND pro.confirm_sold = 0
				AND IF(pro.hide_for_live = 1 AND pro.start_time > '" . date('Y-m-d H:i:s') . "',0,1) = 1
				AND pro.pay_status = " . Property::CAN_SHOW . "

        ORDER BY pro.set_jump " . $order_by . "
		LIMIT 0," . $numrow, true); //
    }
//
//AND pro.set_jump = 1
//				OR pro.set_jump = 0
//				AND pro.auction_sale = 9
//				And date(pro.start_time) > Now()
//				AND pro.active = 1
//				AND pro.agent_active = 1
//				AND pro.focus = 0
//				AND pro.feature = 0
} if ($total == 0) {

    //echo 'Test Again';
    $rows = $property_cls->getRows("SELECT pro.property_id, pro.address, pro.price,pro.stop_bid, pro.set_jump, pro.suburb, pro.state,pro.open_for_inspection,
								date_format(pro.end_time, '%d %M %Y') as end_time , pro.postcode,pro.start_time, pro_rat_mrk.livability_rating_mark, pro_rat_mrk.green_rating_mark, pro.active, pro.agent_active,
			(SELECT pro_term.value
					     FROM " . $property_cls->getTable('property_term') . " AS pro_term LEFT JOIN " . $property_cls->getTable('auction_terms') . " AS term
                         ON pro_term.auction_term_id = term.auction_term_id
                         WHERE term.code = 'auction_start_price' AND pro.property_id = pro_term.property_id) AS start_price,
			(SELECT reg1.name FROM " . $region_cls->getTable() . ' AS reg1 WHERE reg1.region_id = pro.state) AS state_name,
			(SELECT reg2.name FROM ' . $region_cls->getTable() . ' AS reg2 WHERE reg2.region_id = pro.country) AS country_name,
			(SELECT pro_opt1.value 
				FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt1 
				WHERE pro_opt1.property_entity_option_id = pro.bathroom) AS bathroom_value,
			(SELECT pro_opt2.value 
				FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt2 
				WHERE pro_opt2.property_entity_option_id = pro.bedroom) AS bedroom_value,
			(SELECT pro_opt3.value 
				FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt3 
				WHERE pro_opt3.property_entity_option_id = pro.car_port) AS carport_value

		FROM ' . $property_cls->getTable() . ' AS pro
		LEFT JOIN ' . $property_rating_mark_cls->getTable() . ' AS pro_rat_mrk ON pro.property_id = pro_rat_mrk.property_id
		INNER JOIN ' . $property_cls->getTable('agent') . ' AS agt ON pro.agent_id = agt.agent_id AND agt.type_id IN 
				(SELECT agt_typ.agent_type_id FROM ' . $property_cls->getTable('agent_type') . ' AS agt_typ WHERE agt_typ.title != \'theblock\')
		
		WHERE pro.auction_sale = 9
				AND pro.start_time > "' . date('Y-m-d H:m:d') . '"
				AND pro.stop_bid = 0
				AND pro.active = 1
				AND pro.agent_active = 1
				AND pro.confirm_sold = 0
				AND IF(pro.hide_for_live = 1 AND pro.start_time > \'' . date('Y-m-d H:i:s') . '\',0,1) = 1
				AND pro.pay_status = ' . Property::CAN_SHOW . '

		ORDER BY pro.property_id ' . $order_by . '
		LIMIT 0,' . $numrow, true); //
    //echo $property_cls->sql;
}

$_SESSION['wh_str'] = ' pro.confirm_sold=0
                            AND pro.stop_bid = 0
                            AND pro.start_time > \'' . date('Y-m-d H:i:s') . '\'
                            AND pro.pay_status = ' . Property::CAN_SHOW . '
				            AND pro.auction_sale = ' . $auction_sale_ar['auction'];
//	AND pro.focus = 0
//				AND pro.feature = 0
//				AND pro.set_jump = 1
//				OR pro.set_jump = 0
//				AND pro.auction_sale = 9
//				AND pro.active = 1
//				AND pro.agent_active = 1
//				AND pro.focus = 0
//				AND pro.feature = 0
//				AND pro.start_time > "' .date('Y-m-d H:m:d'). '"
$sale_data = array();
$str = '';



//print_r($property_cls->sql);
//print_r(date('Y-m-d h:m:d'));
if (is_array($rows) and count($rows) > 0) {

    foreach ($rows as $row) {

        if ($row['end_time'] == '0000-00-00 00:00:00') {
            $row['end_time'] = '--:--:--';
        } else {
            $dt = new DateTime($row['end_time']);
            $row['end_time'] = $dt->format($config_cls->getKey('general_date_format'));
        }

        $row['livability_rating_mark'] = showStar($row['livability_rating_mark']);
        $row['green_rating_mark'] = showStar($row['green_rating_mark']);

        //BEGIN MEDIA
        $_media = PM_getPhoto($row['property_id'], true);
        $row['file_name'] = $_media['photo_thumb_default'];
        //END
        $l = intval($row['start_price']);
        $reserve_price = PT_getValueByCode($row['property_id'], 'reserve');
        $l = intval($reserve_price);
        $row['price'] = '<div style="float:left;margin-left:5px;font-size:12px;">From<span>: ' . showLowPrice($l) . '</span></div><div style="float:left;clear:both;margin-left:5px;font-size:12px;*margin-left: 5px;*float: none;*text-align: left;">To<span style="margin-left:0px;">: ' . showHighPrice($l) . '</span></div>';

        $row['address_full'] = $row['address'] . ', ' . $row['suburb'] . ', ' . $row['state_name'] . ', ' . $row['postcode'];
        $row['address_short'] = strlen($row['address_full']) > 30 ? substr($row['address_full'], 0, 27) . ' ...' : $row['address_full'];
        //BEGIN LAN
        if ($row['start_time'] == '0000-00-00 00:00:00') {
            $row['start_time'] = '--:--:--';
        } else {
            $dt = new DateTime($row['start_time']);
            $row['start_time'] = $dt->format($config_cls->getKey('general_date_format'));
        }
        //END
        //Begin Thuy
        $r1 = '/modules/property/action.php?action=add-watchlist&property_id=' . $row['property_id'] . '';
        $r2 = '/?module=property&action=view-forthcoming-detail&id=' . $row['property_id'] . '';
        $r3 = '/?module=property&action=view-forthcoming-detail&id=' . $row['property_id'] . '';
        //End Thuy

        $row['o4i'] = Calendar_createPopup($row['property_id'], $row['open_for_inspection']);

        $str .= '<div class="property-list property-list-ie auctions-box-g" style="display:inline-block;">
					<ul>
						<li class="first " style="float:left;">
							<div class="property-item {$cls}" >
								<div class="pro-img">
									<span class="f-left" style="margin-left:10px; color:#2f2f2f">AUCTION ENDS: ' . $row['end_time'] . ' </span>
									<div style="float:left;">
										<div class="detail-icons detail-icons-a">
											<span style="float:left; margin-left:10px;"> ID : ' . $row['property_id'] . ' </span>
											</div>
											<div class="detail-icons detail-icons-b">
											<span class="icons bed"> ' . $row['bedroom_value'] . '  </span>
											<span class="icons bath"> ' . $row['bathroom_value'] . ' </span>
											<span class="icons car"> ' . $row['carport_value'] . ' </span>
										</div>
									</div>
									
									<a href="/?module=property&action=view-forthcoming-detail&id=' . $row['property_id'] . '"><img src="' . $row['file_name'] . '" alt="Photo" style="width:180px;height:115px"/></a>
								</div>
								<div class="pro-info">
									<p style="padding: 0px 10px 0px 10px;" class="name" title=" ' . $row['address_full'] . ' ">
										' . $row['address_short'] . '
									</p>
									<!--<div style="font-size: 16px; font-weight: bold; color: #2f2f2f; text-align: center;">
										' . $row['end_time'] . '
									</div>-->
									<span class="f-left" style="margin-top: 13px;margin-left:10px;margin-bottom:5px; color:#2f2f2f">AUCTION STARTS : ' . $row['start_time'] . ' </span>
									<div align="center" style="margin-bottom:20px;" >
											<div style="font-size:14px;  margin-left:5px;color:#2f2f2f !important ">' . $row['price'] . '</div>
									</div>
									
									<div class="tbl-info" id="tbl-info-ie9" style="position: absolute;bottom:42px;left:4px;">
										<ul style="height:18px;">
											<li>
												<span style="font-family:Arial,Helvetica,sans-serif; color:#666666; float:left; margin-left:5px; margin-right: 26px; margin-top:1px;"> Livability Rating </span>
												<span style="">' . $row['livability_rating_mark'] . '</span>
											</li>
										</ul>
												
										<ul style="height:18px;">
											<li>
												<span style="font-family:Arial,Helvetica,sans-serif; color:#666666; float:left; margin-left:5px; margin-right: 4px; margin-top:1px;">iBB Sustainability </span>
												<span style="">' . $row['green_rating_mark'] . '</span>
											</li>
										</ul>
										<span style="float:right;color: rgb(152, 0, 0);margin-right: 15px;margin-top: 14px;"> Open for Inspection: ' . $row['o4i'] . '</span>
									</div>
									
									<!--<p class="price-viewmore">
										<span class="price f-left">' . $row['price'] . ' </span>
										<span class="viewmore icons f-right"><a href="?module=property&action=view-auction-detail&id=' . $row['property_id'] . '">View more</a></span>
										<span class="clearthis"></span>
									</p>-->
									
									
								</div>
								<div class="btn-view-wht btn-view-wht-forthcoming" style="position: absolute;bottom:11px;*bottom:10px;left:11px;width: 182px;">
										
									
									<button class="btn-wht btn-wht-home-forthcoming btn-lan-home" style="float:left;" onclick="pro.addWatchlist(\'' . $r1 . '\');">
										<span style="font-size:12px;"><span style="font-size:12px;">Add to Watchlist</span></span>
									</button>
										
									  
									<button style="float:right;margin-top:2px;" class="btn-view btn-view-home-forthcoming" onClick="document.location = \'' . $r2 . '\'">
									</button>
										
									<div class="clearthis"> </div>
								</div>
							</div>
						</li>
					</ul>
				</div>';

        $sale_data[] = $row;
    }
    die($str);
}
		