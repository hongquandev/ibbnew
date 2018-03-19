<?php
include_once 'agent.class.php';
include_once 'agent_creditcard.class.php';
include_once 'agent_history.class.php';
include_once 'agent_lawyer.class.php';
include_once 'agent_contact.class.php';
include_once 'agent_option.class.php';
include_once 'agent.logo.class.php';
include_once 'agent.payment.class.php';
include_once 'message.php';
include_once 'company.php';
include_once 'agent_site.class.php';
include_once ROOTPATH . '/modules/general/inc/regions.class.php';
include_once ROOTPATH . '/modules/general/inc/sendmail.php';
include_once ROOTPATH . '/modules/general/inc/card_type.class.php';
#include_once ROOTPATH.'/modules/general/inc/bids.php';
include_once ROOTPATH . '/modules/property/inc/property.php';
if (!isset($agent_cls) || !($agent_cls instanceof Agent)) {
    $agent_cls = new Agent();
}
if (!isset($agent_logo_cls) || !($agent_logo_cls instanceof Agent_Logo)) {
    $agent_logo_cls = new Agent_Logo();
}
if (!isset($agent_payment_cls) || !($agent_payment_cls instanceof Agent_Payment)) {
    $agent_payment_cls = new Agent_Payment();
}
if (!isset($agent_site_cls) || !($agent_site_cls instanceof Agent_site)) {
    $agent_site_cls = new Agent_site();
}
if (!isset($region_cls) or !($region_cls instanceof Region)) {
    $region_cls = new Regions();
}
if (!isset($property_cls) || !($property_cls instanceof Property)) {
    $property_cls = new Property();
}
//END
//BEGIN AGENT - Tedte
/**
 * @ function : A_optionName
 */
function A_optionName($defaul = '')
{
    global $agent_cls;
    $option_ar = array();
    $rows = $agent_cls->getRows('is_active = 1 ORDER BY firstname ASC');
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            $option_ar[$row['agent_id']] = $row['firstname'] . ' ' . $row['lastname'];
        }
    }
    return $option_ar;
}

/**
 * @ function : A_getFullName
 **/
function A_getFullName($agent_id)
{
    global $agent_cls;
    $row = $agent_cls->getRow('agent_id = ' . $agent_id);
    if (is_array($row) and count($row) > 0) {
        return $row['firstname'] . ' ' . $row['lastname'];
    }
    return '';
}

/**
 * @ function : A_getEmail
 **/
function A_getEmail($agent_id)
{
    global $agent_cls;
    $row = $agent_cls->getRow('agent_id = ' . $agent_id);
    if (is_array($row) and count($row) > 0) {
        return $row['email_address'];
    }
    return '';
}

/**
 * @ function : A_prevAdminLink
 **/
function A_prevAdminLink($agent_id = 0)
{
    global $agent_cls, $token;
    $row = $agent_cls->getRow('agent_id < ' . (int)$agent_id . ' ORDER BY agent_id DESC');
    if (is_array($row) and count($row) > 0) {
        return '<a href="?module=agent&action=edit-personal&agent_id=' . $row['agent_id'] . '&token=' . $token . '">&lt;&lt; Previous</a>';
    }
    return '';
}

/**
 * @ function : A_nextAdminLink
 **/
function A_nextAdminLink($agent_id = 0)
{
    global $agent_cls, $token;
    $row = $agent_cls->getRow('agent_id > ' . (int)$agent_id . ' ORDER BY agent_id ASC');
    if (is_array($row) and count($row) > 0) {
        return '<a href="?module=agent&action=edit-personal&agent_id=' . $row['agent_id'] . '&token=' . $token . '">Next &gt;&gt;</a>';
    }
    return '';
}

/**
 * @ function : A_getStatus
 **/
function A_getStatus($agent_id)
{
    global $agent_cls;
    $row = $agent_cls->getRow('agent_id = ' . $agent_id);
    if (is_array($row) && count($row) > 0) {
        return $row['is_active'];
    }
    return '';
}

//END
function A_getAddress($agent_id = 0)
{
    global $agent_cls, $region_cls;
    $sql = 'SELECT  agent.street, agent.suburb,
					agent.other_state, agent.postcode,
				(SELECT reg1.name
				FROM ' . $region_cls->getTable() . ' AS reg1
				WHERE reg1.region_id = agent.state ) AS state_name,

				(SELECT reg2.name
				FROM ' . $region_cls->getTable() . ' AS reg2
				WHERE reg2.region_id = agent.country) AS country_name

			FROM ' . $agent_cls->getTable() . ' AS agent
			WHERE agent.agent_id = ' . (int)$agent_id;
    $row = $agent_cls->getRow($sql, true);
    $rs = '';
    if (count($row) > 0) {
        $add_ar = array();
        $add_ar[] = $row['street'];
        $add_ar[] = $row['suburb'];
        $add_ar[] = $row['postcode'];
        $add_ar[] = strlen(trim($row['state_name'])) > 0 ? $row['state_name'] : $row['other_state'];
        $add_ar[] = $row['country_name'];
        $rs = implode(', ', $add_ar);
    }
    return $rs;
}

function A_getCompanyAddress($agent_id = 0)
{
    global $company_cls, $region_cls;
    $sql = 'SELECT  ac.address, ac.suburb,
					ac.other_state, ac.postcode,
				(SELECT reg1.name
				FROM ' . $region_cls->getTable() . ' AS reg1
				WHERE reg1.region_id = ac.state ) AS state_name,

				(SELECT reg2.name
				FROM ' . $region_cls->getTable() . ' AS reg2
				WHERE reg2.region_id = ac.country) AS country_name

			FROM ' . $company_cls->getTable() . ' AS ac
			WHERE ac.agent_id = ' . (int)$agent_id;
    $row = $company_cls->getRow($sql, true);
    $rs = '';
    if (count($row) > 0) {
        $add_ar = array();
        $add_ar[] = $row['address'];
        $add_ar[] = $row['suburb'];
        $add_ar[] = $row['postcode'];
        $add_ar[] = strlen(trim($row['state_name'])) > 0 ? $row['state_name'] : $row['other_state'];
        $add_ar[] = $row['country_name'];
        $rs = implode(', ', $add_ar);
    }
    return $rs;
}

//BEGIN AGENT TYPE
/**
 * @ function : AgentType_getOptions
 **/
function AgentType_getOptions($active = 1, $field = 'title')
{
    global $agent_cls;
    $options = array();
    $wh_str = ' WHERE active = ' . (int)$active;
    $rows = $agent_cls->getRows('SELECT agent_type_id, ' . $field . ' FROM ' . $agent_cls->getTable('agent_type') . $wh_str, true);
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            $options[$row['agent_type_id']] = $row[$field];
        }
    }
    return $options;
}

/**
 * @ function : AgentType_getType
 **/
function AgentType_getType($type_id)
{
    global $agent_cls;
    $row = $agent_cls->getRow('SELECT name
								FROM ' . $agent_cls->getTable('agent_type') . '
								WHERE agent_type_id = ' . $type_id, true);
    if (is_array($row) and count($row) > 0) {
        return $row['name'];
    }
    return '';
}

/**
 * @ function : AgentType_getIdByKey
 **/
function AgentType_getIdByKey($key = '')
{
    global $agent_cls;
    $row = $agent_cls->getRow('SELECT agent_type_id
								FROM ' . $agent_cls->getTable('agent_type') . '
								WHERE title = \'' . $key . '\'', true);
    if (is_array($row) and count($row) > 0) {
        return $row['agent_type_id'];
    }
    return 0;
}

/**
 * @ function : AgentType_isVendor
 **/
function AgentType_isVendor($type_id = 0)
{
    global $agent_cls;
    $row = $agent_cls->getRow('SELECT title
								FROM ' . $agent_cls->getTable('agent_type') . '
								WHERE agent_type_id = ' . $type_id, true);
    if (is_array($row) and count($row) > 0) {
        if ($row['title'] == 'vendor') return true;
    }
    return false;
}

/**
 * @ function : AgentType_getOptions_
 **/
function AgentType_getOptions_($allowGuest = true)
{
    global $agent_cls;
    $wh_str = '';
    if ($allowGuest == false) {
        $arr = AgentType_getArr();
        $wh_str = ' AND agent_type_id != ' . $arr['guest'];
    }
    $options = array();
    $rows = $agent_cls->getRows('SELECT agent_type_id,name FROM ' . $agent_cls->getTable('agent_type') . ' WHERE active = 1' . $wh_str, true);
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            $options[$row['agent_type_id']] = $row['name'];
        }
    }
    return $options;
}

/**
 * @ function : AgentType_getArr
 **/
function AgentType_getArr()
{
    global $agent_cls;
    $options = array();
    $rows = $agent_cls->getRows('SELECT agent_type_id,title FROM ' . $agent_cls->getTable('agent_type'), true);
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            $options[$row['title']] = $row['agent_type_id'];
        }
    }
    return $options;
}

/**
 * @ function : AgentType_getTypeAgent
 **/
