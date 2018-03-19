<?php
include 'partner.php';
include_once 'company.php';
// Call Constructor init();
if (!isset($partner_cls) || !($partner_cls instanceof PartnerRegister)) {
    $partner_cls = new PartnerRegister();
}

if (!isset($_SESSION['new_agent']['id']) or  $_SESSION['new_agent']['id'] < 1) {
    redirect(ROOTURL.'?module='.$module.'&action='.$action);
}

$message = '';
$form_action = '?module='.$module.'&action='.$action.'&step='.$step;

if (@$_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($step < $max_step){
        $_SESSION['new_agent']['step'] = $step + 1;
        redirect(ROOTURL.'?module='.$module.'&action='.$action.'&step='.($step + 1));
    }else{
        redirect(ROOTURL.'?module=agent&action=finish-register');
    }
} else {//GET for reviewing


    $agent_cls = new Agent();
    $agent_lawyer_cls = new Agent_lawyer();
    $agent_contact_cls = new Agent_contact();
    $agent_creditcard_cls = new Agent_creditcard();

    $agent_row = $agent_cls->getRow('SELECT a.*,
						(SELECT rg1.code FROM '.$agent_cls->getTable('regions').' AS rg1 WHERE rg1.region_id = a.state) AS state_name,
						(SELECT rg2.name FROM '.$agent_cls->getTable('regions').' AS rg2 WHERE rg2.region_id = a.country) AS country_name
						FROM '.$agent_cls->getTable('agent').' AS a WHERE a.agent_id = '.$_SESSION['new_agent']['id'],true);
    //$agent_row = $agent->getRow('agent_id='.$agent_id);
    if ($agent_cls->hasError()) {
        $message = $agent_cls->getError();
    } else {
        if($agent_row['country'] != 1)
        {
            $agent_row['state_name'] = $agent_row['other_state'];
        }
        $smarty->assign('agent_row',$agent_row);
    }

    $agent_lawyer_row = $agent_cls->getRow('SELECT al.*,
						(SELECT rg1.code FROM '.$agent_cls->getTable('regions').' AS rg1 WHERE rg1.region_id = al.state) AS state_name,
						(SELECT rg2.name FROM '.$agent_cls->getTable('regions').' AS rg2 WHERE rg2.region_id = al.country) AS country_name
						FROM '.$agent_cls->getTable('agent_lawyer').' AS al WHERE al.agent_id = '.$_SESSION['new_agent']['id'],true);

    //$agent_lawyer_row = $agent_lawyer->getRow('agent_id='.$agent_id);
    if ($agent_lawyer_cls->hasError()) {
        $message = $agent_lawyer_cls->getError();
    } else {
        $smarty->assign('agent_lawyer_row',$agent_lawyer_row);
    }

    //contact
    $agent_contact_row = $agent_cls->getRow('SELECT al.*,
						(SELECT rg1.code FROM '.$agent_cls->getTable('regions').' AS rg1 WHERE rg1.region_id = al.state) AS state_name,
						(SELECT rg2.name FROM '.$agent_cls->getTable('regions').' AS rg2 WHERE rg2.region_id = al.country) AS country_name
						FROM '.$agent_cls->getTable('agent_contact').' AS al WHERE al.agent_id = '.$_SESSION['new_agent']['id'],true);

    if ($agent_contact_cls->hasError()) {
        $message = $agent_contact_cls->getError();
    } else {
        if(count($agent_contact_row) > 0 and is_array($agent_contact_row))
        {
            if($agent_contact_row['country'] != 1)
            {
                $agent_contact_row['state_name'] = $agent_contact_row['other_state'];

            }
            $smarty->assign('agent_contact_row',$agent_contact_row);
        }
        else{
            if($_SESSION['new_agent']['agent']['auto_update_contact'] == 1)
            {
                $smarty->assign('agent_contact_row',$agent_contact_row);
            }
        }
    }

    // DUC CODING SHOW INFORMATION COMPANY INFOR
    $partner_row = $partner_cls->getRow('SELECT p.*,
                                         (SELECT rg1.code FROM '.$agent_cls->getTable('regions').' AS rg1 WHERE rg1.region_id = p.postal_state) AS postal_state_code,
						                 (SELECT rg2.name FROM '.$agent_cls->getTable('regions').' AS rg2 WHERE rg2.region_id = p.postal_country) AS postal_country_name
                                         FROM '.$partner_cls->getTable().' AS p
                                         WHERE p.agent_id = '.$_SESSION['new_agent']['id'].'', true);
    if ($partner_cls->hasError()) {
        $message = $partner_cls->getError();
    } else {
        $smarty->assign('partner_row',$partner_row);
    }


    $company_row = $company_cls->getRow('SELECT c.*,
                                         (SELECT rg1.code FROM '.$agent_cls->getTable('regions').' AS rg1 WHERE rg1.region_id = c.state) AS state_code,
						                 (SELECT rg2.name FROM '.$agent_cls->getTable('regions').' AS rg2 WHERE rg2.region_id = c.country) AS country_name
                                         FROM '.$company_cls->getTable().' AS c
                                         WHERE c.agent_id = '.$_SESSION['new_agent']['id'].'', true);
    if ($company_cls->hasError()) {
        $message = $company_cls->getError();
    } else {
        $smarty->assign('company_row',$company_row);
    }


    $agent_creditcard_row = $agent_creditcard_cls->getRow('agent_id='.$_SESSION['new_agent']['id']);
    if ($agent_creditcard_cls->hasError()) {
        $message = $agent_creditcard_cls->getError();
    } else {
        $smarty->assign('agent_creditcard_row',$agent_creditcard_row);
    }

    if (isset($message) and strlen($message)>0) {
        $smarty->assign('message',$message);
    }
}


//$smarty->assign('options_method',$options_method);
$smarty->assign('options_question',AO_getOptions('security_question'));
$smarty->assign('options_card_type',CT_getOptions());
?>