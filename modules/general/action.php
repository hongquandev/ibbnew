<?php
ini_set('display_errors', 0);
require '../../configs/config.inc.php';
require ROOTPATH . '/includes/functions.php';
include ROOTPATH . '/includes/model.class.php';
include ROOTPATH . '/includes/validate.class.php';
include_once ROOTPATH . '/modules/general/inc/bids_mailer.php';
include_once ROOTPATH . '/modules/general/inc/property_history.php';
include_once ROOTPATH . '/modules/cms/inc/cms.php';
include_once ROOTPATH . '/includes/pagging.class.php';
include_once ROOTPATH . '/modules/payment/inc/payment_store.class.php';
include_once ROOTPATH . '/modules/general/inc/bids_stop.class.php';
include_once ROOTPATH . '/modules/general/inc/bids_first.class.php';
include_once ROOTPATH . '/modules/agent/inc/agent.php';
include_once ROOTPATH . '/modules/general/inc/propose_increment.php';
include_once ROOTPATH . '/modules/general/inc/user_online.php';
include_once ROOTPATH . '/modules/notification/notification.php';
include_once ROOTPATH . '/modules/notification/notification_app.class.php';

$mobileBrowser = detectBrowserMobile();
if ($mobileBrowser){
    define('MOBILE_FOLDER','/mobile/');    
}else{
    define('MOBILE_FOLDER','/');
}
if (!($notification_app_cls) || !($notification_app_cls instanceof Notification_app)) {
    $notification_app_cls = new Notification_app();
}

if (!isset($user_online_cls) || !($user_online_cls instanceof UserOnline)) {
    $user_online_cls = new UserOnline();
}
$user_online_cls->checkOnline();

if (!isset($bid_first_cls) || !($bid_first_cls instanceof Bids_first)) {
    $bid_first_cls = new Bids_first();
}

if (!$payment_store_cls || !($payment_store_cls instanceof Payment_store)) {
    $payment_store_cls = new Payment_store();
}
if (!$bids_stop_cls || !($bids_stop_cls instanceof Bids_stop)) {
    $bids_stop_cls = new Bids_stop();
}
if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
    $pag_cls = new Paginate();
}
/*die ('TEst action3');*/

if (!isset($bids_mailer_cls) || !($bids_mailer_cls instanceof Bids_mailer)) {
    $bids_mailer_cls = new Bids_mailer();
}
if (!isset($property_history_cls) || !($property_history_cls instanceof property_history)) {
    $property_history_cls = new property_history();
}
// BEGIN SMARTY
include_once ROOTPATH . '/includes/smarty/Smarty.class.php';
$smarty = new Smarty;
if(detectBrowserMobile()){ 
    $smarty->compile_dir = ROOTPATH.'/m.templates_c/';
}else{
    $smarty->compile_dir = ROOTPATH.'/templates_c/';
}
$smarty->assign('MEDIAURL', MEDIAURL);
// END
include_once ROOTPATH . '/modules/configuration/inc/config.class.php';
include_once ROOTPATH . '/modules/property/inc/property.php';
include_once ROOTPATH . '/modules/agent/inc/agent.php';
if (!isset($config_cls) || !($config_cls instanceof Config)) {
    $config_cls = new Config();
}

define('SITE_TITLE',$config_cls->getKey('site_title'));
$smarty->assign('site_title_config',$config_cls->getKey('site_title'));

$count = array();
$count['once'] = $config_cls->getKey('count_going_once');
$count['twice'] = $config_cls->getKey('count_going_twice');
$count['third'] = $config_cls->getKey('count_going_third');

include_once ROOTPATH . '/modules/facebook-twitter/inc/fb.facebook.class.php';
$fb = array('enable' => $config_cls->getKey('facebook_enable'),
            'security' => $config_cls->getKey('facebook_security'),
            'id' => $config_cls->getKey('facebook_application_api_id'),
            'key' => $config_cls->getKey('facebook_application_api_key'),
            'secret' => $config_cls->getKey('facebook_application_secret'),
            'url' => ROOTURL . '?module=agent&action=fb-info',
            'logout_url' => ROOTURL . '?module=agent&action=logout');

if (!isset($fb_cls) || !($fb_cls instanceof FaceBook)) {
    $fb_cls = new FaceBook($fb);
}

$action = getParam('action');

if (!restrict4AjaxFrontend()) {
    die('!Permission.');


}