function AgentType_getTypeAgent($agent_id)
{
    global $agent_cls;
    $row = $agent_cls->getRow('SELECT * FROM ' . $agent_cls->getTable() . ' as a
							   LEFT JOIN ' . $agent_cls->getTable('agent_type') . ' AS agt
							   ON a.type_id = agt.agent_type_id
							   WHERE a.agent_id =' . $agent_id, true);
    if (is_array($row) and count($row) > 0) {
        return $row['title'];
    }
    return '';
}

/**
 * @ function : AgentType_getTypeIDAgent
 **/
function AgentType_getTypeIDAgent($agent_id)
{
    global $agent_cls;
    $row = $agent_cls->getRow('SELECT type_id FROM ' . $agent_cls->getTable() . ' as a
							   WHERE a.agent_id =' . $agent_id, true);
    if (is_array($row) and count($row) > 0) {
        return $row['type_id'];
    }
    return '';
}

//END
if (!isset($agent_creditcard_cls) || !($agent_creditcard_cls instanceof Agent_creditcard)) {
    $agent_creditcard_cls = new Agent_creditcard();
}
//BEGIN CREDITCARD
/**
 * @ function : ACC_getOptionsMonth
 **/
function ACC_getOptionsMonth()
{
    $option_ar = array(0 => 'Month',
        1 => '01 - January',
        2 => '02 - February',
        3 => '03 - March',
        4 => '04 - April',
        5 => '05 - May',
        6 => '06 - June',
        7 => '07 - July',
        8 => '08 - August',
        9 => '09 - September',
        10 => '10 - October',
        11 => '11 - November',
        12 => '12 - December');
    return $option_ar;
}

/**
 * @ function : ACC_getOptionsYear
 **/
function ACC_getOptionsYear($end_year)
{
    $option_ar = array(0 => 'Year');
    for ($i = date('Y'); $i <= $end_year; $i++) {
        $option_ar[$i] = $i;
    }
    return $option_ar;
}

/**
 * @ function : ACC_getOptions
 **/
function ACC_getOptions($agent_id = 0)
{
    global $agent_creditcard_cls, $card_type_cls;
    $rows = $agent_creditcard_cls->getRows('SELECT acc.agent_creditcard_id, acc.card_name, acc.card_number, ct.name AS card_type
			FROM ' . $agent_creditcard_cls->getTable() . ' AS acc,' . $card_type_cls->getTable() . ' AS ct
			WHERE acc.card_type = ct.code AND ct.active > 0 AND acc.agent_id = ' . $agent_id . '
			ORDER BY ct.code', true);
    $option_ar = array();
    if (is_array($rows) && count($rows) > 0) {
        foreach ($rows as $row) {
            $option_ar[$row['agent_creditcard_id']] = $row['card_type'] . ' ( ' . $row['card_name'] . ' - ' . $row['card_number'] . ' )';
        }
    }
    return $option_ar;
}

//END
if (!isset($agent_history_cls) || !($agent_history_cls instanceof Agent_history)) {
    $agent_history_cls = new Agent_history();
}
//BEGIN AGENT HISTORY
/**
 * @ function : AH_update
 **/
function AH_update($data = array())
{
    global $agent_history_cls;
    $ar = array('is_track', 'property_id', 'agent_id', 'step');
    if (!is_array($data)) {
        $data = array('is_track' => 0);
    }
    foreach ($ar as $v) {
        if (!isset($data[$v])) {
            $data[$v] = 0;
        }
    }
    if ($data['is_track'] == 1) {
        $agent_history_cls->updateHistory(array('agent_id' => $data['agent_id'],
            'property_id' => $data['property_id'],
            'property_step' => $data['step']),
            'agent_id = ' . $data['agent_id'] . ' AND property_id = ' . $data['property_id']);
    }
}

//END
if (!isset($agent_lawyer_cls) || !($agent_lawyer_cls instanceof Agent_lawyer)) {
    $agent_lawyer_cls = new Agent_lawyer();
}
if (!isset($agent_contact_cls) || !($agent_contact_cls instanceof Agent_contact)) {
    $agent_contact_cls = new Agent_contact();
}
if (!isset($agent_option_cls) || !($agent_option_cls instanceof Agent_option)) {
    $agent_option_cls = new Agent_option();
}
//BEGIN AGENT OPTION
/**
 * @ function : AO_getOptions
 **/
function AO_getOptions($code = '')
{
    global $agent_option_cls;
    $options = array(0 => 'Select...');
    $rows = $agent_option_cls->getRows("parent_id = (SELECT b.agent_option_id
					FROM " . $agent_option_cls->getTable() . " AS b
					WHERE b.code = '" . $agent_option_cls->escape($code) . "') AND active = 1 ORDER BY `order` ASC");
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            $options[$row['agent_option_id']] = $row['title'];
        }
    }
    return $options;
}

//END
if (!isset($message_cls) || !($message_cls instanceof Message)) {
    $message_cls = new Message();
}
//BEGIN MESSAGE
/**
 * @ function : M_numInbox
 **/
function M_numInbox()
{
    global $message_cls;
    $row = $message_cls->getRow('SELECT COUNT(*) AS num
					FROM ' . $message_cls->getTable() . '
					WHERE `agent_id_to` = ' . $_SESSION['agent']['id'] . ' AND draft = 0', true);
    return isset($row['num']) ? $row['num'] : 0;
}

/**
 * @ function : M_numOutbox
 **/
function M_numOutbox()
{
    global $message_cls;
    $row = $message_cls->getRow('SELECT COUNT(*) AS num
					FROM ' . $message_cls->getTable() . '
					WHERE `agent_id_from` = ' . $_SESSION['agent']['id'] . ' AND `abort` = 0', true);
    return isset($row['num']) ? $row['num'] : 0;
}

/**
 * @ function : M_numUnread
 **/
function M_numUnread()
{
    global $message_cls;
    $row = $message_cls->getRow('SELECT COUNT(*) AS num
					FROM ' . $message_cls->getTable() . '
					WHERE `agent_id_to` = ' . $_SESSION['agent']['id'] . ' AND `read` = 0 AND draft = 0', true);
    return isset($row['num']) ? $row['num'] : 0;
}

//END
if (!isset($card_type_cls) or !($card_type_cls instanceof Card_type)) {
    $card_type_cls = new Card_type();
}
//BEGIN CARD TYPE
/**
 * @ function : CT_getOptions
 **/
function CT_getOptions()
{
    global $card_type_cls;
    $options = array('' => 'Select...');
    $rows = $card_type_cls->getRows('active > 0 ORDER BY `order` ASC');
    if ($card_type_cls->hasError()) {
        $message = $card_type_cls->getError();
    } else {
        if (is_array($rows) and count($rows) > 0) {
            foreach ($rows as $key => $row) {
                $options[$row['code']] = $row['name'];
            }
        }
    }
    return $options;
}

//END
//BEGIN CHECK INFORMATION OF AGENT
/**
 * @ function : getInfo
 **/
function getInfo($table_name, $agent_id)
{
    global $agent_cls;
    $row = array();
    if ($agent_id > 0) {
        $row = $agent_cls->getRow('SELECT * FROM ' . $agent_cls->getTable($table_name) . ' WHERE agent_id = ' . $agent_id, true);
        if (count($row) > 0 and is_array($row)) {
            return $row;
        }
    }
    return array();
}

/**
 * @ function : A_isLogin
 **/
function A_isLogin()
{
    global $agent_cls;
    $agent_id = (isset($_SESSION['agent']) and $_SESSION['agent']['id'] > 0) ? $_SESSION['agent']['id'] : 0;
    $ch = false;
    if ($agent_id > 0) {
        $row = $agent_cls->getCRow(array('agent_id'), 'agent_id =' . $agent_id . ' AND is_active=1');
        if (count($row) and is_array($row)) {
            $ch = true;
        }
    }
    return $ch;
}

/**
 * @ function : AI_isBasic
 **/
function AI_isBasic($agent_id)
{
    global $agent_cls;
    $personal = false;
    $contact = $partner = true;
    if (is_array(getInfo('agent', $agent_id)) and count(getInfo('agent', $agent_id)) > 0) {
        $row = getInfo('agent', $agent_id);
        //check the block or agent
        $arr = AgentType_getArr();
        if (in_array($row['type_id'], array($arr['agent'], $arr['theblock']))) return false;
        $fields = array('suburb', 'state', 'postcode', 'country');
        foreach ($fields as $field) {
            if (trim($row[$field]) == null) {
                $personal = true;
            }
        }
    }
    if (is_array(getInfo('agent_contact', $agent_id)) and count(getInfo('agent_contact', $agent_id)) > 0) {
        $contact = false;
    }
    if (is_array(getInfo('partner_register', $agent_id)) and count(getInfo('partner_register', $agent_id)) > 0) {
        $partner = false;
    }
    $type = $agent_cls->getRow('SELECT * FROM ' . $agent_cls->getTable('agent_type') . ' WHERE title = \'partner\'', true);
    if ($row['type_id'] == ($type['agent_type_id'])) {
        if (/*$personal ||*/
        $partner /*|| $credit*/
        ) {
            return true;
        }
    } else {
        if ($personal || $contact /*|| $lawyer*/ /*|| $credit*/) {
            return true;
        }
    }
    return false;
}

/**
 * @ function : AI_infoNull
 **/
function AI_infoNull($agent_id)
{
    $personal = false;
    if (is_array(getInfo('agent', $agent_id)) and count(getInfo('agent', $agent_id)) > 0) {
        $row = getInfo('agent', $agent_id);
        $arr = AgentType_getArr();
        if (in_array($row['type_id'], array($arr['agent'], $arr['theblock']))) return false;
        $fields = $row['type_id'] == $arr['partner'] ?
            array('email_address', 'suburb', 'state', 'postcode', 'country') :
            array('email_address', 'suburb', 'state', 'postcode', 'country');
        foreach ($fields as $field) {
            if (trim($row[$field]) == null) {
                $personal = true;
            }
        }
    }
    return $personal;
}

//END
//BEGIN TWITTER
/**
 * @ function : AT_hasID
 **/
function AT_hasID($id, $prefix)
{
    global $agent_cls;
    $row = $agent_cls->getRow('provider_id = \'' . $prefix . '-' . $id . '\'');
    if (is_array($row) and count($row) > 0) {
        return true;
    }
    return false;
}

//END
/**
 * @ function : A_requireActive
 **/
function A_requireActive($property_id = 0)
{
    global $smarty;
    if ($property_id > 0) {
        $smarty->assign('agent_id', @$_SESSION['agent']['id']);
        $smarty->assign('agent_email', @$_SESSION['agent']['email_address']);
        $smarty->assign('property_id', $property_id);
        $str = $smarty->fetch(ROOTPATH . '/modules/agent/templates/agent.require-activation.popup.tpl');
        return $str;
    }
}

/**
 * @ function : __viewProperty
 **/
function __viewProperty($act = 'view-property')
{
    global $smarty, $region_cls, $property_cls, $package_cls, $agent_history_cls, $pag_cls, $property_entity_option_cls, $message_cls,
           $property_rating_mark_cls, $step, $property_media_cls, $media_cls, $agent_cls, $bid_cls, $jagentstr, $jstr, $config_cls;
    escapeParam();
    $form_data = array();
    if ($act == 'view-property-buyer') {
        $act = 'view-property';
    }
    // $date_format=''%Y-%m-%d'';
    $auction_sale_ar = PEO_getAuctionSale();
    $count = array();
    $count['once'] = $config_cls->getKey('count_going_once');
    $count['twice'] = $config_cls->getKey('count_going_twice');
    $count['third'] = $config_cls->getKey('count_going_third');
    //BEGIN FOR PAGGING
    $p = (int)restrictArgs(getQuery('p', 1));
    $p = $p <= 0 ? 1 : $p;
    $page = $p;
    $mode_fix = isset($_GET['mode']) ? $_GET['mode'] : '';
    $mode_fix = $mode_fix == 'grid' ? 'grid' : 'list';
    //$len = 10;
    if (getPost('len', 0) > 0) {
        $_SESSION['len'] = (int)restrictArgs(getPost('len'));
    }
    $len = isset($_SESSION['len']) ? $_SESSION['len'] : 9;
    //END
    //Order By
    $auction_sale_ar = PEO_getAuctionSale();
    $start_price = '(SELECT pro_term.value
                         FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
                         LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
                         ON pro_term.auction_term_id = term.auction_term_id
                         WHERE term.code = \'auction_start_price\'
                               AND pro.property_id = pro_term.property_id)';
    $wh_price = '(SELECT CASE
                        WHEN pro.auction_sale = ' . $auction_sale_ar['auction'] . ' THEN
                            (SELECT CASE
                                 WHEN pro.pay_status = ' . Property::PAY_COMPLETE . ' THEN
                                     (SELECT CASE
                                         WHEN (date(pro.start_time) > \'' . date('Y-m-d H:i:s') . '\' OR isnull(max(bid.price)) ) THEN
                                         ' . $start_price . '
                                         ELSE max(bid.price)
                                         END
                                         FROM bids AS bid WHERE bid.property_id = pro.property_id) + 0
                                 ELSE
                                     (SELECT CASE
                                         WHEN !isnull(' . $start_price . ') THEN ' . $start_price . '
                                         ELSE pro.price
                                         END)
                                 END)
                        WHEN auction_sale != ' . $auction_sale_ar['auction'] . ' AND pro.price != 0 THEN pro.price
                        WHEN auction_sale != ' . $auction_sale_ar['auction'] . ' AND pro.price = 0 AND pro.price_on_application != 0 THEN pro.price_on_application
                        END)';
    if (getPost('order_by') != '' || (isset($_POST['search']['order_by']) AND $_POST['search']['order_by'] != '')) {
        $_SESSION['order_by'] = (getPost('order_by') != '') ? getPost('order_by') : $_POST['search']['order_by'];
    }
    $order_by = isset($_SESSION['order_by']) ? $_SESSION['order_by'] : '';
    $sub_select = null;
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
        case 'offer':
            $order_ar = ' offer_number DESC';
            $sub_select = ',
                    (SELECT CASE
                            WHEN    pro.auction_sale = 9
                                    AND pro.start_time < \'' . date('Y-m-d H:i:s') . '\'
                                    AND pro.end_time > \'' . date('Y-m-d H:i:s') . '\'
                                    AND pro.stop_bid = 0
                                    AND pro.confirm_sold = 0
                                    AND pro.active = 1
                                THEN
                                    (SELECT count(*)
                                        FROM ' . $property_cls->getTable('message') . ' AS msg
                                        WHERE msg.entity_id = pro.property_id AND msg.abort = 0 AND
                                              msg.offer_price > bid_price
                                    )
                            ELSE    (SELECT count(*)
                                        FROM ' . $property_cls->getTable('message') . ' AS msg
                                        WHERE msg.entity_id = pro.property_id AND msg.abort = 0 AND
                                              TRUE
                                    )
                            END
                    )AS offer_number
                            ';
            break;
        case 'switch':
            $order_ar = ' ID DESC';
            $sub_select = ',(SELECT pro_his.property_id FROM property_transition_history AS pro_his
                                                                            WHERE pro_his.property_id=pro.property_id AND pro.confirm_sold !=' . Property::PAY_COMPLETE . ' ORDER BY pro_his.property_transition_history_id DESC LIMIT 0,1) as ID';
            break;
        case 'notcomplete':
            $order_ar = ' pro.pay_status ASC,pro.property_id DESC';
            break;
        case 'active':
            $order_ar = ' pro.active,pro.confirm_sold ASC,pro.pay_status DESC';
            break;
        case 'passed-in':
            $order_ar = ' pro.stop_bid DESC, pro.confirm_sold ASC';
            $sub_select = ',((SELECT pro_term.value
                                         FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
                                         LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
                                            ON pro_term.auction_term_id = term.auction_term_id
                                         WHERE term.code = \'reserve\'
                                            AND pro.property_id = pro_term.property_id ) - pro.price) AS Order_price ';
            break;
        case 'sold':
            $order_ar = 'pro.confirm_sold DESC';
            break;
        default:
            //$order_ar = ' pro.confirm_sold, pro.stop_bid,pro.pay_status, pro.property_id DESC';
            $order_ar = ' pro.confirm_sold, pro.stop_bid,pro.property_id DESC';
            break;
    }
    $order_ar = ($order_ar != '') ? ' ORDER BY ' . $order_ar : '';
    $smarty->assign('order_by', $order_by);
    //End Order By
    $min = 0;
    $max = 5;
    $where_clause = '';
    //unset($_SESSION['type_prev']);
    $_SESSION['type_prev'] = 'my_detail';
    unset($_SESSION['wh_str']);
    if (in_array($_SESSION['agent']['type'], array('theblock', 'agent'))) {
        $where_clause .= ' AND (pro.agent_id IN (SELECT agent_id FROM ' . $agent_cls->getTable() . ' WHERE parent_id = ' . $_SESSION['agent']['id'] . ')
                                OR IF(ISNULL(pro.agent_manager)
                                      OR pro.agent_manager = 0
                                      OR (SELECT parent_id FROM ' . $agent_cls->getTable() . ' WHERE agent_id = ' . $_SESSION['agent']['id'] . ') = 0
                                      ,pro.agent_id = ' . $_SESSION['agent']['id'] . '
                                      , pro.agent_manager = ' . $_SESSION['agent']['id'] . '))';
    } else {
        $where_clause = ' AND pro.agent_id = ' . $_SESSION['agent']['id'];
    }
    if ($act == 'view-property') {
        $min = (($p - 1) * $len);
        $max = $len;
    } elseif ($act == 'view-auction') {
        $min = (($p - 1) * $len);
        $max = $len;
        $where_clause .= '  AND pro.auction_sale = ' . $auction_sale_ar['auction'] . '
                            AND pro.confirm_sold = ' . Property::SOLD_UNKNOWN . '
                            AND (pro.stop_bid = 0
                            OR   pro.pay_status != ' . Property::PAY_COMPLETE . ')';
    }
    $sql = 'SELECT SQL_CALC_FOUND_ROWS DISTINCT pro.property_id,
	                                   pro.address,
									   pro.kind,
									   pro.parking,
	                                   pro.description,
	                                   pro.price, pro.suburb,
	                                   pro.stop_bid,
	                                   pro.postcode,
	                                   pro.end_time,
	                                   pro.open_for_inspection,
	                                   pro.pay_status,
								       pro.agent_active,
								       pro.active,
								       pro.step,
								       pro.suburb,
								       pro.package_id,
								       pro.start_time,
								       pro.release_time,
								       pro.confirm_sold,
								       pro.sold_time,
									   pro.livability_rating_mark,
								       pro.green_rating_mark,
								       pro.owner,
								       pro.set_count,
								       pro.agent_id,
								       pro.agent_manager,
								       pro.show_agent_logo,
								       pro.price_on_application,
								       pro.period,
								       pro.auction_sale,
								       pro.buynow_status,

			        (SELECT CONCAT(a.firstname,\' \',a.lastname) FROM ' . $agent_cls->getTable() . ' AS a
			         WHERE a.agent_id = pro.agent_id) AS agent_name,

					(SELECT reg1.name FROM ' . $region_cls->getTable() . ' AS reg1 WHERE reg1.region_id = pro.state) AS state_name,
					(SELECT reg2.code FROM ' . $region_cls->getTable() . ' AS reg2 WHERE reg2.region_id = pro.state) AS state_code,
					(SELECT reg3.name FROM ' . $region_cls->getTable() . ' AS reg3 WHERE reg3.region_id = pro.country) AS country_name,
					(SELECT reg4.code FROM ' . $region_cls->getTable() . ' AS reg4 WHERE reg4.region_id = pro.country) AS country_code,

					(SELECT pro_term.value
					     FROM ' . $property_cls->getTable('property_term') . ' AS pro_term LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
                         ON pro_term.auction_term_id = term.auction_term_id
                         WHERE term.code = "auction_start_price" AND pro.property_id = pro_term.property_id) AS start_price,

					(SELECT pro_opt1.value
						FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt1
						WHERE pro_opt1.property_entity_option_id = pro.bathroom) AS bathroom_value,

					(SELECT pro_opt2.value
						FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt2
						WHERE pro_opt2.property_entity_option_id = pro.bedroom) AS bedroom_value,

					(SELECT pro_opt3.value
						FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt3
						WHERE pro_opt3.property_entity_option_id = pro.car_port) AS carport_value,

					(SELECT pro_opt5.title
						FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt5
						WHERE pro_opt5.property_entity_option_id = pro.land_size) AS landsize_title,

					(SELECT pro_opt6.code
						FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt6
						WHERE pro_opt6.property_entity_option_id = pro.auction_sale) AS auction_sale_code,

					(SELECT pro_opt6.title
						FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt6
						WHERE pro_opt6.property_entity_option_id = pro.auction_sale) AS auction_sale_title,

					(SELECT pro_opt8.value
                        FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt8
                        WHERE pro_opt8.property_entity_option_id = pro.car_space
                        ) AS carspace_value,

					(SELECT pt.value
						FROM ' . $property_cls->getTable('property_term') . ' AS pt,' . $property_cls->getTable('auction_terms') . ' AS at
						WHERE pt.property_id = pro.property_id AND pt.auction_term_id = at.auction_term_id AND at.code = "reserve" LIMIT 0,1)	AS reserve,

                    (SELECT pro_opt6.code
                        FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt6
                        WHERE pro_opt6.property_entity_option_id = pro.period
                        ) AS period,

					(SELECT CASE
            					WHEN pro.auction_sale != ' . $auction_sale_ar['private_sale'] . ' AND ( date(pro.start_time) > \'' . date('Y-m-d H:i:s') . '\' OR isnull(max(bid.price)) ) THEN

									(SELECT pro_term.value
									 FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
									 LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term ON pro_term.auction_term_id = term.auction_term_id
									 WHERE term.code = \'auction_start_price\' AND pro.property_id = pro_term.property_id)

            					WHEN auction_sale = ' . $auction_sale_ar['private_sale'] . ' AND pro.price != 0 THEN pro.price
                                WHEN auction_sale = ' . $auction_sale_ar['private_sale'] . ' AND pro.price = 0 AND pro.price_on_application != 0 THEN pro.price_on_application
            				ELSE max(bid.price)
            				END
            		FROM bids AS bid WHERE bid.property_id = pro.property_id) AS bid_price,

					(SELECT MAX(bid.price)
						FROM ' . $property_cls->getTable('bids') . ' AS bid
						WHERE bid.property_id = pro.property_id ) AS bid_prices

					' . $sub_select . '

			FROM ' . $property_cls->getTable() . ' AS pro
			WHERE 1
            ' . $where_clause . '
            ' . $order_ar . '
			LIMIT ' . $min . ',' . $max;
    //echo'<pre>'; print_r($sql); echo '</pre>';
    $rows = $property_cls->getRows($sql, true);
    $total_row = $property_cls->getFoundRows();
    $review_pagging = (($p - 1) * $len) . ' - ' . (($p * $len) > $total_row ? $total_row : ($p * $len)) . ' (' . $total_row . ' Items)';
    if ($act == 'view-dashboard') {
        $review_pagging = ' 0 - 5 (' . $total_row . ' Items)';
    }
    $v = 'view-property';
    if ($act == 'view-auction')
        $v = 'view-auction';
    if ($mode_fix == 'grid') {
        $pag_cls->setTotal($total_row)
            ->setPerPage($len)
            ->setCurPage($p)
            ->setLenPage(10)
            ->setUrl('/?module=agent&action=' . $v . '&mode=grid')
            ->setLayout('link_simple');
    } else {
        $pag_cls->setTotal($total_row)
            ->setPerPage($len)
            ->setCurPage($p)
            ->setLenPage(10)
            ->setUrl('/?module=agent&action=' . $v . '&')
            ->setLayout('link_simple');
    }
    $smarty->assign('mode_fix', $mode_fix);
    $smarty->assign('review_pagging', $review_pagging);
    $smarty->assign('pag_str', $pag_cls->layout());
    $results = array();
    $_options = PEO_getOptions('auction_sale', array(), 1);
    if ($property_cls->hasError()) {
    } else if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $k => $row) {
            $link_ar = array('module' => 'property', 'action' => 'register', 'step' => $row['step'], 'id' => $row['property_id']);
            $end_time = $row['end_time'];
            $start_time = $row['start_time'];
            $type = PEO_getOptionById($row['auction_sale']);
            $row['pro_type_code'] = $type['code'];
            if ($row['pay_status'] == Property::PAY_PENDING && PO_hasOptions($row['property_id'])) {
                $step = 7;
            } else if (in_array($row['step'], range(1, 7))) {
                $step = $row['step'];
            }
            if ($step == 7 and $row['stop_bid'] == 1 and $row['pay_status'] != Property::PAY_COMPLETE) {
                $step = 6;
            }
            $row['isBlock'] = PE_isTheBlock($row['property_id']) ? 1 : 0;
            $row['ofAgent'] = PE_isTheBlock($row['property_id'], 'agent') ? 1 : 0;
            // Begin set type and title of property
            $auction_option = PEO_getOptionById($auction_sale_ar[$row['auction_sale_code']]);
            $title = $row['auction_sale'] == $auction_sale_ar['auction'] ? 'AUCTION' : strtoupper($auction_option['title']);
            if (in_array($row['auction_sale_code'], array('auction', 'ebiddar', 'ebidda30', 'bid2stay'))) {
                $type = 'auction';
                if ($row['start_time'] != '0000-00-00 00:00:00' && $row['end_time'] != '0000-00-00 00:00:00') {
                    $dt = new DateTime($row['end_time']);
                    $dt1 = new DateTime($row['start_time']);
                    $row['end_time_format'] = $dt->format($config_cls->getKey('general_date_format'));
                    if($row['start_time'] >= '5000-05-05 00:00:00' && $row['end_time'] >= '5000-06-06 00:00:00'){
                        $row['titles'] =  'FOR ' . (PE_isRentProperty($row['property_id']) ? 'RENT' : 'SALE') . '';
                    }elseif ($row['start_time'] > date('Y-m-d H:i:s')
                        OR ($row['confirm_sold'] == Property::SOLD_COMPLETE AND $row['sold_time'] < $row['start_time'])
                    ) {// Date() : Time of mellbourl.
                        $type = 'forthcoming';
                        $row['type'] = 'forthcoming';
                        //$row['titles'] = $title . ' ENDS: ' . $row['end_time_format'];
                        $row['titles'] =  'AUCTION STARTS : ' . $dt1->format($config_cls->getKey('general_date_format') . ' @ g:i');
                        $row['start_time'] = $dt1->format('d-m-Y' . ' @ g:i');
                    } else {
                        if ($row['end_time'] < date('Y-m-d H:i:s')) {
                            $row['type'] = 'stop_auction';
                            //$row['titles'] = $title . ' ENDED: ' . $row['end_time_format'];
                            $row['titles'] = Localizer::translate('AUCTION ENDED') . ': ' . $dt->format($config_cls->getKey('general_date_format'));
                        } else {
                            $row['type'] = 'live_auction';
                            //$row['titles'] = $title . ' ENDS: ' . $row['end_time_format'];
                            $row['titles'] = Localizer::translate('AUCTION ENDS') . ': <span class="auc-time-'.$row['property_id'].'"></span>';
                            $row['remain_time'] = remainTime($end_time);
                            if($row['stop_bid'] == 1){
                                $row['titles'] = Localizer::translate('AUCTION ENDED');
                            }
                        }
                    }
                } else {
                    $row['type'] = 'no_finish_auction';
                    $row['titles'] = 'AUCTION ';
                    $row['bid_price'] = $row['price'];
                }
            } else {
                $row['type'] = 'sale';
                $type = 'sale';
                $row['titles'] = 'FOR SALE : ' . $row['suburb'];
            }
            //End

            $row['advertised_price'] = showAdvertisedPrice($row['property_id']);
            $row['titles'] = $row['isBlock'] == 1 ? 'OWNER: ' . $row['owner'] : $row['titles'];
            if ($row['ofAgent']) $row['agent'] = A_getCompanyInfo($row['property_id']);
            $row['titles'] = $row['ofAgent'] == 1 ? 'AGENT : ' . $row['agent']['company_name'] : $row['titles'];
            $row['titles'] = ucwords(strtolower($row['titles']));
            $results[$k]['info'] = $row;
            //Begin Format price (Bid_price is price, bid_price,start_price)
            if ($row['type'] == 'forthcoming') {
                $reserve_price = PT_getValueByCode($row['property_id'], 'reserve');
                $results[$k]['info']['bid_price'] = $row['price_on_application'] == 1 ? 'Price On Application' : showLowPrice($reserve_price) . ' - ' . showHighPrice($reserve_price);
                if ($mode_fix == 'grid') {
                    $results[$k]['info']['bid_price'] = $row['price_on_application'] == 1 ? 'Price On Application' : showSwingPrice($reserve_price);
                }
                if ($row['auction_sale_code'] == 'ebiddar') {
                    $results[$k]['info']['bid_price'] = $row['price_on_application'] == 1 ? 'Price On Application' : 'Starting rent ' . showPrice($reserve_price);
                }
                if ($row['auction_sale_code'] == 'bid2stay') {
                    $results[$k]['info']['bid_price'] = $row['price_on_application'] == 1 ? 'Price On Application' : 'Starting stay ' . showPrice($reserve_price);
                }
            } else {
                $results[$k]['info']['bid_price'] = showprice($row['bid_price']);
                if ($type == 'sale') {
                    $results[$k]['info']['bid_price'] = $row['price_on_application'] == 1 ? 'Price On Application' : $results[$k]['info']['bid_price'];
                }
            }
            //End
            if($row['release_time'] > '0000-00-00 00:00:00'){
                $dt_release = new DateTime($row['release_time']);
                $results[$k]['info']['release_time'] = $dt_release->format('d F Y g.ia');
            }else{
                unset($results[$k]['info']['release_time']);
            }
            $results[$k]['info']['is_release_time'] = date('Y-m-d H:i:s') > $row['release_time'];
            //Begin Set watermark
            $results[$k]['info']['watermark'] = 'none';
            if ($row['type'] == 'live_auction' && (float)$row['reserve'] <= (float)$row['bid_prices']) {
                $results[$k]['info']['watermark'] = 'market';
            }
            if ($row['type'] == 'stop_auction' && (float)$row['reserve'] <= (float)$row['bid_prices']) {
                $results[$k]['info']['watermark'] = 'sold';
            }
            if ($row['confirm_sold'] == 1) {
                $results[$k]['info']['watermark'] = 'sold';
            }
            //End
            if ($results[$k]['info']['carport_value'] == null AND $results[$k]['info']['parking'] == 1) {
                $results[$k]['info']['carport_value'] = $results[$k]['info']['carspace_value'];
            }
            //Begin Reset pay_status
            $results[$k]['info']['wait_for_activation'] = false;
            if ($row['pay_status'] == Property::PAY_UNKNOWN) {
                $results[$k]['info']['pay_status'] = 'unknown';
                $results[$k]['info']['status'] = $row['type'] == 'sale' ? 'Not complete' : 'No payment';
            }
            if ($row['pay_status'] == Property::PAY_PENDING) {
                $results[$k]['info']['pay_status'] = 'pending';
                $results[$k]['info']['status'] = $row['type'] == 'sale' ? 'Not complete' : 'Payment review';
                $step = 7;
            }
            if ($row['pay_status'] == Property::PAY_COMPLETE) {
                $results[$k]['info']['pay_status'] = 'complete';
                $results[$k]['info']['status'] = 'Enable';
                if ($row['active'] == 0) {
                    $results[$k]['info']['wait_for_activation'] = true;
                }
                if ($row['agent_active'] == 0) {
                    $results[$k]['info']['status'] = 'Disable';
                }
            }
            $results[$k]['info']['buynow_status'] = $row['buynow_status'] == 1 ? 'Yes' : 'No';
            //End
            //Format general
            //$results[$k]['info']['link_detail'] = '?module=property&action=view-'.$type.'-detail&id='.$row['property_id'];
            $results[$k]['info']['link_detail'] = shortUrl(array('module' => 'property',
                'action' => 'view-' . $type . '-detail',
                'id' => $row['property_id'],
                'data' => $row + array('auctionsale_code' => $row['auction_sale_code'])), array());
            /*
            if (PE_isLiveProperty($row['property_id'])) {
                $results[$k]['info']['link_detail'] = '?module=property&action=view-'.$type.'-detail&id='.$row['property_id'];
            }
            */
            $reaxml_status = PE_getPropertyStatusREA_xml($row['property_id']);
            $reaxml_status = str_replace(' ', '_',strtolower($reaxml_status));
            $results[$k]['info']['reaxml_status'] = $reaxml_status;
            $results[$k]['info']['full_address'] = $row['address'] . ' ' . $row['suburb'] . ' ' . $row['postcode'] . ' ' . $row['state_name'] . ' ' . $row['country_name'];
            $results[$k]['info']['livability_rating_mark'] = showStar((float)$row['livability_rating_mark']);
            $results[$k]['info']['green_rating_mark'] = showStar((float)$row['green_rating_mark']);
            $results[$k]['info']['description'] = safecontent(formUnescape($row['description']), 100);
            if (strlen($row['description']) > 200) {
                $results[$k]['info']['description'] = safecontent(formUnescape($row['description']), 200) . '...';
            }
            //$results[$k]['info']['description'] = nl2br($row['description']);
            //print_r(htmlentities($results[$k]['info']['description']));
            $results[$k]['info']['price'] = showPrice($row['price']);

            if ($row['confirm_sold'] == 1) {
                $results[$k]['info']['count'] = 'Sold';
            } else {
                if ($results[$k]['info']['remain_time'] <= $count['once'] and $results[$k]['info']['remain_time'] > $count['twice']) {
                    $results[$k]['info']['count'] = 'Going Once';
                } elseif ($results[$k]['info']['remain_time'] <= $count['twice'] and $results[$k]['info']['remain_time'] > $count['third']) {
                    $results[$k]['info']['count'] = 'Going Twice';
                } elseif ($results[$k]['info']['remain_time'] <= $count['third'] and $row['stop_bid'] != 1) {
                    $results[$k]['info']['count'] = 'Third and Final call';
                } else {
                    $results[$k]['info']['count'] = '';
                }
            }
            $results[$k]['o4i'] = Calendar_createPopup($row['property_id'], $row['open_for_inspection']);
            //BEGIN GET START PRICE
            $start_price = PT_getValueByCode($row['property_id'], 'auction_start_price');
            $results[$k]['info']['check_start'] = ((int)$start_price == (int)$row['bid_price']) ? 'true' : 'false';
            if (!isset($row['bid_price']) OR $row['bid_price'] == '' OR $row['bid_price'] <= 0) {
                $row['bid_price'] = '0';
            }
            // MAKE AN OFFER
            $type_pro = PE_Get_type_property($row['property_id']);
            $off_price = $row['bid_price'];
            /*if($type_pro == 'forth_auction')
            {
                $off_price = ($off_price*90)/100;
            }*/
            if ($row['confirm_sold'] == Property::SOLD_UNKNOWN) {
                if ($row['type'] == 'live_auction')
                    $row_mess = $property_cls->getRows('SELECT DISTINCT msg.agent_id_from
                            FROM ' . $property_cls->getTable('message') . ' AS msg
                            WHERE msg.entity_id = ' . $row['property_id'] . ' AND msg.abort = 0 AND msg.offer_price > ' . $off_price . '
                            ORDER BY msg.send_date DESC', true);
                else
                    $row_mess = $property_cls->getRows('SELECT DISTINCT msg.agent_id_from
                            FROM ' . $property_cls->getTable('message') . ' AS msg
                            WHERE msg.entity_id = ' . $row['property_id'] . ' AND msg.abort = 0
                            ORDER BY msg.send_date DESC', true);
                if (is_array($row_mess) and count($row_mess) > 0) {
                    $results[$k]['info']['mao_num'] = count($row_mess);
                }
            } else {
                // update abort =1
                $message_cls->update(array('abort' => 1), 'entity_id=' . $row['property_id']);
            }
            //Begin confirm sold status
            $results[$k]['info']['confirm_sold'] = 'Sold';
            if ($row['confirm_sold'] == 0) {
                $results[$k]['info']['confirm_sold'] = 'None';
            }
            //end
            //BEGIN property_history
            $results[$k]['history'] = '';
            $row_history = $property_cls->getRows('SELECT pro_his.property_id FROM ' . $property_cls->getTable('property_transition_history') . ' AS pro_his
                                                                            WHERE property_id=' . $row['property_id'], true);
            if (is_array($row_history) && count($row_history) > 0) {
                $smarty->assign('property_id', $row['property_id']);
                $_str = '<a href="javascript:void(0)"  onClick="show_history(' . $row['property_id'] . ')" class="history" style="color:#CC8C04; text-decoration:none">History - </a>';
                if ($mode_fix == 'grid') {
                    $_str = '<a href="javascript:void(0)"  onClick="show_history(' . $row['property_id'] . ')" class="history" style="color:#CC8C04; text-decoration:none">History - </a>';
                }
                $smarty->assign('property_id', $row['property_id']);
                $_str .= $smarty->fetch(ROOTPATH . '/modules/property/templates/property.history.popup.tpl');
                $results[$k]['history'] = $_str;
            }
            //END
            //Begin Link
            if ($act == 'view-auction') {
                if ($row['pay_status'] == Property::PAY_COMPLETE or $row['pay_status'] == Property::PAY_PENDING) {
                    $link_ar['step'] = 6;
                } else {
                    if (($row['end_time'] != '0000-00-00 00:00:00' and $row['start_time'] != '0000-00-00 00:00:00') or $step > 5)
                        $link_ar['step'] = 6;
                    else
                        $link_ar['step'] = $step;
                }
            } else {
                $link_ar['step'] = $step;
            }
            $results[$k]['info']['link'] = '/?' . http_build_query($link_ar);
            $results[$k]['info']['link_edit'] = '/?' . http_build_query($link_ar);
            $results[$k]['info']['agent_id'] = in_array($_SESSION['agent']['type'], array('theblock', 'agent')) && ($row['agent_manager'] != '' || $row['agent_manager'] != 0) ?
                $row['agent_manager'] : $row['agent_id'];
            //Link For delete a property
            $link_ar['action'] = 'delete';
            if (count($rows) == 1) {
                $page = $page - 1;
            }
            $results[$k]['info']['link_del'] = '/?' . http_build_query($link_ar) . '&redirect=' . $act . '&mode=' . $mode_fix . '&page=' . $page;
            $link_ar['action'] = 'cancel_bidding';
            $results[$k]['info']['link_cancel_bidding'] = '/?' . http_build_query($link_ar) . '&redirect=' . $act . '&mode=' . $mode_fix . '&page=' . $page;
            $_media = PM_getPhoto($row['property_id'], true);
            $results[$k]['photos'] = $_media['photo_thumb'];
            $results[$k]['photo_default'] = $_media['photo_thumb_default'];
            $results[$k]['photos_count'] = count($_media['photo_thumb']);
            //End
            $results[$k]['info']['ebidda_watermark'] = PE_getEbiddaWatermark($row['property_id']);
            //BEGIN AGENT
            $results[$k]['info']['bidder'] = '-:-';
            $results[$k]['info']['bidder'] = Bid_getShortNameLastBidder($row['property_id']);
            //END
            if ($row['active'] == 1 and $row['pay_status'] == Property::PAY_COMPLETE) {
                $row_comment = $package_cls->getRow('package_id= ' . $row['package_id']);
                if (is_array($row_comment) and count($row_comment) > 0)
                    if ((int)$row_comment['can_comment'] == 1) {
                        $results[$k]['comment'] = array();
                        $results[$k]['comment']['num'] = Comment_count((int)$row['property_id']);
                        $results[$k]['comment']['link'] = ROOTURL . '/?module=agent&action=view-comment&property_id=' . $row['property_id'];
                        if ($results[$k]['comment']['num'] > 0) {
                            $results[$k]['comment']['comment'] = 'Comment (' . Comment_count((int)$row['property_id']) . ')';
                        }
                    }
            }
            $results[$k]['allowActive'] = PE_allowActive($row['property_id']);
            $results[$k]['isLastBidVendor'] = Bid_isLastBidVendor($row['property_id']);
            $results[$k]['num_note'] = Note_count("entity_id_to = " . $row['property_id'] . " AND entity_id_from = " . $_SESSION['agent']['id'] . " AND type = 'customer2property'");
            //END
            $results[$k]['info']['reserve_price'] = showPrice($row['reserve']);
            //BEGIN RESET PROPERTY
            if ($end_time < date('Y-m-d H:i:s') && $row['pay_status'] == Property::PAY_COMPLETE
                AND $row['stop_bid'] = 1
                AND ((float)$row['bid_prices'] < (float)$row['reserve'] OR Bid_isLastBidVendor($row['property_id']))
                AND $row['auction_sale_code'] != 'private_sale'
                AND $row['confirm_sold'] == Property::SOLD_UNKNOWN
            ) {
//                if ($_SESSION['agent']['type'] != 'agent'){
//                    $results[$k]['reset_options'] = array('' => 'Select',
//												ROOTURL.'?module=agent&action=view-property-rs-sale&id='.$row['property_id'] => 'For Sale',
//												ROOTURL.'?module=agent&action=view-property-rs-live&id='.$row['property_id'] => 'Auction'
//												);
//                }else{
//                    $reset_options = array();
//                    $reset_options[''] = 'Select';
//                    foreach ($_options as $key=>$label){
//                        $auction_option = PEO_getOptionById($key);
//                        $_key = ROOTURL.'?module=agent&action=view-property-rs-live&type='.$auction_option['code'].'&id='.$row['property_id'];
//                        $reset_options[$_key] = $label;
//                    }
//                    $results[$k]['reset_options'] = $reset_options;
//                    /*$results[$k]['reset_options'] = array('' => 'Select',
//												ROOTURL.'?module=agent&action=view-property-rs-live&type=ebidda30&id='.$row['property_id'] => 'eBidda30',
//												ROOTURL.'?module=agent&action=view-property-rs-live&type=auction&id='.$row['property_id'] => 'eBidda Agent',
//                                                ROOTURL.'?module=agent&action=view-property-rs-live&type=ebiddar&id='.$row['property_id'] => 'eBiddaR'
//												);*/
//                }
                $_options = PEO_getOptions('auction_sale', array(), $_SESSION['agent']['type'] == 'agent');
                $reset_options = array();
                $reset_options[''] = 'Select';
                foreach ($_options as $key => $label) {
                    $auction_option = PEO_getOptionById($key);
                    if ($auction_option['active']) {
                        if ($auction_option['code'] == 'private_sale') {
                            $_key = ROOTURL . '?module=agent&action=view-property-rs-sale&id=' . $row['property_id'];
                        } else {
                            $_key = ROOTURL . '?module=agent&action=view-property-rs-live&type=' . $auction_option['code'] . '&id=' . $row['property_id'];
                        }
                        $reset_options[$_key] = $label;
                    }
                }
                $results[$k]['reset_options'] = $reset_options;
            }
            //END
            $results[$k]['re_active_popup'] = A_requireActive($row['property_id']);
        }//End foreach
    }
    $form_action = array('module' => 'agent', 'action' => '');
    if ($act == 'view-property') {
        $form_action = array('module' => 'agent', 'action' => 'view-property');
        $title_bar = 'MY PROPERTY DETAILS';
    }
    if ($act == 'view-auction') {
        $form_action = array('module' => 'agent', 'action' => 'view-auction');
        $title_bar = 'MANAGE AUCTION TERMS';
        $smarty->assign('page', 'view-auction');
        $smarty->assign('order_by_action', 'view-auction');
    }
    if ($act == 'view-property-vendor') {
        $form_action = array('module' => 'agent', 'action' => 'view-property-vendor');
        $title_bar = 'EDIT EXISTING PROPERTY';
        $smarty->assign('order_by_action', 'view-property-vendor');
    }
    if ($act == 'view-property-buyer') {
        $form_action = array('module' => 'agent', 'action' => 'view-property-buyer');
        $title_bar = 'LIST PROPERTY';
        $smarty->assign('order_by_action', 'view-property-buyer');
    }
    if ($act == 'view-dashboard') {
        $form_action = array('module' => 'agent', 'action' => 'view-dashboard');
    }
    if (in_array($_SESSION['agent']['type'], array('theblock', 'agent'))) {
        $smarty->assign('agent_options', A_getChildId($_SESSION['agent']['id'],
            array(0 => array('value' => 'Select...', 'active' => 1),
                $_SESSION['agent']['id'] => array('value' => $_SESSION['agent']['firstname'] . ' ' . $_SESSION['agent']['lastname'],
                    'active' => 1))));
    }
    $smarty->assign('act', $act);
    $smarty->assign('len', $len);
    $smarty->assign('len_ar', PE_getItemPerPage());
    $smarty->assign('property_title_bar', $title_bar);
    $form_action = '/?' . http_build_query($form_action);
    $smarty->assign('form_action', $form_action);
    $check_agent = (AI_isBasic($_SESSION['agent']['id'])) ? 'true' : 'false';
    $smarty->assign('check_agent', $check_agent);
    $smarty->assign('form_data', formUnescapes($form_data));
    $smarty->assign('results', formUnescapes($results));
}

/**
 * @ function : A_getChildId
 **/
function A_getChildId($parent, $default = array())
{
    global $agent_cls;
    $options = (is_array($default) and count($default) > 0) ? $default : array();
    $rows = $agent_cls->getRows('SELECT agent_id, firstname, lastname, is_active
                                 FROM ' . $agent_cls->getTable() . '
                                 WHERE parent_id = ' . $parent, true);
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            $options[$row['agent_id']] = array('value' => $row['firstname'] . ' ' . $row['lastname'],
                'active' => $row['is_active']);
        }
    }
    return $options;
}

/**
 * @ function : A_getChildSimple
 **/
function A_getChildSimple($parent)
{
    global $agent_cls;
    if ($parent <= 0) {
        return array();
    }
    $rows = $agent_cls->getRows('SELECT agent_id, firstname, lastname,is_active
                                 FROM ' . $agent_cls->getTable() . '
                                 WHERE parent_id = ' . $parent, true);
    $options = array();
    $options[] = $parent;
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            $options[] = $row['agent_id'];
        }
    }
    return $options;
}

function A_getCompanyInfo($property_id)
{
    global $company_cls, $property_cls, $agent_cls;
    $row = $company_cls->getRow('SELECT c.*
                                 FROM ' . $company_cls->getTable() . ' AS c
                                 WHERE agent_id IN
                                 (SELECT IF(a.parent_id = 0,a.agent_id,a.parent_id)
                                  FROM ' . $agent_cls->getTable() . ' AS a
                                  WHERE a.agent_id IN (SELECT IF(ISNULL(pro.agent_manager) OR pro.agent_manager = \'\',
                                                             pro.agent_id,
                                                             pro.agent_manager)
                                                      FROM ' . $property_cls->getTable() . ' AS pro
                                                      WHERE pro.property_id = ' . $property_id . ')
                                  )', true);
    if (is_array($row) and count($row) > 0) {
        $row['website'] = str_replace(array('http://', 'https://'), '', $row['website']);
        $row['logo'] = strlen($row['logo']) > 0 ? $row['logo'] : '/modules/general/templates/images/photo_default.jpg';
        $row['full_address'] = $row['address'] . ', ' . implode(' ', array($row['suburb'], $row['state_code'], $row['other_state'], $row['postcode'], $row['country_name']));
        $row['link'] = Agent_seoURL('?module=agent&action=view-detail-agency&uid=' . $row['agent_id']);
        $row['short_description'] = strlen($row['description']) > 100 ? safecontent(strip_tags($row['description']), 100) : strip_tags($row['description']);
        $row['short_description'] .= ' <a href="javascript:void(0)" style="color:#CC8C04" class="seemore-des">[See more...]</a>';
        $row['description'] = strip_tags($row['description']) . ' <a href="javascript:void(0)" style="color:#CC8C04" class="seemore-des">[Hide]</a>';
        return $row;
    }
    return null;
}

function A_getAgentManageInfo($property_id)
{
    global $company_cls, $property_cls, $agent_cls, $region_cls;
    $row = $company_cls->getRow('SELECT c.*,
                                 a.agent_id,
                                 a.firstname,
                                 a.lastname,
                                 a.type_id,
                                 a.email_address AS agent_email,
                                 a.notify_sms,
							     a.mobilephone,
								 a.notify_email,
								 a.notify_email_bid,
                                 (SELECT r1.code
                                  FROM ' . $region_cls->getTable('regions') . ' AS r1
                                  WHERE r1.region_id = c.state) AS state_code,

                                 (SELECT r2.name
                                  FROM ' . $region_cls->getTable('regions') . ' AS r2
                                  WHERE r2.region_id = c.country) AS country_name

                                 FROM ' . $agent_cls->getTable() . ' AS a
                                 LEFT JOIN ' . $company_cls->getTable() . ' AS c
                                 ON a.agent_id = c.agent_id

                                 WHERE a.agent_id IN
                                 (SELECT IF(ISNULL(pro.agent_manager) OR pro.agent_manager = \'\',
                                                             pro.agent_id,
                                                             pro.agent_manager)
                                                      FROM ' . $property_cls->getTable() . ' AS pro
                                                      WHERE pro.property_id = ' . $property_id . '
                                 )', true);
    if (is_array($row) and count($row) > 0) {
        if ($row['company_id'] > 0) {
            $row['logo'] = strlen($row['logo']) > 0 ? $row['logo'] : '/modules/general/templates/images/photo_default.jpg';
            $row['full_name'] = $row['firstname'] . ' ' . $row['lastname'];
            $row['website'] = str_replace(array('http://', 'https://'), '', $row['website']);
            $row['full_address'] = $row['address'] . ', ' . implode(' ', array($row['suburb'], $row['state_code'], $row['other_state'], $row['postcode'], $row['country_name']));
            $row['link'] = Agent_seoURL('?module=agent&action=view-detail-agency&uid=' . $row['agent_id']);
        }
        $type_arr = AgentType_getOptions();
        if ($type_arr[$row['type_id']] == 'theblock') {
            $row['short_description'] = strlen($row['description']) > 200 ? safecontent(strip_tags($row['description']), 200) : strip_tags($row['description']);
            $row['short_description'] .= ' <a href="javascript:void(0)" style="color:#CC8C04" class="seemore-des">[See more...]</a>';
            $row['description'] = $row['description'] . ' <a href="javascript:void(0)" style="color:#CC8C04" class="seemore-des">[Hide]</a>';
        } elseif ($type_arr[$row['type_id']] == 'agent') {
            //$browserMobile = detectBrowserMobile();
            /*if ($browserMobile || true) {
                $row['short_description'] = strlen($row['description']) > 100 ? safecontent(strip_tags($row['description']), 100) : strip_tags($row['description']);
                $row['short_description'] .= ' <a href="javascript:void(0)" style="color:#CC8C04" class="seemore-des">[See more...]</a>';
            } else {
                $row['description'] = strlen($row['description']) > 100 ? safecontent(strip_tags($row['description']), 100) : strip_tags($row['description']);
                $row['description'] .= ' <a href="' . Agent_seoURL('?module=agent&action=view-detail-agent&uid=' . $row['agent_id']) . '" style="color:#CC8C04">[See more...]</a>';
            }*/
            $row['short_description'] = strlen($row['description']) > 100 ? safecontent(strip_tags($row['description']), 100) : strip_tags($row['description']);
            $row['short_description'] .= ' <a href="javascript:void(0)" style="color:#CC8C04" class="seemore-des">[See more...]</a>';
            $row['description'] = strip_tags($row['description']) . ' <a href="javascript:void(0)" style="color:#CC8C04" class="seemore-des">[Hide]</a>';
        }
        return $row;
    }
    return null;
}

function A_getParentOption($type_id, $def = array())
{
    global $agent_cls;
    $rows = $agent_cls->getCRows(array('agent_id', 'firstname', 'lastname'), 'type_id = ' . $type_id . ' AND parent_id = 0 AND is_active = 1');
    $options = $def != null ? $def : array();
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            $options[$row['agent_id']] = $row['firstname'] . ' ' . $row['lastname'];
        }
    }
    return $options;
}

function A_getAgentParentInfo($agent_id = 0)
{
    if ($agent_id > 0) {
        global $company_cls, $agent_cls, $agent_site_cls;
        $row = $company_cls->getRow('SELECT c.*,
                                            a.firstname,
                                            a.lastname,
                                            a.agent_id,
                                            s.name AS site_name
                                     FROM ' . $agent_cls->getTable() . ' AS a
                                     LEFT JOIN ' . $company_cls->getTable() . ' AS c
                                     ON a.agent_id = c.agent_id
                                     LEFT JOIN ' . $agent_site_cls->getTable() . ' AS s
                                     ON a.agent_id = s.agent_id AND type = \'agency\'
                                     WHERE a.agent_id = (SELECT IF(a1.parent_id > 0,a1.parent_id,a1.agent_id)
                                                         FROM ' . $agent_cls->getTable() . ' AS a1
                                                         WHERE a1.agent_id = ' . $agent_id . ')'
            , true);
        if (is_array($row) and count($row) > 0) {
            if ($row['company_id'] > 0)
                $row['link'] = Agent_seoURL('?module=agent&action=view-detail-agency&uid=' . $row['agent_id']);
            return $row;
        }
    }
    return null;
}

function Agent_getCurrentPackage($agent_id)
{
    global $agent_cls, $agent_payment_cls;
    $row = $agent_cls->getCRow(array('parent_id'), 'agent_id = ' . $agent_id);
    $package = array();
    if (is_array($row) and count($row) > 0) {
        $parent_id = $row['parent_id'] > 0 ? $row['parent_id'] : $agent_id;
        $package_arr = $agent_payment_cls->getCRow(array('package_id'), 'agent_id = ' . $parent_id . "
                                                        AND date_from <= '" . date('Y-m-d H:i:s') . "' AND date_to >= '" . date('Y-m-d H:i:s') . "'");
        if (is_array($package_arr) and count($package_arr) > 0) {
            $package = PK_getPackage($package_arr['package_id']);
        }
    }
    return $package;
}

function Agent_getBidderInfo($agent_id, $short_name = true)
{
    global $agent_cls, $partner_cls, $company_cls, $region_cls;
    $row = $agent_cls->getRow('SELECT a.agent_id,
                                      a.firstname,
                                      a.lastname,
                                      t.title,
                                      a.street,
                                      a.suburb,
                                      a.other_state,
                                      a.postcode,
                                      a.email_address,
                                      a.telephone,
                                      a.mobilephone,
                                      p.register_number,
                                      c.suburb AS c_suburb,
                                      c.other_state AS c_other_state,
                                      c.postcode AS c_postcode,
                                      c.email_address AS c_email_address,
                                      c.telephone AS c_telephone,
                                      (SELECT r1.code
                                       FROM ' . $region_cls->getTable('regions') . ' AS r1
                                       WHERE r1.region_id = a.state) AS state_code,

                                       (SELECT r2.name
                                        FROM ' . $region_cls->getTable('regions') . ' AS r2
                                        WHERE r2.region_id = a.country) AS country_name,

                                      (SELECT r1.code
                                       FROM ' . $region_cls->getTable('regions') . ' AS r1
                                       WHERE r1.region_id = c.state) AS c_state_code,

                                      (SELECT r2.name
                                       FROM ' . $region_cls->getTable('regions') . ' AS r2
                                       WHERE r2.region_id = c.country) AS c_country_name

                               FROM ' . $agent_cls->getTable() . ' AS a
                               LEFT JOIN ' . $partner_cls->getTable() . ' AS p
                               ON p.agent_id = a.agent_id
                               LEFT JOIN ' . $company_cls->getTable() . ' AS c
                               ON a.agent_id = c.agent_id
                               INNER JOIN ' . $agent_cls->getTable('agent_type') . ' AS t
                               ON a.type_id = t.agent_type_id
                               WHERE a.agent_id = ' . $agent_id, true);
    $html = '';
    if (is_array($row) and count($row) > 0) {
        $html = '<table class="t-tooltip">';
        switch ($row['title']) {
            case 'vendor':
            case 'buyer':
                //$row['name'] = $row['firstname'].' '.$row['lastname'];
                $row['name'] = $short_name ? getShortName($row['firstname'], $row['lastname']) : $row['firstname'] . ' ' . $row['lastname'];
                $row['address'] = $row['street'] . ' ' . implode(' ', array($row['suburb'], $row['state_code'], $row['other_state'], $row['postcode'], $row['country_name']));
                $html .= '<tr>
                            <td colspan="2" class="name">' . $row['name'] . '</td>
                            <td style="text-align:right"><span style="f-left" onclick="$(\'.tipsy\').remove();">x</span></td>
                          </tr>
                          <tr>
                            <td>Address</td>
                            <td>' . $row['address'] . '</td>
                          </tr>
                          <tr>
                            <td>Email</td>
                            <td>' . $row['email_address'] . '</td>
                          </tr>
                          <tr>
                            <td>Telephone</td>
                            <td>' . $row['telephone'] . '</td>
                          </tr>
                          <tr>
                            <td>Mobilephone</td>
                            <td>' . $row['mobilephone'] . '</td>
                          </tr>';
                break;
            case 'partner':
                $row['name'] = $row['firstname'] . ' ' . $row['lastname'];
                $row['address'] = $row['street'] . ' ' . implode(' ', array($row['street'], $row['suburb'], $row['state_code'], $row['other_state'], $row['postcode'], $row['country_name']));
                $html .= '<tr>
                                            <td colspan="2" class="name">' . $row['name'] . '</td>
                                            <td style="text-align:right"><span style="f-left" onclick="$(\'.tipsy\').remove();">x</span></td>
                                          </tr>
                                          <tr>
                                            <td>ACN / ABN</td>
                                            <td>' . $row['register_number'] . '</td>
                                          </tr>
                                          <tr>
                                            <td>Address</td>
                                            <td>' . $row['address'] . '</td>
                                          </tr>
                                          <tr>
                                            <td>Email</td>
                                            <td>' . $row['email_address'] . '</td>
                                          </tr>
                                          <tr>
                                            <td>Telephone</td>
                                            <td>' . $row['telephone'] . '</td>
                                          </tr>
                                         ';
                break;
            case 'theblock':
            case 'agent':
                $row['name'] = $row['firstname'] . ' ' . $row['lastname'];
                $row['address'] = $row['address'] . ' ' . implode(' ', array($row['c_suburb'], $row['c_state_code'], $row['c_other_state'], $row['c_postcode'], $row['c_country_name']));
                $html .= '<tr>
                                            <td colspan="2" class="name">' . $row['name'] . '</td>
                                            <td style="text-align:right"><span style="f-left" onclick="$(\'.tipsy\').remove();">x</span></td>
                                          </tr>
                                          <tr>
                                            <td>Address</td>
                                            <td>' . $row['address'] . '</td>
                                          </tr>
                                          <tr>
                                            <td>Email</td>
                                            <td>' . $row['c_email_address'] . '</td>
                                          </tr>
                                          <tr>
                                            <td>Telephone</td>
                                            <td>' . $row['c_telephone'] . '</td>
                                          </tr>
                                         ';
                break;
        }
        $html .= '</table>';
    }
    return $html;
}

function Agent_checkExitsSite($agent_id = 0, $type = 'agent')
{
    global $agent_site_cls;
    $site = $agent_site_cls->getRow('agent_id = ' . $agent_id . ' AND type = \'' . $type . '\'');
    if (is_array($site) and count($site) > 0) {
        return $site['site_id'];
    }
    return 0;
}

function Agent_specialSite()
{
    return array('admin', 'phpMyAdmin');
}

function Agent_checkValidSite($username, $site_id, &$msg)
{
    global $agent_site_cls;
    $username = strtolower($username);
    preg_match('/[^a-z0-9-]/', $username, $matches);
    if (empty($matches)) {
        if (in_array($username, Agent_specialSite())) {
            $msg = 'Username is existed !';
            return false;
        }
        $rows = $agent_site_cls->getRows("name = '$username' AND site_id != {$site_id}");
        if (is_array($rows) and count($rows) > 0) {
            $msg = 'Username is existed !';
            return false;
        }
        return true;
    } else {
        $msg = 'Contains invalid characters !';
        return false;
    }
}

function Agent_seoURL($url)
{
    global $agent_site_cls, $agent_cls;
    $param = explode('&', str_replace('?', '', $url));
    $link = array();
    if (is_array($param) and count($param) > 0) {
        foreach ($param as $val) {
            $par_detail = explode('=', $val);
            $link[$par_detail[0]] = $par_detail[1];
        }
    }
    //begin seo url for agent site
    $return_url = $url;
    if (isset($link['action']) and in_array($link['action'], array('view-detail-agent', 'view-detail-agency'))) {
        $type_temp = explode('-', $link['action']);
        $type = end($type_temp);
        $row = $agent_site_cls->getRow('agent_id = ' . $link['uid'] . ' AND type = \'' . $type . '\' AND name != \'\'');
        if (is_array($row) and count($row) > 0) {
            if ($type == 'agency') {
                $return_url = $row['name'] . '/';
            } else {
                $parent_row = $agent_site_cls->getRow('agent_id = (
                                                            SELECT IF( parent_id =0, agent_id, parent_id )
                                                            FROM ' . $agent_cls->getTable() . '
                                                            WHERE agent_id = ' . $link['uid'] . ')
                                                       AND type = \'agency\'
                                                       AND name != \'\'');
                if (is_array($parent_row) and count($parent_row) > 0) {
                    $return_url = $parent_row['name'] . '/' . $row['name'] . '/';
                }
            }
        }
    }
    return ROOTURL . '/' . $return_url;
}

function Agent_getAgent($property_id = 0)
{
    global $property_cls;
    $data = array();
    $row = $property_cls->getRow("SELECT IF(agent_manager = '' || ISNULL(agent_manager),agent_id,agent_manager) AS agent
                                  FROM " . $property_cls->getTable() . ' AS a
                                  WHERE property_id = ' . $property_id, true);
    if (is_array($row) and count($row) > 0) {
        $agent_row = A_getAgentParentInfo($row['agent']);
        if ($agent_row['site_name'] != '') {
            $data[] = $agent_row['site_name'];
        }
    }
    return $data;
}

function AgentType_getActiveCustomerType()
{
    global $agent_cls;
    $options = array();
    $rows = $agent_cls->getRows('SELECT agent_type_id, title, name
	                             FROM ' . $agent_cls->getTable('agent_type')
        . ' WHERE active = 1', true);
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            if (in_array($row['title'], array('guest', 'theblock'))) {
                continue;
            }
            if ($row['title'] == 'partner') {
                $row['name'] = 'Advertiser';
            }
            $options[$row['title']] = $row['name'];
        }
    }
    return $options;
}

function __exportCustomerCSV()
{
    global $agent_cls;
    $agent_ids = restrictArgs(getParam('agent_ids', 0), '[^0-9\,]');
    $content = array();
    try {
        $file_name = restrictArgs(getParam('file_name', ''), '[^0-9A-Za-z\-\_]');
        $file_name = $file_name == '' ? 'customer' : $file_name;
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
        $rows = $agent_cls->getRows("SELECT SQL_CALC_FOUND_ROWS agt.* FROM ".$agent_cls->getTable()." AS agt,".$agent_cls->getTable('agent_type')." AS agt_typ
					WHERE agt.type_id = agt_typ.agent_type_id AND agt.agent_id IN (".$agent_ids.") ",true);

        if ($agent_cls->hasError()) {
        } else if (count($rows) > 0 and is_array($rows)) {
            foreach ($rows as $key => $row) {
                /*---------------- CONTENT-----------------*/
                $content['No'][] = $key + 1;
                $content['Agent Id'][$key] = $row['agent_id'];
                $content['First Name'][$key] = $row['firstname'];
                $content['Last Name'][$key] = $row['lastname'];
                $content['Email Address'][$key] = $row['email_address'];
                $content['Mobilephone'][$key] = $row['mobilephone'];
                $content['Telephone'][$key] = $row['telephone'];
                $content['Address'][$key] = A_getAddress($row['agent_id']);
                $content['Type'][$key] = AgentType_getTypeAgent($row['agent_id']);
                $content['Instance'][$key] = $row['instance'];
                $content['Status'][$key] = $row['is_active'] == 1 ? "Active" : "InActive";
                $content['Creation Time'][$key] = $row['creation_time'];

            }
            /* CSV SAVE CONTENT*/
            $title_ar = array_keys($content);
            echo '"' . stripslashes(implode('","', $title_ar)) . "\"\n";
            for ($i = 0; $i < count($rows); $i++) {
                $csv_property_data = array();
                foreach ($title_ar as $key_title) {
                    $csv_property_data[] = '"' . str_replace(array("\"", '"', "_"), array('', '""', ' '), $content[$key_title][$i]) . '"';
                    //$csv_property_data[] = '"' . str_replace('"', '""', $v) . '"';
                }
                echo '' . stripslashes(implode(',', $csv_property_data)) . "\n";
            }
        }
        exit;
    } catch (Exception $er) {
        print_r($er->getMessage());
    }
}

function Agent_getFullTelephone($agent_id){
    global $agent_cls, $agent_contact_cls;
    $result = array('telephone');
    if($agent_id > 0){
        $row = $agent_cls->getRow('SELECT a.*, ac.*
				FROM ' . $agent_cls->getTable() . ' AS a
				LEFT JOIN ' . $agent_contact_cls->getTable() . ' AS ac
				ON ac.agent_id = a.agent_id
				WHERE a.agent_id = ' . $agent_id, true);
        if(is_array($row) && count($row) > 0){

        }
    }
    return $result;
}
?>
