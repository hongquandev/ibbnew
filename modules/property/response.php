<?php
/* 
	Author : Stevenduc
	Company : Global Outsource Solutions
	Skype : stevenduc21
*/
require '../../configs/config.inc.php';
require ROOTPATH.'/includes/functions.php';
require ROOTPATH.'/includes/smarty/Smarty.class.php';
$smarty = new Smarty;  
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once 'inc/property.php';
include_once ROOTPATH.'/modules/general/inc/medias.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent.class.php';
include_once ROOTPATH.'/modules/general/inc/bids.php';

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
function get_ebay_UTC_8601(DateTime $time) {

      $t = clone $time;
      $t->setTimezone(new DateTimeZone("UTC"));
      return $t->format("Y-m-d\TH:i:s\Z");
} 	

$auction_sale_ar = PEO_getAuctionSale();

$ex_where = '';

$ref = isset($_POST['ref']);

$total = $property_cls->getFoundRows();

	

//$order_by = $_REQUEST['ref'] == '' ? 'DESC' : 'ASC';	
$numrow = 6;
//if (isset($ref)) {
//	
//	if (rand() > 10000) {
//		$order_by = 'ASC';
//	} else {
//		$order_by = 'DESC';
//	}
//}

$rows = $property_cls->getRows('SELECT SQL_CALC_FOUND_ROWS pro.property_id, pro.address, pro.price, pro.suburb, pro.state, 
										pro.postcode, pro.end_time, pro_rat_mrk.livability_rating_mark, pro_rat_mrk.green_rating_mark,
										 pro.last_bid_time,pro.description, pro.open_for_inspection, pro.agent_active,
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
		
		WHERE pro.auction_sale = '.$auction_sale_ar['auction'].' 
				AND pro.active = 1
				AND pro.agent_active = 1 
				AND pro.focus = 0 
				AND pro.feature = 0 
				AND pro.stop_bid = 0 
				AND IF(pro.hide_for_live = 1 AND pro.start_time > \''.date('Y-m-d H:i:s').'\',0,1) = 1
				AND pro.pay_status = '.Property::CAN_SHOW.'
				'.$ex_where.'
		
		ORDER BY pro.property_id '.$order_by.'
		LIMIT 0,'.$numrow.'',true);//


$auction_data = array();	
$str = '';
$strtime = '';

foreach ($rows as $row) {
	
		$row['livability_rating_mark'] = showStar($row['livability_rating_mark']);
		$row['green_rating_mark']      =  showStar($row['green_rating_mark']);
				
		//BEGIN MEDIA
		$media_row = $property_media_cls->getRow('SELECT med.media_id, med.file_name
								FROM '.$media_cls->getTable().' AS med,'.$property_media_cls->getTable()." AS pro_med
								WHERE med.media_id = pro_med.media_id AND med.type = 'photo' AND pro_med.property_id = ".$row['property_id'],true);
		//print_r($media_row);						
		if ($property_media_cls->hasError()) {
		
		} elseif (is_array($media_row) and count($media_row)>0) {
			$row['file_name'] = $media_row['file_name'];
		}

		if (!is_file(ROOTPATH.'/'.trim($row['file_name'],'/'))) {
			$row['file_name'] = 'modules/property/templates/images/auction-img.jpg';
		}
		//END
		
		//BEGIN AGENT
		$row['bidder'] = '--';
		
		$agent_row = $agent_cls->getRow('SELECT agt.firstname, agt.lastname, bid.price
							FROM '.$agent_cls->getTable().' AS agt,'.$bid_cls->getTable().' AS bid
							WHERE agt.agent_id = bid.agent_id AND bid.property_id = '.$row['property_id'].'
							ORDER BY bid.price DESC 
							LIMIT 1',true);
							
		if ($agent_cls->hasError()) {
			
		} else if (is_array($agent_row) and count($agent_row)>0) {
			$row['bidder'] = $agent_row['firstname'].' '.$agent_row['lastname'];
			if ($agent_row['price'] > 0.0) {
				$row['price'] = $agent_row['price'];
			}
		}
		
		//END
		
		//FORMAT PRICE
		$row['price'] = showPrice($row['price']);
	
		//CALC REMAIN TIME
		$row['remain_time'] = remainTime($row['end_time']);
		/*
		if ($row['remain_time'] < 0) {
			$row['remain_time'] = $row['repeat_time'] > 0 ? $row['repeat_time'] : REPEAT_TIME;
		}
		*/
		//RE-EDIT ADDRESS
		$row['address_full'] = $row['address'].', '.$row['suburb'].', '.$row['state_name'].', '.$row['postcode'];
		$row['address_short'] = strlen($row['address_full'])>30 ? substr($row['address_full'],0,27).' ...' : $row['address_full'];
		
		$r1 = '/?module=property&action=view-auction-detail&id='.$row['property_id'];
		$r2 = '/modules/property/action.php?action=add-watchlist&property_id='.$row['property_id'];
		$r3 = '/?module=property&action=view-auction-detail&id='.$row['property_id'];
		
		$b1 = 'auc-'.$row['property_id'];
		$b2 = $row['remain_time'];
			$str .= '
					<div class="auctions-list show" style="display:inline-block;">
						<ul>							
							<li class="first" >
					
								<div class="auction-item hide" style="display:inline-block;" >
								
									<div class="auc-img">
									 <span class="f-left" style="margin-left:10px; color:#2f2f2f">AUCTION '.$row['end_time'].' </span>
										  
										
											<div style="float:left">
												<p class="detail-icons" style="margin-top:5px; margin-bottom:5px; margin-left:7px;">
													<span  style="float:left; margin-left:-1px; margin-right:40px; "> ID : '.$row['property_id'].' </span>  
													
													<span class="bed icons">'.$row['bedroom_value'].'</span>
													<span class="bath icons">'.$row['bathroom_value'].'</span>
													<span class="car icons">'.$row['carport_value'].'</span>
												</p>
											</div>    
										<a href="/?module=property&action=view-auction-detail&id='.$row['property_id'].'"><img src="'.$row['file_name'].'" alt="Photo" style="width:180px;height:115px" onclick="bid_{'.$row['property_id'].'}.click()" /></a>
										
									</div>
									
									<div class="auc-info" id="auc-'.$row['property_id'].'">
										<p class="name" style="min-height:25px; padding:0 5px" title="'.$row['address_full'].'">
											'.$row['address_short'].'
										</p>
										
										 <script>ids.push('.$row['property_id'].');</script>
										 
                                   <div id="auc-'.$row['property_id'].'" >
                                        <p id="auc-time-'.$row['property_id'].'" style="color: #2f2f2f;font-size: 16px; font-weight: bold; text-align: center;">
                                            -d:-:-:-
                                        </p>
                                         <script>
											if ('.$row['remain_time'].' > 0)
											{
												ids.push('.$row['property_id'].');	
											}
											
											var time_'.$row['property_id'].' = '.$row['remain_time'].';
											var bid_'.$row['property_id'].' = new Bid();
											bid_'.$row['property_id'].'.setContainerObj("auc-"+'.$row['property_id'].');
											bid_'.$row['property_id'].'.setTimeObj("auc-time-"+'.$row['property_id'].');
											bid_'.$row['property_id'].'.setBidderObj();
											bid_'.$row['property_id'].'.setPriceObj();
											bid_'.$row['property_id'].'.setTimeValue('.$row['remain_time'].');
											bid_'.$row['property_id'].'.startTimer('.$row['property_id'].');
										stopTimerGlobal();
										</script>
				 
						
						
								   
                                    </div>
									
										<div align="center" style="margin-bottom:5px;" >
											<span style="font-size:14px;  margin-left:55px; margin-right:45px; color:#2f2f2f !important ">'.$row['price'].'</span>
										  </div>
										  
										  <div class="tbl-info" style="margin-top:-15px; position:relative;">
												<ul style="height:20px;">
													<li>
														<span style="font-family:Arial,Helvetica,sans-serif; color:#666666; float:left; margin-left:5px; margin-top:1px;"> Livability Rating </span>
														 <span style="float:right; margin-left:25px;">'.$row['livability_rating_mark'].'</span>
													</li>
												</ul>
												
												<ul>
													<li>
														<span style="font-family:Arial,Helvetica,sans-serif; color:#666666; float:left; margin-left:15px; margin-top:1px;">Green Rating </span> 
														<span style="float:right; margin-left:26px;">'.$row['green_rating_mark'].'</span>
													</li>
												</ul>
										  
												 <p style="float:right; font-size:10px; margin-right:8px; margin-top:-7px;" >
												 <!-- Open for Inspection: {$data.o4i} -->
												 </p>
								   
										</div>	      
									</div>
									
									   <div class="btn-view-wht">
										  
												<button style="float:right" class="btn-view btn-view-home" onClick="document.location = '.$r1.'">
												</button>
												
												 <button class="btn-wht btn-wht-home" style="float:left !important;" onclick="pro.addWatchlist('.$r2.')">
												<span style="font-size:12px;"><span style="font-size:12px;">Add to Watchlist</span></span>
												 </button>
												 
											    <div class="clearthis"> </div>
											</div>
											
								<div class="auc-bid">
										
								  
									</div> 
								   
								</div>
							</li>						
						
						</ul>
				</div>';
				
				
}  // End foreach. 

die('<script>stopTimerGlobal(); ids = []; </script>'.$str.'<script>updateLastBidder();</script>');

?>