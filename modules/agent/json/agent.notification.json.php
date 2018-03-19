<?php
require '../../../configs/config.inc.php';
require ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
$module = 'agent';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/agent/inc/partner.php';

$ar = array('notify_email','notify_email_bid','notify_sms','notify_turnon_sms','subscribe','allow_twitter','allow_facebook','allow_lawyer');
$ar_2 = array('contact_references');
        if($_SERVER['REQUEST_METHOD']=='GET'){
	/*
	$requests['notify_email'] = isset($_GET['notify_email'])?1:0;
	$requests['notify_sms'] = isset($_GET['notify_sms'])?1:0;
	$requests['notify_turnon_sms'] = isset($_GET['notify_turnon_sms'])?1:0;
	*/
	$requests = array();
    foreach ($_GET as $k=>$val){
        if ($k != '_'){
            $param = $k;
        }
    }
    if (in_array($param,$ar_2)){
        foreach ($ar_2 as $val){
            if (isset($_GET[$val])){
                $requests[$val] = $_GET[$val];
            }
        }
        $partner_cls->update($requests,'agent_id = '.$_SESSION['agent']['id']);
        if($partner_cls->hasError()){
            $message['result'] = false;
            $message['msg'] = $partner_cls->getError();
        }else{
            $message['result'] = true;
            $message['msg']  = 'Updated Successfully.';
        }
    }else{
        foreach ($ar as $val) {
            if (isset($_GET[$val])) {
                $requests[$val] = $_GET[$val];
            }
        }
        $agent_cls->update($requests,'agent_id='.$_SESSION['agent']['id']);
        if($agent_cls->hasError()){
            $message['result'] = false;
            $message['msg'] = $agent_cls->getError();
        }else{
            $message['result'] = true;
            $message['msg']  = 'Updated Successfully.';
        }
    }

}

print(json_encode($message));

?>