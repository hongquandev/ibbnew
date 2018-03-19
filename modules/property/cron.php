<?php
$ROOTURL = ROOTURL;
include_once ROOTPATH . '/modules/general/inc/SMS.class.php';
include_once ROOTPATH . '/modules/general/inc/sms_log.class.php';
include_once ROOTPATH . '/modules/agent/inc/agent.php';
include_once ROOTPATH . '/modules/property/inc/property.php';
include_once ROOTPATH . '/modules/general/inc/bids.php';
include_once ROOTPATH . '/includes/class.phpmailer.php';
include_once ROOTPATH . '/modules/banner/inc/banner.php';
include_once ROOTPATH . '/modules/general/inc/bids_mailer.php';
include_once ROOTPATH . '/modules/configuration/inc/config.class.php';
include_once ROOTPATH . '/modules/general/inc/timetable.class.php';
include_once ROOTPATH . '/modules/agent/inc/agent_lawyer.class.php';
include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
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
$schedule_cron = isset($schedule_cron) ? $schedule_cron : 0;
$schedule_sec = round($schedule_cron * 60 / 2);
/**GO TO auction
 * =================
 * Description:
 * -----------
 * Bidder Reminder function for Forthcoming Auctions
 * We need to add a option for Bidders to add an automatic reminder (by email or sms)
 * 1 day, 1 hour, live before a Forthcoming Auction becomes a Live Auction
 **/
