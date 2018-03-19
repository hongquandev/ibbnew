<?php

	include_once 'emailalert.class.php';
	include_once ROOTPATH.'/modules/general/inc/regions.php';
    include_once ROOTPATH.'/modules/property/inc/property.php';
    include_once ROOTPATH.'/modules/property/inc/property_entity_option.class.php';
    include_once ROOTPATH.'/modules/agent/inc/agent.php';
    include_once ROOTPATH.'/modules/configuration/inc/config.class.php';
    include_once ROOTPATH.'/modules/general/inc/email_log.class.php';

    if (!isset($log_cls) || !($log_cls instanceof Email_log)) {
        $log_cls = new Email_log();
    }
	// Call Constructor init();
	if (!isset($email_cls) || !($email_cls instanceof EmailAlert)) {
		$email_cls = new EmailAlert();
	}


    function EA_getStatus($id){
        global $email_cls;
        $row = $email_cls->getRow(' email_id = '. $id);
        if (is_array($row) and count($row)>0){
            return $row['allows'];
        }
        return null;
    }

    function EA_optionSchedule(){
        global $email_cls;
        $sch = array();
        $rows = $email_cls->getRows('SELECT * FROM '.$email_cls->getTable('schedule'),true);
        if (is_array($rows) and count($rows) > 0){
            foreach ($rows as $row){
                $sch[$row['schedule_id']] = $row['schedule_name'];
            }
        }
        return $sch;
    }

    function EA_getSchedule(){
        global $email_cls;
        $sch = array('Daily'=>0,'Weekly'=>0,'Monthly'=>0);
        $rows = $email_cls->getRows('SELECT * FROM '.$email_cls->getTable('schedule'),true);
        if (is_array($rows) and count($rows) > 0){
            foreach ($rows as $row){
                $sch[$row['schedule_name']] = $row['schedule_id'];
            }
        }
        return $sch;
    }
    /*research and EA_sendEmail
     return: void
    */
    function EA_reSearch(&$data,& $message,$agent_id,$schedule = 0,$type = 'cron'){
        global $agent_cls,$email_cls;
        $result = array();
        $data = formUnescapes($data);    
        $result = searchPro($data,$schedule,$type);

        $auction_sale_ar = PEO_getAuctionSale();
        $entity_diff = 0;
        $id_data = null;

        if(count($result) > 0 and is_array($result))
        {
            $id_data = array();
            foreach($result as $row)
            {
                $id_data[] = $row['property_id'];
            }
        }

        $banner = PE_getBanner($data);

        /*$check = false;
        if($data['property_number'] != null )
        {
            $check = true;
            $property_number = explode(',',$data['property_number']);
            $entity_diff = count(array_diff($id_data,$property_number));
        }*/

		if ((count($result) > 0 )){
            /*if($data['auction_sale'] == $auction_sale_ar['auction']) {
                    $auction_sale = 'auction';
            } else {
                    $auction_sale = 'sale';
            }*/
            $full_link = ROOTURL.'?module=property&action=search'/*-.$auction_sale*/;
            $fields = array('property_type','property_kind','auction_sale','minprice','maxprice','address','suburb','state','postcode','bedroom','bathroom','parking',
                            'car_space','car_port','land_size_max','land_size_min','unit');
            foreach ($fields as $_f){
                    $full_link .= '&'.$_f.'='.($fields == 'auction_sale'?setAuctionSale($data[$_f]):$data[$_f]);
            }

            $subject = $data['name_email'];
            $sent = false;
            $email_agent = $agent_cls->getRow('agent_id = '.$agent_id);
            if(count($email_agent) > 0 AND is_array($email_agent))
            {
                $email_agent['full_link'] = $full_link;
                $email_agent['description'] = $data['description'];
                $nd = tplEmail($result,$email_agent);
                $data['content'] = addslashes($nd);
                if(isset($email_agent['email_address']) AND $email_agent['email_address'] != '')
                {
                    if (EA_sendEmail($email_agent['email_address'],$subject,$nd,$message,$banner)){
                        $message = 'Resend successfully !';
                        $sent = true;
                    }
                }
            }
            $email_cls->update(array('property_number' => implode(',',$id_data))
                                                         ,'email_id ='.$data['email_id']);
            return $sent;

        }else{
            $message = 'No property match !';
            return false;
        }

    }
    function EA_sendEmail($to = '',$subject = '',$content = '',$msg = '',$banner = ''){
        global $log_cls,$agent_cls;
        include_once ROOTPATH.'/modules/general/inc/bids.php';
        include_once ROOTPATH.'/modules/general/inc/email_log.class.php';
        $row = $agent_cls->getRow(" `email_address` = '$to'");
        $ok = false;
        if(count($row) > 0 and is_array($row))
        {
            if($row['notify_email'] == 1)
            {
                $ok = true;
            }else{
                if($row['allow_alert'] == 1)
                {
                    $ok = true;
                    $agent_cls->update(array('allow_alert' => 0),"agent_id = ".$row['agent_id']);
                }

            }
            if($ok)
            {
                $mail = sendEmail_func('',$to,$content,$subject,$banner);
                if( $mail == 'send'){
                    $log_cls->createLog('email_alert');
                    return true;
                }else{
                    return $mail;
                }
            }
        }else{
            return true;
        }
    }

