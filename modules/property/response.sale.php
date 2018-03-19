<?php
require '../../configs/config.inc.php';
require ROOTPATH.'/includes/functions.php';
require ROOTPATH.'/includes/smarty/Smarty.class.php';
$smarty = new Smarty;  
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once 'inc/property.php';
include_once ROOTPATH.'/modules/general/inc/medias.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent.class.php';
include_once ROOTPATH.'/modules/general/inc/bids.php';

//BEGIN LAN
include_once ROOTPATH.'/modules/configuration/inc/config.class.php';

if (!isset($config_cls) || !($config_cls instanceof Config)) {
	$config_cls = new Config();
}

//END

if (!isset($media_cls) or !($media_cls instanceof Medias)) {
	$media_cls = new Medias();
}

if (!isset($agent_cls) or !($agent_cls instanceof Agent)) {
	$agent_cls = new Agent();
}
$i = 0;
$nRandom = rand(0,3);

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
	
}elseif ($nRandom == 3) {

	$order_by = 'DESC';
	//echo 'DDDDDDDDDD';
}

$auction_sale_ar = PEO_getAuctionSale();

$ex_where = '';
$numrow = 6;

//BEGIN FOR SALE
$rows = $property_cls->getRows('SELECT pro.property_id, pro.address, pro.price, pro.set_jump, pro.suburb, pro.state,
								pro.end_time, pro.postcode,pro.start_time, pro_rat_mrk.livability_rating_mark, pro_rat_mrk.green_rating_mark,
			(SELECT reg1.name FROM '.$region_cls->getTable().' AS reg1 WHERE reg1.region_id = pro.state) AS state_name,
			(SELECT reg2.name FROM '.$region_cls->getTable().' AS reg2 WHERE reg2.region_id = pro.country) AS country_name,
			(SELECT pro_opt1.value 
				FROM '.$property_entity_option_cls->getTable().' AS pro_opt1 
				WHERE pro_opt1.property_entity_option_id = pro.bathroom) AS bathroom_value,
			(SELECT pro_opt2.value 
				FROM '.$property_entity_option_cls->getTable().' AS pro_opt2 
				WHERE pro_opt2.property_entity_option_id = pro.bedroom) AS bedroom_value,
			(SELECT pro_opt3.value 
				FROM '.$property_entity_option_cls->getTable().' AS pro_opt3 
				WHERE pro_opt3.property_entity_option_id = pro.car_port) AS carport_value

		FROM '.$property_cls->getTable().' AS pro
		LEFT JOIN '.$property_rating_mark_cls->getTable().' AS pro_rat_mrk ON pro.property_id = pro_rat_mrk.property_id
		INNER JOIN '.$property_cls->getTable('agent')." AS agt ON pro.agent_id = agt.agent_id AND agt.type_id IN 
				(SELECT agt_typ.agent_type_id FROM ".$property_cls->getTable('agent_type').' AS agt_typ WHERE agt_typ.title != \'theblock\')
		
		WHERE pro.auction_sale = 10
				AND pro.active = 1
				AND pro.agent_active = 1 
				AND IF(pro.hide_for_live = 1 AND pro.start_time < now(),0,1) = 1

				AND pro.focus = 0 
				AND pro.feature = 0
				AND pro.set_jump = 1
		ORDER BY pro.property_id '.$order_by.'
		LIMIT 0,'.$numrow .'',true);//
		
$total = $property_cls->getFoundRows();

if ($total < 6) {

$rows = $property_cls->getRows('SELECT pro.property_id, pro.address, pro.price, pro.set_jump, pro.suburb, pro.state,
								date_format(pro.end_time, "%d %M %Y") as end_time , pro.postcode,pro.start_time, pro_rat_mrk.livability_rating_mark, pro_rat_mrk.green_rating_mark,
			(SELECT reg1.name FROM '.$region_cls->getTable().' AS reg1 WHERE reg1.region_id = pro.state) AS state_name,
			(SELECT reg2.name FROM '.$region_cls->getTable().' AS reg2 WHERE reg2.region_id = pro.country) AS country_name,
			(SELECT pro_opt1.value 
				FROM '.$property_entity_option_cls->getTable().' AS pro_opt1 
				WHERE pro_opt1.property_entity_option_id = pro.bathroom) AS bathroom_value,
			(SELECT pro_opt2.value 
				FROM '.$property_entity_option_cls->getTable().' AS pro_opt2 
				WHERE pro_opt2.property_entity_option_id = pro.bedroom) AS bedroom_value,
			(SELECT pro_opt3.value 
				FROM '.$property_entity_option_cls->getTable().' AS pro_opt3 
				WHERE pro_opt3.property_entity_option_id = pro.car_port) AS carport_value

		FROM '.$property_cls->getTable().' AS pro
		LEFT JOIN '.$property_rating_mark_cls->getTable().' AS pro_rat_mrk ON pro.property_id = pro_rat_mrk.property_id
		
		INNER JOIN '.$property_cls->getTable('agent')." AS agt ON pro.agent_id = agt.agent_id AND agt.type_id IN 
				(SELECT agt_typ.agent_type_id FROM ".$property_cls->getTable('agent_type').' AS agt_typ WHERE agt_typ.title != \'theblock\')
		
		WHERE pro.auction_sale = 10
				AND pro.active = 1 
				AND pro.agent_active = 1 
				AND pro.focus = 0 
				AND pro.feature = 0
				AND IF(pro.hide_for_live = 1 AND pro.start_time < now(),0,1) = 1
		ORDER BY pro.set_jump = 1 '.$order_by.'
		LIMIT 0,'.$numrow .'',true); //
		
	//print_r($total);
	if ($order_by == 'ASC') {
	
		$rows = $property_cls->getRows('SELECT pro.property_id, pro.address, pro.price, pro.set_jump, pro.suburb, pro.state,
								date_format(pro.end_time, "%d %M %Y") as end_time , pro.postcode,pro.start_time, pro_rat_mrk.livability_rating_mark, pro_rat_mrk.green_rating_mark,
			(SELECT reg1.name FROM '.$region_cls->getTable().' AS reg1 WHERE reg1.region_id = pro.state) AS state_name,
			(SELECT reg2.name FROM '.$region_cls->getTable().' AS reg2 WHERE reg2.region_id = pro.country) AS country_name,
			(SELECT pro_opt1.value 
				FROM '.$property_entity_option_cls->getTable().' AS pro_opt1 
				WHERE pro_opt1.property_entity_option_id = pro.bathroom) AS bathroom_value,
			(SELECT pro_opt2.value 
				FROM '.$property_entity_option_cls->getTable().' AS pro_opt2 
				WHERE pro_opt2.property_entity_option_id = pro.bedroom) AS bedroom_value,
			(SELECT pro_opt3.value 
				FROM '.$property_entity_option_cls->getTable().' AS pro_opt3 
				WHERE pro_opt3.property_entity_option_id = pro.car_port) AS carport_value

		FROM '.$property_cls->getTable().' AS pro
		LEFT JOIN '.$property_rating_mark_cls->getTable().' AS pro_rat_mrk ON pro.property_id = pro_rat_mrk.property_id
		
		INNER JOIN '.$property_cls->getTable('agent')." AS agt ON pro.agent_id = agt.agent_id AND agt.type_id IN 
				(SELECT agt_typ.agent_type_id FROM ".$property_cls->getTable('agent_type').' AS agt_typ WHERE agt_typ.title != \'theblock\')
		
		WHERE pro.auction_sale = 10 
				AND pro.active = 1
				AND pro.agent_active = 1  
				AND pro.focus = 0 
				AND pro.feature = 0
				AND IF(pro.hide_for_live = 1 AND pro.start_time < now(),0,1) = 1
		ORDER BY pro.set_jump = 0 '.$order_by.'
		LIMIT 0,'.$numrow .'',true); //
	}			

} if($total == 0 ) {
	//echo 'Test Again';
	$rows = $property_cls->getRows('SELECT pro.property_id, pro.address, pro.price, pro.set_jump, pro.suburb, pro.state,
								date_format(pro.end_time, "%d %M %Y") as end_time , pro.postcode,pro.start_time, pro_rat_mrk.livability_rating_mark, pro_rat_mrk.green_rating_mark,
			(SELECT reg1.name FROM '.$region_cls->getTable().' AS reg1 WHERE reg1.region_id = pro.state) AS state_name,
			(SELECT reg2.name FROM '.$region_cls->getTable().' AS reg2 WHERE reg2.region_id = pro.country) AS country_name,
			(SELECT pro_opt1.value 
				FROM '.$property_entity_option_cls->getTable().' AS pro_opt1 
				WHERE pro_opt1.property_entity_option_id = pro.bathroom) AS bathroom_value,
			(SELECT pro_opt2.value 
				FROM '.$property_entity_option_cls->getTable().' AS pro_opt2 
				WHERE pro_opt2.property_entity_option_id = pro.bedroom) AS bedroom_value,
			(SELECT pro_opt3.value 
				FROM '.$property_entity_option_cls->getTable().' AS pro_opt3 
				WHERE pro_opt3.property_entity_option_id = pro.car_port) AS carport_value

		FROM '.$property_cls->getTable().' AS pro
		LEFT JOIN '.$property_rating_mark_cls->getTable().' AS pro_rat_mrk ON pro.property_id = pro_rat_mrk.property_id
		
		INNER JOIN '.$property_cls->getTable('agent')." AS agt ON pro.agent_id = agt.agent_id AND agt.type_id IN 
				(SELECT agt_typ.agent_type_id FROM ".$property_cls->getTable('agent_type').' AS agt_typ WHERE agt_typ.title != \'theblock\')
		
		WHERE pro.auction_sale = 10
				AND pro.active = 1
				AND pro.agent_active = 1  
				AND IF(pro.hide_for_live = 1 AND pro.start_time < now(),0,1) = 1

				AND pro.focus = 0 
				AND pro.feature = 0
		ORDER BY pro.property_id '.$order_by.'
		LIMIT 0,'.$numrow .'',true);//
}

$_SESSION['wh_str'] = ' pro.confirm_sold=0
				        AND pro.auction_sale = '.$auction_sale_ar['private_sale'].'
				        AND IF (pro.confirm_sold = 1  AND datediff(\''.date('Y-m-d H:i:s').'\', pro.sold_time) >14 ,0,1) = 1';
$sale_data = array();	
$str='';							
if (is_array($rows) and count($rows)>0) {

	foreach ($rows as $row) {
		
		if ($row['end_time'] == '0000-00-00 00:00:00') {
					$row['end_time'] = '--:--:--';
				} else {
					$dt = new DateTime($row['end_time']);
					$row['end_time'] = $dt->format($config_cls->getKey('general_date_format'));
				} 
				
		$row['livability_rating_mark'] = showStar($row['livability_rating_mark']);
		$row['green_rating_mark']      =  showStar($row['green_rating_mark']);
		
		//BEGIN MEDIA
		$_media = PM_getPhoto($row['property_id'],true);
		$row['file_name'] = $_media['photo_thumb_default'];		
		//END
		
		$row['address_full'] = $row['address'].', '.$row['suburb'].', '.$row['state_name'].', '.$row['postcode'];
		$row['address_short'] = strlen($row['address_full'])>30 ? substr($row['address_full'],0,27).' ...' : $row['address_full'];
	
		$row['o4i'] = Calendar_createPopup($row['property_id'],$row['open_for_inspection']);
		
		//BEGIN LAN
		if ($row['start_time'] == '0000-00-00 00:00:00') {
			$row['start_time'] =  '--:--:--';
		} else {
			$dt = new DateTime($row['start_time']);
			$row['start_time'] = $dt->format($config_cls->getKey('general_date_format'));
		}
			//$row['price'] = intval($row['price']);
			
		$row['price'] = showPrice($row['price']);
		//END 
		
		//Begin Thuy
		$r1 = '/modules/property/action.php?action=add-watchlist&property_id='.$row['property_id'];
	
		$r2 = '/?module=property&action=view-sale-detail&id='.$row['property_id'].'';
		$r3 = '/?module=property&action=view-sale-detail&id='.$row['property_id'].'';
		//End Thuy
		
		$str .= '
		    <div class="topselling-list auctions-box-g" >
		            <script>var pro = new Property();</script>
					<ul>
						<li class="first" >
							<div class="topselling-item {$cls}">
								<div class="topsell-img">
									<span class="f-left" style="margin-left:10px; color:#2f2f2f">FOR SALE: '.$row['suburb'].' </span>
									<div class="clearthis"></div>
									 <div style="float:left">
										 <div class="detail-icons detail-icons-a">
											<span style="float:left; margin-left:10px;"> ID : '.$row['property_id'].' </span>     
										 </div>
										 <div class="detail-icons detail-icons-b">
												<span class="bed icons"> '.$row['bedroom_value'].' </span>
												<span class="bath icons">'.$row['bathroom_value'].' </span>
												<span class="car icons"> '.$row['carport_value'].' </span>
									    </div>
																				  
									 </div>      
									 <a href="'.$r2.'"><img src="'.$row['file_name'].'" alt="Photo" style="width:180px;height:115px"/> </a>
									
								</div>
								
								<div class="topsell-info" id="auc-'.$row['property_id'].'" >
										<p class="name" style="min-height:26px; padding:0 10px" title="'.$row['address_full'].'">
										
											'.$row['address_short'].' 
										</p>
										<div align="center" >
											<span style="font-size:14px;  margin-left:55px; margin-right:45px; color:#2f2f2f !important ">'.$row['price'].'</span>
										</div>
										 <!--<p class="time" style="color:#2f2f2f; font-size:16px; font-weight:bold; text-align:center;">
												-d:-:-:-
										 </p>-->

								</div>	    
									
								<div class="tbl-info tbl-info-home-for-sale" style="position: absolute;bottom:60px;left:4px;">
									<ul>
										<li class="livability" style="margin-top:0px; margin-bottom:3px;">
											 <span style="font-family:Arial,Helvetica,sans-serif; color:#666666; float:left; margin-right: 27px;margin-left:6px; margin-top:1px;"> Livability Rating </span>
											  <span style=""> '.$row['livability_rating_mark'].' </span>
										</li>
									 </ul>
											
									 <ul>
										 <li style="margin: 0px 0px 0px 1px;">
											  <span style="font-family:Arial,Helvetica,sans-serif; color:#666666; float:left; margin-right: 5px;margin-left:5px; margin-top:1px;">iBB Sustainability</span>
											   <span style="">'.$row['green_rating_mark'].' </span>
										 </li>
									  </ul>
									  <span class="pfi-home"> Open for Inspection: '.$row['o4i'].' </span>
								</div>
								
								   <div class="f-right btn-view-wht-sale-home" style="position: absolute;bottom:11px;left:11px;width:182px;">

									   <button class="btn-wht btn-wht-home btn-lan-home" style="float:left !important;margin-right:0px;"
									   	 		onclick="pro.addWatchlist(\''.$r1.'\')">
											<span style="font-size:12px;"><span style="font-size:12px;">Add to Watchlist</span></span>
										</button>
										<button style="float:right;margin-right:0px;" class="btn-view btn-view-home" 
												onclick="document.location = \''.$r3.'\' ">
										</button>
										
									</div>
									<div class="auc-bid">
					
								</div>
							</div>
						</li>
					</ul>
				</div>';
		
		$sale_data[] = $row; 
	}
	
die($str);
}