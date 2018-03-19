<?php
//die('test');
/*die('ROOTURL='.ROOTURL);*/
ini_set('display_errors', 1);
$ROOTURL = ROOTURL;
include_once ROOTPATH.'/modules/general/inc/SMS.class.php';
include_once ROOTPATH.'/modules/general/inc/sms_log.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/modules/general/inc/bids.php';
include_once ROOTPATH.'/includes/class.phpmailer.php';
include_once ROOTPATH.'/modules/banner/inc/banner.php';
include_once ROOTPATH.'/modules/general/inc/bids_mailer.php';
include_once ROOTPATH.'/modules/configuration/inc/config.class.php';
include_once ROOTPATH.'/modules/general/inc/timetable.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent_lawyer.class.php';
include_once ROOTPATH.'/modules/general/inc/email_log.class.php';

if (!isset($property_cls) || !($property_cls instanceof Property)) {
    $property_cls = new Property();
}
if (!isset($property_term_cls) || !($property_term_cls instanceof Property_term)) {
    $property_term_cls = new Property_term();
}
if (!isset($auction_term_cls) || !($auction_term_cls instanceof Auction_terms)) {
    $auction_term_cls = new Auction_terms();
}

if (!isset($log_cls) || !($log_cls instanceof Email_log)) {
    $log_cls = new Email_log();
}
if (!isset($config_cls) || !($config_cls instanceof Config)) {
        $config_cls = new Config();
    }
if (!isset($agent_lawyer_cls) || !($agent_lawyer_cls instanceof Agent_lawyer)) {
	$agent_lawyer_cls = new Agent_lawyer();
}

if (!isset($timetable_cls) || !($timetable_cls instanceof Timetable)) {
        $timetable_cls = new Timetable();
    }

if (!isset($sms_cls) || !($sms_cls instanceof SMS)) {
	$sms_cls = new SMS(array('username' => $config_cls->getKey('sms_username'),
							'password' => $config_cls->getKey('sms_password'),
							'sender_id' => $config_cls->getKey('sms_sender_id'),
							'portal_url' => $config_cls->getKey('sms_gateway_url')));
}

if (!isset($sms_log_cls) || !($sms_log_cls instanceof SMS_log)) {
	$sms_log_cls = new SMS_log();
}

$schedule_cron = (int)$config_cls->getKey('notification_schedule_cron'); // Loop Cron with minute/hour
$schedule_cron = isset($schedule_cron) ? $schedule_cron : 0 ;
$schedule_sec = round($schedule_cron*60/2);


/**
> BEGIN : IBB-392
=================
	Description:
	-----------
		Bidder Reminder function for Forthcoming Auctions
		We need to add a option for Bidders to add an automatic reminder (by email or sms) 
		1 day before a Forthcoming Auction becomes a Live Auction
	
**/
        $auction_sale_ar = PEO_getAuctionSale();
        $b_time = date("Y-m-d H:i:s", mktime(date('H') + 24, date('i'), date('s') - $schedule_sec, date('m'), date('d'), date('Y')));
        $e_time = date("Y-m-d H:i:s", mktime(date('H') + 24, date('i'), date('s') + $schedule_sec, date('m'), date('d'), date('Y')));

        $rows = $property_cls->getRows('SELECT pro.*
                                        FROM '.$property_cls->getTable().' as pro
                                        WHERE 1
                                            AND auction_sale != '.$auction_sale_ar['private_sale']."
                                            AND stop_bid = 0
                                            AND confirm_sold = 0
                                            AND start_time BETWEEN '".$b_time."' AND '".$e_time."'
                                            AND active = 1
                                            AND agent_active = 1
                                            AND IF(hide_for_live = 1 AND start_time > '".date('Y-m-d H:i:s')."' , 0, 1) = 1
                                            AND pay_status = ".Property::CAN_SHOW.'
                                            AND IF (pro.auction_sale != '.$auction_sale_ar['private_sale'].'
                                                    AND (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\',0,pro_term.value)
                                                                 FROM '.$property_term_cls->getTable().' AS pro_term
                                                                 LEFT JOIN '.$auction_term_cls->getTable().' AS term
                                                                    ON pro_term.auction_term_id = term.auction_term_id
                                                                 WHERE term.code = \'auction_start_price\'
                                                                    AND pro.property_id = pro_term.property_id )
                                                            AND  (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\',0,pro_term.value)
                                                                 FROM '.$property_term_cls->getTable().' AS pro_term
                                                                 LEFT JOIN '.$auction_term_cls->getTable().' AS term
                                                                    ON pro_term.auction_term_id = term.auction_term_id
                                                                 WHERE term.code = \'reserve\'
                                                                    AND pro.property_id = pro_term.property_id )
                                                            AND  IF((SELECT pro_term.value
                                                                 FROM '.$property_term_cls->getTable().' AS pro_term
                                                                 LEFT JOIN '.$auction_term_cls->getTable().' AS term
                                                                    ON pro_term.auction_term_id = term.auction_term_id
                                                                 WHERE term.code = \'auction_start_price\'
                                                                    AND pro.property_id = pro_term.property_id )
                                                                 >
                                                                 (SELECT pro_term.value
                                                                 FROM '.$property_term_cls->getTable().' AS pro_term
                                                                 LEFT JOIN '.$auction_term_cls->getTable().' AS term
                                                                    ON pro_term.auction_term_id = term.auction_term_id
                                                                 WHERE term.code = \'reserve\'
                                                                    AND pro.property_id = pro_term.property_id ),0,1)
                                                            = 0, 0, 1) = 1 ',true

        );

        if (is_array($rows) && count($rows) > 0) {
            $link_ar = array();
            $id_ar = array('id' => array(),'banner' => array());
            $time_str = 'on tomorrow';
            foreach ($rows as $row) {
                $link_ar[] = ROOTURL.'/?module=property&action=view-forthcoming-detail&id='.$row['property_id'];
                $id_ar['id'][] = $row['property_id'];
                $id_ar['banner'][] = getBannerByPropertyId($row['property_id']);
            }

            foreach( $id_ar['id'] as $key => $property_id)
            {
                $info = getInfoReminder($property_id,'forthcoming-notifications');
                //BEGIN send EMail
                if(count($info['email']) > 0)
                {
                    $msg = $config_cls->getKey('email_bidder_remind_msg');
                    $subject = $config_cls->getKey('email_bidder_remind_msg_subject');
                    $link = '<a href="'.ROOTURL.'/?module=property&action=view-auction-detail&id='.$property_id.'">'.ROOTURL.'?module=property&action=view-auction-detail&id='.$property_id.'</a>';
                    $msg = str_replace(array('[ID]','[link]','[rooturl]'),array($property_id,$link,$time_str),$msg);
                    //$title = ' Reminder: Forthcoming Auction [ID] will become a Live Auction in tomorrow.';
                    $title = $subject;
                    $title = str_replace('[ID]',$property_id,$title);
                    sendEmail($config_cls->getKey('general_contact_email'), $info['email'], $msg,$title, $id_ar['banner'][$key]);
                    $log_cls->createLog('remind');
                }
                //End
                //Begin send SMS
                if (count($info['sms']) > 0) {
                    $msg = $config_cls->getKey('sms_bidder_remind_msg');
                    $msg = preg_replace(array('{property_ids}','{remain_time}'),array(implode(', ',$id_ar),$time_str),$msg);
                    sendSMS($msg, $info['sms']);
                }
                //ENd
            }//END FOREACH
        }

