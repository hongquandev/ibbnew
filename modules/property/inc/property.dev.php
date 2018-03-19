<?php
include_once ROOTPATH . '/includes/validate.class.php';
include_once ROOTPATH . '/includes/pagging.class.php';
include_once 'property.class.php';
include_once ROOTPATH . '/modules/general/inc/documents.class.php';
include_once 'property_document.class.php';
include_once 'property_package_payment.class.php';
include_once 'property_entity_option.class.php';
include_once 'property_media.class.php';
include_once 'property_option.class.php';
include_once ROOTPATH . '/modules/general/inc/property_history.php';
include_once ROOTPATH . '/modules/general/inc/bid_room.class.php';
include_once ROOTPATH . '/modules/general/inc/autobid_setting.class.php';
include_once ROOTPATH . '/modules/general/inc/ratings.class.php';
include_once 'property_rating.class.php';
include_once 'property_rating_mark.class.php';
include_once 'property_term.class.php';
include_once 'watchlists.class.php';
include_once ROOTPATH . '/modules/package/inc/package.php';
include_once ROOTPATH . '/modules/general/inc/bids.php';
include_once ROOTPATH . '/modules/general/inc/bids_transition_history.php';
include_once ROOTPATH . '/modules/calendar/inc/calendar.php';
include_once ROOTPATH . '/modules/systemlog/inc/systemlog.php';
include_once ROOTPATH . '/modules/general/inc/auction_terms.class.php';
include_once ROOTPATH . '/modules/general/inc/medias.class.php';
include_once ROOTPATH . '/modules/emailalert/inc/emailalert.class.php';
include_once ROOTPATH . '/modules/comment/inc/comment.php';
include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
include_once ROOTPATH . '/modules/agent/inc/agent.php';
include_once ROOTPATH . '/modules/general/inc/bids_first.class.php';
include_once ROOTPATH . '/modules/configuration/inc/configuration.php';
include_once ROOTPATH . '/modules/general/inc/sendmail.php';
include_once ROOTPATH . '/modules/general/inc/notification.class.php';
include_once ROOTPATH . '/modules/general/inc/getbanner.php';
include_once ROOTPATH . '/modules/general/inc/SMS.php';
include_once ROOTPATH . '/modules/agent/inc/agent.php';
include_once ROOTPATH . '/modules/agent/inc/partner.php';
include_once ROOTPATH . '/modules/general/inc/bids_stop.class.php';
include_once ROOTPATH . '/modules/systemlog/inc/systemlog.php';
include_once ROOTPATH . '/modules/payment/inc/payment_store.class.php';
include_once ROOTPATH . '/includes/localizer.class.php';
include_once ROOTPATH . '/modules/general/inc/medias.class.php';
include_once ROOTPATH . '/modules/property/inc/property_media.class.php';
include_once 'property_provideremail.class.php';
if (!isset($media_cls) or !($media_cls instanceof Medias)) {
    $media_cls = new Medias();
}
if (!isset($property_media_cls) || !($property_media_cls instanceof Property_media)) {
    $property_media_cls = new Property_media();
}
include_once ROOTPATH . '/modules/general/inc/ftp.php';
include_once ROOTPATH . '/modules/general/inc/media.php';
include_once ROOTPATH . '/includes/smarty/Smarty.class.php';
$mobileFolder = '/';
$mobileBrowser = detectBrowserMobile();
if (!isset($smarty) || !($smarty instanceof Smarty)) {
    //BEGIN SMARTY
    $smarty = new Smarty;
    if ($mobileBrowser) {
        $mobileFolder = '/mobile/';
        $smarty->compile_dir = ROOTPATH . '/m.templates_c/';
    } else {
        $smarty->compile_dir = ROOTPATH . '/templates_c/';
        $mobileFolder = '/';
    }
}
// Call Constructor init();
if (!isset($payment_store_cls) || !($payment_store_cls instanceof Payment_store)) {
    $payment_store_cls = new Payment_store();
}
if (!isset($email_cls) || !($email_cls instanceof EmailAlert)) {
    $email_cls = new EmailAlert();
}
if (!isset($log_cls) || !($log_cls instanceof Email_log)) {
    $log_cls = new Email_log();
}
if (!isset($property_cls) || !($property_cls instanceof Property)) {
    $property_cls = new Property();
}
if (!isset($bid_room_cls) || !($bid_room_cls instanceof Bid_room)) {
    $bid_room_cls = new Bid_room();
}
if (!isset($autobid_cls) || !($autobid_cls instanceof Autobid_setting)) {
    $autobid_cls = new Autobid_setting();
}
if (!isset($document_cls) or !($document_cls instanceof Documents)) {
    $document_cls = new Documents();
}
if (!isset($systemlog_cls) or !($systemlog_cls instanceof SystemLog)) {
    $systemlog_cls = new SystemLog();
}
if (!isset($property_entity_option_cls) || !($property_entity_option_cls instanceof Property_entity_option)) {
    $property_entity_option_cls = new Property_entity_option();
}
if (!isset($property_package_payment_cls) || !($property_package_payment_cls instanceof Property_package_payment)) {
    $property_package_payment_cls = new Property_package_payment();
}
if (!isset($property_history_cls) || !($property_history_cls instanceof property_history)) {
    $property_history_cls = new property_history();
}
if (!isset($bid_transition_history_cls) || !($bid_transition_history_cls instanceof bids_transition_history)) {
    $bid_transition_history_cls = new bids_transition_history();
}
if (!isset($bids_first_cls) or !($bids_first_cls instanceof Bids_first)) {
    $bids_first_cls = new Bids_first();
}
if (!isset($notification_cls) || !($notification_cls instanceof Notification)) {
    $notification_cls = new Notification();
}
if (!isset($calendar_cls) || !($calendar_cls instanceof Calendar)) {
    $calendar_cls = new Calendar();
}
if (!isset($sms_cls) || !($sms_cls instanceof SMS)) {
    $sms_cls = new SMS(array('username' => $config_cls->getKey('sms_username'),
        'password' => $config_cls->getKey('sms_password'),
        'sender_id' => $config_cls->getKey('sms_sender_id'),
        'portal_url' => $config_cls->getKey('sms_gateway_url')));
}
if (!isset($bids_stop_cls) || !($bids_stop_cls instanceof Bids_stop)) {
    $bids_stop_cls = new Bids_stop();
}
if (!isset($sms_log_cls) || !($sms_log_cls instanceof SMS_log)) {
    $sms_log_cls = new SMS_log();
}
include_once ROOTPATH . '/modules/general/inc/bids_stop.class.php';
include_once ROOTPATH . '/modules/general/inc/bids_first.class.php';
if (!isset($bids_first_cls) or !($bids_first_cls instanceof Bids_first)) {
    $bids_first_cls = new Bids_first();
}
if (!$bids_stop_cls || !($bids_stop_cls instanceof Bids_stop)) {
    $bids_stop_cls = new Bids_stop();
}
if (!isset($property_provider_email_cls) || !($property_provider_email_cls instanceof Property_provideremail)) {
    $property_provider_email_cls = new Property_provideremail();
}
/**
 * Duc Coding Rewrite New Function
 * Fix Print See Show Start Image
 */
function startPrints($mark = 0, $total = 5)
{
    $rs = '';
    for ($i = 1; $i <= $total; $i++) {
        if ($i <= $mark) {
            $rs .= "<div class='star-yellow2'> <img src='" . ROOTURL . "/modules/general/templates/images/rating.png' /> </div>";
        } elseif (($mark > $i - 1) && ($mark < $i)) {
            $rs .= "<div class='star-half2'> <img src='" . ROOTURL . "/modules/general/templates/images/rating.png' /> </div>";
        } else {
            $rs .= "<div class='star-white2'> <img src='" . ROOTURL . "/modules/general/templates/images/rating.png' /> </div>";
        }
    }
    return $rs;
}

/**
 * @ function : PE_prepare4Navigate
 * @ argument : auc_sal_id, auc_sal_str
 * @ output : string
 **/
function PE_prepare4Navigate($property_id, $auc_sal_id = 0, $auc_sal_str = 'auction')
{
    global $property_term_cls, $auction_term_cls, $property_cls, $agent_cls, $property_entity_option_cls;
    $auction_sale_ar = PEO_getAuctionSale();
    $auction_sale = $auction_sale_ar['auction'];
    $wh_ar = array();
    $wh_str = '';
    //print_r($_SESSION);
    if (isset($_SESSION['wh_str']) && strlen($_SESSION['wh_str']) > 0) {
        $wh_str = $_SESSION['wh_str'];
        unset($_SESSION['type_prev']);
    }
    //print_r($_SESSION['where'].' '.$_SESSION['type_prev']);
    if (isset($_SESSION['where']) and $_SESSION['where'] == 'list') {
        if (!isset($_SESSION['type_prev'])) {
            if (is_array(@$_SESSION['focus']) && count(@$_SESSION['focus']) > 0 && in_array($property_id, @$_SESSION['focus'])) {
                $_SESSION['type_prev'] = 'focus';
            } else {
                $_SESSION['type_prev'] = $auc_sal_str;
            }
        }
        if (in_array($_SESSION['type_prev'],
            array('auction', 'forthcoming', 'sale', 'focus', 'the_block', 'passedin', 'my_detail', 'property_bids', 'live_agent', 'forthcoming_agent'))) {
            unset($_SESSION['wh_str']);
            switch ($_SESSION['type_prev']) {
                case 'auction':
                    $auction_sale = $auction_sale_ar['ebidda30'];
                    $wh_clause = ' AND pro.auction_sale = ' . $auction_sale . '
                                    AND pro.end_time > \'' . date('Y-m-d H:i:s') . '\'
                                    AND pro.confirm_sold=0
                                    AND pro.stop_bid = 0
                                    AND pro.start_time <= \'' . date('Y-m-d H:i:s') . '\'
                                    AND pro.pay_status = ' . Property::CAN_SHOW;
                    $entityOption = $property_entity_option_cls->getItem($auction_sale, 'for_agent');
                    if ($entityOption == Property::AUCTION_CODE_AGENT) {
                        $wh_clause .= ' AND (SELECT agtype.title
                                       FROM ' . $agent_cls->getTable('agent_type') . " AS agtype
                                       WHERE agtype.agent_type_id = agt.type_id) = 'agent'";
                    }
                    break;
                case 'forthcoming':
                    $auction_sale = $auction_sale_ar['ebidda30'];
                    $wh_clause = ' AND pro.auction_sale = ' . $auction_sale . '
                                     AND pro.confirm_sold=0
                                     AND pro.stop_bid = 0
                                     AND pro.start_time > \'' . date('Y-m-d H:i:s') . '\'
                                     AND pro.pay_status = ' . Property::CAN_SHOW;
                    $entityOption = $property_entity_option_cls->getItem($auction_sale, 'for_agent');
                    if ($entityOption == Property::AUCTION_CODE_AGENT) {
                        $wh_clause .= ' AND (SELECT agtype.title
                                       FROM ' . $agent_cls->getTable('agent_type') . " AS agtype
                                       WHERE agtype.agent_type_id = agt.type_id) = 'agent'";
                    }
                    break;
                case 'sale':
                    $auction_sale = $auction_sale_ar['private_sale'];
                    $wh_clause = ' AND pro.auction_sale = ' . $auction_sale . '
                                    AND (IF (pro.confirm_sold = 1
                                    AND datediff(\'' . date('Y-m-d H:i:s') . '\', pro.sold_time) >14 ,0,1) = 1  OR pro.confirm_sold = 0)
                                    AND pro.pay_status = ' . Property::CAN_SHOW;
                    break;
                case 'focus':
                    $wh_clause = ' AND pro.focus = 1 AND pro.stop_bid = 0
                                     AND pro.active = 1
                                     AND pro.agent_active = 1
                                     AND pro.focus = 1
                                     AND pro.stop_bid = 0
                                     AND pro.confirm_sold = 0
                                     AND pro.pay_status = ' . Property::CAN_SHOW;
                    break;
                case 'property_bids':
                    $wh_clause = $_SESSION['agent_detail']['prev_next'];
                    break;
                case 'passedin':
                    $auction_sale = array($auction_sale_ar['ebidda30'], $auction_sale_ar['ebiddar'], $auction_sale_ar['auction'], $auction_sale_ar['bid2stay']);
                    $wh_clause = ' AND pro.auction_sale IN (' . implode(',', $auction_sale) . ')
                                       AND IF((SELECT agt_typ.title FROM ' . $property_cls->getTable('agent_type') . ' AS agt_typ
                                               LEFT JOIN ' . $agent_cls->getTable() . ' AS agt ON agt.type_id = agt_typ.agent_type_id
                                               WHERE pro.agent_id = agt.agent_id)
                                               = \'agent\' AND pro.auction_sale = ' . $auction_sale_ar['auction'] . ',1,
                                       (
                                        ((SELECT IF(ISNULL(max(bid.price)),0,max(bid.price))
                                            FROM ' . $property_cls->getTable('bids') . ' AS bid
                                            WHERE pro.property_id = bid.property_id)
                                        <
                                        (SELECT pro_term.value
											FROM ' . $property_term_cls->getTable() . ' AS pro_term
											LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
											     ON pro_term.auction_term_id = term.auction_term_id
											WHERE term.code = \'reserve\'
											AND pro.property_id = pro_term.property_id )
				                        ))
                                            OR(
                                            (SELECT bid.agent_id
                                            FROM ' . $property_cls->getTable('bids') . ' AS bid
                                            WHERE pro.property_id = bid.property_id
                                                  AND (SELECT IF(ISNULL(max(bid.price)),0,max(bid.price))
                                                    FROM ' . $property_cls->getTable('bids') . ' AS bid
                                                    WHERE pro.property_id = bid.property_id) = bid.price
                                            ) = pro.agent_id
                                            AND
                                             ((SELECT IF(ISNULL(max(bid.price)),0,max(bid.price))
                                            FROM ' . $property_cls->getTable('bids') . ' AS bid
                                            WHERE pro.property_id = bid.property_id)
                                                >=
                                            (SELECT pro_term.value
                                            FROM ' . $property_term_cls->getTable() . ' AS pro_term
                                            LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
                                                 ON pro_term.auction_term_id = term.auction_term_id
                                            WHERE term.code = \'reserve\'
                                            AND pro.property_id = pro_term.property_id ))

                                        )
				                        )
								AND pro.end_time > pro.start_time
								AND (pro.stop_bid = 1 OR pro.end_time < \'' . date('Y-m-d H:i:s') . '\' )
								AND pro.confirm_sold = ' . Property::SOLD_UNKNOWN . '
								AND pro.start_time <= \'' . date('Y-m-d H:i:s') . '\'
								AND (SELECT agt_typ.title FROM ' . $property_cls->getTable('agent_type') . ' AS agt_typ
                                     LEFT JOIN ' . $agent_cls->getTable() . ' AS agt ON agt.type_id = agt_typ.agent_type_id
                                     WHERE pro.agent_id = agt.agent_id)
                                    != \'theblock\'
                                AND pro.pay_status = ' . Property::CAN_SHOW;
                    break;
                case 'live_agent':
                    $auction_sale = (isset($_SESSION['auction_type']) && strlen($_SESSION['auction_type']) > 0) ? $_SESSION['auction_type'] : $auction_sale_ar['auction'];
                    $wh_clause = ' AND pro.end_time > \'' . date('Y-m-d H:i:s') . '\'
								AND pro.auction_sale = ' . $auction_sale . '
								AND pro.confirm_sold = 0
								AND pro.end_time > pro.start_time
								AND pro.stop_bid = 0
								AND pro.start_time <= \'' . date('Y-m-d H:i:s') . '\'
								AND pro.pay_status = ' . Property::CAN_SHOW;
                    $entityOption = $property_entity_option_cls->getItem($auction_sale, 'for_agent');
                    if ($entityOption == Property::AUCTION_CODE_AGENT) {
                        $wh_clause .= ' AND (SELECT agtype.title
                                       FROM ' . $agent_cls->getTable('agent_type') . " AS agtype
                                       WHERE agtype.agent_type_id = agt.type_id) = 'agent'";
                    }
                    break;
                case 'forthcoming_agent':
                    $auction_sale = (isset($_SESSION['auction_type']) && strlen($_SESSION['auction_type']) > 0) ? $_SESSION['auction_type'] : $auction_sale_ar['auction'];
                    $wh_clause = ' AND pro.confirm_sold = 0
                                AND pro.auction_sale = ' . $auction_sale . '
								AND pro.stop_bid = 0
								AND pro.end_time > pro.start_time
								AND pro.start_time >= \'' . date('Y-m-d H:i:s') . '\'
								AND pro.pay_status = ' . Property::CAN_SHOW;
                    $entityOption = $property_entity_option_cls->getItem($auction_sale, 'for_agent');
                    if ($entityOption == Property::AUCTION_CODE_AGENT) {
                        $wh_clause .= ' AND (SELECT agtype.title
                                       FROM ' . $agent_cls->getTable('agent_type') . " AS agtype
                                       WHERE agtype.agent_type_id = agt.type_id) = 'agent'";
                    }
                    break;
                case 'the_block':
                    $wh_clause = ' AND pro.auction_sale = ' . $auction_sale_ar['auction'] . '
                                     AND pro.confirm_sold=0
                                     AND pro.pay_status = ' . Property::CAN_SHOW;
                    break;
                case 'my_detail':
                    if ($_SESSION['agent']['type'] == 'theblock') {
                        $wh_clause = ' AND (pro.agent_id IN (SELECT agent_id FROM ' . $agent_cls->getTable() . ' WHERE parent_id = ' . $_SESSION['agent']['id'] . ')
                                                    OR IF(ISNULL(pro.agent_manager)
                                                          OR pro.agent_manager = 0
                                                          OR (SELECT parent_id FROM ' . $agent_cls->getTable() . ' WHERE agent_id = ' . $_SESSION['agent']['id'] . ') = 0
                                                          ,pro.agent_id = ' . $_SESSION['agent']['id'] . '
                                                          , pro.agent_manager = ' . $_SESSION['agent']['id'] . '))';
                    } else {
                        $wh_clause = ' AND pro.agent_id = ' . $_SESSION['agent']['id'];
                    }
            }
            /*$wh_str .= " AND IF (pro.auction_sale = " . $auction_sale_ar['auction'] . '
                                       AND (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\',0,pro_term.value)
                                            FROM ' . $property_term_cls->getTable() . ' AS pro_term
                                            LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
                                            ON pro_term.auction_term_id = term.auction_term_id
                                            WHERE term.code = \'auction_start_price\' AND pro.property_id = pro_term.property_id ) = 0, 0, 1) = 1
                                   ' . $wh_clause;*/
            //return $wh_clause;
        }
    }
    $wh_str = $wh_clause != '' ? $wh_str . ' ' . $wh_clause : $wh_str;
    return ' ' . $wh_str;
}

/**
 * @ function : PE_getNextAction
 * @ argument : $row
 * @ output : string
 **/
function PE_getNextAction($row)
{
    //BEGIN FOR SEARCH , THAT IS NOT DISTINCT AUCTION OR SALE
    $auction_sale_ar = PEO_getAuctionSale();
    $act = '';
    if ($row['auction_sale'] == $auction_sale_ar['private_sale']) {
        $act = 'sale';
    } else if ($row['start_time'] <= date('Y-m-d H:i:s')) {
        $act = 'auction';
    } else {
        $act = 'forthcoming';
    }
    //END
    return $act;
}

/**
 * @ function : PE_getOrderBy
 * @ argument : directly
 * @ output : string
 **/
function PE_getOrderBy($directly = 'ASC')
{
    if (isset($_SESSION['order_str']) && strlen($_SESSION['order_str']) > 0) {
        $order_str = str_replace(array('asc', 'desc'), array(''), strtolower($_SESSION['order_str']));
        return $order_str . ' ' . $directly;
    }
    return 'pro.property_id ' . $directly;
}

/**
 * @ function : PE_navLink_new
 * @ argument :
 * @ output :
 **/
function PE_navLink_new($type = '', $property_id = 0)
{
    $link = '';
    global $property_cls, $config_cls, $agent_cls, $region_cls, $property_entity_option_cls, $bids_first_cls, $property_history_cls, $agent_payment_cls;
    if (is_array($_SESSION['prev_next_ids_ar']) && count($_SESSION['prev_next_ids_ar']) > 1) {
        $prev_next_ids_ar = $_SESSION['prev_next_ids_ar'];
        $key = array_search($property_id, $prev_next_ids_ar);
        if ($type == 'next') {
            $nav_id = $prev_next_ids_ar[$key + 1];
        }
        if ($type == 'prev') {
            $nav_id = $prev_next_ids_ar[$key - 1];
        }
        /*if(empty($nav_id)){
                $nav_id = $prev_next_ids_ar[0];
            }*/
        if (!empty($nav_id) && $nav_id > 0) {
            $sql = 'SELECT pro.property_id,
						pro.auction_sale,
						pro.start_time,
						pro.address,
						pro.suburb,
						pro.state,
						pro.postcode,
						(SELECT reg1.code
						FROM ' . $region_cls->getTable() . ' AS reg1
						WHERE reg1.region_id = pro.state
						) AS state_code,

						(SELECT reg2.name
						FROM ' . $region_cls->getTable() . ' AS reg2
						WHERE reg2.region_id = pro.country
						) AS country_name,

						(SELECT pro_opt4.code
						FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt4
						WHERE pro_opt4.property_entity_option_id = pro.auction_sale
						) AS auctionsale_code


				FROM ' . $property_cls->getTable() . ' AS pro
				WHERE pro.property_id = ' . $nav_id;
            $row = $property_cls->getRow($sql, true);
            if (is_array($row) and count($row) > 0) {
                $link = '<a href="' . shortUrl(array('module' => 'property', 'action' => 'view-' . PE_getNextAction($row) . '-detail', 'id' => $nav_id) + array('data' => $row), (PE_isTheBlock($nav_id, 'agent') ? Agent_getAgent($nav_id) : array())) . '">' . ($type == 'next' ? 'Next property' : 'Previous property') . '</a>';
            }
        }
    }
    return $link;
}

/**
 * @ function : PE_navLink
 * @ argument :
 * @ output :
 **/
function PE_navLink($type = '', $property_id = 0, $auc_sal_id = 0, $auc_sal_str = 'auction')
{
    global $property_cls, $config_cls, $agent_cls, $region_cls, $property_entity_option_cls, $bids_first_cls, $property_history_cls, $agent_payment_cls;
    $rs = '';
    $auction_sale_ar = PEO_getAuctionSale();
    //BEGIN FOR LOCK THE BLOCK PROPERTY: NHUNG
    $date_lock = (int)$config_cls->getKey('date_lock');
    $join_ar = array();
    if ($_SESSION['type_prev'] == 'the_block') {
        $join_ar[] = 'INNER JOIN ' . $property_cls->getTable('agent') . ' AS agt ON pro.agent_id = agt.agent_id AND agt.type_id IN
						(SELECT agt_typ.agent_type_id
						FROM ' . $property_cls->getTable('agent_type') . ' AS agt_typ
						WHERE agt_typ.title = \'theblock\')';
    } else {
        $join_ar[] = 'INNER JOIN ' . $property_cls->getTable('agent') . ' AS agt ON pro.agent_id = agt.agent_id';
    }
    if (isset($_SESSION['join']) && strlen($_SESSION['join']) > 0 && $_SESSION['where'] != 'list' && $_SESSION['where'] != 'search') {
        $join_ar[] = $_SESSION['join'];
    }
    $where_ar = array();
    $where_ar[] = 'pro.property_id ' . ($type == 'next' ? '>' : '<') . (int)$property_id;
    /*IBB-1022:Hide The Block properties from view in the Online Auctions section: NHUNG*/
    /*if (!(in_array($_SESSION['type_prev'],array('the_block','property_bids')) || $_SESSION['where'] == 'watchlist')){
            $where_ar[] = 'AND (SELECT agtype.title
                       FROM '.$agent_cls->getTable('agent_type')." AS agtype
                       WHERE agtype.agent_type_id = agt.type_id) != 'theblock'";
        }*/
    /*IBB-1053: Hide switch property is not complete in my watchlist and my property_bid: NHUNG*/
    if ($_SESSION['type_prev'] == 'property_bids' || $_SESSION['where'] == 'watchlist') {
        $test = $_SESSION['type_prev'] == 'property_bids' ? ' AND pro.auction_sale != ' . $auction_sale_ar['private_sale'] : '';
        $where_ar[] = ' AND IF((SELECT MAX(h.transition_time)
                                  FROM ' . $property_history_cls->getTable() . " AS h
                                  WHERE h.property_id = pro.property_id) = ''
                                  ,1
                                  ,pro.active = 1
                                   AND pro.agent_active = 1
                                   AND pro.pay_status = " . Property::PAY_COMPLETE . '
                                   AND pro.price != \'\'
                                   ' . $test . ')';
    }
    $where_ar[] = PE_prepare4Navigate($property_id, $auc_sal_id, $auc_sal_str);
    if ($_SESSION['type_prev'] != 'my_detail') {
        $where_ar[] = ' AND pro.active = 1 AND pro.agent_active = 1 AND pro.pay_status = ' . Property::CAN_SHOW;
        if (isset($_SESSION['agent']) and $_SESSION['agent']['id'] > 0) {
            //agent is the block/is not the block
            $lock_str = " IF(
                                    (SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at WHERE agt.type_id = at.agent_type_id) IN ('theblock'),

                                    (SELECT p.pay_bid_first_status
									 FROM " . $bids_first_cls->getTable() . " AS p
                                     WHERE p.property_id = pro.property_id
									 		AND p.agent_id = " . $_SESSION['agent']['id'] . ")> 0
                                     		OR '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00',DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY),pro.date_to_reg_bid)
                                     		OR (IF(ISNULL(pro.agent_manager)
                                            		OR pro.agent_manager = 0
                                            		,pro.agent_id = '{$_SESSION['agent']['id']}'
                                            		,pro.agent_manager = '{$_SESSION['agent']['id']}')
                                         	|| pro.agent_id IN (SELECT a.agent_id FROM agent AS a WHERE a.parent_id = {$_SESSION['agent']['id']})
                                         	|| (pro.agent_id = '{$_SESSION['agent']['id']}' AND agt.parent_id = 0))

                                    ,1)";
        } else {
            $lock_str = "IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at WHERE agt.type_id = at.agent_type_id) IN ('theblock'),
                               '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00',
                                                              DATE_SUB(pro.start_time
                                                              ,INTERVAL {$date_lock} DAY)
                                 ,pro.date_to_reg_bid)
                             ,1)";
        }
        //IBB-1224: unlock/lock the block properties after the auctions
        $lock_status = (int)$config_cls->getKey('theblock_status');
        if ($lock_status == 0) {//unlock
            $lock_type = $config_cls->getKey('theblock_show_type_properties');
            $lock_type_ar = explode(',', $lock_type);
            $unlock_str = 1;
            if (count($lock_type_ar) > 0) {
                foreach ($lock_type_ar as $_type) {
                    switch ($_type) {
                        case 'sold':
                            $unlock_arr[] = "pro.confirm_sold = 1";
                            break;
                        case 'passed_in':
                            $unlock_arr[] = "(pro.confirm_sold = 0 AND pro.stop_bid = 1)";
                            break;
                        case 'live':
                            $unlock_arr[] = "(pro.end_time > '" . date('Y-m-d H:i:s') . "'
                                                  AND pro.confirm_sold = 0
                                                  AND pro.stop_bid = 0
                                                  AND pro.end_time > pro.start_time
                                                  AND pro.start_time <= '" . date('Y-m-d H:i:s') . "')";
                            break;
                        case 'forthcoming':
                            $unlock_arr[] = "(pro.start_time > '" . date('Y-m-d H:i:s') . "'
                                                  AND pro.confirm_sold = 0
                                                  AND pro.stop_bid = 0)";
                            break;
                    }
                }
                $_unlock_str = ' OR ' . implode(' OR ', $unlock_arr);
                if (isset($_SESSION['agent']) and $_SESSION['agent']['id'] > 0) {
                    $unlock_str = " IF(
                                            (SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at WHERE agt.type_id = at.agent_type_id) IN ('theblock'),

                                            (SELECT p.pay_bid_first_status FROM " . $bids_first_cls->getTable() . " AS p
                                             WHERE p.property_id = pro.property_id AND p.agent_id = " . $_SESSION['agent']['id'] . ")> 0
                                             OR '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY),pro.date_to_reg_bid)
                                             OR (IF(ISNULL(pro.agent_manager)
                                                    OR pro.agent_manager = 0
                                                    ,pro.agent_id = {$_SESSION['agent']['id']}
                                                    , pro.agent_manager = '{$_SESSION['agent']['id']}')
                                                 || pro.agent_id IN (SELECT a.agent_id FROM agent AS a WHERE a.parent_id = {$_SESSION['agent']['id']})
                                                 || (pro.agent_id = '{$_SESSION['agent']['id']}' AND agt.parent_id = 0))
                                             {$_unlock_str}

                                            ,1)";
                } else {
                    $unlock_str = "IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at
                                               WHERE agt.type_id = at.agent_type_id) IN ('theblock'),
                                              '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,
                                                                             DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY)
                                                                             ,pro.date_to_reg_bid)
                                              {$_unlock_str}
                                              ,1)
                                           ";
                }
            }
            $date_open_lock = $config_cls->getKey('theblock_date_lock');
            $where_ar[] = " AND IF ('" . date('Y-m-d H:i:s') . "' < '" . $date_open_lock . "',{$lock_str},{$unlock_str})";
        } else {
            $where_ar[] = ' AND ' . $lock_str;
        }
        //HIDE AGENT's PROPERTIES DIDN'T PAYMENT
        $where_ar[] = " AND IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at
                                   WHERE agt.type_id = at.agent_type_id) IN ('agent')
                                   ,(SELECT ap.payment_id FROM " . $agent_payment_cls->getTable() . " AS ap
                                     WHERE ap.agent_id = IF(agt.parent_id = '',agt.agent_id,agt.parent_id)
                                           AND ap.date_from <= '" . date('Y-m-d H:i:s') . "' AND ap.date_to >= '" . date('Y-m-d H:i:s') . "'
                                     ) != ''
                                   ,1)";
        //DON'T ALLOW SHOW PROPERTIES OF INACTIVE AGENT
        $where_ar[] = " AND IF(ISNULL(pro.agent_manager) || pro.agent_manager = '' || pro.agent_manager = 0
                            , agt.is_active = 1
                            ,(SELECT a.is_active FROM " . $agent_cls->getTable() . " AS a WHERE a.agent_id = pro.agent_manager) = 1)
                            ";
    }
    $sql = 'SELECT pro.property_id,
						pro.auction_sale,
						pro.start_time,
						pro.address,
						pro.suburb,
						pro.state,
						pro.postcode,
						(SELECT reg1.code
						FROM ' . $region_cls->getTable() . ' AS reg1
						WHERE reg1.region_id = pro.state
						) AS state_code,

						(SELECT reg2.name
						FROM ' . $region_cls->getTable() . ' AS reg2
						WHERE reg2.region_id = pro.country
						) AS country_name,

						(SELECT pro_opt4.code
						FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt4
						WHERE pro_opt4.property_entity_option_id = pro.auction_sale
						) AS auctionsale_code


				FROM ' . $property_cls->getTable() . ' AS pro ' . implode(' ', $join_ar) . '
				WHERE ' . implode(' ', $where_ar) . '
				ORDER BY ' . ($type == 'next' ? PE_getOrderBy('ASC') : PE_getOrderBy('DESC'));
    //echo $sql;die();
    $row = $property_cls->getRow($sql, true);
    if (is_array($row) and count($row) > 0) {
        $rs = '<a href="' . shortUrl(array('module' => 'property', 'action' => 'view-' . PE_getNextAction($row) . '-detail', 'id' => $row['property_id']) + array('data' => $row), (PE_isTheBlock($row['property_id'], 'agent') ? Agent_getAgent($row['property_id']) : array())) . '">' . ($type == 'next' ? 'Next property' : 'Previous property') . '</a>';
    }
    return $rs;
}

/**
 * @ function : PE_nextAdminLink
 * @ argument :
 * @ output :
 **/
function PE_navAdminLink($type = '', $property_id = 0)
{
    global $property_cls, $token;
    $rs = '';
    $row = $property_cls->getRow('property_id ' . ($type == 'next' ? '>' : '<') . ' ' . (int)$property_id . '  ORDER BY property_id ' . ($type == 'next' ? 'ASC' : 'DESC'));
    if (is_array($row) and count($row) > 0) {
        $label = $type == 'next' ? 'Next &gt;&gt;' : '&lt;&lt; Previous';
        $rs = '<a href="?module=property&action=edit-detail&property_id=' . $row['property_id'] . '&token=' . $token . '">' . $label . '</a>';
    }
    return $rs;
}

/**
 * @ function : PE_getUrl
 * @ argument :
 * @ output :
 **/
function PE_getUrl($property_id = 0)
{
    global $property_cls, $property_entity_option_cls, $region_cls;
    $link = '';
    $sql = 'SELECT pro.property_id,
						pro.auction_sale,
						pro.start_time,
						pro.address,
						pro.suburb,
						pro.state,
						pro.postcode,
						(SELECT reg1.code
						FROM ' . $region_cls->getTable() . ' AS reg1
						WHERE reg1.region_id = pro.state
						) AS state_code,

						(SELECT reg2.name
						FROM ' . $region_cls->getTable() . ' AS reg2
						WHERE reg2.region_id = pro.country
						) AS country_name,

						(SELECT pro_opt4.code
						FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt4
						WHERE pro_opt4.property_entity_option_id = pro.auction_sale
						) AS auctionsale_code

				FROM ' . $property_cls->getTable() . ' AS pro
				WHERE pro.property_id = ' . (int)$property_id;
    $row = $property_cls->getRow($sql, true);
    if (is_array($row) and count($row) > 0) {
        //$link = shortUrl(array('module' => 'property', 'action' => 'view-'.PE_getNextAction($row).'-detail', 'id' => $row['property_id']) + array('data' => $row),(PE_isTheBlock($row['property_id'],'agent')?Agent_getAgent($row['property_id']):array()));
        $link = shortUrl(array('module' => 'property', 'action' => 'view-' . PE_getNextAction($row) . '-detail', 'id' => $row['property_id']) + array('data' => $row), (PE_isTheBlock($row['property_id'], 'agent') ? Agent_getAgent($row['property_id']) : array()));
    }
    return $link;
}

/**
 * @ function : PE_updateHasAuctionTerm
 * @ argument : property_id
 * @ output : void
 * ----------
 * update has_auction_term = 1 if auction
 * has_auction_term = 0 if private_sale
 */
function PE_updateHasAuctionTerm($property_id = 0)
{
    global $property_cls;
    if ($property_id <= 0) return;
    $row = $property_cls->getRow('property_id = ' . $property_id);
    if (is_array($row) and count($row) > 0) {
        $auction_sale_ar = PEO_getAuctionSale();
        $val = $row['auction_sale'] == $auction_sale_ar['auction'] ? 1 : 0;
        //$property_cls->update(array('has_auction_term' => $val), 'property_id = '.$property_id);
    }
}

/**
 * @ function : PE_isAuction
 * @ argument : property_id
 * @ output : bool
 * -------
 * check it is auction or not
 */
function PE_isAuction($property_id = 0, $auction_sale_code = '')
{
    global $property_cls;
    if ($property_id <= 0) return false;
    $row = $property_cls->getRow('property_id = ' . $property_id);
    if (is_array($row) and count($row) > 0) {
        $auction_sale_ar = PEO_getAuctionSale();
        if ($row['auction_sale'] != $auction_sale_ar['private_sale']) {
            if ($auction_sale_code != '') {
                return $row['auction_sale'] == $auction_sale_ar[$auction_sale_code];
            }
            return true;
        }
        return false;
    }
    return false;
}

function PE_isNormalAuction($property_id = 0)
{
    global $property_cls;
    if ($property_id <= 0) return false;
    $row = $property_cls->getRow('property_id = ' . $property_id);
    if (is_array($row) and count($row) > 0) {
        $auction_sale_ar = PEO_getAuctionSale();
        if ($row['auction_sale'] == $auction_sale_ar['auction']) {
            return true;
        }
        return false;
    }
    return false;
}

/**
 * @ function : PE_isManagerTheBlock
 * @ argument : property_id
 * @ output : bool
 * -------
 * check it is The Block Property or not
 */
function PE_isManagerOrVendorTheBlock($property_id = 0, $agent_id = 0)
{
    global $property_cls, $agent_cls;
    if (!isset($property_cls) || !($property_cls instanceof Property)) {
        $property_cls = new Property();
    }
    if ($property_id <= 0) {
        return false;
    }
    $row = $property_cls->getRow('
            SELECT pro.*
            FROM ' . $property_cls->getTable() . ' as pro
            WHERE pro.property_id = ' . $property_id . '
                  AND (pro.agent_id IN (SELECT agent_id FROM ' . $agent_cls->getTable() . ' WHERE parent_id = ' . $agent_id . ')
                     OR IF(ISNULL(pro.agent_manager)
                            OR pro.agent_manager = 0
                            OR (SELECT parent_id FROM ' . $agent_cls->getTable() . ' WHERE agent_id = ' . $agent_id . ') = 0
                        ,pro.agent_id = ' . $agent_id . '
                        ,pro.agent_manager = ' . $agent_id . '))', true);
    if (is_array($row) and count($row) > 0) {
        return true;
    }
    return false;
}

/**
 * @ function : PE_getManager
 * @ argument : property_id
 * @ output : bool
 * -------
 * check it is The Block Property or not
 */
function PE_getManager($property_id = 0)
{
    global $property_cls;
    $row = $property_cls->getCRow(array('agent_id', 'agent_manager'), ' property_id = ' . (int)$property_id);
    if (is_array($row) and count($row) > 0) {
        return (int)$row['agent_manager'] > 0 ? $row['agent_manager'] : $row['agent_id'];
    }
    return 0;
}

/**
 * @ function : PE_isTheBlock
 * @ argument : property_id
 * @ output : bool
 * -------
 * check it is The Block Property or not
 */
function PE_isTheBlock($property_id = 0, $type = 'theblock')
{
    global $property_cls;
    if (!isset($property_cls) || !($property_cls instanceof Property)) {
        $property_cls = new Property();
    }
    if ($property_id <= 0) {
        return false;
    }
    $row = $property_cls->getCRow(array('agent_id'), 'property_id = ' . $property_id);
    if (is_array($row) and count($row) > 0) {
        $agent_row = $property_cls->getRow('SELECT agt.agent_id
                                                FROM ' . $property_cls->getTable('agent') . ' AS agt
                                                WHERE  agt.agent_id = ' . $row['agent_id'] . '
                                                AND  agt.type_id IN
											        (SELECT agt_typ.agent_type_id
											        FROM ' . $property_cls->getTable('agent_type') . ' AS agt_typ
											        WHERE agt_typ.title = \'' . $type . '\')', true);
        if (is_array($agent_row) and count($agent_row) > 0) {
            return true;
        }
        return false;
    }
    return false;
}

/**
 * @ function : PE_isLiveProperty
 * @ argument : property_id
 * @ output : bool
 * -------
 * check it is show on site ?
 */
function PE_isLiveProperty($property_id = 0)
{
    global $property_cls;
    if ($property_id > 0) {
        $row = $property_cls->getRow('property_id=' . $property_id);
        if (count($row) > 0 and is_array($row)) {
            if (((PE_isAuction($property_id)
                        AND PT_getValueByCode($property_id, 'auction_start_price') != null
                        AND PT_getValueByCode($property_id, 'reserve') != null
                    )
                    OR (!PE_isAuction($property_id) AND $row['price'] != null))
                AND $row['confirm_sold'] == 0
                AND $row['stop_bid'] == 0
                AND $row['pay_status'] == Property::PAY_COMPLETE
                AND $row['active'] == 1
                AND $row['agent_active'] == 1
            ) {
                return true;
            }
        }
    }
    return false;
}

/**
 * @ function : PE_isLiveAuction
 * @ argument : property_id
 * @ output : bool
 * -------
 * check it is live Auction and show in Live Auction List
 */
function PE_isLiveAuction($property_id = 0)
{
    global $property_cls;
    if ($property_id <= 0) return false;
    $row = $property_cls->getRow('property_id = ' . $property_id);
    if (is_array($row) and count($row) > 0) {
        $auction_sale_ar = PEO_getAuctionSale();
        if ($auction_sale_ar['auction'] == $row['auction_sale']
            AND PT_getValueByCode($property_id, 'auction_start_price') != null
            AND PT_getValueByCode($property_id, 'reserve') != null
            and $row['pay_status'] == Property::PAY_COMPLETE
            and $row['active'] == 1
            and $row['agent_active'] == 1
            and $row['start_time'] <= date('Y-m-d H:i:s')
            and $row['end_time'] >= date('Y-m-d H:i:s')
            and $row['stop_bid'] == 0
            and $row['confirm_sold'] == Property::SOLD_UNKNOWN
        ) {
            return true;
        }
    }
    return false;
}

function PE_isstopAuction($property_id = 0)
{
    global $property_cls;
    if ($property_id <= 0) return false;
    $row = $property_cls->getRow('property_id = ' . $property_id);
    if (is_array($row) and count($row) > 0) {
        $auction_sale_ar = PEO_getAuctionSale();
        if ($auction_sale_ar['auction'] != $row['private_sale']
            AND PT_getValueByCode($property_id, 'auction_start_price') != null
            AND PT_getValueByCode($property_id, 'reserve') != null
            and $row['pay_status'] == Property::PAY_COMPLETE
            and $row['active'] == 1
            and $row['agent_active'] == 1
            and $row['start_time'] < date('Y-m-d H:i:s')
            and $row['stop_bid'] == 1
        ) {
            return true;
        }
    }
    return false;
}

function PE_isForthAuction($property_id = 0)
{
    global $property_cls;
    if ($property_id <= 0) return false;
    $row = $property_cls->getRow('property_id = ' . $property_id);
    if (is_array($row) and count($row) > 0) {
        $auction_sale_ar = PEO_getAuctionSale();
        if ($auction_sale_ar['private_sale'] != $row['auction_sale']
            AND PT_getValueByCode($property_id, 'auction_start_price') != null
            AND PT_getValueByCode($property_id, 'reserve') != null
            and $row['pay_status'] == Property::PAY_COMPLETE
            and $row['active'] == 1
            and $row['agent_active'] == 1
            and $row['start_time'] > date('Y-m-d H:i:s')
            and $row['end_time'] > date('Y-m-d H:i:s')
            and $row['stop_bid'] == 0
            and $row['confirm_sold'] == 0
        ) {
            return true;
        }
    }
    return false;
}

function PE_isLiveSale($property_id = 0)
{
    global $property_cls;
    if ($property_id <= 0) return false;
    $row = $property_cls->getRow('property_id = ' . $property_id);
    if (is_array($row) and count($row) > 0) {
        $auction_sale_ar = PEO_getAuctionSale();
        if ($auction_sale_ar['private_sale'] == $row['auction_sale']
            and $row['pay_status'] == Property::PAY_COMPLETE
            and $row['active'] == 1
            and $row['agent_active'] == 1
            and $row['stop_bid'] == 0
            and $row['confirm_sold'] == 0
        ) {
            return true;
        }
    }
    return false;
}

function showAdvertisedPrice($property_id = 0)
{
    global $property_cls;
    $advertised_price_str = '';
    if ($property_id <= 0) return $advertised_price_str;
    $row = $property_cls->getCRow(array('advertised_price_from', 'advertised_price_to'), 'property_id = ' . $property_id);
    if (is_array($row) and count($row) > 0) {
        if (!($row['advertised_price_from'] > 0)) {
            $advertised_price_str = 'POA';
        }
        if ($row['advertised_price_from'] > 0) {
            $advertised_price_str = showPrice($row['advertised_price_from']);
            if ($row['advertised_price_to'] > 0) {
                $advertised_price_str .= ' - ' . showPrice($row['advertised_price_to']);;
            }
        }
    }
    return $advertised_price_str;
}
function isNoSetAuctionTime($property_id = 0)
{
    global $property_cls;
    $isNoSetAuctionTime = false;
    if ($property_id <= 0) return $isNoSetAuctionTime;
    $row = $property_cls->getCRow(array('start_time', 'end_time'), 'property_id = ' . $property_id);
    if (is_array($row) and count($row) > 0) {
        if($row['start_time'] == '5000-05-05 00:00:00' && $row['end_time'] == '5000-06-06 00:00:00'){
            $isNoSetAuctionTime = true;
        }
    }
    return $isNoSetAuctionTime;
}

function PE_getMinMaxIncMess($min = 0, $max = 0)
{
    $mess = $maxInc = $minInc_price = $maxInc_price = $minmaxInc_mess = "";
    $min = ($min == "") ? 0 : (int)$min;
    $max = ($max == "") ? 0 : (int)$max;
    if ($min != 0) {
        $minInc_price = showPrice($min);
        $minmaxInc_mess = 'minimum is: <label style="font-weight: bold"> ' . $minInc_price . '</label>';
    }
    if ($max != 0) {
        $maxInc_price = showPrice($max);
        $minmaxInc_mess = ($min != 0) ? 'range is:<label style="font-weight: bold"> ' . $minInc_price . '</label> - <label style="font-weight: bold"> ' . $maxInc_price . '</label>' : 'maximum is: <label style="font-weight: bold"> ' . $maxInc_price . '</label>';
    }
    if ($min != 0 || $max != 0) {
        $mess = "you can only bid inline with the auctioneers set increments, " . $minmaxInc_mess;
    }
    return $mess;
}

/**
 * @ function : PE_getComments
 * @ argument : property_id
 * @ output : array
 **/
function PE_getComments($property_id = 0)
{
    global $comment_cls, $pag_cls, $smarty;
    $comment_p = 0;
    $comment_len = 5;
    if ($property_id == 0) {
        return array();
    }
    $comment_data = array();
    $comment_rows = $comment_cls->getRows('SELECT SQL_CALC_FOUND_ROWS
														comment_id,
														name,
														email,
														title,
														content,
														created_date
												FROM ' . $comment_cls->getTable() . '
												WHERE property_id = ' . $property_id . ' AND active = 1
												ORDER BY comment_id DESC
												LIMIT ' . $comment_p . ',' . $comment_len, true);
    $total_row = $comment_cls->getFoundRows();
    $pag_cls->setTotal($total_row)
        ->setPerPage($comment_len)
        ->setCurPage($comment_p)
        ->setLenPage(10)
        ->setUrl('/modules/comment/action.php?action=view-comment&property_id=' . $property_id)
        ->setLayout('ajax')
        ->setFnc('com.view');
    $smarty->assign('comment_pag_str', $pag_cls->layout());
    $data = array();
    if ($comment_cls->hasError()) {
    } elseif (is_array($comment_rows) and count($comment_rows) > 0) {
        $data = $comment_rows;
    }
    return $data;
}

/**
 * @ function : PE_getItemPerPage
 * @ argument : void
 * @ output : array
 **/
function PE_getItemPerPage()
{
    global $config_cls;
    $output = array();
    $page_str = $config_cls->getKey('general_item_per_page');
    if (strlen($page_str) > 0) {
        $page_ar = explode(',', $page_str);
        if (is_array($page_ar) && count($page_ar) > 0) {
            foreach ($page_ar as $val) {
                $output[(int)$val] = (int)$val;
            }
        }
    }
    if (count($output) == 0) {
        $output = array(3 => 3, 6 => 6, 9 => 9, 12 => 12);
    }
    return $output;
}

/**
 * @ function : PE_getPriceForBid
 * @ param : property_id
 * @ output : mixed (int|float)
 **/
function PE_getPriceForBid($property_id = 0)
{
    global $property_cls, $property_term_cls, $auction_term_cls, $bid_cls;
    $auction_sale_ar = PEO_getAuctionSale();
    $row = $property_cls->getRow('SELECT
											(SELECT pro_term.value
											 FROM ' . $property_term_cls->getTable() . ' AS pro_term
											 LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
													 ON pro_term.auction_term_id = term.auction_term_id
											 WHERE term.code = \'auction_start_price\' AND pro_term.property_id = pro.property_id
											 ) AS start_price,

											 (SELECT IF(ISNULL(MAX(bid.price)), 0, MAX(bid.price))
											 FROM ' . $bid_cls->getTable() . ' AS bid
											 WHERE bid.property_id = pro.property_id) AS bid_price

									  FROM ' . $property_cls->getTable() . ' AS pro
									  WHERE pro.property_id = ' . $property_id, true);
    if (is_array($row) && count($row) > 0 && ($row['start_price'] > 0 || $row['bid_price'] > 0)) {
        return $row['bid_price'] > $row['start_price'] ? $row['bid_price'] : $row['start_price'];
    }
    return 0;
}

/**
 * @ function : PE_getBanner
 * @ param : property_id
 * @ output : string: Find BAnner With Suburb
 **/
function PE_getBanner($data)
{
    return getBannerByDataEA($data);
}

/**
 * @ function : PE_getReview
 * @ param : agent_id, property_id
 * @ output : array
 **/
function PE_getReview($agent_id = 0, $property_id = 0, $type = '')
{
    global $region_cls, $property_entity_option_cls, $property_cls, $property_rating_mark_cls, $config_cls, $agent_cls;
    if ($type == 'theblock') {
        $wh_str = 'property_id = ' . $property_id . '
                           AND (IF(ISNULL(agent_manager)
                                OR agent_manager = 0
                                OR (SELECT parent_id FROM ' . $agent_cls->getTable() . ' WHERE agent_id = ' . $_SESSION['agent']['id'] . ') = 0
                                ,agent_id = ' . $agent_id . '
                                , agent_manager = ' . $agent_id . ')
                                OR agent_id IN (SELECT a.agent_id FROM agent AS a WHERE a.parent_id = ' . $agent_id . '))';
    } else {
        $wh_str = 'property_id = ' . $property_id . ' AND agent_id = ' . $agent_id;
    }
    $review = array();
    if ($property_id > 0 and $agent_id > 0) {
        $sql = 'SELECT SQL_CALC_FOUND_ROWS
                            pro.property_id,
							pro.kind,
							pro.auction_sale,
							pro.parking,
                            pro.address,
                            pro.price,
                            pro.price_on_application,
                            pro.suburb,
                            pro.postcode,
                            pro.end_time,
                            pro.livability_rating_mark,
                            pro.green_rating_mark,
                            pro.step,
                            pro.land_size,
                            pro.focus,
                            pro.set_jump,
                            pro.price_on_application,

                            (SELECT reg1.code
                            FROM ' . $region_cls->getTable() . ' AS reg1
                            WHERE reg1.region_id = pro.state
                            ) AS state_code,

                            (SELECT reg2.code
                            FROM ' . $region_cls->getTable() . ' AS reg2
                            WHERE reg2.region_id = pro.state
                            ) AS state_code,

                            (SELECT reg3.name
                            FROM ' . $region_cls->getTable() . ' AS reg3
                            WHERE reg3.region_id = pro.country
                            ) AS country_name,

                            (SELECT reg4.code
                            FROM ' . $region_cls->getTable() . ' AS reg4
                            WHERE reg4.region_id = pro.country
                            ) AS country_code,

                            (SELECT pro_opt1.value
                            FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt1
                            WHERE pro_opt1.property_entity_option_id = pro.bathroom
                            ) AS bathroom_value,

                            (SELECT pro_opt2.value
                            FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt2
                            WHERE pro_opt2.property_entity_option_id = pro.bedroom
                            ) AS bedroom_value,

                            (SELECT pro_opt3.value
                            FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt3
                            WHERE pro_opt3.property_entity_option_id = pro.car_port
                            ) AS carport_value,

                            (SELECT pro_opt6.code
                            FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt6
                            WHERE pro_opt6.property_entity_option_id = pro.auction_sale
                            ) AS auction_sale_code,

							(SELECT pro_opt6.title
                            FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt6
                            WHERE pro_opt6.property_entity_option_id = pro.auction_sale
                            ) AS auction_sale_title,

                            (SELECT pro_opt8.value
                            FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt8
                            WHERE pro_opt8.property_entity_option_id = pro.car_space
                            ) AS carspace_value


                    FROM ' . $property_cls->getTable() . ' AS pro
                    WHERE ' . $wh_str;
        $row = $property_cls->getRow($sql, true);
        $review = array();
        if (is_array($row) and count($row) > 0) {
            $review['info'] = $row;
            if ($row['auction_sale_code'] != 'private_sale') {
                $dt = new DateTime($row['end_time']);
                if (PE_isTheBlock($property_id, 'agent')) {
                    $review['info']['title'] = strtoupper($row['auction_sale_title']) . ' ';
                } else {
                    $review['info']['title'] = 'AUCTION ';
                }
                if (!(PE_isTheBlock($property_id) || (PE_isTheBlock($property_id, 'agent')))) {
                    $review['info']['title'] .= $dt->format($config_cls->getKey('general_date_format'));
                } else {
                    $dt1 = new DateTime($row['start_time']);
                    $review['info']['title'] .= $dt1->format($config_cls->getKey('general_date_format'));
                }
            } else {
                $review['info']['title'] = 'PRIVATE SALE';
            }
            if ($review['info']['bedroom_value'] == null) {
                $review['info']['bedroom_value'] = 0;
            }
            if ($review['info']['bathroom_value'] == null) {
                $review['info']['bathroom_value'] = 0;
            }
            $review['info']['full_address'] = $row['address'] . ' ' . $row['suburb'] . ' ' . $row['postcode'] . ' ' . $row['state_code'] . ' ' . $row['country_name'];
            $review['info']['livability_rating_mark'] = showStar((float)$row['livability_rating_mark']);
            $review['info']['green_rating_mark'] = showStar((float)$row['green_rating_mark']);
            $review['info']['description'] = safecontent($row['description'], 100);
            $auction_sale_ar = PEO_getAuctionSale();
            $review['info']['price'] = $row['price_on_application'] == 1 ? 'Price On Application' : showPrice($row['price']);
            /* if($row['auction_sale'] == $auction_sale_ar['private_sale'])
                {
                    if($row['price'] == 0 or $row['price'] == '')
                    {
                        $review['info']['price'] = showPrice($row['price_on_application']);
                    }
                }*/
            $type = ($row['auction_sale_code'] == 'auction') ? 'auction' : 'sale';
            $review['info']['link'] = '?module=property&action=register&id=' . $row['property_id'];
            if ($row['property_step'] > 1 && $row['property_step'] < 8) {
                $review['info']['link'] .= '&step=' . $row['property_step'];
            }
            $photo_ar = PM_getPhoto($row['property_id'], true);
            $review['photo'] = $photo_ar['photo_thumb_default'];
            $review['info']['auction_sale_code'] = $row['auction_sale_code'];
        }
    }
    return $review;
}

function PE_getInfo($property_id = 0)
{
    global $region_cls, $property_entity_option_cls, $property_cls, $property_rating_mark_cls, $config_cls, $agent_cls;
    $wh_str = 'property_id = ' . $property_id;
    $review = array();
    if ($property_id > 0) {
        $sql = 'SELECT SQL_CALC_FOUND_ROWS
                                pro.property_id,
                                pro.kind,
                                pro.auction_sale,
                                pro.parking,
                                pro.address,
                                pro.price,
                                pro.price_on_application,
                                pro.suburb,
                                pro.postcode,
                                pro.end_time,
                                pro.livability_rating_mark,
                                pro.green_rating_mark,
                                pro.step,
                                pro.land_size,
                                pro.focus,
                                pro.set_jump,
                                pro.price_on_application,

                                (SELECT reg1.name
                                FROM ' . $region_cls->getTable() . ' AS reg1
                                WHERE reg1.region_id = pro.state
                                ) AS state_name,

                                (SELECT reg2.code
                                FROM ' . $region_cls->getTable() . ' AS reg2
                                WHERE reg2.region_id = pro.state
                                ) AS state_code,

                                (SELECT reg3.name
                                FROM ' . $region_cls->getTable() . ' AS reg3
                                WHERE reg3.region_id = pro.country
                                ) AS country_name,

                                (SELECT reg4.code
                                FROM ' . $region_cls->getTable() . ' AS reg4
                                WHERE reg4.region_id = pro.country
                                ) AS country_code,

                                (SELECT pro_opt1.value
                                FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt1
                                WHERE pro_opt1.property_entity_option_id = pro.bathroom
                                ) AS bathroom_value,

                                (SELECT pro_opt2.value
                                FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt2
                                WHERE pro_opt2.property_entity_option_id = pro.bedroom
                                ) AS bedroom_value,

                                (SELECT pro_opt3.value
                                FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt3
                                WHERE pro_opt3.property_entity_option_id = pro.car_port
                                ) AS carport_value,

                                (SELECT pro_opt6.code
                                FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt6
                                WHERE pro_opt6.property_entity_option_id = pro.auction_sale
                                ) AS auction_sale_code,

                                (SELECT pro_opt6.title
                                FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt6
                                WHERE pro_opt6.property_entity_option_id = pro.auction_sale
                                ) AS auction_sale_title,

                                (SELECT pro_opt8.value
                                FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt8
                                WHERE pro_opt8.property_entity_option_id = pro.car_space
                                ) AS carspace_value


                        FROM ' . $property_cls->getTable() . ' AS pro
                        WHERE ' . $wh_str;
        $row = $property_cls->getRow($sql, true);
        $review = array();
        if (is_array($row) and count($row) > 0) {
            $review['info'] = $row;
            if ($row['auction_sale_code'] != 'private_sale') {
                $dt = new DateTime($row['end_time']);
                if (PE_isTheBlock($property_id, 'agent')) {
                    $review['info']['title'] = strtoupper($row['auction_sale_title']) . ' ';
                } else {
                    $review['info']['title'] = 'AUCTION ';
                }
                if (!(PE_isTheBlock($property_id) || (PE_isTheBlock($property_id, 'agent')))) {
                    $review['info']['title'] .= $dt->format($config_cls->getKey('general_date_format'));
                } else {
                    $dt1 = new DateTime($row['start_time']);
                    $review['info']['title'] .= $dt1->format($config_cls->getKey('general_date_format'));
                }
            } else {
                $review['info']['title'] = 'PRIVATE SALE';
            }
            if ($review['info']['bedroom_value'] == null) {
                $review['info']['bedroom_value'] = 0;
            }
            if ($review['info']['bathroom_value'] == null) {
                $review['info']['bathroom_value'] = 0;
            }
            $review['info']['full_address'] = $row['address'] . ' ' . $row['suburb'] . ' ' . $row['postcode'] . ' ' . $row['state_name'] . ' ' . $row['country_name'];
            $review['info']['livability_rating_mark'] = showStar((float)$row['livability_rating_mark']);
            $review['info']['green_rating_mark'] = showStar((float)$row['green_rating_mark']);
            $review['info']['description'] = safecontent($row['description'], 100);
            $auction_sale_ar = PEO_getAuctionSale();
            $review['info']['price'] = $row['price_on_application'] == 1 ? 'Price On Application' : showPrice($row['price']);
            /* if($row['auction_sale'] == $auction_sale_ar['private_sale'])
                 {
                     if($row['price'] == 0 or $row['price'] == '')
                     {
                         $review['info']['price'] = showPrice($row['price_on_application']);
                     }
                 }*/
            $type = ($row['auction_sale_code'] == 'auction') ? 'auction' : 'sale';
            $review['info']['link'] = '?module=property&action=register&id=' . $row['property_id'];
            if ($row['property_step'] > 1 && $row['property_step'] < 8) {
                $review['info']['link'] .= '&step=' . $row['property_step'];
            }
            $photo_ar = PM_getPhoto($row['property_id'], true);
            $review['photo'] = $photo_ar['photo_thumb_default'];
            $review['info']['auction_sale_code'] = $row['auction_sale_code'];
        }
    }
    return $review;
}

function PE_getAddressProperty($property_id = 0)
{
    global $property_cls, $region_cls;
    $address = '';
    if ($property_id > 0) {
        $row = $property_cls->getRow('SELECT SQL_CALC_FOUND_ROWS
                            pro.property_id,
                            pro.address,
                            pro.suburb,
                            pro.postcode,
                            (SELECT reg1.code
                            FROM ' . $region_cls->getTable() . ' AS reg1
                            WHERE reg1.region_id = pro.state
                            ) AS state_code,

                            (SELECT reg2.code
                            FROM ' . $region_cls->getTable() . ' AS reg2
                            WHERE reg2.region_id = pro.state
                            ) AS state_code,

                            (SELECT reg3.name
                            FROM ' . $region_cls->getTable() . ' AS reg3
                            WHERE reg3.region_id = pro.country
                            ) AS country_name,

                            (SELECT reg4.code
                            FROM ' . $region_cls->getTable() . ' AS reg4
                            WHERE reg4.region_id = pro.country
                            ) AS country_code
                    FROM ' . $property_cls->getTable() . ' AS pro
                    WHERE pro.property_id = ' . $property_id . '
                    ', true);
        if (count($row) > 0 and is_array($row)) {
            $address = $row['address'] . ' ' . $row['suburb'] . ' ' . $row['postcode'] . ' ' . $row['state_code'] . ' ' . $row['country_name'];
        }
    }
    return $address;
}

/**
 * @ function : PE_PayStatus2str
 * @ argument : pay_status
 * @ output : string
 **/
function PE_PayStatus2str($pay_status)
{
    $ar = array();
    if ($pay_status == Property::PAY_UNKNOWN) {
        $ar['text'] = 'unknown';
    }
    if ($pay_status == Property::PAY_PENDING) {
        $ar['text'] = 'pending';
    }
    if ($pay_status == Property::PAY_COMPLETE) {
        $ar['text'] = 'complete';
    }
    return $ar['text'];
}

/**
 * @ function : PE_requirePayment
 * @ argument : property_id
 * @ output : bool
 **/
function PE_requirePayment($property_id = 0)
{
}

/**
 * @ function : PE_getMoneyPayment
 * @ argument : property_id
 * @ output : number
 **/
function PE_getMoneyPayment($property_id = 0)
{
    global $property_cls, $package_cls;
    $row = $property_cls->getRow('SELECT  	pro.focus,
		                                        pro.auction_sale,
												pro.set_jump,
												pro.jump_status,
												pro.focus_status,
												pro.jump_flag,
												pro.focus_flag,
												pro.auction_sale,
												pro.package_id,
												pro.pay_status
									  FROM ' . $property_cls->getTable() . ' AS pro
									  WHERE pro.property_id = ' . $property_id, true);
    $price = 0;
    $auction_sale_ar = PEO_getAuctionSale();
    if (is_array($row) && count($row) > 0) {
        $ar = array();
        if (($row['jump_flag'] == 1 and $row['jump_status'] == 0)) {
            $ar[] = 'home';
        }
        if (($row['focus_flag'] == 1) and $row['focus_status'] == 0) {
            $ar[] = 'focus';
        }
        if (PE_PayStatus2str($row['pay_status']) == 'complete') {
            $price = PABasic_getPrice($ar);
        } else {
            $price = PA_getPrice($row['package_id']) + PABasic_getPrice($ar);
        }
    }
    return $price;
}

if (!isset($property_document_cls) || !($property_document_cls instanceof Property_document)) {
    $property_document_cls = new Property_document();
}
/**
 * @ function : DOC_getList
 * @ argument :
 * @ output
 **/
function DOC_getList()
{
    global $document_cls;
    $output = array();
    $rows = $document_cls->getRows('active = 1 ORDER BY `order` ASC');
    if (is_array($rows) && count($rows) > 0) {
        foreach ($rows as $row) {
            $output[$row['document_id']] = $row['title'];
        }
    }
    return $output;
}

/**
 * @ function : PD_getDocs
 * @ argument : property_id
 * @ output : array|null
 **/
function PD_getDocs($property_id = 0)
{
    global $property_document_cls, $document_cls, $package_cls, $property_cls;
    $row = PA_getPackageOfID($property_id);
    if (is_array($row) and count($row) > 0) {
        $wh_str = '';
        if ($row['document_ids'] != '') {
            if ($row['document_ids'] != 'all') {
                $wh_str = ' AND pro_doc.document_id IN (' . $row['document_ids'] . ')';
            }
            $rows = $property_document_cls->getRows('SELECT pro_doc.property_document_id,
                                                            pro_doc.property_id,
                                                            pro_doc.document_id,
                                                            doc.title,
                                                            pro_doc.file_name,
                                                            pro_doc.link_name
                                                      FROM ' . $document_cls->getTable() . ' AS doc,' . $property_document_cls->getTable() . ' AS pro_doc
                                                      WHERE doc.document_id = pro_doc.document_id
                                                            AND pro_doc.active = 1
                                                            AND pro_doc.property_id = ' . $property_id . $wh_str
                , true);
            if (is_array($rows) && count($rows) > 0) {
                foreach ($rows as $key => $row) {
                    $rows[$key]['title'] = str_replace('Upload', 'Download', $row['title']);
                }
                return $rows;
            }
        }
    }
    return null;
}

if (!isset($property_entity_option_cls) || !($property_entity_option_cls instanceof Property_entity_option)) {
    $property_entity_option_cls = new Property_entity_option();
}
/**
 * @ function : PEO_getKind
 * @ argument :
 * @ output :
 **/
function PEO_getKind($default = array())
{
    $rs = array();
    if (count($default) > 0) {
        $rs = $default;
    }
    if (isset($_SESSION['agent']['type']) && $_SESSION['agent']['type'] == 'agent') {
        $rs = $rs + array(1 => 'Commercial', 2 => 'Residential',);
    } else {
        $rs = $rs + array(2 => 'Residential', 1 => 'Commercial');
    }
    return $rs;
}

function PEO_getKindName($kind = 0)
{
    if ($kind == 0) {
        return "Any";
    } elseif ($kind == 1) {
        return "Commercial";
    } elseif ($kind == 2) {
        return 'Residential';
    }
    return "";
}

function PEO_getKindId($default = array('any' => 0))
{
    $rs = array();
    if (count($default) > 0) {
        $rs = $default;
    }
    $rs = $rs + array('commercial' => 1, 'residential' => 2);
    return $rs;
}

/**
 * @ function : PEO_getParking
 * @ argument :
 * @ output :
 **/
function PEO_getParking($default = array())
{
    $rs = array();
    if (count($default) > 0) {
        $rs = $default;
    }
    $rs = $rs + array(0 => 'No', 1 => 'Yes');
    return $rs;
}

/**
 * @ function : PEO_getOptions
 * @ argument : code, default
 * @ output : array
 **/
function PEO_getOptions($code = '', $default = array(), $isAgent = null)
{
    global $property_entity_option_cls;
    $options = array();
    if (count($default) > 0) {
        $options = $default;
    } else {
        //$options = array(0=>'Select...');
    }
    // GET CACHE
    $file_name = ROOTPATH . '/modules/cache/' . $code . '-new.php';
    //$file_name = null;
    if (file_exists($file_name)) {
        /*$options2 = Cache_get($file_name);
			if (!isset($options2[0])) {
				return $options+$options2;
			}
			return $options2;*/
    }
    $rows = $property_entity_option_cls->getChildsByParentCode($code);
    $cache_options = array();
    if ($property_entity_option_cls->hasError()) {
        $message = $property_entity_option_cls->getError();
    } else if (is_array($rows) and count($rows) > 0) {
        //full auction_sale
        /*if ($code == 'auction_sale' && strlen($isAgent) <= 0) {
                $options[Property::OPTION_AUCTION_LIVE] = 'Auction Live';
                $cache_options[Property::OPTION_AUCTION_LIVE] = 'Auction Live';
            }*/
        foreach ($rows as $row) {
            if ($code == 'auction_sale' && false) {
                if (strlen($isAgent) > 0) {
                    if ($isAgent) {
                        if (in_array($row['for_agent'], array(Property::AUCTION_CODE_AGENT, Property::AUCTION_CODE_ALL))) {
                            $options[$row['property_entity_option_id']] = $row['title'];
                            $cache_options[$row['property_entity_option_id']] = $row['title'];
                        }
                    } elseif (!$isAgent) {
                        if (in_array($row['for_agent'], array(Property::AUCTION_CODE_ALL, Property::AUCTION_CODE_NOT_AGENT))) {
                            $row['title'] = $row['code'] == 'auction' ? 'Auction Live' : $row['title'];
                            $options[$row['property_entity_option_id']] = $row['title'];
                            $cache_options[$row['property_entity_option_id']] = $row['title'];
                        }
                    }
                } else {
                    //full auction_sale
                    if ($row['code'] == 'auction') {
                        $options[Property::OPTION_AUCTION_LIVE] = 'Auction Live';
                        $cache_options[Property::OPTION_AUCTION_LIVE] = 'Auction Live';
                    }
                    $options[$row['property_entity_option_id']] = $row['title'];
                    $cache_options[$row['property_entity_option_id']] = $row['title'];
                }
            } else {
                $options[$row['property_entity_option_id']] = $row['title'];
                $cache_options[$row['property_entity_option_id']] = $row['title'];
            }
        }
    }
    // SET CACHE
    Cache_set($file_name, $cache_options);
    return $options;
}

/**
 * @ function : PEO_getAuctionSale
 * @ argument : void
 * @ output : array
 * ---------
 * ['auction'] => 9, ['private_sale'] => 10
 **/
function PEO_getAuctionSale($denny_sale = false)
{
    global $property_entity_option_cls;
    if (!isset($property_entity_option_cls) || !($property_entity_option_cls instanceof Property_entity_option)) {
        $property_entity_option_cls = new Property_entity_option();
    }
    //GET CACHE
    $file_name = ROOTPATH . '/modules/cache/auction_sale_ar.php';
    if (file_exists($file_name)) {
        //return Cache_get($file_name);
    }
    $auction_sale_ar = array();
    $rows = $property_entity_option_cls->getRows("parent_id = (SELECT property_entity_option_id
																	FROM " . $property_entity_option_cls->getTable() . " AS pro_ent_opt2
																	WHERE pro_ent_opt2.code = 'auction_sale')");
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            $auction_sale_ar[$row['code']] = $row['property_entity_option_id'];
            if ($row['active'] == 0) {
                $auction_sale_ar[$row['code']] = 0;
            }
        }
    }
    if ($denny_sale) {
        $auction_sale_ar['private_sale'] = 0;
    }
    // SET CACHE
    Cache_set($file_name, $auction_sale_ar);
    return $auction_sale_ar;
}

function PE_getAuctionSaleProperty($property_id)
{
    global $property_entity_option_cls, $property_cls;
    $row = $property_entity_option_cls->getRow("SELECT pro_opt4.code AS auction_sale_code
													  FROM " . $property_entity_option_cls->getTable() . " AS pro_opt4
													  LEFT JOIN " . $property_cls->getTable() . " AS pro ON pro_opt4.property_entity_option_id = pro.auction_sale
													  WHERE pro.property_id = " . $property_id, true);
    if (is_array($row) and count($row) > 0) {
        return $row['auction_sale_code'];
    }
}

//END
if (!isset($property_media_cls) || !($property_media_cls instanceof Property_media_cls)) {
    $property_media_cls = new Property_media();
}
function PM_getThumbFacebook($file_name)
{
    $thumb_ar = getThumbFromOriginal($file_name);
    if ($file_name == 'modules/property/templates/images/auction-img.jpg') {//photo default
        $link_image = 'modules/property/templates/images/auction-img.jpg';
    } else {
        if (file_exists(ROOTPATH . '/' . trim($file_name, '/')) && !file_exists(ROOTPATH . '/' . trim($thumb_ar['path']) . '/thumbs/50/' . trim($thumb_ar['file_name']))) {
            createFolder($thumb_ar['path'] . '/thumbs/50/', 1);
            createThumbs($thumb_ar['file_name'], $thumb_ar['path'], $thumb_ar['path'] . '/thumbs/50', 90, 46);
            $arr = explode('/', $thumb_ar['file_thumb_path']);
            $link_image = substr($thumb_ar['file_thumb_path'], 0, strlen($thumb_ar['file_thumb_apth']) - strlen($arr[count($arr) - 1])) . '50/' . $thumb_ar['file_name'];
        }
    }
    return $link_image;
}

/**
 * @ function : PM_getPhoto
 * @ argument : property_id, create_thumb, width, height
 * @ output : array
 **/
function PM_getPhoto($property_id, $create_thumb = true, $width = 300, $height = 182, $hasDefault = true)
{
    global $property_media_cls, $media_cls, $ftp_cls;
    $output = array('photo' => array(),
        'photo_default' => '',
        'photo_thumb' => array(),
        'photo_thumb_default' => '');
    $rows = $property_media_cls->getRows('SELECT med.media_id,
													  med.file_name,
													  med.type,
													  pro_med.default
											   FROM ' . $property_media_cls->getTable() . ' AS pro_med
											   LEFT JOIN ' . $media_cls->getTable() . ' AS med ON pro_med.media_id = med.media_id
											   WHERE med.type = \'photo\' AND pro_med.property_id = ' . $property_id, true);
    if ($property_media_cls->hasError()) {
    } else if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $_row) {
            $_row['photo_file'] = str_replace('/thumbs', '', $_row['file_name']);
            $output['photo'][] = $_row;
            if ($_row['default'] == 1) {
                $output['photo_default'] = $_row['file_name'];
            }
            if ($create_thumb) {
                $thumb_ar = getThumbFromOriginal($_row['file_name']);
                if (!file_exists(ROOTPATH . '/' . trim($thumb_ar['file_thumb_path'], '/'))) {
                    createFolder($thumb_ar['path'] . '/thumbs', 1);
                    createThumbs($thumb_ar['file_name'], $thumb_ar['path'], $thumb_ar['path'] . '/thumbs', $width, $height);
                }
                $__row = $_row;
                $__row['file_name'] = $thumb_ar['file_thumb_path'];
                $output['photo_thumb'][] = $__row;
                if ($_row['default'] == 1) {
                    $output['photo_thumb_default'] = $thumb_ar['file_thumb_path'];
                }
            }
        }
    } else {
        if ($hasDefault) {
            $output['photo_thumb'][] = array('file_name' => 'modules/property/templates/images/search-img.jpg');
            $output['photo'][] = array('photo_file' => 'modules/property/templates/images/auction-img.jpg');
        }
    }
    /*--------------------------*/
    if (is_array($output['photo']) && count($output['photo']) > 0 && strlen($output['photo_default']) == 0) {
        $output['photo_default'] = @$output['photo'][0]['file_name'];
        if ($create_thumb) {
            $thumb_ar = getThumbFromOriginal($output['photo_default']);
            $output['photo_thumb_default'] = $thumb_ar['file_thumb_path'];
        }
    }
    if ($hasDefault && !is_file(ROOTPATH . '/' . @$output['photo_default']) || (is_file(ROOTPATH . '/' . @$output['photo_default']) && !file_exists(ROOTPATH . '/' . @$output['photo_default']))) {
        $output['photo_default'] = $output['photo_thumb_default'] = 'modules/property/templates/images/search-img.jpg';
        $action = getParam('action', '');
        $action_ar = explode('-', $action);
        if ($action_ar[0] == 'view') {
            if ($action_ar[2] == 'list') {
                $output['photo_default'] = $output['photo_thumb_default'] = 'modules/property/templates/images/search-img.jpg';
            } elseif ($action_ar[2] == 'detail') {
                $output['photo_default'] = $output['photo_thumb_default'] = 'modules/property/templates/images/auction-img.jpg';
            } else {
                $output['photo_default'] = $output['photo_thumb_default'] = 'modules/property/templates/images/search-img.jpg';
            }
        }
        if ($action_ar[0] == 'search') {
            $output['photo_default'] = $output['photo_thumb_default'] = 'modules/property/templates/images/search-img.jpg';
        }
        if (in_array($action_ar[0], array("home_auction", "home_forthcoming", "home_sale"))) {
            $output['photo_default'] = $output['photo_thumb_default'] = 'modules/property/templates/images/search-img.jpg';
        }
    }
    return $output;
}

/**
 * @ function : PM_getVideo
 * @ argument : property_id
 * @ output : array
 **/
function PM_getVideo($property_id)
{
    global $property_media_cls, $media_cls;
    $output = array('video' => array(),
        'video_default' => '');
    $rows = $property_media_cls->getRows('SELECT med.media_id,
													  med.file_name,
													  med.type,
													  pro_med.default
											   FROM ' . $property_media_cls->getTable() . ' AS pro_med
											   LEFT JOIN ' . $media_cls->getTable() . ' AS med ON pro_med.media_id = med.media_id
											   WHERE med.type = \'video\' AND pro_med.property_id = ' . $property_id, true);
    if ($property_media_cls->hasError()) {
    } else if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $_row) {
            $output['video'][] = $_row;
            if ($_row['default'] == 1) {
                $output['video_default'] = $_row['file_name'];
            }
        }
    }
    if (is_array($output['video']) && count($output['video']) > 0 && strlen($output['video_default']) == 0) {
        $output['video_default'] = @$output['video'][0]['file_name'];
    }
    return $output;
}

/**
 * @ function : PM_getYT
 * @ argument : property_id
 * @ output : array
 **/
function PM_getYT($property_id)
{
    global $property_media_cls, $media_cls;
    $output = array('video' => array(),
        'video_default' => '');
    $rows = $property_media_cls->getRows('SELECT med.media_id,
													  med.file_name,
													  med.type,
													  pro_med.default
											   FROM ' . $property_media_cls->getTable() . ' AS pro_med
											   LEFT JOIN ' . $media_cls->getTable() . ' AS med ON pro_med.media_id = med.media_id
											   WHERE med.type = \'video-youtube\' AND pro_med.property_id = ' . $property_id, true);
    if ($property_media_cls->hasError()) {
    } else if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $_row) {
            $output['video'][] = $_row;
        }
    }
    return $output;
}

/**
 * @ function : PM_getMedia
 * @ argument : property_id
 * @ output : array
 **/
function PM_getMedia($property_id = 0)
{
    global $property_media_cls, $media_cls;
    $output = array('photo' => array(),
        'photo_default' => '',
        'video' => array(),
        'video_default' => '');
    $rows = $property_media_cls->getRows('SELECT med.media_id,
													  med.file_name,
													  med.type,
													  pro_med.default
											   FROM ' . $property_media_cls->getTable() . ' AS pro_med
											   LEFT JOIN ' . $media_cls->getTable() . ' AS med ON pro_med.media_id = med.media_id
											   WHERE pro_med.property_id = ' . $property_id, true);
    if ($property_media_cls->hasError()) {
    } else if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $_row) {
            if (!file_exists(ROOTPATH . '/' . $_row['file_name'])) {
                continue;
            }
            if ($_row['type'] == 'photo') {
                $output['photo'][] = $_row;
                if ($_row['default'] == 1) {
                    $output['photo_default'] = $_row['file_name'];
                }
            } elseif ($_row['type'] == 'video') {
                $output['video'][] = $_row;
                if ($_row['default'] == 1) {
                    $output['video_default'] = $_row['file_name'];
                }
            }
        }
    }
    if (is_array($output['photo']) && count($output['photo']) > 0 && strlen($output['photo_default']) == 0) {
        $output['photo_default'] = @$output['photo'][0]['file_name'];
    }/* else if (strlen($output['photo_default']) == 0 && count($output['photo']) == 0) {
			$output['photo_default'] = 'modules/property/templates/images/auction-img.jpg';
            $output['photo_default_detail'] = 'modules/property/templates/images/auction-img.jpg';
            $output['photo_default_thumb'] = ' modules/property/templates/images/search-img.jpg';
		}
		*/
    if (!is_file(ROOTPATH . '/' . @$output['photo_default']) || (is_file(ROOTPATH . '/' . @$output['photo_default']) && !file_exists(ROOTPATH . '/' . @$output['photo_default']))) {
        $output['photo_default'] = 'modules/property/templates/images/auction-img.jpg';
        $output['photo_default_detail'] = 'modules/property/templates/images/auction-img.jpg';
        $output['photo_default_thumb'] = ' modules/property/templates/images/search-img.jpg';
    }
    if (is_array($output['video']) && count($output['video']) > 0 && strlen($output['video_default']) == 0) {
        $output['video_default'] = @$output['video'][0]['file_name'];
    }
    return $output;
}

if (!isset($property_option_cls) || !($property_option_cls instanceof Property_option)) {
    $property_option_cls = new Property_option();
}
/**
 * @ function : PO_getOptions
 * @ argument : void
 * @ output : array
 */
function PO_getOptions()
{
    $options = array(0 => 'No', 1 => 'Yes');
    return $options;
}

/**
 * @ function : PO_hasOptions
 * @ argument : property_id
 * @ output : bool
 **/
function PO_hasOptions($property_id = 0)
{
    global $property_option_cls;
    $rows = $property_option_cls->getRows('property_id = ' . $property_id);
    if (is_array($rows) && count($rows) > 0) {
        return true;
    }
    return false;
}

if (!isset($rating_cls) || !($rating_cls instanceof Ratings)) {
    $rating_cls = new Ratings();
}
if (!isset($property_rating_cls) || !($property_rating_cls instanceof Property_rating)) {
    $property_rating_cls = new Property_rating();
}
if (!isset($property_rating_mark_cls) or !($property_rating_mark_cls instanceof Property_rating_mark)) {
    $property_rating_mark_cls = new Property_rating_mark();
}
/**
 * @ function : PRM_getRatingMark
 * @ argument : code, property_id
 * @ output : mix
 **/
function PRM_getRatingMark($code = '', $property_id = 0)
{
    global $rating_cls, $property_rating_cls;
    $mark = 0;
    $num = 1;
    $id_ar = array();
    $rows = $rating_cls->getChildByParentCode($code);
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            array_push($id_ar, $row['rating_id']);
        }
        $num = count($rows);
    }
    if (is_array($id_ar) and count($id_ar) > 0) {
        $rows = $property_rating_cls->getRow("SELECT SUM(ra.value)as mark
                            FROM " . $property_rating_cls->getTable() . " AS pro_ra
                            LEFT JOIN " . $rating_cls->getTable() . " AS ra ON pro_ra.rating_id = ra.rating_id
                            WHERE pro_ra.property_id = " . $property_id
            . " AND ra.parent_id IN ( " . implode(',', $id_ar) . " )", true);
        $mark = $rows['mark'];
    }
    //$mark = round(($mark * 5) / 24,1);
    return $mark;
}

if (!isset($property_term_cls) || !($property_term_cls instanceof Property_term)) {
    $property_term_cls = new Property_term();
}
/**
 * @ function : PT_getTerms
 * @ argument : property_id
 * @ output : array
 **/
function PT_getTerms($property_id = 0)
{
    global $property_term_cls;
    $terms = array();
    $rows = $property_term_cls->getRows('property_id = ' . $property_id);
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            $terms[$row['auction_term_id']] = $row['value'];
        }
    }
    return $terms;
}

/**
 * @ function : PT_getTermsKeyParentId
 * @ argument : property_id
 * @ output : array
 **/
function PT_getTermsKeyParentId($property_id = 0)
{
    global $property_term_cls;
    $rs = array();
    $rows = $property_term_cls->getRows('property_id = ' . $property_id);
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            $_code = AT_getCodeById((int)$row['auction_term_parent_id']);
            if ($_code == 'auction_date') {
                $row['value'] = AT_db2date($row['value']);
            }
            $rs[$row['auction_term_parent_id']] = $row['value'];
        }
    }
    return $rs;
}

/**
 * @ function : PT_hasProperty
 * @ argument : property_id
 * @ output : bool
 **/
function PT_hasProperty($property_id = 0)
{
    global $property_term_cls;
    $rows = $property_term_cls->getRows('property_id = ' . $property_id);
    if (is_array($rows) and count($rows) > 0) {
        return true;
    }
    return false;
}

/**
 * @ function : PT_getKeyValue
 * @ argument : property_id
 * @ output : array
 * ----
 * [auction_date] => 1
 * [auction_start_price] => 1222
 * ....
 * [initial_auction_increments] => 5000
 */
function PT_getKeyValue($property_id = 0)
{
    global $property_term_cls, $auction_term_cls;
    $property_id = (int)$property_id;
    $rows = $property_term_cls->getRows('SELECT pt.property_term_id, pt.value, at.auction_term_id, at.code
					FROM ' . $property_term_cls->getTable() . ' AS pt,' . $auction_term_cls->getTable() . ' AS at
					WHERE pt.property_id = ' . $property_id . ' AND pt.auction_term_parent_id = at.auction_term_id', true);
    $rs = array();
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $key => $row) {
            $rs[$row['code']] = $row['value'];
        }
    }
    return $rs;
}

/**
 * @ function : PT_getValueByCode
 * @ argument : property_id, code
 * @ output : mix
 **/
function PT_getValueByCode($property_id = 0, $code = '')
{
    global $property_term_cls, $auction_term_cls;
    $row = $property_term_cls->getRow('SELECT pt.value
										   FROM ' . $property_term_cls->getTable() . ' AS pt,' . $auction_term_cls->getTable() . ' AS at
										   WHERE pt.auction_term_parent_id = at.auction_term_id AND at.code = \'' . $code . '\' AND pt.property_id = ' . $property_id, true);
    if (is_array($row) && count($row) > 0) {
        return $row['value'];
    }
    return null;
}

if (!isset($watchlist_cls) || !($watchlist_cls instanceof Watchlists)) {
    $watchlist_cls = new Watchlists();
}
/**
 * @ function : WL_add
 * @ argument : agent_id, property_id
 * @ output : void
 */
function WL_add($agent_id = 0, $property_id = 0)
{
    global $watchlist_cls;
    if ($agent_id > 0 and $property_id > 0) {
        //CHECK IS EXISTED OR NOT
        $row = $watchlist_cls->getRow('agent_id = ' . $agent_id . ' AND property_id = ' . $property_id);
        //WILL BE ADD IF NOT
        if (count($row) == 0) {
            $watchlist_cls->insert(array('agent_id' => $agent_id, 'property_id' => $property_id, 'viewed_time' => date('Y-m-d H:i:s')));
        }
    }
}

if (!isset($media_cls) or !($media_cls instanceof Medias)) {
    $media_cls = new Medias();
}
if (!isset($auction_term_cls) or !($auction_term_cls instanceof Auction_terms)) {
    $auction_term_cls = new Auction_terms();
}
/**
 * @ function : AT_getTerms
 * @ argument : parent_id
 * @ output : array
 **/
function AT_getTerms($parent_id = 0)
{
    global $auction_term_cls;
    $term_ar = array();
    $rows = $auction_term_cls->getRows('auction_term_parent_id = ' . $parent_id . ' AND active = 1 ORDER BY `order` ASC');
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            $term_ar[$row['auction_term_id']] = $row;
        }
    }
    return $term_ar;
}

/**
 * @ function : AT_getIdByCode
 * @ argument : code
 * @ output : int
 **/
function AT_getIdByCode($code = '')
{
    global $auction_term_cls;
    $row = $auction_term_cls->getRow("code = '" . $code . "'");
    if (is_array($row) && count($row) > 0) {
        return $row['auction_term_id'];
    }
    return 0;
}

/**
 * @ function : AT_getOptions
 * @ argument : parent_id
 * @ output : array
 */
function AT_getOptions($parent_id = 0, $active = 1, $order = 'ASC', $condition = '')
{
    global $auction_term_cls;
    $options = array();
    $query = $condition != '' ? " AND (FIND_IN_SET('{$condition}', `condition`) OR ISNULL(`condition`) OR `condition` = '')" : '';
    $rows = $auction_term_cls->getRows('auction_term_parent_id = ' . $parent_id . ' AND active = ' . $active . $query . ' ORDER BY `order` ' . $order);
    if (is_array($rows) and count($rows) > 0) {
        $null_options = $cond_options = array();
        foreach ($rows as $row) {
            if ($condition != '') {
                if ($row['condition'] == '') {
                    $null_options[$row['value']] = $row['title'];
                } else {
                    $cond_options[$row['value']] = $row['title'];
                }
            } else {
                $options[$row['value']] = $row['title'];
            }
        }
    }
    if (is_array($null_options) and is_array($cond_options) and $condition != '') {
        //print_r($cond_options);
        $options = count($null_options) > count($cond_options) && count($cond_options) == 0 ? $null_options : $cond_options;
    }
    return $options;
}

/**
 * @ function : AT_getOptionsByMinMax
 * @ argument : parent_id
 * @ output : array
 */
function AT_getOptionsByMinMax($parent_id = 0, $min = 0, $max = 0)
{
    global $auction_term_cls;
    $min = isset($min) ? (int)$min : 0;
    $max = isset($max) ? (int)$max : 0;
    $options = array();
    $rows = $auction_term_cls->getRows('auction_term_parent_id = ' . $parent_id . ' AND active = 1 ORDER BY `order` ASC');
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            if (($row['value'] >= $min and $max <= 0)
                or ($row['value'] <= $max and $min <= 0 and $max > 0)
                or ($row['value'] >= $min and $row['value'] <= $max and $min > 0 and $max > 0)
                or ($min <= 0 and $max <= 0)
            ) {
                $options[$row['value']] = $row['title'];
            }
        }
    }
    return $options;
}

function AT_getIncOptionsByMinMax($parent_id = 0, $min = 0, $max = 0)
{
    global $auction_term_cls;
    $parent_id = AT_getIdByCode('initial_auction_increments');
    $min = isset($min) ? (int)$min : 0;
    $max = isset($max) ? (int)$max : 0;
    $options = array();
    $rows = $auction_term_cls->getRows('auction_term_parent_id = ' . $parent_id . ' AND active = 1 ORDER BY `order` ASC');
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            if (($row['value'] >= $min and $max <= 0)
                or ($row['value'] <= $max and $min <= 0 and $max > 0)
                or ($row['value'] >= $min and $row['value'] <= $max and $min > 0 and $max > 0)
                or ($min <= 0 and $max <= 0)
            ) {
                //$options[]
                $options[$row['value']] = $row['title'];
            }
        }
    }
    if ($min != 0) {
        $options = array($min => showPrice($min)) + $options;
    }
    if ($max != 0) {
        $options = $options + array($max => showPrice($max));
    }
    ksort($options);
    return array_unique($options);
}

/**
 * @ function : AT_getChildIds
 * @ argument : parent_id
 * @ output : array
 * --------------
 * child_ids
 */
function AT_getChildIds($parent_id = 0)
{
    global $auction_term_cls;
    $childs = array();
    $rows = $auction_term_cls->getRows('auction_term_parent_id = ' . $parent_id . ' AND active = 1 ORDER BY `order` ASC');
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            array_push($childs, $row['auction_term_id']);
        }
    }
    return $childs;
}

/**
 * @ function : AT_getType
 * @ argument : auction_term_id
 * @ output : string
 * ---------------------
 * type of row owner $auction_term_id
 */
function AT_getType($auction_term_id = 0)
{
    global $auction_term_cls;
    $row = $auction_term_cls->getRow('auction_term_id = ' . (int)$auction_term_id);
    if ($auction_term_cls->hasError()) {
    } else if (is_array($row) and count($row) > 0) {
        return $row['type'];
    }
    return '';
}

/**
 * @ function : AT_getParentId
 * @ argument : auction_term_id
 * @ output : int (parent_id)
 */
function AT_getParentId($auction_term_id = 0)
{
    global $auction_term_cls;
    $parent_id = 0;
    $row = $auction_term_cls->getRow('auction_term_id = ' . (int)$auction_term_id);
    if ($auction_term_cls->hasError()) {
    } else if (is_array($row) and count($row) > 0) {
        $parent_id = $row['parent_id'];
    }
    return $parent_id = 0;
}

/**
 * @ function : AT_getCodeById
 * @ argument : auction_term_id
 * @ output : string, code;
 */
function AT_getCodeById($auction_term_id = 0)
{
    global $auction_term_cls;
    $code = '';
    if ($auction_term_id <= 0) return $code;
    $row = $auction_term_cls->getRow('auction_term_id = ' . $auction_term_id);
    if ($auction_term_cls->hasError()) {
    } else if (is_array($row) and count($row) > 0) {
        $code = $row['code'];
    }
    return $code;
}

/**
 * @ function : AT_getChildId
 * @ argument : $value is mix, $auction_term_id
 * @ output : string,child_id of it
 */
function AT_getChildId($value, $parent_id = 0)
{
    global $auction_term_cls;
    //$rs = $auction_term_id;
    $rs = 0;
    $row = $auction_term_cls->getRow("auction_term_parent_id = " . (int)$parent_id . " AND value ='" . $auction_term_cls->escape($value) . "'");
    if ($auction_term_cls->hasError()) {
    } else if (is_array($row) and count($row) > 0) {
        $rs = $row['auction_term_id'];
    }
    return $rs;
}

/**
 * @ function : AT_date2db
 * @ argument : string
 * @ output : datetime format
 * ------------------------
 * 04/13/2011 => 2011-04-12 cur_hour:cur_minute:cur_second
 */
function AT_date2db($str = '')
{
    if (strlen($str) > 0) {
        $_ex = explode('/', $str);
        if (count($_ex) > 2) {
            return $_ex[2] . '-' . $_ex[0] . '-' . $_ex[1] . ' ' . date('H:i:s');
        }
    }
    return date('m-d-Y H:i:s');
}

/**
 * @ function : AT_db2date
 * @ argument : date
 * @ output : date format
 * ----------------------
 * 2011-04-14 11:11:11 or 2011-04-14
 * ==>04/14/2011
 */
function AT_db2date($date = '')
{
    if (strlen($date) == 19 and isValidDateTime($date)) {
        $dt = new DateTime($date);
        return $dt->format('m/d/Y');
    } else if (strlen($date) == 10 and isValidDate($date)) {
        $dt = new DateTime($date);
        return $dt->format('m/d/Y');
    } else {
        return date("m/d/Y", mktime(0, 0, 0, date('m'), date('d') + 14, date('Y')));
    }
}

/**
 * @ function : getOptionsPriceRange
 * @ argument : begin, end, step
 * @ output : array
 **/
function getOptionsPriceRange($begin = 0, $end = 10, $step = 100000)
{
    $options = array();
    for ($i = $begin; $i < $end; $i++) {
        //$options[$i*$step] = '$'.number_format($i*$step,',');
        $options[$i * $step] = '$' . number_format($i * $step, 0, '.', ',');
    }
    //$options['etc'] = 'etc';
    return $options;
}

/**
 * @ function : Property_deleteFull
 * @ argument : property_id, agent_id
 * @ output : void
 **/
function Property_deleteFull($property_id = 0, $agent_id = 0)
{
    global $property_cls, $property_term_cls, $property_rating_mark_cls, $property_rating_cls,
           $property_option_cls, $property_history_cls, $bid_transition_history_cls, $note_cls, $property_media_cls, $property_document_cls, $comment_cls, $media_cls, $bid_cls, $calendar_cls, $watchlist_cls;
    if ($property_id > 0) {
        $property_term_cls->delete('property_id = ' . $property_id);
        //$property_rating_mark_cls->delete('property_id = '.$property_id);
        $property_rating_cls->delete('property_id = ' . $property_id);
        $property_option_cls->delete('property_id = ' . $property_id);
        $note_cls->delete('entity_id_to = ' . $property_id . " AND (`type` = 'customer2property' OR `type` = 'admin2property')");
        $rows = $property_media_cls->getRows('SELECT pro_med.property_id,med.media_id, med.file_name
							FROM ' . $property_media_cls->getTable() . ' AS pro_med,' . $media_cls->getTable() . ' AS med
							WHERE pro_med.media_id = med.media_id AND pro_med.property_id = ' . $property_id, true);
        if (is_array($rows) and count($rows) > 0) {
            foreach ($rows as $row) {
                //DELETE
                @unlink(ROOTPATH . '/' . trim($row['file_name'], '/'));
                $media_cls->delete('media_id = ' . $row['media_id']);
            }
        }
        $property_media_cls->delete('property_id = ' . $property_id);
        $rows = $property_document_cls->getRows('property_id = ' . $property_id);
        if (is_array($rows) and count($rows) > 0) {
            foreach ($rows as $row) {
                @unlink(ROOTPATH . '/' . trim($row['file_name'], '/'));
                $property_document_cls->delete('property_id = ' . $property_id);
            }
        }
        $comment_cls->delete('property_id = ' . $property_id);
        $bid_cls->delete('property_id = ' . $property_id);
        $bid_transition_history_cls->delete('property_id = ' . $property_id);
        $calendar_cls->delete('property_id = ' . $property_id);
        $watchlist_cls->delete('property_id = ' . $property_id);
        if ($agent_id > 0) {
            deleteFolder(ROOTPATH . '/store/uploads/' . $agent_id . '/' . $property_id);
            rmdir(ROOTPATH . '/store/uploads/' . $agent_id . '/' . $property_id);
        }
        $property_cls->delete('property_id = ' . $property_id);
        $property_history_cls->delete('property_id = ' . $property_id);
    }
}

function Property_deleteFullAgent($agent_id = 0)
{
    global $property_cls;
    $rows = $property_cls->getRows('agent_id = ' . $agent_id);
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            Property_deleteFull($row['property_id'], $agent_id);
        }
    }
}

/**
 * @ function : Property_History
 * @ argument : property_id, agent_id
 * @ output : void
 **/
function Property_history($property_id = 0, $agent_id = 0, $switch_to, $data = array())
{
    global $property_cls, $property_history_cls, $bid_transition_history_cls, $property_term_cls, $property_rating_mark_cls, $property_rating_cls,
           $property_option_cls, $note_cls, $bid_transition_history_cls, $property_history_cls, $property_media_cls, $property_document_cls, $comment_cls, $media_cls, $bid_cls;
    $data_temp = array();
    //$row_temrs = $property_term_cls->getCRow(array('property_id'),'property_id='.$property_id);
    //$rows_bids = $bid_cls->getRow('SELECT agent_id,property_id,step,price,time FROM '.$bid_cls->getTable().' WHERE property_id='.$property_id,true);
    {
        $data_temp['start_price'] = PT_getValueByCode($property_id, 'auction_start_price');
        $data_temp['reserve_price'] = PT_getValueByCode($property_id, 'reserve');
        if ($switch_to == 'private_sale') {
            $data_temp['reserve_price'] = $data['price'];
        }
        $data_temp['last_bidder'] = Bid_getShortNameLastBidder($property_id);
        $data_temp['transition_time'] = date('Y-m-d H:i:s');
        $data_temp['property_id'] = (int)$property_id;
        $row = Bid_getLastBidByPropertyId($property_id);
        if (is_array($row) and count($row) > 0) {
            $data_temp['bid_price'] = $row['price'];
        } else {
            $data_temp['bid_price'] = PT_getValueByCode($property_id, 'auction_start_price');
        }
        $row = $property_cls->getCRow(array('end_time', 'start_time', 'auction_sale'), 'property_id=' . $property_id);
        if (is_array($row) && count($row) > 0) {
            $data_temp['end_time'] = $row['end_time'];
            $data_temp['start_time'] = $row['start_time'];
            $data_temp['auction_sale'] = $row['auction_sale'];
        }
        foreach ($data_temp as $k => $value) {
            $data_temp[$k] = addslashes($value);
        }
        $property_history_cls->insert($data_temp);
        $id = $property_history_cls->insertId();
        // Insert Bids_transition_history
        $rows = $bid_cls->getRows('SELECT agent_id,property_id,step,price,time FROM ' . $bid_cls->getTable() . ' WHERE property_id=' . $property_id, true);
        if (is_array($rows) && count($rows) > 0) {
            foreach ($rows as $row) {
                $row['property_transition_history_id'] = $id;
                $bid_transition_history_cls->insert($row);
            }
        }
    }
    //delete
    unset($rows);
    unset($data_temp);
    unset($property_history_cls);
    unset($bid_transition_history_cls);
}

function Property_reset($property_id = 0, $switch_to = 'auction')
{
    global $property_cls;
    if ($property_id > 0) {
        //Reset a property
        $data_temp = array();
        $data_temp['hide_for_live'] = 0; // reset =1 change
        $data_temp['last_bid_time '] = '0000-00-00 00:00:00';
        $data_temp['creation_date'] = date('Y-m-d H:i:s');
        $data_temp['last_update_time'] = date('Y-m-d H:i:s');
        $data_temp['creation_datetime'] = date('Y-m-d H:i:s');
        $data_temp['agent_active'] = 1;
        $data_temp['active'] = 0;
        $data_temp['step'] = 2;
        $data_temp['views'] = 0;
        $data_temp['focus'] = 0;
        $data_temp['set_jump'] = 0;
        $data_temp['focus_status'] = 0;
        $data_temp['package_id'] = 0;
        $data_temp['jump_status'] = 0;
        $data_temp['dateviews'] = '0000-00-00';
        $data_temp['stop_bid'] = 0;
        $data_temp['scan'] = 0;
        $data_temp['start_time'] = '0000-00-00 00:00:00';
        $data_temp['end_time'] = '0000-00-00 00:00:00';
        $data_temp['set_count'] = '';
        $data_temp['lock_bid'] = 0;
        $data_temp['pay_status'] = Property::PAY_UNKNOWN;
        /*NHUNG EDIT*/
        $auction_sale_arr = PEO_getAuctionSale();
        $data_temp['auction_sale'] = $auction_sale_arr[$switch_to];
        /*END*/
        /*if($switch_to == 'sale')
            {
                $data_temp['auction_sale'] = 10;
            }
            if($switch_to == 'auction')
            {
                $data_temp['auction_sale'] = 9;
            }*/
        $property_cls->update($data_temp, 'property_id = ' . $property_id);
    }
}

/**
 * @ function : Property_transition
 * @ argument : property_id, agent_id
 * @ output : void
 **/
function Property_transition($property_id = 0, $agent_id = 0, $type = '', $switch_to = 'auction', $data = array())
{
    global $property_cls, $property_term_cls, $property_rating_mark_cls, $property_rating_cls, $bid_room_cls, $autobid_cls,
           $property_option_cls, $note_cls, $property_media_cls, $property_document_cls, $comment_cls, $media_cls, $bid_cls, $calendar_cls, $watchlist_cls;
    $auction_sale_ar = PEO_getAuctionSale();
    if ($type == 'passed-in' or $type == 'admin') {
        // Save into History
        Property_history($property_id, $agent_id, $switch_to, $data);
        // Reset a property
        Property_reset($property_id, $switch_to);
        // Delete information Property
        if ($property_id > 0 && $agent_id > 0) {
            $property_term_cls->delete('property_id = ' . $property_id);
            $comment_cls->delete('property_id = ' . $property_id);
            $bid_cls->delete('property_id = ' . $property_id);
            $bid_room_cls->delete('property_id = ' . $property_id);
            $autobid_cls->delete('property_id = ' . $property_id);
        }
    }
    if ($type == 'register') {
        if ($data['pay_status'] == Property::PAY_COMPLETE) {
            if ($data['auction_sale'] != $auction_sale_ar['private_sale']) {
                // Save into History
                Property_history($property_id, $agent_id, $switch_to, $data);
                // Reset a property
                Property_reset($property_id, $switch_to);
                // Delete information Property
                if ($property_id > 0 && $agent_id > 0) {
                    $property_term_cls->delete('property_id = ' . $property_id);
                    $comment_cls->delete('property_id = ' . $property_id);
                    $bid_cls->delete('property_id = ' . $property_id);
                    $bid_room_cls->delete('property_id = ' . $property_id);
                    $autobid_cls->delete('property_id = ' . $property_id);
                }
            } else {
                Property_reset($property_id);
                Property_history($property_id, $agent_id);
            }
        } else {
        }
    }
}

/**
 * @ function : Property_makeAnOfferPopup
 * @ argument : property_id
 * @ output : string
 **/
function Property_makeAnOfferPopup($property_id = 0)
{
    global $smarty, $property_cls, $region_cls, $mobileFolder;
    $msg = '';
    //BEGIN SET PROPERTY'S INFO TO MSG
    $sql = 'SELECT  pro.address, pro.price, pro.suburb, pro.postcode,
					(SELECT reg1.code FROM ' . $region_cls->getTable() . ' AS reg1 WHERE reg1.region_id = pro.state) AS state_code,
					(SELECT reg2.name FROM ' . $region_cls->getTable() . ' AS reg2 WHERE reg2.region_id = pro.country) AS country_name

				FROM ' . $property_cls->getTable() . ' AS pro
				WHERE pro.property_id = ' . $property_id;
    $row = $property_cls->getRow($sql, true);
    if (is_array($row) && count($row) > 0) {
        $msg_ar = array();
        $msg_ar[] = 'ID {' . $property_id . '}';
        $msg_ar[] = "Property's Address :" . $row['address'] . ', ' . $row['suburb'] . ', ' . $row['state_code'] . ', ' . $row['postcode'] . ', ' . $row['country_name'];
        $msg = implode("\r\n", $msg_ar);
    }
    //END
    $smarty->assign('agent_id', @$_SESSION['agent']['id']);
    $smarty->assign('agent_email', @$_SESSION['agent']['email_address']);
    $smarty->assign('property_id', $property_id);
    $smarty->assign('msg', $msg);
    $str = $smarty->fetch(ROOTPATH . '/modules/property/templates' . $mobileFolder . 'property.make-an-offer.popup.tpl');
    return $str;
}

/**
 * @ function : Property_datediff
 * @ argument : startdate , enddate
 * @ Description :
 * @ output : Returns the number of date and time boundaries crossed between two specified dates
 **/
function Property_datediff($startdate, $enddate, $format = '%d %h %i %s')
{
    /*global $property_cls;
        $row = $property_cls->getRow('SELECT datediff(\''.$enddate.'\',\''.$startdate.'\') AS day FROM '.$property_cls->getTable(),true);
        if(is_array($row)&& count($row)){
            return (int)$row['day'];
        }
        return -1;*/
    $be_time = new DateTime($startdate);
    $en_time = new DateTime($enddate);
    $date = date_diff($be_time, $en_time)->format($format);
    //print_r($date);
    return $date;
}

function Property_getCondition()
{
    global $config_cls, $agent_cls, $bids_first_cls, $agent_payment_cls;
    //BEGIN FOR LOCK THE BLOCK PROPERTY: NHUNG
    $date_lock = (int)$config_cls->getKey('date_lock');
    $wh_arr = array();
    /*if (isset($_SESSION['agent']) and $_SESSION['agent']['id'] > 0) {
        $lock_str = " IF(
                                (SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at WHERE agt.type_id = at.agent_type_id) IN ('theblock'),

                                (SELECT p.pay_bid_first_status FROM " . $bids_first_cls->getTable() . " AS p
                                 WHERE p.property_id = pro.property_id AND p.agent_id = " . $_SESSION['agent']['id'] . ")> 0
                                 OR '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY),pro.date_to_reg_bid)
                                 OR (IF(ISNULL(pro.agent_manager)
                                        OR pro.agent_manager = 0
                                        ,pro.agent_id = {$_SESSION['agent']['id']}
                                        , pro.agent_manager = '{$_SESSION['agent']['id']}')
                                     || pro.agent_id IN (SELECT a.agent_id FROM agent AS a WHERE a.parent_id = {$_SESSION['agent']['id']})
                                     || (pro.agent_id = '{$_SESSION['agent']['id']}' AND agt.parent_id = 0))

                                ,1) = 1";
    } else {
        $lock_str = "
                               IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at
                                   WHERE agt.type_id = at.agent_type_id) IN ('theblock'),
                                  '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,
                                  DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY),pro.date_to_reg_bid),1) = 1
                               ";
    }
    //IBB-1224: unlock/lock the block properties after the auctions
    $lock_status = (int)$config_cls->getKey('theblock_status');
    if ($lock_status == 0) {//unlock
        $lock_type = $config_cls->getKey('theblock_show_type_properties');
        $lock_type_ar = explode(',', $lock_type);
        $unlock_str = 1;
        if (count($lock_type_ar) > 0) {
            foreach ($lock_type_ar as $type) {
                switch ($type) {
                    case 'sold':
                        $unlock_arr[] = "pro.confirm_sold = 1";
                        break;
                    case 'passed_in':
                        $unlock_arr[] = "(pro.confirm_sold = 0 AND pro.stop_bid = 1)";
                        break;
                    case 'live':
                        $unlock_arr[] = "(pro.end_time > '" . date('Y-m-d H:i:s') . "'
                                              AND pro.confirm_sold = 0
                                              AND pro.stop_bid = 0
                                              AND pro.end_time > pro.start_time
                                              AND pro.start_time <= '" . date('Y-m-d H:i:s') . "')";
                        break;
                    case 'forthcoming':
                        $unlock_arr[] = "(pro.start_time > '" . date('Y-m-d H:i:s') . "'
                                              AND pro.confirm_sold = 0
                                              AND pro.stop_bid = 0)";
                        break;
                }
            }
            $_unlock_str = ' OR ' . implode(' OR ', $unlock_arr);
            if (isset($_SESSION['agent']) and $_SESSION['agent']['id'] > 0) {
                $unlock_str = " IF(
                                        (SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at WHERE agt.type_id = at.agent_type_id) IN ('theblock'),

                                        (SELECT p.pay_bid_first_status FROM " . $bids_first_cls->getTable() . " AS p
                                         WHERE p.property_id = pro.property_id AND p.agent_id = " . $_SESSION['agent']['id'] . ")> 0
                                         OR '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY),pro.date_to_reg_bid)
                                         OR (IF(ISNULL(pro.agent_manager)
                                                OR pro.agent_manager = 0
                                                ,pro.agent_id = {$_SESSION['agent']['id']}
                                                , pro.agent_manager = '{$_SESSION['agent']['id']}')
                                             || pro.agent_id IN (SELECT a.agent_id FROM agent AS a WHERE a.parent_id = {$_SESSION['agent']['id']})
                                             || (pro.agent_id = '{$_SESSION['agent']['id']}' AND agt.parent_id = 0))
                                         {$_unlock_str}

                                        ,1)";
            } else {
                $unlock_str = "
                                       IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at
                                           WHERE agt.type_id = at.agent_type_id) IN ('theblock'),
                                          '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,
                                                                         DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY)
                                                                         ,pro.date_to_reg_bid)
                                          {$_unlock_str}
                                          ,1)
                                       ";
            }
        }
        $date_open_lock = $config_cls->getKey('theblock_date_lock');
        $wh_arr[] = " IF ('" . date('Y-m-d H:i:s') . "' < '" . $date_open_lock . "',{$lock_str},{$unlock_str})";
    } else {
        $wh_arr[] = $lock_str;
    }*/
    //HIDE AGENT's PROPERTIES DIDN'T PAYMENT
    /*$wh_arr[] = " IF((SELECT title FROM ".$agent_cls->getTable('agent_type')." AS at
                                   WHERE agt.type_id = at.agent_type_id) IN ('agent')
                                   ,(SELECT ap.payment_id FROM ".$agent_payment_cls->getTable()." AS ap
                                     WHERE ap.agent_id = IF(agt.parent_id = '',agt.agent_id,agt.parent_id)
                                           AND ap.date_from <= '".date('Y-m-d H:i:s')."' AND ap.date_to >= '".date('Y-m-d H:i:s')."'
                                     ) != ''
                                   ,1)";*/
    //DON'T ALLOW SHOW PROPERTIES OF INACTIVE AGENT
    $wh_arr[] = " IF(ISNULL(pro.agent_manager) || pro.agent_manager = '' || pro.agent_manager = 0
                        , agt.is_active = 1
                        ,(SELECT a.is_active FROM " . $agent_cls->getTable() . " AS a WHERE a.agent_id = pro.agent_manager) = 1)
                        ";
    return $wh_arr;
}

/**
 * @ function : Property_getList
 * @ argument :
 * @ output :
 **/
function Property_getList($wh_clause = '', $p = 1, $len = 1, $search_query = '', $pag_link = '')
{
    global $smarty
           , $property_cls
           , $region_cls
           , $property_entity_option_cls
           , $pag_cls
           , $config_cls
           , $agent_cls
           , $bids_first_cls
           , $total_found
           , $agent_payment_cls;
    if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
        $pag_cls = new Paginate();
    }
    $count = array();
    $count['once'] = $config_cls->getKey('count_going_once');
    $count['twice'] = $config_cls->getKey('count_going_twice');
    $count['third'] = $config_cls->getKey('count_going_third');
    $auction_sale_ar = PEO_getAuctionSale();
    $wh_price = '(SELECT CASE
            					WHEN pro.auction_sale != ' . $auction_sale_ar['private_sale'] . '
									 AND ( date(pro.start_time) > \'' . date('Y-m-d H:i:s') . '\' OR isnull(max(bid.price)) ) THEN
									(SELECT pro_term.value
									 FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
									 LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
									 	ON pro_term.auction_term_id = term.auction_term_id
									 WHERE term.code = \'auction_start_price\'
									 		AND pro.property_id = pro_term.property_id)
            					WHEN auction_sale = ' . $auction_sale_ar['private_sale'] . ' AND pro.price != 0 THEN pro.price
                                WHEN auction_sale = ' . $auction_sale_ar['private_sale'] . ' AND pro.price = 0 AND pro.price_on_application != 0 THEN pro.price_on_application
            				ELSE max(bid.price)
            				END
            		FROM bids AS bid WHERE bid.property_id = pro.property_id) + 0';
    if (getPost('order_by') != '' || (isset($_POST['search']) && isset($_POST['search']['order_by']) && $_POST['search']['order_by'] != '')) {
        $_SESSION['order_by'] = (getPost('order_by') != '') ? getPost('order_by') : $_POST['search']['order_by'];
    }
    $order_by = isset($_SESSION['order_by']) ? $_SESSION['order_by'] : '';
    switch ($order_by) {
        case 'highest':
            $order_ar = $wh_price . ' DESC';
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
        default:
            //$order_ar = ' pro.start_time DESC';
            $order_ar = in_array(getParam('action'), array('search', 'search-auction', 'search-sale')) ? 'pro.confirm_sold, pro.stop_bid, pro.end_time' : 'pro.property_id DESC';
            $_SESSION['order_by'] = '';
            break;
    }
    $order_ar = ($order_ar != '') ? ' ORDER BY ' . $order_ar : '';
    $smarty->assign('order_by', $order_by);
    $wh_arr = Property_getCondition();
    /*IBB-1022:Hide The Block properties from view in the Online Auctions section: NHUNG*/
    /*
        $wh_arr[] = '  (SELECT agtype.title
                       FROM '.$agent_cls->getTable('agent_type')." AS agtype
                       WHERE agtype.agent_type_id = agt.type_id) != 'theblock'";
		*/
    $wh_str = count($wh_arr) > 0 ? ' AND ' . implode(' AND ', $wh_arr) : '';
    $rows = $property_cls->getRows("SELECT SQL_CALC_FOUND_ROWS pro.property_id,
                                                    pro.type,
                                                    pro.agent_id,
													pro.address,
													pro.suburb,
													pro.state,
													pro.step,
													pro.postcode,
													pro.end_time,
													pro.start_time,
													pro.livability_rating_mark,
													pro.green_rating_mark,
										 			pro.last_bid_time,
										 			pro.last_update_time,
													pro.description,
													pro.open_for_inspection,
													pro.agent_active,
													pro.auction_sale,
													pro.confirm_sold,
													pro.sold_time,
													pro.stop_bid,
													agt.type_id,
													pro.set_count,
													pro.owner,
													pro.kind,
													pro.parking,
													pro.price_on_application,
													pro.buynow_price,
													pro.buynow_buyer_id,
													pro.buynow_status,
													pro.land_size,

                                                    pro.bond,
                                                    pro.ensuite,
                                                    pro.garages,
                                                    pro.headline,
                                                    pro.isHomeLandPackage,
                                                    pro.lotNumber,
                                                    pro.solarPanels,
                                                    pro.streetView,
                                                    pro.toilets,
                                                    pro.unitNumber,
                                                    pro.energyRating,
                                                    pro.price as list_price,

													(SELECT reg1.code
													FROM " . $region_cls->getTable() . " AS reg1
													WHERE reg1.region_id = pro.state
													) AS state_code,

													(SELECT reg2.name
													FROM " . $region_cls->getTable() . " AS reg2
													WHERE reg2.region_id = pro.country
													) AS country_name,

													(SELECT reg3.code
                                                    FROM " . $region_cls->getTable() . " AS reg3
                                                    WHERE reg3.region_id = pro.country
                                                    ) AS country_code,

													(SELECT pro_opt1.value
													FROM " . $property_entity_option_cls->getTable() . " AS pro_opt1
													WHERE pro_opt1.property_entity_option_id = pro.bathroom
													) AS bathroom_value,

													(SELECT pro_opt2.value
													FROM " . $property_entity_option_cls->getTable() . " AS pro_opt2
													WHERE pro_opt2.property_entity_option_id = pro.bedroom
													) AS bedroom_value,

													(SELECT pro_opt3.value
													FROM " . $property_entity_option_cls->getTable() . " AS pro_opt3
													WHERE pro_opt3.property_entity_option_id = pro.car_port
													) AS carport_value,

													(SELECT pro_opt33.value
													FROM " . $property_entity_option_cls->getTable() . " AS pro_opt33
													WHERE pro_opt33.property_entity_option_id = pro.car_space
													) AS carspace_value,

													(SELECT pro_opt4.code
													FROM " . $property_entity_option_cls->getTable() . " AS pro_opt4
													WHERE pro_opt4.property_entity_option_id = pro.auction_sale
													) AS auctionsale_code,

                                                    (SELECT pro_opt6.code
                                                    FROM " . $property_entity_option_cls->getTable() . " AS pro_opt6
                                                    WHERE pro_opt6.property_entity_option_id = pro.auction_sale
                                                    ) AS auction_sale_code,

													(SELECT pro_opt8.value
                                                    FROM " . $property_entity_option_cls->getTable() . " AS pro_opt8
                                                    WHERE pro_opt8.property_entity_option_id = pro.car_space
                                                    ) AS carspace_value,

                                                    (SELECT pro_opt6.code
                                                    FROM " . $property_entity_option_cls->getTable() . " AS pro_opt6
                                                    WHERE pro_opt6.property_entity_option_id = pro.period
                                                    ) AS period,

                                                    " . $wh_price . " AS price

												FROM " . $property_cls->getTable() . " AS pro

												INNER JOIN " . $property_cls->getTable('agent') . " AS agt
													ON pro.agent_id = agt.agent_id
												WHERE   pro.active = 1
														AND pro.agent_active = 1
														AND pro.pay_status = " . Property::CAN_SHOW
        . $wh_str
        . $wh_clause
        . $order_ar
        . ' LIMIT ' . ($p - 1) * $len . ',' . $len, true);
    //print_r($property_cls->sql);die();
    $mode = getParam('mode', 'list') == 'grid' ? getParam('mode', 'list') : 'list';
    $url_part = /*$mode == 'grid' ? '&mode=grid' : */
        '';
    $url_search = '';
    //$pag_link = '/?module=property&action='.getParam('action');
    if (preg_match('/.html/', @$_SERVER['REDIRECT_URL'])) {
        $pag_link = parseRedirectUrl(@$_SERVER['REDIRECT_URL']);
        if (preg_match('/rs=1/', @$_SERVER['REDIRECT_URL'])) {
            $pag_link .= '&rs=1';
        }
        $pag_link .= '&mode=' . $mode;
    }
    if ($pag_link == "") {
        $pag_link = $_SERVER['REQUEST_URI'];
    }
    if (in_array(getParam('action'), array('search', 'search-auction', 'search-sale'))) {
        $url_search = '&' . $search_query . '&order_by=' . $order_by;
        $url_search = str_replace('&&', '&', $url_search);
        //$pag_link = getParam('action').'-'.$mode.'.html';
    } else if (strlen($pag_link) == 0) {
        //$pag_link = str_replace('list', $mode, getParam('action')).'.html';
    }
    $total_found = $total_row = $property_cls->getFoundRows();
    $pag_cls->setTotal($total_row)
        ->setPerPage($len)
        ->setCurPage($p)
        ->setLenPage(10)
        ->setUrl($pag_link . $url_search . $url_part)
        ->setLayout('link_simple');
    $smarty->assign('mode', $mode);
    $smarty->assign('pag_str', $pag_cls->layout());
    $smarty->assign('review_pagging', (($p - 1) * $len) . ' - ' . (($p * $len) > $total_row ? $total_row : ($p * $len)) . ' (' . $total_row . ' items)');
    $data = array();
    $_SESSION['prev_next_ids_ar'] = array();
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $key => $row) {
            $data[$key] = $row;
            /*QUAN: PREV & NEXT*/
            $_SESSION['prev_next_ids_ar'][] = $row['property_id'];
            $type = PEO_getOptionById($row['auction_sale']);
            $data[$key]['pro_type_code'] = $type['code'];
            $data[$key]['pro_type'] = 'sale';
            $data[$key]['set_count'] = $row['set_count'];
            $link_ar = array('module' => 'property',
                'action' => '',
                'id' => $row['property_id']);
            $link_ar['action'] = 'view-sale-detail';
            $data[$key]['origin_price'] = $row['price'];
            $data[$key]['price'] = showPrice($row['price']);
            if ($row['auction_sale'] == $auction_sale_ar['private_sale']) {
                $data[$key]['price'] = $row['price_on_application'] == 1 ? 'Price On Application' : showPrice($row['price']);
            }

            if ($row['auction_sale'] != $auction_sale_ar['private_sale']) {
                $dt1 = new DateTime($row['start_time']);
                $dt = new DateTime($row['end_time']);
                if ($row['start_time'] == '5000-05-05 00:00:00' || $row['start_time'] == '0000-00-00 00:00:00') {
                    $data[$key]['start_time'] = 'For ' . (PE_isRentProperty($row['property_id']) ? 'Rent' : 'Sale') . ' - no auction scheduled';
                } else {
                    $data[$key]['start_time'] = $dt1->format($config_cls->getKey('general_date_format') . ', g:i a');
                }
                if ($row['end_time'] == '5000-06-06 00:00:00' || $row['end_time'] == '0000-00-00 00:00:00') {
                    $data[$key]['end_time'] = 'For ' . (PE_isRentProperty($row['property_id']) ? 'Rent' : 'Sale') . ' - no auction scheduled';
                } else {
                    $data[$key]['end_time'] = $dt->format($config_cls->getKey('general_date_format'));
                }
                $current = new DateTime(date('Y-m-d H:i:s'));
                if($row['start_time'] == '5000-05-05 00:00:00' && $row['end_time'] == '5000-06-06 00:00:00'){
                    $data[$key]['title'] =  'FOR ' . (PE_isRentProperty($row['property_id']) ? 'RENT' : 'SALE') . '';
                }elseif ($row['start_time'] > date('Y-m-d H:i:s')
                    OR ($row['confirm_sold'] == Property::SOLD_COMPLETE AND $row['sold_time'] < $row['start_time'])
                ) {//FORTHCOMING
                    $data[$key]['title'] = 'AUCTION STARTS : ' . $dt1->format('d-m-Y' . ' @ g:i');
                    $data[$key]['pro_type'] = 'forthcoming';
                    $link_ar['action'] = 'view-forthcoming-detail';
                    $reserve_price = PT_getValueByCode($row['property_id'], 'reserve');
                    global $mobileBrowser;
                    if ($mobileBrowser) {
                        $data[$key]['price'] = $row['price_on_application'] > 0 ? 'POA' : '' . showLowPrice($reserve_price) . ' - ' . showHighPrice($reserve_price) . '';
                    } else {
                        $data[$key]['price'] = $row['price_on_application'] > 0 ? 'Price On Application' : showLowPrice($reserve_price) . ' - ' . showHighPrice($reserve_price);
                    }
                    if ($row['confirm_sold'] == Property::SOLD_COMPLETE) {
                        $data[$key]['price'] = showPrice($row['price']);
                    }
                    if ($mode == 'grid') {
                        $data[$key]['price'] = $row['price_on_application'] > 0 ? 'Price On Application' : '' . showLowPrice($reserve_price) . ' - ' . showHighPrice($reserve_price) . '';
                    }
                    if (in_array($row['auction_sale'], array($auction_sale_ar['ebiddar'], $auction_sale_ar['bid2stay']))) {
                        $data[$key]['price'] = $row['price_on_application'] > 0 ? 'Price On Application' : 'Starting at ' . showPrice($row['price']);
                    }
                    $data[$key]['start_time'] = 'Auction starts ' . $data[$key]['start_time'];
                    //CALC REMAIN TIME
                    //$data[$key]['remain_time'] = remainTime($row['end_time']);
                } else {//AUCTION
                    if ($row['end_time'] < date('Y-m-d H:i:s')) { // END AUCTION
                        $data[$key]['title'] = Localizer::translate('AUCTION ENDED') . ': ' . $dt->format($config_cls->getKey('general_date_format'));
                    } else { //LIVE AUCTION
                        $data[$key]['title'] = Localizer::translate('AUCTION ENDS') . ': <span class="auc-time-'.$row['property_id'].'"></span>';
                        if($row['stop_bid'] == 1){
                            $data[$key]['title'] = Localizer::translate('AUCTION ENDED');
                        }
                    }
                    $data[$key]['pro_type'] = 'auction';
                    $link_ar['action'] = 'view-auction-detail';
                    //BEGIN BIDDER
                    $data[$key]['isLastBidVendor'] = Bid_isLastBidVendor($row['property_id']);
                    $data[$key]['bidder'] = Bid_getShortNameLastBidder($row['property_id']);
                    //END
                    //CALC REMAIN TIME
                    $data[$key]['remain_time'] = remainTime($row['end_time']);
                    //BEGIN GET START PRICE
                    $start_price = PT_getValueByCode($row['property_id'], 'auction_start_price');
                    $reserve_price = PT_getValueByCode($row['property_id'], 'reserve');
                    $data[$key]['check_start'] = ($start_price == $row['price']) ? true : false;
                    //$data[$key]['data_'] = $row;
                    // For Passed In Auctions
                    if ((($row['price'] < $reserve_price OR (Bid_isLastBidVendor($row['property_id']) AND $row['price'] >= $reserve_price) OR ($row['price_on_application'] > 0) OR ($row['price'] >= $reserve_price AND $data[$key]['check_start']))
                            AND ($row['stop_bid'] == 1 OR $row['end_time'] < date('Y-m-d H:i:s')))
                        OR ($data[$key]['ofAgent'] && $row['stop_bid'] == 1)
                    ) {
                        $data[$key]['auction_type'] = 'passedin';
                    }
                    //COUNTDOWN FOR LIVE
                    if ($row['confirm_sold'] == 1) {
                        $data[$key]['count'] = in_array($data[$key]['pro_type_code'], array('ebiddar', 'bid2stay')) ? 'Leased' : 'Sold';
                    } else {
                        if ($data[$key]['remain_time'] <= $count['once'] and $data[$key]['remain_time'] > $count['twice']) {
                            $data[$key]['count'] = 'Going once';
                        } elseif ($data[$key]['remain_time'] <= $count['twice'] and $data[$key]['remain_time'] > $count['third']) {
                            $data[$key]['count'] = 'Going twice';
                        } elseif ($data[$key]['remain_time'] <= $count['third'] and $row['stop_bid'] != 1) {
                            $data[$key]['count'] = 'Third and final call';
                        } else {
                            $data[$key]['count'] = '';
                        }
                    }
                    if (PE_isTheBlock($row['property_id'])) {
                        $data[$key]['count'] = $row['set_count'];
                    }
                }// End Auction
                $data[$key]['title_status'] = $data[$key]['title'];
            }
            /**/
            $data[$key]['buynow_price'] = showPrice($row['buynow_price']);
            $data[$key]['advertised_price'] = showAdvertisedPrice($row['property_id']);
            $data[$key]['getTypeProperty'] = PE_getTypeProperty($row['property_id']);
            $data[$key]['livability_rating_mark'] = showStar($row['livability_rating_mark']);
            $data[$key]['green_rating_mark'] = showStar($row['green_rating_mark']);
            $data[$key]['description'] = safecontent($row['description'], 100);
            //$data[$key]['description'] = nl2br($row['description']);
            if (strlen($row['description']) > 200) {
                $data[$key]['description'] = safecontent($row['description'], 200) . '...';
            }
            $data[$key]['is_mine'] = Property_isMine($_SESSION['agent']['id'], $row['property_id']);
            $data[$key]['isAgent'] = Property_isVendorOfProperty($row['property_id']);
            $data[$key]['address_full'] = implode(', ', array($row['address'], $row['suburb'], $row['state_code'], $row['postcode'], $row['country_name']));
            $data[$key]['address_short'] = strlen($data[$key]['address_full']) > 30 ? substr($data[$key]['address_full'], 0, 27) . ' ...' : $data[$key]['address_full'];
            $googleAddress = str_replace(' ', '+', $data[$key]['address_full']);
            if ($data[$key]['carport_value'] == null AND $data[$key]['parking'] == 1) {
                $data[$key]['carport_value'] = $data[$key]['carspace_value'];
            }
            //BEGIN FOR MEDIA
            $_media = PM_getPhoto($row['property_id'], true);
            global $mobileBrowser, $property_media_cls, $media_cls;
            if ($mobileBrowser) {
                $media_row = $property_media_cls->getRow('SELECT med.media_id,
														 med.file_name
												  FROM ' . $media_cls->getTable() . ' AS med,' . $property_media_cls->getTable() . " AS pro_med
												  WHERE med.media_id = pro_med.media_id
														AND med.type = 'photo'
														AND pro_med.property_id = " . $row['property_id'] . '
												  ORDER BY pro_med.default DESC', true);
                if ($property_media_cls->hasError()) {
                } elseif (is_array($media_row) and count($media_row) > 0) {
                    $data[$key]['file_name'] = trim($media_row['file_name'], '/');
                    $file_name = basename($data[$key]['file_name']);
                    $ar = explode('/', $data[$key]['file_name']);
                    unset($ar[count($ar) - 1]);
                    $dir_rel = implode('/', $ar);
                    $data[$key]['file_name'] = $dir_rel . '/' . $file_name;
                }
                if (!is_file($data[$key]['file_name'])) {
                    $data[$key]['file_name'] = 'modules/general/templates/images/hero-img.jpg';
                }
            }
            $data[$key]['photo'] = $_media['photo_thumb'];
            $data[$key]['photo_default'] = $_media['photo_thumb_default'];
            //$data[$key]['photo_defa']
            //END MEDIA
            //BEGIN GET RESERVE PRICE
            $data[$key]['reserve_price'] = PT_getValueByCode($row['property_id'], 'reserve');
            //check price>reserve price ?
            $data[$key]['check_price'] = false;
            if ($row['price'] >= $data[$key]['reserve_price'] && $data[$key]['reserve_price'] > 0) {
                $data[$key]['check_price'] = true;
            }
            // BEGIN LINK
            //shortUrl$data[$key]['detail_link'] = '/?'.http_build_query($link_ar);
            $data[$key]['edit_link'] = ROOTURL . '/?module=property&action=register&step=' . $row['step'] . '&id=' . $row['property_id'];
            $data[$key]['cancel_bidding_link'] = ROOTURL . '/?module=property&action=cancel_bidding&id=' . $row['property_id'];
            $_SESSION['redirect_link'] = ROOTURL . '' . $_SERVER['REQUEST_URI'];
            //END
            $data[$key]['awl'] = "pro.addWatchlist('/modules/property/action.php?action=add-watchlist&property_id=" . $row['property_id'] . "')";
            $data[$key]['o4i'] = Calendar_createPopup($row['property_id'], $row['open_for_inspection'], $mode);
            $data[$key]['btn_open_for_inspection'] = Calendar_createButton($row['property_id'], $row['open_for_inspection'], $mode);
            //get data contact form
            $data[$key]['contact_info'] = PE_getAgent($row['agent_id']);
            $data[$key]['mao'] = Property_makeAnOfferPopup($row['property_id']);
            $data[$key]['isBlock'] = PE_isTheBlock($row['property_id']) ? 1 : 0;
            $data[$key]['ofAgent'] = PE_isTheBlock($row['property_id'], 'agent') ? 1 : 0;
            $auction_option = PEO_getOptionById($row['auction_sale']);
            $data[$key]['auction_title'] = strtoupper($auction_option['title']);
            // $data[$key]['detail_link'] = shortUrl($link_ar + array('data' => $data[$key]),
            // ($data[$key]['ofAgent']?Agent_getAgent($row['property_id']):array())
            $rowaddress = str_replace(' ', '-', $row['address']);
            $rowaddress = str_replace(',', '', $rowaddress);
            $rowaddress = (substr($rowaddress, -1) == '-') ? substr($rowaddress, 0, -1) : $rowaddress;
            $rowsuburb = str_replace(' ', '-', $row['suburb']);
            $data[$key]['detail_link'] = "/" . strtolower($row['state_code']) . "/for-sale/$rowsuburb/$rowaddress/id-" . $row['property_id'];
            if ($data[$key]['isBlock'] == 1) {
                $data[$key]['remain_time'] = remainTime($row['start_time']);
                $data[$key]['popup'] = "return showMess('Please go to property detail to have full function to bid.')";
            }
            if ($data[$key]['ofAgent']) {
                //$data[$key]['agent'] = A_getCompanyInfo($row['property_id']);
                $data[$key]['agent'] = A_getAgentManageInfo($row['property_id']);
                //$data[$key]['agent']['logo'] = resizeImageNew($data[$key]['agent']['logo'],220,220);
            }
            $data[$key]['isSold'] = (int)PE_getSoldStatus($row['property_id']);
            $data[$key]['isRent'] = PE_isAuction($row['property_id'], 'ebiddar') || PE_isAuction($row['property_id'], 'bid2stay') ? true : false;
            $data[$key]['ebidda_watermark'] = PE_getEbiddaWatermark($row['property_id']);
            //$data[$key]['isVendor'] = Property_isMine($_SESSION['agent']['id'],$row['property_id']);
            $data[$key]['isVendor'] = Property_isVendorOfProperty($row['property_id'], $_SESSION['agent']['id']);
            $dt1 = new DateTime($row['end_time']);
            if ($row['confirm_sold'] == Property::SOLD_COMPLETE)
                $dt1 = new DateTime($row['sold_time']);
            $dt2 = new DateTime(date('Y-m-d H:i:s'));
            $data[$key]['Day'] = date_diff($dt1, $dt2)->format('%d Days');
            if ($data[$key]['pro_type'] == 'sale')
                $data[$key]['Day'] = '0 Days';
            // For check register to Bid
            $data[$key]['register_bid'] = Property_registerBid($row['property_id']);
            if ($data[$key]['isBlock'] == 1 AND $data[$key]['isVendor']) {
                $data[$key]['register_bid'] = true;
            }
            //print_r($data[$key]['property_id'].'='.$data[$key]['SoldTime'].'</br>');
            $saleStatus = '';
            /* TITLE */
            if (!$data[$key]['isBlock'] && !$data[$key]['ofAgent']) {
                if ($data[$key]['pro_type'] == "forthcoming" || $data[$key]['pro_type'] == 'auction') {
                    if ($data[$key]['auction_type'] == 'passedin') {
                        //$data[$key]['show_title'] = Localizer::translate('Auction Ended') . ': ' . $data[$key]['end_time'];
                        $saleStatus = 'Off Market';
                    } else {
                        $data[$key]['show_title'] = Localizer::translate('Auction Ends') . ': ' . $data[$key]['end_time'];
                        $saleStatus = 'Current';
                    }
                } else {
                    //$data[$key]['show_title'] = Localizer::translate('For Sale') . ': ' . $data[$key]['suburb'];
                }
                if ($data[$key]['confirm_sold'] == 1 && $data[$key]['pro_type'] != 'sale') {
                    ///$data[$key]['show_title'] = Localizer::translate('Auction End') . ': ' . $data[$key]['end_time'];
                    $saleStatus = 'Sold';
                }
                $data[$key]['show_title'] = $data[$key]['title'];
            } elseif ($data[$key]['isBlock']) {
                $data[$key]['show_title'] = $data[$key]['owner'];
            } else {
                $data[$key]['show_title'] =  'AGENT : ' . $data[$key]['agent']['company_name'];
            }

            $reaxml_status = PE_getPropertyStatusREA_xml($row['property_id']);
            $data[$key]['reaxml_status'] = '';
            if (in_array($reaxml_status, array('sold', 'leased', 'passed in', 'under offer')))
                $data[$key]['reaxml_status'] = str_replace(' ', '_', $reaxml_status);
            /*----REA XML DATA-----*/
            $data[$key]['reaxml']['saleStatus'] = $saleStatus;
            $data[$key]['videos'] = PM_getVideo($row['property_id']);
            $property_type_options = PEO_getOptions('property_type_commercial');
            $data[$key]['category'] = $property_type_options[$row['type']];
            /*---formUnescapes----*/
            $data[$key] = formUnescapes($data[$key]);
        }
    }
    //print_r($_SESSION);
    return $data;
}

/**
 * @ function : Property_getList
 * @ argument :
 * @ output :
 **/
function Property_getListForApi($wh_clause = '', $len = 0, $search_query = '', $pag_link = '')
{
    global $smarty
           , $property_cls
           , $region_cls
           , $property_entity_option_cls
           , $pag_cls
           , $config_cls
           , $agent_cls
           , $bids_first_cls
           , $total_found
           , $agent_payment_cls;
    if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
        $pag_cls = new Paginate();
    }
    $count = array();
    $count['once'] = $config_cls->getKey('count_going_once');
    $count['twice'] = $config_cls->getKey('count_going_twice');
    $count['third'] = $config_cls->getKey('count_going_third');
    $auction_sale_ar = PEO_getAuctionSale();
    $wh_price = '(SELECT CASE
            					WHEN pro.auction_sale != ' . $auction_sale_ar['private_sale'] . '
									 AND ( date(pro.start_time) > \'' . date('Y-m-d H:i:s') . '\' OR isnull(max(bid.price)) ) THEN
									(SELECT pro_term.value
									 FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
									 LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
									 	ON pro_term.auction_term_id = term.auction_term_id
									 WHERE term.code = \'auction_start_price\'
									 		AND pro.property_id = pro_term.property_id)
            					WHEN auction_sale = ' . $auction_sale_ar['private_sale'] . ' AND pro.price != 0 THEN pro.price
                                WHEN auction_sale = ' . $auction_sale_ar['private_sale'] . ' AND pro.price = 0 AND pro.price_on_application != 0 THEN pro.price_on_application
            				ELSE max(bid.price)
            				END
            		FROM bids AS bid WHERE bid.property_id = pro.property_id) + 0';
    if (getPost('order_by') != '' || (isset($_POST['search']) && isset($_POST['search']['order_by']) && $_POST['search']['order_by'] != '')) {
        $_SESSION['order_by'] = (getPost('order_by') != '') ? getPost('order_by') : $_POST['search']['order_by'];
    }
    $order_by = isset($_SESSION['order_by']) ? $_SESSION['order_by'] : '';
    switch ($order_by) {
        case 'highest':
            $order_ar = $wh_price . ' DESC';
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
        default:
            //$order_ar = ' pro.start_time DESC';
            $order_ar = in_array(getParam('action'), array('search', 'search-auction', 'search-sale')) ? 'pro.confirm_sold, pro.stop_bid, pro.end_time' :
                'pro.end_time';
            //$order_ar = ' ';
            break;
    }
    $p = 1;
    $order_ar = ($order_ar != '') ? ' ORDER BY ' . $order_ar : '';
    $limit = ($len == 0) ? " " : " LIMIT 0, " . $len;
    $wh_arr = Property_getCondition();
    /*IBB-1022:Hide The Block properties from view in the Online Auctions section: NHUNG*/
    /*
        $wh_arr[] = '  (SELECT agtype.title
                       FROM '.$agent_cls->getTable('agent_type')." AS agtype
                       WHERE agtype.agent_type_id = agt.type_id) != 'theblock'";
		*/
    $wh_str = count($wh_arr) > 0 ? ' AND ' . implode(' AND ', $wh_arr) : '';
    $rows = $property_cls->getRows("SELECT SQL_CALC_FOUND_ROWS pro.property_id,
													pro.address,
													pro.suburb,
													pro.state,
													pro.step,
													pro.postcode,
													pro.end_time,
													pro.start_time,
													pro.livability_rating_mark,
													pro.green_rating_mark,
										 			pro.last_bid_time,
													pro.description,
													pro.open_for_inspection,
													pro.agent_active,
													pro.auction_sale,
													pro.confirm_sold,
													pro.sold_time,
													pro.stop_bid,
													agt.type_id,
													pro.set_count,
													pro.owner,
													pro.kind,
													pro.parking,
													pro.price_on_application,
													pro.buynow_price,
													pro.buynow_buyer_id,
													pro.buynow_status,
													pro.land_size,

													(SELECT reg1.name
													FROM " . $region_cls->getTable() . " AS reg1
													WHERE reg1.region_id = pro.state
													) AS state_name,

													(SELECT reg2.name
													FROM " . $region_cls->getTable() . " AS reg2
													WHERE reg2.region_id = pro.country
													) AS country_name,

													(SELECT pro_opt1.value
													FROM " . $property_entity_option_cls->getTable() . " AS pro_opt1
													WHERE pro_opt1.property_entity_option_id = pro.bathroom
													) AS bathroom_value,

													(SELECT pro_opt2.value
													FROM " . $property_entity_option_cls->getTable() . " AS pro_opt2
													WHERE pro_opt2.property_entity_option_id = pro.bedroom
													) AS bedroom_value,

													(SELECT pro_opt3.value
													FROM " . $property_entity_option_cls->getTable() . " AS pro_opt3
													WHERE pro_opt3.property_entity_option_id = pro.car_port
													) AS carport_value,

													(SELECT pro_opt4.code
													FROM " . $property_entity_option_cls->getTable() . " AS pro_opt4
													WHERE pro_opt4.property_entity_option_id = pro.auction_sale
													) AS auctionsale_code,

                                                    (SELECT pro_opt6.code
                                                    FROM " . $property_entity_option_cls->getTable() . " AS pro_opt6
                                                    WHERE pro_opt6.property_entity_option_id = pro.auction_sale
                                                    ) AS auction_sale_code,

													(SELECT pro_opt8.value
                                                    FROM " . $property_entity_option_cls->getTable() . " AS pro_opt8
                                                    WHERE pro_opt8.property_entity_option_id = pro.car_space
                                                    ) AS carspace_value,

                                                    (SELECT pro_opt6.code
                                                    FROM " . $property_entity_option_cls->getTable() . " AS pro_opt6
                                                    WHERE pro_opt6.property_entity_option_id = pro.period
                                                    ) AS period,

                                                    " . $wh_price . " AS price

												FROM " . $property_cls->getTable() . " AS pro

												INNER JOIN " . $property_cls->getTable('agent') . " AS agt
													ON pro.agent_id = agt.agent_id
												WHERE   pro.active = 1
														AND pro.agent_active = 1
														AND pro.pay_status = " . Property::CAN_SHOW
        . $wh_str
        . $wh_clause
        . $order_ar
        . $limit, true);
    //print_r($property_cls->sql);
    $mode = getParam('mode', 'list') == 'grid' ? getParam('mode', 'list') : 'list';
    $url_part = /*$mode == 'grid' ? '&mode=grid' : */
        '';
    $url_search = '';
    //$pag_link = '/?module=property&action='.getParam('action');
    if (preg_match('/.html/', @$_SERVER['REDIRECT_URL'])) {
        $pag_link = parseRedirectUrl(@$_SERVER['REDIRECT_URL']);
        if (preg_match('/rs=1/', @$_SERVER['REDIRECT_URL'])) {
            $pag_link .= '&rs=1';
        }
        $pag_link .= '&mode=' . $mode;
    }
    if ($pag_link == "") {
        $pag_link = $_SERVER['REQUEST_URI'];
    }
    if (in_array(getParam('action'), array('search', 'search-auction', 'search-sale'))) {
        $url_search = '&' . $search_query . '&order_by=' . $order_by;
        $url_search = str_replace('&&', '&', $url_search);
        //$pag_link = getParam('action').'-'.$mode.'.html';
    } else if (strlen($pag_link) == 0) {
        //$pag_link = str_replace('list', $mode, getParam('action')).'.html';
    }
    $total_found = $total_row = $property_cls->getFoundRows();
    $pag_cls->setTotal($total_row)
        ->setPerPage($len)
        ->setCurPage(1)
        ->setLenPage(10)
        ->setUrl($pag_link . $url_search . $url_part)
        ->setLayout('link_simple');
    $smarty->assign('mode', $mode);
    $smarty->assign('pag_str', $pag_cls->layout());
    $smarty->assign('review_pagging', (($p - 1) * $len) . ' - ' . (($p * $len) > $total_row ? $total_row : ($p * $len)) . ' (' . $total_row . ' items)');
    $data = array();
    $_SESSION['prev_next_ids_ar'] = array();
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $key => $row) {
            $data[$key] = $row;
            /*QUAN: PREV & NEXT*/
            $_SESSION['prev_next_ids_ar'][] = $row['property_id'];
            $type = PEO_getOptionById($row['auction_sale']);
            $data[$key]['pro_type_code'] = $type['code'];
            $data[$key]['pro_type'] = 'sale';
            $data[$key]['set_count'] = $row['set_count'];
            $link_ar = array('module' => 'property',
                'action' => '',
                'id' => $row['property_id']);
            $link_ar['action'] = 'view-sale-detail';
            $data[$key]['price'] = showPrice($row['price']);
            if ($row['auction_sale'] == $auction_sale_ar['private_sale']) {
                $data[$key]['price'] = $row['price_on_application'] == 1 ? 'Price On Application' : showPrice($row['price']);
            }
            if ($row['auction_sale'] != $auction_sale_ar['private_sale']) {
                $dt1 = new DateTime($row['start_time']);
                $data[$key]['start_time'] = $dt1->format($config_cls->getKey('general_date_format'));
                $dt = new DateTime($row['end_time']);
                $data[$key]['end_time'] = $dt->format($config_cls->getKey('general_date_format'));
                $current = new DateTime(date('Y-m-d H:i:s'));
                if ($dt1 > $current
                    OR ($row['confirm_sold'] == Property::SOLD_COMPLETE AND $row['sold_time'] < $row['start_time'])
                ) {//FORTHCOMING
                    $data[$key]['pro_type'] = 'forthcoming';
                    $link_ar['action'] = 'view-forthcoming-detail';
                    $reserve_price = PT_getValueByCode($row['property_id'], 'reserve');
                    global $mobileBrowser;
                    if ($mobileBrowser) {
                        $data[$key]['price'] = $row['price_on_application'] > 0 ? 'POA' : '' . showLowPrice($reserve_price) . ' - ' . showHighPrice($reserve_price) . '';
                    } else {
                        $data[$key]['price'] = $row['price_on_application'] > 0 ? 'Price On Application' : showLowPrice($reserve_price) . ' - ' . showHighPrice($reserve_price);
                    }
                    if ($row['confirm_sold'] == Property::SOLD_COMPLETE) {
                        $data[$key]['price'] = showPrice($row['price']);
                    }
                    if ($mode == 'grid') {
                        $data[$key]['price'] = $row['price_on_application'] > 0 ? 'Price On Application' : '' . showLowPrice($reserve_price) . ' - ' . showHighPrice($reserve_price) . '';
                    }
                    if (in_array($row['auction_sale'], array($auction_sale_ar['ebiddar'], $auction_sale_ar['bid2stay']))) {
                        $data[$key]['price'] = $row['price_on_application'] > 0 ? 'Price On Application' : 'Starting at ' . showPrice($row['price']);
                    }
                    $data[$key]['buynow_price'] = showPrice($row['buynow_price']);
                } else {//AUCTION
                    $data[$key]['pro_type'] = 'auction';
                    $link_ar['action'] = 'view-auction-detail';
                    //BEGIN BIDDER
                    $data[$key]['isLastBidVendor'] = Bid_isLastBidVendor($row['property_id']);
                    $data[$key]['bidder'] = Bid_getShortNameLastBidder($row['property_id']);
                    //END
                    //CALC REMAIN TIME
                    $data[$key]['remain_time'] = remainTime($row['end_time']);
                    //BEGIN GET START PRICE
                    $start_price = PT_getValueByCode($row['property_id'], 'auction_start_price');
                    $reserve_price = PT_getValueByCode($row['property_id'], 'reserve');
                    $data[$key]['check_start'] = ($start_price == $row['price']) ? true : false;
                    //$data[$key]['data_'] = $row;
                    // For Passed In Auctions
                    if ((($row['price'] < $reserve_price OR (Bid_isLastBidVendor($row['property_id']) AND $row['price'] >= $reserve_price) OR ($row['price_on_application'] > 0) OR ($row['price'] >= $reserve_price AND $data[$key]['check_start']))
                            AND ($row['stop_bid'] == 1 OR $row['end_time'] < date('Y-m-d H:i:s')))
                        OR ($data[$key]['ofAgent'] && $row['stop_bid'] == 1)
                    ) {
                        $data[$key]['auction_type'] = 'passedin';
                    }
                    //COUNTDOWN FOR LIVE
                    if ($row['confirm_sold'] == 1) {
                        $data[$key]['count'] = in_array($data[$key]['pro_type_code'], array('ebiddar', 'bid2stay')) ? 'Leased' : 'Sold';
                    } else {
                        if ($data[$key]['remain_time'] <= $count['once'] and $data[$key]['remain_time'] > $count['twice']) {
                            $data[$key]['count'] = 'Going once';
                        } elseif ($data[$key]['remain_time'] <= $count['twice'] and $data[$key]['remain_time'] > $count['third']) {
                            $data[$key]['count'] = 'Going twice';
                        } elseif ($data[$key]['remain_time'] <= $count['third'] and $row['stop_bid'] != 1) {
                            $data[$key]['count'] = 'Third and final call';
                        } else {
                            $data[$key]['count'] = '';
                        }
                    }
                    if (PE_isTheBlock($row['property_id'])) {
                        $data[$key]['count'] = $row['set_count'];
                    }
                }// End Auction
            }
            //$data[$key]['livability_rating_mark'] =  showStar($row['livability_rating_mark']);
            //$data[$key]['green_rating_mark'] = showStar($row['green_rating_mark']);
            //$data[$key]['description'] = safecontent($row['description'],100);
            //$data[$key]['description'] = nl2br($row['description']);
            if (strlen($row['description']) > 200) {
                $data[$key]['description'] = safecontent($row['description'], 1000) . '...';
            }
            //$data[$key]['is_mine'] = Property_isMine($_SESSION['agent']['id'],$row['property_id']);
            //$data[$key]['isAgent'] = Property_isVendorOfProperty($row['property_id']);
            $data[$key]['address_full'] = implode(', ', array($row['address'], $row['suburb'], $row['state_name'], $row['postcode'], $row['country_name']));
            $data[$key]['address_short'] = strlen($data[$key]['address_full']) > 30 ? substr($data[$key]['address_full'], 0, 27) . ' ...' : $data[$key]['address_full'];
            $googleAddress = str_replace(' ', '+', $data[$key]['address_full']);
            if ($data[$key]['carport_value'] == null AND $data[$key]['parking'] == 1) {
                $data[$key]['carport_value'] = $data[$key]['carspace_value'];
            }
            //BEGIN FOR MEDIA
            $_media = PM_getPhoto($row['property_id'], true);
            global $mobileBrowser, $property_media_cls, $media_cls;
            if ($mobileBrowser) {
                $media_row = $property_media_cls->getRow('SELECT med.media_id,
														 med.file_name
												  FROM ' . $media_cls->getTable() . ' AS med,' . $property_media_cls->getTable() . " AS pro_med
												  WHERE med.media_id = pro_med.media_id
														AND med.type = 'photo'
														AND pro_med.property_id = " . $row['property_id'] . '
												  ORDER BY pro_med.default DESC', true);
                if ($property_media_cls->hasError()) {
                } elseif (is_array($media_row) and count($media_row) > 0) {
                    $data[$key]['file_name'] = trim($media_row['file_name'], '/');
                    $file_name = basename($data[$key]['file_name']);
                    $ar = explode('/', $data[$key]['file_name']);
                    unset($ar[count($ar) - 1]);
                    $dir_rel = implode('/', $ar);
                    $data[$key]['file_name'] = $dir_rel . '/' . $file_name;
                }
                if (!is_file($data[$key]['file_name'])) {
                    $data[$key]['file_name'] = 'modules/general/templates/images/hero-img.jpg';
                }
            }
            $data[$key]['photo'] = $_media['photo_thumb'];
            $data[$key]['photo_default'] = $_media['photo_thumb_default'];
            //$data[$key]['photo_defa']
            //END MEDIA
            //BEGIN GET RESERVE PRICE
            $data[$key]['reserve_price'] = PT_getValueByCode($row['property_id'], 'reserve');
            //check price>reserve price ?
            $data[$key]['check_price'] = false;
            if ($row['price'] >= $data[$key]['reserve_price'] && $data[$key]['reserve_price'] > 0) {
                $data[$key]['check_price'] = true;
            }
            // BEGIN LINK
            //shortUrl$data[$key]['detail_link'] = '/?'.http_build_query($link_ar);
            //$data[$key]['edit_link'] = ROOTURL.'/?module=property&action=register&step='.$row['step'].'&id='.$row['property_id'];
            //$data[$key]['cancel_bidding_link'] = ROOTURL.'/?module=property&action=cancel_bidding&id='.$row['property_id'];
            //$_SESSION['redirect_link'] = ROOTURL.''.$_SERVER['REQUEST_URI'];
            //END
            //$data[$key]['awl'] = "pro.addWatchlist('/modules/property/action.php?action=add-watchlist&property_id=".$row['property_id']."')";
            //$data[$key]['o4i'] = Calendar_createPopup($row['property_id'],$row['open_for_inspection'],$mode);
            //get data contact form
            $data[$key]['contact_info'] = PE_getAgent($row['agent_id']);
            //$data[$key]['mao'] = Property_makeAnOfferPopup($row['property_id']);
            $data[$key]['isBlock'] = PE_isTheBlock($row['property_id']) ? 1 : 0;
            $data[$key]['ofAgent'] = PE_isTheBlock($row['property_id'], 'agent') ? 1 : 0;
            $auction_option = PEO_getOptionById($row['auction_sale']);
            $data[$key]['auction_title'] = strtoupper($auction_option['title']);
            $data[$key]['detail_link'] = shortUrl($link_ar + array('data' => $data[$key]),
                ($data[$key]['ofAgent'] ? Agent_getAgent($row['property_id']) : array())
            );
            if ($data[$key]['isBlock'] == 1) {
                $data[$key]['remain_time'] = remainTime($row['start_time']);
                $data[$key]['popup'] = "return showMess('Please go to property detail to have full function to bid.')";
            }
            if ($data[$key]['ofAgent']) {
                $data[$key]['agent'] = A_getCompanyInfo($row['property_id']);
            }
            $data[$key]['isSold'] = (int)PE_getSoldStatus($row['property_id']);
            $data[$key]['isRent'] = PE_isAuction($row['property_id'], 'ebiddar') || PE_isAuction($row['property_id'], 'bid2stay') ? true : false;
            $data[$key]['ebidda_watermark'] = PE_getEbiddaWatermark($row['property_id']);
            //$data[$key]['isVendor'] = Property_isMine($_SESSION['agent']['id'],$row['property_id']);
            $data[$key]['isVendor'] = Property_isVendorOfProperty($row['property_id'], $_SESSION['agent']['id']);
            $dt1 = new DateTime($row['end_time']);
            if ($row['confirm_sold'] == Property::SOLD_COMPLETE)
                $dt1 = new DateTime($row['sold_time']);
            $dt2 = new DateTime(date('Y-m-d H:i:s'));
            $data[$key]['Day'] = date_diff($dt1, $dt2)->format('%d Days');
            if ($data[$key]['pro_type'] == 'sale')
                $data[$key]['Day'] = '0 Days';
            // For check register to Bid
            $data[$key]['register_bid'] = Property_registerBid($row['property_id']);
            if ($data[$key]['isBlock'] == 1 AND $data[$key]['isVendor']) {
                $data[$key]['register_bid'] = true;
            }
            //print_r($data[$key]['property_id'].'='.$data[$key]['SoldTime'].'</br>');
            /* TITLE */
            if (!$data[$key]['isBlock'] && !$data[$key]['ofAgent']) {
                if ($data[$key]['pro_type'] == "forthcoming" || $data[$key]['pro_type'] == 'auction') {
                    if ($data[$key]['auction_type'] == 'passedin') {
                        $data[$key]['show_title'] = Localizer::translate('Auction Ended') . ': ' . $data[$key]['end_time'];
                    } else {
                        $data[$key]['show_title'] = Localizer::translate('Auction Ends') . ': ' . $data[$key]['end_time'];
                    }
                } else {
                    $data[$key]['show_title'] = Localizer::translate('For Sale') . ': ' . $data[$key]['suburb'];
                }
                if ($data[$key]['confirm_sold'] == 1 && $data[$key]['pro_type'] != 'sale') {
                    $data[$key]['show_title'] = Localizer::translate('Auction End') . ': ' . $data[$key]['end_time'];
                }
            } elseif ($data[$key]['isBlock']) {
                $data[$key]['show_title'] = $data[$key]['owner'];
            } else {
                $data[$key]['show_title'] = $data[$key]['auction_title'] . ': ' . $data[$key]['agent']['company_name'];
            }
            /*---formUnescapes----*/
            $data[$key] = formUnescapes($data[$key]);
        }
    }
    //print_r($_SESSION);
    return $data;
}

function getSurroundWhereStr($wh_clause = '', $search_query = '', $pag_link = '')
{
    global $smarty
           , $property_cls
           , $region_cls
           , $property_entity_option_cls
           , $pag_cls
           , $config_cls
           , $agent_cls
           , $bids_first_cls
           , $total_found
           , $agent_payment_cls;
    if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
        $pag_cls = new Paginate();
    }
    $count = array();
    $count['once'] = $config_cls->getKey('count_going_once');
    $count['twice'] = $config_cls->getKey('count_going_twice');
    $count['third'] = $config_cls->getKey('count_going_third');
    $auction_sale_ar = PEO_getAuctionSale();
    $wh_price = '(SELECT CASE
            					WHEN pro.auction_sale != ' . $auction_sale_ar['private_sale'] . '
									 AND ( date(pro.start_time) > \'' . date('Y-m-d H:i:s') . '\' OR isnull(max(bid.price)) ) THEN
									(SELECT pro_term.value
									 FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
									 LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
									 	ON pro_term.auction_term_id = term.auction_term_id
									 WHERE term.code = \'auction_start_price\'
									 		AND pro.property_id = pro_term.property_id)
            					WHEN auction_sale = ' . $auction_sale_ar['private_sale'] . ' AND pro.price != 0 THEN pro.price
                                WHEN auction_sale = ' . $auction_sale_ar['private_sale'] . ' AND pro.price = 0 AND pro.price_on_application != 0 THEN pro.price_on_application
            				ELSE max(bid.price)
            				END
            		FROM bids AS bid WHERE bid.property_id = pro.property_id) + 0';
    if (getPost('order_by') != '' || (isset($_POST['search']) && isset($_POST['search']['order_by']) && $_POST['search']['order_by'] != '')) {
        $_SESSION['order_by'] = (getPost('order_by') != '') ? getPost('order_by') : $_POST['search']['order_by'];
    }
    $order_by = isset($_SESSION['order_by']) ? $_SESSION['order_by'] : '';
    switch ($order_by) {
        case 'highest':
            $order_ar = $wh_price . ' DESC';
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
        default:
            //$order_ar = ' pro.start_time DESC';
            $order_ar = in_array(getParam('action'), array('search', 'search-auction', 'search-sale')) ? 'pro.confirm_sold, pro.stop_bid, pro.end_time' :
                'pro.end_time';
            //$order_ar = ' ';
            break;
    }
    $order_ar = ($order_ar != '') ? ' ORDER BY ' . $order_ar : '';
    $smarty->assign('order_by', $order_by);
    $wh_arr = Property_getCondition();
    /*IBB-1022:Hide The Block properties from view in the Online Auctions section: NHUNG*/
    /*
        $wh_arr[] = '  (SELECT agtype.title
                       FROM '.$agent_cls->getTable('agent_type')." AS agtype
                       WHERE agtype.agent_type_id = agt.type_id) != 'theblock'";
		*/
    $wh_str = count($wh_arr) > 0 ? ' AND ' . implode(' AND ', $wh_arr) : '';
    $postcode_arr = $property_cls->getRows("SELECT postcode FROM ( SELECT pro.postcode,
													pro.end_time,
													pro.start_time,
													pro.livability_rating_mark,
													pro.green_rating_mark,
										 			pro.last_bid_time,
													pro.description,
													pro.open_for_inspection,
													pro.agent_active,
													pro.auction_sale,
													pro.confirm_sold,
													pro.sold_time,
													pro.stop_bid,
													agt.type_id,
													pro.set_count,
													pro.owner,
													pro.kind,
													pro.parking,
													pro.price_on_application,
													pro.buynow_price,

													(SELECT reg1.name
													FROM " . $region_cls->getTable() . " AS reg1
													WHERE reg1.region_id = pro.state
													) AS state_name,

													(SELECT reg2.name
													FROM " . $region_cls->getTable() . " AS reg2
													WHERE reg2.region_id = pro.country
													) AS country_name,

													(SELECT pro_opt1.value
													FROM " . $property_entity_option_cls->getTable() . " AS pro_opt1
													WHERE pro_opt1.property_entity_option_id = pro.bathroom
													) AS bathroom_value,

													(SELECT pro_opt2.value
													FROM " . $property_entity_option_cls->getTable() . " AS pro_opt2
													WHERE pro_opt2.property_entity_option_id = pro.bedroom
													) AS bedroom_value,

													(SELECT pro_opt3.value
													FROM " . $property_entity_option_cls->getTable() . " AS pro_opt3
													WHERE pro_opt3.property_entity_option_id = pro.car_port
													) AS carport_value,

													(SELECT pro_opt4.code
													FROM " . $property_entity_option_cls->getTable() . " AS pro_opt4
													WHERE pro_opt4.property_entity_option_id = pro.auction_sale
													) AS auctionsale_code,

                                                    (SELECT pro_opt6.code
                                                    FROM " . $property_entity_option_cls->getTable() . " AS pro_opt6
                                                    WHERE pro_opt6.property_entity_option_id = pro.auction_sale
                                                    ) AS auction_sale_code,

													(SELECT pro_opt8.value
                                                    FROM " . $property_entity_option_cls->getTable() . " AS pro_opt8
                                                    WHERE pro_opt8.property_entity_option_id = pro.car_space
                                                    ) AS carspace_value,

                                                    (SELECT pro_opt6.code
                                                    FROM " . $property_entity_option_cls->getTable() . " AS pro_opt6
                                                    WHERE pro_opt6.property_entity_option_id = pro.period
                                                    ) AS period,

                                                    " . $wh_price . " AS price

												FROM " . $property_cls->getTable() . " AS pro

												INNER JOIN " . $property_cls->getTable('agent') . " AS agt
													ON pro.agent_id = agt.agent_id
												WHERE   pro.active = 1
														AND pro.agent_active = 1
														AND pro.pay_status = " . Property::CAN_SHOW
        . $wh_str
        . $wh_clause
        . ' GROUP BY pro.postcode '
        . $order_ar
        . ' ) as rs', true);
    //print_r($property_cls->sql);die();
    //var_dump($postcode_arr);die();
    $AUST_postcode_arr = array(
        array(1000, 1999),//NSW
        array(2000, 2599),
        array(2619, 2898),
        array(2921, 2999),
        array(200, 299), //ACT
        array(2600, 2618),
        array(2900, 2920),
        array(3000, 3999),//VIC
        array(8000, 8999),
        array(4000, 4999),//QLD
        array(9000, 9999),
        array(5000, 5799),//SA
        array(5800, 5999),
        array(6000, 6797),//WA
        array(6800, 6999),
        array(7000, 7799),//TAS
        array(7800, 7999),
        //array(0800, 0899),//TAS
        //array(0900, 0999),
    );
    $in_range_arr = array();
    foreach ($AUST_postcode_arr as $key => $val) {
        foreach ($postcode_arr as $postcode) {
            if ($postcode['postcode'] >= $val[0] && $postcode['postcode'] <= $val[1]) {
                if (!in_array($val, $in_range_arr)) {
                    array_push($in_range_arr, $val);
                }
            }
        }
    }
    $extra_where_str = "";
    foreach ($in_range_arr as $key => $arr) {
        $extra_where_str .= " OR (pro.postcode >= " . $arr[0] . " AND pro.postcode <= " . $arr[1] . " ) ";
    }
    return $extra_where_str;
}

//get Query from Form Data
function getSearchQueryByFormData(&$form_data = array(), &$action)
{
    $form_data['checked'] = 'true';
    //print_r_pre($form_data);die();
    global $region_cls, $property_cls, $agent_cls;
    $where_str = '';
    $where_ar = array();
    foreach ($form_data as $key => $data) {
        if ($data == '') {
            unset($form_data[$key]);
        }
    }
    $auction_sale_ar = PEO_getAuctionSale();
    if (isset($form_data['property_type']) && ($form_data['property_type'] > 0)) {
        $where_ar[] = "pro.`type` = " . $form_data['property_type'];
        $kind_ar = PEO_getKindByType($form_data['property_type']);
        if (is_array($kind_ar) and count($kind_ar) > 0) {
            if ($kind_ar['code'] == 'property_type') {
                $where_ar[] = "pro.`kind` = 2";
            }
            if ($kind_ar['code'] == 'property_type_commercial') {
                $where_ar[] = "pro.`kind` = 1";
            }
        }
    }
    if (isset($form_data['property_kind']) && ($form_data['property_kind'] > 0)) {
        $where_ar[] = "pro.`kind` = " . $form_data['property_kind'];
        $type_options = PEO_getTypeByKind($form_data['property_kind']);
        $type_ = "(";
        if (count($type_options) > 0 and is_array($type_options)) {
            foreach ($type_options as $key => $value) {
                $type_ .= $key . ',';
            }
        }
        $type_ .= ")";
        $type_ = str_replace(",)", ")", $type_);
        $where_ar[] = "pro.`type` IN " . $type_;
        if ($form_data['property_kind'] == 1) {
            unset($form_data['bedroom'], $form_data['bathroom']);
        }
    }
    if (isset($form_data['parking']) && ($form_data['parking'] >= 0)) { // it have  options (Any => -1 ,No=> 0, Yes => 1)
        $where_ar[] = "pro.`parking` = " . $form_data['parking'];
    }
    if (isset($form_data['region']) && strlen($form_data['region']) > 0) {
        $str = "( concat(pro.suburb,' ',
                            (SELECT reg_s1.code
                                FROM " . $region_cls->getTable() . " AS reg_s1
                                WHERE reg_s1.region_id = pro.state),' ',
                            pro.postcode ) LIKE '%" . $property_cls->escape($form_data['region']) . "%'
                   OR pro.property_id LIKE '%" . $property_cls->escape($form_data['region']) . "%' )";
        $where_ar[] = $str;
    }
    if (isset($form_data['address']) && strlen($form_data['address']) > 0) {
        $where_ar[] = "pro.address LIKE '%" . $form_data['address'] . "%'";
    }
    if (isset($form_data['property_id']) && strlen($form_data['property_id']) > 0) {
        $form_data['region'] = $form_data['property_id'];
        $where_ar[] = "pro.property_id LIKE '%" . $form_data['property_id'] . "%'";
    }
    if (isset($form_data['suburb']) && strlen($form_data['suburb']) > 0) {
        $where_ar[] = "pro.suburb LIKE '%" . $property_cls->escape($form_data['suburb']) . "%'";
    }
    if (isset($form_data['state']) && $form_data['state'] > 0) {
        $_state_id = preg_replace('#[^0-9]#', '', $property_cls->escape($form_data['state']));
        $where_ar[] = "pro.state = " . $_state_id;
    }
    if (isset($form_data['postcode']) && strlen($form_data['postcode']) > 0) {
        $_postcode = preg_replace('#[^0-9]#', '', $property_cls->escape($form_data['postcode']));
        $AUST_postcode_arr = array(
            array(1000, 1999),//NSW
            array(2000, 2599),
            array(2619, 2898),
            array(2921, 2999),
            array(200, 299), //ACT
            array(2600, 2618),
            array(2900, 2920),
            array(3000, 3999),//VIC
            array(8000, 8999),
            array(4000, 4999),//QLD
            array(9000, 9999),
            array(5000, 5799),//SA
            array(5800, 5999),
            array(6000, 6797),//WA
            array(6800, 6999),
            array(7000, 7799),//TAS
            array(7800, 7999),
            //array(0800, 0899),//TAS
            //array(0900, 0999),
        );
        $in_range_arr = array();
        foreach ($AUST_postcode_arr as $key => $val) {
            if ((int)$_postcode >= $val[0] && (int)$_postcode <= $val[1]) {
                if (!in_array($val, $in_range_arr)) {
                    array_push($in_range_arr, $val);
                }
            }
        }
        $extra_where_str = "";
        foreach ($in_range_arr as $key => $arr) {
            $extra_where_str .= " OR (pro.postcode >= " . $arr[0] . " AND pro.postcode <= " . $arr[1] . " ) ";
        }
        if ($form_data['surround_suburb'] == 1) {
            $where_ar[] = "(pro.postcode = '" . $_postcode . "' $extra_where_str)";
        } else {
            $where_ar[] = "pro.postcode = '" . $_postcode . "'";
        }
    }
    if (isset($form_data['country']) && $form_data['country'] > 0) {
        $_country_id = (int)preg_replace('#[^0-9]#', '', $property_cls->escape($form_data['country']));
        $where_ar[] = "pro.country = " . $_country_id;
    }
    $pro_kind_ar = PEO_getKindId();
    if (isset($form_data['bedroom']) && $form_data['bedroom'] > 0) {
        $_bedroom_val = (int)preg_replace('#[^0-9]#', '', $form_data['bedroom']);
        $where_ar[] = "pro.bedroom = " . $_bedroom_val;
        $where_ar[] = "pro.kind = " . $pro_kind_ar['residential'];
        $where_ar[] = "pro.kind = " . $pro_kind_ar['residential'];
    }
    if (isset($form_data['bathroom']) && $form_data['bathroom'] > 0) {
        $_bathroom_val = (int)preg_replace('#[^0-9]#', '', $form_data['bathroom']);
        $where_ar[] = "pro.bathroom = " . $_bathroom_val;
        $where_ar[] = "pro.kind = " . $pro_kind_ar['residential'];
    }
    $wh_price = "(SELECT CASE
                        WHEN (  auction_sale != " . $auction_sale_ar['private_sale'] . " AND isnull(max(bid.price))
                                AND (
                                     (pro.confirm_sold = " . Property::SOLD_UNKNOWN . " AND date(pro.start_time) > '" . date('Y-m-d H:i:s') . "')
                                    OR
                                     (pro.confirm_sold = " . Property::SOLD_COMPLETE . " AND date(pro.sold_time) < date(pro.start_time))
                                    )
                              ) THEN
                                 (SELECT ((pro_term.value*110)/100)
                                 FROM " . $property_cls->getTable('property_term') . " AS pro_term
                                 LEFT JOIN " . $property_cls->getTable('auction_terms') . " AS term ON pro_term.auction_term_id = term.auction_term_id
                                 WHERE term.code = 'reserve' AND pro.property_id = pro_term.property_id)

                        WHEN (  auction_sale != " . $auction_sale_ar['private_sale'] . " AND isnull(max(bid.price))
                                AND (
                                        (date(pro.start_time) <= '" . date('Y-m-d H:i:s') . "' AND " . Property::SOLD_UNKNOWN . ")
                                    OR
                                        (date(pro.start_time) < date(pro.sold_time) AND " . Property::SOLD_COMPLETE . ")
                                    )
                             ) THEN
                                 (SELECT pro_term.value
                                 FROM " . $property_cls->getTable('property_term') . " AS pro_term
                                 LEFT JOIN " . $property_cls->getTable('auction_terms') . " AS term ON pro_term.auction_term_id = term.auction_term_id
                                 WHERE term.code = 'auction_start_price' AND pro.property_id = pro_term.property_id)

                        WHEN auction_sale = " . $auction_sale_ar['private_sale'] . " AND pro.price != 0 THEN pro.price
                        WHEN auction_sale = " . $auction_sale_ar['private_sale'] . " AND pro.price = 0 AND pro.price_on_application != 0 THEN pro.price_on_application
                        ELSE max(bid.price)
                        END
                        FROM bids AS bid WHERE bid.property_id = pro.property_id) + 0";
    if ($form_data['minprice'] > 0 || $form_data['maxprice'] > 0) {
        $_minprice = (int)preg_replace('#[^0-9]#', '', $form_data['minprice']);
        $_maxprice = (int)preg_replace('#[^0-9]#', '', $form_data['maxprice']);
        if ($_maxprice == 0 && $_minprice == 0) {
        } else {
            if ($_maxprice == 0) {
                $where_ar[] = $wh_price . " >= " . $_minprice;
            } else {
                $where_ar[] = $wh_price . " >= " . $_minprice . " AND " . $wh_price . " <= " . $_maxprice;
            }
        }
    }
    if (isset($form_data['unit']) && $form_data['unit'] != 0 && strlen($form_data['unit']) > 0) {
        $unit = $property_cls->getRow('SELECT * FROM ' . $property_cls->getTable('property_entity_option') . '
                                                WHERE property_entity_option_id = ' . $form_data['unit'], true);
        $len_ = strlen($unit['title']);
        $len_ = $len_ - 1;
        $where_ar[] = " mid(land_size,length(land_size) - " . $len_ . ") = '" . $unit['title'] . "'";
    }
    if ($form_data['land_size_min'] > 0 || $form_data['land_size_max'] > 0) {
        $_min = (int)$form_data['land_size_min'];
        $_max = (int)$form_data['land_size_max'];
        if ($_max == 0) {
            $where_ar[] = " pro.land_size + 0 >= " . $_min;
        } else {
            $where_ar[] = " pro.land_size + 0 BETWEEN " . $_min . " AND " . $_max;
        }
    }
    if (isset($form_data['state_code']) && strlen($form_data['state_code']) > 0) {
        $where_ar[] = "pro.state = (SELECT region_id FROM " . $region_cls->getTable() . " WHERE code = '" . $form_data['state_code'] . "')";
    }
    //car-space
    if (isset($form_data['car_space']) and $form_data['car_space'] > 0) {
        $where_ar[] = 'pro.car_space = ' . $form_data['car_space'];
        $where_str[] = 'pro.parking = 1';
    }
    //car-port
    if (isset($form_data['car_port']) and $form_data['car_port'] > 0) {
        $where_ar[] = 'pro.car_port = ' . $form_data['car_port'];
        $where_str[] = 'pro.parking = 1';
    }
    //END
    /*$where_ar[] = '(SELECT agtype.title
                                       FROM '.$agent_cls->getTable('agent_type')." AS agtype
                                       WHERE agtype.agent_type_id = agt.type_id) != 'agent'";*/
    if ((isset($form_data['livability_rating']) && $form_data['livability_rating'] > 0) or
        (isset($form_data['green_rating']) && $form_data['green_rating'] > 0)
    ) {
        if (isset($form_data['livability_rating']) and $form_data['livability_rating'] > 0) {
            $_livability_rating = (int)preg_replace('#[^0-9]#', '', $form_data['livability_rating']);
            $where_ar[] = 'pro.livability_rating_mark >= ' . $_livability_rating;
        }
        if (isset($form_data['green_rating']) and $form_data['green_rating'] > 0) {
            $_green_rating = (int)preg_replace('#[^0-9]#', '', $form_data['green_rating']);
            $where_ar[] = 'pro.green_rating_mark >= ' . $_green_rating;
        }
    }
    /*NH EDIT*/
    include_once ROOTPATH . '/modules/emailalert/inc/emailalert.php';
    if (isset($form_data['auction_sale']) and strlen($form_data['auction_sale']) > 0) {
        $form_data['auction_sale'] = setAuctionSale($form_data['auction_sale']);
        switch ($form_data['auction_sale']) {
            case 'ebidda30':
                $where_ar[] = '(pro.auction_sale = ' . $auction_sale_ar['ebidda30'] . ' )';
//                     OR (pro.auction_sale = '.$auction_sale_ar['auction'].'
//                                          AND (SELECT agtype.title
//                                               FROM '.$agent_cls->getTable('agent_type').' AS agtype
//                                               WHERE agtype.agent_type_id = agt.type_id) != \'agent\'
//                                              )
                break;
            case 'sale':
                $where_ar[] = 'pro.auction_sale = ' . $auction_sale_ar['private_sale'];
                break;
            case 'ebiddar':
            case 'bid2stay':
                $where_ar[] = 'pro.auction_sale = ' . $auction_sale_ar[$form_data['auction_sale']];
                break;
            case 'agent-auction':
                $where_ar[] = 'pro.auction_sale = ' . $auction_sale_ar['auction'] . ' AND (SELECT agtype.title
                                           FROM ' . $agent_cls->getTable('agent_type') . ' AS agtype
                                           WHERE agtype.agent_type_id = agt.type_id) = \'agent\'';
                break;
            default:
                /*$where_ar[] = 'pro.auction_sale = '.$auction_sale_ar['auction'].' AND (SELECT agtype.title
                                           FROM '.$agent_cls->getTable('agent_type').' AS agtype
                                           WHERE agtype.agent_type_id = agt.type_id) != \'agent\'';*/
                $where_str .= ' AND (pro.auction_sale = ' . $auction_sale_ar['ebidda30'] .
                    ' OR (pro.auction_sale = ' . $auction_sale_ar['auction'] . '
                                          AND (SELECT agtype.title
                                               FROM ' . $agent_cls->getTable('agent_type') . ' AS agtype
                                               WHERE agtype.agent_type_id = agt.type_id) != \'agent\'
                                          )
                                     )';
                break;
        }
        //$where_ar[] = 'pro.auction_sale = '.$form_data['auction_sale'];
    }
    //for Prev, Next link
    if (count($where_ar) > 0) {
        unset($_SESSION['type_prev']);
        $where_str = ' AND ' . implode(' AND ', $where_ar);
        $_SESSION['where'] = 'search';
    }
    //for Prev, Next link search auction, sale auction in Chrome
    //$search = '';
    if (in_array($action, array('search-auction', 'search-sale', 'search-ebiddar', 'search-agent-auction', 'search-bid2stay'))) {
        switch ($action) {
            case 'search-auction':/*eBidda 30, auction of vendor, auction the block*/
                $where_str .= ' AND (pro.auction_sale = ' . $auction_sale_ar['ebidda30'] .
                    ' OR (pro.auction_sale = ' . $auction_sale_ar['auction'] . '
                                          AND (SELECT agtype.title
                                               FROM ' . $agent_cls->getTable('agent_type') . ' AS agtype
                                               WHERE agtype.agent_type_id = agt.type_id) != \'agent\'
                                          )
                                     )';
                $form_data['auction_sale'] = array('ebidda30', 'auction');
                break;
            case 'search-sale':
                $where_str .= ' AND pro.auction_sale = ' . $auction_sale_ar['private_sale'];
                $form_data['auction_sale'] = 'sale';
                break;
            case 'search-ebiddar':
            case 'search-bid2stay':
                $_actionAr = explode('-', $action);
                $where_str .= ' AND pro.auction_sale = ' . $auction_sale_ar[$_actionAr[1]];
                $form_data['auction_sale'] = $_actionAr[1];
                break;
            case 'search-agent-auction':
                $where_str .= ' AND pro.auction_sale = ' . $auction_sale_ar['auction'] . ' AND (SELECT agtype.title
                                           FROM ' . $agent_cls->getTable('agent_type') . ' AS agtype
                                           WHERE agtype.agent_type_id = agt.type_id) = \'agent\'';
                $form_data['auction_sale'] = 'agent-auction';
                break;
        }
    }
    /*OR (pro.auction_sale = '.$auction_sale_ar['auction'].'
                                 AND  pro.stop_bid = 1
                                 AND  pro.confirm_sold = 0
                                 AND datediff(\''.date('Y-m-d H:i:s').'\', pro.end_time) < 14+0)*/
    $where_str .= ' AND (IF (pro.confirm_sold = 1  AND datediff(\'' . date('Y-m-d H:i:s') . '\',pro.sold_time) < 14,1,0) = 1
                             OR (pro.confirm_sold = 0 AND pro.auction_sale = ' . $auction_sale_ar['private_sale'] . ')
                             OR (pro.auction_sale != ' . $auction_sale_ar['private_sale'] . ' AND pro.confirm_sold = 0))';
    $where_str .= ' AND IF (pro.auction_sale != ' . $auction_sale_ar['private_sale'] . '
                                                                AND (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\',0,pro_term.value)
                                                                     FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
                                                                     LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
                                                                        ON pro_term.auction_term_id = term.auction_term_id
                                                                     WHERE term.code = \'auction_start_price\'
                                                                        AND pro.property_id = pro_term.property_id )
                                                                AND  (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\',0,pro_term.value)
                                                                     FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
                                                                     LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
                                                                        ON pro_term.auction_term_id = term.auction_term_id
                                                                     WHERE term.code = \'reserve\'
                                                                        AND pro.property_id = pro_term.property_id )
                                                                AND  IF ((SELECT pro_term.value
                                                                     FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
                                                                     LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
                                                                        ON pro_term.auction_term_id = term.auction_term_id
                                                                     WHERE term.code = \'auction_start_price\'
                                                                        AND pro.property_id = pro_term.property_id )
                                                                     >
                                                                     (SELECT pro_term.value
                                                                     FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
                                                                     LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
                                                                        ON pro_term.auction_term_id = term.auction_term_id
                                                                     WHERE term.code = \'reserve\'
                                                                        AND pro.property_id = pro_term.property_id ),0,1)

                                                                = 0, 0, 1) = 1';
    return $where_str;
}

//get Query from Form Data
function getSearchQueryByFormData1(&$form_data = array(), &$action, $where_str_surround)
{
    $form_data['checked'] = 'true';
    //print_r_pre($form_data);die();
    global $region_cls, $property_cls, $agent_cls;
    $where_str = '';
    $where_ar = array();
    foreach ($form_data as $key => $data) {
        if ($data == '') {
            unset($form_data[$key]);
        }
    }
    $auction_sale_ar = PEO_getAuctionSale();
    if (isset($form_data['property_type']) && ($form_data['property_type'] > 0)) {
        $where_ar[] = "pro.`type` = " . $form_data['property_type'];
        $kind_ar = PEO_getKindByType($form_data['property_type']);
        if (is_array($kind_ar) and count($kind_ar) > 0) {
            if ($kind_ar['code'] == 'property_type') {
                $where_ar[] = "pro.`kind` = 2";
            }
            if ($kind_ar['code'] == 'property_type_commercial') {
                $where_ar[] = "pro.`kind` = 1";
            }
        }
    }
    if (isset($form_data['property_kind']) && ($form_data['property_kind'] > 0)) {
        $where_ar[] = "pro.`kind` = " . $form_data['property_kind'];
        $type_options = PEO_getTypeByKind($form_data['property_kind']);
        $type_ = "(";
        if (count($type_options) > 0 and is_array($type_options)) {
            foreach ($type_options as $key => $value) {
                $type_ .= $key . ',';
            }
        }
        $type_ .= ")";
        $type_ = str_replace(",)", ")", $type_);
        $where_ar[] = "pro.`type` IN " . $type_;
        if ($form_data['property_kind'] == 1) {
            unset($form_data['bedroom'], $form_data['bathroom']);
        }
    }
    if (isset($form_data['parking']) && ($form_data['parking'] >= 0)) { // it have  options (Any => -1 ,No=> 0, Yes => 1)
        $where_ar[] = "pro.`parking` = " . $form_data['parking'];
    }
    if (isset($form_data['region']) && strlen($form_data['region']) > 0) {
        if (isset($form_data['surround_suburb']) && $form_data['surround_suburb'] == 1) {
            $str = "( concat(pro.suburb,' ',
                            (SELECT reg_s1.code
                                FROM " . $region_cls->getTable() . " AS reg_s1
                                WHERE reg_s1.region_id = pro.state),' ',
                            pro.postcode ) LIKE '%" . $property_cls->escape($form_data['region']) . "%'
                   OR pro.property_id LIKE '%" . $property_cls->escape($form_data['region']) . "%' $where_str_surround)";
        } else {
            $str = "( concat(pro.suburb,' ',
                            (SELECT reg_s1.code
                                FROM " . $region_cls->getTable() . " AS reg_s1
                                WHERE reg_s1.region_id = pro.state),' ',
                            pro.postcode ) LIKE '%" . $property_cls->escape($form_data['region']) . "%'
                   OR pro.property_id LIKE '%" . $property_cls->escape($form_data['region']) . "%' )";
        }
        $where_ar[] = $str;
    }
    if (isset($form_data['address']) && strlen($form_data['address']) > 0) {
        $where_ar[] = "pro.address LIKE '%" . $form_data['address'] . "%'";
    }
    if (isset($form_data['property_id']) && strlen($form_data['property_id']) > 0) {
        $form_data['region'] = $form_data['property_id'];
        $where_ar[] = "pro.property_id LIKE '%" . $form_data['property_id'] . "%'";
    }
    if (isset($form_data['suburb']) && strlen($form_data['suburb']) > 0) {
        $where_ar[] = "pro.suburb LIKE '%" . $property_cls->escape($form_data['suburb']) . "%'";
    }
    if (isset($form_data['state']) && $form_data['state'] > 0) {
        $_state_id = preg_replace('#[^0-9]#', '', $property_cls->escape($form_data['state']));
        $where_ar[] = "pro.state = " . $_state_id;
    }
    if (isset($form_data['postcode']) && strlen($form_data['postcode']) > 0) {
        $_postcode = preg_replace('#[^0-9]#', '', $property_cls->escape($form_data['postcode']));
        $AUST_postcode_arr = array(
            array(1000, 1999),//NSW
            array(2000, 2599),
            array(2619, 2898),
            array(2921, 2999),
            array(200, 299), //ACT
            array(2600, 2618),
            array(2900, 2920),
            array(3000, 3999),//VIC
            array(8000, 8999),
            array(4000, 4999),//QLD
            array(9000, 9999),
            array(5000, 5799),//SA
            array(5800, 5999),
            array(6000, 6797),//WA
            array(6800, 6999),
            array(7000, 7799),//TAS
            array(7800, 7999),
            //array(0800, 0899),//TAS
            //array(0900, 0999),
        );
        $in_range_arr = array();
        foreach ($AUST_postcode_arr as $key => $val) {
            if ((int)$_postcode >= $val[0] && (int)$_postcode <= $val[1]) {
                if (!in_array($val, $in_range_arr)) {
                    array_push($in_range_arr, $val);
                }
            }
        }
        $extra_where_str = "";
        foreach ($in_range_arr as $key => $arr) {
            $extra_where_str .= " OR (pro.postcode >= " . $arr[0] . " AND pro.postcode <= " . $arr[1] . " ) ";
        }
        if ($form_data['surround_suburb'] == 1) {
            $where_ar[] = "(pro.postcode = '" . $_postcode . "' $extra_where_str)";
        } else {
            $where_ar[] = "pro.postcode = '" . $_postcode . "'";
        }
    }
    if (isset($form_data['country']) && $form_data['country'] > 0) {
        $_country_id = (int)preg_replace('#[^0-9]#', '', $property_cls->escape($form_data['country']));
        $where_ar[] = "pro.country = " . $_country_id;
    }
    $pro_kind_ar = PEO_getKindId();
    if (isset($form_data['bedroom']) && $form_data['bedroom'] > 0) {
        $_bedroom_val = (int)preg_replace('#[^0-9]#', '', $form_data['bedroom']);
        $where_ar[] = "pro.bedroom = " . $_bedroom_val;
        $where_ar[] = "pro.kind = " . $pro_kind_ar['residential'];
        $where_ar[] = "pro.kind = " . $pro_kind_ar['residential'];
    }
    if (isset($form_data['bathroom']) && $form_data['bathroom'] > 0) {
        $_bathroom_val = (int)preg_replace('#[^0-9]#', '', $form_data['bathroom']);
        $where_ar[] = "pro.bathroom = " . $_bathroom_val;
        $where_ar[] = "pro.kind = " . $pro_kind_ar['residential'];
    }
    $wh_price = "(SELECT CASE
                        WHEN (  auction_sale != " . $auction_sale_ar['private_sale'] . " AND isnull(max(bid.price))
                                AND (
                                     (pro.confirm_sold = " . Property::SOLD_UNKNOWN . " AND date(pro.start_time) > '" . date('Y-m-d H:i:s') . "')
                                    OR
                                     (pro.confirm_sold = " . Property::SOLD_COMPLETE . " AND date(pro.sold_time) < date(pro.start_time))
                                    )
                              ) THEN
                                 (SELECT ((pro_term.value*110)/100)
                                 FROM " . $property_cls->getTable('property_term') . " AS pro_term
                                 LEFT JOIN " . $property_cls->getTable('auction_terms') . " AS term ON pro_term.auction_term_id = term.auction_term_id
                                 WHERE term.code = 'reserve' AND pro.property_id = pro_term.property_id)

                        WHEN (  auction_sale != " . $auction_sale_ar['private_sale'] . " AND isnull(max(bid.price))
                                AND (
                                        (date(pro.start_time) <= '" . date('Y-m-d H:i:s') . "' AND " . Property::SOLD_UNKNOWN . ")
                                    OR
                                        (date(pro.start_time) < date(pro.sold_time) AND " . Property::SOLD_COMPLETE . ")
                                    )
                             ) THEN
                                 (SELECT pro_term.value
                                 FROM " . $property_cls->getTable('property_term') . " AS pro_term
                                 LEFT JOIN " . $property_cls->getTable('auction_terms') . " AS term ON pro_term.auction_term_id = term.auction_term_id
                                 WHERE term.code = 'auction_start_price' AND pro.property_id = pro_term.property_id)

                        WHEN auction_sale = " . $auction_sale_ar['private_sale'] . " AND pro.price != 0 THEN pro.price
                        WHEN auction_sale = " . $auction_sale_ar['private_sale'] . " AND pro.price = 0 AND pro.price_on_application != 0 THEN pro.price_on_application
                        ELSE max(bid.price)
                        END
                        FROM bids AS bid WHERE bid.property_id = pro.property_id) + 0";
    if ($form_data['minprice'] > 0 || $form_data['maxprice'] > 0) {
        $_minprice = (int)preg_replace('#[^0-9]#', '', $form_data['minprice']);
        $_maxprice = (int)preg_replace('#[^0-9]#', '', $form_data['maxprice']);
        if ($_maxprice == 0 && $_minprice == 0) {
        } else {
            if ($_maxprice == 0) {
                $where_ar[] = $wh_price . " >= " . $_minprice;
            } else {
                $where_ar[] = $wh_price . " >= " . $_minprice . " AND " . $wh_price . " <= " . $_maxprice;
            }
        }
    }
    if (isset($form_data['unit']) && $form_data['unit'] != 0 && strlen($form_data['unit']) > 0) {
        $unit = $property_cls->getRow('SELECT * FROM ' . $property_cls->getTable('property_entity_option') . '
                                                WHERE property_entity_option_id = ' . $form_data['unit'], true);
        $len_ = strlen($unit['title']);
        $len_ = $len_ - 1;
        $where_ar[] = " mid(land_size,length(land_size) - " . $len_ . ") = '" . $unit['title'] . "'";
    }
    if ($form_data['land_size_min'] > 0 || $form_data['land_size_max'] > 0) {
        $_min = (int)$form_data['land_size_min'];
        $_max = (int)$form_data['land_size_max'];
        if ($_max == 0) {
            $where_ar[] = " pro.land_size + 0 >= " . $_min;
        } else {
            $where_ar[] = " pro.land_size + 0 BETWEEN " . $_min . " AND " . $_max;
        }
    }
    if (isset($form_data['state_code']) && strlen($form_data['state_code']) > 0) {
        $where_ar[] = "pro.state = (SELECT region_id FROM " . $region_cls->getTable() . " WHERE code = '" . $form_data['state_code'] . "')";
    }
    //car-space
    if (isset($form_data['car_space']) and $form_data['car_space'] > 0) {
        $where_ar[] = 'pro.car_space = ' . $form_data['car_space'];
        $where_str[] = 'pro.parking = 1';
    }
    //car-port
    if (isset($form_data['car_port']) and $form_data['car_port'] > 0) {
        $where_ar[] = 'pro.car_port = ' . $form_data['car_port'];
        $where_str[] = 'pro.parking = 1';
    }
    //END
    /*$where_ar[] = '(SELECT agtype.title
                                       FROM '.$agent_cls->getTable('agent_type')." AS agtype
                                       WHERE agtype.agent_type_id = agt.type_id) != 'agent'";*/
    if ((isset($form_data['livability_rating']) && $form_data['livability_rating'] > 0) or
        (isset($form_data['green_rating']) && $form_data['green_rating'] > 0)
    ) {
        if (isset($form_data['livability_rating']) and $form_data['livability_rating'] > 0) {
            $_livability_rating = (int)preg_replace('#[^0-9]#', '', $form_data['livability_rating']);
            $where_ar[] = 'pro.livability_rating_mark >= ' . $_livability_rating;
        }
        if (isset($form_data['green_rating']) and $form_data['green_rating'] > 0) {
            $_green_rating = (int)preg_replace('#[^0-9]#', '', $form_data['green_rating']);
            $where_ar[] = 'pro.green_rating_mark >= ' . $_green_rating;
        }
    }
    /*NH EDIT*/
    include_once ROOTPATH . '/modules/emailalert/inc/emailalert.php';
    if (isset($form_data['auction_sale']) and strlen($form_data['auction_sale']) > 0) {
        $form_data['auction_sale'] = setAuctionSale($form_data['auction_sale']);
        switch ($form_data['auction_sale']) {
            case 'ebidda30':
                $where_ar[] = '(pro.auction_sale = ' . $auction_sale_ar['ebidda30'] . ' )';
//                     OR (pro.auction_sale = '.$auction_sale_ar['auction'].'
//                                          AND (SELECT agtype.title
//                                               FROM '.$agent_cls->getTable('agent_type').' AS agtype
//                                               WHERE agtype.agent_type_id = agt.type_id) != \'agent\'
//                                              )
                break;
            case 'sale':
                $where_ar[] = 'pro.auction_sale = ' . $auction_sale_ar['private_sale'];
                break;
            case 'ebiddar':
            case 'bid2stay':
                $where_ar[] = 'pro.auction_sale = ' . $auction_sale_ar[$form_data['auction_sale']];
                break;
            case 'agent-auction':
                $where_ar[] = 'pro.auction_sale = ' . $auction_sale_ar['auction'] . ' AND (SELECT agtype.title
                                           FROM ' . $agent_cls->getTable('agent_type') . ' AS agtype
                                           WHERE agtype.agent_type_id = agt.type_id) = \'agent\'';
                break;
            default:
                /*$where_ar[] = 'pro.auction_sale = '.$auction_sale_ar['auction'].' AND (SELECT agtype.title
                                           FROM '.$agent_cls->getTable('agent_type').' AS agtype
                                           WHERE agtype.agent_type_id = agt.type_id) != \'agent\'';*/
                $where_str .= ' AND (pro.auction_sale = ' . $auction_sale_ar['ebidda30'] .
                    ' OR (pro.auction_sale = ' . $auction_sale_ar['auction'] . '
                                          AND (SELECT agtype.title
                                               FROM ' . $agent_cls->getTable('agent_type') . ' AS agtype
                                               WHERE agtype.agent_type_id = agt.type_id) != \'agent\'
                                          )
                                     )';
                break;
        }
        //$where_ar[] = 'pro.auction_sale = '.$form_data['auction_sale'];
    }
    //for Prev, Next link
    if (count($where_ar) > 0) {
        unset($_SESSION['type_prev']);
        $where_str = ' AND ' . implode(' AND ', $where_ar);
        $_SESSION['where'] = 'search';
    }
    //for Prev, Next link search auction, sale auction in Chrome
    //$search = '';
    if (in_array($action, array('search-auction', 'search-sale', 'search-ebiddar', 'search-agent-auction', 'search-bid2stay'))) {
        switch ($action) {
            case 'search-auction':/*eBidda 30, auction of vendor, auction the block*/
                $where_str .= ' AND (pro.auction_sale = ' . $auction_sale_ar['ebidda30'] .
                    ' OR (pro.auction_sale = ' . $auction_sale_ar['auction'] . '
                                          AND (SELECT agtype.title
                                               FROM ' . $agent_cls->getTable('agent_type') . ' AS agtype
                                               WHERE agtype.agent_type_id = agt.type_id) != \'agent\'
                                          )
                                     )';
                $form_data['auction_sale'] = array('ebidda30', 'auction');
                break;
            case 'search-sale':
                $where_str .= ' AND pro.auction_sale = ' . $auction_sale_ar['private_sale'];
                $form_data['auction_sale'] = 'sale';
                break;
            case 'search-ebiddar':
            case 'search-bid2stay':
                $_actionAr = explode('-', $action);
                $where_str .= ' AND pro.auction_sale = ' . $auction_sale_ar[$_actionAr[1]];
                $form_data['auction_sale'] = $_actionAr[1];
                break;
            case 'search-agent-auction':
                $where_str .= ' AND pro.auction_sale = ' . $auction_sale_ar['auction'] . ' AND (SELECT agtype.title
                                           FROM ' . $agent_cls->getTable('agent_type') . ' AS agtype
                                           WHERE agtype.agent_type_id = agt.type_id) = \'agent\'';
                $form_data['auction_sale'] = 'agent-auction';
                break;
        }
    }
    /*OR (pro.auction_sale = '.$auction_sale_ar['auction'].'
                                 AND  pro.stop_bid = 1
                                 AND  pro.confirm_sold = 0
                                 AND datediff(\''.date('Y-m-d H:i:s').'\', pro.end_time) < 14+0)*/
    $where_str .= ' AND (IF (pro.confirm_sold = 1  AND datediff(\'' . date('Y-m-d H:i:s') . '\',pro.sold_time) < 14,1,0) = 1
                             OR (pro.confirm_sold = 0 AND pro.auction_sale = ' . $auction_sale_ar['private_sale'] . ')
                             OR (pro.auction_sale != ' . $auction_sale_ar['private_sale'] . ' AND pro.confirm_sold = 0))';
    $where_str .= ' AND IF (pro.auction_sale != ' . $auction_sale_ar['private_sale'] . '
                                                                AND (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\',0,pro_term.value)
                                                                     FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
                                                                     LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
                                                                        ON pro_term.auction_term_id = term.auction_term_id
                                                                     WHERE term.code = \'auction_start_price\'
                                                                        AND pro.property_id = pro_term.property_id )
                                                                AND  (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\',0,pro_term.value)
                                                                     FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
                                                                     LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
                                                                        ON pro_term.auction_term_id = term.auction_term_id
                                                                     WHERE term.code = \'reserve\'
                                                                        AND pro.property_id = pro_term.property_id )
                                                                AND  IF ((SELECT pro_term.value
                                                                     FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
                                                                     LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
                                                                        ON pro_term.auction_term_id = term.auction_term_id
                                                                     WHERE term.code = \'auction_start_price\'
                                                                        AND pro.property_id = pro_term.property_id )
                                                                     >
                                                                     (SELECT pro_term.value
                                                                     FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
                                                                     LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
                                                                        ON pro_term.auction_term_id = term.auction_term_id
                                                                     WHERE term.code = \'reserve\'
                                                                        AND pro.property_id = pro_term.property_id ),0,1)

                                                                = 0, 0, 1) = 1';
    return $where_str;
}

/**
 * @ function : Property_getListForSitemap
 * @ argument :
 * @ output :
 **/
function Property_getListForSitemap()
{
    global $smarty, $property_cls, $region_cls, $property_entity_option_cls, $pag_cls, $config_cls, $agent_cls, $bids_first_cls, $agent_payment_cls;
    $date_lock = (int)$config_cls->getKey('date_lock');
    $order_ar = ' ORDER BY pro.end_time';
    $time_str = " AND
						   IF((SELECT title
						   	   FROM " . $agent_cls->getTable('agent_type') . " AS at
							   WHERE agt.type_id = at.agent_type_id) IN ('theblock'),
							  '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,
							  DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY),pro.date_to_reg_bid),1) = 1
						   ";
    //HIDE AGENT's PROPERTIES DIDN'T PAYMENT
    $time_str .= " AND IF((SELECT title
							   FROM " . $agent_cls->getTable('agent_type') . " AS at
                               WHERE agt.type_id = at.agent_type_id) IN ('agent')
                                   ,(SELECT ap.payment_id
								     FROM " . $agent_payment_cls->getTable() . " AS ap
                                     WHERE ap.agent_id = IF(agt.parent_id = '', agt.agent_id, agt.parent_id)
                                           AND ap.date_from <= '" . date('Y-m-d H:i:s') . "'
										   AND ap.date_to >= '" . date('Y-m-d H:i:s') . "'
                                     ) != ''
                                   ,1)";
    /*IBB-1022:Hide The Block properties from view in the Online Auctions section: NHUNG*/
    $hide = ' AND (SELECT agtype.title
                       FROM ' . $agent_cls->getTable('agent_type') . " AS agtype
                       WHERE agtype.agent_type_id = agt.type_id) != 'theblock'";
    $rows = $property_cls->getRows("SELECT SQL_CALC_FOUND_ROWS pro.property_id,
													pro.address,
													pro.suburb,
													pro.state,
													pro.postcode,

													(SELECT reg1.code
													FROM " . $region_cls->getTable() . " AS reg1
													WHERE reg1.region_id = pro.state
													) AS state_code,

													(SELECT reg2.name
													FROM " . $region_cls->getTable() . " AS reg2
													WHERE reg2.region_id = pro.country
													) AS country_name,

													(SELECT pro_opt4.code
													FROM " . $property_entity_option_cls->getTable() . " AS pro_opt4
													WHERE pro_opt4.property_entity_option_id = pro.auction_sale
													) AS auctionsale_code

												FROM " . $property_cls->getTable() . " AS pro
												INNER JOIN " . $property_cls->getTable('agent') . " AS agt ON pro.agent_id = agt.agent_id
												WHERE   pro.active = 1
														AND pro.agent_active = 1
														AND pro.pay_status = " . Property::CAN_SHOW
        . $hide
        . $time_str
        . 'ORDER BY pro.end_time', true);
    $data = array();
    $auction_sale_ar = PEO_getAuctionSale();
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $key => $row) {
            $data[$key] = $row;
            $link_ar = array('module' => 'property', 'action' => 'view-sale-detail', 'id' => $row['property_id']);
            if ($row['auction_sale'] == $auction_sale_ar['auction']) {
                $dt1 = new DateTime($row['start_time']);
                $current = new DateTime(date('Y-m-d H:i:s'));
                if ($dt1 > $current || ($row['confirm_sold'] == Property::SOLD_COMPLETE && $row['sold_time'] < $row['start_time'])) {
                    $link_ar['action'] = 'view-forthcoming-detail';
                } else {
                    $link_ar['action'] = 'view-auction-detail';
                }// End Auction
            }
            //$data[$key]['detail_link'] = shortUrl($link_ar + array('data' => $data[$key]),
            //                                      (PE_isTheBlock($row['property_id'],'agent')?Agent_getAgent($row['property_id']):array())
            $rowaddress = str_replace(' ', '-', $row['address']);
            $rowaddress = str_replace(',', '', $rowaddress);
            $rowaddress = (substr($rowaddress, -1) == '-') ? substr($rowaddress, 0, -1) : $rowaddress;
            $rowsuburb = str_replace(' ', '-', $row['suburb']);
            $data[$key]['detail_link'] = "/" . $row['state_code'] . "/for-sale/$rowsuburb/$rowaddress/id-" . $row['property_id'];
            $dt1 = new DateTime($row['end_time']);
        }
    }
    return $data;
}

/**
 * @ function : PE_getBidPrice
 * @ argument : property_id
 * @ output : string
 **/
function PE_getBidPrice($property_id)
{
    global $property_cls;
    $auction_sale_ar = PEO_getAuctionSale();
    $row = $property_cls->getRow('SELECT
                                      (SELECT CASE
												WHEN auction_sale != ' . $auction_sale_ar['private_sale'] . ' AND pro.start_time != \'0000-00-00 00:00:00\' AND( pro.start_time > \'' . date('Y-m-d H:i:s') . '\' OR isnull(max(bid.price)) ) THEN
																(SELECT pro_term.value
																 FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
																 LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
																 ON pro_term.auction_term_id = term.auction_term_id
																 WHERE term.code = \'auction_start_price\' AND pro.property_id = pro_term.property_id
																 )

															WHEN auction_sale = ' . $auction_sale_ar['private_sale'] . ' OR (auction_sale != ' . $auction_sale_ar['private_sale'] . ' AND pro.start_time = \'0000-00-00 00:00:00\') THEN pro.price
															ELSE max(bid.price)
															END
													FROM ' . $property_cls->getTable('bids') . ' AS bid
													WHERE bid.property_id = pro.property_id
													) AS price
									  FROM ' . $property_cls->getTable() . ' AS pro
									  WHERE property_id = ' . $property_id, true);
    /*$row = $property_cls->getRow('SELECT (SELECT CASE
														WHEN auction_sale = '.$auction_sale_ar['auction'].' AND (
															pro.start_time > \''.date('Y-m-d H:i:s').'\' OR isnull(max(bid.price)) OR isnull(max(bid_his.price)) )
														THEN
															(SELECT pro_term.value
															FROM '.$property_cls->getTable('property_term').' AS pro_term
															LEFT JOIN '.$property_cls->getTable('auction_terms').' AS term
															ON pro_term.auction_term_id = term.auction_term_id
															WHERE term.code = \'auction_start_price\' AND pro.property_id = pro_term.property_id
															)
														WHEN auction_sale = '.$auction_sale_ar['private_sale'].'
														THEN pro.price
														ELSE max(bid.price)
													END
					    					FROM '.$property_cls->getTable('bids').' AS bid,'.$property_cls->getTable('bids_transition_history').' AS bid_his
											WHERE bid.property_id = pro.property_id OR bid_his.property_id = pro.property_id
											) AS price
									FROM '.$property_cls->getTable().' AS pro
									WHERE pro.property_id = '.$property_id, true);
									*/
    if (is_array($row) and count($row) > 0) {
        return $row['price'];
    }
    return '';
}

/**
 * @ function : PK_getPackage
 * @ argument : property_id
 * @ output : string
 **/
function PK_getPackageTpl($property_id = 0, $tpl = false, $auction_type = null, $of_agent = null)
{
    global $property_cls, $package_cls, $smarty;
    $rs = '';
    $auction_sale_ar = PEO_getAuctionSale();
    $auction_type = $auction_type == null ? $auction_sale_ar['auction'] : $auction_type;
    if ($tpl && $property_id == 0) {
        $str_query = strlen($of_agent) > 0 && $of_agent ? ' AND for_agent = 1' : ' AND for_agent = 0';
    } else {
        $str_query = PE_isTheBlock($property_id, 'agent') || $_SESSION['agent']['type'] == 'agent' ? ' AND for_agent = 1' : ' AND for_agent = 0';
    }
    $rows = $package_cls->getRows('property_type = ' . $auction_type . ' AND package_type = \'property\' AND active = 1 AND can_show = 1' . $str_query . ' ORDER BY `order` ASC');
    if (is_array($rows) && count($rows) > 0) {
        foreach ($rows as $key => $row) {
            $rows[$key]['price'] = '$' . number_format($row['price'], 0, ',', '');
        }
        if ($property_id > 0) {
            $row = $property_cls->getRow('property_id = ' . $property_id);
            if (is_array($row) && count($row) > 0) {
                $smarty->assign('package_id', $row['package_id']);
                if ($row['pay_status'] == Property::PAY_COMPLETE and $row['auction_sale'] == $auction_sale_ar['auction']) {
                    $pay_status = 'complete';
                } else {
                    $pay_status = 'not_complete';
                }
                $smarty->assign('pay_status', $pay_status);
            }
        }
        $smarty->assign('package_data', $rows);
        $smarty->assign('admin', $tpl);
        //$rs = $smarty->fetch(ROOTPATH.'/modules/property/templates/property.packages.item.tpl');
        $rs = $smarty->fetch(ROOTPATH . '/modules/property/templates/property.packages.info.tpl');
    }
    return $rs;
}

/**
 * @ function : PE_getPayStatus
 * @ argument :  property_id
 * @ output : complete, pending, unknown
 **/
function PE_getPayStatus($property_id = 0)
{
    global $property_cls;
    if ($property_id > 0) {
        $row = $property_cls->getCRow(array('pay_status'), 'property_id=' . $property_id);
        if (is_array($row) and count($row) > 0) {
            return PE_PayStatus2str((int)$row['pay_status']);
        }
    }
    return false;
}

/**
 * @ function : PE_getSoldStatus
 * @ argument :  property_id
 * @ output : true, false
 **/
function PE_getSoldStatus($property_id = 0)
{
    global $property_cls;
    if ($property_id > 0) {
        $row = $property_cls->getCRow(array('confirm_sold'), 'property_id=' . $property_id);
        if (is_array($row) and count($row) > 0) {
            if ($row['confirm_sold'] == Property::SOLD_UNKNOWN) {
                return false;
            } else {
                return true;
            }
        }
    }
    return false;
}

/**
 * @ function : PK_getAttribute
 * @ argument : field, property_id
 * @ output : array
 **/
function PK_getAttribute($field, $property_id = 0)
{
    global $property_cls, $package_cls;
    $rs = '';
    $query = (PE_isTheBlock($property_id, 'agent') || $_SESSION['agent']['type'] == 'agent') ? ' AND for_agent = 1' : ' AND for_agent = 0';
    $row = $property_cls->getRow('SELECT pk.' . $field . '
									  FROM ' . $property_cls->getTable() . ' AS p, ' . $package_cls->getTable() . ' AS pk
									  WHERE p.package_id = pk.package_id AND p.property_id = ' . $property_id . $query, true);
    if (is_array($row) && count($row) > 0) {
        if (strlen(trim($row[$field])) > 0) {
            return $row[$field];
        }
    }
    return $rs;
}

/**
 * @ function : PK_isBindProperty
 * @ argument : property_id
 * @ output : bool
 **/
function PK_isBindProperty_old($property_id = 0)
{
    global $property_cls, $package_cls;
    $row = $property_cls->getRow('SELECT p.property_id
									  FROM ' . $property_cls->getTable() . ' AS p, ' . $package_cls->getTable() . ' AS pk
									  WHERE p.package_id = pk.package_id AND p.property_id = ' . $property_id, true);
    if (is_array($row) && count($row) > 0) {
        return true;
    }
    return false;
}

function PK_isBindProperty($property_id = 0)
{
    global $property_cls, $package_property_cls;
    $row = $property_cls->getRow('SELECT p.property_id
									  FROM ' . $property_cls->getTable() . ' AS p, ' . $package_property_cls->getTable() . ' AS pk
									  WHERE p.package_id = pk.package_id AND p.property_id = ' . $property_id, true);
    if (is_array($row) && count($row) > 0) {
        return true;
    }
    return false;
}

function PE_getTotal($where = '')
{
    global $property_cls;
    $row = $property_cls->getRow('SELECT COUNT(*) AS sum FROM ' . $property_cls->getTable() . ' WHERE 1 AND ' . $where, true);
    return $row['sum'];
}

/**
 * @ function : PE_getTypeProperty
 * @ param : property_id
 * @ output : live,forth,sale,
 * --------
 **/
function PE_getTypeProperty($property_id = 0)
{
    global $property_cls;
    $type = 'unknown';
    if ($property_id <= 0) {
        return $type;
    }
    $row = $property_cls->getCRow(array('auction_sale', 'pay_status', 'start_time', 'end_time', 'stop_bid', 'confirm_sold'), "property_id='" . $property_id . "'");
    if (is_array($row) or count($row) > 0) {
        $auction_sale_ar = PEO_getAuctionSale();
        $type = 'unknown';
        if ($row['auction_sale'] != $auction_sale_ar['private_sale']) {
            if ($row['pay_status'] == Property::PAY_COMPLETE) {
                /*if($row['start_time'] == '5000-05-05 00:00:00'){
                    $type = 'no_auction_scheduled';
                    return $type;
                }*/
                if ($row['start_time'] < date('Y-m-d H:i:s')) {
                    if ($row['end_time'] < date('Y-m-d H:i:s') or $row['stop_bid'] == 1) {
                        $type = 'stop_auction';
                    } else {
                        $type = 'live_auction';
                    }
                } else {
                    $type = 'forth_auction';
                }
            } else {
                $type = 'not_payment';
            }
        } else {
            $type = 'sale';
        }
    }
    return $type;
}

function PE_Get_type_property($property_id = 0)
{
    return PE_getTypeProperty($property_id);
}

function PE_getVendor($property_id)
{
    global $property_cls, $agent_cls;
    $data = array();
    if ($property_id > 0) {
        $row = $property_cls->getRow('property_id=' . $property_id);
        if (is_array($row) and count($row) > 0) {
            $row_agent = $property_cls->getRow('SELECT * FROM ' . $agent_cls->getTable() . ' WHERE agent_id=' . $row['agent_id'], true);
            if (is_array($row_agent) and count($row_agent) > 0) {
                return $row_agent;
            }
        }
    }
    return $data;
}

/*get ROW of agent by Agent_id OR property_id*/
function PE_getAgent($agent_id, $property_id = 0)
{
    include_once ROOTPATH . '/modules/general/inc/regions.class.php';
    global $property_cls, $agent_cls, $region_cls;
    if (!isset($region_cls) or !($region_cls instanceof Regions)) {
        $region_cls = new Regions();
    }
    if ($property_id > 0) {
        $pro_row = $property_cls->getCRow(array('agent_id'), 'property_id = ' . $property_id);
        if (count($pro_row) > 0 and is_array($pro_row)) {
            $agent_id = $pro_row['agent_id'];
        }
    }
    $data = array();
    if ($agent_id > 0 AND isset($agent_id)) {
        $row_agent = $property_cls->getRow('SELECT ag.*,
                                                       agt.title,
                                                       p.postal_address,
                                                       p.postal_suburb,
                                                       p.postal_postcode,
                                                       p.postal_other_state,

                                                       (SELECT reg1.code
                                                        FROM ' . $region_cls->getTable() . ' AS reg1
                                                        WHERE reg1.region_id = ag.state
                                                        ) AS state_code,
                                                        (SELECT reg3.name
                                                        FROM ' . $region_cls->getTable() . ' AS reg3
                                                        WHERE reg3.region_id = ag.country
                                                        ) AS country_name,

                                                       (SELECT reg1.name
                                                        FROM ' . $region_cls->getTable() . ' AS reg1
                                                        WHERE reg1.region_id = p.postal_state
                                                        ) AS postal_state_name,

                                                        (SELECT reg3.name
                                                        FROM ' . $region_cls->getTable() . ' AS reg3
                                                        WHERE reg3.region_id = p.postal_country
                                                        ) AS postal_country_name

                                                FROM ' . $agent_cls->getTable() . ' As ag
                                                LEFT JOIN ' . $agent_cls->getTable('agent_type') . ' AS agt
                                                ON ag.type_id = agt.agent_type_id
                                                LEFT JOIN ' . $agent_cls->getTable('partner_register') . ' AS p
                                                ON p.agent_id = ag.agent_id
                                                WHERE ag.agent_id=' . $agent_id, true);
        //print_r($property_cls->sql);die();
        if (is_array($row_agent) and count($row_agent) > 0) {
            $data = formUnescapes($row_agent);
        }
    }
    return $data;
}

function PE_getBankInfo($property_id = 0)
{
    global $property_cls;
    if ($property_id > 0) {
        $pro_row = $property_cls->getCRow(array('bank_info'), 'property_id = ' . $property_id);
        if (count($pro_row) > 0 and is_array($pro_row)) {
            return unserialize($pro_row['bank_info']);
        }
    }
    return array();
}

/**
 * @ function : PE_get_winner_property
 * @ param : property_id
 * @ output : array info
 * --------
 **/
function PE_getWinnerProperty($property_id)
{
    global $message_cls;
    $data = array();
    if ($property_id > 0) {
        $type = PE_Get_type_property($property_id);
        $issold = PE_getSoldStatus($property_id);
        if ($issold) {
            $row_mess = $message_cls->getRow('entity_id =' . $property_id . ' AND active_sold=1');
            if (count($row_mess) > 0 and is_array($row_mess)) {
                $row = PE_getAgent($row_mess['agent_id_from']);
                $data = $row;
            } elseif ($type == 'stop_auction') {
                $row_bidder = Bid_getLastBidByPropertyId($property_id);
                if (count($row_bidder) > 0 and is_array($row_bidder)) {
                    $reserve = PT_getValueByCode($property_id, 'reserve');
                    if ($row_bidder['price'] >= $reserve) {
                        $row = PE_getAgent($row_bidder['agent_id']);
                        $data = $row;
                    }
                }
            }
        }
    }
    return $data;
}

/*DateTime::diff -- date_diff — Returns the difference between two DateTime objects*/
if (!function_exists('date_diff')) {
    class DateInterval
    {
        public $y;
        public $m;
        public $d;
        public $h;
        public $i;
        public $s;
        public $invert;

        public function format($format)
        {
            $format = str_replace('%R%y', ($this->invert ? '-' : '+') . $this->y, $format);
            $format = str_replace('%R%m', ($this->invert ? '-' : '+') . $this->m, $format);
            $format = str_replace('%R%d', ($this->invert ? '-' : '+') . $this->d, $format);
            $format = str_replace('%R%h', ($this->invert ? '-' : '+') . $this->h, $format);
            $format = str_replace('%R%i', ($this->invert ? '-' : '+') . $this->i, $format);
            $format = str_replace('%R%s', ($this->invert ? '-' : '+') . $this->s, $format);
            $format = str_replace('%y', $this->y, $format);
            $format = str_replace('%m', $this->m, $format);
            $format = str_replace('%d', $this->d, $format);
            $format = str_replace('%h', $this->h, $format);
            $format = str_replace('%i', $this->i, $format);
            $format = str_replace('%s', $this->s, $format);
            return $format;
        }
    }

    function date_diff(DateTime $date1, DateTime $date2)
    {
        $diff = new DateInterval();
        if ($date1 > $date2) {
            $tmp = $date1;
            $date1 = $date2;
            $date2 = $tmp;
            $diff->invert = true;
        }
        $diff->y = ((int)$date2->format('Y')) - ((int)$date1->format('Y'));
        $diff->m = ((int)$date2->format('n')) - ((int)$date1->format('n'));
        if ($diff->m < 0) {
            $diff->y -= 1;
            $diff->m = $diff->m + 12;
        }
        $diff->d = ((int)$date2->format('j')) - ((int)$date1->format('j'));
        if ($diff->d < 0) {
            $diff->m -= 1;
            $diff->d = $diff->d + ((int)$date1->format('t'));
        }
        $diff->h = ((int)$date2->format('G')) - ((int)$date1->format('G'));
        if ($diff->h < 0) {
            $diff->d -= 1;
            $diff->h = $diff->h + 24;
        }
        $diff->i = ((int)$date2->format('i')) - ((int)$date1->format('i'));
        if ($diff->i < 0) {
            $diff->h -= 1;
            $diff->i = $diff->i + 60;
        }
        $diff->s = ((int)$date2->format('s')) - ((int)$date1->format('s'));
        if ($diff->s < 0) {
            $diff->i -= 1;
            $diff->s = $diff->s + 60;
        }
        return $diff;
    }
}
function date_diff_ar($start, $end = "NOW") // calculate second
{
    $date_time_shift = array('days' => 0, 'hrs' => 0, 'min' => 0, 'sec' => 0);
    $sdate = strtotime($start);
    $edate = strtotime($end);
    $time = $edate - $sdate;
    if ($time >= 0 && $time <= 59) {
        // Seconds
        //$timeshift = $time.' seconds ';
        $date_time_shift['sec'] = $time;
    } elseif ($time >= 60 && $time <= 3599) {
        // Minutes + Seconds
        $pmin = ($edate - $sdate) / 60;
        $premin = explode('.', $pmin);
        $presec = $pmin - $premin[0];
        $sec = $presec * 60;
        //$timeshift = $premin[0].' min '.round($sec,0).' sec ';
        $date_time_shift['min'] = $premin[0];
        $date_time_shift['sec'] = round($sec, 0);
    } elseif ($time >= 3600 && $time <= 86399) {
        // Hours + Minutes
        $phour = ($edate - $sdate) / 3600;
        $prehour = explode('.', $phour);
        $premin = $phour - $prehour[0];
        $min = explode('.', $premin * 60);
        $presec = '0.' . $min[1];
        $sec = $presec * 60;
        //$timeshift = $prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';
        $date_time_shift['hrs'] = $prehour[0];
        $date_time_shift['min'] = $min[0];
        $date_time_shift['sec'] = round($sec, 0);
    } elseif ($time >= 86400) {
        // Days + Hours + Minutes
        $pday = ($edate - $sdate) / 86400;
        $preday = explode('.', $pday);
        $phour = $pday - $preday[0];
        $prehour = explode('.', $phour * 24);
        $premin = ($phour * 24) - $prehour[0];
        $min = explode('.', $premin * 60);
        $presec = '0.' . $min[1];
        $sec = $presec * 60;
        //$timeshift = $preday[0].' days '.$prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';
        $date_time_shift['days'] = $preday[0];
        $date_time_shift['hrs'] = $prehour[0];
        $date_time_shift['min'] = $min[0];
        $date_time_shift['sec'] = round($sec, 0);
    }
    return $date_time_shift;
}

function utf8_to_latin9($utf8str)
{ // replaces utf8_decode()
    $trans = array("€" => "¤", "�" => "¦", "š" => "¨", "Ž" => "´", "ž" => "¸", "Œ" => "¼", "œ" => "½", "Ÿ" => "¾", "?" => "");
    $wrong_utf8str = strtr($utf8str, $trans);
    $latin9str = utf8_decode($wrong_utf8str);
    return $latin9str;
}

function PE_isPassedInAuction($property_id)
{
    global $property_cls;
    if ($property_id <= 0) return false;
    $row = $property_cls->getRow('property_id = ' . $property_id);
    if (is_array($row) and count($row) > 0) {
        $auction_sale_ar = PEO_getAuctionSale();
        if ($auction_sale_ar['auction'] == $row['auction_sale']) {
            $bidPrice = PE_getBidPrice($property_id);
            if ($bidPrice < $row['price'] AND ($row['end_time'] < date('Y-m-d H:i:s') OR $row['stop_bid'] == 1))
                return true;
            else
                return false;
        }
        return false;
    }
    return false;
}

function PE_isBidHistory($property_id)
{
    global $bid_cls, $agent_cls, $config_cls, $smarty, $property_cls, $property_history_cls;
    $bid_transition_history_cls = new bids_transition_history();
    $show_all = false;
    $count_bid = 0;
    $is_bid_history = false;
    if ($property_id > 0) {
        $bid_rows = $bid_cls->getRow('SELECT SQL_CALC_FOUND_ROWS
                                                    bid.price,
                                                    bid.time
                                            FROM ' . $bid_cls->getTable() . ' AS bid
                                            WHERE bid.property_id = ' . $property_id
            , true);
        if ($bid_cls->hasError()) {
        } else if (is_array($bid_rows) and count($bid_rows) > 0) {
            {
                $is_bid_history = true;
            }
        } else {
            $row_his = $property_history_cls->getRow('property_id=' . $property_id);
            if (is_array($row_his) and count($row_his) > 0) {
                $bid_tran = $bid_transition_history_cls->getRow('SELECT SQL_CALC_FOUND_ROWS
                                                                        bid.price,
                                                                        bid.time
                                                                    FROM ' . $bid_transition_history_cls->getTable() . ' AS bid
                                                                    WHERE bid.property_transition_history_id = ' . $row_his['property_transition_history_id']
                    , true);
                if (is_array($bid_tran) and count($bid_tran) > 0) {
                    $is_bid_history = true;
                }
            }
        }
    }
    return $is_bid_history;
}

function PE_allowActive($property_id = 0)
{
    global $smarty, $property_cls;
    if ($property_id > 0) {
        $auction_sale_ar = PEO_getAuctionSale();
        $row = $property_cls->getRow('property_id =' . $property_id);
        if (is_array($row) and count($row) > 0) {
            if ($row['auction_sale'] == $auction_sale_ar['auction']) {
                if ($row['end_time'] > date('Y-m-d H:i:s') and (int)$row['active'] == 0 and (int)$row['pay_status'] == Property::PAY_COMPLETE) {
                    return true;
                }
            } else {
                return true;
            }
        }
    }
    return false;
}

function Property_makeCountDownPopup($property_id = 0, $type_popup = '')
{
    global $smarty, $property_cls, $config_cls, $bid_cls, $auction_term_cls, $property_term_cls;
    $auction_sale_ar = PEO_getAuctionSale();
    $row = $property_cls->getRow('SELECT property_id,
                                            autobid_enable,
                                            min_increment,
                                            max_increment,
                                            stop_bid,
                                            confirm_sold,
                                            set_count,
                                        IF(pro.auction_sale = ' . $auction_sale_ar['auction'] . ',
												(SELECT IF( ISNULL( MAX(b.price)) OR pro.start_time > \'' . date('Y-m-d H:i:s') . '\' ,
															(SELECT  pro_term.value
															FROM ' . $property_term_cls->getTable() . ' AS pro_term
															LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
																ON pro_term.auction_term_id = term.auction_term_id
															WHERE term.code = \'auction_start_price\' AND pro.property_id = pro_term.property_id
															),
															MAX(b.price) )
												FROM ' . $bid_cls->getTable() . ' AS b
												WHERE b.property_id = pro.property_id
												)
									    ,pro.price) AS price
                                        FROM ' . $property_cls->getTable() . ' AS pro
                                        WHERE property_id = ' . $property_id, true);
    $smarty->assign('refresh_time', $config_cls->getKey('no_more_bids_refresh') * 1000);
    //$smarty->assign('refresh_time',100);
    if (is_array($row) and count($row) > 0) {
        $row['isLastBidVendor'] = Bid_isLastBidVendor($row['property_id']);
        $row['bidder'] = formUnescape(Bid_getShortNameLastBidder($row['property_id']));
        //BEGIN GET RESERVE PRICE
        $row['reserve'] = PT_getValueByCode($row['property_id'], 'reserve');
        $row['check_price'] = $row['price'] >= $row['reserve'] && $row['reserve'] > 0;
        $row['price'] = showPrice($row['price']);
        $row['inc_default'] = $inc_default = PT_getValueByCode($row['property_id'], 'initial_auction_increments');
        $row['price_inc_default'] = $price_inc_default = showPrice($inc_default);
        //print_r($row);
        if (($row['min_increment']) == "" or !isset($row['min_increment']) or $row['min_increment'] == 0) {
            $property_cls->update(array('min_increment' => $inc_default), "property_id = " . $row['property_id']);
            $row['min_increment'] = $inc_default;
            $row['min_increment_'] = $price_inc_default;
        } else {
            $row['min_increment_'] = showPrice($row['min_increment']);
        }
        if (($row['max_increment']) == "" or !isset($row['max_increment']) or $row['max_increment'] == 0) {
            $row['max_increment'] = "";
            $row['max_increment_'] = "";
        } else {
            $row['max_increment_'] = showPrice($row['max_increment']);
        }
        //$row['max_increment_'] = showPrice($row['max_increment']) != "$0"  ? showPrice($row['max_increment']) : "" ;
        //$row['min_increment_'] = showPrice($row['min_increment']) != "$0" ? showPrice($row['min_increment']) : "" ;
        if ($row['max_increment_'] != "" and $row['min_increment_'] != "") {
            $row['min_max_increment_mess'] = $row['max_increment_'] . " to " . $row['min_increment_'];
        } elseif ($row['max_increment_'] != "") {
            $row['min_max_increment_mess'] = $row['max_increment_'] . "(max) ";
        } elseif ($row['min_increment_'] != "") {
            $row['min_max_increment_mess'] = $row['min_increment_'] . "(min) ";
        } else {
            $row['min_max_increment_mess'] = "none";
        }
        $row['owner'] = '"' . implode('","', Property_getOwner($property_id)) . '"';
        $row['is_mobile'] = (int)detectMobile();
        $row['is_mobile_nexus7'] = (int)detectNexus7();
        //print_r($row);
        $smarty->assign('row', $row);
        $smarty->assign('type_popup', $type_popup);
        $iai_id = AT_getIdByCode('price_options_popup');
        $step_options_detail = AT_getOptions($iai_id, 0, 'DESC');
        $smarty->assign('price_ar_options', $step_options_detail);
        $no_more_bid = PE_isNoMoreBids($row['property_id'], isset($_SESSION['agent']) ? $_SESSION['agent']['id'] : 0);
        $smarty->assign('no_more_bid', $no_more_bid);
        $str = $smarty->fetch(ROOTPATH . '/modules/property/templates/property.countdown.popup.tpl');
        return $str;
    }
}

function Property_getOwner($property_id = 0)
{
    global $property_cls, $agent_cls;
    $rs = array();
    $row = $property_cls->getRow('SELECT pro.agent_id, pro.agent_manager, agt.parent_id
				FROM ' . $property_cls->getTable() . ' AS pro, ' . $agent_cls->getTable() . ' AS agt
				WHERE pro.agent_id = agt.agent_id AND pro.property_id = ' . (int)$property_id, true);
    if (count($row) > 0) {
        if ((int)@$row['agent_id'] > 0) {
            $rs[] = $row['agent_id'];
        }
        if ((int)@$row['agent_manager'] > 0) {
            $rs[] = $row['agent_manager'];
        }
        if ((int)@$row['parent_id'] > 0) {
            $rs[] = $row['parent_id'];
        }
    }
    return $rs;
}

function Property_getOwnerByPropertyId($property_id = 0)
{
    global $property_cls, $agent_cls;
    $rs = array();
    $row = $property_cls->getRow('SELECT pro.agent_id, pro.agent_manager, agt.parent_id
				FROM ' . $property_cls->getTable() . ' AS pro, ' . $agent_cls->getTable() . ' AS agt
				WHERE pro.agent_id = agt.agent_id AND pro.property_id = ' . (int)$property_id, true);
    if (count($row) > 0) {
        if ((int)@$row['agent_id'] > 0) {
            $rs['agent_id'] = $row['agent_id'];
        }
        if ((int)@$row['agent_manager'] > 0) {
            $rs['agent_manager'] = $row['agent_manager'];
        }
        if ((int)@$row['parent_id'] > 0) {
            $rs['parent_id'] = $row['parent_id'];
        }
    }
    return $rs;
}

function Property_getParent($property_id = 0)
{
    global $property_cls, $agent_cls;
    $agent_id = 0;
    $row = $property_cls->getRow('SELECT pro.agent_id, pro.agent_manager, agt.parent_id
				FROM ' . $property_cls->getTable() . ' AS pro, ' . $agent_cls->getTable() . ' AS agt
				WHERE pro.agent_id = agt.agent_id AND pro.property_id = ' . (int)$property_id, true);
    if (count($row) > 0) {
        if ((int)@$row['parent_id'] > 0) {
            $agent_id = $row['parent_id'];
        } else if ((int)@$row['agent_manager'] > 0) {
            $agent_id = $row['agent_manager'];
        } else {
            $agent_id = $row['agent_id'];
        }
    }
    return $agent_id;
}

function Property_isVendor($vendor_id = 0, $property_id = 0)
{
    global $property_cls, $bid_cls, $smarty, $agent_cls;
    $check = false;
    if ($property_id > 0 and $vendor_id > 0) {
        $row = $property_cls->getCRow(array('agent_id'), 'property_id = ' . $property_id);
        if (count($row) > 0 and is_array($row)) {
            $check = ($row['agent_id'] == $vendor_id) ? true : false;
        }
    }
    return $check;
}

function Property_registerBid($property_id = 0)
{
    global $property_cls, $bid_cls, $smarty, $agent_cls;
    if ($property_id > 0) {
        if (isset($_SESSION['agent']) AND ($_SESSION['agent']['id'] > 0)) {
            return Property_isMine($_SESSION['agent']['id'], $property_id) ? true : bid_first_isvalid($property_id, $_SESSION['agent']['id']);
        }
    }
    return false;
}

function Property_isMine($agent_id, $property_id)
{
    global $property_cls, $agent_cls;
    $result = false;
    if ($agent_id > 0) {
        if ($property_id > 0) {
            $row = $property_cls->getRow('SELECT    pro.property_id,
                                                    pro.agent_id,pro.agent_manager,
                                                    agt.parent_id
                                          FROM ' . $property_cls->getTable() . ' AS pro,' . $agent_cls->getTable() . ' AS agt
                                          WHERE ' . $property_id . '= pro.property_id
                                                AND  agt.agent_id = pro.agent_id
                                 ', true);
            if (is_array($row) and count($row) > 0) {
                if ($row['agent_id'] == $agent_id) {
                    $result = true;
                    return $result;
                }
                if (PE_isTheBlock($row['property_id']) || PE_isTheBlock($row['property_id'], 'agent')) {
                    if ($row['agent_manager'] == '' || $row['agent_manager'] == 0 || !isset($row['agent_manager'])) {
                        $result = ((in_array($row['agent_id'], A_getChildSimple($agent_id))));
                    } else {
                        $child = array();
                        if ($row['parent_id'] == 0) {
                            $child = A_getChildSimple($agent_id);
                        }
                        $result = ($row['agent_manager'] == $agent_id || in_array($row['agent_id'], $child));
                    }
                }
            }
        }
        /*$rows = $property_cls->getRows('property_id = '.$property_id.'
                                        AND (IF(ISNULL(agent_manager)
                                                OR agent_manager = 0
                                                OR (SELECT parent_id FROM '.$agent_cls->getTable().' WHERE agent_id = '.$_SESSION['agent']['id'].') = 0
                                               ,agent_id = '.$agent_id.'
                                               ,agent_manager = '.$agent_id.'
                                               )
                                            OR agent_id  IN(SELECT agent_id FROM agent WHERE parent_id = '.$agent_id.'))');
        if (is_array($rows) and count($rows) > 0){
            return true;
        }*/
    }
    return $result;
}

function PEO_getOptionById($id = 0)
{
    global $property_entity_option_cls;
    $result = '';
    if ($id > 0) {
        $row = $property_entity_option_cls->getRow('property_entity_option_id = ' . $id);
        if (count($row) > 0 and is_array($row)) {
            $result = $row;
        }
    }
    return $result;
}

function PEO_getKindByType($type_id = 0)
{
    global $property_entity_option_cls;
    $result = array();
    if ($type_id > 0) {
        $row = $property_entity_option_cls->getRow('property_entity_option_id = ' . $type_id);
        if (is_array($row) and count($row) > 0) {
            $result = PEO_getOptionById($row['parent_id']);
        }
    }
    return $result;
}

function PEO_getTypeByKind($kind_id = 0)
{
    global $property_entity_option_cls;
    $result = array();
    if ($kind_id > 0) {
        $kind_code = $kind_id == 1 ? 'property_type_commercial' : ($kind_id == 2 ? 'property_type' : '');
        if ($kind_code != '') $result = PEO_getOptions($kind_code);
    }
    return $result;
}

function PE_isActiveDetail($property_id = 0)
{
    global $property_cls, $property_term_cls, $auction_term_cls, $config_cls, $agent_cls, $bids_first_cls;
    $auction_sale_ar = PEO_getAuctionSale();
    $_active = " pro.pay_status = " . Property::CAN_SHOW . '
                    AND IF (pro.auction_sale = ' . $auction_sale_ar['auction'] . ',
                           (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\'
                                   ,0
                                   ,pro_term.value)
                           FROM ' . $property_term_cls->getTable() . ' AS pro_term
                           LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
                           ON pro_term.auction_term_id = term.auction_term_id
                           WHERE term.code = \'auction_start_price\'
                           AND pro.property_id = pro_term.property_id ) != 0
                    , 1)
                    AND pro.active = 1
                    AND pro.agent_active = 1';
    $date_lock = (int)$config_cls->getKey('date_lock');
    if (isset($_SESSION['agent']) and $_SESSION['agent']['id'] > 0) {
        //agent is the block/is not the block
        $time_str = " AND IF(
                                (SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at WHERE agt.type_id = at.agent_type_id) = 'theblock',

                                (SELECT p.pay_bid_first_status FROM " . $bids_first_cls->getTable() . " AS p
                                 WHERE p.property_id = pro.property_id AND p.agent_id = " . $_SESSION['agent']['id'] . ")> 0
                                 OR '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY),pro.date_to_reg_bid)
                                 OR (IF(ISNULL(pro.agent_manager)
                                        OR pro.agent_manager = 0
                                        ,pro.agent_id = {$_SESSION['agent']['id']}
                                        , pro.agent_manager = '{$_SESSION['agent']['id']}')
                                     || pro.agent_id IN (SELECT a.agent_id FROM agent AS a WHERE a.parent_id = {$_SESSION['agent']['id']})
                                     || (pro.agent_id = '{$_SESSION['agent']['id']}' AND agt.parent_id = 0))

                                ,IF (pro.agent_id = {$_SESSION['agent']['id']},1, {$_active}))";
    } else {
        $time_str = " AND IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at
                                  WHERE agt.type_id = at.agent_type_id) = 'theblock',
                                  '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY),pro.date_to_reg_bid),1) = 1
                          AND {$_active}";
    }
    $where = "pro.property_id = $property_id $time_str";
    if ($property_id > 0) {
        $row = $property_cls->getRow("SELECT * FROM " . $property_cls->getTable() . " as pro
                                                INNER JOIN " . $property_cls->getTable('agent') . " AS agt ON pro.agent_id = agt.agent_id
                                               WHERE $where LIMIT 1", true);
        if (is_array($row) and count($row) > 0) {
            return true;
        }
    }
    return false;
}

function PE_getDisableFieldsPaid($payment_status)
{
    if ($payment_status == Property::PAY_COMPLETE || $payment_status == 'complete') {
        $fields = array('auction_sale');
        return $fields;
    }
    return array();
}

function PE_isValidPriceBeforeLiveAndEnding($property_id = 0, $type = '')
{
    global $config_cls, $property_cls;
    $ch_ar = array('start_time' => false, 'start_price' => false, 'end_time' => false, 'reserve_price' => false, 'price' => false);
    $date_now = date('Y-m-d H:i:s');
    $date_to_lock_before_ending = (int)$config_cls->getKey('date_to_lock_before_ending');
    //automatic disable:Nhung
    //$ch_ar['reserve_price'] = true;
    if (!isset($date_to_lock_before_ending) Or $date_to_lock_before_ending == '') {
        $date_to_lock_before_ending = 0;
    }
    $date_to_lock_before_live = $type == 'agent' ? 0 : (int)$config_cls->getKey('date_to_lock_before_live');
    if (!isset($date_to_lock_before_live) Or $date_to_lock_before_live == '') {
        $date_to_lock_before_live = 0;
    }
    if ($property_id > 0) {
        $row = $property_cls->getCRow(array('auction_sale', 'pay_status', 'active', 'confirm_sold', 'end_time', 'start_time', 'stop_bid'), "property_id='{$property_id}'");
        if (count($row) > 0 and is_array($row) > 0) {
            if ($row['start_time'] == '5000-05-05 00:00:00') {
                $row['start_time'] = '0000-00-00 00:00:00';
            }
            if ($row['end_time'] == '5000-06-06 00:00:00') {
                $row['end_time'] = '0000-00-00 00:00:00';
            }
            $auction_sale_ar = PEO_getAuctionSale();
            if ($row['auction_sale'] != $auction_sale_ar['private_sale']
                AND $row['pay_status'] == Property::PAY_COMPLETE
                AND $row['active'] == 1
                AND $row['confirm_sold'] == Property::SOLD_UNKNOWN
                AND $row['end_time'] != '0000-00-00 00:00:00'
                AND $row['start_time'] != '0000-00-00 00:00:00'
            ) {
                if ($row['start_time'] < date('Y-m-d H:i:s')
                    AND $row['stop_bid'] == 0
                ) // Live
                {
                    foreach ($ch_ar as $key => $ch) {
                        $ch_ar[$key] = true;
                    }
                    $date_ar = date_diff_ar($date_now, $row['end_time']);
                    if (($date_ar['days'] == $date_to_lock_before_ending
                            AND $date_ar['hrs'] > 0
                            AND $date_ar['min'] > 0
                            AND $date_ar['sec'] > 0) OR ($date_ar['days'] > $date_to_lock_before_ending)
                    ) {
                        $ch_ar['end_time'] = false;
                    }
                } else { // Forthcoming
                    foreach ($ch_ar as $key => $ch) {
                        $ch_ar[$key] = false;
                    }
                    $date_ar = date_diff_ar($date_now, $row['start_time']);
                    //print_r($date_ar);
                    if (($date_ar['days'] == $date_to_lock_before_live
                            AND $date_ar['hrs'] <= 0
                            AND $date_ar['min'] <= 0
                            AND $date_ar['sec'] <= 0)
                        OR ($date_ar['days'] < $date_to_lock_before_live)
                    ) {
                        $ch_ar['start_time'] = true;
                        $ch_ar['price'] = true;
                        $ch_ar['reserve_price'] = true;
                    }
                }
            }
        }
    }
    return $ch_ar;
}

function PE_isNoMoreBids($property_id, $agent_id)
{
    global $bids_stop_cls;
    if ($agent_id > 0 && Property_registerBid($property_id)) {
        $row = $bids_stop_cls->getRow('SELECT stop_id
                                   FROM ' . $bids_stop_cls->getTable() . '
                                   WHERE property_id = ' . $property_id . ' AND agent_id = ' . $agent_id, true);
        if (is_array($row) and count($row) > 0) {
            return true;
        }
        return false;
    } else {
        return true;
    }
}

function PA_getCurrentPackage($agent_id)
{
    global $agent_cls, $agent_payment_cls;
    $row = $agent_cls->getCRow(array('agent_id', 'parent_id'), 'agent_id = ' . $agent_id);
    if (is_array($row) and count($row) > 0) {
        $parent_id = $row['parent_id'] > 0 ? $row['parent_id'] : $row['agent_id'];
        $package_arr = $agent_payment_cls->getCRow('package_id', 'agent_id = ' . $parent_id . "
                                                    AND date_from <= '" . date('Y-m-d H:i:s') . "' AND date_to >= '" . date('Y-m-d H:i:s') . "'");
        if (is_array($package_arr) and count($package_arr)) {
            return PK_getPackage($package_arr['package_id']);
        }
    }
    return null;
}

function Property_isShow($property_id, $agent_id)
{
    global $config_cls, $agent_cls, $bids_first_cls, $property_cls, $agent_payment_cls, $property_term_cls, $auction_term_cls;
    $date_lock = (int)$config_cls->getKey('date_lock');
    $auction_sale_ar = PEO_getAuctionSale();
    //BEGIN SQL FOR CHECK ACTIVE
    $_active = " pro.pay_status = " . Property::CAN_SHOW . '
                    AND IF (pro.auction_sale != ' . $auction_sale_ar['private_sale'] . ',
                           (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\'
                                   ,0
                                   ,pro_term.value)
                           FROM ' . $property_term_cls->getTable() . ' AS pro_term
                           LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
                           ON pro_term.auction_term_id = term.auction_term_id
                           WHERE term.code = \'auction_start_price\'
                           AND pro.property_id = pro_term.property_id ) != 0
                    , 1)
                    AND pro.active = 1
                    AND pro.agent_active = 1';
    if ($agent_id > 0) {
        $time_str = " AND IF(
                                (SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at WHERE agt.type_id = at.agent_type_id) IN ('theblock','agent'),

                                (SELECT p.pay_bid_first_status FROM " . $bids_first_cls->getTable() . " AS p
                                 WHERE p.property_id = pro.property_id AND p.agent_id = " . $agent_id . ")> 0
                                 OR '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY),pro.date_to_reg_bid)
                                 OR (IF(ISNULL(pro.agent_manager)
                                        OR pro.agent_manager = 0
                                        ,pro.agent_id = $agent_id
                                        , pro.agent_manager = '$agent_id')
                                     || pro.agent_id IN (SELECT a.agent_id FROM agent AS a WHERE a.parent_id = $agent_id)
                                     || (pro.agent_id = '$agent_id' AND agt.parent_id = 0))

                                ,IF (pro.agent_id = {$_SESSION['agent']['id']},1,{$_active} ))";
    } else {
        $time_str = " AND IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at
                                  WHERE agt.type_id = at.agent_type_id) IN ('theblock','agent'),
                                  '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY),pro.date_to_reg_bid),1) = 1
                          AND {$_active}";
    }
    //HIDE AGENT's PROPERTIES DIDN'T PAYMENT
    $time_str .= " AND IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at
                                   WHERE agt.type_id = at.agent_type_id) IN ('agent')
                                   ,(SELECT ap.payment_id FROM " . $agent_payment_cls->getTable() . " AS ap
                                     WHERE ap.agent_id = IF(agt.parent_id = '',agt.agent_id,agt.parent_id)
                                           AND ap.date_from <= '" . date('Y-m-d') . "' AND ap.date_to >= '" . date('Y-m-d') . "'
                                     ) != ''
                                   ,1)";
    $row = $property_cls->getRow('SELECT pro.property_id
                                  FROM ' . $property_cls->getTable() . ' AS pro
                                  LEFT JOIN ' . $agent_cls->getTable() . ' AS agt
                                  ON pro.agent_id = agt.agent_id
                                  WHERE pro.property_id = ' . $property_id . $time_str, true);
    if (is_array($row) and count($row) > 0) {
        return true;
    }
    return false;
}

function __exportCSV()
{
    global $bid_cls, $agent_cls, $config_cls, $smarty, $property_cls, $pag_cls, $property_history_cls, $region_cls, $payment_store_cls;
    $page = restrictArgs(getParam('page', ''), '[^0-9A-Za-z\-\_]');
    if (true) {
        if ($page == 'AdminRegisterToBid') // export CSV in ADMIN
        {
            $ids_ar = array();
            $property_id = 0;
            $payment_store_ids = restrictArgs(getParam('store_ids', 0), '[^0-9\,]');
            $payment_store_id_ar = explode(',', $payment_store_ids);
            foreach ($payment_store_id_ar as $id) {
                $payment_row = $payment_store_cls->getRow("SELECT property_id FROM " . $payment_store_cls->getTable() . " WHERE id='{$id}'", true);
                if (count($payment_row) > 0 and is_array($payment_row)) {
                    $ids_ar[] = $payment_row['property_id'];
                }
            }
            if (count($ids_ar) > 0) {
                $property_id = implode(',', $ids_ar);
            }
        } else {
            $property_id = (int)restrictArgs(getParam('property_id', 0), '[^0-9]');
        }
        /*$query = 'SELECT SQL_CALC_FOUND_ROWS
											bid.*,
											agt.firstname,
											agt.lastname,
											agt.agent_id AS Agent_id,
											agt.email_address,
											agt.mobilephone,
											agt.telephone,
											agt.license_number,
											agt.street,
											agt.suburb,
											(SELECT reg1.name
                                                FROM '.$region_cls->getTable().' AS reg1
                                                WHERE reg1.region_id = agt.state
                                            ) AS state_name,
                                            agt.postcode,
                                            (SELECT reg3.name
                                                FROM '.$region_cls->getTable().' AS reg3
                                                WHERE reg3.region_id = agt.country
                                            ) AS country_name,
											(SELECT count(bid_.agent_id)
											        FROM '.$bid_cls->getTable().' AS bid_
                                                    WHERE bid_.property_id IN ('.$property_id.') AND bid_.agent_id = bid.agent_id
											        ) AS bid_number
									FROM '.$bid_cls->getTable('bids_first_payment').' AS bid,'.$agent_cls->getTable().' AS agt
									WHERE bid.agent_id = agt.agent_id AND bid.property_id IN ('.$property_id.') AND bid.pay_bid_first_status > 0
									ORDER BY bid.bid_first_time DESC';*/
        $query = ' SELECT SQL_CALC_FOUND_ROWS
                                                     pay.property_id,
                                                     pay.agent_id,
                                                     pay.creation_time,
                                                     pay.is_paid,
                                                     agt.firstname,
                                                    agt.lastname,
                                                    agt.agent_id AS Agent_id,
                                                    agt.email_address,
                                                    agt.mobilephone,
                                                    agt.telephone,
                                                    agt.license_number,
                                                    agt.street,
                                                    agt.suburb,
                                                    agt.state,
                                                    agt.type_id,
                                                    agt.country,
                                                    agt.other_state,
                                                    (SELECT reg1.code
                                                        FROM ' . $region_cls->getTable() . ' AS reg1
                                                        WHERE reg1.region_id = agt.state
                                                    ) AS state_code,
                                                    agt.postcode,
                                                    (SELECT reg3.name
                                                        FROM ' . $region_cls->getTable() . ' AS reg3
                                                        WHERE reg3.region_id = agt.country
                                                    ) AS country_name,
                                                    (SELECT count(bid_.agent_id)
                                                            FROM ' . $bid_cls->getTable() . ' AS bid_
                                                            WHERE bid_.property_id IN (' . $property_id . ') AND bid_.agent_id = pay.agent_id
                                                            ) AS bid_number
                                                    FROM ' . $payment_store_cls->getTable() . ' AS pay,' . $agent_cls->getTable() . ' AS agt
                                                    WHERE pay.agent_id = agt.agent_id AND pay.property_id IN (' . $property_id . ') AND (pay.bid = 1 OR pay.offer = 1) AND pay.is_paid > 0
                                                    ORDER BY pay.creation_time DESC';
        $file_name = restrictArgs(getParam('file_name', ''), '[^0-9A-Za-z\-\_]');
        $file_name = $file_name == '' ? 'data' : $file_name;
        header('Content-Type: text/octect-stream; charset=utf-8');
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="' . $file_name . '.csv"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Disposition: attachment; filename="' . $file_name . '.csv";');
        ob_clean();
        flush();
        //echo $property_id ."\"\n";
        //echo $query."\"\n";
        // output to csv
        $title = array();
        $title[0] = 'No';
        $title[1] = 'Property Id';
        $title[2] = 'Bidder';
        $title[3] = 'Email Address';
        $title[4] = 'Address';
        $title[5] = 'Suburb';
        $title[6] = 'State';
        $title[7] = 'Post Code';
        $title[8] = 'Country';
        $title[9] = 'Telephone';
        $title[10] = 'MobilePhone';
        $title[11] = 'Drivers License Number/Medicare Card No.';
        $title[12] = 'Register Time';
        echo '"' . stripslashes(implode('","', $title)) . "\"\n";
        $rows = $bid_cls->getRows($query, true);
        if (count($rows) > 0 and is_array($rows)) {
            foreach ($rows as $key => $row) {
                $content = array();
                $content['No'] = $key + 1;
                $content['id'] = $row['property_id'];
                $content['bidder'] = $row['firstname'] . ' ' . $row['lastname'];
                $content['email'] = $row['email_address'];
                $content['address'] = $row['street'];
                $content['suburb'] = $row['suburb'];
                if ($row['country'] != 1) {
                    $content['state'] = $row['other_state'];
                } else {
                    $content['state'] = $row['state_code'];
                }
                $content['postcode'] = $row['postcode'];
                $content['country'] = $row['country_name'];
                $content['telephone'] = $row['telephone'];
                $content['mobilephone'] = $row['mobilephone'];
                $content['license'] = $row['license_number'];
                if ($row['type_id'] == 3) {
                    $row_partner = $agent_cls->getRow('SELECT p.*,ac.*
                                                   FROM ' . $agent_cls->getTable('partner_register') . ' AS p
                                                   LEFT JOIN ' . $agent_cls->getTable('agent_contact') . '  AS ac
                                                   ON ac.agent_id = p.agent_id
                                                   WHERE p.agent_id = ' . $row['Agent_id'], true);
                    //print_r($row_partner);
                    if (count($row_partner) > 0) {
                        $content['license'] = $row_partner['register_number'];
                        //unset($content['l']);
                        //unset($title[9]);
                        //$title[11] = 'license_number';
                    }
                }
                $content['time'] = $row['creation_time'];
                foreach ($content as $key => $conte_) {
                    //$conte_ = restrictArgs($conte_,'[^0-9A-Za-z]');
                    $conte_ = str_replace("\"", '', $conte_);
                    $content[$key] = "=\"" . $conte_ . "\"";
                }
                echo '' . stripslashes(implode(',', $content)) . "\n";
            }
        }
        /*while($row = mysql_fetch_row($sql_csv)) {
            print '"' . stripslashes(implode('","',$row)) . "\"\n";
        }*/
        //die('done');
        exit;
        //return true;
    }
}

function __exportPropertyCSV()
{
    global $bid_cls, $agent_cls, $config_cls, $property_entity_option_cls, $smarty, $property_cls, $pag_cls, $property_history_cls, $region_cls, $payment_store_cls;
    $property_ids = restrictArgs(getParam('property_ids', 0), '[^0-9\,]');
    $auction_arr = PEO_getAuctionSale();
    $content = array();
    try {
        $file_name = restrictArgs(getParam('file_name', ''), '[^0-9A-Za-z\-\_]');
        $file_name = $file_name == '' ? 'property' : $file_name;
        header('Content-Type: text/octect-stream; charset=utf-8');
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="' . $file_name . '.csv"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Disposition: attachment; filename="' . $file_name . '.csv";');
        ob_clean();
        flush();
        /*---------------BEGIN CSV---------------*/
        $rows = $property_cls->getRows('SELECT SQL_CALC_FOUND_ROWS pro.property_id,
										pro.address,
										pro.set_jump,
										pro.postcode,
										pro.suburb,
										pro.type,
										pro.pay_status,
										pro.price,
										pro.price_on_application,
										pro.open_for_inspection,
										pro.agent_active,
										pro.active,
										agt.firstname,
										pro.feature,
										pro.focus,
										pro.set_jump,
										agt.lastname,
										pro.views,
										pro.land_size,
										pro.auction_sale,
										pro.stop_bid,
										pro.start_time,
										pro.end_time,
										pro.confirm_sold,
										pro.date_to_reg_bid,
										pro.parking,
										pro.package_id,
										agtype.title AS agent_type,

										(SELECT reg1.code
										FROM ' . $region_cls->getTable() . ' AS reg1
										WHERE reg1.region_id = pro.state) AS state_code,

										(SELECT reg2.name
										FROM ' . $region_cls->getTable() . ' AS reg2
										WHERE reg2.region_id = pro.country) AS country_name,

										(SELECT pro_ent_opt1.title
										FROM ' . $property_entity_option_cls->getTable() . ' AS pro_ent_opt1
										WHERE pro_ent_opt1.property_entity_option_id = pro.auction_sale) AS auction_name,

										(SELECT pro_ent_opt2.title
										FROM ' . $property_entity_option_cls->getTable() . ' AS pro_ent_opt2
										WHERE pro_ent_opt2.property_entity_option_id = pro.type) AS type_name,

										(SELECT pro_ent_opt4.title
										FROM ' . $property_entity_option_cls->getTable() . ' AS pro_ent_opt4
										WHERE pro_ent_opt4.property_entity_option_id = pro.bedroom) AS bedroom_name,

										(SELECT pro_ent_opt5.title
										FROM ' . $property_entity_option_cls->getTable() . ' AS pro_ent_opt5
										WHERE pro_ent_opt5.property_entity_option_id = pro.bathroom) AS bathroom_name,

										(SELECT pro_ent_opt7.title
										FROM ' . $property_entity_option_cls->getTable() . ' AS pro_ent_opt7
										WHERE pro_ent_opt7.property_entity_option_id = pro.car_space) AS car_space_name,

										(SELECT pro_ent_opt8.title
										FROM ' . $property_entity_option_cls->getTable() . " AS pro_ent_opt8
										WHERE pro_ent_opt8.property_entity_option_id = pro.car_port) AS car_port_name,

										(SELECT IF(isnull(max(bid.price)),0,max(bid.price))
										FROM " . $property_cls->getTable('bids') . " AS bid
										WHERE bid.property_id = pro.property_id) AS bid_price,

										(SELECT pro_opt4.code
										FROM " . $property_entity_option_cls->getTable() . " AS pro_opt4
										WHERE pro_opt4.property_entity_option_id = pro.auction_sale
										) AS auction_sale_code,

										(SELECT pro_term.value
										 FROM " . $property_cls->getTable('property_term') . ' AS pro_term
										 LEFT JOIN ' . $property_cls->getTable('auction_terms') . " AS term
												ON pro_term.auction_term_id = term.auction_term_id
										 WHERE term.code = 'auction_start_price' AND pro.property_id = pro_term.property_id) AS start_price,

										(SELECT COUNT(*) FROM notes AS n WHERE n.entity_id_to = pro.property_id AND n.type != 'admin2customer') AS cproperty,
										(SELECT COUNT(*) FROM comments AS c WHERE c.property_id = pro.property_id) AS comproperty,
										(SELECT COUNT(*) FROM bids AS b WHERE b.property_id = pro.property_id) AS bidproperty

							FROM " . $property_cls->getTable() . ' AS pro
							LEFT JOIN ' . $agent_cls->getTable() . ' AS agt ON pro.agent_id = agt.agent_id
							LEFT JOIN ' . $agent_cls->getTable('agent_type') . ' AS agtype ON agt.type_id = agtype.agent_type_id
							WHERE pro.property_id IN (' . $property_ids . ')
							', true);
        if (count($rows) > 0 and is_array($rows)) {
            foreach ($rows as $key => $row) {
                if ($row['agent_type'] != 'agent') {
                    $row['auction_name'] = $row['auction_sale'] == $auction_arr['auction'] ? 'Live Auction' : $row['auction_name'];
                }
                $row['price'] = showPrice($row['price']);
                $row['bid_price'] = showPrice($row['bid_price']);
                if ($row['bid_price'] == '$0') {
                    $row['bid_price'] = showPrice($row['start_price']);
                    if ($row['auction_name'] == 'Private Sale') {
                        $row['bid_price'] = '--';
                        if ($row['price'] == '$0') {
                            $row['price'] = showPrice($row['price_on_application']);
                        }
                    }
                }
                $row['price'] = $row['price_on_application'] == 1 ? 'POA' : $row['price'];
                $row['set_jump'] = (int)$row['set_jump'];
                $row['agent_fullname'] = $row['firstname'] . ' ' . $row['lastname'];
                $row['address_full'] = $row['address'] . ', ' . $row['suburb'] . ', ' . $row['postcode'] . ', ' . $row['state_code'] . ', ' . $row['country_name'];
                $row['pay_status'] = $property_cls->getPayStatus($row['pay_status']);
                $packages = __listPackageByPropertyId($row['property_id']);
                /*---------------- CONTENT----------------- */
                $content['No'][] = $key + 1;
                $content['Property Id'][$key] = $row['property_id'];
                $content['Address'][$key] = $row['address'];
                $content['Suburb'][$key] = $row['suburb'];
                $content['Postcode'][$key] = $row['postcode'];
                $content['State'][$key] = $row['state_code'];
                $content['Country'][$key] = $row['country_name'];
                $content['Status'][$key] = $row['active'] ? "Active" : 'Inactive';
                $content['Price'][$key] = $row['price'];
                $content['Bid Price'][$key] = $row['bid_price'];
                $content['Auction/Sale'][$key] = $row['auction_name'];
                $content['Type'][$key] = $row['type_name'];
                $content['Vendor Name'][$key] = $row['agent_fullname'];
                $content['Pay Status'][$key] = $row['pay_status'];
                //$content['Package'][$key] = '' ;
                /**/
                foreach ($packages as $packageData_val) {
                    foreach ($packageData_val['options'] as $val) {
                        $content[$val['name'] . ' (' . $packageData_val['package_name'] . ')'][$key] = $val['value_html'];
                    }
                }
            }
            /* CSV SAVE CONTENT*/
            $title_ar = array_keys($content);
            echo '"' . stripslashes(implode('","', $title_ar)) . "\"\n";
            for ($i = 0; $i < count($rows); $i++) {
                $csv_property_data = array();
                foreach ($title_ar as $key_title) {
                    $csv_property_data[] = "" . str_replace(array("\"", ",", "_"), array('', '.', ' '), $content[$key_title][$i]) . "";
                }
                echo '' . stripslashes(implode(',', $csv_property_data)) . "\n";
            }
        }
        exit;
    } catch (Exception $er) {
        print_r($er->getMessage());
    }
}

function Property_isVendorOfProperty($property_id, $agent_id = 0)
{
    global $agent_cls, $property_cls;
    $isVendor = false;
    if ($agent_id == 0) {
        $agent_id = (int)$_SESSION['agent']['id'];
    }
    if ($agent_id != '' && $agent_id > 0) {
        $agent = array();
        $agent = $property_cls->getRow('SELECT pro.property_id, pro.agent_id
                                          FROM ' . $property_cls->getTable() . ' AS pro
                                          LEFT JOIN ' . $agent_cls->getTable() . ' AS a
                                          ON pro.agent_id = a.agent_id
                                          WHERE pro.property_id = ' . $property_id . '
                                          AND IF((SELECT agt.title FROM ' . $agent_cls->getTable('agent_type') . " AS agt
                                                  WHERE agt.agent_type_id = a.type_id) IN ('theblock','agent')

                                                  ,IF(pro.agent_manager = '' || ISNULL(pro.agent_manager) || pro.agent_manager = 0
                                                      ,pro.agent_id = {$agent_id} || a.parent_id IN ({$agent_id})
                                                      ,pro.agent_manager = {$agent_id} || (SELECT a1.parent_id FROM agent AS a1 WHERE a1.agent_id = pro.agent_manager) = {$agent_id}
                                                   )
                                                  ,pro.agent_id = {$agent_id})", true);
        $isVendor = (is_array($agent) and count($agent) > 0) ? true : false;
    }
    return $isVendor;
}

function PE_getEbiddaWatermark($property_id, $isDetail = false)
{
    $watermark = "";
    $watermark_ar = array('auction' => 'ebidda.png', 'ebidda30' => 'ebidda30.png', 'ebiddar' => 'ebiddaR.png', 'bid2stay' => 'bid2stay.png');
    if ($isDetail) {
        $watermark_ar = array('auction' => 'ebidda_detail.png', 'ebidda30' => 'ebidda30_detail.png', 'ebiddar' => 'ebiddaR_detail.png', 'bid2stay' => 'bid2stay_detail.png');
    }
    $skin_img_url = '/modules/general/templates/images/';
    if ($property_id > 0) {
        $agent = Property_getOwnerByPropertyId($property_id);
        $agent_id = $agent['agent_id'];
        if ($agent_id > 0) {
            //echo 'ID='.$property_id.' Type:'.AgentType_getTypeAgent($agent_id).'<br>';
            //if(AgentType_getTypeAgent($agent_id) == 'agent'){
            foreach ($watermark_ar as $key => $img) {
                if (PE_isAuction($property_id, $key)) {
                    $watermark = $skin_img_url . $img;
                    if (!file_exists(ROOTURL . $watermark)) {
                        //$watermark = "";
                    }
                }
            }
            //}
        }
    }
    return $watermark;
}

/*
property_id,
auction_sale,
suburb,
end_time,
start_time,
confirm_sold,
sold_time,
owner
*/
function Property_getTitle($info_ar = array())
{
    global $config_cls;
    $title = '';
    $id = $info_ar['property_id'];
    $auction_sale_ar = PEO_getAuctionSale();
    if ($info_ar['auction_sale'] == $auction_sale_ar['private_sale']) {
        $title = Localizer::translate('FOR SALE') . ' : ' . $info_ar['suburb'];
    }
    $isBlock = PE_isTheBlock($id) ? 1 : 0;
    $ofAgent = PE_isTheBlock($id, 'agent') ? 1 : 0;
    if ($isBlock || $ofAgent) {
        $agent = A_getCompanyInfo($id);
    }
    if ($info_ar['auction_sale'] == $auction_sale_ar['auction']
        && $info_ar['end_time'] != '0000-00-00 00:00:00'
        && $info_ar['start_time'] != '0000-00-00 00:00:00'
    ) { //LIVE AUCTION OR FORTHCOMING
        $dt = new DateTime($info_ar['end_time']);
        $end_time = $dt->format($config_cls->getKey('general_date_format'));
        $dt = new DateTime($info_ar['start_time']);
        $current_time = new DateTime(date('Y-m-d H:i:s'));
        if ($dt > $current_time
            || ($info_ar['confirm_sold'] == Property::SOLD_COMPLETE
                && $info_ar['sold_time'] < $info_ar['start_time'])
        ) { //FORTHCOMING
            $title = Localizer::translate('FORTHCOMING') . ':' . $end_time;
        } else { //LIVE AUCTION
            $title = Localizer::translate('AUCTION ENDS') . ': ' . $end_time;
            if ($info_ar['end_time'] < date('Y-m-d H:i:s'))
                $title = Localizer::translate('AUCTION ENDED') . ': ' . $end_time;
        }
    } elseif ($info_ar['auction_sale'] == $auction_sale_ar['auction']
        && $info_ar['end_time'] == '0000-00-00 00:00:00'
        && $info_ar['start_time'] == '0000-00-00 00:00:00'
    ) {
        $title = Localizer::translate('AUCTION') . ': ' . $info_ar['suburb'];
    }
    if ($isBlock) {
        $title = Localizer::translate('OWNER') . ': ' . $info_ar['owner'];
    }
    if ($ofAgent) {
        $title = Localizer::translate('OWNER') . ': ' . $agent['company_name'];
    }
    return $title;
}

function Property_isLockBid($property_id)
{
    global $property_cls;
    $row = $property_cls->getCRow(array('lock_bid'), 'property_id = ' . $property_id);
    if (is_array($row) and count($row) > 0) {
        return (int)@$row['lock_bid'];
    }
    return 0;
}

function Property_afterSold($property_id)
{
    global $config_cls, $property_provider_email_cls;
    if ($property_id > 0) {
        $from = $config_cls->getKey('general_contact_email');
        $to = array($config_cls->getKey('general_alert_post_email'));
        $subject = $config_cls->getKey('email_admin_sold_msg_subject');
        $subject = str_replace(array('{property_id}', '[ID]'), array($property_id, $property_id), $subject);
        $message = $config_cls->getKey('email_admin_sold_msg');
        $message = str_replace(array('{property_id}', '[ID]'), array($property_id, $property_id), $message);
        //$agent = PE_getAgent(0, $property_id);
        sendEmail_func($from, $to, $message, $subject);
        /*https://peteburley.atlassian.net/browse/NI-237*/
        $general_service_provider_email = $config_cls->getKey('general_service_provider_email');
        $provider_email = $property_provider_email_cls->getRow('property_id = ' . $property_id);
        if (is_array($provider_email) & count($provider_email) > 0) {
            sendEmail_func($from, $provider_email['email'], $message, $subject);
        } else if (strlen($general_service_provider_email) > 0) {
            sendEmail_func($from, $general_service_provider_email, $message, $subject);
        }
        /**/
    }
}

function Property_sendWinner($data)
{
    global $config_cls;
    $row = Bid_getLastBidByPropertyId((int)$data['property_id']);
    if (count($row) > 0 and is_array($row)) {
        $winner_email = A_getEmail($row['agent_id']);
        $winner_name = A_getFullName($row['agent_id']);
        $address = PE_getAddressProperty($data['property_id']);
        $lkB = getBannerByPropertyId($data['property_id']);
        $msg = $config_cls->getKey('email_winner_stop_bid_msg');
        $msg = str_replace(array('[ID]', '[address]', '[winner_name]'), array($data['property_id'], $address, $winner_name), $msg);
        $email_from = $config_cls->getKey('general_contact_email');
        $subject = $config_cls->getKey('email_winner_stop_bid_msg_subject');
        $subject = str_replace(array('[ID]', '[address]', '[winner_name]'), array($data['property_id'], $address, $winner_name), $subject);
        //sendEmail($email_from, $winner_email, $msg, $subject, $lkB);
        /*To: Vendor, Landlord, Agent, Lawyer*/
        $agent = PE_getAgent(0, $data['property_id']);
        $params_email = array('to' => ($agent['email_address']), 'property_id' => $data['property_id']);
        $bank_info = PE_getBankInfo($data['property_id']);
        $variables = array('[name]' => $bank_info['name'], '[bsb]' => $bank_info['bsb'], '[number]' => $bank_info['number']);
        sendNotificationByEventKey('user_sold_or_leased', $params_email, $variables);
        /*To: buyer (successful bidder)*/
        $params_email = array('to' => ($winner_email), 'property_id' => $data['property_id']);
        sendNotificationByEventKey('user_sold_or_leased_buyer', $params_email, $variables);
        /*To: all registered bidders*/
        /*To: users with property in watch list*/
    }
}

function PEO_getTitleOfAuctionSaleFromCode($code, $property_id)
{
    $auction_sale_ar = PEO_getAuctionSale();
    $result = PEO_getTitleOfAuctionSale($auction_sale_ar[$code], $property_id);
    return $result;
}

function PEO_getTitleOfAuctionSale($auction_sale, $property_id)
{
    $auction_sale_ar = PEO_getAuctionSale();
    $code_arr = PEO_getOptionById($auction_sale);
    $result = $code_arr['title'];
    if (!PE_isTheBlock($property_id, 'agent') && $auction_sale == $auction_sale_ar['auction']) {
        $result = 'Auction';
    }
    return $result;
}

function PEO_getCodeAuctionSale($property_id)
{
    global $property_cls, $property_entity_option_cls;
    $row = $property_cls->getRow("SELECT pro_opt4.code
								  FROM " . $property_entity_option_cls->getTable() . " AS pro_opt4
								  LEFT JOIN " . $property_cls->getTable() . " AS pro ON pro_opt4.property_entity_option_id = pro.auction_sale
								  WHERE pro.property_id = {$property_id}", true);
    if (is_array($row) and count($row) > 0) {
        return $row['code'];
    }
    return '';
}

function PE_isNoMoreBid($property_id)
{
    global $bids_stop_cls, $bids_first_cls;
    $stop = $bids_stop_cls->getRow('SELECT count(agent_id) AS count FROM ' . $bids_stop_cls->getTable() . ' WHERE property_id =' . $property_id, true);
    $registered = $bids_first_cls->getRow('SELECT count(agent_id) AS count FROM ' . $bids_first_cls->getTable() . ' WHERE property_id = ' . $property_id . ' AND pay_bid_first_status > 0', true);
    $count_stop = (is_array($stop) && count($stop > 0)) ? $stop['count'] : 0;
    $count_registered = (is_array($registered) && count($registered > 0)) ? $registered['count'] : 0;
    return $count_stop == $count_registered && $count_registered > 0;
}

function DO_getRequireDocumentList_old($property_id)
{
    global $document_cls;
    $document_rows = $document_cls->getRows('1 ORDER BY a.`order` ASC');
    $document_id_str = PK_getAttribute('document_ids', $property_id);
    $documents = array();
    if ($document_id_str != 'all') {
        $document_id_ar = explode(',', $document_id_str);
        foreach ($document_rows as $document) {
            if (in_array($document['document_id'], $document_id_ar) && $document['require'] == 1) {
                $documents[] = $document['document_id'];
            }
        }
    }
    return $documents;
}

function DO_getRequireDocumentList($property_id)
{
    global $document_cls;
    $document_rows = $document_cls->getRows('1 ORDER BY a.`order` ASC');
    $document_ids = PA_getDocumentIds($property_id);
    $documents = array();
    foreach ($document_rows as $row) {
        if ($row['require'] == 1 and in_array($row['document_id'], $document_ids)) {
            $documents[] = $row['document_id'];
        }
    }
    return $documents;
}

function DO_getDocumentInfo($document_id)
{
    global $document_cls;
    $document_row = $document_cls->getRow('document_id = ' . $document_id);
    if (is_array($document_row) and count($document_row) > 0) {
        return $document_row;
    }
    return null;
}

function DO_getTermDocument($property_id)
{
    global $document_cls, $property_document_cls;
    $document_row = $property_document_cls->getRow('SELECT * FROM ' . $property_document_cls->getTable() . ' AS pdoc
                                                    LEFT JOIN ' . $document_cls->getTable() . ' AS doc ON pdoc.document_id = doc.document_id
                                                    WHERE pdoc.property_id = ' . $property_id . ' AND doc.is_term = 1', true);
    return $document_row;
}

function DO_getTermDownload($property_id)
{
    global $config_cls, $document_cls, $property_document_cls;
    $termDoc = DO_getTermDocument($property_id);
    if (is_array($termDoc) and count($termDoc) > 0) {
        $file_name = $termDoc['file_name'];
        $path_file = ROOTURL . '/' . trim($file_name, '/');
    } else {
        $file_name = $config_cls->getKey('termdoc_filename');
        $path_file = ROOTURL . '/' . trim($file_name, '/');
    }
    return $path_file;
}

function Property_getDetailForPDF($id)
{
    global $config_cls, $agent_cls, $property_term_cls, $bids_first_cls, $auction_term_cls, $agent_payment_cls, $property_cls,
           $agent_logo_cls, $property_entity_option_cls, $bid_first_cls, $region_cls, $smarty;
    $count = array();
    $count['once'] = $config_cls->getKey('count_going_once');
    $count['twice'] = $config_cls->getKey('count_going_twice');
    $count['third'] = $config_cls->getKey('count_going_third');
    $auction_sale_ar = PEO_getAuctionSale();
    if (isset($_SESSION['require']['Bid_addByBidder'])) {
        $output = Bid_isValid((int)$_SESSION['agent']['id'], $id);
        if (!@$output['error']) {
            Bid_addByBidder((int)$_SESSION['agent']['id'], $id);
        }
        unset($_SESSION['require']['Bid_addByBidder']);
    }
    //BEGIN FOR PROPERTY
    if (!isset($_SESSION['agent']['id'])) $_SESSION['agent']['id'] = 0;
    //BEGIN SQL FOR CHECK ACTIVE
    $_active = " pro.pay_status = " . Property::CAN_SHOW . '
                    AND IF (pro.auction_sale != ' . $auction_sale_ar['private_sale'] . ',
                           (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\'
                                   ,0
                                   ,pro_term.value)
                           FROM ' . $property_term_cls->getTable() . ' AS pro_term
                           LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
                           ON pro_term.auction_term_id = term.auction_term_id
                           WHERE term.code = \'auction_start_price\'
                           AND pro.property_id = pro_term.property_id ) != 0
                    , 1)
                    AND pro.active = 1
                    AND pro.agent_active = 1';
    //BEGIN FOR LOCK THE BLOCK PROPERTY: NHUNG
    $wh_arr = array();
    $date_lock = (int)$config_cls->getKey('date_lock');
    if (isset($_SESSION['agent']) and $_SESSION['agent']['id'] > 0) {
        //agent is the block/is not the block
        $lock_str = "  IF(
                                (SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at WHERE agt.type_id = at.agent_type_id) IN ('theblock'),

                                (SELECT p.pay_bid_first_status FROM " . $bids_first_cls->getTable() . " AS p
                                 WHERE p.property_id = pro.property_id AND p.agent_id = " . $_SESSION['agent']['id'] . ")> 0
                                 OR '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY),pro.date_to_reg_bid)
                                 OR (IF(ISNULL(pro.agent_manager)
                                        OR pro.agent_manager = 0
                                        ,pro.agent_id = {$_SESSION['agent']['id']}
                                        , pro.agent_manager = '{$_SESSION['agent']['id']}')
                                     || pro.agent_id IN (SELECT a.agent_id FROM agent AS a WHERE a.parent_id = {$_SESSION['agent']['id']})
                                     || (pro.agent_id = '{$_SESSION['agent']['id']}' AND agt.parent_id = 0))

                                ,IF (pro.agent_id = {$_SESSION['agent']['id']},1, {$_active}))";
    } else {
        $lock_str = " IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at
                                  WHERE agt.type_id = at.agent_type_id) IN ('theblock'),
                                  '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY),pro.date_to_reg_bid),1) = 1
                          AND {$_active}";
    }
    //IBB-1224: unlock/lock the block properties after the auctions
    $lock_status = (int)$config_cls->getKey('theblock_status');
    if ($lock_status == 0) { //unlock
        $lock_type = $config_cls->getKey('theblock_show_type_properties');
        $lock_type_ar = explode(',', $lock_type);
        $unlock_str = 1;
        if (count($lock_type_ar) > 0) {
            foreach ($lock_type_ar as $type) {
                switch ($type) {
                    case 'sold':
                        $unlock_arr[] = "pro.confirm_sold = 1";
                        break;
                    case 'passed_in':
                        $unlock_arr[] = "(pro.confirm_sold = 0 AND pro.stop_bid = 1)";
                        break;
                    case 'live':
                        $unlock_arr[] = "(pro.end_time > '" . date('Y-m-d H:i:s') . "'
                                              AND pro.confirm_sold = 0
                                              AND pro.stop_bid = 0
                                              AND pro.end_time > pro.start_time
                                              AND pro.start_time <= '" . date('Y-m-d H:i:s') . "')";
                        break;
                    case 'forthcoming':
                        $unlock_arr[] = "(pro.start_time > '" . date('Y-m-d H:i:s') . "'
                                              AND pro.confirm_sold = 0
                                              AND pro.stop_bid = 0)";
                        break;
                }
            }
            $_unlock_str = ' OR ' . implode(' OR ', $unlock_arr);
            if (isset($_SESSION['agent']) and $_SESSION['agent']['id'] > 0) {
                $unlock_str = " IF(
                                        (SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at WHERE agt.type_id = at.agent_type_id) IN ('theblock'),

                                        (SELECT p.pay_bid_first_status FROM " . $bids_first_cls->getTable() . " AS p
                                         WHERE p.property_id = pro.property_id AND p.agent_id = " . $_SESSION['agent']['id'] . ")> 0
                                         OR '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY),pro.date_to_reg_bid)
                                         OR (IF(ISNULL(pro.agent_manager)
                                                OR pro.agent_manager = 0
                                                ,pro.agent_id = {$_SESSION['agent']['id']}
                                                , pro.agent_manager = '{$_SESSION['agent']['id']}')
                                             || pro.agent_id IN (SELECT a.agent_id FROM agent AS a WHERE a.parent_id = {$_SESSION['agent']['id']})
                                             || (pro.agent_id = '{$_SESSION['agent']['id']}' AND agt.parent_id = 0))
                                         {$_unlock_str}

                                        ,IF (pro.agent_id = {$_SESSION['agent']['id']},1, {$_active}))";
            } else {
                $unlock_str = "
                                       IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at
                                           WHERE agt.type_id = at.agent_type_id) IN ('theblock'),
                                          '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,
                                                                         DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY)
                                                                         ,pro.date_to_reg_bid)
                                          {$_unlock_str}
                                          ,IF (pro.agent_id = {$_SESSION['agent']['id']},1, {$_active}))
                                       ";
            }
        }
        $date_open_lock = $config_cls->getKey('theblock_date_lock');
        $wh_arr[] = " IF ('" . date('Y-m-d H:i:s') . "' < '" . $date_open_lock . "',{$lock_str},{$unlock_str})";
    } else {
        $wh_arr[] = $lock_str;
    }
    //HIDE AGENT's PROPERTIES DIDN'T PAYMENT
    if (isset($_SESSION['agent']) and $_SESSION['agent']['id'] > 0) {
        $isVendorOfPro = Property_isVendorOfProperty($id) ? 1 : 0;
        $wh_arr[] = " IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at
                                       WHERE agt.type_id = at.agent_type_id) IN ('agent')
                                       ,(SELECT ap.payment_id FROM " . $agent_payment_cls->getTable() . " AS ap
                                         WHERE ap.agent_id = IF(agt.parent_id = '',agt.agent_id,agt.parent_id)
                                               AND ap.date_from <= '" . date('Y-m-d H:i:s') . "' AND ap.date_to >= '" . date('Y-m-d H:i:s') . "'
                                         ) != '' OR {$isVendorOfPro}
                                       ,1)";
    } else {
        $wh_arr[] = " IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at
                                       WHERE agt.type_id = at.agent_type_id) IN ('agent')
                                       ,(SELECT ap.payment_id FROM " . $agent_payment_cls->getTable() . " AS ap
                                         WHERE ap.agent_id = IF(agt.parent_id = '',agt.agent_id,agt.parent_id)
                                               AND ap.date_from <= '" . date('Y-m-d H:i:s') . "' AND ap.date_to >= '" . date('Y-m-d H:i:s') . "'
                                         ) != ''
                                       ,1)";
    }
    //DON'T ALLOW SHOW PROPERTIES OF INACTIVE AGENT
    $wh_arr[] = " IF(ISNULL(pro.agent_manager) || pro.agent_manager = '' || pro.agent_manager = 0
                        , agt.is_active = 1
                        ,(SELECT a.is_active FROM " . $agent_cls->getTable() . " AS a WHERE a.agent_id = pro.agent_manager) = 1)
                        ";
    $wh_arr[] = " IF(pro.agent_id = " . $_SESSION['agent']['id'] . ", 1 , pro.active = 1 AND pro.agent_active = 1 AND pro.pay_status = " . Property::PAY_COMPLETE . " ) ";
    $wh_str = count($wh_arr) > 0 ? ' AND ' . implode(' AND ', $wh_arr) : '';
    $row = $property_cls->getRow('SELECT pro.property_id,
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
											open_for_inspection,
											pro.stop_bid,
											pro.confirm_sold,
											pro.sold_time,
											pro.land_size,
											pro.pay_status,
											pro.auction_blog,
											pro.livability_rating_mark,
											pro.green_rating_mark,
											pro.owner,
											pro.agent_manager,
											agt.type_id,
											pro.agent_active,
											pro.active,
											pro.set_count,
											pro.min_increment,
											pro.max_increment,
											pro.autobid_enable,
											pro.price_on_application,
											pro.show_agent_logo,

											(SELECT l.logo
											FROM ' . $agent_logo_cls->getTable() . ' AS l
											WHERE l.agent_id = IF(pro.agent_manager = \'\' OR ISNULL(pro.agent_manager),pro.agent_id,pro.agent_manager)
											) AS logo,

											(SELECT SUM(pro_log.view)
											FROM ' . $property_cls->getTable('property_log') . ' AS pro_log
											WHERE pro_log.property_id = pro.property_id
											)AS views,

											(SELECT reg1.name
											FROM ' . $region_cls->getTable() . ' AS reg1
											WHERE reg1.region_id = pro.state
											) AS state_name,

											(SELECT reg2.code
											FROM ' . $region_cls->getTable() . ' AS reg2
											WHERE reg2.region_id = pro.state
											) AS state_code,

											(SELECT reg3.name
											FROM ' . $region_cls->getTable() . ' AS reg3
											WHERE reg3.region_id = pro.country
											) AS country_name,

											(SELECT reg4.code
											FROM ' . $region_cls->getTable() . ' AS reg4
											WHERE reg4.region_id = pro.country
											) AS country_code,

											(SELECT pro_opt1.value
											FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt1
											WHERE pro_opt1.property_entity_option_id = pro.bathroom
											) AS bathroom_value,

											(SELECT pro_opt2.value
											FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt2
											WHERE pro_opt2.property_entity_option_id = pro.bedroom
											) AS bedroom_value,

											(SELECT pro_opt3.value
											FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt3
											WHERE pro_opt3.property_entity_option_id = pro.car_port
											) AS carport_value,

											(SELECT pro_opt6.title
											FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt6
											WHERE pro_opt6.property_entity_option_id = pro.type
											) AS type_name,
                                            (SELECT pro_opt8.value
                                            FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt8
                                            WHERE pro_opt8.property_entity_option_id = pro.car_space
                                            ) AS carspace_value,
											(SELECT count(*)
											FROM ' . $property_cls->getTable('bids') . ' AS bid
											WHERE bid.property_id = pro.property_id
											) AS bids,


											(SELECT pro_opt6.title
                                                    FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt6
                                                    WHERE pro_opt6.property_entity_option_id = pro.period
                                                    ) AS period,

											(SELECT CASE
                                                WHEN pro.auction_sale != ' . $auction_sale_ar['private_sale'] . '
                                                     AND ( date(pro.start_time) > \'' . date('Y-m-d H:i:s') . '\' OR isnull(max(bid.price)) ) THEN
                                                    (SELECT pro_term.value
                                                     FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
                                                     LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
                                                        ON pro_term.auction_term_id = term.auction_term_id
                                                     WHERE term.code = \'auction_start_price\'
                                                            AND pro.property_id = pro_term.property_id)
                                                WHEN auction_sale = ' . $auction_sale_ar['private_sale'] . ' AND pro.price != 0 THEN pro.price
                                                WHEN auction_sale = ' . $auction_sale_ar['private_sale'] . ' AND pro.price = 0 AND pro.price_on_application != 0 THEN pro.price_on_application
                                            ELSE max(bid.price)
                                            END
                                            FROM bids AS bid WHERE bid.property_id = pro.property_id) AS price


									FROM ' . $property_cls->getTable() . ' AS pro
									INNER JOIN ' . $property_cls->getTable('agent') . ' AS agt ON pro.agent_id = agt.agent_id

									WHERE pro.property_id = ' . $id
        . $wh_str . '

                                    ORDER BY pro.confirm_sold, pro.stop_bid, pro.property_id DESC'
        , true);
    $data = array();
    if ($property_cls->hasError()) {
    } else if (is_array($row) && count($row) > 0) {
        $data['info'] = $row;
        $data['info']['completed'] = $row['active'] == 1 AND $row['agent_active'] == 1 AND $row['pay_status'] == Property::PAY_COMPLETE;
        $data['info']['description'] = nl2br($row['description']);
        $type = PEO_getOptionById($row['auction_sale']);
        $data['info']['pro_type_code'] = $type['code'];
        //$meta_description = $data['info']['meta_description'] = htmlentities($row['description']);
        /*IBB-1152: NHUNG
        Fix the Facebook post description*/
        $link_ar = array('module' => 'property',
            'action' => '',
            'id' => $row['property_id']);
        $link_ar['action'] = 'view-auction-detail';
        $meta_description = $data['info']['meta_description'] = strip_tags($row['description']);
        //$data['link'] = shortUrl($link_ar + array('data' => $row),
        //                         (PE_isTheBlock($row['property_id'],'agent')?Agent_getAgent($row['property_id']):array()));
        //print_r($row['livability_rating_mark'].','.$row['green_rating_mark']);
        //$data['info']['livability_rating_mark'] = showStar((float)$row['livability_rating_mark']);
        //$data['info']['green_rating_mark'] = showStar((float)$row['green_rating_mark']);
        //get data contact form
        //$data['contact_info'] = PE_getAgent($row['agent_id']);
        $data['info']['carport_value_'] = $data['info']['carport_value'];
        if ($data['info']['carport_value'] == null AND $data['info']['parking'] == 1) {
            $data['info']['carport_value'] = $data['info']['carspace_value'];
        }
        $data['info']['address_full'] = implode(', ', array($row['address'], $row['suburb'], $row['state_name'], $row['postcode'], $row['country_name']));
        $data['info']['address_short'] = strlen($data['info']['address_full']) > 30 ? substr($data['info']['address_full'], 0, 27) . ' ...' : $data['info']['address_full'];
        //$data['info']['o4i'] = Calendar_createPopup($row['property_id'], $row['open_for_inspection'], 'grid');
        //$googleAddress = str_replace(' ','+',$data['info']['address_full']);
        //$smarty->assign('new_address',$googleAddress);
        //pay_status
        $_meta_desc_ar = array();
        $_meta_desc_ar[] = $data['info']['pro_type'];
        $_meta_desc_ar[] = $data['info']['address_full'];
        $_meta_desc_ar[] = $data['info']['type_name'];
        $_meta_desc_ar[] = ' Bed room :' . $data['info']['bedroom_value'];
        $_meta_desc_ar[] = ' Bath room :' . $data['info']['bathroom_value'];
        $_meta_desc_ar[] = ' Car port :' . $data['info']['carport_value'];
        if (isset($site_title)) {
            $site_title = $site_title . ' / ' . $data['info']['address_full'];
        }
        $site_meta_key = implode(' / ', $_meta_desc_ar);
        $site_meta_description = htmlentities(implode(' / ', $_meta_desc_ar));
        //$data['info']['next'] = PE_navLink('next', $row['property_id'], $row['auction_sale'], $data['info']['pro_type']);
        //$data['info']['prev'] = PE_navLink('prev', $row['property_id'], $row['auction_sale'], $data['info']['pro_type']);
        /*Quan*/
        //$data['info']['next_link'] = PE_navLink_new('next', $row['property_id']);
        //$data['info']['prev_link'] = PE_navLink_new('prev', $row['property_id']);
        /*Print Page*/
        //$data['info']['landsize'] = trim(str_replace('m2','',$row['land_size']));
        $data['info']['link'] = shortUrl($link_ar + array('data' => $row), (PE_isTheBlock($row['property_id'], 'agent') ? Agent_getAgent($row['property_id']) : array()));
        //BEGIN FOR DOCUMENT
        //$data['docs'] = PD_getDocs($row['property_id']);
        //END
        $data['info']['short_description'] = strlen(safecontent($row['description'], 400)) > 400 ? safecontent($row['description'], 400) . '...' : $row['description'];
        //BEGIN FOR MEDIA
        $_photo = PM_getPhoto($row['property_id'], true);
        //$data['photo'] = $_photo['photo'];
        $data['photo'] = $_photo['photo_thumb'];
        $data['photo_default'] = $_photo['photo_default'];
        if (count($data['photo']) == 0) {
            $data['info']['photo_default'] = $_photo['photo_default_detail'];
        }
        $data['info']['photo_facebook'] = $data['photo_default'];
        //END MEDIA
    }
    return $data;
}

/*
 * Can we confirm the status options for properties, against REA xml req.
 I would like to add a new status, and banners to reflect real status of property, as per our xml feed setup can we have the following statuses available for each property.
- current (REA xml req) - we have ? The property has not yet been sold (or leased), and is still on offer.
- sold (REA xml req) - we have ? The property has been sold.
- leased (REA xml req) - we have ? The property has been leased.
- passed in - we have? the property has passed in post auction.
- under offer - new - once an offer (or buy it now) is accepted via bidRhino, by vendor/agent, the property should be listed as "under offer" with a banner, as well as a stutus in db.
- withdrawn (REA xml req) - do we have this already? - The property is withdrawn from the market for whatever reason.
- offmarket (REA xml req) - do we have this already? - This property is not currently on the market.
 *
 * */
function PE_getPropertyStatusREA_xml($property_id = 0)
{
    global $config_cls, $agent_cls, $property_term_cls, $bids_first_cls, $auction_term_cls, $agent_payment_cls, $property_cls,
           $agent_logo_cls, $property_entity_option_cls, $bid_first_cls, $region_cls, $smarty;
    $status_ar = array(
        'current' => 'current',
        'sold' => 'sold',
        'leased' => 'leased',
        'passed-in' => 'passed in',
        'under-offer' => 'under offer',
        'withdrawn' => 'withdrawn',
        'offmarket' => 'offmarket');
    $auction_sale_ar = PEO_getAuctionSale();
    if ($property_id > 0) {
        $row = $property_cls->getRow('SELECT pro.property_id,
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
											open_for_inspection,
											pro.stop_bid,
											pro.confirm_sold,
											pro.sold_time,
											pro.land_size,
											pro.pay_status,
											pro.auction_blog,
											pro.livability_rating_mark,
											pro.green_rating_mark,
											pro.owner,
											pro.agent_manager,
											agt.type_id,
											pro.agent_active,
											pro.active,
											pro.set_count,
											pro.min_increment,
											pro.max_increment,
											pro.autobid_enable,
											pro.price_on_application,
											pro.show_agent_logo,
											pro.buynow_price,
                                            pro.buynow_buyer_id,
                                            pro.withdrawn,
                                            pro.underoffer,

											(SELECT l.logo
											FROM ' . $agent_logo_cls->getTable() . ' AS l
											WHERE l.agent_id = IF(pro.agent_manager = \'\' OR ISNULL(pro.agent_manager),pro.agent_id,pro.agent_manager)
											) AS logo,

											(SELECT SUM(pro_log.view)
											FROM ' . $property_cls->getTable('property_log') . ' AS pro_log
											WHERE pro_log.property_id = pro.property_id
											)AS views,

											(SELECT reg1.code
											FROM ' . $region_cls->getTable() . ' AS reg1
											WHERE reg1.region_id = pro.state
											) AS state_code,

											(SELECT reg2.code
											FROM ' . $region_cls->getTable() . ' AS reg2
											WHERE reg2.region_id = pro.state
											) AS state_code,

											(SELECT reg3.name
											FROM ' . $region_cls->getTable() . ' AS reg3
											WHERE reg3.region_id = pro.country
											) AS country_name,

											(SELECT reg4.code
											FROM ' . $region_cls->getTable() . ' AS reg4
											WHERE reg4.region_id = pro.country
											) AS country_code,

											(SELECT pro_opt1.value
											FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt1
											WHERE pro_opt1.property_entity_option_id = pro.bathroom
											) AS bathroom_value,

											(SELECT pro_opt2.value
											FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt2
											WHERE pro_opt2.property_entity_option_id = pro.bedroom
											) AS bedroom_value,

											(SELECT pro_opt3.value
											FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt3
											WHERE pro_opt3.property_entity_option_id = pro.car_port
											) AS carport_value,

											(SELECT pro_opt6.title
											FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt6
											WHERE pro_opt6.property_entity_option_id = pro.type
											) AS type_name,
                                            (SELECT pro_opt8.value
                                            FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt8
                                            WHERE pro_opt8.property_entity_option_id = pro.car_space
                                            ) AS carspace_value,
											(SELECT count(*)
											FROM ' . $property_cls->getTable('bids') . ' AS bid
											WHERE bid.property_id = pro.property_id
											) AS bids,


											(SELECT pro_opt6.title
                                                    FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt6
                                                    WHERE pro_opt6.property_entity_option_id = pro.period
                                                    ) AS period,

											(SELECT CASE
                                                WHEN pro.auction_sale != ' . $auction_sale_ar['private_sale'] . '
                                                     AND ( date(pro.start_time) > \'' . date('Y-m-d H:i:s') . '\' OR isnull(max(bid.price)) ) THEN
                                                    (SELECT pro_term.value
                                                     FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
                                                     LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
                                                        ON pro_term.auction_term_id = term.auction_term_id
                                                     WHERE term.code = \'auction_start_price\'
                                                            AND pro.property_id = pro_term.property_id)
                                                WHEN auction_sale = ' . $auction_sale_ar['private_sale'] . ' AND pro.price != 0 THEN pro.price
                                                WHEN auction_sale = ' . $auction_sale_ar['private_sale'] . ' AND pro.price = 0 AND pro.price_on_application != 0 THEN pro.price_on_application
                                            ELSE max(bid.price)
                                            END
                                            FROM bids AS bid WHERE bid.property_id = pro.property_id) AS price


									FROM ' . $property_cls->getTable() . ' AS pro
									INNER JOIN ' . $property_cls->getTable('agent') . ' AS agt ON pro.agent_id = agt.agent_id

									WHERE pro.property_id = ' . $property_id, true);
        if ($property_cls->hasError()) {
        } else if (is_array($row) && count($row) > 0) {
            /*
                * Can we confirm the status options for properties, against REA xml req.
                I would like to add a new status, and banners to reflect real status of property, as per our xml feed setup can we have the following statuses available for each property.
                - current (REA xml req) - we have ? The property has not yet been sold (or leased), and is still on offer.
                - sold (REA xml req) - we have ? The property has been sold.
                - leased (REA xml req) - we have ? The property has been leased.
                - passed in - we have? the property has passed in post auction.
                - under offer - new - once an offer (or buy it now) is accepted via bidRhino, by vendor/agent, the property should be listed as "under offer" with a banner, as well as a stutus in db.
                - withdrawn (REA xml req) - do we have this already? - The property is withdrawn from the market for whatever reason.
                - offmarket (REA xml req) - do we have this already? - This property is not currently on the market.
                 *
                 *
             * */
            if ($row['withdrawn'] == 1) {
                $status = $status_ar['withdrawn'];
                return $status;
            }
            /*sold-leased*/
            if ($row['confirm_sold'] == $property_cls::SOLD_COMPLETE) {
                $type = PEO_getOptionById($row['auction_sale']);
                $row['pro_type_code'] = $type['code'];
                $status = in_array($row['pro_type_code'], array('ebiddar', 'bid2stay')) ? $status_ar['leased'] : $status_ar['sold'];
                return $status;
            }
            /*offmarket*/
            if ($row['active'] == 0 || $row['agent_active'] == 0 || $row['pay_status'] != $property_cls::PAY_COMPLETE) {
                $status = $status_ar['offmarket'];
                return $status;
            }
            if (/*PE_isLiveProperty($property_id)*/
            true
            ) {
                /*underoffer*/
                $lastBid_row = Bid_getLastBidByPropertyId($property_id);
                if (/*isset($lastBid_row['is_offer']) && $lastBid_row['is_offer'] == 1 && */
                    $row['underoffer'] == 1
                ) {
                    $status = $status_ar['under-offer'];
                    return $status;
                }
            }
            $start_price = PT_getValueByCode($row['property_id'], 'auction_start_price');
            $reserve_price = PT_getValueByCode($row['property_id'], 'reserve');
            $row['check_start'] = ($start_price == $row['price']) ? true : false;
            $row['ofAgent'] = PE_isTheBlock($row['property_id'], 'agent') ? 1 : 0;
            if ((($row['price'] < $reserve_price
                        OR (Bid_isLastBidVendor($row['property_id']) AND $row['price'] >= $reserve_price)
                        OR ($row['price_on_application'] > 0)
                        OR ($row['price'] >= $reserve_price AND $row['check_start'])
                    )
                    AND ($row['stop_bid'] == 1 OR $row['end_time'] < date('Y-m-d H:i:s'))
                )
                OR ($row['ofAgent'] && $row['stop_bid'] == 1)
            ) {
                $status = $status_ar['passed-in'];
                return $status;
            }
            if (PE_isLiveProperty($property_id)) {
                $status = $status_ar['current'];
                return $status;
            } else {
                $status = $status_ar['offmarket'];
                return $status;
            }
        }
    }
    return 'withdrawn';
}

function PE_isRentProperty($property_id = 0)
{
    global $property_cls;
    if ($property_id > 0) {
        $auction_sale_options = PEO_getAuctionSale();
        $row = $property_cls->getCRow(array('auction_sale'), 'property_id=' . $property_id);
        if (count($row) > 0 and is_array($row) and $row['auction_sale'] == $auction_sale_options['ebiddar']) {
            return true;
        }
    }
    return false;
}

function Property_getDetail($id)
{
    global $config_cls, $agent_cls, $property_term_cls, $bids_first_cls, $auction_term_cls, $agent_payment_cls, $property_cls,
           $agent_logo_cls, $property_entity_option_cls, $bid_first_cls, $region_cls, $smarty;
    $count = array();
    $count['once'] = $config_cls->getKey('count_going_once');
    $count['twice'] = $config_cls->getKey('count_going_twice');
    $count['third'] = $config_cls->getKey('count_going_third');
    $auction_sale_ar = PEO_getAuctionSale();
    if (isset($_SESSION['require']['Bid_addByBidder'])) {
        $output = Bid_isValid((int)$_SESSION['agent']['id'], $id);
        if (!@$output['error']) {
            Bid_addByBidder((int)$_SESSION['agent']['id'], $id);
        }
        unset($_SESSION['require']['Bid_addByBidder']);
    }
    //BEGIN FOR PROPERTY

    if (!isset($_SESSION['agent']['id'])) $_SESSION['agent']['id'] = 0;

    //BEGIN SQL FOR CHECK ACTIVE
    /*$_active = " pro.pay_status = " . Property::CAN_SHOW . '
                    AND IF (pro.auction_sale != ' . $auction_sale_ar['private_sale'] . ',
                           (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\'
                                   ,0
                                   ,pro_term.value)
                           FROM ' . $property_term_cls->getTable() . ' AS pro_term
                           LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
                           ON pro_term.auction_term_id = term.auction_term_id
                           WHERE term.code = \'auction_start_price\'
                           AND pro.property_id = pro_term.property_id ) != 0
                    , 1)
                    AND pro.active = 1
                    AND pro.agent_active = 1';
    //BEGIN FOR LOCK THE BLOCK PROPERTY: NHUNG
    $wh_arr = array();
    $date_lock = (int)$config_cls->getKey('date_lock');
    if (isset($_SESSION['agent']) and $_SESSION['agent']['id'] > 0) {
        //agent is the block/is not the block
        $lock_str = "  IF(
                            (SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at WHERE agt.type_id = at.agent_type_id) IN ('theblock'),

                            (SELECT p.pay_bid_first_status FROM " . $bids_first_cls->getTable() . " AS p
                             WHERE p.property_id = pro.property_id AND p.agent_id = " . $_SESSION['agent']['id'] . ")> 0
                             OR '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY),pro.date_to_reg_bid)
                             OR (IF(ISNULL(pro.agent_manager)
                                    OR pro.agent_manager = 0
                                    ,pro.agent_id = {$_SESSION['agent']['id']}
                                    , pro.agent_manager = '{$_SESSION['agent']['id']}')
                                 || pro.agent_id IN (SELECT a.agent_id FROM agent AS a WHERE a.parent_id = {$_SESSION['agent']['id']})
                                 || (pro.agent_id = '{$_SESSION['agent']['id']}' AND agt.parent_id = 0))

                            ,IF (pro.agent_id = {$_SESSION['agent']['id']},1, {$_active}))";
    } else {
        $lock_str = " IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at
                                  WHERE agt.type_id = at.agent_type_id) IN ('theblock'),
                                  '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY),pro.date_to_reg_bid),1) = 1
                          AND {$_active}";
    }
    //IBB-1224: unlock/lock the block properties after the auctions
    $lock_status = (int)$config_cls->getKey('theblock_status');
    if ($lock_status == 0) { //unlock
        $lock_type = $config_cls->getKey('theblock_show_type_properties');
        $lock_type_ar = explode(',', $lock_type);
        $unlock_str = 1;
        if (count($lock_type_ar) > 0) {
            foreach ($lock_type_ar as $type) {
                switch ($type) {
                    case 'sold':
                        $unlock_arr[] = "pro.confirm_sold = 1";
                        break;
                    case 'passed_in':
                        $unlock_arr[] = "(pro.confirm_sold = 0 AND pro.stop_bid = 1)";
                        break;
                    case 'live':
                        $unlock_arr[] = "(pro.end_time > '" . date('Y-m-d H:i:s') . "'
                                              AND pro.confirm_sold = 0
                                              AND pro.stop_bid = 0
                                              AND pro.end_time > pro.start_time
                                              AND pro.start_time <= '" . date('Y-m-d H:i:s') . "')";
                        break;
                    case 'forthcoming':
                        $unlock_arr[] = "(pro.start_time > '" . date('Y-m-d H:i:s') . "'
                                              AND pro.confirm_sold = 0
                                              AND pro.stop_bid = 0)";
                        break;
                }
            }
            $_unlock_str = ' OR ' . implode(' OR ', $unlock_arr);
            if (isset($_SESSION['agent']) and $_SESSION['agent']['id'] > 0) {
                $unlock_str = " IF(
                                        (SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at WHERE agt.type_id = at.agent_type_id) IN ('theblock'),

                                        (SELECT p.pay_bid_first_status FROM " . $bids_first_cls->getTable() . " AS p
                                         WHERE p.property_id = pro.property_id AND p.agent_id = " . $_SESSION['agent']['id'] . ")> 0
                                         OR '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY),pro.date_to_reg_bid)
                                         OR (IF(ISNULL(pro.agent_manager)
                                                OR pro.agent_manager = 0
                                                ,pro.agent_id = {$_SESSION['agent']['id']}
                                                , pro.agent_manager = '{$_SESSION['agent']['id']}')
                                             || pro.agent_id IN (SELECT a.agent_id FROM agent AS a WHERE a.parent_id = {$_SESSION['agent']['id']})
                                             || (pro.agent_id = '{$_SESSION['agent']['id']}' AND agt.parent_id = 0))
                                         {$_unlock_str}

                                        ,IF (pro.agent_id = {$_SESSION['agent']['id']},1, {$_active}))";
            } else {
                $unlock_str = "
                                       IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at
                                           WHERE agt.type_id = at.agent_type_id) IN ('theblock'),
                                          '" . date('Y-m-d H:i:s') . "' < IF(pro.date_to_reg_bid = '0000-00-00' OR DATE_FORMAT(pro.start_time,'%Y-%m-%d') < pro.date_to_reg_bid,
                                                                         DATE_SUB(pro.start_time,INTERVAL {$date_lock} DAY)
                                                                         ,pro.date_to_reg_bid)
                                          {$_unlock_str}
                                          ,IF (pro.agent_id = {$_SESSION['agent']['id']},1, {$_active}))
                                       ";
            }
        }
        $date_open_lock = $config_cls->getKey('theblock_date_lock');
        //$wh_arr[] = " IF ('" . date('Y-m-d H:i:s') . "' < '" . $date_open_lock . "',{$lock_str},{$unlock_str})";
    } else {
        //$wh_arr[] = $lock_str;
    }*/
    //HIDE AGENT's PROPERTIES DIDN'T PAYMENT
    /*if (isset($_SESSION['agent']) and $_SESSION['agent']['id'] > 0) {
        $isVendorOfPro = Property_isVendorOfProperty($id)?1:0;
        $wh_arr[] = " IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at
                                       WHERE agt.type_id = at.agent_type_id) IN ('agent')
                                       ,(SELECT ap.payment_id FROM " . $agent_payment_cls->getTable() . " AS ap
                                         WHERE ap.agent_id = IF(agt.parent_id = '',agt.agent_id,agt.parent_id)
                                               AND ap.date_from <= '" . date('Y-m-d H:i:s') . "' AND ap.date_to >= '" . date('Y-m-d H:i:s') . "'
                                         ) != '' OR {$isVendorOfPro}
                                       ,1)";
    }else{
       $wh_arr[] = " IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at
                                       WHERE agt.type_id = at.agent_type_id) IN ('agent')
                                       ,(SELECT ap.payment_id FROM " . $agent_payment_cls->getTable() . " AS ap
                                         WHERE ap.agent_id = IF(agt.parent_id = '',agt.agent_id,agt.parent_id)
                                               AND ap.date_from <= '" . date('Y-m-d H:i:s') . "' AND ap.date_to >= '" . date('Y-m-d H:i:s') . "'
                                         ) != ''
                                       ,1)";
    }*/
    //DON'T ALLOW SHOW PROPERTIES OF INACTIVE AGENT
    $wh_arr[] = " IF(ISNULL(pro.agent_manager) || pro.agent_manager = '' || pro.agent_manager = 0
                        , agt.is_active = 1
                        ,(SELECT a.is_active FROM " . $agent_cls->getTable() . " AS a WHERE a.agent_id = pro.agent_manager) = 1)
                        ";
    $wh_arr[] = " IF(pro.agent_id = " . $_SESSION['agent']['id'] . ", 1 , pro.active = 1 AND pro.agent_active = 1 AND pro.pay_status = " . Property::PAY_COMPLETE . " ) ";
    //print_r($wh_arr);die();
    $wh_str = count($wh_arr) > 0 ? ' AND ' . implode(' AND ', $wh_arr) : '';
    $row = $property_cls->getRow('SELECT pro.property_id,
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
											open_for_inspection,
											pro.stop_bid,
											pro.confirm_sold,
											pro.sold_time,
											pro.land_size,
											pro.pay_status,
											pro.auction_blog,
											pro.livability_rating_mark,
											pro.green_rating_mark,
											pro.owner,
											pro.agent_manager,
											agt.type_id,
											pro.agent_active,
											pro.active,
											pro.set_count,
											pro.min_increment,
											pro.max_increment,
											pro.autobid_enable,
											pro.price_on_application,
											pro.show_agent_logo,
											pro.buynow_price,
                                            pro.buynow_buyer_id,
                                            pro.buynow_status,
                                            pro.price as list_price,

											(SELECT l.logo
											FROM ' . $agent_logo_cls->getTable() . ' AS l
											WHERE l.agent_id = IF(pro.agent_manager = \'\' OR ISNULL(pro.agent_manager),pro.agent_id,pro.agent_manager)
											) AS logo,

											(SELECT SUM(pro_log.view)
											FROM ' . $property_cls->getTable('property_log') . ' AS pro_log
											WHERE pro_log.property_id = pro.property_id
											)AS views,

											(SELECT reg1.code
											FROM ' . $region_cls->getTable() . ' AS reg1
											WHERE reg1.region_id = pro.state
											) AS state_code,

											(SELECT reg1.name
											FROM ' . $region_cls->getTable() . ' AS reg1
											WHERE reg1.region_id = pro.state
											) AS state_name,

											(SELECT reg2.code
											FROM ' . $region_cls->getTable() . ' AS reg2
											WHERE reg2.region_id = pro.state
											) AS state_code,

											(SELECT reg3.name
											FROM ' . $region_cls->getTable() . ' AS reg3
											WHERE reg3.region_id = pro.country
											) AS country_name,

											(SELECT reg4.code
											FROM ' . $region_cls->getTable() . ' AS reg4
											WHERE reg4.region_id = pro.country
											) AS country_code,

											(SELECT pro_opt1.value
											FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt1
											WHERE pro_opt1.property_entity_option_id = pro.bathroom
											) AS bathroom_value,

											(SELECT pro_opt2.value
											FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt2
											WHERE pro_opt2.property_entity_option_id = pro.bedroom
											) AS bedroom_value,

											(SELECT pro_opt3.value
											FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt3
											WHERE pro_opt3.property_entity_option_id = pro.car_port
											) AS carport_value,

											(SELECT pro_opt6.title
											FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt6
											WHERE pro_opt6.property_entity_option_id = pro.type
											) AS type_name,
                                            (SELECT pro_opt8.value
                                            FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt8
                                            WHERE pro_opt8.property_entity_option_id = pro.car_space
                                            ) AS carspace_value,
											(SELECT count(*)
											FROM ' . $property_cls->getTable('bids') . ' AS bid
											WHERE bid.property_id = pro.property_id
											) AS bids,


											(SELECT pro_opt6.title
                                                    FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt6
                                                    WHERE pro_opt6.property_entity_option_id = pro.period
                                                    ) AS period,

											(SELECT CASE
                                                WHEN pro.auction_sale != ' . $auction_sale_ar['private_sale'] . '
                                                     AND ( date(pro.start_time) > \'' . date('Y-m-d H:i:s') . '\' OR isnull(max(bid.price)) ) THEN
                                                    (SELECT pro_term.value
                                                     FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
                                                     LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
                                                        ON pro_term.auction_term_id = term.auction_term_id
                                                     WHERE term.code = \'auction_start_price\'
                                                            AND pro.property_id = pro_term.property_id)
                                                WHEN auction_sale = ' . $auction_sale_ar['private_sale'] . ' AND pro.price != 0 THEN pro.price
                                                WHEN auction_sale = ' . $auction_sale_ar['private_sale'] . ' AND pro.price = 0 AND pro.price_on_application != 0 THEN pro.price_on_application
                                            ELSE max(bid.price)
                                            END
                                            FROM bids AS bid WHERE bid.property_id = pro.property_id) AS price


									FROM ' . $property_cls->getTable() . ' AS pro
									INNER JOIN ' . $property_cls->getTable('agent') . ' AS agt ON pro.agent_id = agt.agent_id

									WHERE pro.property_id = ' . $id.''
                                    . $wh_str . '

                                    ORDER BY pro.confirm_sold, pro.stop_bid, pro.property_id DESC'
        , true);
    $data = array();
    if ($property_cls->hasError()) {
    } else if (is_array($row) && count($row) > 0) {
        $isAgent = $data['is_mine'] = Property_isVendorOfProperty($row['property_id']);
        if ($isAgent) {
            $isShow = false;
            if ($row['active'] == 1 AND $row['agent_active'] == 1 AND $row['pay_status'] == Property::PAY_COMPLETE) {
                $isShow = true;
            }
        } else {
            $isShow = true;
        }
        $isVendor = Property_isVendor($_SESSION['agent']['id'], $row['property_id']);
        $data['info'] = $row;
        $data['info']['views'] = (int)$row['views'] > 0 ? $row['views'] : 0;
        $data['info']['buynow_buyer_id'] = (int)$row['buynow_buyer_id'] > 0 ? (int)$row['buynow_buyer_id'] : 0;
        if ($row['auction_sale'] == $auction_sale_ar['private_sale']) {
            $data['info']['pro_type'] = 'sale';
            $data['info']['title'] = 'FOR SALE : ' . $row['suburb'];
        }
        $data['info']['price'] = showPrice($row['price']);
        if ($data['info']['pro_type'] == 'sale') {
            $data['info']['price'] = $row['price_on_application'] == 1 ? 'Price On Application'
                : showPrice($row['price']);
        }
        $data['info']['isBlock'] = PE_isTheBlock($row['property_id']) ? 1 : 0;
        $data['info']['ofAgent'] = PE_isTheBlock($row['property_id'], 'agent') ? 1 : 0;
        if ($data['info']['isBlock'] || $data['info']['ofAgent']) {
            $data['info']['no_more_bids'] = PE_isNoMoreBids($row['property_id'], isset($_SESSION['agent']) ? $_SESSION['agent']['id'] : 0);
            $data['agent'] = A_getCompanyInfo($row['property_id']);
            $data['me'] = A_getAgentManageInfo($row['property_id']);
        }
        $data['info']['count'] = '';
        if ($row['auction_sale'] != $auction_sale_ar['private_sale']
            AND $row['end_time'] != '0000-00-00 00:00:00'
            AND $row['start_time'] != '0000-00-00 00:00:00'
        ) { //LIVE AUCTION OR FORTHCOMING
            $dt = new DateTime($row['end_time']);
            $dt1 = new DateTime($row['start_time']);
            if($row['start_time'] == '5000-05-05 00:00:00' && $row['end_time'] == '5000-06-06 00:00:00'){
                $data['info']['title'] =  'FOR ' . (PE_isRentProperty($row['property_id']) ? 'RENT' : 'SALE') . '';
            }elseif ($row['start_time'] > date('Y-m-d H:i:s')) { //FORTHCOMING
                $data['info']['pro_type'] = 'forthcoming';
                $data['info']['title'] = 'AUCTION STARTS : ' . $dt1->format('d-m-Y' . ' @ g:i');
                $data['info']['status_time'] = $data['info']['start_time'];
                $reserve_price = PT_getValueByCode($row['property_id'], 'reserve');
                $data['info']['price'] = $row['price_on_application'] == 1 ? 'Price On Application'
                    : showLowPrice($reserve_price) . '-' . showHighPrice($reserve_price);
                if (in_array($row['auction_sale'], array($auction_sale_ar['ebiddar'], $auction_sale_ar['bid2stay']))) {
                    $data['info']['price'] = $row['price_on_application'] > 0 ? 'Price On Application' : 'Starting at ' . showPrice($row['price']);
                }
                //$data['info']['remain_time'] = remainTime($row['start_time']);
            } else { // AUCTION
                $data['info']['pro_type'] = 'auction';
                if ($row['end_time'] < date('Y-m-d H:i:s')) { // END AUCTION
                    $data['info']['title'] = Localizer::translate('AUCTION ENDED') . ': ' . $dt->format($config_cls->getKey('general_date_format'));
                    $data['info']['status_time'] = Localizer::translate('AUCTION ENDED') . ': '.$dt->format($config_cls->getKey('general_date_format'));
                } else { //LIVE AUCTION
                    $data['info']['title'] = Localizer::translate('AUCTION ENDS') . ': <span class="auc-time-'.$row['property_id'].'"></span>';
                    $data['info']['status_time'] = Localizer::translate('AUCTION ENDS') . ':';
                    if($row['stop_bid'] == 1){
                        $data['info']['title'] = Localizer::translate('AUCTION ENDED');
                    }
                }

                $data['info']['status_time'] .= $dt->format($config_cls->getKey('general_date_format') . ' @ g:i');
                //BEGIN BIDDER
                $data['info']['isLastBidVendor'] = Bid_isLastBidVendor($row['property_id']);
                $data['info']['bidder'] = formUnescape(Bid_getShortNameLastBidder($row['property_id']));
                //END
                //BEGIN GET RESERVE PRICE
                $data['info']['reprice'] = PT_getValueByCode($row['property_id'], 'reserve');
                //check price>reserve price ?
                if ($row['price'] >= $data['info']['reprice'] && $data['info']['reprice'] > 0) {
                    $data['info']['check_price'] = true;
                } else {
                    $data['info']['check_price'] = false;
                }
                //CALC REMAIN TIME Nhung edit
                $data['info']['remain_time'] = remainTime($row['end_time']);
                //BEGIN GET START PRICE
                $start_price = PT_getValueByCode($row['property_id'], 'auction_start_price');
                $data['info']['check_start'] = ($start_price == $row['price']) ? 'true' : 'false';
                if ($row['confirm_sold'] == 1) {
                    $data['info']['count'] = 'Sold';
                } else {
                    if ($data['info']['remain_time'] <= $count['once'] and $data['info']['remain_time'] > $count['twice']) {
                        $data['info']['count'] = 'Going once';
                    } elseif ($data['info']['remain_time'] <= $count['twice'] and $data['info']['remain_time'] > $count['third']) {
                        $data['info']['count'] = 'Going twice';
                    } elseif ($data['info']['remain_time'] <= $count['third'] and $row['stop_bid'] != 1) {
                        $data['info']['count'] = 'Third and final call';
                    } else {
                        $data['info']['count'] = '';
                    }
                }
                if (PE_isTheBlock($row['property_id'])) {
                    $data['info']['count'] = $row['set_count'];
                }
            }
        } elseif ($row['auction_sale'] != $auction_sale_ar['private_sale']
            AND $row['end_time'] == '0000-00-00 00:00:00'
            AND $row['start_time'] == '0000-00-00 00:00:00') {
            $data['info']['pro_type'] = 'sale';
            $data['info']['title'] = 'AUCTION : ' . $row['suburb'];
            $data['info']['price'] = '';
        }
        $data['info']['buynow_price'] = showPrice($row['buynow_price']);

        $data['info']['advertised_price'] = showAdvertisedPrice($row['property_id']);
        $data['info']['isNoSetAuctionTime'] = isNoSetAuctionTime($row['property_id']);

        $data['info']['completed'] = $row['active'] == 1 AND $row['agent_active'] == 1 AND $row['pay_status'] == Property::PAY_COMPLETE;
        //$data['info']['description'] = nl2br($row['description']);
        $data['info']['description'] = nl2br($row['description']);
        $data['info']['print_description'] = safecontent($row['description'], 5000);
        $type = PEO_getOptionById($row['auction_sale']);
        $data['info']['pro_type_code'] = $type['code'];
        //$meta_description = $data['info']['meta_description'] = htmlentities($row['description']);
        //
        $data['info']['isRentProperty'] = PE_isRentProperty($row['property_id']);
        $data['info']['getTypeProperty'] = PE_getTypeProperty($row['property_id']);
        /*IBB-1152: NHUNG
        Fix the Facebook post description*/
        $link_ar = array('module' => 'property',
            'action' => '',
            'id' => $row['property_id']);
        $link_ar['action'] = 'view-auction-detail';
        $meta_description = $data['info']['meta_description'] = strip_tags($row['description']);
        $data['link'] = shortUrl($link_ar + array('data' => $row),
            (PE_isTheBlock($row['property_id'], 'agent') ? Agent_getAgent($row['property_id']) : array()));
        //print_r($row['livability_rating_mark'].','.$row['green_rating_mark']);
        $data['info']['livability_rating_mark'] = showStar((float)$row['livability_rating_mark']);
        $data['info']['green_rating_mark'] = showStar((float)$row['green_rating_mark']);
        //get data contact form
        $data['contact_info'] = PE_getAgent($row['agent_id']);
        $data['info']['carport_value_'] = $data['info']['carport_value'];
        if ($data['info']['carport_value'] == null AND $data['info']['parking'] == 1) {
            $data['info']['carport_value'] = $data['info']['carspace_value'];
        }
        $data['info']['address_full'] = implode(', ', array($row['address'], $row['suburb'], $row['state_name'], $row['postcode'], $row['country_name']));
        $data['info']['address_short'] = strlen($data['info']['address_full']) > 30 ? substr($data['info']['address_full'], 0, 27) . ' ...' : $data['info']['address_full'];
        $data['info']['o4i'] = Calendar_createPopup($row['property_id'], $row['open_for_inspection'], 'grid');
        $data['info']['btn_open_for_inspection'] = Calendar_createButton($row['property_id'], $row['open_for_inspection'], 'grid');
        $googleAddress = str_replace(' ', '+', $data['info']['address_full']);
        $smarty->assign('new_address', $googleAddress);
        //pay_status
        if ($row['pay_status'] == Property::PAY_UNKNOWN) {
            $data['info']['pay_status'] = 'unknown';
        } elseif ($row['pay_status'] == Property::PAY_PENDING) {
            $data['info']['pay_status'] = 'pending';
        } elseif ($row['pay_status'] == Property::PAY_COMPLETE) {
            $data['info']['pay_status'] = 'complete';
        }
        $_meta_desc_ar = array();
        $_meta_desc_ar[] = $data['info']['pro_type'];
        $_meta_desc_ar[] = $data['info']['address_full'];
        $_meta_desc_ar[] = $data['info']['type_name'];
        $_meta_desc_ar[] = ' Bed room :' . $data['info']['bedroom_value'];
        $_meta_desc_ar[] = ' Bath room :' . $data['info']['bathroom_value'];
        $_meta_desc_ar[] = ' Car port :' . $data['info']['carport_value'];
        if (isset($site_title)) {
            $site_title = $site_title . ' / ' . $data['info']['address_full'];
        }
        $site_meta_key = implode(' / ', $_meta_desc_ar);
        $site_meta_description = htmlentities(implode(' / ', $_meta_desc_ar));
        $data['info']['next'] = PE_navLink('next', $row['property_id'], $row['auction_sale'], $data['info']['pro_type']);
        $data['info']['prev'] = PE_navLink('prev', $row['property_id'], $row['auction_sale'], $data['info']['pro_type']);
        /*Quan*/
        $data['info']['next_link'] = PE_navLink_new('next', $row['property_id']);
        $data['info']['prev_link'] = PE_navLink_new('prev', $row['property_id']);
        /*Print Page*/
        $data['info']['landsize'] = trim(str_replace('m2', '', $row['land_size']));
        //$data['info']['link'] = shortUrl($link_ar + array('data' => $row),(PE_isTheBlock($row['property_id'],'agent')?Agent_getAgent($row['property_id']):array()));
        $rowaddress = str_replace(' ', '-', $row['address']);
        $rowaddress = str_replace(',', '', $rowaddress);
        $rowaddress = (substr($rowaddress, -1) == '-') ? substr($rowaddress, 0, -1) : $rowaddress;
        $rowsuburb = str_replace(' ', '-', $row['suburb']);
        $data['info']['link'] = ROOTURL . "/" . strtolower($row['state_code']) . "/for-sale/$rowsuburb/$rowaddress/id-" . $row['property_id'];
        //BEGIN FOR DOCUMENT
        $data['docs'] = PD_getDocs($row['property_id']);
        //END
        $data['info']['short_description'] = strlen(safecontent($row['description'], 200)) > 200 ? safecontent($row['description'], 200) . '...' : $row['description'];
        //BEGIN FOR MEDIA
        $_photo = PM_getPhoto($row['property_id'], true);
        $data['photo'] = $_photo;
        $data['info']['photo_facebook'] = $data['photo_default'];
        //END MEDIA
        $data['info']['register_bid'] = Property_registerBid($row['property_id']);
        if (isset($_SESSION['agent']) AND $_SESSION['agent']['type'] == 'theblock') {
            $id_ = $row['property_id'];
            //$row = PE_getAgent(0,$id_);
            if (count($row) > 0 AND $row['agent_id'] == $_SESSION['agent']['id']) {
                $data['info']['register_bid'] = true;
            }
        }
        $data['ebidda_detail_watermark'] = PE_getEbiddaWatermark($row['property_id'], true);
        //BEGIN FOR COMMENT
        $data['comments'] = PE_getComments($row['property_id']);
        //
        $reaxml_status = PE_getPropertyStatusREA_xml($row['property_id']);
        $data['info']['property_status'] = str_replace(' ', '_', $reaxml_status);
        //BEGIN VIEWMORE
        $smarty->assign('data', $data['info']);
        $smarty->assign('property_id', $row['property_id']);
        $smarty->assign('meta_description', $meta_description);
        $_str = '<a style="display:none;" class="pvm" href="javascript:void(0)"  onClick="showPVM()" class="viewmore">MORE INFORMATION &raquo;</a>';
        $_str .= $smarty->fetch(ROOTPATH . '/modules/property/templates/property.viewmore.popup.tpl');
        $data['view_more'] = $_str;
        $data['mao'] = Property_makeAnOfferPopup($row['property_id']);
        //$data['countdown'] = Property_makeCountDownPopup($row['property_id'],$row['autobid_enable'],$row['min_increment'],$row['max_increment']);
        //END
        //BEGIN FOR BID, AUTO BID
        if (@$_SESSION['agent']['id'] > 0) {
            //abs~auto bid settings
            $data['abs_tpl'] = Bid_showBox($row['property_id']);
        }
        //END
        $iai_id = AT_getIdByCode('initial_auction_increments');
        $term_ar = PT_getTermsKeyParentId($row['property_id']);
        $step_init = $term_ar[$iai_id];
        $step_options_detail = AT_getOptions($iai_id, 1, 'ASC', $data['info']['pro_type_code']);
        //$inc_options = $step_options_detail;
        //NI-21.Property detail - Show increment price is not right
        $inc_options = AT_getIncOptionsByMinMax($iai_id, $step_init);
        if (PE_isTheBlock($row['property_id'])) {
            $inc_options = AT_getIncOptionsByMinMax($iai_id, $row['min_increment'], $row['max_increment']);
            $step_init = !in_array($step_init, array_keys($inc_options)) ? min(array_keys($inc_options))
                : $step_init;
            if ($row['min_increment'] != 0) {
                $minInc = "Min";
                $minInc_price = showPrice($row['min_increment']);
                $minmaxInc_mess = 'minimum is: <label style="font-weight: bold"> ' . $minInc_price . '</label>';
            }
            if ($row['max_increment'] != 0) {
                $maxInc = ($row['min_increment'] != 0) ? "- Max" : "Max:";
                $maxInc_price = showPrice($row['max_increment']);
                $minmaxInc_mess = ($row['min_increment'] != 0)
                    ? 'range is:<label style="font-weight: bold"> ' . $minInc_price . '</label> - <label style="font-weight: bold"> ' . $maxInc_price . '</label>'
                    : 'maximum is: <label style="font-weight: bold"> ' . $maxInc_price . '</label>';
            }
            $data['info']['minmaxInc'] = "";
            if ($row['max_increment'] != 0 || $row['min_increment'] != 0) {
                $data['info']['minmaxInc'] = '(' . $minInc . ' ' . $maxInc . ' : ' . $minInc_price . ' ' . $maxInc_price . ")";
                //$data['info']['minmaxInc_mess'] = 'Please select the increment '.$minmaxInc_mess.' as it is the Vendor\'s bid increment setting in minimum on a row';
                $data['info']['minmaxInc_mess'] = "you can only bid inline with the auctioneers set increments, " . $minmaxInc_mess;
            }
            //End Increment
        }
        $smarty->assign('step_init', $step_init);
        $smarty->assign('inc_options', $inc_options);
        //BEGIN BACKGROUND
        $pro_type_ = PE_isTheBlock($id) ? 'theblock' :
            !$data['info']['check_price'] ? 'passedin' : $data['info']['pro_type'];
        $smarty->assign('pro_type_', $pro_type_);
        if (PE_isTheBlock($id)) {
            $data['info']['title'] = $row['owner'];
        }
        /*if (PE_isTheBlock($id, 'agent')) {
            $auction_option = PEO_getOptionById($row['auction_sale']);
            $data['info']['title'] = strtoupper($auction_option['title']).': '.$data['agent']['company_name'];
            $mobileBrowser = detectBrowserMobile();
            if ($mobileBrowser && strlen($data['info']['title']) > 15){
                $data['info']['title'] = safecontent($data['info']['title'],15).'...';
            }
        }*/
        if (isset($actions))
            $smarty->assign('action-detail', $actions[1]);
        $default_inc = PT_getValueByCode($row['property_id'], 'initial_auction_increments');
        $smarty->assign('default_inc', showPrice($default_inc));
        $smarty->assign('is_localhost', false);
        $smarty->assign('isLogin', A_isLogin());
        $smarty->assign('property_data', formUnescapes($data));
        $smarty->assign('can_comment', (int)PK_getAttribute('can_comment', $row['property_id']));
        $smarty->assign('is_bid_history', PE_isBidHistory($row['property_id']));
        $smarty->assign('isSold', (int)PE_getSoldStatus($row['property_id']));
        $smarty->assign('isAgent', $isAgent);
        $smarty->assign('isAuction', PE_isNormalAuction($row['property_id']));
        $smarty->assign('isShow', $isShow);
        $smarty->assign('is_paid', $bid_first_cls->getStatus(@$_SESSION['agent']['id'], $row['property_id']) ? 1
            : 0 OR $_SESSION['agent']['type'] == 'theblock' OR $isAgent);
    }
    return $data;
}

function NewPropertyFromPropertyId($property_id, $agent_id)
{
    global $property_cls, $media_cls, $property_media_cls, $property_document_cls, $property_term_cls;
    $new_property_id = 0;
    if ($property_id > 0 && $agent_id > 0) {
        $row = $property_cls->getRow('property_id=' . $property_id);
        if (is_array($row) && count($row) > 0) {
            /**/
            unset($row['property_id']);
            $row['stop_bid'] = 0;
            $row['confirm_sold'] = 0;
            $row['pay_status'] = 0;
            $row['underoffer'] = 0;
            $row['active'] = 0;
            $row['agent_id'] = $agent_id;
            $row['start_time'] = '0000-00-00 00:00:00';
            $row['end_time'] = '0000-00-00 00:00:00';
            /*Property_details*/
            $property_cls->insert($row);
            $new_property_id = $property_cls->insertId();
            /*Property_packages*/
            PA_NewPackageFromId($property_id, $new_property_id);
            /*Property_medias*/
            $property_media_rows = $property_media_cls->getRows('property_id=' . $property_id);
            if (is_array($property_media_rows) && count($property_media_rows) > 0) {
                foreach ($property_media_rows as $property_media_row) {
                    $property_media_row['property_id'] = $new_property_id;
                    if ($property_media_row['media_id'] > 0) {
                        $media_row = $media_cls->getRow('media_id=' . $property_media_row['media_id']);
                        unset($media_row['media_id']);
                        $media_cls->insert($media_row);
                        if (!$media_cls->hasError()) {
                            $property_media_row['media_id'] = $media_cls->insertId();
                            $property_media_cls->insert($property_media_row);
                        }
                    }
                }
            }
            /*Property_DOCS*/
            $property_document_rows = $property_document_cls->getRows('property_id=' . $property_id);
            if (is_array($property_media_rows) && count($property_document_rows) > 0) {
                foreach ($property_document_rows as $property_document_row) {
                    $property_document_row['property_id'] = $new_property_id;
                    $property_document_cls->insert($property_document_row);
                }
            }
            /*Property_Terms*/
            /*$property_term_rows = $property_term_cls->getRows('property_id=' . $property_id);
            if (is_array($property_term_rows) && count($property_term_rows) > 0) {
                foreach ($property_term_rows as $property_term_row) {
                    $property_term_row['property_id'] = $new_property_id;
                    $property_term_cls->insert($property_term_row);
                }
            }*/
        }
    }
    return $new_property_id;
}

?>