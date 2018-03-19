<?php

include_once ROOTPATH.'/modules/general/inc/bids_mailer.php';
include_once ROOTPATH.'/modules/general/inc/property_history.php';
include_once ROOTPATH.'/modules/cms/inc/cms.php';
include_once ROOTPATH.'/includes/pagging.class.php';
include_once ROOTPATH.'/modules/payment/inc/payment_store.class.php';
include_once ROOTPATH.'/modules/general/inc/bids_stop.class.php';
include_once ROOTPATH.'/modules/general/inc/bids_first.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';

include_once ROOTPATH.'/modules/general/inc/propose_increment.php';

include_once ROOTPATH.'/modules/general/inc/user_online.php';

session_start();

$action = getParam('action');
switch ($action) {
	case 'status':
		include_once 'inc/status.property.php';
		break;
	case 'login':
		include_once 'inc/agent.login.php';
		break;
	case 'my-property-details':
		loginPost();
		include_once 'inc/my.property.details.php';
		break;	
	case 'view-property-bids-detail':
			loginPost();
			include_once 'inc/view.property.bids.detail.php';
			break;
	case 'view-property-bids':
		loginPost();
		include_once 'inc/view.property.bids.php';
		break;
    case 'view-property-bids-dev':
		loginPost();
		include_once 'inc/view.property.bids.dev.php';
		break;
	case 'view-property-detail':
		loginPost();
		include_once 'inc/view.property.detail.php';
		break;
	case 'view-property-bidder':
			loginPost();
			include_once 'inc/view.property.bidder.php';
		break;
	case 'view-property-photo':
			loginPost();
			include_once 'inc/view.property.photo.php';
			break;
	case 'bid':
		loginPost();
		include_once 'inc/bid.php';
		break;
	case 'on-bid':
		loginPost();
		include_once 'inc/on.bid.php';
		break;
	case 'loadReportBid':
		loginPost();
		include_once 'inc/report.bid.php';
		break;
	case 'loadReportNoMoreBid':
		loginPost();
		include_once 'inc/report.no.more.bid.php';
		break;
	case 'loadReportRegisterBid':
		loginPost();
		include_once 'inc/report.register.to.bid.php';
		break;
	case 'loadLoggedInBid':
		loginPost();
		include_once 'inc/report.logged.in.bid.php';
		break;
	case 'no-more-bids':
		loginPost();
		$property_id = restrictArgs(getParam('property_id',0));
		$row = $bids_stop_cls->getRow('SELECT stop_id
				FROM '.$bids_stop_cls->getTable().'
				WHERE property_id = '.$property_id.' AND agent_id = '.$_SESSION['agent']['id'],true);
		if (is_array($row) and count($row) > 0){
		}else{
			$bids_stop_cls->insert(array('property_id'=>$property_id,
					'agent_id'=>$_SESSION['agent']['id'],
					'time'=>date('Y-m-d H:i:s')));
			if (!$bids_stop_cls->hasError()){
				$payment_store_cls->update(array('is_disable'=>1),'property_id = '.$property_id.'
						AND agent_id = '.$_SESSION['agent']['id'].'
						AND (bid = 1 OR offer = 1)');
				$stop = $bids_stop_cls->getRow('SELECT count(agent_id) AS count FROM '.$bids_stop_cls->getTable().' WHERE property_id ='.$property_id,true);
				$registered = $bids_first_cls->getRow('SELECT count(agent_id) AS count FROM '.$bids_first_cls->getTable().' WHERE property_id = '.$property_id .' AND pay_bid_first_status > 0',true);
	
				$count_stop = (is_array($stop) && count($stop > 0))?$stop['count']:0;
				$count_registered = (is_array($registered) && count($registered > 0))?$registered['count']:0;
	
				if ($count_registered > 0 && $count_stop == $count_registered){
					$property_cls->update(array('no_more_bid'=>1),
							'property_id = '.$property_id);
					//$property_cls->update(array('set_count'=>'No More Online Bids'),'property_id = '.$property_id);
				}
				die(json_encode(array('success'=>1)));
			}
		}
		die(json_encode(array('error'=>1)));
		break;
	case 'setCount':
		loginPost();
		include_once 'inc/setCount.php';
		break;
	case 'changeStatus':
		loginPost();
		include_once 'inc/changeStatus.php';
		break;
	case 'bid_history':
		loginPost();
		include_once ROOTPATH.'/modules/general/inc/bids.php';
		include_once ROOTPATH.'/modules/agent/inc/agent.php';
		include_once ROOTPATH.'/modules/property/inc/property.php';
		die(json_encode(__bidHistoryAction()));
		break;
	case 'set-incre':
		loginPost();
		include_once 'inc/setIncre.php';
		break;
	case 'my-reg-to-bids':
		loginPost();
		include_once 'inc/my_reg_to_bids.php';
		break;

	case 'propose_require':
		loginPost();
		include_once ROOTPATH.'/modules/property/inc/property.php';
		include_once ROOTPATH.'/modules/general/inc/propose_increment.php';
	
		die(json_encode(__proposeRequire()));
		break;
		case 'propose_accept':
			loginPost();
			die(json_encode(__proposeAccept()));
			break;
		case 'propose_refuse':
			loginPost();
			die(json_encode(__proposeRefuse()));
			break;
		case 'propose_finish':
			loginPost();
			die(json_encode(__proposeFinish()));
			break;
		case 'propose_request':
			loginPost();
			$row=array();
			$property_id = restrictArgs(getParam('property_id', 0));
			if (in_array($_SESSION['agent']['id'] , Property_getOwner($property_id))) {
				$row=$propose_increment_cls->getCRow(array('property_id', 'amount','from_id','type_approved'), 'property_id = '.$property_id.' AND type_approved = 0');
				if(is_array($row)&& count($row)>0)
				{
					$agent_row = $agent_cls->getRow("SELECT * FROM ".$agent_cls->getTable('agent')." WHERE agent_id = ".$row['from_id'],true);
					$row['agent_name']=substr($agent_row['firstname'],0,1).'.'.substr($agent_row['lastname'],0,2);
				}else
					$row=array();
				
			}
			die(json_encode($row));
		break;
		case 'propose_done':
			loginPost();
			$row = array();
			$property_id = restrictArgs(getParam('property_id', 0));
			//$row = $propose_increment_cls->getCRow(array('property_id', 'amount', 'from_id', 'type_approved'), 'property_id = ' . $property_id . ' AND type_approved = 3');
			$row = $propose_increment_cls->getCRow(array('property_id', 'amount', 'from_id', 'type_approved'), 'property_id = ' . $property_id . ' AND (type_approved = 1 OR type_approved = 2)');
		
			die(json_encode($row));
			break;
    case 'view-detail':
        loginPost();
        include_once 'inc/property.detail.php';
        break;
	/*
	 * 
	 *  case 'propose_require':
        loginPost();
        include_once ROOTPATH . '/modules/property/inc/property.php';
        include_once ROOTPATH . '/modules/general/inc/propose_increment.php';
        die(json_encode(__proposeRequire()));
        break;
    case 'propose_accept':
        loginPost();
        die(json_encode(__proposeAccept()));
        break;
    case 'propose_refuse':
        loginPost();
        die(json_encode(__proposeRefuse()));
        break;
    case 'propose_finish':
        loginPost();
        die(json_encode(__proposeFinish()));
        break;
    case 'propose_request':
        loginPost();
        $row = array();
        $property_id = restrictArgs(getParam('property_id', 0));
        if (in_array($_SESSION['agent']['id'], Property_getOwner($property_id))) {
            $row = $propose_increment_cls->getCRow(array('property_id', 'amount', 'from_id', 'type_approved'), 'property_id = ' . $property_id . ' AND type_approved = 0');
            $agent_row = $agent_cls->getRow("SELECT * FROM " . $agent_cls->getTable('agent') . " WHERE agent_id = " . $row['from_id'], true);
            $row['agent_name'] = substr($agent_row['firstname'], 0, 1) . '.' . substr($agent_row['lastname'], 0, 2);
        }

        die(json_encode($row));
        break;
    case 'propose_done':
        	loginPost();
        	$row = array();
        	$property_id = restrictArgs(getParam('property_id', 0));
        	if (in_array($_SESSION['agent']['id'], Property_getOwner($property_id))) {
        		$row = $propose_increment_cls->getCRow(array('property_id', 'amount', 'from_id', 'type_approved'), 'property_id = ' . $property_id . ' AND type_approved = 1');
        		$agent_row = $agent_cls->getRow("SELECT * FROM " . $agent_cls->getTable('agent') . " WHERE agent_id = " . $row['from_id'], true);
        		$row['agent_name'] = substr($agent_row['firstname'], 0, 1) . '.' . substr($agent_row['lastname'], 0, 2);
        	}
        
        	die(json_encode($row));
        	break;
	 */
}
function __proposeRequire() {
	global $property_cls;
	$amount = restrictArgs(getParam('amount', 0));
	$property_id = restrictArgs(getParam('property_id', 0));
	$from_id = restrictArgs(getParam('from_id', 0));

	PI_update(array('property_id' => $property_id, 'from_id' => $from_id, 'amount' => $amount, 'type_approved' => 0));
	$rs = array('success' => 1, 'from_id' => $from_id, 'property_id' => $property_id);
	return $rs;
}
function __proposeAcceptRefuse($type_approved = 0) {
	global $property_cls, $propose_increment_cls,$agent_cls;
	$property_id = restrictArgs(getParam('property_id', 0));
	// notice, we have reverve from_id and to_id
	$from_id = restrictArgs(getParam('from_id', 0));
	$to_id = restrictArgs(getParam('to_id', 0));

	$rs = array('success' => 0);
	if (in_array($from_id , Property_getOwner($property_id))) {
		$row = $propose_increment_cls->getCRow(array('property_id', 'amount'), 'property_id = '.$property_id.' AND from_id = '.$to_id);
		if (isset($row['property_id'])) {
			$propose_increment_cls->update(array('type_approved' => $type_approved), 'property_id = '.$property_id.' AND from_id = '.$to_id);
			$rs = array('success' => 1, 'from_id' => $from_id, 'property_id' => $property_id, 'amount' => $row['amount']);
            if($type_approved == 1){
                // Update Inc
                $str = $_SESSION['agent']['parent_id'] == 0 ? ' (agent_id IN (SELECT agent_id
                                                              FROM '.$agent_cls->getTable().'
                                                              WHERE parent_id = '.$_SESSION['agent']['id'].')
                                                   OR agent_id = '.$_SESSION['agent']['id'].')'
                    :
                    " IF(ISNULL(agent_manager) || agent_manager = ''
												   ,agent_id ={$_SESSION['agent']['id']}
												   ,agent_manager = {$_SESSION['agent']['id']})";

                $p_row = $property_cls->getRow('SELECT property_id,min_increment,max_increment
                                  FROM '.$property_cls->getTable()."
                                  WHERE {$str}
                                        AND property_id = {$property_id}"
                ,true);
                if (is_array($p_row) and count($p_row) > 0){
                   if((int)$row['amount'] > (int)$p_row['max_increment'] and (int)$p_row['max_increment'] > 0){
                       $max = $row['amount'];
                       $property_cls->update(array('max_increment' => $max),
                           'property_id = '.$property_id);
                   }else{
                       $min = $row['amount'];
                       $property_cls->update(array('min_increment' => $min),
                           'property_id = '.$property_id);
                   }
                }

            }
		}
	}
	return $rs;
}