function searchPro($sr_arr, $schedule = 0, $type = 'cron')
{
    global $property_cls, $region_cls, $property_entity_option_cls, $config_cls, $smarty;
    include_once ROOTPATH . '/modules/property/inc/property.php';
    $where_ar = array();
    $where_str = '';
    $auction_sale_ar = PEO_getAuctionSale();
    if ($schedule != 0 and $type == 'cron') {
        $schedule_ar = EA_getSchedule();
        if ($schedule == $schedule_ar['Daily']) {
            $where_ar[] = ' (pro.creation_datetime > \'' . $sr_arr['last_cron'] . '\' OR pro.last_update_time > \'' . $sr_arr['last_cron'] . '\'  )';
        }
        if ($schedule == $schedule_ar['Weekly']) {
            $where_ar[] = ' (pro.creation_datetime > \'' . $sr_arr['last_cron'] . '\' OR pro.last_update_time > \'' . $sr_arr['last_cron'] . '\'  )';
        }
        if ($schedule == $schedule_ar['Monthly']) {
            $where_ar[] = ' (pro.creation_datetime > \'' . $sr_arr['last_cron'] . '\' OR pro.last_update_time > \'' . $sr_arr['last_cron'] . '\'  )';
        }
    }

    if (isset($sr_arr['auction_sale'])) {
        $sr_arr['auction_sale'] = setAuctionSale($sr_arr['auction_sale']);
    }

    /* if (isset($sr_arr['auction_sale'])) {
         if ($sr_arr['auction_sale'] == $auction_sale_ar['auction'] ) {
             $where_ar[] = ' pro.auction_sale = '.$auction_sale_ar['auction'];
         } else {
             $where_ar[] = '  pro.auction_sale = '.$auction_sale_ar['private_sale'];
         }
     }*/
    if (count($where_ar) > 0) {
        $where_str = implode(' AND ', $where_ar);
    }
    //$where_str = ' AND '.$where_str;
    if (strlen(trim($where_str)) > 0) {
        $where_str = ' AND ' . $where_str;
    }

    $temp = '';
    $where_str .= getSearchQueryByFormData($sr_arr, $temp);
    $p = 1;
    $len = 5;
    $search_query = "";
    $_SESSION['order_by'] = "newest";
    $rows = Property_getList($where_str, $p, $len, $search_query);
    /* print_r_pre($sr_arr);
    print_r_pre($rows);die();*/
    unset($_SESSION['order_by']);
    $result = array();
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $k => $row) {
            //print_r($row['price']);
            $result[$k] = $row;
            $result[$k]['full_address'] = $row['address'] . ' ' . $row['postcode'] . ' ' . $row['suburb'] . ' ' . $row['state_name'] . ' ' . $row['country_name'];
            //BEGIN TYPE AND LINK
            $result[$k]['price'] = ($row['price']);
            if ($row['auction_sale'] == $auction_sale_ar['private_sale']) {
                //$result[$k]['price'] = $row['price_on_application'] == 1 ? 'Price On Application': showPrice($row['price']);
            }

            if (!$row['isBlock'] && !$row['ofAgent']) {
                if ($row['pro_type'] == 'forthcoming' or $row['pro_type'] == 'auction'){
                    if ($row['auction_type'] == 'passedin'){
                        $title = "Auction Ended: {$row['end_time']}";
                    }else{
                        $title = "Auction Ends: {$row['end_time']}";
                    }
                }else{
                    $title = "For Sale: {$row['suburb']}";
                }
                if ($row['confirm_sold'] == 1 and $row['pro_type'] != 'sale'){
                    $title = "Auction End:  {$row['end_time']}";
                }
            } elseif ($row['isBlock']) {
                $title = $row['owner'];
            } else {
                $title = $row['auction_title'] . ": " . $row['agent']['company_name'];
            }

            if ($row['auction_sale_code'] == 'auction') {
                if ($row['start_time'] > date('Y-m-d H:i:s')) {
                    $result[$k]['type'] = 'forthcoming';
                } else {
                    $result[$k]['type'] = 'auction';
                }
            } else {
                $result[$k]['type'] = 'sale';
            }
            $result[$k]['link'] = shortUrl(array('module' => 'property', 'action' => 'email_alert') + array('data' => $row));
            $result[$k]['title'] = $title;
            //END
            //BEGIN FOR MEDIA
            $_media = PM_getPhoto($row['property_id'], true);
            $result[$k]['photo'] = $_media['photo_thumb'];
            $result[$k]['photo_default'] = ROOTURL . '/' . $_media['photo_thumb_default'];
            //END MEDIA
        }
    }
    return $result;
}

