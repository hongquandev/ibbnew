<?php 
include_once ROOTPATH.'/modules/agent/inc/agent.class.php';
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
include_once ROOTPATH.'/modules/general/inc/bids.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/property/inc/property.php';

$id = isset($_GET['property_id'])?intval($_GET['property_id']):0;
$agent_id = restrictArgs(getParam('agent_id',0));

//BEGIN SQL FOR CHECK ACTIVE
$auction_sale_ar = PEO_getAuctionSale();

$row = $property_cls->getRow('SELECT pro.auction_sale ,
		pro.end_time,
		pro.start_time,
		pro.agent_id,
		pro.stop_bid,
		pro.confirm_sold,
		pro.pay_status,
		pro.agent_manager,
		pro.agent_active,
		pro.active,
		pro.set_count,
		pro.owner,
		pro.auction_sale,
		pro.suburb,
		pro.sold_time,

		(SELECT count(*)
		FROM ' . $property_cls->getTable('bids') . ' AS bid
		WHERE bid.property_id = pro.property_id
		) AS bids,

        (SELECT agtype.title
        FROM '.$agent_cls->getTable('agent_type').' AS agtype
        WHERE agtype.agent_type_id = agt.type_id) AS agent_type,

        (SELECT pt.value
		FROM '.$property_cls->getTable('property_term').' AS pt,'.$property_cls->getTable('auction_terms').' AS at
		WHERE pt.property_id = pro.property_id AND pt.auction_term_id = at.auction_term_id AND at.code = "reserve")	AS reserve_price,

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
        FROM bids AS bid WHERE bid.property_id = pro.property_id) AS bid_price


        FROM ' . $property_cls->getTable() . ' AS pro
        INNER JOIN ' . $property_cls->getTable('agent') . ' AS agt ON pro.agent_id = agt.agent_id
        WHERE pro.property_id = ' . $id
    
		, true);
    $watermark = '';
    $countdown = '';
	$agent_logo = '';
	$block_image = '';
	$title = '';
    if (is_array($row) and count($row) > 0){

        if(in_array($row['pay_status'],array(Property::PAY_PENDING,Property::PAY_UNKNOWN))
           || ($row['auction_sale'] == $auction_sale_ar['auction'] && $row['start_time'] == '0000-00-00 00:00:00')){//NOT COMPLETE
            if (Property_isVendorOfProperty($id,$agent_id)){
                $status = $watermark = 'not_complete';
            }
        }else{//COMPLETE

            if ($row['confirm_sold'] == 1){//SOLD
                $status = 'sold';
                $countdown = 'SOLD';
                $watermark = 'sold';
            }elseif ($row['auction_sale'] == $auction_sale_ar['auction']){
                if($row['stop_bid'] == 1){//SOLD OR PASSEDIN
                   $status = $watermark = $row['reserve_price'] < $row['bid_price'] && $row['reserve_price'] > 0?'sold':'passed_in';
                   $countdown =  $row['reserve_price'] < $row['bid_price'] && $row['reserve_price'] > 0?'SOLD':'PASSED IN';
                   if (in_array($row['agent_type'],array('agent','theblock'))){
                           $countdown = $row['set_count'];
                           $status = $watermark = $row['set_count'] == 'SOLD'?'sold':'passed_in';
                   }
                }else{
                   $start_time = new DateTime($row['start_time']);
                   $end_time = new DateTime($row['end_time']);
                   $current_time = new DateTime(date('Y-m-d H:i:s'));
                   if ($start_time <= $current_time AND $current_time <= $end_time){//LIVE
                       $status = 'live';
                       if ($row['reserve_price'] <= $row['bid_price'] && $row['reserve_price'] > 0){
                            $watermark = 'on_the_market';
                       }

                       if (in_array($row['agent_type'],array('agent','theblock'))){
                           $countdown = $row['set_count'];
                       }
                   }else{//FORTH
                        $status = 'forthcoming';
                        $start_time = new DateTime($row['start_time']);
                        $countdown = 'Auction starts: '.$start_time->format($config_cls->getKey('general_date_format'));
                   }
                }

                $watermark = $row['agent_active'] == 0 || $row['active'] == 0?'wait_for_activation':$watermark;
            }else{
                $status = 'sale';
            }
        }

        //For switch Pro
        $row_history = $property_history_cls->get_Field($id);
        if (is_array($row_history) and count($row_history) > 0 && !Property_isVendorOfProperty($id,$agent_id)) {
            if ((!PE_isLiveProperty((int)$id))) {
                if (!PE_isstopAuction($id)) {
                    $countdown = 'Switch';
                }
            }
        }
        // end switch
		
        $of_agent = PE_isTheBlock($id, 'agent') ? 1 : 0;
        if ($of_agent) {
            $agent = A_getCompanyInfo($id);
			$agent_logo = MEDIAURL . '/' . $agent['logo'];
        }

		if (PE_isTheBlock($id)) {
			$block_image = ROOTURL . '/modules/general/templates/images/theblock.png';
		}
		
		
		// BEGIN 
		$info_ar = array('property_id' => $id,
						'auction_sale' => $row['auction_sale'],
						'suburb' => $row['suburb'],
						'end_time' => $row['end_time'],
						'start_time' => $row['start_time'],
						'confirm_sold' => $row['confirm_sold'],
						'sold_time' => $row['sold_time'],
						'owner' => $row['owner']);
		$title = Property_getTitle($info_ar);
		// END

        //bid status
        if($status == 'forthcoming'){
            $bid_status = $start_time->format($config_cls->getKey('general_date_format'));
        }elseif ($status != 'sale'){
            $isLastBidVendor = Bid_isLastBidVendor($id,$in_room);
	        $bidder = formUnescape(Bid_getShortNameLastBidder($id));
            if ($isLastBidVendor){
               $bid_status['bidder'] = $in_room?'In Room Bid':'Vendor Bid';
            }else{
               $bid_status['bidder'] = $row['stop_bid'] == 1 || $row['confirm_sold'] == 1?'Last Bidder: '.$bidder:'Current Bidder: '.$bidder;
            }

            $bid_price = showPrice($row['bid_price']);
            if ($row['bids'] == 0){
               $bid_status['price'] = 'Start Price: '.$bid_price;
            }else{
               $bid_status['price'] = $row['stop_bid'] == 1 || $row['confirm_sold'] == 1?'Last Bid: '.$bid_price:'Current Bid: '.$bid_price;
            }
        }
    }
//}

die(json_encode(array('watermark' => $watermark,
				'agent_logo' => $agent_logo,
				'block_image' => $block_image,
				'title' => $title,
				'countdown' => $countdown,
				'status' => $status,
                'bid_status'=>$bid_status)));
?>