/**
> END : IBB-392
**/


/**
> BEGIN : IBB-174
=================
	Description:
	------------
		Auction ending notifications
		intervals: 5 days, 2 days, 1 day, 12 hours, 6 hours, 3 hours, 1 hour, 30 minutes.
		before the end of the Auction as the default

**/

        $hour_ar = array(5 * 24, 2 * 24, 1 * 24, 12, 6, 3, 1, 0);
        $minute_ref_ar = array( 5 * 24 * 60 => '5 days',
                                2 * 24 * 60 => '2 days',
                                1 * 24 * 60 => '1 day',
                                12 * 60 => '12 hours',
                                6 * 60 => '6 hours',
                                3 * 60 => '3 hours',
                                1 * 60 => '1 hour',
                                30 => '30 minutes',
                                0 => '30 minutes');

        $wh_ar = array();
        foreach ($hour_ar as $hour) {
            $b_time = date("Y-m-d H:i:s", mktime(date('H') + $hour, date('i'), date('s') - $schedule_sec , date('m'), date('d'), date('Y')));
            $e_time = date("Y-m-d H:i:s", mktime(date('H') + $hour, date('i'),date('s') + $schedule_sec, date('m'), date('d'), date('Y')));
            //print_r('hour: '.$hour.'<br> b_time :'.$b_time.'<br>e_time:'.$e_time.'<br>sec :'.$schedule_sec);

            $wh_ar[] = "( end_time BETWEEN '".$b_time."' AND '".$e_time."' )";
        }             
        $rows = $property_cls->getRows('auction_sale != '.$auction_sale_ar['private_sale'].'
                                        AND stop_bid = 0
                                        AND ('.implode(' OR ',$wh_ar).')
                                        AND active = 1
                                        AND agent_active = 1
                                        AND IF(hide_for_live = 1 AND start_time > \''.date('Y-m-d H:i:s').'\' , 0, 1) = 1
                                        AND pay_status = '.Property::CAN_SHOW);


        //die(print_r($property_cls->sql));
        if (is_array($rows) && count($rows) > 0) {
            $email_info_ar = array();
            $email_info_data = array();
            $sms_info_ar = array();
            foreach ($rows as $row) {
                if(PE_isLiveAuction($row['property_id']))
                {
                    $time_str = '';
                    $minute = remainTime($row['end_time'], date('Y-m-d H:i:s'))/60;


                    foreach ($minute_ref_ar as $value => $title) {
                        if ( (($value - $schedule_cron) <= $minute ) && ($minute < ($value + $schedule_cron)) ) {
                            $time_str = $title;
                            break;
                        }
                    }
                    if ($minute <= 5)
                    {
                        $time_str = '5 minutes';
                    }

                    if (strlen($time_str) > 0) {
                        $email_info = array('ID' => $row['property_id'],'remain_time' => $time_str);
                        $email_info_data[] = $email_info;

                        $email_info_ar[] = $ROOTURL.'/?module=property&action=view-auction-detail&id='.$row['property_id'].' will be finished in '.$time_str;
                        $sms_info_ar[] = 'ID: '.$row['property_id'].' will be finished in '.$time_str;
                    }
                }
            }
            //die (print_r($email_info_data));
            //$info = array('email' => array(), 'sms' => array());
            if (count($email_info_data) > 0) {

                foreach($email_info_data as $key => $email_info_pro)
                {
                    $id = $email_info_pro['ID'];
                    $info = getInfoReminder($id,'ending-notifications');
                    if(count($info['email']) > 0 )
                    {
                        if($email_info_pro['remain_time'] != '5 minutes')
                        {
                            // For send email
                            if( true )
                            {

                                $lkB = addBanner($id);
                                $msg = $config_cls->getKey('email_bidder_prompt_msg');
                                $link = $ROOTURL.'/?module=property&action=view-auction-detail&id='.$email_info_pro['ID'];
                                $link = '<a href="'.$link.'">'.$link.'</a> ';
                                $subject = $config_cls->getKey('email_bidder_prompt_msg_subject');
                                $msg = str_replace(array('[ID]','[link]','[remain_time]'),array($email_info_pro['ID'],$link,$email_info_pro['remain_time']),$msg);
                                sendEmail($config_cls->getKey('general_contact_email'),$info['email'], $msg,$subject, $lkB);
                                $log_cls->createLog('notify');
                            }
                            // For send SMS
                        }
                    }
                    //SEND SMS
                    if (count($info['sms']) > 0) {
                        $msg = $config_cls->getKey('sms_bidder_prompt_msg');
                        $msg = preg_replace(array('{info}'),$sms_info_ar[$key],$msg);
                        sendSMS($msg, $info['sms']);
                    }

                }
            }
        }

/**     Sent Bid Email :  Description
        ===============
        Send email/SMS to Last bidder, vendor and another people when property had been bid.
**/

        /*if (!isset($bids_mailer_cls) || !($bids_mailer_cls instanceof Bids_mailer)) {
            $bids_mailer_cls = new Bids_mailer();
        }

        $rows = $bids_mailer_cls->getRows('SELECT *
                                            FROM '.$bids_mailer_cls->getTable().'
                                            WHERE sent = 0
                                            ORDER BY bid_time ASC
                                            ',true);

        if(is_array($rows) and count($rows) > 0 )
        {
            foreach($rows as $row)
            {
                if(Cron_BidSMSEmail($row['property_id'],$row['agent_id'],$row['email'],$row['bid_price'],$row['bid_time'],$row['auto_bid']))
                {
                    $bids_mailer_cls->update(array('sent'=>1),'bids_mailer_id='.$row['bids_mailer_id']);
                }

            }
        }
            $bids_mailer_cls->delete('sent=1');*/

//End   Sent Bid Email


/**
> END : IBB-174 

        Description
        ===============
        Send email/SMS to bidder, vendor and another people when property stop bid.

**/
    $main_key = 'notification_auction';

    $timetable_cls->update(array('begin_time' => date('Y-m-d H:i:s')), "`key` = '".$main_key."'");
    $scan = true;


    if (true) {
        $auction_sale_ar = PEO_getAuctionSale();
        $rows = $property_cls->getRows("auction_sale != ".$auction_sale_ar['private_sale']."
                                        AND scan = 0
                                        AND stop_bid = 1
                                        AND active = 1
                                        AND confirm_sold = 1
                                        AND agent_active = 1
										AND IF(hide_for_live = 1 AND start_time > '".date('Y-m-d H:i:s')."' , 0, 1) = 1
										AND pay_status = ".Property::CAN_SHOW."
                                        AND (SELECT pro_term.value
											FROM ".$property_cls->getTable('property_term')." AS pro_term 
											LEFT JOIN ".$property_cls->getTable('auction_terms')." AS term
												ON pro_term.auction_term_id = term.auction_term_id
											WHERE term.code = 'reserve' AND a.property_id = pro_term.property_id
											)
											<=
                             			    (SELECT max(price) FROM ".$property_cls->getTable('bids')." WHERE a.property_id = bids.property_id)
                             			AND (
                             			    (SELECT agent_id FROM ".$property_cls->getTable('bids')."
                             			        WHERE a.property_id = bids.property_id
                             			        ORDER BY time DESC
                             			        LIMIT 0,1)
                             			    != a.agent_id
                             			)
                             			    "
        );
        if (is_array($rows) && count($rows) > 0) {
            foreach ($rows as $row) {
                if(!isset($row['property_id']) OR $row['property_id'] <=0){
                    continue;
                }
                $property_cls->update(array('scan' => 1),'property_id = '.$row['property_id']);
                
                $cron = new cron2($row);
                try{
                        $cron->scanVendor($row);
                        $cron->scanLawyer($row);
                        $cron->sendVendor($row);
                        $cron->sendLawyer($row);
                        $cron->scanBidder($row);
                        $cron->scanWatchlist($row);
                        $cron->sendWinner($row);
                        $cron->sendReceiver($row);
                }
                catch(Exception $er){
                    print_r($er);
                    die ();
                }
            }//end foreach
        }

    }//end if scan


    /*IBB-1181: NHUNG
      All properties posted on iBB should be automatically posted to the iBB Facebook page when the property is activated online by iBB*/
    include_once ROOTPATH.'/modules/facebook-twitter/inc/fb.facebook.class.php';
    include_once ROOTPATH.'/modules/facebook-twitter/inc/twitter.class.php';

    if (!isset($fb_cls) || !($fb_cls instanceof Facebook)) {
        $fb = array('appId' => $config_cls->getKey('facebook_application_api_id'),
                    'secret' => $config_cls->getKey('facebook_application_secret'));
        $fb_cls = new Facebook($fb);
    }


    //POST ENTRY TO FACEBOOK, TWITTER
    $fb_info = array('uid'=>$config_cls->getKey('facebook_fanpage_id'),
                     'token'=>$config_cls->getKey('facebook_fanpage_token'));

    
    $wh_arr = array();
    //HIDE AGENT's PROPERTIES DIDN'T PAYMENT
    $wh_arr[] = " IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at
                                       WHERE agt.type_id = at.agent_type_id) IN ('agent')
                                       ,(SELECT ap.payment_id FROM " . $agent_payment_cls->getTable() . " AS ap
                                         WHERE ap.agent_id = IF(agt.parent_id = '',agt.agent_id,agt.parent_id)
                                               AND ap.date_from <= '" . date('Y-m-d H:i:s') . "' AND ap.date_to >= '" . date('Y-m-d H:i:s') . "'
                                         ) != ''
                                       ,1)";
    //DON'T ALLOW SHOW PROPERTIES OF INACTIVE AGENT
    $wh_arr[] = " IF(ISNULL(pro.agent_manager) || pro.agent_manager = '' || pro.agent_manager = 0
                            , agt.is_active = 1
                            ,(SELECT a.is_active FROM " . $agent_cls->getTable() . " AS a WHERE a.agent_id = pro.agent_manager) = 1)
                            ";

    //DON'T POST THEBLOCK'S PROPERTTY
    $wh_arr[] = ' (SELECT agtype.title
                       FROM '.$agent_cls->getTable('agent_type')." AS agtype
                       WHERE agtype.agent_type_id = agt.type_id) != 'theblock'";

    $wh_str = count($wh_arr) > 0 ? ' AND ' . implode(' AND ', $wh_arr) : '';

    $rows = $property_cls->getRows('SELECT pro.property_id,
                                           pro.suburb,
                                           pro.postcode,
                                           pro.description,
                                           pro.address,

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
										   ) AS country_name
                                    FROM '.$property_cls->getTable().' AS pro
                                    INNER JOIN '.$property_cls->getTable('agent').' AS agt
													ON pro.agent_id = agt.agent_id
                                    WHERE pro.active = 1
                                          AND pro.agent_active = 1
                                          AND pro.stop_bid = 0
                                          AND pro.confirm_sold = 0
                                          AND pro.post = 1
                                          AND pro.pay_status = '.Property::CAN_SHOW.'
                                          AND IF (pro.auction_sale != ' . $auction_sale_ar['private_sale'] . ',
                                                   (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\'
                                                           ,0
                                                           ,pro_term.value)
                                                   FROM ' . $property_term_cls->getTable() . ' AS pro_term
                                                   LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
                                                   ON pro_term.auction_term_id = term.auction_term_id
                                                   WHERE term.code = \'auction_start_price\'
                                                   AND pro.property_id = pro_term.property_id ) != 0
                                            , 1)'

                                          .$wh_str,true);
    //AND pro.start_time <= \''.date('Y-m-d H:i:s').'\''
    //print_r($rows);die('End');
    if (is_array($rows) and count($rows) > 0){
       foreach ($rows as $row){
               $_photo = PM_getPhoto($row['property_id']);
               $photo = $_photo['photo_default'];
               $link_ar = array('module' => 'property',
                                 'action' => '',
                                 'id' => $row['property_id']);
               $link_ar['action'] = 'view-auction-detail';

               $link = shortUrl($link_ar + array('data' => $row),
                                (PE_isTheBlock($row['property_id'],'agent')?Agent_getAgent($row['property_id']):array()));

               $content = array('message' => '',
                                'name' => $row['address'].', '.implode(' ',array($row['suburb'], $row['state_code'], $row['postcode'], $row['country_name'])),
                                'caption' => ROOTURL,
                                'link' => $link,
                                'description' => strip_tags($row['description']),
                                'picture' =>MEDIAURL.'/'.$photo);

               $fb_cls->postFull($content,$fb_info);
               $property_cls->update(array('post'=>1),'property_id = '.$row['property_id']);
       }
    }