function searchPro_($sr_arr,$schedule = 0){

    $where_str = '1';
    global $property_cls, $region_cls, $property_entity_option_cls, $config_cls;

    if (isset($sr_arr['auction_sale']) && ($sr_arr['auction_sale'] > 0)) {
        $where_ar[] = "pro.auction_sale = ".$sr_arr['auction_sale'];
    }

    if (isset($sr_arr['property_type']) && ($sr_arr['property_type'] > 0)) {
        $where_ar[] = "pro.`type` = ".$sr_arr['property_type'];

    }

    if (isset($sr_arr['property_kind']) && ($sr_arr['property_kind'] > 0 )) {
        $where_ar[] = "pro.`kind` = ".$sr_arr['property_kind'];
        if($sr_arr['property_kind'] == 1)
        {
            unset($sr_arr['bedroom'],$sr_arr['bathroom']);
        }
    }


    if (isset($sr_arr['address']) && strlen($sr_arr['address']) > 0) {
        $where_ar[] = "pro.address LIKE '%".$sr_arr['address']."%'";
    }

    if (isset($sr_arr['suburb']) && strlen($sr_arr['suburb']) > 0) {
        $where_ar[] = "pro.suburb LIKE '%".$property_cls->escape($sr_arr['suburb'])."%'";
    }

    if (isset($sr_arr['state']) && $sr_arr['state'] > 0) {
        $_state_id = (int)preg_replace('#[^0-9]#','',$property_cls->escape($sr_arr['state']));
        $where_ar[] = "pro.state = ".$_state_id;
    }

    if (isset($sr_arr['postcode']) && strlen($sr_arr['postcode']) > 0) {
        $_postcode = (int)preg_replace('#[^0-9]#','',$property_cls->escape($sr_arr['postcode']));
        $where_ar[] = "pro.postcode = '".$_postcode."'";
    }

    if (isset($sr_arr['country']) && $sr_arr['country'] > 0) {
        $_country_id = (int)preg_replace('#[^0-9]#','',$property_cls->escape($sr_arr['country']));
        $where_ar[] = "pro.country = ".$_country_id;
    }


    if (isset($sr_arr['bedroom']) && $sr_arr['bedroom'] > 0) {
        $_bedroom_val = (int)preg_replace('#[^0-9]#','',$sr_arr['bedroom']);
        $where_ar[] = "pro.bedroom = ".$_bedroom_val;
        $where_ar[] = "pro.kind = 1 ";

    }

    if (isset($sr_arr['bathroom']) && $sr_arr['bathroom'] > 0) {
        $_bathroom_val = (int)preg_replace('#[^0-9]#','',$sr_arr['bathroom']);
        $where_ar[] = "pro.bathroom = ".$_bathroom_val;
        $where_ar[] = "pro.kind = 1 ";
    }


    if (isset($sr_arr['parking']) && $sr_arr['parking'] > 0) {
        $where_ar[] = "pro.parking = ".$sr_arr['parking'];
    }

    if (isset($sr_arr['car_space']) and $sr_arr['car_space'] > 0) {
        $where_ar[] = 'pro.car_space = ' . $sr_arr['car_space'];
        $where_ar[] = 'pro.parking = 1';
    }
    if (isset($sr_arr['car_port']) and $sr_arr['car_port'] > 0) {
        $where_ar[] = 'pro.car_port = '.$sr_arr['car_port'];
        $where_ar[] = 'pro.parking = 1';
    }

    if (isset($sr_arr['unit']) && strlen($sr_arr['unit']) > 0){
        /*$unit = $property_cls->getRow('SELECT * FROM '.$property_cls->getTable('property_entity_option').'
     WHERE property_entity_option_id = '.$sr_arr['unit'],true);*/
        $unit = $property_entity_option_cls->getItem($sr_arr['unit'],'title');
        $len_ = strlen($unit['title']);
        $len_ = $len_ - 1;
        $where_ar[] = " mid(land_size,length(land_size) - ".$len_ .") = '".$unit['title']."'";
    }

    if ((isset($sr_arr['land_size_min']) && $sr_arr['land_size_min'] > 0) || (isset($sr_arr['land_size_max'])&& $sr_arr['land_size_max'])) {
        if (isset($sr_arr['land_size_min']) && isset($sr_arr['land_size_max'])) {
            $_min = (int)$sr_arr['land_size_min'];
            $_max = (int)$sr_arr['land_size_max'];
            if ($_max  == 0){
                $where_ar[] = " pro.land_size + 0 >= ".$_min;  }
            else {
                $where_ar[] =" pro.land_size + 0 BETWEEN ".$_min." AND ".$_max;
            }
        }
    }
    $auction_sale_ar = PEO_getAuctionSale();
    $wh_price = "(SELECT CASE
            WHEN auction_sale = '9' AND date(pro.start_time) > '".date('Y-m-d H:i:s')."' OR (isnull(max(bid.price))AND pro.auction_sale = '9') THEN
                (SELECT pro_term.value
                 FROM ".$property_cls->getTable('property_term')." AS pro_term
                 LEFT JOIN ".$property_cls->getTable('auction_terms'). " AS term ON pro_term.auction_term_id = term.auction_term_id
                 WHERE term.code = 'auction_start_price' AND pro.property_id = pro_term.property_id)
            WHEN auction_sale != ".$auction_sale_ar['auction']." AND pro.price != 0 THEN pro.price
            WHEN auction_sale != ".$auction_sale_ar['auction']." AND pro.price = 0 AND pro.price_on_application != 0 THEN pro.price_on_application
            ELSE max(bid.price)
            END
            FROM bids AS bid WHERE bid.property_id = pro.property_id) + 0";

    if (isset($sr_arr['minprice']) || isset($sr_arr['maxprice'])) {

        if (isset($sr_arr['minprice']) && isset($sr_arr['maxprice'])) {
            $_minprice = (int)preg_replace('#[^0-9]#', '', $sr_arr['minprice']);
            $_maxprice = (int)preg_replace('#[^0-9]#', '', $sr_arr['maxprice']);
            if ($_maxprice == 0 && $_minprice == 0) {
            }
            else {
                if ($_maxprice == 0) {
                    $where_ar[] = $wh_price . " >= " . $_minprice;
                }
                else {
                    $where_ar[] = $wh_price . " >= " . $_minprice . " AND " . $wh_price . " <= " . $_maxprice;
                }
            }
        }
    }


    if($schedule != 0)
    {
        $schedule_ar = EA_getSchedule();
        if($schedule == $schedule_ar['Daily'])
        {
            $where_ar[] = ' (pro.creation_datetime > \''.$sr_arr['last_cron'].'\' OR pro.last_update_time > \''.$sr_arr['last_cron'].'\'  )';
        }

        if($schedule == $schedule_ar['Weekly'])
        {
            $where_ar[] = ' (pro.creation_datetime > \''.$sr_arr['last_cron'].'\' OR pro.last_update_time > \''.$sr_arr['last_cron'].'\'  )';
        }

        if($schedule == $schedule_ar['Monthly'])
        {
            $where_ar[] = ' (pro.creation_datetime > \''.$sr_arr['last_cron'].'\' OR pro.last_update_time > \''.$sr_arr['last_cron'].'\'  )';
        }
    }


    if (count($where_ar) > 0) {
        $where_str = implode(' AND ',$where_ar);
        //print_r($where_ar);
    }

    $where_str .= ' AND (IF (pro.confirm_sold = 1  AND datediff(\''.date('Y-m-d H:i:s').'\',pro.sold_time) < 14,1,0) = 1
                     OR (pro.auction_sale = '.$auction_sale_ar['auction'].'
                         AND  pro.stop_bid = 1
                         AND  pro.confirm_sold = 0
                         AND (SELECT IF(ISNULL(max(bid.price)),0,max(bid.price))
                              FROM '.$property_cls->getTable('bids').' AS bid
                              WHERE pro.property_id = bid.property_id)
                              <
                              (SELECT pro_term.value
                              FROM '.$property_cls->getTable('property_term').' AS pro_term
                              LEFT JOIN '.$property_cls->getTable('auction_terms').' AS term
                              ON pro_term.auction_term_id = term.auction_term_id
                              WHERE term.code = \'reserve\' AND pro.property_id = pro_term.property_id
                         )
                         AND datediff(\''.date('Y-m-d H:i:s').'\', pro.end_time) < 14+0)
                     OR (pro.confirm_sold = 0 AND pro.auction_sale = '.$auction_sale_ar['private_sale'].')
                     OR (pro.auction_sale = '.$auction_sale_ar['auction'].' AND pro.stop_bid = 0))';
    $where_str .= ' AND IF (pro.auction_sale = '.$auction_sale_ar['auction'].'
														AND (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\',0,pro_term.value)
															 FROM '.$property_cls->getTable('property_term').' AS pro_term
															 LEFT JOIN '.$property_cls->getTable('auction_terms').' AS term
																ON pro_term.auction_term_id = term.auction_term_id
															 WHERE term.code = \'auction_start_price\'
																AND pro.property_id = pro_term.property_id )
														AND  (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\',0,pro_term.value)
															 FROM '.$property_cls->getTable('property_term').' AS pro_term
															 LEFT JOIN '.$property_cls->getTable('auction_terms').' AS term
																ON pro_term.auction_term_id = term.auction_term_id
															 WHERE term.code = \'reserve\'
																AND pro.property_id = pro_term.property_id )
														AND  IF ((SELECT pro_term.value
															 FROM '.$property_cls->getTable('property_term').' AS pro_term
															 LEFT JOIN '.$property_cls->getTable('auction_terms').' AS term
																ON pro_term.auction_term_id = term.auction_term_id
															 WHERE term.code = \'auction_start_price\'
																AND pro.property_id = pro_term.property_id )
														     >
															 (SELECT pro_term.value
															 FROM '.$property_cls->getTable('property_term').' AS pro_term
															 LEFT JOIN '.$property_cls->getTable('auction_terms').' AS term
																ON pro_term.auction_term_id = term.auction_term_id
															 WHERE term.code = \'reserve\'
																AND pro.property_id = pro_term.property_id ),0,1)

													    = 0, 0, 1) = 1';

    //

    $auction_sale_ar = PEO_getAuctionSale();
    $rows = $property_cls->getRows("SELECT SQL_CALC_FOUND_ROWS pro.property_id,pro.kind,pro.parking,pro.type, pro.address, pro.auction_sale, pro.suburb, pro.postcode, pro.end_time,pro.stop_bid,
				     pro.confirm_sold,pro.description, pro.open_for_inspection, pro.agent_active,pro.price_on_application,
				 	date_format(start_time, '%Y-%m-%d') as start_time , date(Now()) as dt,
			(SELECT reg1.name FROM ".$region_cls->getTable().' AS reg1 WHERE reg1.region_id = pro.state) AS state_name,
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

				(SELECT CASE
						WHEN auction_sale = '.$auction_sale_ar['auction'].' AND ( pro.start_time > \''.date('Y-m-d H:i:s').'\' OR isnull(max(bid.price)) ) THEN

							(SELECT pro_term.value
							 FROM '.$property_cls->getTable('property_term').' AS pro_term
							 LEFT JOIN '.$property_cls->getTable('auction_terms').' AS term
							 ON pro_term.auction_term_id = term.auction_term_id
							 WHERE term.code = \'auction_start_price\' AND pro.property_id = pro_term.property_id
							 )

						WHEN auction_sale != '.$auction_sale_ar['auction'].' AND pro.price != 0 THEN pro.price
                        WHEN auction_sale != '.$auction_sale_ar['auction'].' AND pro.price = 0 AND pro.price_on_application != 0 THEN pro.price_on_application
						ELSE max(bid.price)
						END
				FROM '.$property_cls->getTable('bids').' AS bid
				WHERE bid.property_id = pro.property_id
				) AS price
			FROM '.$property_cls->getTable().' AS pro
			INNER JOIN '.$property_cls->getTable('agent')." AS agt ON pro.agent_id = agt.agent_id AND agt.type_id IN
					(SELECT agt_typ.agent_type_id FROM ".$property_cls->getTable('agent_type').' AS agt_typ WHERE agt_typ.title != \'theblock\')

			WHERE 	IF(pro.hide_for_live = 1 AND pro.start_time > \''.date('Y-m-d H:i:s').'\',0,1) = 1
					AND (
				        IF (pro.stop_bid = 1
				            AND datediff(\''.date('Y-m-d H:i:s').'\', pro.end_time) < 14
				            AND pro.confirm_sold = 0
                            AND '. $wh_price .' <
                                (SELECT pro_term.value
                                 FROM '.$property_cls->getTable('property_term').' AS pro_term
                                 LEFT JOIN '.$property_cls->getTable('auction_terms').' AS term
                                 ON pro_term.auction_term_id = term.auction_term_id
                                 WHERE term.code = \'reserve\' AND pro.property_id = pro_term.property_id
                                 )+ 0,1,0) = 1
                        OR pro.stop_bid = 0)
					AND pro.pay_status = '.Property::CAN_SHOW.'
					AND	pro.active = 1
					AND pro.agent_id != '.$sr_arr['agent_id'].'
					AND pro.agent_active = 1 AND '.$where_str
        .' ORDER BY pro.property_id DESC
                    LIMIT 0,5',true);
    $result = array();
    if (is_array($rows) and count($rows)>0){
        foreach ($rows as $k=>$row){
            $result[$k] = $row;
            $result[$k]['full_address'] = $row['address'].' '.$row['postcode'].' '.$row['suburb'].' '.$row['state_name'].' '.$row['country_name'];

            //BEGIN TYPE AND LINK
            $result[$k]['price'] = showPrice($row['price']);
            if ($row['auction_sale'] == $auction_sale_ar['private_sale']){
                $result[$k]['price'] = $row['price_on_application'] == 1 ? 'Price On Application': showPrice($row['price']);
            }
            if ($row['auction_sale_code'] == 'auction'){
                if ($row['start_time'] > date('Y-m-d H:i:s')){
                    $result[$k]['type'] = 'forthcoming';
                    $reserve_price = PT_getValueByCode($row['property_id'],'reserve');
                    $result[$k]['price'] = $row['price_on_application'] > 0?'Price On Application':showLowPrice($reserve_price).' - '.showHighPrice($reserve_price);

                    //$result[$k]['price'] = showLowPrice($reserve_price).' - '.showHighPrice($reserve_price);
                    $dt = new DateTime($row['start_time']);
                    $title = 'AUCTION STARTS: '.$dt->format($config_cls->getKey('general_date_format'));
                    $dt = new DateTime($row['end_time']);
                    $title .= '</br>AUCTION ENDS: '.$dt->format($config_cls->getKey('general_date_format'));

                }else{
                    $result[$k]['type'] = 'auction';
                    $dt = new DateTime($row['end_time']);
                    $title = 'AUCTION ENDS: '.$dt->format($config_cls->getKey('general_date_format'));
                }

            } else {
                $result[$k]['type'] = 'sale';
                $title = 'FOR SALE: '.$row['suburb'];

            }

            //$result[$k]['link'] = ROOTURL.'?module=property&action=view-'.$result[$k]['type'].'-detail&id='.$result[$k]['property_id'];
            $result[$k]['link'] = shortUrl(array('module' => 'property','action' => 'email_alert') + array('data' => $row));
            $result[$k]['title'] = $title;
            //END
            //BEGIN FOR MEDIA
            $_media = PM_getPhoto($row['property_id'],true);
            $result[$k]['photo'] = $_media['photo_thumb'];
            $result[$k]['photo_default'] = ROOTURL.'/'.$_media['photo_thumb_default'];
            //END MEDIA
        }
    }
    return $result;
}

function tplEmail($data = array(), $agent_info = array())
{
    $note = (isset($data['description']) AND $data['description'] != '') ? '<span>Note: ' . $data['description'] . '</span>' : "";
    $str = ' <div style="padding-top:0px;width: 430px;">
                    <span style="font-weight: normal;font-size: 13px; color: #2f2f2f;">
   	                    Dear ' . formUnescape($agent_info['firstname']) . ' ' . stripcslashes($agent_info['lastname']) . '
                    </span>
                    <h3 style="font-size: 14px;color: #2f2f2f;">Please see below email for a list of properties that match your email alert.</h3>
                    ' . $note;

    if (is_array($data) and count($data) > 0) {
        foreach ($data as $row) {
            $property_kind = PEO_getKindName($row['kind']);
            $car_space = '';
            $parking = 0;
            if (isset($_POST['search'])) {
                $parking = isset($_POST['search']['parking']) ? $_POST['search']['parking'] : 0;
            }
            $sold = "";
            if ($row['confirm_sold'] == Property::SOLD_COMPLETE) {
                $sold = '<div style="color: rgb(152, 0, 0); font-weight: bold; text-align: center; padding-top: 7px;">SOLD</div>';
            }
            if ($parking != 0 && $row['carport_value']> 0) {
                $car_space = '<span class="car icons" style="color: #017db9;font-size: 15px;
                                        background: url(' . ROOTURL . '/modules/general/templates/images/icons.png) 100% -281px no-repeat;
                                        padding: 2px 23px 2px 0;
                                        background-position: 100% -281px;
                                        margin-right: 3px;">
                             ' . $row['carport_value'] . '
                        </span>
                    ';
            }
            $room = '';
            if ($row['kind'] == 1) {
                $room = $car_space;
            } else {
                if ($row['bedroom_value'] > 0) {
                    $room .= '<span class="bed icons" style="color: #017db9;font-size: 15px;
                                        background: url(' . ROOTURL . '/modules/general/templates/images/icons.png) 100% -240px no-repeat;
                                        padding: 2px 23px 2px 0;
                                        background-position: 100% -240px;
                                        margin-right: 3px;">
                                    ' . $row['bedroom_value'] . '
                                </span>';
                }
                if ($row['bathroom_value'] > 0) {
                    $room .= '<span class="bath icons" style="color: #017db9;font-size: 15px;
                                        background: url(' . ROOTURL . '/modules/general/templates/images/icons.png) 100% -262px no-repeat;
                                        padding: 2px 23px 2px 0;background-position: 100% -262px;margin-right: 3px;">
                                    ' . $row['bathroom_value'] . '
                                    </span>';
                }
                $room .= $car_space . '';
            }
            $str .= '<div style="padding-top:12px; border-bottom: 1px dashed #6B6B6B;height:215px; " >
							<div style="float:left;">
							    <div style="color: #2f2f2f; font-size: 14px; border-bottom-width: 0px; margin-bottom: 10px; margin-left: 0;"> ID: ' . $row['property_id'] . '</div>
								<a href="' . $row['link'] . '">
								    <img src="' . $row['photo_default'] . '" alt="img" style="width:180px;height:115px; border:none;"/>
								</a>
								 ' . $sold . '
							</div>
							<div style="float:right;clear:none;width:55%;">
							      <span style="color:#2f2f2f; font-size:14px;">' . $row['title'] . '</span>
					              <p>' . $row['full_address'] . '</p>
                                  <p>
                                        <span>
                                            Kind : ' . $property_kind . '
                                        </span>
                                  </p>
								  <p style="margin-bottom:0px;">
									 ' . $room . '
								  </p>
                                  <div style="padding-top:20px; float:left;">
                                        <span class="price" style="color: #a1a1a1; font-size: 14px; font-weight: bold;"> ' . $row['price'] . ' </span>
                                  </div>
                                  <div style="float:right; padding-top:15px; ">
                                        <a href="' . $row['link'] . '"><img src="' . ROOTURL . '/modules/general/templates/images/btn-view.png" style="border:none; " /></a>
                                  </div>
						    </div>
				    </div>
                    <div style="clear:both;"></div>';
        }
    }

    $str .= '<div align="center" style="padding-top:20px;width:430px;">
                        <span style="color: #2f2f2f; font-size: 13px; font-weight: normal;float:left;">
                            If you want to view all search results that match your email alert settings please click on the button below Show all matching properties
                        </span>
                        <div style="float:right;margin-top:20px;"><a href="' . $agent_info['full_link'] . '"><img style="border:none; " src="' . ROOTURL . '/modules/general/templates/images/showall.png" /></a></div>

                </div>
               </div>';
    return $str;
}

    function EA_prepareGrid(){
        global $email_cls, $region_cls, $property_entity_option_cls;
        $st = 'SELECT e.*,
	      (SELECT reg1.name FROM '.$region_cls->getTable().' AS reg1 WHERE reg1.region_id = e.state) AS state_name,
	      (SELECT reg2.name FROM '.$region_cls->getTable().' AS reg2 WHERE reg2.region_id = e.country) AS country_name,
	      (SELECT pro_opt1.title
				FROM '.$property_entity_option_cls->getTable().' AS pro_opt1
				WHERE pro_opt1.property_entity_option_id = e.property_type) AS property_name
	       FROM '.$email_cls->getTable().' as e
	       WHERE e.agent_id = '.$_SESSION['agent']['id'].'
	       ORDER BY e.email_id DESC';


	    $rows = $email_cls->getRows($st,true);
        if (is_array($rows) and count($rows)>0){
         foreach ($rows as $k=>$row){
            $email[$k] = $row;
            $email[$k]['full_address'] = $email[$k]['suburb'].' '.$email[$k]['postcode'].' '.$email[$k]['state_name'].' '.$email[$k]['country_name'];
            $email[$k]['property_name'] = ($row['property_name'] == null)?'Any': $row['property_name'];
            $email[$k]['status'] = ($email[$k]['allows'])?'Active':'InActive';
         }
        }
     return $email;
    }

    function setAuctionSale($auction_sale){
        $auction_sale_ar = PEO_getAuctionSale();
        $ref_ar = array(0=>'auction',
                            $auction_sale_ar['private_sale']=>'sale',
                            $auction_sale_ar['auction']=>'agent-auction',
                            $auction_sale_ar['ebidda30']=>'ebidda30',
                            $auction_sale_ar['ebiddar']=>'ebiddar');
        if (is_numeric($auction_sale)){
            return $ref_ar[$auction_sale];
        }
        return $auction_sale;
    }
?>