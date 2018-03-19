<?php
//session_start();
require '../../configs/config.inc.php';
require ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
include_once ROOTPATH.'/includes/pagging.class.php';
//include 'lang/agent.en.lang.php';
include_once ROOTPATH.'/modules/configuration/inc/config.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/term/inc/bid_term.class.php';

ini_set('display_errors', 1);
if (!isset($bid_term_cls) || !($bid_term_cls instanceof Bids_term)) {
        $bid_term_cls = new Bids_term();
}
$action = getParam('action');

switch ($action){
    case 'checkTerm':
        $property_id = restrictArgs(getPost('property',0));
        $bidder_id =  restrictArgs(getPost('bidder',0));
        $agentInfo = A_getAgentManageInfo($property_id);
        if(isset($agentInfo['agent_id']) && $agentInfo['agent_id'] > 0)
        $registered = $bid_term_cls->isExist($bidder_id,$agentInfo['agent_id']);
        if (isset($registered) && $registered){
            $result['registered'] = 1;
        }else{
            $result['link'] = ROOTURL.'?module=term&action=view&pid='.$property_id;
        }
        die(json_encode($result));
        break;

    case 'confirmEdit':
        $result = array();
        $property_id = restrictArgs(getPost('property',0));
        $bidder_id =  restrictArgs(getPost('bidder',0));
        $agentInfo = A_getAgentManageInfo($property_id);
        if(isset($agentInfo['agent_id']) && $agentInfo['agent_id'] > 0)
        $parent = A_getAgentParentInfo($agentInfo['agent_id']);
        if(isset($parent['agent_id']) && $parent['agent_id'] > 0)
        $row = $bid_term_cls->getRow('bidder_id = '.$bidder_id.' AND company_id = '.$parent['agent_id']);
        if(isset($row) && is_array($row) and count($row) > 0){
            $bid_term_cls->update(array('status'=>0),'bidder_id = '.$bidder_id.' AND company_id = '.$parent['agent_id']);
            if ($bid_term_cls->hasError()){
                $result['error'] = 1;
                $result['msg'] = $bid_term_cls->getError();
            }else{
                $result['success'] = 1;
                $result['link'] = ROOTURL.'?module=term&action=view&pid='.$property_id;
            }
        }
        die(json_encode($result));
        break;
}
?>