switch ($action) {
    case 'check_login':
        //die(_response(__checkLoginAction()));
        //die(json_encode(__checkLoginAction()));

        die(json_encode(__checkLoginAction()));
        //die('OnLogin(\''.json_encode(__checkLoginAction()).'\')');
        break;
    case 'check_login_ajax':
        die((__checkLoginAjaxAction()));
        break;
    case 'get_states':
        include_once ROOTPATH . '/modules/general/inc/regions.class.php';
        $region_cls = new Regions();
        die(json_encode(__getStateAction()));
        break;
    case 'registerToTransact':
        $jsons = array('error' => 0, 'data' => array());
        include_once ROOTPATH . '/modules/general/inc/bids.php';
        include_once ROOTPATH . '/modules/agent/inc/agent.php';
        include_once ROOTPATH . '/modules/property/inc/property.php';
        registerToTransactAction();
        break;
    case 'bid':
    case 'get-bid':
        $jsons = array('error' => 0, 'data' => array());
        include_once ROOTPATH . '/modules/general/inc/bids.php';
        include_once ROOTPATH . '/modules/agent/inc/agent.php';
        include_once ROOTPATH . '/modules/property/inc/property.php';
        if ($action == 'bid') {
            $jsons = __bidAction();
        } else if ($action == 'get-bid') {
            //die(json_encode(array('Test' => true)));
            $jsons = __getBidAction();
            //ape_insert(array('key' => restrictArgs(getParam('ids'),'[^0-9\-]'), 'data' => serialize($jsons)));
        }
        die(json_encode($jsons));
        break;
    case 'actualBid_history':
    case 'bid_history':
        include_once ROOTPATH . '/modules/general/inc/bids.php';
        include_once ROOTPATH . '/modules/agent/inc/agent.php';
        include_once ROOTPATH . '/modules/property/inc/property.php';
        die(json_encode(__bidHistoryAction()));
        break;
    case 'registerToBid_history':
        include_once ROOTPATH . '/modules/general/inc/bids.php';
        include_once ROOTPATH . '/modules/agent/inc/agent.php';
        include_once ROOTPATH . '/modules/property/inc/property.php';
        die(json_encode(__registerBidHistoryAction()));
        break;
    case 'updateBidViewAction':
        include_once ROOTPATH . '/modules/general/inc/bids.php';
        include_once ROOTPATH . '/modules/agent/inc/agent.php';
        include_once ROOTPATH . '/modules/property/inc/property.php';
        die(json_encode(__updateBidViewAction()));
        break;
    case 'exportCSV':
        include_once ROOTPATH . '/modules/general/inc/bids.php';
        include_once ROOTPATH . '/modules/agent/inc/agent.php';
        include_once ROOTPATH . '/modules/property/inc/property.php';
        __exportCSV();
        //die(_response(__exportCSV()));
        exit;
        break;
    case 'registerToBid_blockReport':
        include_once ROOTPATH . '/modules/general/inc/bids.php';
        include_once ROOTPATH . '/modules/agent/inc/agent.php';
        include_once ROOTPATH . '/modules/property/inc/property.php';
        //die(json_encode(__registerBidHistoryBlockReportAction()));
        die(json_encode(__registerBidHistoryAction()));
        break;
    case 'registerBidAgent':
        include_once ROOTPATH . '/modules/general/inc/bids.php';
        include_once ROOTPATH . '/modules/agent/inc/agent.php';
        include_once ROOTPATH . '/modules/property/inc/property.php';
        die(json_encode(__registerBidAgentAction()));
        break;
    case 'winner_info':
        include_once ROOTPATH . '/modules/general/inc/bids.php';
        include_once ROOTPATH . '/modules/agent/inc/agent.php';
        include_once ROOTPATH . '/modules/property/inc/property.php';
        die(json_encode(__winnerInfoAction()));
        break;
    case 'check-basic':
        $url = getParam('link');
        $type = (getParam('type') == '') ? 'property' : getParam('type');
        $check_agent = $_SESSION['agent']['type'] != 'agent' && (AI_isBasic($_SESSION['agent']['id'])) ? true : false;
        $result = array('success' => $check_agent, 'url' => $url, 'type' => $type, 'root' => ROOTURL);
        die(_response($result));
        break;
    case 'check-sub':
        die(json_encode(__checkSubAction()));
        break;
    case 'remind-payment':
        die(json_encode(__remindPaymentAction()));
        break;
    case 'payment':
        __agentPaymentAction();
        break;
    case 'rlater':
        $_SESSION['agent']['rlater'] = 1;
        die($_SESSION['agent']['rlater']);
        break;
    case 'on-bid':
        include_once ROOTPATH . '/modules/general/inc/bids.php';
        include_once ROOTPATH . '/modules/agent/inc/agent.php';
        include_once ROOTPATH . '/modules/property/inc/property.php';
        die(_response(__onBidAction()));
        break;
    case 'transferTemplate':
        __transfertemplateFunction();
        break;
    case 'load-background':
        include_once ROOTPATH . '/modules/theblock/inc/background.php';
        include_once ROOTPATH . '/modules/menu/inc/menu.php';
        $pro_where = '';
        $link = getParam('location');
        $link_arr = explode('/', $link);
        $pro_id = restrictArgs(getParam('id', 0));
        //for detail
        $__action = getParam('_action', '');
        $pro_type = getParam('pro_type', '');
        $pro_where = '';

        if ($link_arr[count($link_arr) - 1] != '') { //not HOME
            if ($pro_type != '') {
                /* if (strpos($__action,'search') === false){//detail
               /* if (strpos($__action,'search') === false){//detail
                    $link_str = $pro_type == 'theblock'?'view-tv-show':'view-'.$pro_type.'-list';
                    if ($pro_type == 'theblock' && $pro_id > 0){
                            $pro_where = " AND (theblock_id LIKE '{$pro_id}'
                                           OR theblock_id LIKE '{$pro_id},%'
                                           OR theblock_id LIKE '%,{$pro_id}%')";
                    }
                }else{//search
                    $link_str = $pro_type == 'partner'?'view-search-partner':'view-search-advance-'.$pro_type;
                }*/
                if ($pro_id > 0 && PE_isTheBlock($pro_id)) {
                    $row = $menu_cls->getRow('SELECT menu_id FROM ' . $menu_cls->getTable() . "
                                            WHERE url LIKE 'the-block.html%'", true);
                    if (is_array($row) and count($row) > 0) {
                        $link = 'the-block.html';
                    }
                }
            } else { //normal
                $link = end($link_arr);

                /*if (strlen($__action)> 0){
                    $link_str = $__action;
                }else{
                    $link_str = strpos($link_arr[count($link_arr)-1],'.html') != false?str_replace('.html','',$link_arr[count($link_arr)-1]):$link_arr[count($link_arr)-1];
                }
                $pro_where = $__action == 'view-tv-show'?' AND (ISNULL(theblock_id) OR theblock_id = \'\' )':$pro_where;*/
            }
            $row = $menu_cls->getRow('SELECT menu_id FROM ' . $menu_cls->getTable() . "
                              WHERE url LIKE '{$link}%'", true);
        } else $row['page_id'] = 0;

        if (is_array($row) and count($row) > 0) {
            $img = $background_cls->getRow('SELECT *
                                      FROM ' . $background_cls->getTable() . "
                                      WHERE agent_id = 0 AND (cms_page LIKE '{$row['menu_id']}'
                                            OR cms_page LIKE '{$row['menu_id']},%'
                                            OR cms_page LIKE '%,{$row['menu_id']}%') AND active = 1 {$pro_where}
                                      ORDER BY background_id DESC
                                      ", true);
            if (is_array($img) and count($img) > 0) {
                $dir = '/store/uploads/background/img/';
                die(json_encode(array('url' => $dir . $img['link'],
                                     'color' => $img['background_color'],
                                     'fixed' => $img['fixed'],
                                     'repeat' => $img['repeat'])));
            }
        }
        die(json_encode(array()));
        break;
    case 'setCount':
        __setCountForTheBlock();
        break;
    case 'no-more-bids':
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
                    //$property_cls->update(array('set_count'=>'No More Online Bids'),'property_id = '.$property_id);
                }

                push(0, array('type_msg' => 'update-property'));
                //push1(0, array('type_msg' => 'update-property'));
                die(json_encode(array('success' => 1)));
            }
        }
        // UPDATE NOTIFICATION TO ANDROID

        die(json_encode(array('error' => 1)));
        break;
    case 'loadTerm':
        __loadTerm();
        break;
    case 'acceptTerm':
        __acceptTerm();
        break;
    case 'loadFormUpload':
        __loadFormUpload();
        break;
    case 'uploadTerm':
        __uploadTerm();
        break;
    case 'sendTerm':
        __sendTerm();
        break;
    case 'tourguide-content':
        __tourGuideContent();
        break;
    case 'changeStatus':
        __changeStatusAction();
        break;
    case 'loadCountDown':
        $property_id = (int)restrictArgs(getParam('id', 0));
        $type_popup = getParam('type_popup', 'bidder-user');
        $html = Property_makeCountDownPopup($property_id, $type_popup);
        die($html);
        break;
    case 'loadReportBid':
    case 'loadReportNoMoreBid':
    case 'loadReportRegisterBid':
    case 'loadLoggedInBid':
        $property_id = (int)restrictArgs(getParam('property_id', 0));
        $is_nexus7 = (int)restrictArgs(getParam('is_nexus7', 0));
        $p = (int)restrictArgs(getQuery('p', 1));
        $p = $p <= 0 ? 1 : $p;
        $len = 5;
        if ($is_nexus7 > 0) {
            $len = 3;
        }
        $isAgent = Property_isVendorOfProperty($property_id);
        $smarty->assign('isAgent', $isAgent);
        $smarty->assign('property_id', $property_id);
        switch ($action) {
            case 'loadReportBid':
                __reportReportBid($property_id, $p, $len, $isAgent);
                break;
            case 'loadReportNoMoreBid':
                __reportNoMoreBid($property_id, $p, $len, $isAgent);
                break;
            case 'loadReportRegisterBid':
                __reportRegisterToBid($property_id, $p, $len, $isAgent);
                break;
            case 'loadLoggedInBid':
                __reportLoggedInBid($property_id, $p, $len);
                break;
        }
        $smarty->assign('p', $p);
        $smarty->assign('len', $p);
        $smarty->assign('ROOTPATH', ROOTPATH);
        $smarty->assign('is_mine', $isAgent);
        $html = $smarty->fetch(ROOTPATH . '/modules/property/templates/property.report.tpl');
        die($html);
        break;
    case 'disableBidder':
    case 'allowBidder':
        $field = $action == 'disableBidder' ? 'is_disable' : 'allow';
        $agent_id = (int)restrictArgs(getParam('aid', 0));
        $property_id = (int)restrictArgs(getParam('pid', 0));
        $result = array('error' => 1);
        if ($agent_id > 0) {
            $another_field = $field == 'is_disable' ? 'allow' : 'is_disable';
            $row = $payment_store_cls->getCRow(array($field, $another_field), 'agent_id = ' . $agent_id . ' AND property_id =' . $property_id . ' AND (bid = 1 OR offer = 1)');
            if (is_array($row) and count($row) > 0) {
                $payment_store_cls->update(array($field => 1 - $row[$field]), 'agent_id = ' . $agent_id . ' AND property_id =' . $property_id . ' AND (bid = 1 OR offer = 1)');
                if ($payment_store_cls->hasError()) {
                    $result['msg'] = $payment_store_cls->getError();
                } else {
                    //send Mail
                    $agent_row = $agent_cls->getCRow(array('firstname',
                        'lastname',
                        'email_address'), 'agent_id = ' . $agent_id);
                    if (is_array($agent_row) and count($agent_row) > 0) {

                        if ($action == 'disableBidder') {
                            if (1 - $row['is_disable'] == 0) { //enable
                                $subject = $config_cls->getKey('bidder_enable_subject');
                                $content = $config_cls->getKey('bidder_enable_content');
                                //ENABLE NO-MORE
                                $bids_stop_cls->delete('property_id = ' . $property_id . ' AND agent_id = ' . $agent_id);
                            } else { //disable
                                $subject = $config_cls->getKey('bidder_disable_subject');
                                $content = $config_cls->getKey('bidder_disable_content');
                                //DISABLE NO-MORE
                                $row = $bids_stop_cls->getRow('SELECT stop_id FROM ' . $bids_stop_cls->getTable() . '
                                                                          WHERE property_id = ' . $property_id . ' AND agent_id = ' . $agent_id, true);
                                if (is_array($row) and count($row) > 0) {
                                } else {
                                    $bids_stop_cls->insert(array('property_id' => $property_id,
                                        'agent_id' => $agent_id,
                                        'time' => date('Y-m-d H:i:s')));
                                }
                            }

                            $info = Agent_getBidderInfo($_SESSION['agent']['id']);
                            $content = str_replace(array('[username]','[property_id]','[agent_info]'),array($agent_row['firstname'] . ' ' . $agent_row['lastname'],
                                    $property_id,$info), $content);

                            sendEmail_func($_SESSION['agent']['email_address'], $agent_row['email_address'], $content, $subject);
                            include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
                            $log_cls->createLog('disable_bidder');
                        }
                        if($action == 'allowBidder'){
                            if (1 - (int)$row['allow'] == 1) {//enable
                                //$subject = "You have been approved registration on a property ID#".$property_id;
                                //$content = "You have been approved registration on a property ID#".$property_id.'<br><br><br> Thanks you.';
                                $general_contact1_email = $config_cls->getKey('general_contact1_name');
                                $params_email_buyer = array();
                                $params_email_buyer['property_id'] = $property_id;
                                $params_email_buyer['to'] = array($agent_row['email_address'],$config_cls->getKey('general_contact1_name'));
                                $params_email_buyer['send_mymessage'] = true;
                                sendNotificationByEventKey('user_bidder_approved_vendor_agent_to_bid',$params_email_buyer);
                                //sendEmail_func('',array($agent_row['email_address'],$general_contact1_email), $content, $subject);

                                //$subject = "You have approved a user registration on a property ID#".$property_id;
                                //$content = "You have approved a user registration on a property ID#".$property_id.'<br><br><br> Thanks you.';
                                //sendEmail_func('', A_getEmail($_SESSION['agent']['id']), $content, $subject);
                                $params_email_vendor = array();
                                $params_email_vendor['property_id'] = $property_id;
                                $params_email_vendor['send_mymessage'] = true;
                                $params_email_vendor['to'] = array(A_getEmail($_SESSION['agent']['id']),$config_cls->getKey('general_contact1_name'));
                                sendNotificationByEventKey('user_bidder_approved_vendor_agent_to_bid_vendor',$params_email_vendor,array('[bidder_email_address]' => $agent_row['email_address']));
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
                    }
                    //end
                    $result = array('success' => 1, 'status' => 1 - $row[$field], 'astatus' => $row[$another_field]);
                    //push(0, array('type_msg' => 'update-property'));
                    //push1(0, array('type_msg' => 'update-property'));
                }
            }
        }
        die(json_encode($result));
    case 'refresh':
        $current_time = time();
        $property_id = (int)restrictArgs(getParam('property_id', 0));
        $isAgent = Property_isVendorOfProperty($property_id);

        $callbackFnc = array();
        $new_bid_max = __reportReportBid($property_id, 1, 1, $isAgent, 0);

        $new_reg = __reportRegisterToBid($property_id, 1, 1, $isAgent, 0);
        $new_no_more_bids = __reportNoMoreBid($property_id, 1, 1, $isAgent, 0);
        $new_logged = __reportLoggedInBid($property_id, 1, 1, 0);
        die(json_encode(array('callbackFnc' => $callbackFnc, 'nr' => (int)$new_bid_max, '_nr' => (int)$new_reg, 'nn' => (int)$new_no_more_bids, 'nl' => $new_logged)));
        break;
    case 'propose_require':
        include_once ROOTPATH . '/modules/property/inc/property.php';
        include_once ROOTPATH . '/modules/general/inc/propose_increment.php';

        die(json_encode(__proposeRequire()));
        break;
    case 'propose_accept':
        die(json_encode(__proposeAccept()));
        break;
    case 'propose_refuse':
        die(json_encode(__proposeRefuse()));
        break;
    case 'propose_finish':
        die(json_encode(__proposeFinish()));
        break;
    case 'win_finish':
        die(json_encode(__winFinish()));
        break;
    case 'customer_registration':
        die(json_encode(__customerRegistration()));
        break;
    case 'send_equiry':
        die(json_encode(__sendEquiryAction()));
        break;
}
function __sendEquiryAction(){
    global $config_cls;
    ini_set('display_errors', 0);
    $result = array('success' => 1);
    $email_address = getParam('email_address');
    if(empty($email_address)){
        $result['success'] = 0 ;
        $result['message'] = 'Please enter email address.';
    }else{
        include_once ROOTPATH . '/modules/general/inc/development.class.php';
        if (!isset($development_cls) || !($development_cls instanceof Development)) {
            $development_cls = new Development();
        }
        $row = $development_cls->getRow('email_address="'.$email_address.'"');
        if(is_array($row) && count($row) > 0){
            $result['message'] = 'This email existed.';
        }else{
            $data  = array(
                'first_name' => '',
                'last_name' => '',
                'email_address' => $email_address,
                'postcode' => '',
                'interested' => '',
                'interested_project' => '',
                'describes' => '');
            $development_cls->insert($data);
            if(!$development_cls->hasError()){
                $result['message'] = 'Saved successful.';
            }
        }
        $params_email = array('to' => array($email_address,'test@bidrhino.com',$config_cls->getKey('general_enquiry_email')));
        $params_email['subject'] = ' A enquiry email is registered.';
        $params_email['email_content'] = $email_address. ' is registered on bidrhino.com site. Thanks you!';
        sendNotificationByEventKey('user_enquiry_email',$params_email,array());
    }
    return $result;
}
function __customerRegistration(){
    $result = array();
    $result = $_POST;
    return $result;
}
function __tourGuideContent()
{
    include_once ROOTPATH . '/modules/cms/inc/cms.php';
    global $cms_cls, $config_cls, $smarty;

    $rows = $cms_cls->getRows('SELECT SQL_CALC_FOUND_ROWS cms.*
                               FROM ' . $cms_cls->getTable() . ' as cms
                               WHERE cms.is_tour_guide = 1
                               ORDER BY cms.sort_order
							   ', true);
    $data = array();
    $result = array();
    $result['success'] = 0;
    if (count($rows) > 0 and is_array($rows)) {
        foreach ($rows as $row)
        {
            $temp = array();
            $temp['title'] = $row['title'];
            $temp['content'] = $row['content'];
            $temp['page_id'] = $row['page_id'];
            $data[] = $temp;
        }
        $smarty->assign('data', $data);
        $result['success'] = 1;


        $mobileFolder = $mobileFolder?'/mobile/':'';
        $result['html'] = $smarty->fetch(ROOTPATH . '/modules/general/templates/'.$mobileFolder.'tourguide.tpl');
    }
    die(json_encode($result));
}

function registerToTransactAction()
{
    global $property_cls,$config_cls;
    $result = array('success' => 1, 'message' => '');
    $property_id = restrictArgs(getParam('property_id', 0));
    if ($property_id > 0) {
        $row = $property_cls->getCRow(array('release_time'), 'property_id = ' . $property_id);
        if(is_array($row) && !empty($row['release_time'])){
            if(date('Y-m-d H:i:s') < $row['release_time']){
                $dt = new DateTime($row['release_time']);
                $release_time = $dt->format($config_cls->getKey('general_date_format'));
                $result['success'] = 0;
                $result['message'] = 'You can not register to bid on this property, please wait to release date ['.$release_time.']. Thanks!';
            }
        }
        $agent_id = !empty($_SESSION['agent']['id']) ? $_SESSION['agent']['id'] : 0;
        if ($agent_id > 0) {
            $result['hasLogIn'] = true;
        } else {
            unset($_SESSION['new_agent']);
            unset($_SESSION['registerToTransact_agent_id']);
            unset($_SESSION['registerToTransact_id']);
        }
        //$type = getParam('type', '');
        $_SESSION['registerToTransact_id'] = $property_id;
        $result['redirect_link'] = ROOTURL . '/?module=agent&action=register-buyer&step=1&kind=transact';
        $result['redirect_link_logged'] = ROOTURL . '/?module=agent&action=register-buyer&step=1&kind=transact&transact_step=2';
    }else{
        $result['success'] = 0;
        $result['message'] = 'Can not process this property';
    }
    die(json_encode($result));
}
//=============={+}==============

/**
function : __bidAction
 **/
function __bidAction()
{
    global $agent_creditcard_cls, $bid_cls, $agent_cls, $property_cls, $bid_room_cls, $jsons;
    $property_id = restrictArgs(getParam('property_id', 0));
    $step = 0;
    $mine = getParam('mine', 0);
    $jsons = array();
    $jsons['id'] = $property_id;
    $jsons['isBlock'] = PE_isTheBlock($property_id) || PE_isTheBlock($property_id, 'agent');
    if (@$_SESSION['agent']['id'] <= 0) {
        $_SESSION['redirect'] = '?module=property&action=view-auction-detail&id=' . $property_id;
        $jsons['login'] = 1;
        unset($jsons['error']);
        return $jsons;
    }

    $min_incre = $max_incre = 0;
    if ($jsons['isBlock']) {
        $row = $property_cls->getRow('SELECT stop_bid,
                                            confirm_sold,
                                            min_increment,
                                            max_increment
                                          FROM ' . $property_cls->getTable() . '
                                          WHERE property_id = ' . $property_id, true);
        if (is_array($row) and count($row) > 0) {
            if ($row['confirm_sold'] == 1 || $row['stop_bid'] == 1) {
                $jsons['error'] = 1;
                $jsons['msg'] = $row['confirm_solid'] == 1 ? 'This property had been sold.'
                        : 'Bidding has stopped on this property (the Auction has finished).';
                return $jsons;
            } else {
                $min_incre = $row['min_increment'];
                $max_incre = $row['max_increment'];
                $ok = (int)$min_incre > 0 || (int)$max_incre > 0;
            }

        }
        $step = $min_incre == $max_incre ? 0 : $max_incre - $min_incre;
    }
    if (in_array($_SESSION['agent']['type'], array('theblock', 'agent')) && $mine == 1) {
        if (Property_isLockBid($property_id)) {
            $jsons['error'] = 1;
            $jsons['msg'] = 'Sorry, this property is not ready. Please click Start Auction button for opening bid.';
            return $jsons;
        }
        $price = getPost('money_step', 0);
        $incre = PT_getValueByCode($property_id, 'initial_auction_increments');
        $bid_price = PE_getBidPrice($property_id);

        if ($price <= $bid_price) {
            $jsons['error'] = 1;
            $jsons['msg'] = 'Bid price must be larger than ' . showPrice($bid_price);
        } else {
            $increment = $price - $bid_price;
            $jsons['error'] = 0;
            if ($jsons['isBlock'] && $ok) {
                if ($step == 0) {
                    if ($increment != $min_incre) {
                        $jsons['error'] = 1;
                        $jsons['msg'] = 'This property is only bid with price is ' . $min_incre . '.<br/>
                                     Please bid with price is ' . showPrice(($bid_price + $min_incre)) . '.';
                    }
                } elseif ($step < 0) { //only min_incre
                    if ($increment < $min_incre) {
                        $jsons['error'] = 1;
                        $jsons['msg'] = 'Min increment of this property is ' . showPrice($min_incre) . '<br />
                                     Please bid with price larger than ' . showPrice(($bid_price + $min_incre)) . '.';
                    }
                } else {
                    if ($increment >= $min_incre && $increment <= $max_incre) {
                    } else {
                        $jsons['error'] = 1;
                        if ($min_incre > 0) {
                            $jsons['msg'] = 'Increment of this property between is ' . showPrice($min_incre) . ' and ' . showPrice($max_incre) . '.<br />
                                             Please bid with price larger than ' . showPrice(($bid_price + $min_incre)) . ' and smaller than ' . showPrice(($bid_price + $max_incre)) . '.';
                        } else {
                            $jsons['msg'] = 'Max increment of this property is ' . showPrice($max_incre) . '<br />
                                             Please bid with price smaller than ' . showPrice(($bid_price + $max_incre)) . '.';
                        }
                    }
                }
            }
            if ($jsons['error'] == 0) {
                $jsons['msg'] = 'Please confirm your bid price ' . showPrice($price) . ' ?';
                $jsons['money'] = $price - $bid_price;
            }
        }
    } else {
        if ($bid_room_cls->isExist($_SESSION['agent']['id'], $property_id)) {
            $jsons['error'] = 1;
            //$jsons['msg'] = 'Your turn on autobid on this property.'."<br/>".'Please turn off autobid to use this feature.';
            $jsons['msg'] = 'It is currently your turn in the autobid queue for this property. If you want to manually bid, please turn off your autobid for this property by clicking on autobid and then the <font style="color:#2f2f2f;font-size:14px;font-weight:bold;">Cancel</font> button.';
            return $jsons;
        }

        $output = Bid_isValid($_SESSION['agent']['id'], $property_id, false, false, $_SESSION['agent']['type']);
        if (count($output) > 0) {
            foreach ($output as $k => $item) {
                $jsons[$k] = $output[$k];
            }
            $jsons['error'] = 1;
        } else {
            $jsons['error'] = 0;

            //get increment price
            $money_step = getPost('money_step', 0); //WHEN BIDDER CHOSE FROM COMBOBOX
            $incre = PT_getValueByCode($property_id, 'initial_auction_increments');
            if (!$jsons['isBlock']){
                $min_incre = $incre;
                $max_incre = 0;
                $step = $min_incre == $max_incre ? 0 : $max_incre - $min_incre;
            }
            $increment = ($money_step == 0) ? $incre: $money_step;
            $bid_price = PE_getBidPrice($property_id);

            if (($jsons['isBlock'] && $ok) || (isset($min_incre) && $min_incre > 0)) {
                if ($step == 0) {
                    if ($increment != $min_incre) {
                        $jsons['error'] = 1;
                        $jsons['msg'] = 'This property is only bid with price is ' . $min_incre . '.<br/>
                                     Please bid with price is ' . showPrice(($bid_price + $min_incre)) . '.';
                    }
                } elseif ($step < 0) { //only min_incre
                    if ($increment < $min_incre) {
                        $jsons['error'] = 1;
                        $jsons['msg'] = 'Min increment of this property is ' . showPrice($min_incre) . '<br />
                                     Please bid with price larger than ' . showPrice(($bid_price + $min_incre)) . '.';
                    }
                } else {
                    if ($increment >= $min_incre && $increment <= $max_incre) {

                    } else {
                        $jsons['error'] = 1;
                        if ($min_incre > 0) {
                            $jsons['msg'] = 'Increment of this property between is ' . showPrice($min_incre) . ' and ' . showPrice($max_incre) . '.<br />
                                             Please bid with price larger than ' . showPrice(($bid_price + $min_incre)) . ' and smaller than ' . showPrice(($bid_price + $max_incre)) . '.';
                        } else {
                            $jsons['msg'] = 'Max increment of this property is ' . showPrice($max_incre) . '<br />
                                             Please bid with price smaller than ' . showPrice(($bid_price + $max_incre)) . '.';
                        }
                    }
                }
            }
            if ($jsons['error'] == 0) {
                $after_price = showPrice($increment + $bid_price);
                $jsons['msg'] = 'Please confirm your bid price ' . $after_price . ' ?';
            }
        }
    }

    return $jsons;
}

/**
function : __bidAction
 **/
function __onBidAction()
{
    global $bid_room_cls, $property_cls, $jsons, $bids_mailer_cls, $banner_cls;
    $property_id = restrictArgs(getParam('property_id', 0));
    /*if (@$_SESSION['agent']['id'] <= 0) {
         $jsons['error'] = true;
         $jsons['msg'] = 'Please login !';
         return $jsons;
     }*/
    $jsons = array();
    $mine = getParam('mine');
    $room = getParam('room');
    $jsons['property_id'] = $property_id;
    if (in_array($_SESSION['agent']['type'], array('theblock', 'agent')) && $mine === 'true') {
        $money = getParam('money', 0);
        if ($money == 0) {
            $jsons['success'] = false;
            $jsons['msg'] = 'Error';
        }
        $in_room = $room === 'true' ? 1 : 0;

        if (Bid_addByBidder($_SESSION['agent']['id'], $property_id, $money, 0, true, false, true, $in_room)) {
            $jsons['success'] = true;
            $jsons['msg'] = 'Your bid is successful';
            if (APE_ENABLE) {
                $jsons['ape'] = __getBidAction($property_id);
            }
        }
    } else {
        if ($bid_room_cls->isExist($_SESSION['agent']['id'], $property_id)) {
            $jsons['success'] = false;
            $jsons['msg'] = 'You have an Auto Bid set for this property and you are currenlty next in queue to bid on this property. If you want to manually place bids now please turn off your autobid.';
            return $jsons;
        }

        $output = Bid_isValid($_SESSION['agent']['id'], $property_id);
        if (count($output) > 0) {
            $jsons['success'] = false;
            $jsons['msg'] = $output['msg'];
        } else {
            $jsons['success'] = false;
            $jsons['msg'] = 'You have just been outbid, please bid again !';
            if (!$property_cls->isLocked($property_id) || $property_cls->isExpire($property_id)) {
                $property_cls->lock($property_id);

                if (Bid_addByBidder(@$_SESSION['agent']['id'], $property_id)) {
                    $jsons['success'] = true;
                    $jsons['msg'] = 'Your bid is successful';
                    Bid_sendSMSEmail($property_id,$_SESSION['agent']['id']);

                    //Bid_PossMessage_Fb_Tw($property_id, $_SESSION['agent']['id']);
                    /*
					$row = Bid_getLastBidByPropertyId($property_id);
                    $price = $row['price'];
                    $data = array('property_id' => $property_id,
                              'agent_id' => @$_SESSION['agent']['id'],
                              'bid_price' => $price,
                              'bid_time' => date('Y-m-d H:i:s'),
                              'email' => @$_SESSION['agent']['email_address'],
                              'sent' => 0);
                    $bids_mailer_cls->insert($data);
					*/
                    //ape_insert(array('key' => $property_id, 'data' => serialize(__getBidAction($property_id))));
                    if (APE_ENABLE) {
                        $jsons['ape'] = __getBidAction($property_id);
                    }
                } else {
                    $jsons['msg'] = 'Your bid is unsuccessful.';
                }

                $property_cls->unLock($property_id);
            }

        }
    }
    //print_r($jsons);
    // UPDATE NOTIFICATION TO ANDROID
    //push(0, array('type_msg' => 'update-property'));
    //push1(0, array('type_msg' => 'update-property'));
    return $jsons;
}

/**
function : __getBidAction
 **/
function __getBidAction($property_id = 0)
{
    global $property_cls, $agent_cls, $bid_cls, $autobid_setting_cls, $bid_room_cls, $config_cls, $jsons, $count, $propose_increment_cls;
    $data = array();
    $auction_sale_ar = PEO_getAuctionSale();
    $property_ids = $property_id > 0 ? $property_id : restrictArgs(getParam('ids'), '[^0-9\-]');
    $property_id_ar = array_unique(explode('-', $property_ids));

    if (is_array($property_id_ar) && count($property_id_ar) > 0 && count($property_id_ar) < 100) {
        $jsons['success'] = 1;
        /*
          $rows = $property_cls->getRows('SELECT pro.*,
                                              (SELECT count(*)
                                              FROM '.$bid_cls->getTable().' AS bid
                                              WHERE bid.property_id = pro.property_id
                                              ) AS bids,

                                              (SELECT SUM(pro_log.view)
                                              FROM '.$property_cls->getTable('property_log').' AS pro_log
                                              WHERE pro_log.property_id = pro.property_id
                                              )AS views

                                          FROM '.$property_cls->getTable().' AS pro
                                          WHERE pro.property_id IN ('.implode(",",$property_id_ar).')',true);
          */

        $file_name = ROOTPATH . '/cache/' . md5(implode('_', $property_id_ar)) . '.cache';
        //if ((file_exists($file_name) && remainTime(date('Y-m-d H:i:s'),date("Y-m-d H:i:s", filemtime($file_name))) < 2 )) {
        //$data = Cache_get($file_name);
        //} else {
        $rows = $property_cls->getRows('SELECT  pro.agent_id,
													pro.property_id,
													pro.stop_bid,
													pro.auction_sale,
													pro.confirm_sold,
													pro.end_time,
													pro.start_time,
													pro.pay_status,
													pro.set_count,
													pro.stop_bid,
													pro.no_more_bid,
													pro.max_increment,
													pro.min_increment,
													pro.is_record,
													pro.lock_bid,
													pro.listening
													
											FROM ' . $property_cls->getTable() . ' AS pro
											WHERE pro.property_id IN (\'' . implode("','", $property_id_ar) . '\')
													AND pro.active = 1
													AND pro.pay_status = 2', true);


        if (!is_array($rows) || count($rows) == 0) {
            return $data;
        }

        foreach ($rows as $row) {
            $finish = 0;
            $type_property = '';
            $stop_bid = $row['stop_bid'];

            $data[$row['property_id']] = array();
            $data[$row['property_id']]['set_count'] = $row['no_more_bid'] == 1 && $row['lock_bid'] == 0? 'No More Online Bids': $row['set_count'];
            //$data[$row['property_id']]['set_count'] = $row['set_count'];

            if (in_array($row['auction_sale'],array($auction_sale_ar['ebiddar'],$auction_sale_ar['bid2stay'])) && $row['confirm_sold'] == 1){
                $data[$row['property_id']]['rent'] = 1;
            }
            if ($row['auction_sale'] == $auction_sale_ar['private_sale']) {
                $type_property = 'sale';
            } else if ($row['confirm_sold'] == 1) {
                $property_cls->update(array('stop_bid' => 1), 'property_id = ' . $row['property_id']);
                //$autobid_setting_cls->delete('property_id = '.$row['property_id']);
                //$bid_room_cls->delete('property_id = '.$row['property_id']);
            } else {
                if (!Validate::isDateTime(array($row['end_time']))) {
                    continue;
                }
                $remain_time = remainTime($row['end_time']);
                $data[$row['property_id']]['remain_time'] = $remain_time;
                $isBlock = PE_isTheBlock($row['property_id']);
                $isAgent = PE_isTheBlock($row['property_id'], 'agent');

                if ($remain_time <= 0) {
                    $finish = 1;
                    $stop_bid = 1;
                    $type_property = 'stop_auction';
                    $property_cls->update(array('stop_bid' => 1, 'stop_time' => date('Y-m-d H:i:s')), 'property_id = ' . $row['property_id']);
                } else {
                    //if (($isBlock || ($isAgent && PE_isNormalAuction($row['property_id']))) && $row['stop_bid'] == 1) {
                    if ($row['stop_bid'] == 1) { // SET FROM CANCEL BIDDING
                        $type_property = 'stop_auction';
                    } else if ($row['start_time'] < date('Y-m-d H:i:s')) {
                        $type_property = 'live_auction';
                        //$property_cls->update(array('stop_bid' => 0), 'property_id = ' . $row['property_id']);
                    } else {
                        $type_property = 'forthcoming';
                        /*if ($row['confirm_sold'] == 0) {
                            $stop_bid = 0;
                            $property_cls->update(array('stop_bid' => 0), 'property_id = ' . $row['property_id']);
                        }*/
                    }
                }
            }
            $data[$row['property_id']]['live_time'] = remainTime($row['start_time'], date('Y-m-d H:i:s'));
            if ($stop_bid == 0 && $row['confirm_sold'] == 0) {
                try {
                    $data[$row['property_id']]['isVendor'] = Property_isVendorOfProperty($row['property_id'], $_SESSION['agent']['id']);
                    //$data[$row['property_id']]['ID'] = $_SESSION['agent']['id'];
                    //$data[$row['property_id']]['ID'] = $_SESSION['agent']['agent_id'];
                } catch (Exception $e) {
                    $data[$row['property_id']]['isVendor'] = false;
                }
                $data[$row['property_id']]['ID'] = $_SESSION['agent']['id'];

                $data[$row['property_id']]['on_server'] = ON_SERVER;
                $data[$row['property_id']]['MinMax_mess'] = PE_getMinMaxIncMess($row['min_increment'], $row['max_increment']);
                $iai_id = AT_getIdByCode('initial_auction_increments');
                $data[$row['property_id']]['MinMax_options'] = AT_getIncOptionsByMinMax($iai_id, $row['min_increment'], $row['max_increment']);

                if ($_SESSION['agent']['type'] == 'theblock') {
                    if ($_SESSION['increment'][$row['property_id']]['min'] != $row['min_increment'] || $_SESSION['increment'][$row['property_id']]['max'] != $row['max_increment']) {
                        //$data[$row['property_id']]['max_increment'] = $row['max_increment'];
                        //$data[$row['property_id']]['min_increment'] = $row['min_increment'];
                    }
                    $_SESSION['increment'][$row['property_id']]['min'] = $row['min_increment'];
                    $_SESSION['increment'][$row['property_id']]['max'] = $row['max_increment'];
                }
                $data[$row['property_id']]['register_bid'] = getRegisterBidValue($row['property_id'], (int)$_SESSION['agent']['id']) > 0
                        ? true : false;
                /*$data[$row['property_id']]['register_bid'] = (boolean)bid_first_isvalid($row['property_id'],(int)$_SESSION['agent']['id']);*/
            }

            $data[$row['property_id']]['count'] = $count;
            $agent_row = $agent_cls->getRow('SELECT agt.agent_id,
															agt.firstname,
															agt.lastname,
															bid.price,
															bid.time,
															bid.in_room,
															bid.is_offer
													FROM ' . $agent_cls->getTable() . ' AS agt,' . $bid_cls->getTable() . ' AS bid
													WHERE agt.agent_id = bid.agent_id AND bid.property_id = ' . $row['property_id'] . '
													ORDER BY bid.price DESC', true);
            $data[$row['property_id']]['bid_price'] = 0;
            if (is_array($agent_row) && count($agent_row) > 0) {

                $data[$row['property_id']]['bidder_id'] = $agent_row['agent_id'];

                $data[$row['property_id']]['bidder'] = getShortName($agent_row['firstname'], $agent_row['lastname']);
                $data[$row['property_id']]['bidder_short'] = getShortName($agent_row['firstname'], $agent_row['lastname']);

                $data[$row['property_id']]['isLastBidVendor'] = Bid_isLastBidVendor($row['property_id']);
                $data[$row['property_id']]['bid_price'] = $agent_row['price'];
                $data[$row['property_id']]['price'] = showPrice($agent_row['price']);
                $data[$row['property_id']]['confirm_price'] = showPrice($agent_row['price']);
                $data[$row['property_id']]['last_time'] = remainTime($row['end_time'], $agent_row['time']);
                $data[$row['property_id']]['inRoom'] = $agent_row['in_room'];
                //$data[$row['property_id']]['remain_time'] = $remain_time;

            }
            $data[$row['property_id']]['reserve_price'] = PT_getValueByCode($row['property_id'], 'reserve');
            if ($data[$row['property_id']]['reserve_price'] <= $data[$row['property_id']]['bid_price']
                and $data[$row['property_id']]['bid_price'] > 0
                and $data[$row['property_id']]['reserve_price'] > 0
                and $stop_bid == 1
                and !Bid_isLastBidVendor($row['property_id'])
                //and !($isBlock || ($isAgent && PE_isNormalAuction($row['property_id'])))
            ) {
                $row_pro = $property_cls->getCRow(array('confirm_sold','stop_bid'),'property_id = ' . $row['property_id']);
                if(is_array($row_pro) && count($row_pro) >0){
                    if($row_pro['confirm_sold'] != 1 && $agent_row['is_offer'] != 1 ){
                        $property_cls->update(array('confirm_sold' => 1, 'stop_bid' => 1, 'sold_time' => date('Y-m-d H:i:s')), 'property_id = ' . $row['property_id']);
                        Property_afterSold($row['property_id']);
                        Property_sendWinner($row);
                    }
                }

            }
            //}

            if ($autobid_setting_cls->getReceived(array('agent_id' => (int)$_SESSION['agent']['id'], 'property_id' => $row['property_id'])) == 1) {
                $data[$row['property_id']]['autobid'] = 0;
                $data[$row['property_id']]['out_bidder_id'] = (int)$_SESSION['agent']['id'];
                $data[$row['property_id']]['msg'] = 'Your autobid detect has stopped.';
                $autobid_setting_cls->setReceived(array('agent_id' => (int)$_SESSION['agent']['id'], 'property_id' => $row['property_id'], 'received' => 0));
            }

            $data[$row['property_id']]['type_property'] = $type_property;
            $data[$row['property_id']]['finish'] = $finish;
            $data[$row['property_id']]['stop_bid'] = (int)$stop_bid;
            $data[$row['property_id']]['confirm_sold'] = (int)$row['confirm_sold'];
            $data[$row['property_id']]['pay_status'] = (int)$row['pay_status'];
            $data[$row['property_id']]['inRoom'] = $data[$row['property_id']]['isLastBidVendor'] && $data[$row['property_id']]['inRoom'];
            $data[$row['property_id']]['agent_id'] = $_SESSION['agent']['id'];

            $data[$row['property_id']]['ebidda_watermark'] = PE_getEbiddaWatermark($row['property_id']);
            $data[$row['property_id']]['max_increment'] = $row['max_increment'];
            $data[$row['property_id']]['min_increment'] = $row['min_increment'];
            $data[$row['property_id']]['is_record'] = (int)$row['is_record'];

            $data[$row['property_id']]['is_play'] = in_array($_SESSION['agent']['id'], explode('-', $row['listening']))
                    ? 1 : 0;

            $reaxml_status = PE_getPropertyStatusREA_xml($row['property_id']);
            $data[$row['property_id']]['reaxml_status'] = '';
            if(in_array($reaxml_status,array('sold','leased','passed in','under offer')))
                $data[$row['property_id']]['reaxml_status'] = $reaxml_status;
            // BEGIN PROPOSE INCREMENT
            $ar = __getProposeIncrement($row['property_id']);
            if (count($ar) > 0) {
                $data[$row['property_id']]['propose_increment'] = $ar;
            }

            // BEGIN ALERT FOR WINNER
            if ($stop_bid == 1 && trim($row['set_count']) != 'Passed In' && !Property_isVendorOfProperty($row['property_id'], $_SESSION['agent']['id'])) {
                $data[$row['property_id']]['win_info'] = __getAlertWinner($row['property_id']);
            }
            //}
            // BEGIN SET CACHE
            //@unlink($file_name);
            //Cache_set($file_name, $data);
        }
        // end if

    }
    //end if

    $jsons['data'] = $data;

    return $jsons;
}

/**
function : __getProposeIncrement
 **/

function __getProposeIncrement($property_id = 0)
{
    global $propose_increment_cls, $agent_cls, $property_cls;
    $rs = array();
    $pi_rows = $propose_increment_cls->getRows('SELECT pi.from_id, pi.property_id, pi.amount, pi.type_approved,
						agent.firstname, agent.lastname	
					FROM ' . $propose_increment_cls->getTable() . ' AS pi, ' . $agent_cls->getTable() . ' AS agent
					WHERE pi.from_id = agent.agent_id AND pi.type_approved < 3 AND pi.property_id = ' . (int)$property_id, true);

    if (count($pi_rows) > 0) {
        foreach ($pi_rows as $pi_row) {
            switch ($pi_row['type_approved']) {
                case '1':
                    $pi_row['label_approved'] = 'Accepted';
                    $pro_pi_row = $property_cls->getCRow(array('min_increment', 'max_increment'), 'property_id = ' . (int)$property_id);
                    if (count($pro_pi_row) > 0) {
                        $pi_row['min_increment'] = $pro_pi_row['min_increment'];
                        $pi_row['max_increment'] = $pro_pi_row['max_increment'];
                    }
                    break;
                case '2':
                    $pi_row['label_approved'] = 'Rejected';
                    break;
                default :
                    $pi_row['label_approved'] = '';
                    break;
            }
            $pi_row['property_id'] = (int)$property_id;
            $pi_row['fullname'] = getShortName($pi_row['firstname'], $pi_row['lastname']);
            $rs[$pi_row['from_id']] = $pi_row;
        }
    }
    return $rs;
}

/**
function : __getAlertWinner
 **/

function __getAlertWinner($property_id = 0)
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
            $add2 = A_getCompanyAddress(__getWinnerInfo);
            $rs['agent_address'] = strlen($add2) > 0 ? $add2 : $add1;


            /*-- FOR MOBILE*/
            $rs['msg1'] = 'Congratulations!';
            $rs['msg2'] = 'You are the winning bidder and as the Highest bidder, you are buying this property.';
            $rs['msg3'] = 'Please contact the Managing Agent.';
        }
    }
    return $rs;
}

/**
function : __winnerInfoAction
 **/

function __registerBidAgentAction()
{

    global $bid_cls, $agent_cls, $config_cls, $smarty, $property_cls, $property_history_cls, $partner_cls;
    $data = array('success' => false);
    $data_ = '';
    $row = array();
    //$agent_id = restrictArgs(getParam('agent_id'),0);
    $agent_id = getParam('agent_id');
    if ($agent_id > 0) {
        if ($agent_id > 0) {
            //$row = $agent_cls->getRow('agent_id='.$agent_id);
            $row = PE_getAgent($agent_id);
            if (is_array($row) and count($row) > 0) {
                $row['name'] = A_getFullName($row['agent_id']);
                if ($row['other_state'] == '' OR !isset($row['other_state']))
                    $row['address'] = implode(', ', array($row['street'], $row['suburb'], $row['state_name'], $row['postcode'], $row['country_name']));
                else {
                    $row['address'] = implode(', ', array($row['street'], $row['suburb'], $row['other_state'], $row['postcode'], $row['country_name']));
                }
                $row['address'] = str_replace(array(', ,'), array(', '), $row['address']);

                if ($row['type_id'] == 3) // PARTENER
                {
                    $row_partner = $agent_cls->getRow('SELECT p.*,ac.*
                                                   FROM ' . $partner_cls->getTable() . ' AS p
                                                   LEFT JOIN ' . $agent_cls->getTable('agent_contact') . '  AS ac
                                                   ON ac.agent_id = p.agent_id
                                                   WHERE p.agent_id = ' . $agent_id, true);
                    //print_r($row_partner);
                    if (count($row_partner) > 0) {
                        $row['license_number'] = $row_partner['register_number'];
                        //$row['mobilephone'] = $row_partner['mobilephone'];
                        //$row['telephone'] = $row_partner['mobilephone'];
                    }
                }
                $data['success'] = true;

            }
            $smarty->assign('agent_id', $agent_id);
            $smarty->assign('data_agent', formUnescapes($row));
            $data['info'] = $smarty->fetch(ROOTPATH . '/modules/property/templates/property.registerbid.info.tpl');
            $data['success'] = true;
        }
    }

    return $data;
}

/**
function : __winnerInfoAction
 **/

function __winnerInfoAction()
{

    global $bid_cls, $agent_cls, $config_cls, $smarty, $property_cls, $property_history_cls;
    $data = array('success' => 0);
    $data_ = '';
    $row = array();
    $property_id = restrictArgs(getParam('property_id', 0));
    if ($property_id > 0) {
        $row = PE_getWinnerProperty($property_id);
        if (is_array($row) and count($row) > 0) {
            $row['name'] = A_getFullName($row['agent_id']);
            /*if($row['other_state'] == '')
                $row['address'] = implode(' ',array($row['street'],$row['suburb'],$row['state_name'],$row['postcode'],$row['country_name']));
            else{
                $row['address'] = implode(' ',array($row['street'],$row['suburb'],$row['other_state'],$row['postcode'],$row['country_name']));
            }
            $row['address'] = str_replace(array(', ,'),array(', '),$row['address']);
            */
            //NH EDIT
            $row['address'] = $row['street'] . ', ' . implode(' ', array($row['suburb'], $row['other_state'], $row['state_name'], $row['postcode'], $row['country_name']));
            $row['postal_address'] = $row['postal_address'] . ', ' . implode(' ', array($row['postal_suburb'], $row['postal_other_state'], $row['postal_state_name'], $row['postal_postcode'], $row['postal_country_name']));
            $data['success'] = 1;

        }
        $smarty->assign('property_id', $property_id);
        $smarty->assign('data_agent', formUnescapes($row));
        $data['info'] = $smarty->fetch(ROOTPATH . '/modules/property/templates/property.winner.info.tpl');
        $data_ = $data['info'];
    }

    return $data_;
}

function __checkLoginAction()
{
    global $smarty;
    $Auth = array();
    $data = array('success' => 0);
    $is_login = 0;

    //BEGIN
    $authentic = array();
    if (isset($_SESSION['agent'])) {
        $authentic = $_SESSION['agent'];
        $is_login = 1;
        $data['success'] = 1;
        $Auth['is_login'] = $is_login;
        $Auth['Agent'] = $authentic;
    }
    //END
    $logout_url = '/?module=agent&action=logout';
    $smarty->assign('logout_url', $logout_url);
    $smarty->assign('is_login', $is_login);
    $smarty->assign('authentic', $authentic);
    $data['form_login'] = $smarty->fetch(ROOTPATH . '/modules/general/templates/login.box.tpl');

    //return $smarty->fetch(ROOTPATH.'/modules/general/templates/login.box.tpl');
    return $data;

}

function __checkLoginAjaxAction()
{
    global $smarty;
    $Auth = array();
    $data = array('success' => 0);
    $is_login = 0;

    //BEGIN
    $authentic = array();
    if (isset($_SESSION['agent'])) {
        $authentic = $_SESSION['agent'];
        $is_login = 1;
        $data['success'] = 1;
        $Auth['is_login'] = $is_login;
        $Auth['Agent'] = $authentic;
    }
    //END
    $logout_url = '/?module=agent&action=logout';
    $smarty->assign('logout_url', $logout_url);
    $smarty->assign('is_login', $is_login);
    $smarty->assign('authentic', $authentic);
    $data['form_login'] = $smarty->fetch(ROOTPATH . '/modules/general/templates/login.box.tpl');
    $ajax_resulst = $data['form_login'];
    return $ajax_resulst;

}

/**
function : __bidHistoryAction
 **/

function __bidHistoryAction(){
    global $bid_cls, $agent_cls, $config_cls, $smarty, $property_cls, $property_history_cls;

    $property_id = restrictArgs(getParam('property_id', 0));
    $view = getParam('view', '');
    if ($property_id <= 0) return '';
    $p = 1;
    $len = 1000;
    $show_all = false;
    $show_his_all = false;

    $bid_rows = $bid_cls->getRows('SELECT SQL_CALC_FOUND_ROWS
											bid.price,
											bid.time,
											agt.firstname,
											agt.lastname,
											agt.agent_id,
											agt.email_address
									FROM ' . $bid_cls->getTable() . ' AS bid,' . $agent_cls->getTable() . ' AS agt
									WHERE bid.agent_id = agt.agent_id AND bid.property_id = ' . $property_id . '
									ORDER BY bid.price DESC
									LIMIT ' . ($p - 1) * $len . ',' . $len, true);

    $total_row = $bid_cls->getFoundRows();
    $rows = array();
    if ($bid_cls->hasError()) {

    } else if (is_array($bid_rows) and count($bid_rows) > 0) {
        foreach ($bid_rows as $key => $row) {
            $dt = new DateTime($row['time']);
            $rows[] = array('name' => getShortName($row['firstname'], $row['lastname']),
                            'price' => showPrice($row['price']),
                            'time' => $dt->format($config_cls->getKey('general_date_format')) . ' at ' . $dt->format('H:i:s'));
        }


        $row = $property_cls->getRow('property_id=' . $property_id);
        if (is_array($row) and count($row) > 0) {
            if ($row['agent_id'] == $_SESSION['agent']['id'] and isset($_SESSION['agent']['id'])) {
                $show_all = true;
                $link_showall = ROOTURL . '/?module=property&action=bid-history-full&property_id=' . $property_id . '&view=' . $view;

            }
        }


    }
    else
    {
        $row_his = $property_history_cls->getRow('property_id=' . $property_id);
        if (is_array($row_his) and count($row_his) > 0) {
            $row = $property_cls->getRow('property_id=' . $property_id);
            if (is_array($row) and count($row) > 0) {
                if ($row['agent_id'] == $_SESSION['agent']['id'] and isset($_SESSION['agent']['id'])) {
                    $show_his_all = true;
                    $link_showall = ROOTURL . '/?module=property&action=bid-history-full&property_id=' . $property_id . '&id=' . $row_his['property_transition_history_id'] . '&view=' . $view;
                }
            }

        }
    }

    $smarty->assign('show_all', $show_all);
    $smarty->assign('show_his_all', $show_his_all);
    $smarty->assign('rows', formUnescapes($rows));
    $smarty->assign('property_id', $property_id);
    $smarty->assign('link_showall', $link_showall);
    if(detectBrowserMobile()){
        $rs = $smarty->fetch(ROOTPATH . '/modules/general/templates/mobile/bid_history.tpl');
    }else{
        $rs = $smarty->fetch(ROOTPATH . '/modules/general/templates/bid_history.tpl');
    }
    return $rs;
}

/**
function : __bidHistoryAction
 **/

function __reportReportBid($property_id, $p, $len, $isAgent, $need_detail = 1)
{
    global $bid_cls, $agent_cls, $config_cls, $smarty, $property_cls, $pag_cls, $property_history_cls, $payment_store_cls, $bids_stop_cls;

    // BEGIN BID
    if ($need_detail) {
        $bid_rows = $bid_cls->getRows('SELECT SQL_CALC_FOUND_ROWS
                                                bid.price,
                                                bid.time,
                                                bid.in_room,
                                                bid.agent_id,
                                                agt.firstname,
                                                agt.lastname,
                                                agt.agent_id as Agent_id,
                                                agt.email_address
                                        FROM ' . $bid_cls->getTable() . ' AS bid,' . $agent_cls->getTable() . ' AS agt
                                        WHERE bid.agent_id = agt.agent_id AND bid.property_id = ' . $property_id . '
                                        ORDER BY bid.price DESC
                                        LIMIT ' . ($p - 1) * $len . ',' . $len, true);
        $total_row = $bid_cls->getFoundRows();
        $actualBid_rows = array();

        if ($bid_cls->hasError()) {
        } else if (is_array($bid_rows) and count($bid_rows) > 0) {
            $i = $len * ($p - 1) + 1;
            foreach ($bid_rows as $key => $row) {
                $row['name'] = $isAgent ? $row['firstname'] . ' ' . $row['lastname']
                        : getShortName($row['firstname'], $row['lastname']);

                if (Property_isVendorOfProperty($property_id, $row['agent_id'])) {
                    $row['name'] = $row['in_room'] == 1 ? 'In Room Bid' : 'Vendor Bid';
                }

                $dt = new DateTime($row['time']);
                $actualBid_rows[] = array('ID' => $i++,
                                          'name' => $row['name'],
                                          'raw_price' => $row['price'],
                                          'price' => showPrice($row['price']),
                                          'info' => Agent_getBidderInfo($row['agent_id'], false),
                                          'agent_id' => $row['agent_id'],
                                          'time' => $dt->format($config_cls->getKey('general_date_format')) . ' at ' . $dt->format('H:i:s')
                );
            }
            $pag_cls->setTotal($total_row)
                    ->setPerPage($len)
                    ->setCurPage($p)
                    ->setLenPage(10)
                    ->setLayout('ajax')
                    ->setUrl('')
                    ->setFnc('reloadReportBid');
            $smarty->assign('pagingBid', $pag_cls->layout());

        }
        $smarty->assign('actualBid_rows', formUnescapes($actualBid_rows));

    }
    $bid_max_row = $bid_cls->getRow('SELECT max(price) AS price
                                         FROM ' . $bid_cls->getTable() . '
                                         WHERE property_id = ' . $property_id, true);
    if (is_array($bid_max_row) and count($bid_max_row)) {
        $bid_max = $bid_max_row['price'];
    }
    $smarty->assign('bid_max', $bid_max);
    return $bid_max;
    // END
}

function __reportNoMoreBid($property_id, $p, $len, $isAgent, $need_detail = 1)
{
    global $agent_cls, $config_cls, $smarty, $property_cls, $pag_cls, $bids_stop_cls;

    if ($need_detail) {
        if (in_array($_SESSION['agent']['type'], array('agent', 'theblock')) && $isAgent) {
            $rows = $bids_stop_cls->getRows('SELECT SQL_CALC_FOUND_ROWS a.firstname,
                                                                        a.lastname,
                                                                        a.agent_id,
                                                                        a.email_address,
                                                                        b.*
                                            FROM ' . $agent_cls->getTable() . ' AS a
                                            LEFT JOIN ' . $bids_stop_cls->getTable() . ' AS b
                                            ON a.agent_id = b.agent_id
                                            WHERE b.property_id = ' . $property_id . '
                                            ORDER BY b.time DESC
                                            LIMIT ' . ($p - 1) * $len . ',' . $len, true);
            $total_row = $bids_stop_cls->getFoundRows();

            $data = array();
            if (is_array($rows) and count($rows) > 0) {
                $i = $len * ($p - 1) + 1;
                foreach ($rows as $row) {
                    $dt = new DateTime($row['time']);
                    $row['ID'] = $i++;
                    $row['time'] = $dt->format($config_cls->getKey('general_date_format')) . ' at ' . $dt->format('H:i:s');
                    $row['info'] = Agent_getBidderInfo($row['agent_id'], false);
                    $data[] = $row;
                }
            }
            $smarty->assign('no_more_bids_data', $data);
            $pag_cls->setTotal($total_row)
                    ->setPerPage($len)
                    ->setCurPage($p)
                    ->setLenPage(10)
                    ->setLayout('ajax')
                    ->setUrl('')
                    ->setFnc('reloadReportNoMoreBid');
            $smarty->assign('paging', $pag_cls->layout());
            $property = $property_cls->getRow('SELECT no_more_bid FROM ' . $property_cls->getTable() . ' WHERE property_id = ' . $property_id, true);
            $smarty->assign('no_more_bids_msg', $property['no_more_bid']);
        }
    }
    //END
    $new_reg = 0;
    $reg_new_row = $bids_stop_cls->getRow('SELECT max(stop_id) AS max
                                                   FROM ' . $bids_stop_cls->getTable() . '
                                                   WHERE property_id = ' . $property_id, true);
    if (is_array($reg_new_row) and count($reg_new_row) > 0) {
        $new_reg = $reg_new_row['max'];
    }
    $smarty->assign('new_no_more_bids', $new_reg);
    return $new_reg;
}

function __reportLoggedInBid($property_id, $p, $len, $need_detail = 1)
{
    global $payment_store_cls, $pag_cls, $agent_cls, $user_online_cls, $config_cls, $smarty;

    if ($need_detail) {
        $rows = $user_online_cls->getRows('SELECT SQL_CALC_FOUND_ROWS
                                              u.agent_id,
                                              FROM_UNIXTIME(u.last_active),
                                              a.firstname,
                                              a.lastname,
                                              a.email_address
                                       FROM ' . $user_online_cls->getTable() . ' AS u
                                       INNER JOIN ' . $agent_cls->getTable() . ' AS a
                                       ON a.agent_id = u.agent_id
                                       INNER JOIN ' . $payment_store_cls->getTable() . ' AS p
                                       ON p.agent_id = u.agent_id
                                          AND p.property_id = ' . $property_id . '
                                       WHERE (p.bid = 1 OR p.offer = 1)
                                              AND p.is_paid > 0
                                       ORDER BY u.last_active DESC
                                       LIMIT ' . ($p - 1) * $len . ',' . $len, true);

        $total_row = $user_online_cls->getFoundRows();
        $data = array();
        if ($user_online_cls->hasError()) {
        } else if (is_array($rows) and count($rows) > 0) {
            $i = $len * ($p - 1) + 1;

            foreach ($rows as $row) {
                $dt = new DateTime($row['last_active']);
                $row['name'] = $row['firstname'] . ' ' . $row['lastname'];
                $row['ID'] = $i++;
                $row['last_active'] = $dt->format($config_cls->getKey('general_date_format')) . ' at ' . $dt->format('H:i:s');
                $row['info'] = Agent_getBidderInfo($row['agent_id'], false);
                $data[] = $row;
            }
            $pag_cls->setTotal($total_row)
                    ->setPerPage($len)
                    ->setCurPage($p)
                    ->setLenPage(10)
                    ->setLayout('ajax')
                    ->setUrl('')
                    ->setFnc('reloadLoggedInBid');
        }
        $smarty->assign('pagingLoggedInBid', $pag_cls->layout());
        $smarty->assign('logged_data', formUnescapes($data));
    }
    $reg_logged_row = $user_online_cls->getRow('SELECT count(login_id) AS count
                                                   FROM ' . $user_online_cls->getTable() . ' AS u
                                                   INNER JOIN ' . $payment_store_cls->getTable() . ' AS p
                                                   ON p.agent_id = u.agent_id
                                                      AND p.property_id = ' . $property_id . '
                                                   WHERE (p.bid = 1 OR p.offer = 1)
                                                          AND p.is_paid > 0', true);
    if (is_array($reg_logged_row) and count($reg_logged_row) > 0) {
        $smarty->assign('new_logged', $reg_logged_row['count']);
        return $reg_logged_row['count'];
    }
}

function __reportRegisterToBid($property_id, $p, $len, $isAgent, $need_detail = 1)
{
    global $agent_cls, $config_cls, $smarty, $payment_store_cls, $bid_cls, $pag_cls;

    if ($need_detail) {
        $bid_rows = $payment_store_cls->getRows(' SELECT SQL_CALC_FOUND_ROWS
                                                     pay.property_id,
                                                     pay.agent_id,
                                                     pay.creation_time,
                                                     pay.is_paid,
                                                     pay.is_disable,
                                                     pay.allow,
                                                     agt.firstname,
                                                     agt.lastname,
                                                     agt.agent_id AS Agent_id,
                                                     agt.email_address,
                                                     (SELECT count(bid.agent_id)
                                                            FROM ' . $bid_cls->getTable() . ' AS bid
                                                            WHERE bid.property_id = ' . $property_id . ' AND bid.agent_id = pay.agent_id
                                                            ) AS bid_number
                                                     FROM ' . $payment_store_cls->getTable() . ' AS pay,' . $agent_cls->getTable() . ' AS agt
                                            WHERE   pay.agent_id = agt.agent_id
                                                    AND pay.property_id = ' . $property_id . '
                                                    AND (pay.bid = 1 OR pay.offer = 1)
                                                    AND pay.is_paid > 0
                                            GROUP BY pay.agent_id
                                            ORDER BY pay.creation_time DESC
                                            LIMIT ' . ($p - 1) * $len . ',' . $len
            , true);
        $total_row = $payment_store_cls->getFoundRows();


        $rows = array();
        if ($payment_store_cls->hasError()) {
        } else if (is_array($bid_rows) and count($bid_rows) > 0) {
            $i = $len * ($p - 1) + 1;
            foreach ($bid_rows as $row) {
                $dt = new DateTime($row['creation_time']);
                if ($isAgent) {
                    $row['name'] = $row['firstname'] . ' ' . $row['lastname'];
                } else {
                    $row['name'] = getShortName($row['firstname'], $row['lastname']);
                }
                $status = $row['is_disable'] == 1 ? 'No' : 'Yes';
                $allow = $row['allow'] == 1 ? 'Yes' : 'No';
                $row['disable'] = '<a class="cancel-button" id="disable_' . $i . '" href="javascript:void(0)">' . $status . '</a>';
                $row['allow_str'] = '<a class="cancel-button" id="allow_' . $i . '" href="javascript:void(0)">' . $allow . '</a>';

                $rows[] = array('ID' => $i++,
                                'name' => $row['name'],
                                'email' => $row['email_address'],
                                'agent_id' => $row['agent_id'],
                                'bidNumber' => $row['bid_number'],
                                'info' => Agent_getBidderInfo($row['agent_id'], false),
                                'time' => $dt->format($config_cls->getKey('general_date_format')) . ' at ' . $dt->format('H:i:s'),
                                'disable' => $row['disable'],
                                'allow_str' => $row['allow_str'],
                                'is_disable' => $row['is_disable'],
                                'allow'=>$row['allow']);
            }
            $pag_cls->setTotal($total_row)
                    ->setPerPage($len)
                    ->setCurPage($p)
                    ->setLenPage(10)
                    ->setLayout('ajax')
                    ->setUrl('')
                    ->setFnc('reloadReportRegisterBid');
        }

        $smarty->assign('pagingRegtoBid', $pag_cls->layout());
        $smarty->assign('rows', formUnescapes($rows));

    }
    $reg_new_row = $payment_store_cls->getRow('SELECT max(id) AS max
                                                   FROM ' . $payment_store_cls->getTable() . '
                                                   WHERE property_id = ' . $property_id . '
                                                   AND (bid = 1 OR offer = 1)
                                                   AND is_paid > 0', true);
    if (is_array($reg_new_row) and count($reg_new_row) > 0) {
        $new_reg = $reg_new_row['max'];
    }
    $smarty->assign('new_reg', $new_reg);
    return $new_reg;
}
function __updateBidViewAction(){
    global $bid_cls, $agent_cls, $config_cls,$smarty, $pag_cls;
    $pagBid_cls = $pag_cls;
    $property_id = restrictArgs(getParam('property_id', 0));
    if ($property_id <= 0) return '';
    $p = (int)restrictArgs(getQuery('p', 1));
    $p = $p <= 0 ? 1 : $p;
    $len = 3;
    $sql =
    $bid_rows = $bid_cls->getRows('SELECT SQL_CALC_FOUND_ROWS
                                                bid.price,
                                                bid.in_room,
                                                bid.time,
                                                agt.firstname,
                                                agt.lastname,
                                                agt.agent_id as Agent_id,
                                                agt.email_address
                                        FROM ' . $bid_cls->getTable() . ' AS bid,' . $agent_cls->getTable() . ' AS agt
                                        WHERE bid.agent_id = agt.agent_id AND bid.property_id = ' . $property_id . '
                                        ORDER BY bid.price DESC
                                        LIMIT ' . ($p - 1) * $len . ',' . $len, true);

    $total_row = $bid_cls->getFoundRows();
    $actualBid_rows = array();
    if ($bid_cls->hasError()) {
    } else if (is_array($bid_rows) and count($bid_rows) > 0) {
        foreach ($bid_rows as $key => $row) {
            $row['name'] = getShortName($row['firstname'], $row['lastname']);
            if (Property_isVendorOfProperty($property_id)) {
                $row['name'] = $row['firstname'] . ' ' . $row['lastname'];
            }
            if (Property_isVendorOfProperty($property_id, $row['Agent_id'])) {
                $row['name'] = $row['in_room'] == 1 ? 'In Room Bid' : 'Vendor Bid';
            }
            $dt = new DateTime($row['time']);
            $actualBid_rows[] = array('name' => $row['name'],
                'price' => showPrice($row['price']),
                'agent_id' => $row['Agent_id'],
                'time' => $dt->format($config_cls->getKey('general_date_format')) . '. ' . $dt->format('h:i:s'));
        }
        $pagBid_cls->setTotal($total_row)
            ->setPerPage($len)
            ->setCurPage($p)
            ->setLenPage(10)
            ->setLayout('ajax')
            ->setUrl(ROOTURL.'/modules/general/action.php/?&action=updateBidViewAction&property_id=' . $property_id)
            ->setFnc('updateBidHistory');
        $smarty->assign('p', $p);
        $smarty->assign('len', $len);
        $smarty->assign('pagingBid', $pagBid_cls->layout());
    }
    $smarty->assign('actualBid_rows', formUnescapes($actualBid_rows));
    $smarty->assign('property_id', $property_id);
    $html = $smarty->fetch(ROOTPATH . '/modules/property/templates/property.view.detail.bidhistory.tpl');
    return $html;

}
function __registerBidHistoryAction()
{

    global $bid_cls, $agent_cls, $config_cls, $bids_first_cls, $smarty, $property_cls, $pag_cls, $property_history_cls, $payment_store_cls, $bids_stop_cls;
    $pagBid_cls = $pag_cls;
    $pagRegtoBid_cls = $pag_cls;
    $pagNoMore_cls = $pag_cls;
    $property_id = restrictArgs(getParam('property_id', 0));
    if ($property_id <= 0) return '';
    $p = (int)restrictArgs(getQuery('p', 1));
    $p = $p <= 0 ? 1 : $p;
    $p_reg2bid = $p_noMore = 1;
    $content = getParam('content', '');
    if ($content == 'reg2bid') {
        $p_reg2bid = $p;
    } else if ($content == 'noMore') {
        $p_noMore = $p;
    }

    $len = 20;
    $action = getParam('action');
    $isAgent = false;
    $vendor_id = 0;
    $pro_row = $property_cls->getCRow(array('agent_id','auction_sale'), 'property_id=' . $property_id);
    if (count($pro_row) > 0 AND is_array($pro_row)) {
        $vendor_id = $pro_row['agent_id'];
        //NH EDIT
        $isAgent = Property_isVendorOfProperty($property_id);
        $auctionSale = $pro_row['auction_sale'];
        $auction_sale_ar = PEO_getAuctionSale();
        $smarty->assign('auctionSaleCode',array_search($auctionSale, $auction_sale_ar));
    }
    $smarty->assign('isAgent', $isAgent);
    //BEGIN REGISTER TO BID
    /*$bid_rows = $bid_cls->getRows('SELECT SQL_CALC_FOUND_ROWS
                                             bid.*,
                                             agt.firstname,
                                             agt.lastname,
                                             agt.agent_id AS Agent_id,
                                             agt.email_address,
                                             (SELECT count(bid_.agent_id)
                                                     FROM '.$bid_cls->getTable().' AS bid_
                                                     WHERE bid_.property_id = '.$property_id.' AND bid_.agent_id = bid.agent_id
                                                     ) AS bid_number
                                     FROM '.$bid_cls->getTable('bids_first_payment').' AS bid,'.$agent_cls->getTable().' AS agt
                                     WHERE bid.agent_id = agt.agent_id AND bid.property_id = '.$property_id.' AND bid.pay_bid_first_status > 0
                                     ORDER BY bid.bid_first_time DESC
                                     LIMIT '.($p_reg2bid - 1)*$len.','.$len,true);*/
    $bid_rows = $payment_store_cls->getRows(' SELECT SQL_CALC_FOUND_ROWS
                                                     pay.property_id,
                                                     pay.agent_id,
                                                     pay.creation_time,
                                                     pay.is_paid,
                                                     pay.is_disable,
                                                     pay.allow,
                                                     agt.firstname,
                                                     agt.lastname,
                                                     agt.agent_id AS Agent_id,
                                                     agt.email_address,
                                                     (SELECT count(bid.agent_id)
                                                            FROM ' . $bid_cls->getTable() . ' AS bid
                                                            WHERE bid.property_id = ' . $property_id . ' AND bid.agent_id = pay.agent_id
                                                            ) AS bid_number
                                                     FROM ' . $payment_store_cls->getTable() . ' AS pay,' . $agent_cls->getTable() . ' AS agt
                                            WHERE   pay.agent_id = agt.agent_id
                                                    AND pay.property_id = ' . $property_id . '
                                                    AND (pay.bid = 1 OR pay.offer = 1)
                                                    AND pay.is_paid > 0
                                            GROUP BY pay.agent_id
                                            ORDER BY pay.creation_time DESC
                                            LIMIT ' . ($p_reg2bid - 1) * $len . ',' . $len
        , true);

    $total_row = $bid_cls->getFoundRows();

    $rows = array();
    if ($bid_cls->hasError()) {

    } else if (is_array($bid_rows) and count($bid_rows) > 0) {
        $i = $len * ($p_reg2bid - 1) + 1;
        foreach ($bid_rows as $key => $row) {
            //print_r($row);
            $dt = new DateTime($row['creation_time']);

            $row['name'] = $row['firstname'] . ' ' . $row['lastname'];
            if (!$isAgent) {
                $row['name'] = getShortName($row['firstname'], $row['lastname']);
            }


            $status = $row['is_disable'] == 1 ? 'No' : 'Yes';
            $allow = $row['allow'] == 1 ? 'Yes' : 'No';
            $row['disable'] = '<a class="cancel-button" id="disable_' . $i . '" href="javascript:void(0)">' . $status . '</a>';
            $row['allow_str'] = '<a class="cancel-button" id="allow_' . $i . '" href="javascript:void(0)">' . $allow . '</a>';
            
            $rows[] = array('name' => $row['name'],
                            'email' => $row['email_address'],
                            'agent_id' => $row['Agent_id'],
                            'bidNumber' => $row['bid_number'],
                            'time' => $dt->format($config_cls->getKey('general_date_format')) . ' at ' . $dt->format('h A'),
                            'disable' => $row['disable'],
                            'is_disable' => $row['is_disable'],
                            'allow'=>$row['allow'],
                            'allow_str'=>$row['allow_str'],
                            'ID' => $i++);
            //'time' => $row['bid_first_time']);

        }
        $total_row = count($bid_rows);
        $pagRegtoBid_cls->setTotal($total_row)
                ->setPerPage($len)
                ->setCurPage($p_reg2bid)
                ->setLenPage(10)
                ->setLayout('ajax')
                ->setUrl('/modules/general/action.php/?&action=registerToBid_history&content=reg2bid&property_id=' . $property_id)
                ->setFnc('pagingBid');

        $smarty->assign('p_reg2bid', $p_reg2bid);
        $smarty->assign('len', $len);
        $smarty->assign('pagingRegtoBid', $pagRegtoBid_cls->layout());
    }

    $smarty->assign('rows', formUnescapes($rows));
    //END

    $smarty->assign('property_id', $property_id);
    // BEGIN BID
    $bid_rows = $bid_cls->getRows('SELECT SQL_CALC_FOUND_ROWS
                                                bid.price,
                                                bid.in_room,
                                                bid.time,
                                                agt.firstname,
                                                agt.lastname,
                                                agt.agent_id as Agent_id,
                                                agt.email_address
                                        FROM ' . $bid_cls->getTable() . ' AS bid,' . $agent_cls->getTable() . ' AS agt
                                        WHERE bid.agent_id = agt.agent_id AND bid.property_id = ' . $property_id . '
                                        ORDER BY bid.price DESC
                                        LIMIT ' . ($p - 1) * $len . ',' . $len, true);

    $total_row = $bid_cls->getFoundRows();
    $actualBid_rows = array();
    $isVendor = Property_isVendor(0, $property_id);
    if ($bid_cls->hasError()) {

    } else if (is_array($bid_rows) and count($bid_rows) > 0) {
        foreach ($bid_rows as $key => $row) {

            $row['name'] = $row['firstname'] . ' ' . $row['lastname'];
            if (!$isAgent) {
                $row['name'] = getShortName($row['firstname'], $row['lastname']);
            }
            /*
                   if (Property_isMine($row['Agent_id'],$property_id)){
                       $row['name'] = ($row['in_room'] == 1) ? 'In Room Bid' : 'Vendor Bid';
                   }
                   */
            if (Property_isVendorOfProperty($property_id, $row['Agent_id'])) {
                $row['name'] = $row['in_room'] == 1 ? 'In Room Bid' : 'Vendor Bid';
            }

            $dt = new DateTime($row['time']);
            $actualBid_rows[] = array('name' => $row['name'],
                                      'price' => showPrice($row['price']),
                                      'agent_id' => $row['Agent_id'],
                                      'time' => $dt->format($config_cls->getKey('general_date_format')) . ' at ' . $dt->format('h A'));

        }
        $pagBid_cls->setTotal($total_row)
                ->setPerPage($len)
                ->setCurPage($p)
                ->setLenPage(10)
                ->setLayout('ajax')
                ->setUrl('/modules/general/action.php/?&action=registerToBid_history&property_id=' . $property_id)
                ->setFnc('pagingBid');

        $smarty->assign('p', $p);
        $smarty->assign('len', $len);
        $smarty->assign('pagingBid', $pagBid_cls->layout());
    }
    $smarty->assign('actualBid_rows', formUnescapes($actualBid_rows));
    // END
    // SWitch BID History
    $row_his = $property_history_cls->getRow('property_id=' . $property_id);
    $isSwitchBid = false;
    $link_switch_bid = ROOTURL;
    if (is_array($row_his) and count($row_his) > 0) {
        $view = '';
        $link_switch_bid = ROOTURL . '/?module=property&action=bid-history-full&property_id=' . $property_id . '&id=' . $row_his['property_transition_history_id'] . '&view=' . $view;
        $isSwitchBid = true;
    }
    $smarty->assign('isSwitchBid', $isSwitchBid);
    $smarty->assign('link_switch_bid', $link_switch_bid);
    //END

    //NO MORE BIDS TAB:NHUNG
    if ($_SESSION['agent']['type'] == 'theblock' || ($_SESSION['agent']['type'] == 'agent' && PE_isNormalAuction($property_id)) && $isAgent) {
        $rows = $bids_stop_cls->getRows('SELECT SQL_CALC_FOUND_ROWS a.firstname,
                                                                    a.lastname,
                                                                    a.email_address,
                                                                    b.*
                                        FROM ' . $agent_cls->getTable() . ' AS a
                                        LEFT JOIN ' . $bids_stop_cls->getTable() . ' AS b
                                        ON a.agent_id = b.agent_id
                                        WHERE b.property_id = ' . $property_id . '
                                        ORDER BY b.time DESC
                                        LIMIT ' . ($p_noMore - 1) * $len . ',' . $len, true);
        if (is_array($rows) and count($rows) > 0) {
            $data = array();
            foreach ($rows as $row) {
                if (!$isAgent) {
                    $row['name'] = getShortName($row['firstname'], $row['lastname']);
                }
                $dt = new DateTime($row['time']);
                $row['time'] = $dt->format($config_cls->getKey('general_date_format')) . ' at ' . $dt->format('h A');
                $data[] = $row;
            }
            $smarty->assign('no_more_bids_data', $data);
        }
        $smarty->assign('no_more_bids_data', $data);
        $pag_cls->setTotal($total_row)
                ->setPerPage($len)
                ->setCurPage($p_noMore)
                ->setLenPage(10)
                ->setLayout('ajax')
                ->setUrl('/modules/general/action.php/?&action=registerToBid_history&content=noMore&property_id=' . $property_id)
                ->setFnc('pagingBid');
        $smarty->assign('paging', $pagNoMore_cls->layout());
        $property = $property_cls->getRow('SELECT no_more_bid FROM ' . $property_cls->getTable() . ' WHERE property_id = ' . $property_id, true);
        $smarty->assign('no_more_bids_msg', $property['no_more_bid']);
        $smarty->assign('isAuction',PE_isNormalAuction($property_id));
    }
    //END
    $smarty->assign('action', $action);
    $smarty->assign('ROOTPATH', ROOTPATH);
    $smarty->assign('authentic', $_SESSION['agent']);

    if(detectBrowserMobile()){
        $rs = $smarty->fetch(ROOTPATH . '/modules/property/templates/mobile/property.registerbid.history.tpl');
    }else{
         $rs = $smarty->fetch(ROOTPATH . '/modules/property/templates/property.registerbid.history.tpl');
    }
    return $rs;
}

/**
function : __bidHistoryAction
 **/

function __registerBidHistoryBlockReportAction()
{
    global $bid_cls, $agent_cls, $config_cls, $smarty, $property_cls, $property_history_cls;
    $property_id = restrictArgs(getParam('property_id', 0));
    if ($property_id <= 0) return '';
    $p = 1;
    $len = 500;

    $bid_sql = 'SELECT     DISTINCT
                            bid.agent_id
                            FROM ' . $bid_cls->getTable() . ' AS bid
                            WHERE bid.property_id = ' . $property_id . '
                            ORDER BY bid.price DESC';
    $bid_rows = $bid_cls->getRows('SELECT SQL_CALC_FOUND_ROWS
											bid.*,
											agt.firstname,
											agt.lastname,
											agt.agent_id as Agent_id,
											agt.email_address,
											(SELECT count(bid_.agent_id)
											        FROM ' . $bid_cls->getTable() . ' AS bid_
                                                    WHERE bid_.property_id = ' . $property_id . ' AND bid_.agent_id = bid.agent_id
											        ) AS bid_number
									FROM ' . $bid_cls->getTable('bids_first_payment') . ' AS bid,' . $agent_cls->getTable() . ' AS agt
									WHERE   bid.agent_id = agt.agent_id
									        AND bid.property_id = ' . $property_id . '
									        AND bid.pay_bid_first_status > 0
									        AND bid.agent_id

									ORDER BY bid_number ASC
									LIMIT ' . ($p - 1) * $len . ',' . $len, true);

    $total_row = $bid_cls->getFoundRows();
    //print_r($bid_cls->sql);
    //die();
    $bid_payment = array();
    $IN_payment = '(';
    $rows = array();

    if ($bid_cls->hasError()) {

    } else if (is_array($bid_rows) and count($bid_rows) > 0) {
        foreach ($bid_rows as $key => $row) {
            $dt = new DateTime($row['bid_first_time']);
            $rows[] = array('name' => getShortName($row['firstname'], $row['lastname']),
                            'email' => $row['email_address'],
                            'agent_id' => $row['agent_id'],
                //'bidNumber' => Bid_getCountBidByPropertyIdAgentId($property_id,$row['Agent_id']),
                            'bidNumber' => $row['bid_number'],
                            'time' => $dt->format($config_cls->getKey('general_date_format')) . ' at ' . $dt->format('h A'));
            $bid_payment[] = $row['agent_id'];
            $id_ = $row['agent_id'];
            $IN_payment .= "'$id_',";
        }

        $IN_payment = str_replace(',)', ')', $IN_payment);

    }


    $smarty->assign('rows', formUnescapes($rows));
    $smarty->assign('action', 'registerToBid_blockReport');
    $smarty->assign('property_id', $property_id);
    if(detectBrowserMobile()){
        $rs = $smarty->fetch(ROOTPATH . '/modules/property/templates/mobile/property.registerbid.history.tpl');
    }else{
        $rs = $smarty->fetch(ROOTPATH . '/modules/property/templates/property.registerbid.history.tpl');
    }
    return $rs;
}

/**
function : __getStateAction()
 **/

function __getStateAction()
{
    global $region_cls;

    $jsons = array('error' => 0, 'data' => array());
    $country_id = restrictArgs(getParam('country_id', 0));
    //$options_state = array(0 => 'Select...');
    $options_state = array(0 => array('id' => 0, 'name' => 'Select...'));

    $state_rows = $region_cls->getStates($country_id);
    if ($region_cls->hasError()) {
        $message = $region_cls->getError();
        $jsons['error'] = 1;
    } else {
        if (is_array($state_rows) and count($state_rows) > 0) {
            foreach ($state_rows as $row) {
                //$options_state[$row['region_id']] = $row['name'];
                $options_state[] = array('id' => $row['region_id'], 'name' => $row['name']);
            }
        }

        $jsons['data'] = $options_state;
    }

    if ($_SERVER['REMOTE_ADDR'] == '113.161.8.145') {
        //print_r($jsons);
    }


    return $jsons;
}

function __setCountForTheBlock()
{
    global $property_cls, $bid_cls,$bids_stop_cls,$bids_first_cls;
    $step = getParam('step');
    $property_id = restrictArgs(getParam('property_id', 0));
    $text = '';
    $data = array();
    $type_msg = 'update-property';
    $result = array('error' => 1);
    if ($property_id > 0) {
        $row = $property_cls->getRow('SELECT no_more_bid,
                                             stop_bid,
                                             confirm_sold
                                      FROM ' . $property_cls->getTable() . ' WHERE property_id = ' . $property_id, true);
        switch ($step) {
            case 1:
                $text = 'Going Once';
                $data['no_more_bid'] = 0;
                break;
            case 2:
                $text = 'Going Twice';
                $data['no_more_bid'] = 0;
                break;
            case 3:
                $text = 'Third and Final Call';
                $data['no_more_bid'] = 0;
                break;
            case 'sold':
                $text = 'Sold';
                $data['confirm_sold'] = 1;
                $data['sold_time'] = date('Y-m-d H:i:s');
                $type_msg = 'sold';
                break;
            case 'reset':

                //$bid = $bid_cls->getRows('property_id = '.$property_id);
                //$text = (is_array($bid) and count($bid) > 0)?'Auction Live':'Looking For Opening Bid';

                //$text = $row['no_more_bid'] == 0 ? 'Auction Live' : 'No More Online Bids';


                $text = 'Auction Live';
                $data['no_more_bid'] = PE_isNoMoreBid($property_id)?1:0;
                break;
            case 'passedin':
                $text = 'Passed In';
                $data['stop_bid'] = 1;
                $data['stop_time'] = date('Y-m-d H:i:s');
                break;
            case 'pre_amble':
                $text = 'Auctioneer pre amble';
                $data['lock_bid'] = 1;
                $data['no_more_bid'] = 0;
                break;
            case 'start':
                $text = 'Auction Live';
                $data['lock_bid'] = 0;
                break;
            default:
                break;
        }
        if ($row['stop_bid'] == 0 and $row['confirm_sold'] == 0) {
            if (Property_isLockBid($property_id) && in_array($step,array(1,2,3,'reset','passedin'))){
                $result = array('error'=>1,'msg'=>'Sorry, this property is not ready. Please click Start Auction button for opening bid.');
            }else{
                $data['set_count'] = $text;
                $property_cls->update($data, 'property_id = ' . $property_id);
                if (!$property_cls->getError()) {
                    $result = array('success' => 1, 'property_id' => $property_id, 'step' => $step, 'property_id' => $property_id);
                }
            }
        }
    }
    // UPDATE NOTIFICATION TO ANDROID
    push(0, array('type_msg' => $type_msg));
    //push1(0, array('type_msg' => $type_msg));
    return die(json_encode($result));
}

function __loadTerm()
{
    global $config_cls, $smarty;
    $property_id = (int)restrictArgs(getParam('id', 0));
    $smarty->assign('term_title', $config_cls->getKey('term_title'));
    $smarty->assign('term', $config_cls->getKey('term_bid'));
    $smarty->assign('property_id', $property_id);
    die($smarty->fetch(ROOTPATH . '/modules/property/templates'.MOBILE_FOLDER.'popup.term.tpl'));
}

function __loadFormUpload(){
    global $config_cls, $smarty;
    $property_id = (int)restrictArgs(getParam('id', 0));
    $upload = array('title'=>$config_cls->getKey('termdoc_title'),
                    'message'=>$config_cls->getKey('termdoc_msg'),
                    'download_msg'=>$config_cls->getKey('termdoc_download_msg'),
                    'upload_msg'=>$config_cls->getKey('termdoc_upload_msg'),
                    'property_id'=>$property_id,
                    'download_file'=>DO_getTermDownload($property_id));
    $smarty->assign('is_ie', (int)isIE());
    $smarty->assign('upload',$upload);
    $smarty->assign('ROOTURL',ROOTURL);
    die($smarty->fetch(ROOTPATH . '/modules/property/templates/popup.upload.tpl'));
}

function __acceptTerm()
{
    global $bids_first_cls;
    $property_id = (int)restrictArgs(getParam('property_id', 0));
    $row = $bids_first_cls->getRow('SELECT * FROM ' . $bids_first_cls->getTable() . '
                                   WHERE agent_id = ' . $_SESSION['agent']['id'] . '
                                   AND pay_bid_first_status >= 0
                                   AND property_id = \'' . $property_id . '\'', true);
    if (is_array($row) and count($row) > 0) {
    } else {
        $bids_first_cls->insert(array('property_id' => $property_id,
                                     'agent_id' => $_SESSION['agent']['id'],
                                     'pay_bid_first_status' => 0,
                                     'bid_first_time' => date('Y-m-d H:i:s')));
        if (!$bids_first_cls->hasError()) {
            die(json_encode(array('redirect' => ROOTURL . '/?module=payment&action=option&type=bid&item_id=' . $property_id,
                                 'success' => 1)));
        }
    }
    die(json_encode(array('error' => 1)));
}

function __checkSubAction()
{
    global $agent_cls, $smarty;
    if (!isset($_SESSION['agent']) || $_SESSION['agent']['type'] != 'agent' || $_SESSION['agent']['parent_id'] > 0) {
        return (array('error' => 0));
    }
    $rows = $agent_cls->getCRows(array('agent_id', 'firstname', 'lastname', 'is_active'),
                                 'parent_id = ' . $_SESSION['agent']['id']);
    $package_arr = Agent_getCurrentPackage($_SESSION['agent']['id']);
    $data = array('error' => 0);
    /*if (is_array($package_arr) and count($package_arr) > 0) {
        $sub_account = 0;
        foreach ($rows as $row) {
            if ($row['is_active'] == 1) $sub_account++;
        }
        if ($package_arr['account_num'] > 0 and $sub_account > $package_arr['account_num']) {
            $data['error'] = 1;
            $smarty->assign('data', $rows);
            $smarty->assign('package_arr', $package_arr);
            $smarty->assign('at_least', $sub_account - $package_arr['account_num']);
            $data['data'] = $smarty->fetch(ROOTPATH . '/modules/property/templates/popup.checksub.tpl');
        }
    }*/
    return $data;
}

function __remindPaymentAction()
{
    global $smarty;
    $param = $_POST['psite'];
    $action = $param['action'];
    $module = $param['module'];
    switch ($module) {
        case 'payment':
            return (array('error' => 0));
            break;
        case 'property':
            if ($action == 'register') {
                $data['redirect'] = ROOTURL . '/?module=agent&action=view-dashboard';
            }
            break;
        case 'agent':
            if ($action == 'view-payment') {
                return (array('error' => 0));
            }
            break;
    }
    if ($_SESSION['agent']['type'] == 'agent') {
        $package = PA_getCurrentPackage($_SESSION['agent']['id']);
        if ($package != null || (int)$package == 0) {
            return (array('error' => 0));
        } else {
            if ($_SESSION['agent']['rlater'] && !isset($data['redirect'])) {
                return (array('error' => 0));
            }
            $data['error'] = 1;
            $smarty->assign('package_tpl', PK_getPackageRegisterTpl('table'));
            $package_time = array('1' => count($package) == 0 ? 'Current month' : 'Next month',
                                  '3' => 'Next 3 months',
                                  '12' => 'Next 12 months');
            $smarty->assign('package_time', $package_time);
            $smarty->assign('authentic', $_SESSION['agent']);
            $data['parent_id'] = $_SESSION['agent']['parent_id'];
            $data['data'] = $smarty->fetch(ROOTPATH . '/modules/agent/templates/popup.payment.tpl');
            return ($data);
        }
    }

}

function __changeStatusAction()
{
    global $agent_cls;
    $ids = getParam('ids');
    if (!isset($_SESSION['agent'])) {
        redirect(ROOTURL);
    }
    if ($ids != 'null') { //yourself change
        $id_arr = explode(',', $ids);
        foreach ($id_arr as $id) {
            $row = $agent_cls->getCRow(array('is_active'), 'agent_id = ' . (int)$id);
            if (is_array($row) and count($row) > 0) {
                $agent_cls->update(array('is_active' => 1 - $row['is_active']), 'agent_id = ' . (int)$id);
            }
        }
    } else { //auto inactive account
        $min = (int)restrictArgs(getParam('min', 0));
        $rows = $agent_cls->getRows('SELECT agent_id, is_active
                                     FROM ' . $agent_cls->getTable() . '
                                     WHERE parent_id = ' . $_SESSION['agent']['id'] . ' AND is_active = 1
                                     ORDER BY agent_id DESC
                                     LIMIT 0,' . $min, true);
        if (is_array($rows) and count($rows) > 0) {
            foreach ($rows as $row) {
                $agent_cls->update(array('is_active' => 1 - $row['is_active']), 'agent_id = ' . (int)$row['agent_id']);
            }
        }
    }

    if ($agent_cls->hasError()) {
        die(json_encode(array('error' => 1)));
    }
    die(json_encode(array('success' => 1)));
}

function __agentPaymentAction()
{
    global $agent_payment_cls, $payment_store_cls;
    $param = $_POST['param'];
    $package_id = (int)$param['package_id'];
    $package_arr = PK_getPackage($package_id);
    $time = (int)$param['time'] > 0 ? (int)$param['time'] : 1;

    if ($_SESSION['agent']['id'] > 0) {
        if ($package_arr['price'] == 0) {
            $payment_arr = $agent_payment_cls->getRow("SELECT agent_id, date_to
                                                        FROM " . $agent_payment_cls->getTable() . "
                                                        WHERE payment_id
                                                                    IN (
                                                                    SELECT MAX(payment_id)
                                                                    FROM " . $agent_payment_cls->getTable() . "
                                                                    GROUP BY agent_id
                                                                    )
                                                              AND agent_id = {$_SESSION['agent']['id']}", true);
            $current_date = new DateTime(date('Y-m-d'));
            if (is_array($payment_arr) and count($payment_arr) > 0) {
                $last_date = new DateTime($payment_arr['date_to']);
            } else {
                $last_date = new DateTime('0000-00-00');
            }
            $date_from = $current_date < $last_date ? date('Y-m-d H:i:s', strtotime($payment_arr['date_to']))
                    : date('Y-m-d H:i:s');
            $agent_payment_cls->insert(array('store_id' => 0,
                                            'creation_date' => date('Y-m-d H:i:s'),
                                            'package_id' => $package_id,
                                            'agent_id' => $_SESSION['agent']['id'],
                                            'date_from' => $date_from,
                                            'date_to' => date('Y-m-d H:i:s', strtotime($date_from . " +{$time} month"))));
        } else {
            $item_number = $payment_store_cls->_insert(array('package_id' => $package_id,
                                                            'package_price' => $package_arr['price'],
                                                            'agent_id' => $_SESSION['agent']['id'],
                                                            'amount' => $package_arr['price'] * $time));
            die(json_encode(array('success' => 1, 'redirect' => ROOTURL . '?module=payment&action=option&type=agent&item_id=' . $item_number)));
        }
    } else {
        die(json_encode(array('error' => 1, 'msg' => 'Please login to payment. Thanks you !')));
    }
    die(json_encode(array('success' => 1)));
}

function __transferTemplateFunction()
{
    global $smarty;
    $property_id = restrictArgs(getParam('property_id', 0));
    $template = getParam('tpl');
    $smarty->assign('template', $template);
    $smarty->assign('authentic', $_SESSION['agent']);
    $row = Property_getDetail($property_id);
    $data = $smarty->fetch(ROOTPATH . '/modules/property/templates/property.box.tpl');
    die(json_encode(array('html' => $data, 'reg' => $row['info']['register_bid'], 'vendor' => $row['is_mine'])));
}

function __proposeRequire()
{
    global $property_cls;
    $amount = restrictArgs(getParam('amount', 0));
    $property_id = restrictArgs(getParam('property_id', 0));
    $from_id = restrictArgs(getParam('from_id', 0));

    PI_update(array('property_id' => $property_id, 'from_id' => $from_id, 'amount' => $amount, 'type_approved' => 0));
    $rs = array('success' => 1, 'from_id' => $from_id, 'property_id' => $property_id);

    // UPDATE NOTIFICATION TO ANDROID
    //push(PE_getManager($property_id), array('type_msg' => 'require-propose'));
    push(0, array('type_msg' => 'require-propose'));
    //push1(0, array('type_msg' => 'require-propose'));
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

            if ($type_approved == 1 || $type_approved == 2) { // ACCEPT
                // UPDATE NOTIFICATION TO ANDROID
                //push($to_id, array('type_msg' => 'accept-propose'));
              //  push(0, array('type_msg' => 'accept-propose'));
                pushWithoutUserId($to_id, array('type_msg' => 'accept-propose', 'is_refuse'=>$type_approved==2?1:0));
                //push1(0, array('type_msg' => 'accept-propose'));
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

function __winFinish()
{
    global $bid_cls;
    $property_id = restrictArgs(getParam('property_id', 0));
    $agent_id = restrictArgs(getParam('agent_id', 0));
    $price = restrictArgs(getParam('price', 0));
    $bid_cls->update(array('type_approved' => 1), 'property_id = ' . $property_id . ' AND agent_id = ' . $agent_id . ' AND price = ' . $price);
    $rs = array('success' => 1);
    return $rs;
}

function __uploadTerm(){
    include_once ROOTPATH . '/utils/ajax-upload/server/php.php';

    if (!(isset($_SESSION['agent']) && $_SESSION['agent']['id'] > 0)){
        die(_response(array('error' => 'No permission.')));
    }
    $path = ROOTPATH.'/store/uploads/' . @$_SESSION['agent']['id'].'/';
    ini_set('max_input_time', 300);
    ini_set('max_execution_time', 300);
    createFolder($path, 2);

    //BEGIN SETTING FOR UPLOADER
    $allowedExtensions = array('pdf', 'png', 'jpg','doc');
    // max file size in bytes
    $sizeLimit = 10 * 1024 * 1024 * 1024;
    $isCheckSetting = false;
    $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, $isCheckSetting);
    $result = $uploader->handleUpload($path);

    $property_document_id = 0;
    if (isset($result['success'])) {
        $result['nextAction'] = array();
        $result['nextAction']['method'] = 'showDoc';
        $result['nextAction']['args'] = array();
        $_SESSION['upload']['term'] = array('path'=>$path.$result['filename'],
                                            'filename'=>$result['filename']);
    }
    die(_response($result));
}

function __sendTerm(){
    global $config_cls;
    print_r($_SESSION['upload']['term']);
    if (isset($_SESSION['upload']['term']) && is_array($_SESSION['upload']['term']) && count($_SESSION['upload']['term']) > 0){
        $property_id = getParam('pid',0);
        //IBB-1572: Email the agent (listed property owner/manager) when users register to bid on their property
        $agentInfo = A_getAgentManageInfo($property_id);
        $msg = $config_cls->getKey('email_agent_register_bid_msg');
        $link = ROOTURL . '/?module=property&action=view-auction-detail&id=' . $property_id;
        $link = '<a href="' . $link . '">' . $link . '</a> ';
        $subject = $config_cls->getKey('email_agent_register_bid_subject');
        $msg = str_replace(array('[agent_name]', '[ID]', '[link]', '[rooturl]'), array($agentInfo['full_name'], $property_id, $link, ROOTURL), $msg);
        $result = sendEmail_attach($config_cls->getKey('general_contact_email'), 'devtesting04@gmail.com', $msg, $subject, '',$_SESSION['upload']['term']);

        if ($result == 'send'){
            die(json_encode(array('success'=>1)));
        }else{
            die(json_encode(array('error'=>1,'msg'=>$result)));
        }
    }

}

/*
function push1($issuer_id = 0, $data = array())
{
    global $notification_app_cls;
   
    $reg_ids1 = $notification_app_cls->getRegIDs($issuer_id, Notification_app::IPHONE);
    if ($reg_ids1 != null && count($reg_ids1) > 0) {
        $data['issuer_id'] = '';
        push_IPhone($reg_ids1, $data);
    }
}
function push_IPhone($registrationIDs = array(), $data = array())
{
  $passphrase = '123456';
  $ctx = stream_context_create();
  stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
  stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

  // Open a connection to the APNS server
	$fpstream = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
	//if (!$fp)
	// Encode the payload as JSON
	$payload = json_encode($data);
		foreach ($registrationIDs as $regId) { 
            	// Build the binary notification
            	$deviceToken = utf8_encode($regId);
				$msg = chr (0) . chr (0) . chr (32) . pack ('H*', $deviceToken) . pack ('n', strlen ($payload)) . $payload;
				// Send it to the server
				$result = fwrite($fpstream, $msg, strlen($msg));
        }
   fclose($fp); 
}
*/

?>