function __proposeAccept() {
	return __proposeAcceptRefuse(1);
}

function __proposeRefuse() {
	return __proposeAcceptRefuse(2);
}

function __proposeFinish() {
	global $property_cls, $propose_increment_cls;
	$property_id = restrictArgs(getParam('property_id', 0));
	$from_id = restrictArgs(getParam('from_id', 0));
	$row = $propose_increment_cls->getCRow(array('property_id',), 'property_id = '.$property_id.' AND from_id = '.$from_id);
	$rs = array('success' => 0);
	if (isset($row['property_id'])) {
		$propose_increment_cls->update(array('type_approved' => 3), 'property_id = '.$property_id.' AND from_id = '.$from_id);
		//$propose_increment_cls->delete('property_id = '.$property_id.' AND from_id = '.$from_id.' AND to_id = '.$to_id);
		$rs = array('success' => 1, 'from_id' => $from_id, 'property_id' => $property_id);
	}
	return $rs;
}
function loginPost(){
	include_once ROOTPATH.'/modules/facebook-twitter/inc/twitter_detail.class.php';
	include_once ROOTPATH.'/modules/facebook-twitter/inc/fb.fb_detail.class.php';
	Global $agent_cls;
	if (isset($_GET['username']) and isset($_GET['password']) ) {
		$email = $_GET['username'];
		$password = encrypt($_GET['password']);
	
		$row = $agent_cls->getRow("email_address='".$agent_cls->escape($email)."' AND password='".$agent_cls->escape($password)."'");
		if (is_array($row) and count($row)>0) {
			if ($row['is_active'] == 0 ) {
				die(json_encode(array('error' => 'Your account is not activated yet.')));
			} else {
				$type_row = $agent_cls->getRow("SELECT * FROM ".$agent_cls->getTable('agent_type')." WHERE agent_type_id = ".$row['type_id'],true);
					
				$type = 'buyer';
				if (is_array($type_row) and count($type_row)>0) {
					$type = $type_row['title'];
				}
					
				$fn = $row['firstname'].' '.$row['lastname'];
				$len = 60;
				$_SESSION['agent'] = array('id' => $row['agent_id'],
						'agent_id' => $row['agent_id'],
						'3x_id' => $row['agent_id'],
						'full_name' => strlen($fn) > $len ? safecontent($fn, $len).'...' : $fn,
						'firstname' => $row['firstname'],
						'lastname' => $row['lastname'],
						'email_address' => $row['email_address'],
						'auction_step' => $row['auction_step'],
						'maximum_bid' => $row['maximum_bid'],
						'type' => $type,
						'type_id' => $row['type_id'],
						'login' => true,
						'parent_id'=>$row['parent_id']);

				//GET INFORMATION TWITTER
				if (TD_getInfo($row['provider_id']) != null){
					$_SESSION['tw_info'] = TD_getInfo($row['provider_id']);
				}
					
				//GET INFROMATION FACEBOOK
				if (FD_getInfoID($row['agent_id']) != null){
					$_SESSION['fb_info'] = FD_getInfoID($row['agent_id']);
				}
					
			}
		}
	
	}
}
die(json_encode(array('error' => 'go away!')));
?>