function goToAuction($time)
{
    global $config_cls, $property_cls, $schedule_sec, $property_term_cls, $auction_term_cls;
    $auction_sale_ar = PEO_getAuctionSale();
    $b_time = date("Y-m-d H:i:s", mktime(date('H') + $time, date('i'), date('s') - $schedule_sec, date('m'), date('d'), date('Y')));
    $e_time = date("Y-m-d H:i:s", mktime(date('H') + $time, date('i'), date('s') + $schedule_sec, date('m'), date('d'), date('Y')));
    $rows = $property_cls->getRows('SELECT pro.*
                                        FROM ' . $property_cls->getTable() . ' as pro
                                        WHERE 1
                                            AND auction_sale != ' . $auction_sale_ar['private_sale'] . "
                                            AND stop_bid = 0
                                            AND confirm_sold = 0
                                            AND start_time BETWEEN '" . $b_time . "' AND '" . $e_time . "'
                                            AND active = 1
                                            AND agent_active = 1
                                            AND IF(hide_for_live = 1 AND start_time > '" . date('Y-m-d H:i:s') . "' , 0, 1) = 1
                                            AND pay_status = " . Property::CAN_SHOW . '
                                            AND IF (pro.auction_sale != ' . $auction_sale_ar['private_sale'] . '
                                                    AND (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\',0,pro_term.value)
                                                                 FROM ' . $property_term_cls->getTable() . ' AS pro_term
                                                                 LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
                                                                    ON pro_term.auction_term_id = term.auction_term_id
                                                                 WHERE term.code = \'auction_start_price\'
                                                                    AND pro.property_id = pro_term.property_id )
                                                            AND  (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\',0,pro_term.value)
                                                                 FROM ' . $property_term_cls->getTable() . ' AS pro_term
                                                                 LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
                                                                    ON pro_term.auction_term_id = term.auction_term_id
                                                                 WHERE term.code = \'reserve\'
                                                                    AND pro.property_id = pro_term.property_id )
                                                            AND  IF((SELECT pro_term.value
                                                                 FROM ' . $property_term_cls->getTable() . ' AS pro_term
                                                                 LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
                                                                    ON pro_term.auction_term_id = term.auction_term_id
                                                                 WHERE term.code = \'auction_start_price\'
                                                                    AND pro.property_id = pro_term.property_id )
                                                                 >
                                                                 (SELECT pro_term.value
                                                                 FROM ' . $property_term_cls->getTable() . ' AS pro_term
                                                                 LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
                                                                    ON pro_term.auction_term_id = term.auction_term_id
                                                                 WHERE term.code = \'reserve\'
                                                                    AND pro.property_id = pro_term.property_id ),0,1)
                                                            = 0, 0, 1) = 1 ', true);
    if (is_array($rows) && count($rows) > 0) {
        foreach ($rows as $row) {
            $property_id = $row['property_id'];
            $vendor_emails = getEmailSMS_Vendor($property_id);
            $vendor_emails = (array)$vendor_emails;
            $vendor_emails[] = $config_cls->getKey('general_contact1_name');
            sendNotificationByEventKey('user_auction_go_to_start', array('to' => $vendor_emails, 'property_id' => $property_id));
            $register_bidder_emails = getEmailSMS_RegToBid($property_id);
            sendNotificationByEventKey('user_auction_go_to_start_registered_bidder', array('to' => $register_bidder_emails, 'property_id' => $property_id));
            $watchlist_emails = getEmailSMS_Watchlist($property_id);
            sendNotificationByEventKey('user_auction_go_to_start_user_in_watchlist', array('to' => $watchlist_emails, 'property_id' => $property_id));
        }
    }
}

/*============RUNNING FUNCTIONS============*/
goToAuction(24);
goToAuction(1);
goToAuction(0);
/**
 * > END : GO TO auction
 **/
/*
 * need a new text/email notification – release date/time, 30 minutes before this is due a notification to registered bidders (and watchlist users) to notify them that the release is pending in 30 minutes time….
 * */
function goToRelease($time = 30)
{
    global $config_cls, $property_cls, $schedule_sec;
    $auction_sale_ar = PEO_getAuctionSale();
    $b_time = date("Y-m-d H:i:s", mktime(date('H'), date('i')  + $time, date('s') - $schedule_sec, date('m'), date('d'), date('Y')));
    $e_time = date("Y-m-d H:i:s", mktime(date('H'), date('i')  + $time, date('s') + $schedule_sec, date('m'), date('d'), date('Y')));
    $rows = $property_cls->getRows('SELECT pro.*
                                        FROM ' . $property_cls->getTable() . ' as pro
                                        WHERE 1
                                            AND auction_sale != ' . $auction_sale_ar['private_sale'] . "
                                            AND stop_bid = 0
                                            AND confirm_sold = 0
                                            AND release_time BETWEEN '" . $b_time . "' AND '" . $e_time . "'
                                            AND active = 1
                                            AND agent_active = 1
                                            AND pay_status = " . Property::CAN_SHOW . '
                                            ', true);
    if (is_array($rows) && count($rows) > 0) {
        foreach ($rows as $row) {
            $property_id = $row['property_id'];
            $vendor_emails = getEmailSMS_Vendor($property_id);
            $vendor_emails = (array)$vendor_emails;
            $vendor_emails[] = $config_cls->getKey('general_contact1_name');

            sendNotificationByEventKey('user_property_go_to_release', array('to' => $vendor_emails, 'property_id' => $property_id));
            $register_bidder_emails = getEmailSMS_RegToBid($property_id);

            sendNotificationByEventKey('user_property_go_to_release_registered_bidder', array('to' => $register_bidder_emails, 'property_id' => $property_id));
            $watchlist_emails = getEmailSMS_Watchlist($property_id);

            sendNotificationByEventKey('user_property_go_to_release_user_in_watchlist', array('to' => $watchlist_emails, 'property_id' => $property_id));
        }
    }
}
goToRelease(30);
/**
 * > BEGIN : auction ending
 * =================
 * Description:
 * ------------
 * Auction ending notifications
 * intervals: 5 days, 2 days, 1 day, 12 hours, 6 hours, 3 hours, 1 hour, 30 minutes.
 * before the end of the Auction as the default
 **/
//$hour_ar = array(5 * 24, 2 * 24, 1 * 24, 12, 6, 3, 1, 0);
$hour_ar = array(1 * 24, 12, 6, 3, 1, 0);
$minute_ref_ar = array( //5 * 24 * 60 => '5 days',
    //2 * 24 * 60 => '2 days',
    1 * 24 * 60 => '1 day',
    12 * 60 => '12 hours',
    6 * 60 => '6 hours',
    3 * 60 => '3 hours',
    1 * 60 => '1 hour',
    30 => '30 minutes',
    0 => 'now');
$wh_ar = array();
foreach ($hour_ar as $hour) {
    $b_time = date("Y-m-d H:i:s", mktime(date('H') + $hour, date('i'), date('s') - $schedule_sec, date('m'), date('d'), date('Y')));
    $e_time = date("Y-m-d H:i:s", mktime(date('H') + $hour, date('i'), date('s') + $schedule_sec, date('m'), date('d'), date('Y')));
    $wh_ar[] = "( end_time BETWEEN '" . $b_time . "' AND '" . $e_time . "' )";
}
$auction_sale_ar = PEO_getAuctionSale();
$rows = $property_cls->getRows('auction_sale != ' . $auction_sale_ar['private_sale'] . '
                                        AND stop_bid = 0
                                        AND (' . implode(' OR ', $wh_ar) . ')
                                        AND active = 1
                                        AND agent_active = 1
                                        AND IF(hide_for_live = 1 AND start_time > \'' . date('Y-m-d H:i:s') . '\' , 0, 1) = 1
                                        AND pay_status = ' . Property::CAN_SHOW);
//die(print_r($property_cls->sql));
if (is_array($rows) && count($rows) > 0) {
    foreach ($rows as $row) {
        if (PE_isLiveAuction($row['property_id'])) {
            $time_str = '';
            $minute = remainTime($row['end_time'], date('Y-m-d H:i:s')) / 60;
            foreach ($minute_ref_ar as $value => $title) {
                if ((($value - $schedule_cron) <= $minute) && ($minute < ($value + $schedule_cron))) {
                    $time_str = $title;
                    break;
                }
            }
            if ($minute <= 5) {
                $time_str = '5 minutes';
            }
            if (strlen($time_str) > 0) {
                $property_id = $row['property_id'];
                $vendor_emails = getEmailSMS_Vendor($property_id);
                $vendor_emails = (array)$vendor_emails;
                $vendor_emails[] = $config_cls->getKey('general_contact1_name');
                sendNotificationByEventKey('user_2_hours_before_auction_end', array('to' => $vendor_emails, 'property_id' => $property_id, 'remain_time' => $time_str));
                $register_bidder_emails = getEmailSMS_RegToBid($property_id);
                sendNotificationByEventKey('user_2_hours_before_auction_end_all_register_bidders', array('to' => $register_bidder_emails, 'property_id' => $property_id, 'remain_time' => $time_str));
                $bidder_emails = getEmailSMS_Bidder($property_id);
                sendNotificationByEventKey('user_2_hours_before_auction_end_all_has_bidders', array('to' => $bidder_emails, 'property_id' => $property_id, 'remain_time' => $time_str));
                $watchlist_emails = getEmailSMS_Watchlist($property_id);
                sendNotificationByEventKey('user_2_hours_before_auction_end_user_in_watchlis', array('to' => $watchlist_emails, 'property_id' => $property_id, 'remain_time' => $time_str));
            }
        }
    }
}
/**
 * > END : IBB-174
 *
 * Description
 * ===============
 * Send email/SMS to bidder, vendor and another people when property stop bid.
 **/
$main_key = 'notification_auction';
$timetable_cls->update(array('begin_time' => date('Y-m-d H:i:s')), "`key` = '" . $main_key . "'");
$scan = true;
if (true) {
    $auction_sale_ar = PEO_getAuctionSale();
    $rows = $property_cls->getRows("auction_sale != " . $auction_sale_ar['private_sale'] . "
                                        AND scan = 0
                                        AND stop_bid = 1
                                        AND active = 1
                                        AND confirm_sold = 1
                                        AND agent_active = 1
										AND IF(hide_for_live = 1 AND start_time > '" . date('Y-m-d H:i:s') . "' , 0, 1) = 1
										AND pay_status = " . Property::CAN_SHOW . "
                                        AND (SELECT pro_term.value
											FROM " . $property_cls->getTable('property_term') . " AS pro_term
											LEFT JOIN " . $property_cls->getTable('auction_terms') . " AS term
												ON pro_term.auction_term_id = term.auction_term_id
											WHERE term.code = 'reserve' AND a.property_id = pro_term.property_id
											)
											<=
                             			    (SELECT max(price) FROM " . $property_cls->getTable('bids') . " WHERE a.property_id = bids.property_id)
                             			AND (
                             			    (SELECT agent_id FROM " . $property_cls->getTable('bids') . "
                             			        WHERE a.property_id = bids.property_id
                             			        ORDER BY time DESC
                             			        LIMIT 0,1)
                             			    != a.agent_id
                             			)
                             			    "
    );
    if (is_array($rows) && count($rows) > 0) {
        foreach ($rows as $row) {
            if (!isset($row['property_id']) OR $row['property_id'] <= 0) {
                continue;
            }
            $property_cls->update(array('scan' => 1), 'property_id = ' . $row['property_id']);
            $cron = new PropertySoldSendEmail($row);
            try {
                $cron->scanVendor($row);
                $cron->scanLawyer($row);
                $cron->scanBidder($row);
                $cron->scanWatchlist($row);
                $cron->sendVendor($row);
                $cron->sendLawyer($row);
                $cron->sendWinner($row);
                //$cron->sendReceiver($row);
                $cron->sendBidder($row);
                $cron->sendWatchlist($row);
            } catch (Exception $er) {
                print_r($er);
            }
        }//end foreach
    }
}//end if scan
class PropertySoldSendEmail
{
    private $win_ar = array();
    private $email_ctn = array('receiver' => array(), 'vendor' => array(), 'lawyer' => array());
    private $sms_ctn = array('receiver' => array(), 'vendor' => array(), 'lawyer' => array());
    private $objs = array();
    private $data = array();

    public function __construct($data = array())
    {
        global $agent_cls, $bid_cls, $watchlist_cls, $config_cls;
        $this->objs['agent_cls'] = $agent_cls;
        $this->objs['bid_cls'] = $bid_cls;
        $this->objs['watchlist_cls'] = $watchlist_cls;
        $this->objs['config_cls'] = $config_cls;
        $this->data = $data;
    }

    public function  showData()
    {
        echo "<br>--Data: " . print_r_pre($this->data) . '<br>';
        echo "<br>--win: " . print_r_pre($this->win_ar) . '<br>';
        echo "<br>--email_ctn: " . print_r_pre($this->email_ctn) . '<br>';
        echo "<br>--SMS: " . print_r_pre($this->sms_ctn) . '<br>';
        echo "<br>--obj: " . print_r_pre($this->objs) . '<br>';
    }

    /**
     * function : scanVendor
     **/
    public function scanVendor($data = array())
    {
        global $agent_cls;
        if (!isset($data['agent_id']))
            $data['agent_id'] = 0;
        $agent_row = $agent_cls->getRow("SELECT a.*
										FROM  " . $agent_cls->getTable() . " AS a , " . $agent_cls->getTable('agent_type') . " AS a_t
										WHERE a.type_id = a_t.agent_type_id
												AND a_t.title = 'vendor'
												AND a.agent_id = " . $data['agent_id'] . "
												AND a.is_active = 1", true);
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
     * function : scanLawyer
     **/
    public function scanLawyer($data = array())
    {
        global $agent_cls;
        if (!isset($data['agent_id']))
            $data['agent_id'] = 0;
        $agent_row = $agent_cls->getRow("SELECT a_l.*,a.notify_email,a.notify_sms,a.allow_lawyer
										FROM  " . $agent_cls->getTable() . " AS a , " . $agent_cls->getTable('agent_lawyer') . " AS a_l
										WHERE a_l.agent_id = a.agent_id
                                            AND a.agent_id = " . $data['agent_id'] . "
                                            AND a.is_active = 1", true);
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

    public function  scanWinnerBidder($data = array())
    {
        global $agent_cls, $bid_cls;
        //
        $row = Bid_getLastBidByPropertyId((int)$data['property_id']);
        if (count($row) > 0 and is_array($row)) {
            $winner_email = A_getEmail($row['agent_id']);
            $this->win_ar['email_address'] = $winner_email;
            $this->win_ar['winner_name'] = A_getFullName($row['agent_id']);
        }
        return $this;
    }

    /**
     * function : scanBidder
     **/
    public function scanBidder($data = array())
    {
        global $agent_cls, $bid_cls;
        $this->scanWinnerBidder($data);
        $bid_rows = $bid_cls->getRows('SELECT DISTINCT agt.agent_id, agt.email_address, agt.mobilephone,
													  agt.notify_email, agt.notify_sms, agt.firstname, agt.lastname
									FROM ' . $agent_cls->getTable() . ' AS agt,' . $bid_cls->getTable() . ' AS bid
									WHERE agt.agent_id = bid.agent_id
											AND agt.is_active = 1
											AND bid.property_id = ' . (int)@$data['property_id'] . ' ORDER BY bid.price DESC', true);
        if (is_array($bid_rows) && count($bid_rows) > 0) {
            foreach ($bid_rows as $bid_row) {
                if (strcasecmp($bid_row['email_address'], @$this->win_ar['email_address']) != 0) {
                    if ($bid_row['notify_email'] == 1) {
                        $this->email_ctn['bidder'][] = $bid_row['email_address'];
                    }
                    if ($bid_row['notify_sms'] == 1 && strlen(trim($bid_row['mobilephone'])) > 0) {
                        $this->sms_ctn['bidder'][] = $bid_row['mobilephone'];
                    }
                }
            }//end foreach
        }//end if
        return $this;
    }

    /**
     * function : scanWatchlist
     **/
    public function scanWatchlist($data = array())
    {
        global $agent_cls, $watchlist_cls;
        $watchlist_rows = $watchlist_cls->getRows('SELECT DISTINCT agt.email_address, agt.mobilephone, agt.notify_email,
																agt.notify_sms, agt.firstname, agt.lastname
																FROM ' . $watchlist_cls->getTable() . ' AS wl,' . $agent_cls->getTable() . ' AS agt
																WHERE wl.agent_id = agt.agent_id
																		AND agt.is_active = 1
																		AND wl.property_id = ' . $data['property_id'], true);
        if (is_array($watchlist_rows) && count($watchlist_rows) > 0) {
            foreach ($watchlist_rows as $wl_row) {
                if (strcasecmp($wl_row['email_address'], @$this->win_ar['email_address']) != 0) {
                    if ($wl_row['notify_email'] == 1) {
                        $this->email_ctn['watcher'][] = $wl_row['email_address'];
                    }
                    if ($wl_row['notify_sms'] == 1 && strlen(trim($wl_row['mobilephone'])) > 0) {
                        $this->sms_ctn['watcher'][] = $wl_row;
                    }
                }
            }//end foreach
        }//end if
        return $this;
    }

    /**
     * function : sendVendor
     **/
    public function sendVendor($data = array())
    {
        global $config_cls;
        if (!empty($this->email_ctn['vendor'])) {
            $params_email = array();
            $params_email['property_id'] = $data['property_id'];
            $params_email['to'] = array($this->email_ctn['vendor']['email_address'], $config_cls->getKey('general_contact1_name'));
            sendNotificationByEventKey('user_sold_or_leased', $params_email);
        }
        return $this;
    }

    /**
     * function : sendLawyer
     **/
    public function sendLawyer($data = array())
    {
        if (!empty($this->email_ctn['lawyer'])) {
            $params_email = array();
            $params_email['property_id'] = $data['property_id'];
            $params_email['to'] = $this->email_ctn['lawyer'];
            sendNotificationByEventKey('user_sold_or_leased', $params_email);
        }
        return $this;
    }

    /**
     * function : sendWinner
     **/
    public function sendWinner($data = array())
    {
        global $config_cls;
        if (!empty($this->win_ar['email_address'])) {
            $params_email = array();
            $params_email['property_id'] = $data['property_id'];
            $params_email['to'] = $this->win_ar['email_address'];
            sendNotificationByEventKey('user_sold_or_leased_buyer', $params_email);
        }
        return $this;
    }

    /**
     * function : sendReceiver ( people who in watchlist)
     **/
    public function sendReceiver($data = array())
    {
        global $config_cls;
        if (is_array($this->email_ctn['receiver']) && count($this->email_ctn['receiver']) > 0) {
            $params_email = array();
            $params_email['property_id'] = $data['property_id'];
            $params_email['to'] = $this->email_ctn['receiver'];
            sendNotificationByEventKey('user_sold_or_leased_buyer_all_registered_bidders', $params_email);
        }
        return $this;
    }

    public function sendBidder($data = array())
    {
        global $config_cls;
        if (!empty($this->email_ctn['receiver']['bidder'])) {
            $params_email = array();
            $params_email['property_id'] = $data['property_id'];
            $params_email['to'] = $this->email_ctn['receiver']['bidder'];
            sendNotificationByEventKey('user_sold_or_leased_buyer_all_registered_bidders', $params_email);
        }
        return $this;
    }

    public function sendWatchlist($data = array())
    {
        global $config_cls;
        if (!empty($this->email_ctn['receiver']['watcher'])) {
            $params_email = array();
            $params_email['property_id'] = $data['property_id'];
            $params_email['to'] = $this->email_ctn['receiver']['watcher'];
            sendNotificationByEventKey('user_sold_or_leased_buyer_user_in_watchlist', $params_email);
        }
        return $this;
    }
}//end class
function getEmailSMS_RegToBid($property_id = 0)
{
    global $bid_first_cls, $bid_cls, $property_cls, $agent_cls;
    $info = array('email' => array(), 'sms' => array());
    if ($property_id > 0) {
        $row_reg_bid = $bid_first_cls->getRows("property_id=" . $property_id);
        if (count($row_reg_bid) > 0 and is_array($row_reg_bid)) {
            foreach ($row_reg_bid as $row) {
                $agent_row = PE_getAgent($row['agent_id']);
                if ($agent_row['notify_email'] == 1) {
                    $info['email'][] = $agent_row['email_address'];
                }
                if ($agent_row['notify_sms'] == 1 && strlen($agent_row['mobilephone']) > 0) {
                    $info['sms'][] = $agent_row['mobilephone'];
                }
            }
        }
    }
    return $info;
}

function getEmailSMS_Lawyer($property_id = 0)
{
    global $agent_cls, $property_cls;
    $result = array();
    if ($property_id > 0) {
        $row = $property_cls->getRow('property_id=' . $property_id);
        if (count($row) > 0 and is_array($row)) {
            $agent_row = $agent_cls->getRow("SELECT a_l.*,a.notify_email,a.notify_sms,a.allow_lawyer
                                            FROM  " . $agent_cls->getTable() . " AS a , " . $agent_cls->getTable('agent_lawyer') . " AS a_l
                                            WHERE a_l.agent_id = a.agent_id
                                                AND a.agent_id = " . $row['agent_id'] . "
                                                AND a.is_active = 1", true);
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

function getEmailSMS_Vendor($property_id = 0)
{
    global $agent_cls, $property_cls;
    $result = array();
    if ($property_id > 0) {
        $row = $property_cls->getRow('property_id=' . $property_id);
        if (count($row) > 0 and is_array($row)) {
            $agent_row = $agent_cls->getRow("SELECT a.*
                                            FROM  " . $agent_cls->getTable() . " AS a
                                            WHERE 1
                                                AND a.agent_id = " . $row['agent_id'] . "
                                                AND a.is_active = 1", true);
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

function getEmailSMS_Bidder($property_id)
{
    global $agent_cls, $bid_cls;
    $result = array('email' => array(), 'sms' => array());
    if ($property_id > 0) {
        $bid_rows = $bid_cls->getRows('SELECT   DISTINCT
                                                    agt.agent_id,
                                                    agt.email_address,
                                                    agt.mobilephone,
                                                    agt.notify_email,
                                                    agt.notify_sms,
                                                    agt.firstname,
                                                    agt.lastname

                                                    FROM ' . $agent_cls->getTable() . ' AS agt,' . $bid_cls->getTable() . ' AS bid
                                                    WHERE
                                                        agt.agent_id = bid.agent_id
                                                        AND agt.is_active = 1
                                                        AND bid.property_id = ' . $property_id . '
                                                    ORDER BY bid.price DESC', true);
        if (is_array($bid_rows) && count($bid_rows) > 0) {
            foreach ($bid_rows as $bid_row) {
                if (true) {
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

function getEmailSMS_Watchlist($property_id)
{
    global $agent_cls, $watchlist_cls;
    $result = array('email' => array(), 'sms' => array());
    if ($property_id > 0) {
        $watchlist_rows = $watchlist_cls->getRows('SELECT DISTINCT agt.email_address, agt.mobilephone, agt.notify_email,
                                                            agt.notify_sms, agt.firstname, agt.lastname
                                                            FROM ' . $watchlist_cls->getTable() . ' AS wl,' . $agent_cls->getTable() . ' AS agt
                                                            WHERE wl.agent_id = agt.agent_id
                                                                    AND agt.is_active = 1
                                                                    AND wl.property_id = ' . $property_id, true);
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

function getEmailSMS_Offer($property_id)
{
    global $agent_cls, $watchlist_cls, $message_cls;
    $result = array('email' => array(), 'sms' => array());
    if ($property_id > 0) {
        $offer_rows = $watchlist_cls->getRows('SELECT DISTINCT agt.email_address, agt.mobilephone, agt.notify_email,
                                                                    agt.notify_sms, agt.firstname, agt.lastname
                                                                    FROM ' . $message_cls->getTable() . ' AS mes,' . $agent_cls->getTable() . ' AS agt
                                                                    WHERE   mes.agent_id_from = agt.agent_id
                                                                            AND agt.is_active = 1
                                                                            AND mes.entity_id = ' . $property_id, true);
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

function getInfoReminder($property_id = 0, $type = '')
{
    $info = array('email' => array(), 'sms' => array());
    if ($property_id <= 0) {
        return $info;
    }
    // Get Vendor Email and SMS
    $vendor_ar = getEmailSMS_Vendor($property_id);
    if (isset($vendor_ar['email'])) {
        $info['email'][] = $vendor_ar['email'];
    }
    if (isset($vendor_ar['sms'])) {
        $info['sms'][] = $vendor_ar['sms'];
    }
    //END
    //Get Lawyer Email AND Sms
    $row_ar = getEmailSMS_Lawyer($property_id);
    if (isset($row_ar['email']) > 0) {
        $info['email'][] = $row_ar['email'];
    }
    if (isset($row_ar['sms']) > 0) {
        $info['sms'][] = $row_ar['sms'];
    }
    //End
    //Get acc RegtoBid Email AND Sms
    $row_ar = getEmailSMS_RegToBid($property_id);
    if (count($row_ar['email']) > 0) {
        foreach ($row_ar['email'] as $row) {
            $info['email'][] = $row;
        }
    }
    if (count($row_ar['sms']) > 0) {
        foreach ($row_ar['sms'] as $row) {
            $info['sms'][] = $row_ar['sms'];
        }
    }
    //End
    if ($type == "ending-notifications") {
        //Get Email Bidder AND SMS number
        $row_ar = getEmailSMS_Bidder($property_id);
        if (count($row_ar['email']) > 0) {
            foreach ($row_ar['email'] as $row) {
                $info['email'][] = $row;
            }
        }
        if (count($row_ar['sms']) > 0) {
            foreach ($row_ar['sms'] as $row) {
                $info['sms'][] = $row_ar['sms'];
            }
        }
        //End
    }
    //Get acc watchlist Email AND Sms
    $row_ar = getEmailSMS_Watchlist($property_id);
    if (count($row_ar['email']) > 0) {
        foreach ($row_ar['email'] as $row) {
            $info['email'][] = $row;
        }
    }
    if (count($row_ar['sms']) > 0) {
        foreach ($row_ar['sms'] as $row) {
            $info['sms'][] = $row_ar['sms'];
        }
    }
    //End
    //Get acc offer Email AND Sms
    $row_ar = getEmailSMS_Offer($property_id);
    if (count($row_ar['email']) > 0) {
        foreach ($row_ar['email'] as $row) {
            $info['email'][] = $row;
        }
    }
    if (count($row_ar['sms']) > 0) {
        foreach ($row_ar['sms'] as $row) {
            $info['sms'][] = $row_ar['sms'];
        }
    }
    //End
    //EMAIL
    $info_ = array();
    $info['email'] = array_unique($info['email']);
    foreach ($info['email'] as $email) {
        if ($email != '' AND isset($email)) {
            $info_[] = $email;
        }
    }
    $info_ = array_unique($info_);
    $info['email'] = $info_;
    //SMS
    $info_ = array();
    $info['sms'] = array_unique($info['sms']);
    foreach ($info['sms'] as $sms) {
        if (isset($sms) AND $sms != '') {
            $info_[] = $sms;
        }
    }
    $info_ = array_unique($info_);
    $info['sms'] = $info_;
    return $info;
}

?>