class cron2 {

	private $win_ar = array();
	private $email_ctn = array('receiver' => array(), 'vendor' => array(), 'lawyer' => array());
	private $sms_ctn = array('receiver' => array(), 'vendor' => array(), 'lawyer' => array() );
	private $objs = array();
    private $data = array();
	public function __construct($data = array()) {

		global $agent_cls, $bid_cls, $watchlist_cls, $config_cls;
		$this->objs['agent_cls'] &= $agent_cls;
		$this->objs['bid_cls'] &= $bid_cls;
		$this->objs['watchlist_cls'] &= $watchlist_cls;
		$this->objs['config_cls'] &= $config_cls;
        $this->data = $data;
	}
    public  function  showData(){
        echo "<br>--Data: ".print_r_pre($this->data).'<br>';
        echo "<br>--win: ".print_r_pre($this->win_ar).'<br>';
        echo "<br>--email_ctn: ".print_r_pre($this->email_ctn).'<br>';
        echo "<br>--SMS: ".print_r_pre($this->sms_ctn).'<br>';
        echo "<br>--obj: ".print_r_pre($this->objs).'<br>';
    }
	/**
	function : scanVendor
	**/
	public function scanVendor($data = array()) {
        global $agent_cls;
        if(!isset($data['agent_id']))
            $data['agent_id'] = 0;

        $agent_row = $agent_cls->getRow("SELECT a.*
										FROM  ".$agent_cls->getTable()." AS a , ".$agent_cls->getTable('agent_type')." AS a_t
										WHERE a.type_id = a_t.agent_type_id
												AND a_t.title = 'vendor'
												AND a.agent_id = ".$data['agent_id']."
												AND a.is_active = 1",true);
        //print_r($agent_cls->sql);

		if (is_array($agent_row) && count($agent_row) > 0) {
			if ($agent_row['notify_email'] == 1) {
				$this->email_ctn['vendor'] = $agent_row;
			}

			if ($agent_row['notify_sms'] == 1) {
				$this->sms_ctn['vendor'] = $agent_row;
			}
		}

		return $this;
	}

    /**
        function : scanLawyer
        **/
	public function scanLawyer($data = array()) {
        global $agent_cls;
        if(!isset($data['agent_id']))
            $data['agent_id'] = 0;
        $agent_row = $agent_cls->getRow("SELECT a_l.*,a.notify_email,a.notify_sms,a.allow_lawyer
										FROM  ".$agent_cls->getTable()." AS a , ".$agent_cls->getTable('agent_lawyer')." AS a_l
										WHERE a_l.agent_id = a.agent_id
                                            AND a.agent_id = ".$data['agent_id']."
                                            AND a.is_active = 1",true);

		if (is_array($agent_row) && count($agent_row) > 0) {
			if ($agent_row['allow_lawyer'] == 1) {
				$this->email_ctn['lawyer'] = $agent_row;
			}

			if ($agent_row['allow_lawyer'] == 1) {
				$this->sms_ctn['lawyer'] = $agent_row;
			}
		}

		return $this;
	}
    public function  scanWinnerBidder($data = array()){
        global $agent_cls, $bid_cls;
        //
        $row = Bid_getLastBidByPropertyId((int)$data['property_id']);
        if(count($row) > 0 and is_array($row))
        {
            $winner_email= A_getEmail($row['agent_id']);
            $this->win_ar['email_address'] = $winner_email;
            $this->win_ar['winner_name'] = A_getFullName($row['agent_id']);
        }
        return $this;
    }
	/**
	function : scanBidder
	**/
	public function scanBidder($data = array()) {
        global $agent_cls, $bid_cls;
        $this->scanWinnerBidder($data);
        $bid_rows = $bid_cls->getRows('SELECT DISTINCT agt.agent_id, agt.email_address, agt.mobilephone,
													  agt.notify_email, agt.notify_sms, agt.firstname, agt.lastname
									FROM '.$agent_cls->getTable().' AS agt,'.$bid_cls->getTable().' AS bid
									WHERE agt.agent_id = bid.agent_id
											AND agt.is_active = 1
											AND bid.property_id = '.(int)@$data['property_id'].' ORDER BY bid.price DESC',true);


		if (is_array($bid_rows) && count($bid_rows) > 0) {
			foreach ($bid_rows as $bid_row) {
                if(strcasecmp($bid_row['email_address'],@$this->win_ar['email_address']) != 0)
                {
					if ($bid_row['notify_email'] == 1) {
						$this->email_ctn['receiver'][] = $bid_row['email_address'];
					}

					if ($bid_row['notify_sms'] == 1 && strlen(trim($bid_row['mobilephone'])) > 0) {
						$this->sms_ctn['receiver'][] = $bid_row['mobilephone'];
					}
                }

			}//end foreach
		}//end if



		return $this;
	}

	/**
	function : scanWatchlist
	**/
	public function scanWatchlist($data = array()) {
        global $agent_cls, $watchlist_cls;
        $watchlist_rows = $watchlist_cls->getRows('SELECT DISTINCT agt.email_address, agt.mobilephone, agt.notify_email,
																agt.notify_sms, agt.firstname, agt.lastname
																FROM '.$watchlist_cls->getTable().' AS wl,'.$agent_cls->getTable().' AS agt
																WHERE wl.agent_id = agt.agent_id
																		AND agt.is_active = 1
																		AND wl.property_id = '.$data['property_id'],true);


		if (is_array($watchlist_rows) && count($watchlist_rows) > 0) {
			foreach ($watchlist_rows as $wl_row) {

				if (strcasecmp($wl_row['email_address'],@$this->win_ar['email_address']) != 0 ) {

					if ($wl_row['notify_email'] == 1) {
						$this->email_ctn['receiver'][] = $wl_row['email_address'];
					}

					if ($wl_row['notify_sms'] == 1 && strlen(trim($wl_row['mobilephone'])) > 0) {
						$this->sms_ctn['receiver'][] = $wl_row;
					}

				}
			}//end foreach
		}//end if

		return $this;
	}

    public function replaceInfo($msg = ''){
        $address = PE_getAddressProperty($this->data['property_id']);
        $vendor_name = $this->email_ctn['vendor']['firstname'] .' '.$this->email_ctn['vendor']['lastname'];
        $lawyer_name = $this->email_ctn['lawyer']['firstname'] .' '.$this->email_ctn['lawyer']['lastname'];
        $winner_name = $this->win_ar['winner_name'];
        $buyer_name = ' member';
        $data = array("[ID]","[address]","[buyer_name]","[agent_name]","[lawyer_name]","[winner_name]", "[vendor_name]");
        $data_rel = array($this->data['property_id'],$address,$buyer_name,$vendor_name,$lawyer_name,$winner_name, $vendor_name);
        return str_replace($data,$data_rel,$msg);
    }

	/**
	function : sendVendor
	**/
	public function sendVendor($data = array()) {

		global $config_cls,$property_cls,$banner_cls,$log_cls;
		$email_from = $config_cls->getKey('general_contact_email');

		if (is_array($this->email_ctn['vendor']) && count($this->email_ctn['vendor']) > 0) {
            $lkB = addBanner($data['property_id']);

            $subject = $config_cls->getKey('email_vendor_stop_bid_msg_subject');
            $subject = $this->replaceInfo($subject);
            $msg = $config_cls->getKey('email_vendor_stop_bid_msg');
            $msg = $this->replaceInfo($msg);
            sendEmail($email_from,$this->email_ctn['vendor']['email_address'],$msg,$subject,$lkB);

            //include_once ROOTPATH.'/modules/general/inc/email_log.class.php';
            $log_cls->createLog('notify');
            
            //die (print_r($this->email_ctn['vendor']['email_address']));
		}

		if (is_array($this->sms_ctn['vendor']) && count($this->sms_ctn['vendor']) > 0) {
			$msg = $config_cls->getKey('sms_vendor_stop_bid_msg');
			$msg = str_replace(array('{property_id}'),array($data['property_id']),$msg);
            $msg = str_replace(array('[ID]'),array($data['property_id']),$msg);
			$to = $this->sms_ctn['vendor']['mobilephone'];

			sendSMS($msg,$to);
		}

		return $this;
	}

/**
	function : sendLawyer
	**/
	public function sendLawyer($data = array()) {
		global $config_cls,$property_cls,$banner_cls,$log_cls;
		$email_from = $config_cls->getKey('general_contact_email');

		if (is_array($this->email_ctn['lawyer']) && count($this->email_ctn['lawyer']) > 0) {
            $lkB = getBannerByPropertyId($data['property_id']);
            $subject = $config_cls->getKey('email_lawyer_stop_bid_msg_subject');
            $subject = $this->replaceInfo($subject);
            $msg = $config_cls->getKey('email_lawyer_stop_bid_msg');
            $msg = $this->replaceInfo($msg);
			sendEmail($email_from,$this->email_ctn['lawyer']['email'],$msg,$subject,$lkB);
            $log_cls->createLog('notify');
		}

		if (is_array($this->sms_ctn['vendor']) && count($this->sms_ctn['vendor']) > 0) {
			$msg = $config_cls->getKey('sms_vendor_stop_bid_msg');
			$msg = str_replace(array('{property_id}'),array($data['property_id']),$msg);
            $msg = str_replace(array('[ID]'),array($data['property_id']),$msg);
			$to = $this->sms_ctn['lawyer']['mobilephone'];
			sendSMS($msg,$to);
		}

		return $this;
	}

	/**
	function : sendWinner
	**/
	public function sendWinner($data = array()) {
        global $config_cls,$property_cls,$banner_cls,$log_cls;
		if (is_array($this->win_ar) && count($this->win_ar) > 0) {
            $lkB = getBannerByPropertyId($data['property_id']);
			$msg = $config_cls->getKey('email_winner_stop_bid_msg');
            $msg = $this->replaceInfo($msg);
            $email_from = $config_cls->getKey('general_contact_email');
            $subject = $config_cls->getKey('email_winner_stop_bid_msg_subject');
            $subject = $this->replaceInfo($subject);
            sendEmail($email_from,$this->win_ar['email_address'],$msg,$subject,$lkB);
            echo 'sendWinner';
            $log_cls->createLog('notify');
			$to = $this->win_ar['mobilephone'];
			sendSMS($msg,$to);
		}

		return $this;
	}

	/**
	function : sendReceiver ( people who in watchlist)
	**/
	public function sendReceiver($data = array()) {
        global $config_cls,$property_cls,$banner_cls,$log_cls;
        $email_from = $config_cls->getKey('general_contact_email');
		if (is_array($this->email_ctn['receiver']) && count($this->email_ctn['receiver']) > 0) {
            $lkB = getBannerByPropertyId($data['property_id']);
            $msg = $config_cls->getKey('email_agent_stop_bid_msg');
            $msg = $this->replaceInfo($msg);
            $subject = $config_cls->getKey('email_agent_stop_bid_msg_subject');
            $subject = $this->replaceInfo($subject);
			sendEmail($email_from,$this->email_ctn['receiver'],$msg,$subject,$lkB);
            $log_cls->createLog('notify');
            //die('Test'.$this->email_ctn['receiver'][0].'Mess='.$msg.' watchlist ='.$this->email_ctn['receiver'][1]);
		}

		if (is_array($this->sms_ctn['receiver']) && count($this->sms_ctn['receiver']) > 0) {

			$to = array();
			foreach ($this->sms_ctn['receiver'] as $receiver) {
				$to[] = $receiver['mobilephone'];
			}

			$msg = $config_cls->getKey('sms_agent_stop_bid_msg');
            $msg = str_replace(array('[ID]'),array($data['property_id']),$msg);
			$msg = preg_replace(array('{property_id}'),array($data['property_id']),$msg);

			sendSMS($msg,$to);
		}

		return $this;
	}
}//end class

/*function sendSMS($text, $to) {
	global $sms_cls, $sms_log_cls, $config_cls;
	$sms_enable = $config_cls->getKey('sms_enable');
	if ($sms_enable == 1) {
		$sms_cls->send($text,$to);
		$sms_cls->parseResponse();
		$sms_log_cls->insert(array('message' => $text,'created_at' => date('Y-m-d H:i:s'),'status' => $sms_cls->getStatus()));
	}
}*/

function getBidder($property_id) {
    global $agent_cls, $bid_cls;
    $bidder = array('email'=>array(),'sms'=>array());

    if($property_id > 0)
    {
        $bid_rows = $bid_cls->getRows('SELECT DISTINCT agt.email_address, bid.price, agt.mobilephone,
                                                      agt.notify_email, agt.notify_sms, agt.firstname, agt.lastname
                                    FROM '.$bid_cls->getTable().' AS bid,'.$agent_cls->getTable().' AS agt
                                    WHERE bid.agent_id = agt.agent_id
                                            AND agt.is_active = 1
                                            AND property_id = '.$property_id.'
                                    ORDER BY bid.price DESC',true);


        if (is_array($bid_rows) && count($bid_rows) > 0) {

            foreach ($bid_rows as $bid_row) {

                    if ($bid_row['notify_email'] == 1) {
                        $bidder['email'][] = $bid_row['email_address'];
                    }

                    if ($bid_row['notify_sms'] == 1 && strlen(trim($bid_row['mobilephone'])) > 0) {
                        $bidder['sms'][]= $bid_row['mobilephone'];
                    }
            }//end foreach
        }//end if
    }

    return $bidder;
}

/**
@function : Cron_BidSMSEmail
**/


function Cron_BidSMSEmail($property_id,$bid_id,$agent_email,$agent_price,$bid_time,$is_autobid = 0) {

    include_once ROOTPATH.'/modules/facebook-twitter/inc/twitter.class.php';
    include_once ROOTPATH.'/modules/general/inc/report_email.php';
    include_once ROOTPATH.'/modules/banner/inc/banner.php';

    global $property_cls,$agent_cls,$bid_cls,$config_cls,$fb_cls,$tw_cls,$banner_cls,$log_cls;
    
	$sms_enable = $config_cls->getKey('sms_enable');
	include_once ROOTPATH.'/modules/general/inc/SMS.class.php';
	include_once ROOTPATH.'/modules/general/inc/sms_log.class.php';

	if (!isset($sms_log_cls) || !($sms_log_cls instanceof SMS_log)) {
		$sms_log_cls = new SMS_log();
	}


	if (!isset($sms_cls) || !($sms_cls instanceof SMS)) {
		$sms_cls = new SMS(array('username' => $config_cls->getKey('sms_username'),
								 'password' => $config_cls->getKey('sms_password'),
								 'sender_id' => $config_cls->getKey('sms_sender_id'),
								 'portal_url' => $config_cls->getKey('sms_gateway_url')));
	}

	$vendor = array();
	$to_ar = array();

	//BEGIN Send Email when Property had been bidded To Vendor
    if($is_autobid == 0) // Not is bid set by auto bid
        $vendor_row = $agent_cls->getRow('SELECT pro.*,
                                                 agt.notify_sms,
                                                 agt.mobilephone,
                                                 agt.notify_email,
                                                 agt.notify_email_bid,
                                                 agt.email_address,
                                                 agt.firstname,
                                                 agt.lastname
                                        FROM '.$agent_cls->getTable().' AS agt,'.$property_cls->getTable().' AS pro
                                        WHERE agt.agent_id = pro.agent_id AND pro.property_id = '.$property_id,true);
        if (is_array($vendor_row) && count($vendor_row) > 0) {
            if ($vendor_row['notify_sms'] == 1 && strlen(trim($vendor_row['mobilephone'])) > 0) {
                $vendor['mobilephone'] = $vendor_row['mobilephone'];
            }

            if ($vendor_row['notify_email_bid'] == 1) {
                $vendor['email_address'] = $vendor_row['email_address'];
                $vendor['username'] = $vendor_row['firstname'].' '.$vendor_row['lastname'];
            }
        }
        if (is_array($vendor) && count($vendor) > 0) {
            if ($sms_enable == 1 && isset($vendor['mobilephone'])) {
                $text = $config_cls->getKey('sms_vendor_msg');
                $text = str_replace('{property_id}',$property_id,$text);
                sendSMS($text,$vendor['mobilephone']);
                //$sms_cls->send($text,);
                $sms_cls->parseResponse();
                $msg = $text."<br/> TO ".$vendor['email_address'].'-'.$vendor['mobilephone']."<br/> RESPONSE :".$sms_cls->getResponse();
                $sms_log_cls->insert(array('message' => $msg,'created_at' => date('Y-m-d H:i:s'),'status' => $sms_cls->getStatus()));
            }
            if (isset($vendor['email_address'])) {
                $text = $config_cls->getKey('email_vendor_msg');
                $subject = $config_cls->getKey('email_vendor_msg_subject');
                $rooturl = '<a href="'.ROOTURL.'">'.ROOTURL.'</a>';
                $text = str_replace(array('[ID]','[username]','[rooturl]'),array($property_id,$vendor['username'],$rooturl),$text);
                $banner = addBanner($property_id);
                //SendEmail($config_cls->getKey('general_contact_email'),$vendor['email_address'],$text,$subject, $banner);
                $log_cls->createLog('cron_bid');

            }
        }
    //END Send Email To Vendor

	//BEGin SEND MAIL To Bidder
	$bidder_rows = $agent_cls->getRows('SELECT DISTINCT
											agt.agent_id,
											agt.notify_sms,
											agt.mobilephone,
											agt.notify_email,
											agt.notify_email_bid,
											agt.allow_facebook,
											agt.allow_twitter,
											agt.email_address
										FROM '.$agent_cls->getTable().' AS agt,'.$bid_cls->getTable().' AS bid
										WHERE agt.agent_id = bid.agent_id
										AND bid.time <= \''.$bid_time.'\'
										AND bid.property_id = '.$property_id,true);
	if (is_array($bidder_rows) && count($bidder_rows) > 0) {
		foreach ($bidder_rows as $bidder) {
			$_ar = array();
			if ($bidder['notify_sms'] == 1 && strlen(trim($bidder['mobilephone'])) > 0) {
				$_ar['mobilephone'] = $bidder['mobilephone'];

			}

			if ($bidder['notify_email_bid'] == 1) {
                if($bidder['email_address'] != $agent_email)
                {
                    $_ar['email_address'] = $bidder['email_address'];
                    $_ar['name_member'] = A_getFullName($bidder['agent_id']);
                }
			}

			if (count($_ar) > 0) {
				$to_ar[] = $_ar;
			}
		}
	}
    $lkB = addBanner($property_id);
    // Send mail To Vendor when there Property had been bid
    
    //die('Test='.$text);

     // Begin Send mail to bidder (Email Last bidder confirm and Email another Bidder)
	if (is_array($to_ar) && count($to_ar) > 0) {
		$to = array();
		$email_ar = array();
		$msg = '';
		foreach ($to_ar as $item) {
            $data =array();
			$to[] = $item['mobilephone'];
            $data['email_address'] = $item['email_address'];
            $data['name_member'] = $item['name_member'];
			$email_ar[]= $data ;
			if (strlen($msg) > 0) {
				$msg .= '<->';
			}
			$msg .= $item['email_address'].'-'.$item['mobilephone'];
		}

		$text = $config_cls->getKey('sms_bidder_msg');
		$text = str_replace(array('{property_id}','{$username}'),array($property_id,'you'),$text);

		if ($sms_enable == 1) {
            sendSMS($text,$to);
			//$sms_cls->send($text,$to);
			$sms_cls->parseResponse();
			$msg = $text."<br/>".$msg."<br/> RESPONSE :".$sms_cls->getResponse();
			$sms_log_cls->insert(array('message' => $msg,'created_at' => date('Y-m-d H:i:s'),'status' => $sms_cls->getStatus()));
		}

        //Begin send Email confirm Bid successful to last bidder
        $user_name = A_getFullName($bid_id);
		$text = $config_cls->getKey('email_bid_confirm_msg');
        $subject = $config_cls->getKey('email_bid_confirm_msg_subject');
        $link = '<a href="'.ROOTURL.'/?module=property&action=view-auction-detail&id='.$property_id.'">'.ROOTURL.'?module=property&action=view-auction-detail&id='.$property_id.'</a>';
		$text = str_replace(array('[ID]','[username]','[link]','[price]'),array($property_id,$user_name,$link,showPrice($agent_price)),$text);
        sendEmail_func($config_cls->getKey('general_contact_email'),$agent_email,$text,$subject,$lkB);
        $log_cls->createLog('bid');
        //End
        
		//Send for another bidder
		foreach($email_ar as $email_addr)
		{
				$content = $config_cls->getKey('email_bidder_msg');
                $subject = $config_cls->getKey('email_bidder_msg_subject');
				$link = '<a href="'.ROOTURL.'?module=property&action=view-auction-detail&id='.$property_id.'">'.ROOTURL.'?module=property&action=view-auction-detail&id='.$property_id.'</a>';
				$rooturl = '<a href="'.ROOTURL.'">'.ROOTURL.'</a>';
				$content = str_replace(array('[ID]','[username]','[rooturl]','[link]','[price]'),array($property_id,$email_addr['name_member'],$rooturl,$link,showPrice($agent_price)),$content);
                sendEmail_func($config_cls->getKey('general_contact_email'),$email_addr['email_address'],$content,$subject, $lkB);
                $log_cls->createLog('bid');
		}
		//END
		StaticsReport('bids');


	}
 return true;
}

function addBanner($property_id)
{
    return getBannerByPropertyId($property_id);
}

function getEmailSMS_RegToBid($property_id = 0 ){
    global $bid_first_cls,$bid_cls,$property_cls,$agent_cls;
    $info = array('email' => array(),'sms' => array());
    if($property_id > 0)
    {
        $row_reg_bid = $bid_first_cls->getRows("property_id=".$property_id);
        if(count($row_reg_bid) > 0 and is_array($row_reg_bid))
        {
            foreach($row_reg_bid as $row)
            {
                $agent_row = PE_getAgent($row['agent_id']);
                if ($agent_row['notify_email'] == 1) {
                    $info['email'][] = $agent_row['email_address'];
                }

                if ($agent_row['notify_sms'] == 1 && strlen($agent_row['mobilephone']) > 0 ) {
                    $info['sms'][] = $agent_row['mobilephone'];
                }
            }
        }

    }
    return $info;
}

function getEmailSMS_Lawyer($property_id = 0) {
    global $agent_cls,$property_cls;
    $result = array();
    if($property_id> 0 )
    {
        $row = $property_cls->getRow('property_id='.$property_id);
        if(count($row) > 0 and is_array($row))
        {
            $agent_row = $agent_cls->getRow("SELECT a_l.*,a.notify_email,a.notify_sms,a.allow_lawyer
                                            FROM  ".$agent_cls->getTable()." AS a , ".$agent_cls->getTable('agent_lawyer')." AS a_l
                                            WHERE a_l.agent_id = a.agent_id
                                                AND a.agent_id = ".$row['agent_id']."
                                                AND a.is_active = 1",true);
            if (is_array($agent_row) && count($agent_row) > 0) {
                if ($agent_row['allow_lawyer'] == 1) {
                    $result['email'] = $agent_row['email'];
                }

                if ($agent_row['allow_lawyer'] == 1) {
                    $result['sms'] = $agent_row['mobilephone'];
                }
            }
        }
    }

    return $result;
}

function getEmailSMS_Vendor($property_id = 0) {
    global $agent_cls,$property_cls;
    $result = array();
    if($property_id > 0 )
    {
        $row = $property_cls->getRow('property_id='.$property_id);
        if(count($row) > 0 and is_array($row))
        {
            $agent_row = $agent_cls->getRow("SELECT a.*
                                            FROM  ".$agent_cls->getTable()." AS a
                                            WHERE 1
                                                AND a.agent_id = ".$row['agent_id']."
                                                AND a.is_active = 1",true);
            if (is_array($agent_row) && count($agent_row) > 0) {
                if ($agent_row['notify_email'] == 1) {
                    $result['email'] = $agent_row['email_address'];
                }

                if ($agent_row['notify_sms'] == 1) {
                    $result['sms'] = $agent_row['mobilephone'];
                }
            }
        }
    }

    return $result;
}

function getEmailSMS_Bidder($property_id) {
    global $agent_cls, $bid_cls;
    $result = array('email' =>array(),'sms' => array());
    if($property_id > 0)
    {
        $bid_rows = $bid_cls->getRows('SELECT   DISTINCT
                                                    agt.agent_id,
                                                    agt.email_address,
                                                    agt.mobilephone,
                                                    agt.notify_email,
                                                    agt.notify_sms,
                                                    agt.firstname,
                                                    agt.lastname

                                                    FROM '.$agent_cls->getTable().' AS agt,'.$bid_cls->getTable().' AS bid
                                                    WHERE
                                                        agt.agent_id = bid.agent_id
                                                        AND agt.is_active = 1
                                                        AND bid.property_id = '.$property_id.'
                                                    ORDER BY bid.price DESC',true);


        if (is_array($bid_rows) && count($bid_rows) > 0) {
            foreach ($bid_rows as $bid_row) {
                if(true)
                {
                    if ($bid_row['notify_email'] == 1) {
                        $result['email'][] = $bid_row['email_address'];
                    }

                    if ($bid_row['notify_sms'] == 1 && strlen(trim($bid_row['mobilephone'])) > 0) {
                        $result['sms'][] = $bid_row['mobilephone'];
                    }
                }

            }//end foreach
        }//end if
    }
    return $result;
}

function getEmailSMS_Watchlist($property_id) {
    global $agent_cls, $watchlist_cls;
    $result = array('email' => array(),'sms' =>array());
    if($property_id > 0)
    {
        $watchlist_rows = $watchlist_cls->getRows('SELECT DISTINCT agt.email_address, agt.mobilephone, agt.notify_email,
                                                                    agt.notify_sms, agt.firstname, agt.lastname
                                                                    FROM '.$watchlist_cls->getTable().' AS wl,'.$agent_cls->getTable().' AS agt
                                                                    WHERE wl.agent_id = agt.agent_id
                                                                            AND agt.is_active = 1
                                                                            AND wl.property_id = '.$property_id,true);


        if (is_array($watchlist_rows) && count($watchlist_rows) > 0) {
            foreach ($watchlist_rows as $wl_row) {
                if (true) {
                    if ($wl_row['notify_email'] == 1) {
                        $result['email'][] = $wl_row['email_address'];
                    }

                    if ($wl_row['notify_sms'] == 1 && strlen(trim($wl_row['mobilephone'])) > 0) {
                        $result['sms'][] = $wl_row['mobilephone'];
                    }

                }
            }//end foreach
        }//end if
    }
    return $result;
}

function getEmailSMS_Offer($property_id) {
    global $agent_cls, $watchlist_cls,$message_cls;
    $result = array('email' => array(),'sms' =>array());
    if($property_id > 0)
    {
        $offer_rows = $watchlist_cls->getRows('SELECT DISTINCT agt.email_address, agt.mobilephone, agt.notify_email,
                                                                    agt.notify_sms, agt.firstname, agt.lastname
                                                                    FROM '.$message_cls->getTable().' AS mes,'.$agent_cls->getTable().' AS agt
                                                                    WHERE   mes.agent_id_from = agt.agent_id
                                                                            AND agt.is_active = 1
                                                                            AND mes.entity_id = '.$property_id,true);


        if (is_array($offer_rows) && count($offer_rows) > 0) {
            foreach ($offer_rows as $wl_row) {
                if (true) {
                    if ($wl_row['notify_email'] == 1) {
                        $result['email'][] = $wl_row['email_address'];
                    }

                    if ($wl_row['notify_sms'] == 1 && strlen(trim($wl_row['mobilephone'])) > 0) {
                        $result['sms'][] = $wl_row['mobilephone'];
                    }

                }
            }//end foreach
        }//end if
    }
    return $result;
}

function getInfoReminder($property_id = 0 ,$type = '' ){
    $info = array('email' => array(), 'sms' => array());
    if($property_id <= 0)
    {
        return $info;
    }

    // Get Vendor Email and SMS
    $vendor_ar = getEmailSMS_Vendor($property_id);
    if(isset($vendor_ar['email'])){
        $info['email'][] = $vendor_ar['email'];
    }
    if(isset($vendor_ar['sms']))
    {
        $info['sms'][] = $vendor_ar['sms'];
    }
    //END
    //Get Lawyer Email AND Sms
    $row_ar = getEmailSMS_Lawyer($property_id);
    if(isset($row_ar['email'])>0){
        $info['email'][] = $row_ar['email'];
    }
    if(isset($row_ar['sms']) > 0)
    {
        $info['sms'][] = $row_ar['sms'];
    }
    //End
    //Get acc RegtoBid Email AND Sms
    $row_ar = getEmailSMS_RegToBid($property_id);
    if(count($row_ar['email'])>0){
        foreach ($row_ar['email'] as $row) {
            $info['email'][] = $row;
        }
    }
    if(count($row_ar['sms']) > 0)
    {
        foreach($row_ar['sms'] as $row)
        {
            $info['sms'][] = $row_ar['sms'];
        }
    }


    //End
    if($type == "ending-notifications")
    {
        //Get Email Bidder AND SMS number
        $row_ar = getEmailSMS_Bidder($property_id);
        if(count($row_ar['email'])>0){
            foreach ($row_ar['email'] as $row) {
                $info['email'][] = $row;
            }
        }
        if(count($row_ar['sms']) > 0)
        {
            foreach($row_ar['sms'] as $row)
            {
                $info['sms'][] = $row_ar['sms'];
            }
        }
        //End
    }
    //Get acc watchlist Email AND Sms
    $row_ar = getEmailSMS_Watchlist($property_id);
    if(count($row_ar['email'])>0){
        foreach ($row_ar['email'] as $row) {
            $info['email'][] = $row;
        }
    }
    if(count($row_ar['sms']) > 0)
    {
        foreach($row_ar['sms'] as $row)
        {
            $info['sms'][] = $row_ar['sms'];
        }
    }
    //End
    //Get acc offer Email AND Sms
    $row_ar = getEmailSMS_Offer($property_id);
    if(count($row_ar['email'])>0){
        foreach ($row_ar['email'] as $row) {
            $info['email'][] = $row;
        }
    }
    if(count($row_ar['sms']) > 0)
    {
        foreach($row_ar['sms'] as $row)
        {
            $info['sms'][] = $row_ar['sms'];
        }
    }
    //End
    //EMAIL
    $info_ = array();
    $info['email'] = array_unique($info['email']);
    foreach($info['email'] as $email){
        if($email != '' AND isset($email))
        {
            $info_[] = $email;
        }
    }
    $info_ = array_unique($info_);
    $info['email'] = $info_;
    //SMS
    $info_ = array();
    $info['sms'] = array_unique($info['sms']);
    foreach($info['sms'] as $sms)
    {
        if(isset($sms) AND $sms != '')
        {
            $info_[] = $sms;
        }
    }
    $info_ = array_unique($info_);
    $info['sms'] = $info_;

    return $info;
}
?>