<?php
include_once ROOTPATH.'/modules/comment/inc/comment.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/note/inc/note.php';
include_once 'message.php';

if (!($rating_cls) || !($rating_cls instanceof Ratings)) {
	$rating_cls = new Ratings();
}
if (!isset($package_cls) || !($package_cls instanceof Package)) {
	$package_cls = new Package();
}

$property_id = (int)getParam('id',0);

__viewPropertyAuction();
function __viewPropertyAuction() {
	global $smarty, $region_cls, $property_cls, $agent_history_cls, $pag_cls, $property_entity_option_cls,$package_cls,$message_cls,
		$property_rating_mark_cls,$step,$property_media_cls, $media_cls,$agent_cls,$bid_cls,$jagentstr,$jstr,$config_cls;

	$form_data = array();
   // $date_format=''%Y-%m-%d'';
    $auction_sale_ar = PEO_getAuctionSale();

	//BEGIN FOR PAGGING
	$p = (int)restrictArgs(getQuery('p',1));
	$p = $p <= 0 ? 1 : $p;
    $page=$p;
    $mode_fix= isset($_GET['mode']) ? $_GET['mode'] : '';
	$mode_fix = $mode_fix == 'grid' ? 'grid' : 'list';
	//$len = 10;
    if (getPost('len',0) > 0) {
			$_SESSION['len'] = (int)restrictArgs(getPost('len'));
		}
    $len = isset($_SESSION['len']) ? $_SESSION['len'] : 9;
	//END

    //Order By
    $auction_sale_ar = PEO_getAuctionSale();
        $start_price = '(SELECT pro_term.value
                                                     FROM '.$property_cls->getTable('property_term').' AS pro_term
                                                     LEFT JOIN '.$property_cls->getTable('auction_terms'). ' AS term
                                                          ON pro_term.auction_term_id = term.auction_term_id
                                                     WHERE term.code = \'auction_start_price\'
                                                           AND pro.property_id = pro_term.property_id)';
        $wh_price = '(SELECT CASE

            					WHEN pro.auction_sale = '.$auction_sale_ar['auction'].' THEN
            					    (SELECT CASE
            					         WHEN pro.pay_status = '.Property::PAY_COMPLETE.' THEN
            					             (SELECT CASE
                                                 WHEN (date(pro.start_time) > \''.date('Y-m-d H:i:s').'\' OR isnull(max(bid.price)) ) THEN
                                                 '.$start_price.'
                                                 ELSE max(bid.price)
                                                 END
                                                 FROM bids AS bid WHERE bid.property_id = pro.property_id) + 0
                                         ELSE
                                             (SELECT CASE
                                                 WHEN !isnull('.$start_price.') THEN '.$start_price.'
                                                 ELSE pro.price
                                                 END)
            				             END)
            				    ELSE pro.price
                                END)';

    if (getPost('order_by') != '' || $_POST['search']['order_by'] != '') {
		    $_SESSION['order_by'] = (getPost('order_by') != '')?getPost('order_by'):$_POST['search']['order_by'];
		}

        $order_by = isset($_SESSION['order_by']) ? $_SESSION['order_by'] : '';
        $sub_select =null;
        switch ($order_by) {
			case 'highest':
				$order_ar = $wh_price. ' DESC';
				break;
			case 'lowest':
				$order_ar = $wh_price;
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
            case 'offer':
				$order_ar = ' offer_number DESC';
                $sub_select = ',(SELECT count(*)
                            FROM '.$property_cls->getTable('message').' AS msg
                            WHERE msg.entity_id = pro.property_id AND msg.abort = 0 AND pro.confirm_sold !='.Property::PAY_COMPLETE.' AND msg.offer_price > bid_price
                            ) AS offer_number';
				break;
            case 'switch':
				$order_ar = ' ID DESC';
                $sub_select = ',(SELECT pro_his.property_id FROM property_transition_history AS pro_his
                                                                            WHERE pro_his.property_id=pro.property_id AND pro.confirm_sold !='.Property::PAY_COMPLETE.' ORDER BY pro_his.property_transition_history_id DESC LIMIT 0,1) as ID';
				break;
            case 'notcomplete':
				$order_ar = ' pro.pay_status,pro.property_id ASC';
				break;
            case 'active':
				$order_ar = ' pro.active,pro.pay_status DESC';
				break;
            case 'sold':
				$order_ar = ' pro.property_id,pro.confirm_sold DESC';
				break;
			default:
				//$order_ar = ' pro.confirm_sold, pro.stop_bid,pro.pay_status, pro.property_id DESC';
                $order_ar = '   pro.confirm_sold, pro.stop_bid,pro.property_id DESC';
				break;
        }

        $order_ar = ($order_ar != '') ? ' ORDER BY ' . $order_ar : '';
        $smarty->assign('order_by',$order_by);
    //End Order By
	//END

	$sql = 'SELECT SQL_CALC_FOUND_ROWS pro.property_id,
	                                   pro.address,
	                                   pro.description,
	                                   pro.price, pro.suburb,
	                                   pro.stop_bid,
	                                   pro.postcode,
	                                   pro.end_time,
	                                   pro.open_for_inspection,
	                                   pro.pay_status,
	                                   pro.suburb,
	                                   pro.price,
								       pro.agent_active,
								       pro_rat_mrk.livability_rating_mark,
								       pro_rat_mrk.green_rating_mark,
								       pro.step,
								       pro.active,
								       pro.start_time,
								       pro.confirm_sold,
								       pro_opt.code,
								       pro.package_id,
								       pro.price_on_application,
					(SELECT reg1.name FROM '.$region_cls->getTable().' AS reg1 WHERE reg1.region_id = pro.state) AS state_name,
					(SELECT reg2.code FROM '.$region_cls->getTable().' AS reg2 WHERE reg2.region_id = pro.state) AS state_code,
					(SELECT reg3.name FROM '.$region_cls->getTable().' AS reg3 WHERE reg3.region_id = pro.country) AS country_name,
					(SELECT reg4.code FROM '.$region_cls->getTable().' AS reg4 WHERE reg4.region_id = pro.country) AS country_code,

					(SELECT pro_term.value
					     FROM '.$property_cls->getTable('property_term').' AS pro_term LEFT JOIN '.$property_cls->getTable('auction_terms').' AS term
                         ON pro_term.auction_term_id = term.auction_term_id
                         WHERE term.code = "auction_start_price" AND pro.property_id = pro_term.property_id) AS start_price,

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

					(SELECT pt.value
						FROM '.$property_cls->getTable('property_term').' AS pt,'.$property_cls->getTable('auction_terms').' AS at
						WHERE pt.property_id = pro.property_id AND pt.auction_term_id = at.auction_term_id AND at.code = "reserve")	AS reserve,

					(SELECT CASE
            					WHEN pro.auction_sale = '.$auction_sale_ar['auction'].' AND ( date(pro.start_time) > \''.date('Y-m-d H:i:s').'\' OR isnull(max(bid.price)) ) THEN

									(SELECT pro_term.value
									 FROM '.$property_cls->getTable('property_term').' AS pro_term
									 LEFT JOIN '.$property_cls->getTable('auction_terms'). ' AS term ON pro_term.auction_term_id = term.auction_term_id
									 WHERE term.code = \'auction_start_price\' AND pro.property_id = pro_term.property_id)

            					WHEN auction_sale = '.$auction_sale_ar['private_sale'].' THEN pro.price
            				ELSE max(bid.price)
            				END
            		FROM bids AS bid WHERE bid.property_id = pro.property_id) AS bid_price,

					(SELECT MAX(bid.price)
						FROM '.$property_cls->getTable('bids').' AS bid
						WHERE bid.property_id = pro.property_id ) AS bid_prices
                    '.$sub_select.'
			FROM '.$property_cls->getTable().' AS pro
			LEFT JOIN '.$property_rating_mark_cls->getTable().' AS pro_rat_mrk ON pro.property_id = pro_rat_mrk.property_id
			LEFT JOIN '.$property_entity_option_cls->getTable().' AS pro_opt ON property_entity_option_id = pro.auction_sale

			WHERE pro.agent_id = '.$_SESSION['agent']['id'].'
			AND code = \'auction\'
			AND pro.confirm_sold = '.Property::SOLD_UNKNOWN.'
			AND (pro.stop_bid = 0
			AND (pro.end_time > \''.date('Y-m-d H:i:s').'\')
			OR   pro.pay_status != '.Property::PAY_COMPLETE.')
			'.$order_ar.'
			LIMIT '.(($p - 1) * $len).','.$len;


	//print_r($sql);
	$rows = $property_cls->getRows($sql,true);

	$total_row = $property_cls->getFoundRows();
	$review_pagging = (($p - 1) * $len).' - '.(($p * $len) > $total_row ? $total_row : ($p * $len)).' ('.$total_row.' Items)';

	$v = 'view-auction';
    if($mode_fix == 'grid')
    {
        $pag_cls->setTotal($total_row)
			->setPerPage($len)
			->setCurPage($p)
			->setLenPage(10)
			->setUrl('/?module=agent&action='.$v .'&mode=grid')
			->setLayout('link_simple');
    }
    else{
	    $pag_cls->setTotal($total_row)
			->setPerPage($len)
			->setCurPage($p)
			->setLenPage(10)
			->setUrl('/?module=agent&action='.$v .'&')
			->setLayout('link_simple');
    }

    $smarty->assign('mode_fix',$mode_fix);
	$smarty->assign('review_pagging',$review_pagging);
	$smarty->assign('pag_str',$pag_cls->layout());

	$results = array();
	if ($property_cls->hasError()) {

	} else if (is_array($rows) and count($rows) > 0) {

		foreach ($rows as $k => $row) {
			$link_ar = array('module' => 'property', 'action' => 'register' , 'id' => $row['property_id']);
            $step=$row['step'];
            $results[$k]['info']['can_show'] = true;
            $results[$k]['info'] = $row;


            //format End Time
            if ($results[$k]['info']['end_time'] == '0000-00-00 00:00:00') {
			    $results[$k]['info']['start_time'] = '';
                $results[$k]['info']['end_time']='';
		    }
		    else{
			    $dt = new DateTime($results[$k]['info']['end_time']);
			    $results[$k]['info']['end_time'] = $dt->format($config_cls->getKey('general_date_format'));

                $dt = new DateTime($results[$k]['info']['start_time']);
			    $results[$k]['info']['start_time'] = $dt->format($config_cls->getKey('general_date_format'));
		    }

            $types = PE_Get_type_property($row['property_id']);

            $results[$k]['info']['type'] = $types;

            $results[$k]['info']['edit_term']= true;
            
            $results[$k]['info']['titles'] = 'AUCTION ';

            if( $types == 'live_auction' or $types == 'forth_auction')
            {
                $results[$k]['info']['titles'] = 'AUCTION ENDS: '.$results[$k]['info']['end_time'];
                if( $types == 'live_auction' )
                {
                    $results[$k]['info']['bid_price'] = showprice($row['bid_price']);
                    if(Property_datediff(date('Y-m-d H:i:s'),$row['end_time'])  < 5){
                        $results[$k]['info']['edit_term']= false;
                    }
                }
                if($types == 'forth_auction' ){
                    $results[$k]['info']['bid_price'] = showLowPrice($row['bid_price']).'-'.showHighPrice($row['bid_price']);
                    if($mode_fix == 'grid')
                    {
                        $results[$k]['info']['bid_price'] =  showSwingPrice($row['bid_price']);
                    }
                    if (in_array($row['auction_sale_code'],array('ebiddar','bid2stay')) && $row['price_on_application'] == 0) {
                        $results[$k]['info']['bid_price'] = 'Starting at ' . showPrice($row['bid_price']);
                    }
                }
            }
            else if ($types == 'not_payment')
            {

               $results[$k]['info']['titles'] = 'AUCTION ';
               if(($row['end_time'] != '0000-00-00 00:00:00' AND $row['start_time'] != '0000-00-00 00:00:00') )
               {
                   $results[$k]['info']['bid_price'] = showprice($row['bid_price']);
                   if($row['start_time'] < date('Y-m-d H:i:s'))
                   {
                       $results[$k]['info']['type'] = 'not_payment_live';
                   }
                   else{
                       $results[$k]['info']['type'] = 'not_payment_forth';
                       $results[$k]['info']['bid_price'] = showLowPrice($row['bid_price']).'-'.showHighPrice($row['bid_price']);
                       if($mode_fix == 'grid')
                       {
                            $results[$k]['info']['bid_price'] =  showSwingPrice($row['bid_price']);
                       }
                       if (in_array($row['auction_sale_code'],array('ebiddar','bid2stay')) && $row['price_on_application'] ==  0){
                            $results[$k]['info']['bid_price'] = 'Starting at '.showPrice($row['bid_price']);
                       }
                   }
               }
                else{
                    $results[$k]['info']['bid_price'] = '';
                }


            }

            //Begin Set watermark
            $results[$k]['info']['watermark']='';
            if($row['type']=='live_auction' && (float)$row['reserve']<=(float)$row['bid_prices']){
               $results[$k]['info']['watermark']='/modules/general/templates/images/onthemarket_list.png';
            }
             if($row['type']=='stop_auction' && (float)$row['reserve']<=(float)$row['bid_prices']){
               $results[$k]['info']['watermark']='/modules/general/templates/images/SOLD.png';
            }
            if($row['confirm_sold']==1)
            {
                $results[$k]['info']['watermark']='/modules/general/templates/images/SOLD.png';
            }
            if($types == 'not_payment')
            {
                $results[$k]['info']['watermark']='/modules/general/templates/images/nopayment.png';

            }
            //End

            //Begin Reset pay_status
            $results[$k]['info']['wait_for_activation'] == false;
            if($row['pay_status'] == Property::PAY_UNKNOWN)
            {
                $results[$k]['info']['pay_status']= 'unknown';
                $results[$k]['info']['status'] =  'No payment';
            }
             if($row['pay_status']== Property::PAY_PENDING)
            {
                $results[$k]['info']['pay_status']='pending';
                $results[$k]['info']['status'] = 'Payment review';
                $step = 7;
            }
             if($row['pay_status']== Property::PAY_COMPLETE)
            {
                $results[$k]['info']['pay_status']='complete';
                $results[$k]['info']['status'] = 'Enable';
                if ($row['active'] == 0 )
                {
                    $results[$k]['info']['wait_for_activation'] = true;

                }
                if ($row['agent_active'] == 0) {
				    $results[$k]['info']['status'] = 'Disable';
			    }
            }


            //End

            //Format general

            $results[$k]['info']['link_detail'] = '?module=property&action=view-auction-agent_detail&id='.$row['property_id'];
			if(PE_isLiveProperty($row['property_id']))
            {
                $results[$k]['info']['link_detail'] = '?module=property&action=view-auction-detail&id='.$row['property_id'];
            }

			$results[$k]['info']['full_address'] = $row['address'].' '.$row['suburb'].' '.$row['postcode'].' '.$row['state_name'].' '.$row['country_name'];
			$results[$k]['info']['livability_rating_mark'] = showStar((float)$row['livability_rating_mark']);
			$results[$k]['info']['green_rating_mark'] = showStar((float)$row['green_rating_mark']);
			$results[$k]['info']['description'] = safecontent($row['description'],150);
            $results[$k]['info']['description'] = $results[$k]['info']['description'].'....';

            $results[$k]['info']['remain_time'] = remainTime($row['end_time']);
            $results[$k]['o4i'] = Calendar_createPopup($row['property_id'],$row['open_for_inspection']);

            $results[$k]['info']['price'] = '';
            if($row['price'] !='')
            {
             $results[$k]['info']['price'] = showPrice($row['price']);
            }

            //BEGIN GET START PRICE
            $start_price = PT_getValueByCode($row['property_id'],'auction_start_price');
            $results[$k]['info']['check_start'] = ((int)$start_price == (int)$row['bid_price'])?'true':'false';

            if(!isset($row['bid_price']))
            {
                $row['bid_price'] ='0';
            }

            // MAKE AN OFFER
            $type_pro = PE_Get_type_property($row['property_id']);
            $off_price = $row['bid_price'];
            if($type_pro == 'forth_auction')
            {
                $off_price = ($off_price*90)/100;
            }
            if($row['confirm_sold'] == Property::SOLD_UNKNOWN){
                $row_mess=$property_cls->getRows('SELECT DISTINCT msg.agent_id_from
                            FROM '.$property_cls->getTable('message').' AS msg
                            WHERE msg.entity_id = '.$row['property_id'].' AND msg.abort = 0 AND msg.offer_price > '.$off_price.'
                            ORDER BY msg.send_date DESC',true);

                if(is_array($row_mess) and count($row_mess) >0){
                    $results[$k]['info']['mao_num']= count($row_mess);
                    //print_r($results[$k]['info']['mao_num']);
                }
            }
            else{

                // update abort =1
                $message_cls->update(array('abort' => 1),'entity_id='.$row['property_id']);
            }


            //end
             //BEGIN property_history

                $results[$k]['history'] = '';
                $row_history=$property_cls->getRows('SELECT pro_his.property_id FROM '.$property_cls->getTable('property_transition_history').' AS pro_his
                                                                            WHERE property_id='.$row['property_id'],true);
                if(is_array($row_history) && count($row_history)>0)
                {
			        $smarty->assign('property_id',$row['property_id']);

                    $_str = '<a href="javascript:void(0)"  onClick="show_history('.$row['property_id'].')" class="history" style="color:#CC8C04; text-decoration:none">History - </a>';
                    if($mode_fix == 'grid')
                    {
                        $_str = '<a href="javascript:void(0)"  onClick="show_history('.$row['property_id'].')" class="history" style="color:#CC8C04; text-decoration:none">History - </a>';
                    }
                    $smarty->assign('property_id',$row['property_id']);
			        $_str .= $smarty->fetch(ROOTPATH.'/modules/property/templates/property.history.popup.tpl');
			        $results[$k]['history'] = $_str;

                }
            //END

            //Begin confirm sold status
            $results[$k]['info']['confirm_sold'] = 'Sold';
            if ($row['confirm_sold'] == 0) {
				$results[$k]['info']['confirm_sold'] = 'None';
			}
            //end

			//Begin Link
			$results[$k]['info']['link'] = '/?'.http_build_query($link_ar).'&step=6';
			$results[$k]['info']['link_edit'] = '/?'.http_build_query($link_ar);
            //Link For delete a property
			$link_ar['action'] = 'delete';
			$results[$k]['info']['link_del'] = '/?'.http_build_query($link_ar).'&redirect=view-auction&page='.$page;
            //Link for cancel bidding a property
            $link_ar['action'] = 'cancel_bidding';
			$results[$k]['info']['link_cancel_bidding'] = '/?'.http_build_query($link_ar).'&redirect=view-auction&page='.$page;

            //BEGIN FOR MEDIA
			$_photo = PM_getPhoto($row['property_id']);
			$results[$k]['photos'] = $_photo['photo'];
            $results[$k]['photos_count'] = count($_photo['photo']);
			$results[$k]['photo_default'] = $_photo['photo_default'];
			//END MEDIA

            //BEGIN AGENT
            $results[$k]['info']['bidder'] = Bid_getShortNameLastBidder($row['property_id']);
            //END
			//BEGIN COMMENT
            $row_comment = $package_cls->getRow('package_id= '.$row['package_id']);
            if((int)$row_comment['can_comment'] == 1)
            {
                $results[$k]['comment'] = array();
                $results[$k]['comment']['num'] = Comment_count((int)$row['property_id']);
                $results[$k]['comment']['comment'] = 'comment ('.Comment_count((int)$row['property_id']).') -';
                $results[$k]['comment']['link'] = '';
                if ($results[$k]['comment']['num'] > 0) {
                    $results[$k]['comment']['link'] = ROOTURL.'/?module=agent&action=view-comment&property_id='.$row['property_id'];
                }
            }
            //END COMMENT
			$results[$k]['num_note'] = Note_count("entity_id_to = ".$row['property_id']." AND entity_id_from = ".$_SESSION['agent']['id']." AND type = 'customer2property'");
			//END

			$results[$k]['info']['reserve_price']=showPrice($row['reserve']);
			//END
		}//End foreach
	}

    $form_action= array('module'=>'agent','action'=>'view-auction');
    $title_bar = 'MANAGE AUCTION TERMS';
    $smarty->assign('len', $len);
    $smarty->assign('page','view-auction');
    $smarty->assign('act','view-auction');
	$smarty->assign('len_ar', PE_getItemPerPage());
    $smarty->assign('property_title_bar', $title_bar);
    $form_action = '?'.http_build_query($form_action);
    $smarty->assign('form_action', $form_action);
    $smarty->assign('order_by_action','view-auction');
    $check_agent = (AI_isBasic($_SESSION['agent']['id']))?'true':'false';
    $smarty->assign('check_agent',$check_agent);
	$smarty->assign('form_data',$form_data);
	$smarty->assign('results',$results);
}
?>