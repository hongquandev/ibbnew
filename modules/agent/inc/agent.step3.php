<?php
include_once ROOTPATH.'/modules/general/inc/report_email.php';
include_once ROOTPATH.'/includes/class.phpmailer.php';
include_once 'partner.php';
include_once 'company.php';
if (!isset($report_email_cls) or !($report_email_cls instanceof ReportEmail)) {
    $report_email_cls = new ReportEmail();
}

if (!isset($_SESSION['new_agent']) or  !isset($_SESSION['new_agent']['id'])) {
    redirect(ROOTURL.'?module='.$module.'&action='.$action);
}
$tandcrules = $config_cls->getKey('tandcrule');
$ibbrules = $config_cls->getKey('ibbrule');
$smarty->assign('tandcrules',$tandcrules);
$smarty->assign('ibbrules',$ibbrules);

$form_action = '?module='.$module.'&action='.$action.'&step='.$step;
$result = '';
if (@$_SERVER['REQUEST_METHOD'] == 'POST') {
    $agree =  isset($_POST['allow_next'])?1:0;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $agree == 1) {
        //SAVE AGENT INFORMATION:Nhung
        if (isset($_SESSION['new_agent']) and $_SESSION['new_agent']['id'] == 0){

            $agent_cls->insert($_SESSION['new_agent']['agent']);
            $id = $agent_cls->insertId();
            $_SESSION['new_agent']['id'] = $id;

            if (isset($_SESSION['new_agent']['lawyer'])){
                $_SESSION['new_agent']['lawyer']['agent_id'] = $id;
                $agent_lawyer_cls->insert($_SESSION['new_agent']['lawyer']);
                $_SESSION['new_agent']['lawyer']['agent_lawyer_id'] = $agent_lawyer_cls->insertId();
            }
            if (isset($_SESSION['new_agent']['contact'])){
                $_SESSION['new_agent']['contact']['agent_id'] = $id;
                $agent_contact_cls->insert($_SESSION['new_agent']['contact']);
                $_SESSION['new_agent']['contact']['agent_contact_id'] = $agent_contact_cls->insertId();
            }
            if (isset($_SESSION['new_agent']['partner'])){
                $_SESSION['new_agent']['partner']['agent_id'] = $id;
                $partner_cls->insert($_SESSION['new_agent']['partner']);
                $_SESSION['new_agent']['partner']['partner_id'] = $partner_cls->insertId();
            }
            if (isset($_SESSION['new_agent']['company'])){
                $_SESSION['new_agent']['company']['agent_id'] = $id;
                $company_cls->insert($_SESSION['new_agent']['company']);
                $_SESSION['new_agent']['company']['company_id'] = $company_cls->insertId();
            }

            //begin create folder
            $path = ROOTPATH.'/store/uploads/'.$_SESSION['new_agent']['id'];
            if ($_SESSION['new_agent']['id']>0 and !is_dir($path)) {
                @mkdir($path,0777);
                chmod($path,0777);
            }

            if (!is_dir($path)) {
                die('It can not create folder');
            }
            //end
            //StaticsReport('register_agent');
        }

        $_SESSION['new_agent']['step'] = $step + 1;
        redirect(ROOTURL.'?module='.$module.'&action='.$action.'&step='.($step + 1));
    }else if($_SERVER['REQUEST_METHOD'] == 'POST' && $agree == 0) {
        unset($_SESSION['new_agent']);
        redirect(ROOTURL.'?module='.$module.'&action='.$action);
    }
}
?>