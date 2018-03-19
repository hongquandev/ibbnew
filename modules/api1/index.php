<?php
include_once ROOTPATH . '/modules/general/inc/bids_mailer.php';
include_once ROOTPATH . '/modules/general/inc/property_history.php';
include_once ROOTPATH . '/modules/cms/inc/cms.php';
include_once ROOTPATH . '/includes/pagging.class.php';
include_once ROOTPATH . '/modules/payment/inc/payment_store.class.php';
include_once ROOTPATH . '/modules/general/inc/bids_stop.class.php';
include_once ROOTPATH . '/modules/general/inc/bids_first.class.php';
include_once ROOTPATH . '/modules/agent/inc/agent.php';
include_once ROOTPATH . '/modules/general/inc/propose_increment.php';
include_once ROOTPATH . '/modules/notification/notification.php';
include_once ROOTPATH . '/modules/general/inc/user_online.php';
$API_KEY = 'YWlybGluZWZhdWx0cw==';
session_start();
/*
 * Global param
 * api_key: YWlybGluZWZhdWx0cw==
 */

checkApi();
$action = getParam('action');
switch ($action) {
    case 'login':
        /* login - input params:
         * username
         * password
        */
        include_once 'inc/agent.login.php';
        break;
    case 'login-fb':
        /* login by fb - input params:
        * email
        * firstname
        * lastname
        * uid
        * access_token
        */
        include_once 'inc/fb_info.php';
        break;
    case 'logout':
        $_SESSION['agent'] = null;
        unset($_SESSION['agent']);
        delete(getParam('user_id'), getParam('type_os'));
        out(1, '');
        break;
    case 'save-notification-id':
        /*
        * save notification id - input params:
        * reg_id
        * type_os
        */
        checkSession();
        doSave($_SESSION['agent']['id'], getParam('reg_id'), getParam('type_os'));
        out(1, 'Successfully');
        break;
    case 'get-api-key':
        out(1, '', array('android_notification_sender_id' => '406859614669', 'facebook_apikey' => $config_cls->getKey('facebook_application_api_key')));
        break;
    case 'del-notification-id':
        /*
        * del notification id - input params:
        * type_os
        */
        delete($_SESSION['agent']['id'], getParam('type_os'));
        out(1, 'Successfully');
        break;
    case 'get-my-list-properties':
        /*
        * get list of properties -  input params:
        * bidder_type:
           - property-bids -> view property bid
           - reg-bids -> view reg to bid
           - else view my property
        * filter:
           - 0 -> view all
           - forthcoming -> forthcoming
           - live_today -> live
        * order_by:
           - 0
           - highest
           - lowest
           - newest
           - oldest
           - suburb
           - state
        * p: paging
        */
        checkSession();
        $bidder_type = getParam('bidder_type');
        if ($bidder_type == 'property-bids') {
            include_once 'inc/view.property.bids.php';
        } else if ($bidder_type == 'reg-bids') {
            include_once 'inc/my_reg_to_bids.php';
        } else {
            include_once 'inc/my.property.details.php';
        }
        break;
    case 'get-my-grid-properties':
        /*
        * it is the same get-my-list-properties method
        */
        checkSession();
        $bidder_type = getParam('bidder_type');
        if ($bidder_type == 'property-bids') {
            include_once 'inc/view.property.bids.php';
        } else if ($bidder_type == 'reg-bids') {
            include_once 'inc/my_reg_to_bids.php';
        } else {
            include_once 'inc/my.property.details.php';
        }
        break;
    case 'get-list-property-bids':
        /*
        * get list of property bids -  input params:
        * bidder_type:
           - property-bids -> view property bid
           - reg-bids -> view reg to bid 
        * order_by:
           - 0
           - highest
           - lowest
           - newest
           - oldest
           - suburb
           - state
        * p: paging
        */
        checkSession();
        $bidder_type = getParam('bidder_type');
        if ($bidder_type == 'property-bids') {
            include_once 'inc/view.property.bids.php';
        } else if ($bidder_type == 'reg-bids') {
            include_once 'inc/my_reg_to_bids.php';
        }
        out(0, 'Bidder type is invalid!');
        break;
    case 'get-grid-property-bids':
        /*
        * get grid of property bids -  input params:
        * bidder_type:
           - property-bids -> view property bid
           - reg-bids -> view reg to bid
        * order_by:
           - 0
           - highest
           - lowest
           - newest
           - oldest
           - suburb
           - state
        * p: paging
        */
        checkSession();
        $bidder_type = getParam('bidder_type');
        if ($bidder_type == 'property-bids') {
            include_once 'inc/view.property.bids.php';
        } else if ($bidder_type == 'reg-bids') {
            include_once 'inc/my_reg_to_bids.php';
        }
        out(0, 'Bidder type is invalid!');
        break;
    case 'view-property-detail':
        /*
        * view property detail - input params:
        * property_id
        */
        checkSession();
        include_once 'inc/view.property.detail.php';
        break;
    case 'view-property-bidder':
        /*
        * view property bid - input params:
        * property_id
        */
        checkSession();
        include_once 'inc/view.property.bidder.php';
        break;
    case 'bid':
        /*
        * bid - input params:
        * property_id
        * mine
          - 1: if account is agent or pro is mine
          - 0: else
        * in_room_bid
          - 1: is bidder
          - 0: agent
        * money_step
          - value of bid total: if account is agent or pro is mine
          - value of bid value: else
        */
        checkSession();
        include_once 'inc/bid.php';
        break;
    case 'on-bid':
        /*
        * on-bid - input params:
        * property_id
        * mine	
          - 1: if account is agent or pro is mine
          - 0: else
        * room
          - 1: is bidder
          - 0: agent
        * money_step
          - value of bid value 
        * to_id: id of current user
        */
        checkSession();
        include_once 'inc/on.bid.php';
        break;
    case 'view-report':
        /*
        * view report  -  input params:
        * report_type
        * property_id
        * p
        */
        checkSession();
        $report_type = getParam('report_type');
        if ($report_type == 'bid_report') {
            include_once 'inc/report.bid.php';
        } else if ($report_type == 'registerd_bid_report') {
            include_once 'inc/report.register.to.bid.php';
        } else if ($report_type == 'bidders_out_report') {
            include_once 'inc/report.no.more.bid.php';
        } else if ($report_type == 'loged_in_bidders_report') {
            include_once 'inc/report.logged.in.bid.php';
        }
        break;

    case 'no-more-bids':
        /*
        * no more bid  -  input params:
        * property_id 
        */
        checkSession();
        $property_id = restrictArgs(getParam('property_id', 0));
        $row = $bids_stop_cls->getRow('SELECT stop_id
				FROM ' . $bids_stop_cls->getTable() . '
				WHERE property_id = ' . $property_id . ' AND agent_id = ' . $_SESSION['agent']['id'], true);
        if (is_array($row) and count($row) > 0) {
        } else {
            $bids_stop_cls->insert(array('property_id' => $property_id,
                                        'agent_id' => $_SESSION['agent']['id'],
                                        'time' => date('Y-m-d H:i:s')));
            if (!$bids_stop_cls->hasError()) {
                $payment_store_cls->update(array('is_disable' => 1), 'property_id = ' . $property_id . '
						AND agent_id = ' . $_SESSION['agent']['id'] . '
						AND (bid = 1 OR offer = 1)');
                $stop = $bids_stop_cls->getRow('SELECT count(agent_id) AS count FROM ' . $bids_stop_cls->getTable() . ' WHERE property_id =' . $property_id, true);
                $registered = $bids_first_cls->getRow('SELECT count(agent_id) AS count FROM ' . $bids_first_cls->getTable() . ' WHERE property_id = ' . $property_id . ' AND pay_bid_first_status > 0', true);

                $count_stop = (is_array($stop) && count($stop > 0)) ? $stop['count'] : 0;
                $count_registered = (is_array($registered) && count($registered > 0)) ? $registered['count'] : 0;

                if ($count_registered > 0 && $count_stop == $count_registered) {
                    $property_cls->update(array('no_more_bid' => 1),
                                          'property_id = ' . $property_id);
                }
                pushWithoutUserId($_SESSION['agent']['id'], array('type_msg' => 'update-property'));
                out(1, 'Saved successful!');
            }
        }
        out(0, '');
        break;
    case 'set-count':
        /*
        * set count - input params:
        * property_id
        * step:
            - 1: g1
            - 2: g2
            - 3: g3
            - sold
            - passedin
            - pre_amble
            - start
            - reset
        */
        checkSession();
        include_once 'inc/setCount.php';
        break;
    case 'set-incre':
        /*
        * set incre - input params:
        * property_id
        * is_reset: 1 -> reset or incre
        * min-incre
        * max-incre
        */
        checkSession();
        include_once 'inc/setIncre.php';
        break;
    case 'propose-require':
        /*
        * call when bidder require a value to set inscre
        * propose-require - input params
        * property_id
        * amount
        * from_id: current user id
        */
        checkSession();
        include_once ROOTPATH . '/modules/property/inc/property.php';
        include_once ROOTPATH . '/modules/general/inc/propose_increment.php';

        out(1, 'Saved successful!', __proposeRequire());
        break;
    case 'propose-accept':
        /*
        * call when accepts
        * propose-accept - input params
        * property_id 
        * from_id: current user id
        * to_id: id cua thang gui
        */
        checkSession();
        out(1, '', __proposeAccept());
        break;
    case 'propose-refuse':
        /*
        * call when user click not accept
        * propose-accept - input params
        * property_id
        * from_id: current user id
         * to_id: id cua thang gui
        */
        checkSession();
        out(1, '', __proposeRefuse());
        break;
    case 'propose-finish':
        /*
        * finnish after refuse
        * propose-finish - input params
        * property_id
        * to_id: current user id
        * from_id:
        */
        checkSession();
        out(1, '', __proposeFinish());
        break;
    case 'get-propose-request':
        /*
        * call when load view bid of agent
        * get-propose-request - input params
        * property_id
        */
        checkSession();
        $row = array();
        $property_id = restrictArgs(getParam('property_id', 0));
        if (in_array($_SESSION['agent']['id'], Property_getOwner($property_id))) {
            $row = $propose_increment_cls->getCRow(array('property_id', 'amount', 'from_id', 'type_approved'), 'property_id = ' . $property_id . ' AND type_approved = 0');
            if (is_array($row) && count($row) > 0) {
                $agent_row = $agent_cls->getRow("SELECT * FROM " . $agent_cls->getTable('agent') . " WHERE agent_id = " . $row['from_id'], true);
                $row['agent_name'] = substr($agent_row['firstname'], 0, 1) . '.' . substr($agent_row['lastname'], 0, 2);
            } else
                $row = array();

        }
        out(1, '', $row);
        break;
    case 'propose-done':
        /*
        * Call when load view bid of bidder
        * propose-done - input params
        * property_id
        */
        checkSession();
        $row = array();
        $property_id = restrictArgs(getParam('property_id', 0));
        $row = $propose_increment_cls->getRow('SELECT pi.from_id, pi.property_id, pi.amount, pi.type_approved,
                                agent.firstname, agent.lastname
                            FROM ' . $propose_increment_cls->getTable() . ' AS pi, ' . $agent_cls->getTable() . ' AS agent
                            WHERE pi.from_id = agent.agent_id AND pi.type_approved < 3 AND pi.type_approved > 0 AND pi.property_id = ' . (int)$property_id. ' AND pi.from_id='.$_SESSION['agent']['id'], true);

        out(1, '', $row);
        break;
    case 'get-no-more-bid-msg':
        /*
        * get-no-more-bid-msg - input params
        * property_id
        */
        checkSession();
        out(1, $config_cls->getKey('no_more_bids_msg'));
        break;
    case 'get-winner':
        /*
        * get-winner - input params
        * property_id
        */
        __getWinnerInfo(getParam('property_id'));
        break;
    case 'change-status-bidder':
        /**
         * Change the status of register bid 
         */
        checkSession();
        _disableEnableRegisterBid();
        break;

}
 
function _disableEnableRegisterBid(){
     global $property_cls, $payment_store_cls,$agent_cls, $config_cls, $bids_stop_cls, $bids_first_cls, $log_cls;
     $agent_id = (int)restrictArgs(getParam('aid', 0));
      $property_id = (int)restrictArgs(getParam('pid', 0)); 
        if ($agent_id > 0) {  
            $field = getParams("what_field") == 'is_disable'?'is_disable':'allow';
            $another_field = $field == 'is_disable'?'allow':'is_disable';
            $row = $payment_store_cls->getCRow(array($field,$another_field), 'agent_id = ' . $agent_id . ' AND property_id =' . $property_id . ' AND bid = 1');
            if (is_array($row) and count($row) > 0) {
                $payment_store_cls->update(array($field => 1 - $row[$field]), 'agent_id = ' . $agent_id . ' AND property_id =' . $property_id . ' AND (bid = 1 OR offer = 1)');
                if ($payment_store_cls->hasError()) { 
                     out(0, $payment_store_cls->getError());
                } else {
                    //send Mail
                    $agent_row = $agent_cls->getCRow(array('firstname',
                                                          'lastname',
                                                          'email_address'), 'agent_id = ' . $agent_id);
                    if (is_array($agent_row) and count($agent_row) > 0) {
                        if($field == 'is_disable'){
                            if (1 - $row['is_disable'] == 0) { //enable
                                $subject = $config_cls->getKey('bidder_enable_subject');
                                $content = $config_cls->getKey('bidder_enable_content');

                                //ENABLE NO-MORE
                                $bids_stop_cls->delete('property_id = ' . $property_id . ' AND agent_id = ' . $agent_id);

                            } else { //disable
                                $subject = $config_cls->getKey('bidder_disable_subject');
                                $content = $config_cls->getKey('bidder_disable_content');

                                //DISABLE NO-MORE
                                $row = $bids_stop_cls->getRow('SELECT stop_id
                                                                                      FROM ' . $bids_stop_cls->getTable() . '
                                                                                      WHERE property_id = ' . $property_id . ' AND agent_id = ' . $agent_id, true);
                                if (is_array($row) and count($row) > 0) {
                                } else {
                                    $bids_stop_cls->insert(array('property_id' => $property_id,
                                                                'agent_id' => $agent_id,
                                                                'time' => date('Y-m-d H:i:s')));
                                }
                            }
                        } 

                        //CHANGE STATUS NO-MORE-ONLINE-BIDS
                        if (!$bids_stop_cls->hasError()) {
                            $stop = $bids_stop_cls->getRow('SELECT count(agent_id) AS count FROM ' . $bids_stop_cls->getTable() . ' WHERE property_id =' . $property_id, true);
                            $registered = $bids_first_cls->getRow('SELECT count(agent_id) AS count FROM ' . $bids_first_cls->getTable() . ' WHERE property_id = ' . $property_id . ' AND pay_bid_first_status > 0', true);

                            $count_stop = (is_array($stop) && count($stop > 0)) ? $stop['count'] : 0;
                            $count_registered = (is_array($registered) && count($registered > 0)) ? $registered['count']
                                    : 0;


                            if (1 - $row[$field] == 0 && $row[$another_field] == 1) { //enable
                                $check_no = $property_cls->getCRow(array('no_more_bid', 'set_count'), 'property_id = ' . $property_id);
                                if (is_array($check_no) and count($check_no) > 0 and $check_no['no_more_bid'] == 1 and $count_registered > 0 && $count_stop < $count_registered) {
                                    $property_cls->update(array('no_more_bid' => 0),
                                                          'property_id = ' . $property_id);
                                }
                            } else {
                                if ($count_registered > 0 && $count_stop == $count_registered) {
                                    $property_cls->update(array('no_more_bid' => 1),
                                                          'property_id = ' . $property_id);

                                }
                            }
                        }

                        $info = Agent_getBidderInfo($_SESSION['agent']['id']);
                        $content = str_replace(array('[username]',
                                                    '[property_id]',
                                                    '[agent_info]'),
                                               array($agent_row['firstname'] . ' ' . $agent_row['lastname'],
                                                    $property_id,
                                                    $info
                                               ), $content);
                        sendEmail_func($_SESSION['agent']['email_address'], $agent_row['email_address'], $content, $subject);
                        include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
                         
                        $log_cls->createLog('disable_bidder');
                    }
                    //end
                    push(0, array('type_msg' => 'update-property')); 
                    
                    out(1, '',  array('status' => $row[$field])); 
                }
            }
        }
         
}

function __proposeRequire()
{
    global $property_cls;
    $amount = restrictArgs(getParam('amount', 0));
    $property_id = restrictArgs(getParam('property_id', 0));
    $from_id = restrictArgs(getParam('from_id', 0));

    PI_update(array('property_id' => $property_id, 'from_id' => $from_id, 'amount' => $amount, 'type_approved' => 0));
    $rs = array('success' => 1, 'from_id' => $from_id, 'property_id' => $property_id);
    pushWithoutUserId($_SESSION['agent']['id'], array('type_msg' => 'require-propose'));
    return $rs;
}

function __proposeAcceptRefuse($type_approved = 0)
{
    global $property_cls, $propose_increment_cls;
    $property_id = restrictArgs(getParam('property_id', 0));
    // notice, we have reverve from_id and to_id
    $from_id = restrictArgs(getParam('from_id', 0));
    $to_id = restrictArgs(getParam('to_id', 0));

    $rs = array('success' => 0);
    if (in_array($from_id, Property_getOwner($property_id))) {
        $row = $propose_increment_cls->getCRow(array('property_id', 'amount'), 'property_id = ' . $property_id . ' AND from_id = ' . $to_id);

        if (isset($row['property_id'])) {
            $propose_increment_cls->update(array('type_approved' => $type_approved), 'property_id = ' . $property_id . ' AND from_id = ' . $to_id);
            $rs = array('success' => 1, 'from_id' => $from_id, 'property_id' => $property_id, 'amount' => $row['amount']);

            if ($type_approved == 1) {
                $row1 = $property_cls->getCRow(array('max_increment'), 'property_id = ' . $property_id);
                if ($row1['max_increment'] == null || (int)$row1['max_increment'] == 0  ) {
                    $property_cls->update(array('min_increment' => $row['amount']), 'property_id = ' . $property_id);
                } else {
                    if((int)$row['min_increment'] <  (int)$row['amount'] &&  (int)$row['amount']> (int)$row1['max_increment'] ){
                        $property_cls->update(array('max_increment' => $row['amount']), 'property_id = ' . $property_id);
                    }else{
                        $property_cls->update(array('min_increment' => $row['amount']), 'property_id = ' . $property_id);
                    }
                    // if ((int)$row1['max_increment'] <= (int)$row['amount']) {
                    // $property_cls->update(array('max_increment' => $row['amount']), 'property_id = ' . $property_id);
                    // } else {
                    // }
                }
            }

            if ($type_approved == 1 || $type_approved == 2) { // ACCEPT
                // UPDATE NOTIFICATION TO ANDROID //$_SESSION['agent']['id']
                pushWithoutUserId($to_id, array('type_msg' => 'accept-propose', 'is_refuse'=>$type_approved==2?1:0));
            }
        }
    }
    return $rs;
}

function __proposeAccept()
{
    return __proposeAcceptRefuse(1);
}

function __proposeRefuse()
{
    return __proposeAcceptRefuse(2);
}

function __proposeFinish()
{
    global $property_cls, $propose_increment_cls;
    $property_id = restrictArgs(getParam('property_id', 0));
    $from_id = restrictArgs(getParam('from_id', 0));
    $row = $propose_increment_cls->getCRow(array('property_id',), 'property_id = ' . $property_id . ' AND from_id = ' . $from_id);
    $rs = array('success' => 0);
    if (isset($row['property_id'])) {
        $propose_increment_cls->update(array('type_approved' => 3), 'property_id = ' . $property_id . ' AND from_id = ' . $from_id);
        //$propose_increment_cls->delete('property_id = '.$property_id.' AND from_id = '.$from_id.' AND to_id = '.$to_id);
        $rs = array('success' => 1, 'from_id' => $from_id, 'property_id' => $property_id);
    }
    return $rs;
}

function __getWinnerInfo($property_id = 0)
{
    global $bid_cls, $region_cls, $agent_cls, $agent_company_cls, $property_cls;
    $rs = array('property_id' => $property_id);
    //WINNER INFO
    $b_row = $bid_cls->getCRow(array('agent_id', 'property_id', 'price', 'type_approved'), 'property_id = ' . (int)$property_id . ' ORDER BY price DESC LIMIT 1');
    if (@$b_row['agent_id'] > 0 && @$b_row['type_approved'] == 0) {
        $rs['agent_id'] = $b_row['agent_id'];
        $rs['price'] = $b_row['price'];

        //AGENT INFO
        $agent_id = Property_getParent($property_id);
        $sql = 'SELECT agent.firstname, agent.lastname, agent.telephone, agent.mobilephone
				FROM ' . $agent_cls->getTable() . ' AS agent
				WHERE agent.agent_id = ' . (int)$agent_id;
        $a_row = $agent_cls->getRow($sql, true);
        if (count($a_row) > 0) {
            $rs['agent_fullname'] = $a_row['firstname'] . ' ' . $a_row['lastname'];
            $rs['agent_phone'] = strlen(trim($a_row['telephone'])) > 0 ? $a_row['telephone'] : $a_row['mobiphone'];
            $add1 = A_getAddress($agent_id);
            $add2 = A_getCompanyAddress($agent_id);
            $rs['agent_address'] = strlen($add2) > 0 ? $add2 : $add1;


            /*-- FOR MOBILE*/
            $rs['msg1'] = 'Congratulations!';
            $rs['msg2'] = 'You are the winning bidder and as the Highest bidder, you are buying this property.';
            $rs['msg3'] = 'Please contact the Managing Agent.';
            $rs['property_id'] = $property_id;
            if ($rs['agent_id'] == $_SESSION['agent']['agent_id']) {
                out(1, '', $rs);
            }
        }
    }

    out(0, '');
}

/*
function Property_isLockBid($property_id){
    global $property_cls;
    $row = $property_cls->getCRow(array('lock_bid'),'property_id = '.$property_id);
    if (is_array($row) and count($row) > 0){
        return (int)@$row['lock_bid'];
    }
    return 0;
}*/
function out($success = 0, $msg = '', $data = '', $isTimeOut = 0)
{
    die(json_encode(array('success' => $success, 'msg' => $msg, 'data' => $data, 'is_time_out' => $isTimeOut)));
}

function checkSession()
{
    if ($_SESSION['agent'] == null || !isset($_SESSION['agent']) || (int)$_SESSION['agent']['id'] <= 0) {
        global $agent_cls;
        $userId = getParams('session_id', 0);
        if ((int)$userId > 0) {
            $row = $agent_cls->getRow("agent_id = '" . $userId . "' ");
            if (is_array($row) and count($row) > 0) {
                if ($row['is_active'] == 0) {
                    out(0, 'Your account is not activated yet.');
                } else {
                    $type_row = $agent_cls->getRow("SELECT * FROM " . $agent_cls->getTable('agent_type') . " WHERE agent_type_id = " . $row['type_id'], true);

                    $type = 'buyer';
                    if (is_array($type_row) and count($type_row) > 0) {
                        $type = $type_row['title'];
                    }

                    $fn = $row['firstname'] . ' ' . $row['lastname'];
                    $len = 60;
                    $_SESSION['agent'] = array('id' => $row['agent_id'],
                                               'agent_id' => $row['agent_id'],
                                               '3x_id' => $row['agent_id'],
                                               'full_name' => strlen($fn) > $len ? safecontent($fn, $len) . '...' : $fn,
                                               'firstname' => $row['firstname'],
                                               'lastname' => $row['lastname'],
                                               'email_address' => $row['email_address'],
                                               'auction_step' => $row['auction_step'],
                                               'maximum_bid' => $row['maximum_bid'],
                                               'type' => $type,
                                               'type_id' => $row['type_id'],
                                               'login' => true,
                                               'parent_id' => $row['parent_id']);


                    out(1, '', $_SESSION['agent']);
                }
            }
        }

        out(0, 'Session is timeout!', "", 1);
    }
}

function checkApi()
{
    global $API_KEY;
    $api = getQuery('api_key', "");
    if (!isset($api)) {
        $result = array('success' => 0, 'msg' => 'Api key is not existed!', 'api_key' => '');
        die(json_encode($result));
    }

    if ($api != $API_KEY) {
        $result = array('success' => 0, 'msg' => 'Api key is invalid!', 'api_key' => '');
        die(json_encode($result));
    }
}

die(json_encode(array('error' => 'go away!')));

function getParams($key, $def = '')
{
    if (isset($_REQUEST[$key])) {
        return ($_REQUEST[$key]);
    }
    return $def;
}

?>